<?php  session_start(); 
if (!isset($_SESSION['id_usuario'])) header('Location: login.php');
include("conexion.php");
?>

<?php include('includes/header.php');?> 
<div class="container text-center">
  <!-- Content here -->

    <h2 class="cointainer pt-5 m-4 text-center">Registrar Material Reciclado</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="tipo_material:" class="form-label">Tipo de material:</label>

            <select class="form-select" name="material_id" aria-label="Default select example"  required>
                <option selected>Tipo de material:</option>
            
            <?php
            $materiales = $conn->query("SELECT id_material, nombre FROM materiales");
            while ($row = $materiales->fetch_assoc()) {
                echo "<option value='{$row['id_material']}'>{$row['nombre']}</option>";
            }
            ?>
            </select>
        </div>
        <div class="mb-3">
            
             
            <label for="cantidad" class="form-label">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" aria-describedby="cantidad" min="0" step="1" required>
            <button type="submit" class="btn btn-primary" name="registrar" >Registrar</button>
            
        </div>    
    </form>
</div>




<?php


if (isset($_POST['registrar'])) {
    $usuario_id = $_SESSION['id_usuario'];
    $material_id = $_POST['material_id'];
    $cantidad = $_POST['cantidad'];

    // Insertar registro
    

    $conn->query("INSERT INTO registro_materiales (usuario_id, material_id, cantidad,  fecha) 
                  VALUES ($usuario_id, $material_id, $cantidad, NOW())");


    // Obtener puntos del material
    $res = $conn->query("SELECT puntos_asignados FROM materiales WHERE id_material = $material_id");
    $puntos = $res->fetch_assoc()['puntos_asignados'];
    $total_puntos = $puntos * $cantidad;

    // Sumar puntos al usuario
    $conn->query("UPDATE usuarios SET puntos = puntos + $total_puntos WHERE id_usuario = $usuario_id");

    echo "Registro exitoso. ¡Ganaste $total_puntos puntos!";
}
include('includes/footer.php');
?>

