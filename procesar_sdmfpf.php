<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Verificar que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // DEBUG: guardar todos los datos recibidos
    file_put_contents('debug_form_data.txt', print_r($_POST, true));
    
    // Recoger datos del formulario según la nueva plantilla
    $distrito = $_POST['distrito'] ?? '';
    $numeroOficio1 = $_POST['numeroOficio1'] ?? $distrito;
    $numeroOficio2 = $_POST['numeroOficio2'] ?? '';
    $memorando = $_POST['memorando'] ?? '';
    $numeroFormateado = $_POST['numeroFormateado'] ?? '';

    // Ciudad
    $ciudadSeleccionada = $_POST['ciudad'] ?? '';
    $otraCiudad = $_POST['otraCiudad'] ?? '';
    $ciudad = ($ciudadSeleccionada === 'OTRA') ? $otraCiudad : $ciudadSeleccionada;
    
    $fecha = $_POST['fecha'] ?? '';
    $grado = $_POST['grado'] ?? '';
    $nombreApellidos = $_POST['nombreApellidos'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $gradoOtorgamiento = $_POST['gradoOtorgamiento'] ?? '';
    $nombreOtorgamiento = $_POST['nombreOtorgamiento'] ?? '';
    $cargoOtorgamiento = $_POST['cargoOtorgamiento'] ?? '';

    // Datos del solicitante
    $iniciales_solicitante = $_POST['iniciales_solicitante'] ?? '';
    $nombreSolicitante = $_POST['nombreSolicitante'] ?? '';
    $Grado_general_superior  = $_POST['Grado_general_superior '] ?? '';
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
    // Nuevos campos específicos para esta plantilla
    $dias = $_POST['dias'] ?? '';
    $diasnumero = $_POST['diasnumero'] ?? '';
    $Motivo_felicitacion = $_POST['Motivo_felicitacion'] ?? '';
    $fechaInicio = $_POST['fechaInicio'] ?? '';
    $opcional = $_POST['opcional'] ?? '';
    $fechaSeleccionada = $_POST['fechaSeleccionada'] ?? '';
    $fechaSeleccionadaFormateada = $_POST['fechaSeleccionadaFormateada'] ?? '';

    // Validación del motivo de felicitación
    if (!in_array($Motivo_felicitacion, ['PUBLICA', 'SOLEMNE'])) {
        die("Error: Motivo de felicitación inválido. Debe ser PUBLICA o SOLEMNE.");
    }

    // Log de campos clave para debug
    file_put_contents('debug_datos_importantes.txt', print_r([
        'distrito' => $distrito,
        'numeroOficio1' => $numeroOficio1,
        'numeroOficio2' => $numeroOficio2,
        'numero' => $numero,
        'numeroFormateado' => $numeroFormateado,
        'iniciales_solicitante' => $iniciales_solicitante,
        'Grado_general_superior' => $Grado_general_superior,
        'ciudad' => $ciudad,
        'fecha' => $fecha,
        'memorando' => $memorando,
        'dias' => $dias,
        'diasnumero' => $diasnumero,
        'Motivo_felicitacion' => $Motivo_felicitacion,
        'grado' => $grado,
        'nombreApellidos' => $nombreApellidos,
        'cargo' => $cargo,
        'gradoOtorgamiento' => $gradoOtorgamiento,
        'nombreOtorgamiento' => $nombreOtorgamiento,
        'cargoOtorgamiento' => $cargoOtorgamiento,
        'gradoSolicitante' => $gradoSolicitante,
        'fechaInicio' => $fechaInicio,
        'fechaSeleccionada' => $fechaSeleccionada,
        'fechaSeleccionadaFormateada' => $fechaSeleccionadaFormateada,
        'opcional' => $opcional,
        'nombreSolicitante' => $nombreSolicitante,
        'cargoSolicitante' => $cargoSolicitante
    ], true));

    // Validar y formatear fechas
    try {
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        // Formatear fecha del oficio
        $fechaObj = new DateTime($fecha);
        $fechaFormateada = $fechaObj->format('d') . ' de ' . $meses[(int)$fechaObj->format('m')] . ' de ' . $fechaObj->format('Y');

        // Formatear fecha de inicio del franco
        $fechaInicioObj = new DateTime($fechaInicio);
        $fechaInicioFormateada = $fechaInicioObj->format('d') . ' de ' . $meses[(int)$fechaInicioObj->format('m')] . ' de ' . $fechaInicioObj->format('Y');
        
        // Usar la fecha formateada que viene del JavaScript (ya procesada para 1 o 2 días)
        $fechaSeleccionadaFinal = $fechaSeleccionadaFormateada;

    } catch (Exception $e) {
        die("Error al procesar las fechas: " . $e->getMessage());
    }

    try {
        // Cargar plantilla
        $template = new TemplateProcessor('plantilla/plantilla-felicitacion.docx');

        // Reemplazar todas las variables según la nueva plantilla
        $template->setValue('numeroOficio1', $numeroOficio1);
        $template->setValue('iniciales_solicitante', $iniciales_solicitante);
        $template->setValue('numeroOficio2', $numeroOficio2);
        $template->setValue('Grado_general_superior', $Grado_general_superior);
        $template->setValue('memorando', $memorando);
        $template->setValue('ciudad', $ciudad);
        $template->setValue('fecha', $fechaFormateada);
        $template->setValue('dias', $dias);
        $template->setValue('diasnumero', $diasnumero);
        $template->setValue('Motivo_felicitacion', $Motivo_felicitacion);
        $template->setValue('grado', $grado);
        $template->setValue('nombreApellidos', $nombreApellidos);
        $template->setValue('cargo', $cargo);
        $template->setValue('gradoOtorgamiento', $gradoOtorgamiento);
        $template->setValue('nombreOtorgamiento', $nombreOtorgamiento);
        $template->setValue('cargoOtorgamiento', $cargoOtorgamiento);
        $template->setValue('gradoSolicitante', $gradoSolicitante);
        $template->setValue('fechaInicio', $fechaInicioFormateada);
        $template->setValue('fechaSeleccionada', $fechaSeleccionadaFinal);
        $template->setValue('opcional', $opcional);
        $template->setValue('nombreSolicitante', $nombreSolicitante);
        $template->setValue('cargoSolicitante', $cargoSolicitante);

        // Guardar documento
        $fileName = 'Solicitud_Franco_Felicitacion_' . preg_replace('/\s+/', '_', $nombreSolicitante) . '_' . date('Ymd_His') . '.docx';
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
    header('Location: index.html');
    exit;
}
?>
