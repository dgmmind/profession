<?php include view_path('partials/progress.php'); ?>
<h2 class="h4 mb-3">Datos personales y CV</h2>
<form method="post" action="<?= u('/apply/step2') ?>" class="bg-body-tertiary border-0 rounded-4 p-3">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="nombre" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Apellidos</label>
      <input class="form-control" name="apellidos" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Identidad</label>
      <input class="form-control" name="identidad" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Teléfono</label>
      <input class="form-control" name="telefono" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Correo</label>
      <input class="form-control" type="email" name="correo" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Titulación</label>
      <input class="form-control" name="titulacion" placeholder="Ej. Ingeniería en Sistemas">
    </div>
    <div class="col-12">
      <label class="form-label">Empresas donde has trabajado</label>
      <textarea class="form-control" name="empresas" rows="3" placeholder="Lista separada por comas"></textarea>
    </div>
    <div class="col-12">
      <label class="form-label">Skills</label>
      <textarea class="form-control" name="skills" rows="3" placeholder="Ej. Office, Node.js, SQL"></textarea>
    </div>
    <div class="col-12 d-flex justify-content-between">
      <a class="btn btn-outline-secondary" href="<?= u('/apply/step1') ?>">Atrás</a>
      <button class="btn btn-primary" type="submit">Continuar</button>
    </div>
  </div>
</form>
