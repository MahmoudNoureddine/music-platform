<?php
// Start a session
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login and Registration Form</title>
      <link rel="stylesheet" href="css/styles.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
      <div class="wrapper">
         <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
         </div>
         <div class="form-inner">
   <!-- Login Form -->
   <form action="../app/controllers/AuthController.php" method="POST" class="login">
      <div class="field">
         <input type="text" name="email" placeholder="Email Address" required>
      </div>
      <div class="field">
         <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="field btn">
         <div class="btn-layer"></div>
         <input type="submit" name="login" value="Login">
      </div>
   </form>

   <!-- Signup Form -->
   <form action="../app/controllers/AuthController.php" method="POST" class="signup">
      <div class="field">
         <input type="text" name="email" placeholder="Email Address" required>
      </div>
      <div class="field">
         <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="field">
         <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      </div>
      <div class="field btn">
         <div class="btn-layer"></div>
         <input type="submit" name="signup" value="Signup">
      </div>
   </form>
</div>

         </div>
      </div>
      <script>
         // JavaScript for toggling between Login and Signup
         const loginForm = document.querySelector("form.login");
         const signupForm = document.querySelector("form.signup");
         const loginBtn = document.querySelector("label.login");
         const signupBtn = document.querySelector("label.signup");

         // Toggle to signup form
         signupBtn.onclick = () => {
            loginForm.style.marginLeft = "-50%";
            signupForm.style.marginLeft = "-50%";
         };

         // Toggle to login form
         loginBtn.onclick = () => {
            loginForm.style.marginLeft = "0%";
            signupForm.style.marginLeft = "0%";
         };
      </script>
   </body>
</html>
