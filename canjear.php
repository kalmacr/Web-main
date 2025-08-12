<?php include("conexion.php"); session_start(); 
if (!isset($_SESSION['id_usuario'])) header('Location: login.php');?>
<!DOCTYPE html>
<html>
    <?php include('includes/header.php');?>
<head><title>Canje de Recompensas</title></head>
<body>
    
<h2 class="m-4">Canjear Recompensas</h2>
<table class="table m-4">
<tr><th>Nombre</th><th>Descripción</th><th>Puntos</th><th>Acción</th></tr>
<?php
$id_usuario = $_SESSION['id_usuario'];
$res = $conn->query("SELECT puntos FROM usuarios WHERE id_usuario=$id_usuario");
$puntos_usuario = $res->fetch_assoc()['puntos'];

$recompensas = $conn->query("SELECT * FROM recompensa");
while ($r = $recompensas->fetch_assoc()) {
    $disabled = $puntos_usuario >= $r['puntos_asignados'] ? "" : "disabled";
    echo "<tr>
        <td>{$r['nombre']}</td>
        <td>{$r['descripcion']}</td>
        <td>{$r['puntos_asignados']}</td>
        <td>
            <form method='POST'>
                <input type='hidden' name='recompensa_id' value='{$r['id_recompensa']}'>
                <input type='submit' name='canjear' value='Canjear' $disabled>
            </form>
        </td>
    </tr>";
}
?>
</table>

<?php
if (isset($_POST['canjear'])) {
    $recompensa_id = $_POST['recompensa_id'];
    $conn->query("INSERT INTO canjes (id_usuario, id_recompensa, fecha) VALUES ($id_usuario, $recompensa_id, NOW())");
    $conn->query("UPDATE usuarios SET puntos = puntos - (SELECT puntos_asignados FROM recompensa WHERE id_recompensa = $recompensa_id) WHERE id_usuario = $id_usuario");
    echo "<p>¡Canje exitoso!</p>";
}
include('includes/footer.php');
?>
</body>
</html>
