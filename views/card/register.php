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

        <form action="<?=base_url?>card/save" class="contact-form" method="POST" >
          <div><h3>Register credit card</h3></div>

          <?php if(isset($_SESSION['register_card']) && $_SESSION['register_card'] == 'complete'):?>
            <div class="green"><h4>Card registration complete</h4></div>
          <?php elseif(isset($_SESSION['register_card']) && $_SESSION['register_card'] == 'failed'):?>
            <div class="red"><h4>Card registration failed: <?=$_SESSION['cause']?></h4></div>
          <?php endif;?>
          <?php Utils::deleteSession('register_card');?>
          <?php if(isset($_SESSION['cause'])){
            Utils::deleteSession('cause');
          }?>
            
          <div>
              <input
                type="number"
                name="card_number"
                class="form-control"
                placeholder="Card number"
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