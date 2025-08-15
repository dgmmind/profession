<section class="py-4 d-flex justify-content-center">
  <div class="w-100" style="max-width:420px;">
    <div class="bg-body-tertiary rounded-4 p-4">
      <h2 class="h4 mb-3">Acceso Administrador</h2>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert"><?= h($error) ?></div>
      <?php endif; ?>
      <form method="post" action="<?= u('/admin/login') ?>">
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input class="form-control" type="password" name="password" required>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary" type="submit">Entrar</button>
        </div>
      </form>
    </div>
  </div>
</section>
