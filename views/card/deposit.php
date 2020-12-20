<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    

    <!-- styles css -->
    <link rel="stylesheet" href="<?=base_url?>assets/css/styles.css" />
    <title>Bank</title>
  </head>
  <body>

        <form action="<?=base_url?>card/deposit" class="contact-form" method="POST" >
          <div><h3>Deposite</h3></div>

          <!-- veo si se realizo o no el deposito y sus causas -->
          <?php if(isset($_SESSION['deposit']) && $_SESSION['deposit'] == 'complete'):?>
            <div class="green"><h4>Deposit completed!</h4></div>
          <?php elseif(isset($_SESSION['deposit']) && $_SESSION['deposit'] == 'failed'):?>
            <div class="red"><h4>Deposit failed!: <?=$_SESSION['cause']?></h4></div>
          <?php endif;?>
          <?php Utils::deleteSession('deposit');?>
          <?php if(isset($_SESSION['cause'])){
            Utils::deleteSession('cause');
          }?>

          <div>
              <input
                type="number"
                name="amount"
                class="form-control"
                placeholder="amount"
                required
              />
          </div>


          <div>
              <button type="submit" class="btn-submit">submit</button>
          </div>
          <div>
            <p><a href="<?=base_url?>user/main">Go back</a></p>
          </div>
        </form>
      </div>
    </section>

  </body>
</html>