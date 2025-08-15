<?php
// PDH/public/index.php
// Front controller + simple router

declare(strict_types=1);

session_start();

// Polyfills for PHP < 8 (production safety)
if (!function_exists('str_starts_with')) {
  function str_starts_with(string $haystack, string $needle): bool {
    if ($needle === '') return true;
    return strncmp($haystack, $needle, strlen($needle)) === 0;
  }
}
if (!function_exists('str_ends_with')) {
  function str_ends_with(string $haystack, string $needle): bool {
    if ($needle === '') return true;
    $len = strlen($needle);
    return $len <= 0 ? true : substr($haystack, -$len) === $needle;
  }
}

// Simple env loader (.env in project root)
$root = dirname(__DIR__);
$envFile = $root . DIRECTORY_SEPARATOR . '.env';
if (!file_exists($envFile)) {
  $alt = $root . DIRECTORY_SEPARATOR . 'env.local';
  if (file_exists($alt)) { $envFile = $alt; }
}
if (file_exists($envFile)) {
  $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (str_starts_with(trim($line), '#')) continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2) {
      $_ENV[trim($parts[0])] = trim($parts[1]);
    }
  }
}

// Config
$SUPABASE_URL = $_ENV['SUPABASE_URL'] ?? '';
$SUPABASE_KEY = $_ENV['SUPABASE_KEY'] ?? '';
$ADMIN_PASSWORD = $_ENV['ADMIN_PASSWORD'] ?? 'admin1234';
$UPLOAD_DIR = $_ENV['UPLOAD_DIR'] ?? ($root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads');
if (!is_dir($UPLOAD_DIR)) @mkdir($UPLOAD_DIR, 0777, true);

require_once $root . '/src/helpers.php';
require_once $root . '/app/Core/Router.php';
require_once $root . '/app/Controllers/HomeController.php';
require_once $root . '/app/Controllers/ApplyController.php';
require_once $root . '/app/Controllers/AdminController.php';

// Expose common vars to views
$viewDataBase = [
  'title' => 'Reclutamientos',
  'year' => date('Y')
];

// Ensure application session
function ensureAppSession(): void {
  if (!isset($_SESSION['application']) || !is_array($_SESSION['application'])) {
    $_SESSION['application'] = [ 'created_at' => date('c') ];
  }
}

// Routing
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Normalize path by removing BASE_PATH prefix if present
$bp = base_path();
if ($bp && str_starts_with($path, $bp)) {
  $path = substr($path, strlen($bp));
  if ($path === '') { $path = '/'; }
}

// Build Router
$router = new App\Core\Router();

// Home
$router->add('GET', '/', [new App\Controllers\HomeController(), 'index']);

// Apply
$apply = new App\Controllers\ApplyController();
$router->add('GET',  '/apply/step1', [$apply, 'step1']);
$router->add('POST', '/apply/step1', [$apply, 'postStep1']);
$router->add('GET',  '/apply/step2', [$apply, 'step2']);
$router->add('POST', '/apply/step2', [$apply, 'postStep2']);
$router->add('GET',  '/apply/step3', [$apply, 'step3']);
$router->add('POST', '/apply/step3', [$apply, 'postStep3']);
$router->add('GET',  '/apply/step4', [$apply, 'step4']);
$router->add('POST', '/apply/step4', [$apply, 'postStep4']);
$router->add('GET',  '/apply/step5', [$apply, 'step5']);
$router->add('POST', '/apply/submit', [$apply, 'postSubmit']);

// Admin
$admin = new App\Controllers\AdminController();
$router->add('GET',  '/admin',          [$admin, 'login']);
$router->add('POST', '/admin/login',    [$admin, 'postLogin']);
$router->add('GET',  '/admin/logout',   [$admin, 'logout']);
$router->add('GET',  '/admin/candidates', [$admin, 'candidates']);
$router->add('GET',  '/admin/candidates/{id}', [$admin, 'detail']);

// Dispatch
$router->dispatch($method, $path);
