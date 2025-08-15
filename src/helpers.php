<?php
// PDH/src/helpers.php

declare(strict_types=1);

function view_path(string $view): string {
  $root = dirname(__DIR__);
  return $root . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $view);
}

function ensure_app_session(): void {
  if (!isset($_SESSION['application']) || !is_array($_SESSION['application'])) {
    $_SESSION['application'] = [ 'created_at' => date('c') ];
  }
}

function render(string $view, array $data = []): void {
  $layout = view_path('layouts/main.php');
  $viewFile = view_path($view);
  // Avoid PHP 8-only str_ends_with; use substr for compatibility
  if (substr($viewFile, -4) !== '.php') $viewFile .= '.php';
  if (!file_exists($viewFile)) {
    http_response_code(500);
    echo 'View not found: ' . htmlspecialchars($viewFile);
    exit;
  }
  extract($data, EXTR_SKIP);
  ob_start();
  include $viewFile;
  $content = ob_get_clean();
  include $layout;
}

function h(?string $s): string { return htmlspecialchars((string)$s ?? '', ENT_QUOTES, 'UTF-8'); }

function base_path(): string {
  $bp = $_ENV['BASE_PATH'] ?? '';
  if ($bp === '/') return '';
  return rtrim($bp, '/');
}

// Build URL respecting BASE_PATH
function u(string $path): string {
  $p = '/' . ltrim($path, '/');
  return base_path() . $p;
}

function redirect(string $to): void { header('Location: ' . u($to)); exit; }

function require_admin(): void {
  if (empty($_SESSION['admin'])) {
    header('Location: ' . u('/admin'));
    exit;
  }
}

function formatDate(?string $iso): string {
  if (!$iso) return '';
  // Add variable name in catch for PHP 7 compatibility
  try { $dt = new DateTime($iso); return $dt->format('Y-m-d H:i'); } catch (Exception $e) { return $iso; }
}

function handle_upload(string $field, string $destDir): ?string {
  if (!isset($_FILES[$field]) || !is_array($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
  $name = $_FILES[$field]['name'] ?? 'file';
  $tmp = $_FILES[$field]['tmp_name'];
  $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
  $target = time() . '_' . $safe;
  if (!is_dir($destDir)) @mkdir($destDir, 0777, true);
  $ok = move_uploaded_file($tmp, rtrim($destDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $target);
  return $ok ? $target : null;
}

// ---- Supabase REST helpers ----
function supabase_headers(string $key): array {
  return [
    'Content-Type: application/json',
    'apikey: ' . $key,
    'Authorization: Bearer ' . $key,
    'Prefer: return=representation'
  ];
}

function supabase_insert(string $table, array $payload, string $url, string $key): array {
  $endpoint = rtrim($url, '/') . '/rest/v1/' . rawurlencode($table);
  $ch = curl_init($endpoint);
  curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => supabase_headers($key),
    CURLOPT_POSTFIELDS => json_encode([$payload], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
  ]);
  $body = curl_exec($ch);
  $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $err = curl_error($ch);
  curl_close($ch);
  if ($err || $http >= 400) return [false, ['error' => $err ?: $body, 'status' => $http]];
  $json = json_decode($body, true);
  return [true, is_array($json) && isset($json[0]) ? $json[0] : $json];
}

function supabase_select(string $table, string $select, string $url, string $key, array $opts = []): array {
  $params = http_build_query(array_merge(['select' => $select], []));
  $endpoint = rtrim($url, '/') . '/rest/v1/' . rawurlencode($table) . '?' . $params;
  if (isset($opts['order'])) {
    $endpoint .= '&order=' . urlencode($opts['order']);
  }
  $ch = curl_init($endpoint);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => supabase_headers($key),
  ]);
  $body = curl_exec($ch);
  $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $err = curl_error($ch);
  curl_close($ch);
  if ($err || $http >= 400) return [false, []];
  $json = json_decode($body, true);
  return [true, is_array($json) ? $json : []];
}

function supabase_get_by_id(string $table, int $id, string $url, string $key): array {
  $endpoint = rtrim($url, '/') . '/rest/v1/' . rawurlencode($table) . '?id=eq.' . $id;
  $endpoint .= '&select=*';
  $ch = curl_init($endpoint);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => supabase_headers($key),
  ]);
  $body = curl_exec($ch);
  $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $err = curl_error($ch);
  curl_close($ch);
  if ($err || $http >= 400) return [false, null];
  $json = json_decode($body, true);
  return [true, isset($json[0]) ? $json[0] : null];
}

function map_application_for_supabase(array $data): array {
  return [
    'created_at' => $data['created_at'] ?? null,
    'vacancy' => $data['vacancy'] ?? null,
    'nombre' => $data['nombre'] ?? null,
    'apellidos' => $data['apellidos'] ?? null,
    'identidad' => $data['identidad'] ?? null,
    'telefono' => $data['telefono'] ?? null,
    'correo' => $data['correo'] ?? null,
    'titulacion' => $data['titulacion'] ?? null,
    'empresas' => $data['empresas'] ?? null,
    'skills' => $data['skills'] ?? null,
    'motivacion' => $data['motivacion'] ?? null,
    'antecedentes_filename' => $data['antecedentes'] ?? null,
    'identidad_filename' => $data['identidad_doc'] ?? null,
    'referencias' => $data['referencias'] ?? null,
  ];
}
