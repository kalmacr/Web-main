<?php
session_start();
if (!isset($_SESSION['id_usuario'])) header("Location: login.php");

include('conexion.php');

$id_usuario = $_SESSION['id_usuario'];
$msg = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, correo=?, contraseña=? WHERE id_usuario=?");
        $stmt->bind_param("sssi", $nombre, $correo, $password_hash, $id_usuario);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, correo=? WHERE id_usuario=?");
        $stmt->bind_param("ssi", $nombre, $correo, $id_usuario);
    }

    if ($stmt->execute()) {
        $msg = "Datos actualizados correctamente.";
    } else {
        $msg = "Error al actualizar: " . $stmt->error;
    }
}


// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT nombre, correo, contraseña FROM usuarios WHERE id_usuario=?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($nombre, $correo, $password);
$stmt->fetch();
$stmt->close();
?>

<?php include('includes/header.php'); ?>



<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card border-0 w-50 shadow p-4" >
    <h2 class="mt-4">Editar mis Datos</h2>
    <?php if ($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required value="<?php echo $nombre; ?>">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control form-control-sm" id="correo" name="correo" required value="<?php echo $correo; ?>" >
        </div> 
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Nueva contraseña (opcional)">
        </div> 
        <div class="d-flex justify-content-center">
           
            <button type="submit" name="ingresar" class="btn btn-primary btn-sm w-100">Guardar cambios</button>
        </div>
                
    </form>
   


    </div>
</div>
<?php include('includes/footer.php'); ?>