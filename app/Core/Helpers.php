<?php
declare(strict_types=1);
namespace App\Core;

class Helpers {
  public static function h(?string $s): string { return htmlspecialchars((string)$s ?? '', ENT_QUOTES, 'UTF-8'); }
  public static function basePath(): string {
    $bp = $_ENV['BASE_PATH'] ?? '';
    if ($bp === '/') return '';
    return rtrim($bp, '/');
  }
  public static function u(string $path): string { return self::basePath() . '/' . ltrim($path, '/'); }
  public static function formatDate(?string $iso): string {
    if (!$iso) return '';
    try { $dt = new \DateTime($iso); return $dt->format('Y-m-d H:i'); } catch (\Exception) { return (string)$iso; }
  }
  public static function requireAdmin(): void {
    if (empty($_SESSION['admin'])) { header('Location: ' . self::u('/admin')); exit; }
  }
  public static function ensureAppSession(): void {
    if (!isset($_SESSION['application']) || !is_array($_SESSION['application'])) {
      $_SESSION['application'] = [ 'created_at' => date('c') ];
    }
  }
  public static function handleUpload(string $field, string $destDir): ?string {
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $name = $_FILES[$field]['name'] ?? 'file';
    $tmp = $_FILES[$field]['tmp_name'];
    $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
    $target = time() . '_' . $safe;
    if (!is_dir($destDir)) @mkdir($destDir, 0777, true);
    $ok = move_uploaded_file($tmp, rtrim($destDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $target);
    return $ok ? $target : null;
  }
}

// Global helper aliases for existing views compatibility
function h(?string $s): string { return Helpers::h($s); }
function base_path(): string { return Helpers::basePath(); }
function u(string $path): string { return Helpers::u($path); }
function formatDate(?string $iso): string { return Helpers::formatDate($iso); }
function require_admin(): void { Helpers::requireAdmin(); }
function ensureAppSession(): void { Helpers::ensureAppSession(); }
