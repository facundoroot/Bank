<?php 

require_once'models/Card.php';
class cardController{

    public function register(){

        require_once'views/card/register.php';
    }

    public function save(){

        if(isset($_POST['card_number'])){

            if(filter_var($_POST['card_number'],FILTER_VALIDATE_INT) && strlen($_POST['card_number']) == 10){
                $card_number = strip_tags($_POST['card_number']);


                $user_id = $_SESSION['identity']->id;

                if($card_number && $user_id){

                    $card = new Card();
                    $card->setCard_number($card_number);
                    $card->setUser_id($user_id);
                    $card->setMoney_amount(0);

                    $save = $card->save();


                    if($save){
                        $_SESSION['register_card'] = 'complete';

                    }else{
                        $_SESSION['register_card'] = 'failed';
                        $_SESSION['cause'] = "registration failed";
                    }

                }else{
                        $_SESSION['register_card'] = 'failed';
                        $_SESSION['cause'] = "invalid number";
                    }


            }else{
                $_SESSION['register_card'] = 'failed';
                $_SESSION['cause'] = "Insert 10 digits";               
            }

            


        }else{
            $_SESSION['register_card'] = 'failed';
            $_SESSION['cause'] = "complete field";
        }

        header("Location:".base_url."card/register");
    }

    public function add_deposit(){

        require_once'views/card/deposit.php';

    }

    public function deposit(){

        if($_POST['amount']){

            if(filter_var($_POST['amount'],FILTER_VALIDATE_INT)){
                // agarro la cantidad que euiro depositar
                $amount = strip_tags($_POST['amount']);

                // ahora agarro la cantidad de dinero que tengo en la base de datos
                $card = new Card();
                $credit_card = $card->getbyIdentity();

                // ahora que tengo el objeto, agarro la columna donde esta el dinero de mi cuenta y la sumo con la
                // cantidad de dinero que quiero depositar

                // cantidad de dinero en mi cuenta
                $money_amount = $credit_card->money_amount;

                // hago la suma
                $sum = $amount + $money_amount;

                // actualizo el valor del deposito en la db
                $deposited = $card->deposit($sum);

                if($deposited){
                    $_SESSION['deposit'] = 'complete';
                }else{
                    $_SESSION['deposit'] = 'failed';
                    $_SESSION['cause'] = "deposit failed";  
                }




            }else{
                $_SESSION['deposit'] = 'failed';
                $_SESSION['cause'] = "Invalid amount";               
            }



        }else{
            $_SESSION['deposit'] = 'failed';
            $_SESSION['cause'] = "complete amount field";
        }

        header("Location:".base_url."card/add_deposit");
    }

    public function withdrawl_form(){

        require_once'views/card/withdrawl.php';

    }

    public function withdrawl(){

         if($_POST['amount']){

            if(filter_var($_POST['amount'],FILTER_VALIDATE_INT)){
                // agarro la cantidad que euiro depositar
                $amount = strip_tags($_POST['amount']);

                // ahora agarro la cantidad de dinero que tengo en la base de datos
                $card = new Card();
                $credit_card = $card->getbyIdentity();

                // ahora que tengo el objeto, agarro la columna donde esta el dinero de mi cuenta y la resto con la
                // cantidad de dinero que quiero depositar

                // cantidad de dinero en mi cuenta
                $money_amount = $credit_card->money_amount;

                if($amount < $money_amount){

                    // hago la suma
                    $sub = $money_amount - $amount;

                    // actualizo el valor del deposito en la db
                    // reutilizo la accion del modelo deposit por que es lo mismo sumar que restar dinero en la db
                    $withdrawl = $card->deposit($sub);

                    if($withdrawl){
                        $_SESSION['withdrawl'] = 'complete';
                    }else{
                        $_SESSION['withdrawl'] = 'failed';
                        $_SESSION['cause'] = "withdrawl failed";  
                    }

                }else{

                    $_SESSION['withdrawl'] = 'failed';
                    $_SESSION['cause'] = "you cant withdrawl more money that you have in your account";
                }






            }else{
                $_SESSION['withdrawl'] = 'failed';
                $_SESSION['cause'] = "Invalid amount";               
            }



        }else{
            $_SESSION['withdrawl'] = 'failed';
            $_SESSION['cause'] = "complete amount field";
        }

        header("Location:".base_url."card/withdrawl_form");

    }


}