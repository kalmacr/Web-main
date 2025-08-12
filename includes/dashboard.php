<?php
session_start();
if (!isset($_SESSION['id_usuario'])) header('Location: ../login.php');

include('../conexion.php');

$titulo = 'Dashboard';
include('header.php');

$id = $_SESSION['id_usuario'];
$res = $conn->query("SELECT nombre, puntos FROM usuarios WHERE id_usuario=$id");
$user = $res->fetch_assoc();
?>

<div class="container mt-4">
  <h1>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></h1>
  <p>Tienes <strong><?php echo $user['puntos']; ?></strong> puntos acumulados.</p>
  <div class="row">
    <div class="col-md-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Registrar Material</h5>
          <a href="../registrar_materiales.php" class="btn btn-primary">Registrar</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Canjear Recompensas</h5>
          <a href="../canjear.php" class="btn btn-success">Canjear</a>
 
        
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Ver Historial</h5>
          <a href="../recompensa.php" class="btn btn-info">Historial</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('footer.php'); ?>
