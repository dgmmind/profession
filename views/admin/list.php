<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h4 m-0">Candidatos</h2>
  <a class="btn btn-outline-secondary" href="<?= u('/admin/logout') ?>">Salir</a>
</div>
<div class="table-responsive rounded-4 overflow-hidden">
  <table class="table table-dark table-striped table-hover align-middle m-0">
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Vacante</th>
        <th>Nombre</th>
        <th>Contacto</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach (($rows ?? []) as $r): ?>
        <tr>
          <td class="text-secondary"><?= h((string)$r['id']) ?></td>
          <td><?= h(formatDate($r['created_at'] ?? null)) ?></td>
          <td><span class="badge text-bg-primary text-uppercase"><?= h((string)($r['vacancy'] ?? '')) ?></span></td>
          <td><?= h((string)($r['nombre'] ?? '')) ?> <?= h((string)($r['apellidos'] ?? '')) ?></td>
          <td>
            <div class="small"><?= h((string)($r['correo'] ?? '')) ?></div>
            <div class="small text-secondary"><?= h((string)($r['telefono'] ?? '')) ?></div>
          </td>
          <td class="text-end">
            <a class="btn btn-sm btn-primary" href="<?= u('/admin/candidates/' . h((string)$r['id'])) ?>">Ver</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
