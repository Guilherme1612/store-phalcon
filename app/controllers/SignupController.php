<?php
declare(strict_types=1);

class SignupController extends ControllerBase
{
    public function indexAction()
    {
        
    }

    public function registerUserAction()
    {
        $users = new Users;
        $users->name = $_POST['name'];
        $users->email = $_POST['email'];
        $users->password = md5($_POST['password']);


        foreach ($users->getAll() as $user) {
            if ($user['email'] == $users->email) {
                echo "<script>
                    alert('Esse e-mail já está sendo utilizado, tente utilizar outro.')
                    location.href = 'http://localhost/store/signup' 
                </script>";
                break;
            }
        } 

        if ($_POST['password'] != $_POST['confirm-password']) {
            echo "<script>
                alert('As senhas devem ser iguais, tente novamente.')
                location.href = 'http://localhost/store/signup' 
            </script>";
        } else {
            $users->registerUser();
            echo "<script>
                alert('Cadastro efetuado com sucesso, realize o login!')
                location.href = 'http://localhost/store/auth' 
            </script>";
        }
    }
}

