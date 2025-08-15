<?php
declare(strict_types=1);

namespace App\Controllers;

class ApplyController {
  public function step1(): void {
    ensure_app_session();
    $vacancies = [
      [ 'id' => 'dev_node', 'title' => 'Desarrollador Node.js', 'salario' => 'HNL 35,000 - 60,000', 'ejemplo' => 'API REST, Express, Supabase' ],
      [ 'id' => 'soporte_it', 'title' => 'Soporte IT', 'salario' => 'HNL 18,000 - 28,000', 'ejemplo' => 'Mesa de ayuda, Office 365' ],
      [ 'id' => 'analista_datos', 'title' => 'Analista de Datos', 'salario' => 'HNL 30,000 - 50,000', 'ejemplo' => 'SQL, Power BI' ],
    ];
    render('apply/step1.php', ['title' => 'Reclutamientos', 'year' => date('Y'), 'vacancies' => $vacancies, 'currentStep' => 1]);
  }
  public function postStep1(): void {
    ensure_app_session();
    $_SESSION['application']['vacancy'] = $_POST['vacancy'] ?? null;
    redirect('/apply/step2');
  }

  public function step2(): void {
    ensure_app_session();
    render('apply/step2.php', ['title' => 'Reclutamientos', 'year' => date('Y'), 'currentStep' => 2]);
  }
  public function postStep2(): void {
    ensure_app_session();
    $fields = ['nombre','apellidos','identidad','telefono','correo','titulacion','empresas','skills'];
    foreach ($fields as $f) { $_SESSION['application'][$f] = $_POST[$f] ?? null; }
    redirect('/apply/step3');
  }

  public function step3(): void {
    ensure_app_session();
    render('apply/step3.php', ['title' => 'Reclutamientos', 'year' => date('Y'), 'currentStep' => 3]);
  }
  public function postStep3(): void {
    ensure_app_session();
    $_SESSION['application']['motivacion'] = $_POST['motivacion'] ?? null;
    redirect('/apply/step4');
  }

  public function step4(): void {
    ensure_app_session();
    render('apply/step4.php', ['title' => 'Reclutamientos', 'year' => date('Y'), 'currentStep' => 4]);
  }
  public function postStep4(): void {
    ensure_app_session();
    $uploadDir = $_ENV['UPLOAD_DIR'] ?? (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads');
    $antecedentes = handle_upload('antecedentes', $uploadDir);
    $identidad_doc = handle_upload('identidad_doc', $uploadDir);
    $_SESSION['application']['antecedentes'] = $antecedentes;
    $_SESSION['application']['identidad_doc'] = $identidad_doc;
    redirect('/apply/step5');
  }

  public function step5(): void {
    ensure_app_session();
    render('apply/step5.php', ['title' => 'Reclutamientos', 'year' => date('Y'), 'currentStep' => 5]);
  }

  public function postSubmit(): void {
    ensure_app_session();
    $refs = [
      [ 'nombre' => $_POST['ref1_nombre'] ?? null, 'telefono' => $_POST['ref1_telefono'] ?? null, 'correo' => $_POST['ref1_correo'] ?? null ],
      [ 'nombre' => $_POST['ref2_nombre'] ?? null, 'telefono' => $_POST['ref2_telefono'] ?? null, 'correo' => $_POST['ref2_correo'] ?? null ],
    ];
    $_SESSION['application']['referencias'] = $refs;

    $url = $_ENV['SUPABASE_URL'] ?? '';
    $key = $_ENV['SUPABASE_KEY'] ?? '';
    $payload = map_application_for_supabase($_SESSION['application']);
    [$ok, $resp] = supabase_insert('applications', $payload, $url, $key);
    if (!$ok) {
      http_response_code(500);
      render('error.php', ['title' => 'Error', 'message' => 'No se pudo guardar tu aplicación. Intenta de nuevo.']);
      return;
    }
    $id = $resp['id'] ?? null;
    $_SESSION['application'] = null;
    render('apply/thanks.php', ['title' => 'Gracias', 'year' => date('Y'), 'appId' => $id]);
  }
}
