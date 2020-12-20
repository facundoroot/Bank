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

        <form action="<?=base_url?>transfer/save" class="contact-form" method="POST" >
          <div><h3>Transference</h3></div>

          <!-- veo si se realizo o no el deposito y sus causas -->
          <?php if(isset($_SESSION['transfer']) && $_SESSION['transfer'] == 'complete'):?>
            <div class="green"><h4>transfer completed!</h4></div>
          <?php elseif(isset($_SESSION['transfer']) && $_SESSION['transfer'] == 'failed'):?>
            <div class="red"><h4>transfer failed!: <?=$_SESSION['cause']?></h4></div>
          <?php endif;?>
          <?php Utils::deleteSession('transfer');?>
          <?php if(isset($_SESSION['cause'])){
            Utils::deleteSession('cause');
          }?>
            
          <div>
              <input
                type="number"
                name="amount"
                class="form-control"
                placeholder="Transfer Amount"
                required
              />
          </div>


          <div>
              <input
                type="email"
                name="email_to_transfer"
                class="form-control"
                placeholder="email to transfer"
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