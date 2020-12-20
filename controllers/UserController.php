<?php

// traigo el modelo para un User
require_once 'models/User.php';

class userController
{

    public function index()
    {
        // traigo la vista
        require_once 'views/user/login.php';
    }

    public function register()
    {
        // traigo la vista
        require_once 'views/user/register.php';
    }

    public function login(){
        if($_POST['email'] && $_POST['password']){

            $email = $_POST['email'];
            $password = $_POST['password'];

            if($email && $password){

                $user = new User();

                $user->setEmail($email);
                $user->setPassword($password);

                $exists = $user->alreadyExist();
                if($exists == true){

                    $identity = $user->login();

                    if($identity && is_object($identity)){

                        $_SESSION['identity'] = $identity;
                        header("Location:".base_url."user/main");

                    }else{
                        $_SESSION['login'] = 'failed';
                        $_SESSION['cause'] = 'password incorrect';
                        header("Location:".base_url);
                    }

                }else{
                    $_SESSION['login'] = 'failed';
                    $_SESSION['cause'] = 'this email is not registered';
                    header("Location:".base_url);
                }


            }else{
                $_SESSION['login'] = 'failed';
                $_SESSION['cause'] = 'Complete fields';
                header("Location:".base_url);
            }

        }else{
            $_SESSION['login'] = 'failed';
            header("Location:".base_url);
        }
    }



    public function save(){
        // chequeo si llegan post
        if(isset($_POST['name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm'])){

            

            // hago validaciones y asigno valores a las variables
            if(strlen($_POST['name']) >= 1){
                $name = strip_tags($_POST['name']);
            }else{
                $_SESSION['register'] = 'failed';
                $_SESSION['cause'] = "Name is empty";               
            }

            if(strlen($_POST['last_name']) >= 1){
                $last_name = strip_tags($_POST['last_name']);
            }else{
                $_SESSION['register'] = 'failed';
                $_SESSION['cause'] = "Last name is empty";               
            }

            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $email = strip_tags($_POST['email']);
            }else{
                $_SESSION['register'] = 'failed';
                $_SESSION['cause'] = "Invalid Email";               
            }


            // para las password hago la encriptacion con hash
            $password = strip_tags($_POST['password']);
            $password_confirm = strip_tags($_POST['password_confirm']);



            // veo si todas las variables estan llenas
            if($name && $last_name && $email && $password && $password_confirm){
                
                // veo si coincide la contrasenia con la confirmacion de contrasenia
                if($password == $password_confirm){

                    // creo el objeto usuario y le asigno las propiedades
                    $user = new User();

                    $user->setName($name);
                    $user->setLast_name($last_name);
                    $user->setEmail($email);
                    $user->setPassword($password);

                    // ahora compruebo si ya existe un usuario con ese email
                    $exists = $user->alreadyExist();
                    if($exists == false){
                        // si no existe el usuario,  guardo el usuario en la db


                        // guardo en la db
                        $save = $user->save();


                    
                        if($save){
                            $_SESSION['register'] = 'complete';
                            
                        }else{
                            $_SESSION['register'] = 'failed';
                            $_SESSION['cause'] = "Registration failed, try again later";
                        }


                    }else{
                        $_SESSION['register'] = 'failed';
                        $_SESSION['cause'] = "This account already exists";
                    }



                }else{
                    $_SESSION['register'] = 'failed';
                    $_SESSION['cause'] = "The password and confirm password fields don't match";
                }


            }else{
                $_SESSION['register'] = 'failed';
                $_SESSION['cause'] = "You need to complete every field";
            }


        }else{
            $_SESSION['register'] = 'failed';
            $_SESSION['cause'] = "You need to complete every field";

        }

        header("Location:".base_url."user/register");
    }

    public function main(){

        require_once 'views/user/main.php';
    }

    public function logout()
    {
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }

        header('Location:' . base_url);

    }
}
