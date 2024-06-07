<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE HTML>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Register</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href=".\css\Register.css"/>
    </head>
<body>
  <section class="bg-light py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <div class="card border border-light-subtle rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="text-center mb-3">
                <img src="/FableFlow/resources/logos/FableFlowLogo.png" alt="FableFlow" width="300" height=auto>
              </div>
              <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign up your account</h2>
              <form id="register"action="/FableFlow/src/server/api/PostRegister.php" method="post">
                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                  	<div class="form-floating mb-3">
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                      <label for="username" class="form-label">Username</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                      <label for="email" class="form-label">Email</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                      <label for="password" class="form-label">Password</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="passwordconfirm" id="passwordconfirm" placeholder="Confirm Password" required>
                      <label for="passwordconfirm" class="form-label">Confirm Password</label>
                    </div>
                    <div id="error-message" class="text-danger" style="display: none;">
                      Passwords don't match
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" id="signup" type="submit">Sign up</button>
                    </div>
                  </div>
                  <div class="col-12">
                    <p class="m-0 text-secondary text-center">Do you have an account already? <a href="/FableFlow/src/client/Login.php" class="text-decoration-none">Sign in</a></p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Lib JQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    document.getElementById('register').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('passwordconfirm').value;
        
        if (password !== confirmPassword) {
            document.getElementById('error-message').style.display = 'block';
            event.preventDefault();
        } else {
            document.getElementById('error-message').style.display = 'none';
        }
    });
</script>
</body>
</html>