<!doctype html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? h($title) : 'Reclutamientos' ?> · Reclutamientos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= u('/css/styles.css') ?>">
  <style>
    :root{ --bs-body-font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial; }
    .navbar-brand{font-weight:700}
    .hero-gradient{background: radial-gradient(1200px 600px at 20% 0%, #1a1a1f 0, #0b0b0c 60%);} 
    .rounded-4{border-radius:1rem!important}
  </style>
</head>
<body>
  <header class="border-bottom sticky-top bg-body">
    <nav class="navbar navbar-expand-lg container py-2">
      <a class="navbar-brand" href="<?= u('/') ?>">TalentHub</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="<?= u('/') ?>">Inicio</a></li>
        </ul>
        <div class="d-flex gap-2">
          <a href="<?= u('/admin') ?>" class="btn btn-outline-secondary">Admin</a>
          <a href="<?= u('/apply/step1') ?>" class="btn btn-primary">Aplicar ahora</a>
        </div>
      </div>
    </nav>
  </header>

  <main class="container py-4">
    <?= $content ?? '' ?>
  </main>

  <footer class="border-top py-4">
    <div class="container small text-secondary">
      © <?= isset($year) ? h((string)$year) : date('Y') ?> TalentHub · Hecho con Clean Architecture
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
