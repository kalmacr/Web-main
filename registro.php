<?php include("conexion.php"); 
 include('includes/header.php');

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, puntos, tipo_usuario)
            VALUES ('$nombre', '$correo', '$clave', 0, 'normal')";
    if ($conn->query($sql)) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card border-0 w-50 shadow p-4" >
    <h2>Registro de Usuario</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div> 
            <div class="d-flex justify-content-center">
                <button type="submit" name="registrar" class="btn btn-success w-100">Registrarse</button>
            </div>
        </form>
    </div>
</div>
<?php include('includes/footer.php');?>
</body>
</html>
