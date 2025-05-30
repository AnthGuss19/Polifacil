<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

// Verificar que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Log de todos los datos recibidos para debug
    file_put_contents('debug_post_data.txt', print_r($_POST, true));
    
    // Recoger datos del formulario
    $distrito = $_POST['distrito'] ?? '';
    $numeroOficio1 = $_POST['numeroOficio1'] ?? $distrito;
    $numeroOficio2 = $_POST['numeroOficio2'] ?? '';

    // Ciudad 1 (para el encabezado del documento)
    $ciudadSeleccionada = $_POST['ciudad'] ?? '';
    $otraCiudad = $_POST['otraCiudad'] ?? '';
    $ciudad = ($ciudadSeleccionada === 'OTRA') ? $otraCiudad : $ciudadSeleccionada;
    
    // Ciudad 2 (para el evento)
    $ciudadSeleccionada2 = $_POST['ciudad2'] ?? '';
    $otraCiudad2 = $_POST['otraCiudad2'] ?? '';
    $ciudad2 = ($ciudadSeleccionada2 === 'OTRA') ? $otraCiudad2 : $ciudadSeleccionada2;
    
    $fecha = $_POST['fecha'] ?? '';
    $grado = $_POST['grado'] ?? '';
    $nombreApellidos = $_POST['nombreApellidos'] ?? '';
    $cargo = $_POST['cargo'] ?? '';

    // Datos del solicitante
    $iniciales_solicitante = $_POST['iniciales_solicitante'] ?? '';
    $Grado_general_superior  = $_POST['Grado_general_superior '] ?? '';
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
    // Motivo y detalles del evento
    $motivo = $_POST['motivo'] ?? 'CITA MÉDICA';
    $fechaInicio = $_POST['fechaInicio'] ?? '';
    
    // CORREGIDO: Manejo mejorado de la hora formateada
    $horaFormateada = $_POST['horaFormateada'] ?? '';
    
    // Log específico para la hora
    file_put_contents('debug_hora.txt', "Hora recibida: '$horaFormateada'\n", FILE_APPEND);
    
    if (empty($horaFormateada)) {
        // Si no viene la hora formateada, intentar construirla desde los componentes
        $horas = $_POST['horas'] ?? '';
        $minutos = $_POST['minutos'] ?? '';
        $ampm = $_POST['ampm'] ?? '';
        
        file_put_contents('debug_hora.txt', "Componentes - Horas: '$horas', Minutos: '$minutos', AMPM: '$ampm'\n", FILE_APPEND);
        
        if (!empty($horas) && !empty($minutos) && !empty($ampm)) {
            $horasStr = str_pad($horas, 2, '0', STR_PAD_LEFT);
            $minutosStr = str_pad($minutos, 2, '0', STR_PAD_LEFT);
            $horaFormateada = $horasStr . ':' . $minutosStr . ' ' . $ampm;
            file_put_contents('debug_hora.txt', "Hora construida: '$horaFormateada'\n", FILE_APPEND);
        } else {
            $horaFormateada = "08:00 AM"; // Valor por defecto
            file_put_contents('debug_hora.txt', "Usando hora por defecto: '$horaFormateada'\n", FILE_APPEND);
        }
    }
    
    $lugar = $_POST['lugar'] ?? '';
    
    // CORREGIDO: Manejo mejorado del anexo
    $respuesta_anexo = $_POST['respuesta_anexo'] ?? '';
    $anexo_custom = $_POST['anexo_custom'] ?? '';
    
    // Log específico para el anexo
    file_put_contents('debug_anexo.txt', "Respuesta anexo: '$respuesta_anexo'\n", FILE_APPEND);
    file_put_contents('debug_anexo.txt', "Anexo custom: '$anexo_custom'\n", FILE_APPEND);
    
    // Si se seleccionó "OTRA", usar el valor personalizado
    if ($respuesta_anexo === 'OTRA' && !empty($anexo_custom)) {
        $anexo = $anexo_custom;
    } else {
        $anexo = $respuesta_anexo;
    }
    
    file_put_contents('debug_anexo.txt', "Anexo final: '$anexo'\n", FILE_APPEND);

    // Validación de campos críticos
    if (empty($iniciales_solicitante)) {
        die("Error: Las iniciales del solicitante son requeridas.");
    }
    
    if (empty($horaFormateada)) {
        die("Error: La hora del evento es requerida.");
    }
    
    if (empty($anexo)) {
        die("Error: Debe seleccionar un tipo de anexo.");
    }

    // Log de campos clave para debug
    file_put_contents('debug_datos_finales.txt', print_r([
        'iniciales_solicitante' => $iniciales_solicitante,
        'nombreSolicitante' => $nombreSolicitante,
        'gradoSolicitante' => $gradoSolicitante,
        'Grado_general_superior' => $Grado_general_superior,
        'motivo' => $motivo,
        'ciudad2' => $ciudad2,
        'horaFormateada' => $horaFormateada,
        'lugar' => $lugar,
        'anexo_final' => $anexo
    ], true));

    // Validar y formatear fechas
    try {
        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        $fechaObj = new DateTime($fecha);
        $fechaFormateada = $fechaObj->format('d') . ' de ' . $meses[(int)$fechaObj->format('m')] . ' del ' . $fechaObj->format('Y');

        $fechaInicioObj = new DateTime($fechaInicio);
        $fechaInicioFormateada = $fechaInicioObj->format('d') . ' de ' . $meses[(int)$fechaInicioObj->format('m')] . ' de ' . $fechaInicioObj->format('Y');
    } catch (Exception $e) {
        die("Error al procesar las fechas: " . $e->getMessage());
    }

    try {
        // Verificar que existe la plantilla
        if (!file_exists('plantilla/Plantilla-cita.docx')) {
            die("Error: No se encontró la plantilla 'plantilla-cita.docx'");
        }
        
        // Cargar plantilla
        $template = new TemplateProcessor('plantilla/Plantilla-cita.docx');

        // Reemplazar variables del encabezado
        $template->setValue('distrito', $distrito);
        $template->setValue('numeroOficio1', $numeroOficio1);
        $template->setValue('numeroOficio2', $numeroOficio2);
        $template->setValue('ciudad', $ciudad);
        $template->setValue('fecha', $fechaFormateada);
        $template->setValue('grado', $grado);
        $template->setValue('nombreApellidos', $nombreApellidos);
        $template->setValue('cargo', $cargo);

        // Datos del solicitante
        $template->setValue('iniciales_solicitante', $iniciales_solicitante);
        $template->setValue('nombreSolicitante', $nombreSolicitante);
        $template->setValue('Grado_general_superior', $Grado_general_superior);
        $template->setValue('gradoSolicitante', $gradoSolicitante);
        $template->setValue('cargoSolicitante', $cargoSolicitante);

        // Motivo y detalles del evento
        $template->setValue('motivo', $motivo);
        $template->setValue('ciudad2', $ciudad2);
        $template->setValue('fechaInicio', $fechaInicioFormateada);
        
        // CRÍTICO: Asegurar que la hora se inserte correctamente
        $template->setValue('horaFormateada', $horaFormateada);
        $template->setValue('hora', $horaFormateada); // Por si la plantilla usa 'hora'
        $template->setValue('horaEvento', $horaFormateada); // Por si usa 'horaEvento'
        
        file_put_contents('debug_template.txt', "Insertando hora en template: '$horaFormateada'\n", FILE_APPEND);
        
        $template->setValue('lugar', $lugar);
        
        // CRÍTICO: Insertar el anexo correctamente
        if (!empty($anexo)) {
            $template->setValue('respuesta_anexo', $anexo);
            $template->setValue('anexo', 'Anexo:'); // Título del anexo
            $template->setValue('anexoTexto', $anexo); // Por si usa otro nombre
        } else {
            $template->setValue('respuesta_anexo', 'No especificado');
            $template->setValue('anexo', '');
            $template->setValue('anexoTexto', '');
        }
        
        file_put_contents('debug_template.txt', "Insertando anexo en template: '$anexo'\n", FILE_APPEND);

        // Guardar documento
        $fileName = 'Permiso_CitaMedica_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $nombreSolicitante) . '_' . date('Ymd_His') . '.docx';
        $directory = 'documentos';
        $filePath = $directory . '/' . $fileName;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $template->saveAs($filePath);
        
        // Verificar que el archivo se creó
        if (!file_exists($filePath)) {
            die("Error: No se pudo crear el archivo del documento.");
        }

        // Log del éxito
        file_put_contents('debug_success.txt', "Documento creado exitosamente: $filePath\n", FILE_APPEND);

        // Forzar descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        // Limpiar cualquier salida previa
        ob_clean();
        flush();
        readfile($filePath);
        // Eliminar después de enviar
        unlink($filePath);
        exit;
        
    } catch (Exception $e) {
        $errorMsg = 'Error al generar documento: ' . $e->getMessage() . ' en línea ' . $e->getLine();
        file_put_contents('error_log.txt', $errorMsg . PHP_EOL, FILE_APPEND);
        die("Error al generar el documento: " . $e->getMessage());
    }
} else {
    header('Location: index.html');
    exit;
}
?>
