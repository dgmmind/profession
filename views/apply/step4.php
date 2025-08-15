<?php include view_path('partials/progress.php'); ?>
<h2 class="h4 mb-1">Sube tus documentos</h2>
<p class="text-secondary mb-3">Aceptamos imágenes o PDF. Máximo 10MB por archivo.</p>
<form method="post" action="<?= u('/apply/step4') ?>" enctype="multipart/form-data" class="bg-body-tertiary border-0 rounded-4 p-3">
  <div class="mb-3">
    <label class="form-label">Antecedentes personales</label>
    <input class="form-control" type="file" name="antecedentes" accept="image/*,application/pdf" required>
    <div class="form-text">Sube una imagen o PDF.</div>
  </div>
  <div class="mb-3">
    <label class="form-label">Copia de identidad</label>
    <input class="form-control" type="file" name="identidad_doc" accept="image/*,application/pdf" required>
  </div>
  <div class="d-flex justify-content-between">
    <a class="btn btn-outline-secondary" href="<?= u('/apply/step3') ?>">Atrás</a>
    <button class="btn btn-primary" type="submit">Continuar</button>
  </div>
</form>
