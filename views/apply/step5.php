<?php include view_path('partials/progress.php'); ?>
<h2 class="h4 mb-3">Referencias</h2>
<form method="post" action="<?= u('/apply/submit') ?>" class="bg-body-tertiary border-0 rounded-4 p-3">
  <div class="row g-3">
    <div class="col-12"><h3 class="h6 text-uppercase text-secondary">Referencia 1</h3></div>
    <div class="col-md-4">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="ref1_nombre" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Teléfono</label>
      <input class="form-control" name="ref1_telefono" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Correo</label>
      <input class="form-control" type="email" name="ref1_correo" required>
    </div>

    <div class="col-12 pt-2"><h3 class="h6 text-uppercase text-secondary">Referencia 2</h3></div>
    <div class="col-md-4">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="ref2_nombre" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Teléfono</label>
      <input class="form-control" name="ref2_telefono" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Correo</label>
      <input class="form-control" type="email" name="ref2_correo" required>
    </div>

    <div class="col-12 d-flex justify-content-between pt-2">
      <a class="btn btn-outline-secondary" href="<?= u('/apply/step4') ?>">Atrás</a>
      <button class="btn btn-primary" type="submit">Enviar aplicación</button>
    </div>
  </div>
</form>
