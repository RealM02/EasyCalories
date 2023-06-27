<!DOCTYPE html>
<html>
<head>
  <title>Easy Calories</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Inserta Logo</h1>
    <form method="POST" action="authenticate.php">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
      <p>
        ¿No tienes cuenta? Crea una, 
        <a href="register.php">aquí</a>.
      </p>

  </div>
</body>
</html>