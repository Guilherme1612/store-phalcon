<?php
declare(strict_types=1);

class AuthController extends ControllerBase
{
    public function indexAction()
    {
        
    }

    public function loginAction()
    {
        $users = new Users;
        $users->email = $_POST['email']; 
        $users->password = md5($_POST['password']); 

        if ($users->authenticate()) {
            session_start();
            $_SESSION['id'] = $users->id;
            $_SESSION['name'] = $users->name;
            $_SESSION['email'] = $users->email;
            $_SESSION['password'] = $users->password;

            echo "<script>
                location.href = 'http://localhost/store/' 
            </script>";
        } else {
            echo "<script>
                alert('E-mail ou senha inválidos.')
                location.href = 'http://localhost/store/auth' 
            </script>";
        }
    }

    public function signOutAction()
    {
        session_start();
        session_destroy();
        header('Location: /store');
    }
}

