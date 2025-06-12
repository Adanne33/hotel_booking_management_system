<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['login'])){

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        if($username == 'kghotel' && $password == 'kghotel123'){
            session_regenerate_id(true);

            $_SESSION['is_logged_in'] = true;

            header("Location: http://localhost:200/index_records.php");
            exit;
        }else{
            $error = "Your Login credential is incorrect";
        }


    }
}





?>






<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f0f2f5;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h3 class="text-center mb-4 text-primary">User Login</h3>

    <?php if (!empty($error)): ?>
        <p class="text-center text-danger"><?= $error ?> </p>
       <?php endif; ?>

    <form action="login.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
      </div>
      <div class="d-grid gap-2">
        <button type="submit" name="login" class="btn btn-primary">Login</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
