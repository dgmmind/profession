<?php
declare(strict_types=1);

namespace App\Controllers;

class HomeController {
  public function index(): void {
    render('home.php', [
      'title' => 'Reclutamientos',
      'year' => date('Y'),
    ]);
  }
}
