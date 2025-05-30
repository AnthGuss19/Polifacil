<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Verificar que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DEBUG: guardar todos los datos recibidos
    file_put_contents('debug_form_data.txt', print_r($_POST, true));

    // Recoger datos del formulario
    $distrito = $_POST['distrito'] ?? '';
    $numeroOficio1 = $_POST['numeroOficio1'] ?? $distrito;
    $numeroOficio2 = $_POST['numeroOficio2'] ?? '';
    $numeroOficio2 = $_POST['numeroOficio2'] ?? '';

    // Ciudad
    $ciudadSeleccionada = $_POST['ciudad'] ?? '';
    $otraCiudad = $_POST['otraCiudad'] ?? '';
    $ciudad = ($ciudadSeleccionada === 'OTRA') ? $otraCiudad : $ciudadSeleccionada;

    $fecha = $_POST['fecha'] ?? '';
    $grado = $_POST['grado'] ?? '';
    $nombreApellidos = $_POST['nombreApellidos'] ?? '';
    $cargo = $_POST['cargo'] ?? '';

    // Datos del solicitante - CORREGIDO
    $iniciales_solicitante = $_POST['iniciales_solicitante'] ?? '';
    $Grado_general_superior  = $_POST['Grado_general_superior '] ?? '';
    $nombreFamiliar = $_POST['nombreFamiliar'] ?? '';
    $nombreSolicitante = $_POST['nombreSolicitante'] ?? '';
    $gradoSolicitante = $_POST['gradoSolicitante'] ?? '';
    $cargoSolicitante = $_POST['cargoSolicitante'] ?? '';

    // NUEVO: Calcular Grado_general y miGrado_solicitante si están vacíos
    if (empty($Grado_general_superior)) {
        $gradosCompletos = [
            'Gral' => 'General',
            'Crnl' => 'Coronel',
            'Tcnl' => 'Teniente Coronel',
            'Mayr' => 'Mayor',
            'Cptn' => 'Capitán',
            'Tnte' => 'Teniente',
            'Sbte' => 'Subteniente',
            'Sbom' => 'Suboficial Mayor',
            'Sbop' => 'Suboficial Primero',
            'Sbos' => 'Suboficial Segundo',
            'Sgop' => 'Sargento Primero',
            'Sgos' => 'Sargento Segundo',
            'Cbop' => 'Cabo Primero',
            'Cbos' => 'Cabo Segundo',
            'Poli' => 'Policía'
        ];
        
        $Grado_general_superior = $gradosCompletos[$grado] ?? '';
    }

    // Motivo
    $familiar = $_POST['familiar'] ?? '';
    $calamidad = $_POST['calamidad'] ?? '';
    $motivo = $_POST['motivo'] ?? $calamidad;
    $fechaInicio = $_POST['fechaInicio'] ?? '';
    $gradoPolicia = $_POST['gradoPolicia'] ?? '';

    // Certificado
    $presentaraCertificado = $_POST['presentaraCertificado'] ?? '';
    $tipoCertificado = $_POST['tipoCertificado'] ?? '';
    $certificado = $_POST['certificado'] ?? '';

    // Anexo
    $anexo = $_POST['anexo'] ?? '';
    $respuesta_anexo = $_POST['respuesta_anexo'] ?? '';

    // Log de campos clave - ACTUALIZADO
    file_put_contents('debug_solicitante.txt', print_r([
        'iniciales_solicitante' => $iniciales_solicitante,
        'Grado_general_superior' => $Grado_general_superior,
        'nombreSolicitante' => $nombreSolicitante,
        'nombreFamiliar' => $nombreFamiliar,
        'motivo' => $motivo,
        'tipoCertificado' => $tipoCertificado,
        'certificado' => $certificado,
        'anexo' => $anexo,
        'respuesta_anexo' => $respuesta_anexo
    ], true));

    // Validar fecha
    try {
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        $fechaObj = new DateTime($fecha);
        $fechaFormateada = $fechaObj->format('d') . ' de ' . $meses[(int)$fechaObj->format('m')] . ' de ' . $fechaObj->format('Y');

        $fechaInicioObj = new DateTime($fechaInicio);
        $fechaInicioFormateada = $fechaInicioObj->format('d') . ' de ' . $meses[(int)$fechaInicioObj->format('m')] . ' de ' . $fechaInicioObj->format('Y');
    } catch (Exception $e) {
        die("Error al procesar las fechas: " . $e->getMessage());
    }

    try {
        // Cargar plantilla
        $template = new TemplateProcessor('plantilla/plantilla-permiso.docx');

        // Reemplazar variables
        $template->setValue('distrito', $distrito);
        $template->setValue('numeroOficio1', $numeroOficio1);
        $template->setValue('numeroOficio2', $numeroOficio2);
        $template->setValue('ciudad', $ciudad);
        $template->setValue('fecha', $fechaFormateada);
        $template->setValue('grado', $grado);
        $template->setValue('nombreApellidos', $nombreApellidos);
        $template->setValue('cargo', $cargo);

        // Solicitante - CORREGIDO
        $template->setValue('iniciales_solicitante', $iniciales_solicitante);
        $template->setValue('Grado_general_superior', $Grado_general_superior);
        $template->setValue('nombreSolicitante', $nombreSolicitante);
        $template->setValue('nombreFamiliar', $nombreFamiliar);
        $template->setValue('gradoSolicitante', $gradoSolicitante);
        $template->setValue('cargoSolicitante', $cargoSolicitante);

        // Motivo
        $template->setValue('familiar', $familiar);
        $template->setValue('motivo', $motivo);
        $template->setValue('fechaInicio', $fechaInicioFormateada);
        $template->setValue('gradoPolicia', $gradoPolicia);
        $template->setValue('certificado', $certificado);

        // Anexo
        $template->setValue('anexo', $anexo);
        $template->setValue('respuesta_anexo', $respuesta_anexo);

        // Guardar documento
        $fileName = 'Permiso_' . preg_replace('/\s+/', '_', $nombreSolicitante) . '_' . date('Ymd_His') . '.docx';
        $directory = 'documentos';
        $filePath = $directory . '/' . $fileName;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $template->saveAs($filePath);

        // Forzar descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);

        // Eliminar después de enviar
        unlink($filePath);
        exit;
    } catch (Exception $e) {
        file_put_contents('error_log.txt', 'Error al generar documento: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
        die("Error al generar el documento: " . $e->getMessage());
    }
} else {
    header('Location: plantilla.php?tipo=calamidad');
    exit;
}
?>