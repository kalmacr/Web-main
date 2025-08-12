<?php 
include("conexion.php"); 
session_start(); 
include('includes/header.php'); 

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener recompensas canjeadas por el usuario
$sql = "SELECT r.nombre, r.descripcion, r.puntos_asignados, c.fecha
        FROM canjes c
        JOIN recompensa r ON c.id_recompensa = r.id_recompensa
        WHERE c.id_usuario = $id_usuario
        ORDER BY c.fecha DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis Recompensas</title>
    <meta charset="UTF-8">
    
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Recompensas Canjeadas</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Puntos</th>
                    <th>Fecha de Canje</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo $fila['puntos_asignados']; ?></td>
                        <td><?php echo $fila['fecha']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Aún no has canjeado ninguna recompensa.</div>
    <?php endif; ?>
</div>

</body>
<?php include('includes/footer.php'); ?>
</html>
