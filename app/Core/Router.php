<?php
namespace App\Core;

class Router {
  private array $routes = [];

  public function add(string $method, string $pattern, callable $handler): void {
    $this->routes[] = [$method, $this->compile($pattern), $handler];
  }

  public function dispatch(string $method, string $path): void {
    foreach ($this->routes as [$m, $regex, $handler]) {
      if ($m !== $method) continue;
      if (preg_match($regex, $path, $mats)) {
        // preg_match returns both numeric and named keys when using named groups.
        // PHP 8 treats string-keyed entries as named args, which cannot mix with positional.
        // Keep only numeric-indexed captures in order.
        $args = [];
        foreach ($mats as $k => $v) {
          if (is_int($k) && $k > 0) { $args[] = $v; }
        }
        echo call_user_func_array($handler, $args);
        return;
      }
    }
    http_response_code(404);
    echo 'Not found';
  }

  private function compile(string $pattern): string {
    $regex = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern);
    return '#^' . $regex . '$#';
  }
}
