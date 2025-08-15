<div class="d-flex gap-2 align-items-center mb-3">
  <h2 class="h4 m-0">Detalle de candidato</h2>
  <div class="ms-auto d-flex gap-2">
    <a class="btn btn-outline-secondary" href="<?= u('/admin/candidates') ?>">Volver</a>
    <a class="btn btn-outline-secondary" href="<?= u('/admin/logout') ?>">Salir</a>
  </div>
</div>

<section class="bg-body-tertiary rounded-4 p-3 mb-3">
  <h3 class="h6 text-uppercase text-secondary">Información</h3>
  <div class="row g-2">
    <div class="col-md-6"><strong>Fecha:</strong> <?= h(formatDate($row['created_at'] ?? null)) ?></div>
    <div class="col-md-6"><strong>Vacante:</strong> <span class="badge text-bg-primary text-uppercase"><?= h((string)($row['vacancy'] ?? '')) ?></span></div>
    <div class="col-md-6"><strong>Nombre:</strong> <?= h((string)($row['nombre'] ?? '')) ?> <?= h((string)($row['apellidos'] ?? '')) ?></div>
    <div class="col-md-6"><strong>Identidad:</strong> <?= h((string)($row['identidad'] ?? '')) ?></div>
    <div class="col-md-6"><strong>Correo:</strong> <?= h((string)($row['correo'] ?? '')) ?></div>
    <div class="col-md-6"><strong>Teléfono:</strong> <?= h((string)($row['telefono'] ?? '')) ?></div>
    <div class="col-12"><strong>Titulación:</strong> <?= h((string)($row['titulacion'] ?? '')) ?></div>
    <div class="col-12"><strong>Empresas:</strong> <?= h((string)($row['empresas'] ?? '')) ?></div>
    <div class="col-12"><strong>Skills:</strong> <?= h((string)($row['skills'] ?? '')) ?></div>
    <div class="col-12"><strong>Motivación:</strong> <?= nl2br(h((string)($row['motivacion'] ?? ''))) ?></div>
  </div>
</section>

<section class="bg-body-tertiary rounded-4 p-3 mb-3">
  <h3 class="h6 text-uppercase text-secondary">Documentos</h3>
  <ul class="mb-0">
    <?php if (!empty($row['antecedentes_filename'])): ?>
      <li>Antecedentes: <a class="link-primary" href="<?= u('/uploads/' . ($row['antecedentes_filename'] ?? '')) ?>" target="_blank"><?= h((string)$row['antecedentes_filename']) ?></a></li>
    <?php endif; ?>
    <?php if (!empty($row['identidad_filename'])): ?>
      <li>Identidad: <a class="link-primary" href="<?= u('/uploads/' . ($row['identidad_filename'] ?? '')) ?>" target="_blank"><?= h((string)$row['identidad_filename']) ?></a></li>
    <?php endif; ?>
  </ul>
</section>

<section class="bg-body-tertiary rounded-4 p-3">
  <h3 class="h6 text-uppercase text-secondary">Referencias</h3>
  <?php foreach (($row['referencias'] ?? []) as $ref): ?>
    <div class="row g-2">
      <div class="col-md-4"><strong>Nombre:</strong> <?= h((string)($ref['nombre'] ?? '')) ?></div>
      <div class="col-md-4"><strong>Teléfono:</strong> <?= h((string)($ref['telefono'] ?? '')) ?></div>
      <div class="col-md-4"><strong>Correo:</strong> <?= h((string)($ref['correo'] ?? '')) ?></div>
    </div>
  <?php endforeach; ?>
</section>
