<section class="py-5 text-center">
  <div class="container">
    <div class="mx-auto" style="max-width:560px;">
      <div class="p-4 bg-body-tertiary rounded-4">
        <h2 class="h4"><?= h((string)($title ?? 'Error')) ?></h2>
        <p class="text-secondary"><?= h((string)($message ?? '')) ?></p>
        <a class="btn btn-primary" href="<?= u('/') ?>">Volver al inicio</a>
      </div>
    </div>
  </div>
</section>
