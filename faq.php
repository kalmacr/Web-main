<?php
session_start();
if (!isset($_SESSION['id_usuario'])) header('Location: login.php');
include('conexion.php');
$titulo = 'Preguntas Frecuentes';
include('includes/header.php');

$res = $conn->query("SELECT pregunta, respuesta FROM faq");
?>
<div class="container mt-4">
  <h2>Preguntas Frecuentes</h2>
  <div class="accordion" id="faqAccordion">
    <?php $i=0; while($row=$res->fetch_assoc()): $i++; ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading<?php echo $i; ?>">
        <button class="accordion-button <?php echo $i>1?'collapsed':''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>">
          <?php echo htmlspecialchars($row['pregunta']); ?>
        </button>
      </h2>
      <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $i===1?'show':''; ?>" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          <?php echo nl2br(htmlspecialchars($row['respuesta'])); ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
<?php include('includes/footer.php'); ?>
