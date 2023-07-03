<!DOCTYPE html>
<html>
<head>
  <title>Exact Calories - Registro</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    .card-img-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
  <script>
    function validateForm() {
      var password = document.getElementById("password").value;
      var confirm_password = document.getElementById("confirm_password").value;

      if (password !== confirm_password) {
        alert("Las contraseñas no coinciden.");
        return false;
      }

      // Validate password requirements
      var passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
      if (!passwordRegex.test(password)) {
        alert("La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número.");
        return false;
      }

      return true;
    }
  </script>
</head>

<body>
  <div class="container my-3">
    <div class="d-flex justify-content-center">
      <div class="card border-0">
        <div class="row g-0">
          <div class="col-md-4 card-img-container">
            <img src="Logo.png" class="img-fluid rounded-start" alt="Logo">
          </div>
          <div class="col-md-8">
            <div class="card-body" style="background-color: transparent;">
              <div class="card-header">
                <h3 class="text-center">Registrate con nosotros</h3>
                <form method="POST" action="register_process.php" onsubmit="return validateForm()">
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
                  <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                  </div>
                  <p>La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número.</p>
                  <div class="d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
