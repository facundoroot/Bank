<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- font-awesome -->
    <!-- styles css -->
    <link rel="stylesheet" href="<?=base_url?>assets/css/styles.css" />
    <title>Bank</title>
  </head>
  <body>

            <!-- contact form -->
        <form action="<?=base_url?>user/login" class="contact-form" method="POST">
          <div><h3>Login</h3></div>

        <!-- voy a poner algun mensaje si fallo el login -->
        <?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'failed'):?>
          <div class="red"><h4>Login Failed: <?=$_SESSION['cause']?></h4></div>
        <?php endif;?>
        <?php Utils::deleteSession('login');?>
        <?php Utils::deleteSession('cause');?>


          <div>
              <input
                type="email"
                name="email"
                class="form-control"
                placeholder="e-mail"
              />
          </div>
          <div>
              <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
              />
          </div>
          <div>
              <button type="submit" class="btn-submit">submit</button>
          </div>
          <div>
            <p>Dont have an account yet? <a href="<?=base_url?>user/register">Register</a></p>
          </div>
        </form>
      </div>
    </section>
    <!-- end of contact -->
  </body>
</html>
