<!DOCTYPE html>
<html>
<head>
  <title>Página de Registro</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Registrate con nosotros</h1>
    <form method="POST" action="register_process.php">
  <div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="form-group">
    <label for="apellido_m">Apellido Materno</label>
    <input type="text" class="form-control" id="apellido_m" name="apellido_m" required>
  </div>
  <div class="form-group">
    <label for="apellido_p">Apellido Paterno</label>
    <input type="text" class="form-control" id="apellido_p" name="apellido_p" required>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
  </div>
</body>
</html>
