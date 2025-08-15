<?php
declare(strict_types=1);

namespace App\Controllers;

class AdminController {
  public function login(): void {
    if (!empty($_SESSION['admin'])) { redirect('/admin/candidates'); return; }
    render('admin/login.php', ['title' => 'Admin', 'year' => date('Y')]);
  }
  public function postLogin(): void {
    $password = $_POST['password'] ?? '';
    $ADMIN_PASSWORD = $_ENV['ADMIN_PASSWORD'] ?? 'admin1234';
    if ($password === $ADMIN_PASSWORD) {
      $_SESSION['admin'] = ['logged' => true];
      redirect('/admin/candidates');
      return;
    }
    render('admin/login.php', ['title' => 'Admin', 'year' => date('Y'), 'error' => 'Contraseña incorrecta']);
  }
  public function logout(): void {
    $_SESSION['admin'] = null; redirect('/admin');
  }
  public function candidates(): void {
    require_admin();
    $url = $_ENV['SUPABASE_URL'] ?? '';
    $key = $_ENV['SUPABASE_KEY'] ?? '';
    [$ok, $rows] = supabase_select('applications', 'id,created_at,vacancy,nombre,apellidos,correo,telefono', $url, $key, ['order' => 'created_at.desc']);
    if (!$ok) { $rows = []; }
    render('admin/list.php', ['title' => 'Admin', 'year' => date('Y'), 'rows' => $rows]);
  }
  public function detail(string $id): void {
    require_admin();
    $url = $_ENV['SUPABASE_URL'] ?? '';
    $key = $_ENV['SUPABASE_KEY'] ?? '';
    [$ok, $row] = supabase_get_by_id('applications', (int)$id, $url, $key);
    if (!$ok || !$row) {
      http_response_code(404);
      render('error.php', ['title' => 'No encontrado', 'message' => 'Candidato no encontrado']);
      return;
    }
    render('admin/detail.php', ['title' => 'Admin', 'year' => date('Y'), 'row' => $row]);
  }
}
