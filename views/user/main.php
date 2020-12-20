<?php require_once'models/Card.php';?>
<?php require_once'models/Transfer.php';?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />
    <!-- font-awesome -->
    <!-- styles css -->
    <link rel="stylesheet" href="<?=base_url?>assets/css/styles.css" />
    <title>Bank</title>
  </head>
  <body>


    <!-- veo si inicio sesion -->
    <?php Utils::isLogged();?>
    <br>
    <br>
    <br>
    <h1>Welcome</h1>

    <h3><?=$_SESSION['identity']->name?> <?=$_SESSION['identity']->last_name?></h3>

    <!-- muestro cantidad de dinero, aca no respeto bien el mvc pero me parecio la mejor manera -->

    <!-- creo el objeto card en general por que lo uso en diferentes ocasiones en esta view -->
        <!-- veo primero si ya esta registrada la tarjeta -->
    <?php $card = new Card();?>
    <?php $exists = $card->alreadyexistsbyIdentity()?>
    <?php if($exists):?>

      <!-- si ya esta registrada, veo el dinero que tiene -->
        <?php $credit_card =$card->getbyIdentity();?>
        <div><h3>Money funds: $<?=$credit_card->money_amount;?></h3></div>

      <!-- ahora voy a ver si alguien hizo una transferencia a mi cuenta y si la hizo la sumo a los fondos de mi cuenta -->

      <?php $transfer = new Transfer();
            $transferences = $transfer->getAll();
            // aca recibo un objeto que contiene la columna de transferencia que se le hizo a este usuario
            if($transferences){

              // uso un while para mostrar cada transferencia, luego una vez mostradas se borran automaticamente de la db asi no ocupan espacio y no se meustra constantemente en la pantalla
              while ($transference = $transferences->fetch_object()){
              $_SESSION['transfered_complete'] = 'complete';

              // asigno valores para luego sumarlos y usarlos para identificar
              $transferer_id = $transference->transferer_id;
              $money_transfered = $transference->amount;
              $transference_id = $transference->id;

              

                

                $transfer->setTransferer_id($transferer_id);
                // agarro el objeto que contiene la columna del usuario que me hizo la transferencia
                $transferer = $transfer->getTransfererFromId();


                // doy valores para luego imprimirlos usando el objeto
                $transfer_name = $transferer->name;
                $transfer_last_name = $transferer->last_name;

                echo '<div class = "green"><h4>'.$transfer_name.' '.$transfer_last_name.' transfered you: $'.$money_transfered.'</h4></div>';
                
                // ahora que se imprime la transferencia la borro de la db asi no ocupa espacio y desaparece de la pantalla cuando refresquemos
                $delete = $transfer->deleteTransferenceById($transference_id);

              }


            }?>


    <?php endif;?>





    
    <div class="btn-container centering">
        <!-- ahora si no esta registrada todavia, aparece el boton para registrars -->
        <?php $exists = $card->alreadyexistsbyIdentity()?>
        <?php if($exists == false):?>
          <div class="btn-main"><a href="<?=base_url?>card/register" class="btn">Register card</a></div>
        <?php endif;?>

        <?php if($exists):?>
            <div class="btn-main"><a href="<?=base_url?>transfer/transference_form" class="btn">Tranfer</a></div>
            <div class="btn-main"><a href="<?=base_url?>card/add_deposit" class="btn">Add deposit</a></div>
        <?php endif; ?>



        <!-- si la cantidad de dinero es 0 no veo la accion de sacar dinero -->
        <?php if(isset($credit_card) && $credit_card->money_amount >0):?>
          <div class="btn-main"><a href="<?=base_url?>card/withdrawl_form" class="btn">Withdrawl</a></div>
        <?php endif;?>
    </div>

    <div class="centering-solo">
      <div class="btn-solo"><a href="<?=base_url?>user/logout" class="btn">Close Session</a></div>
    </div>

  </body>
</html>


