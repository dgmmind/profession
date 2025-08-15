<?php include view_path('partials/progress.php'); ?>
<div class="mb-3">
  <h2 class="h4 mb-1">Selecciona una vacante</h2>
  <p class="text-secondary">Elige la posición que más se ajuste a tu perfil. Ejemplos y salarios de Honduras.</p>
</div>
<form method="post" action="<?= u('/apply/step1') ?>" class="card bg-body-tertiary border-0 rounded-4 p-3">
  <div class="list-group list-group-flush">
    <?php foreach (($vacancies ?? []) as $v): ?>
      <label class="list-group-item d-flex gap-3 align-items-start bg-transparent">
        <input class="form-check-input mt-1" type="radio" name="vacancy" value="<?= h($v['id']) ?>" required>
        <div>
          <div class="fw-semibold"><?= h($v['title']) ?></div>
          <div class="text-secondary small"><?= h($v['salario']) ?></div>
          <div class="text-secondary small">Ejemplo: <?= h($v['ejemplo']) ?></div>
        </div>
      </label>
    <?php endforeach; ?>
  </div>
  <div class="d-flex justify-content-end gap-2 mt-3">
    <button class="btn btn-primary" type="submit">Continuar</button>
  </div>
</form>
