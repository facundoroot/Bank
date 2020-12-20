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

        <form action="<?=base_url?>user/save" class="contact-form" method="POST" enctype="multipart/form-data">
          <div><h3>Register</h3></div>

            <!-- veo si se hizo el registro correctamente o no -->
            <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete') :?>
                <div class="green"><h4>Registration complete!</h4></div>
            <?php elseif(isset($_SESSION['register']) && isset($_SESSION['cause']) && $_SESSION['register'] == 'failed') :?>
                <div class="red"><h4><?= $_SESSION['cause'] ?></h4></div>
            <?php endif; ?>
            <?php Utils::deleteSession('register');?>
            <?php if(isset($_SESSION['cause'])){
                 Utils::deleteSession('cause');
            }?>


          <div>
              <input
                type="text"
                name="name"
                class="form-control"
                placeholder="Name"
                required
              />
          </div>

          <div>
              <input
                type="text"
                name="last_name"
                class="form-control"
                placeholder="Last Name"
                required
              />
          </div>

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
                required
              />
          </div>

          <div>
              <input
                type="password"
                name="password_confirm"
                class="form-control"
                placeholder="Confirm Password"
                required
              />
          </div>

          <div>
              <button type="submit" class="btn-submit">submit</button>
          </div>
          <div>
            <p>You already have an account? <a href="<?=base_url?>">Login</a></p>
          </div>
        </form>
      </div>
    </section>

  </body>
</html>
