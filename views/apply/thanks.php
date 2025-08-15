<section class="py-5 text-center">
  <div class="container">
    <div class="mx-auto" style="max-width:520px;">
      <div class="p-4 bg-body-tertiary rounded-4">
        <h2 class="h4">¡Gracias por aplicar!</h2>
        <p class="text-secondary">Tu ID de aplicación:</p>
        <div class="display-6 fw-semibold mb-3"><?= h((string)($appId ?? '')) ?></div>
        <a class="btn btn-primary" href="<?= u('/') ?>">Volver al inicio</a>
      </div>
    </div>
  </div>
</section>
