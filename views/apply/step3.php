<?php include view_path('partials/progress.php'); ?>
<h2 class="h4 mb-3">¿Por qué deberíamos contratarte?</h2>
<form method="post" action="<?= u('/apply/step3') ?>" class="bg-body-tertiary border-0 rounded-4 p-3">
  <div class="mb-3">
    <label class="form-label">Tu motivación</label>
    <textarea class="form-control" name="motivacion" rows="6" required placeholder="Cuéntanos tus fortalezas y logros..."></textarea>
    <div class="form-text">Sé específico: impacto, herramientas, métricas.</div>
  </div>
  <div class="d-flex justify-content-between">
    <a class="btn btn-outline-secondary" href="<?= u('/apply/step2') ?>">Atrás</a>
    <button class="btn btn-primary" type="submit">Continuar</button>
  </div>
</form>
