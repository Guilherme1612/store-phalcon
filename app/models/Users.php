<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Users extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            $this->email,
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("store");
        $this->setSource("users");
    }

    public function getAll()
    {
        $connection = $this->container->get('db');
        $stmt = $connection->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function registerUser()
    {
        $connection = $this->container->get('db');
        $connection->insert(
            "users",
            [$this->name, $this->email, $this->password],
            ["name", "email", "password"]
        );
    }

    public function authenticate()
    {
        $connection = $this->container->get('db');

        $stmt = $connection->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":password", $this->password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($user['id'])) {
            $this->id = $user['id'];
            $this->email = $user['email'];
            $this->name = $user['name'];
            $this->password = $user['password'];

            return true;
        }
    }

}
