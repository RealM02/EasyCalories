<!DOCTYPE html>
<html>
<head>
  <title>Easy Calories</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="card border-0">
      <img src="Logo.png" class="card-img-top mx-auto d-block mb-0" alt="Logo" style="width: 18rem;">
      <div class="card-body">
      <h3 class="text-center">Iniciar Sesión</h3>
        <form method="POST" action="authenticate.php">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <p class="text-right">
            ¿No tienes cuenta? Crea una,
            <a href="register.php">aquí</a>.
          </p>
          <p class="text-right">
            ¿Olvidaste tu contraseña? Cambia tu contraseña
            <a href="#" data-toggle="modal" data-target="#passwordModal">aquí</a>.
          </p>
        </form>
      </div>
    </div>
  </div>

  <!-- Password change modal -->
  <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="passwordModalLabel">Cambiar contraseña</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="passwordChangeForm" method="POST" action="change_password.php">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="newPassword">Nueva Contraseña</label>
              <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>