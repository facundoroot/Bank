<?php
require_once 'models/Transfer.php';
class transferController{

    public function transference_form(){

        require_once'views/transfer/transference.php';

    }

    public function save(){

        if($_POST['amount'] && $_POST['email_to_transfer']){

            // voy a chequear que la cantidad que quiero transferir sea menor o igual a la de la cuenta
            $transfer = new Transfer();
            $credit_card = $transfer->fundsbyId();
            $money_funds = $credit_card->money_amount;

            // ahora ya tengo los fondos de mi cuenta asi que comparo con la cantidad que quiero transferir a ver si es posible


            if($money_funds >= $_POST['amount']){

                if(filter_var($_POST['amount'],FILTER_VALIDATE_INT)){
                    $amount = strip_tags($_POST['amount']);
                }else{
                    $_SESSION['transfer'] = 'failed';
                    $_SESSION['cause'] = "Invalid amount";               
                }
            }else{
                $_SESSION['transfer'] = 'failed';
                $_SESSION['cause'] = "you are trying to transfer more money than you have in your acount";                 
            }


            // ahora para el email compruebo tambien que al email que quiero transferir sea un usuario registrado
            $transfer = new Transfer();
            $exists = $transfer->userexistbyEmail($_POST['email_to_transfer']);

            if($exists){

                $email_to_transfer = $_POST['email_to_transfer'];

            }else{
                $_SESSION['transfer'] = 'failed';
                $_SESSION['cause'] = "the email you are trying to transfer money is not registered on our website";  
            }


            // ahora veo si la validacion del email y del amount se hicieron correctamente, sino lo muestro en la pantalla
            if($amount){

                if($email_to_transfer){
                    // ya me fije si la validacion de las variables se hizo bien asi que ahora sigo avanzando

                    // antes de guardar la transferencia en la db primero voy a restarle la cantidad de dinero que transfiero
                    // a los fondos de mi cuenta
                    $sub = $money_funds - $amount;
                    $transfer = new Transfer();
                    $sub_funds = $transfer->deposit($sub);

                    // ahora que ya reste a mi cuenta voy a sumarle los fondos a la cuenta del usuario que mande, asi cuando la persona abre su sesion ya directamente
                    // le aparece la cantidad total de su cuenta con la transferencia que le hicieron ya sumada
                    if($sub_funds){

                        $transfer->setTransfered_to($email_to_transfer);

                        $user_to_transfer = $transfer->getTransferedUser();

                        $user_to_transfer_id = $user_to_transfer->id;


                        // con lo que hice hasta recien pude sacar el email de la persona a la que quiero transferir, ahora con ese id puedo modificar la tabla de la cuenta de esta persona
                        // ahora si modifico la tabla del deposito de la eprsona que voy a mandarle la transferencia asi queda su dinero de su cuenta mas la transferencia que le mande

                        $transfered_credit_card = $transfer->getTransferedCreditCard($user_to_transfer_id);

                        $transfered_money_amount = $transfered_credit_card->money_amount;

                        $sum = $transfered_money_amount + $amount;
                        // listo, ya realize la suma de el dinero que tiene en su cuenta la eprsona que quiero transferirle 
                        //  mas el dinero que le quiero transferir

                        // ahora le hago un update en la cuenta del cliente con su nueva cantidad de dienro
                        $update_transfered_db = $transfer->update_transfered_db($sum,$user_to_transfer_id);
                        if($update_transfered_db){
                            // ahora me concentro en guardar la transferencia en la db en la tabla transferer que de ahi la persona va a sacar la info de quien y cuanto le transfirieron
                            if($sub_funds){


                                $id = $_SESSION['identity']->id;

                                $transfer = new Transfer();

                                $transfer->setTransferer_id($id);
                                $transfer->setTransfered_to($email_to_transfer);
                                $transfer->setAmount($amount);

                                // guardo en la db
                                $save = $transfer->save();

                                if($save){

                                    $_SESSION['transfer'] = 'complete';
                                    
                                }else{
                                    $_SESSION['transfer'] = 'failed';
                                    $_SESSION['cause'] = 'transference failed';
                                } 

                            }
                            
                        }else{
                                $_SESSION['transfer'] = 'failed';
                                $_SESSION['cause'] = 'transference failed';
                            
                        }



                    }

                    


                }else{
                    $_SESSION['transfer'] = 'failed';
                    $_SESSION['cause'] = "the email you are trying to transfer money is not registered on our website";  
                }   


            }else{
                $_SESSION['transfer'] = 'failed';
                $_SESSION['cause'] = "you are trying to transfer more money than you have in your acount";                 
            }


        }else{
            $_SESSION['transfer'] = 'failed';
            $_SESSION['cause'] = 'complete both fields';
        }

        header("Location:".base_url."transfer/transference_form");
    }

    public function deleteOne(){
        if($_GET['id']){

            $id = isset($_GET['id']) ? $_GET['id'] : null;

            $transfer = new Transfer();
            $delete = $transfer->deleteTransferenceById($id);

            header("Location:".base_url."user/main");

        }
    }
}