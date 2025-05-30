<?php
// Cargar la biblioteca PHPWord
require_once 'vendor/autoload.php';

// Verificar que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Añade depuración para verificar que los datos se están recibiendo correctamente
    file_put_contents('debug_log.txt', print_r($_POST, true));

    // Recoger los datos del formulario y convertir a mayúsculas
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_Fin = $_POST['fecha_Fin'] ?? '';
    $dias = $_POST['dias'] ?? '';
    $grado = strtoupper($_POST['grado'] ?? '');
    $apellidos = strtoupper($_POST['apellidos'] ?? '');
    $nombres = strtoupper($_POST['nombres'] ?? '');
    $cedula = $_POST['cedula'] ?? '';
    $nomenclatura = strtoupper($_POST['nomenclatura'] ?? '');
    $cargo = strtoupper($_POST['cargo'] ?? '');
    $motivo_causa = strtoupper($_POST['motivo_causa'] ?? '');
    
    // Datos de firmas (convertir a mayúsculas)
    $grado_ServidorPolicial = strtoupper($_POST['grado_ServidorPolicial'] ?? '');
    $Apellidos_Nombres_servidor = strtoupper($_POST['Apellidos_Nombres_servidor'] ?? '');
    $cedula_ServidorPolicial = $_POST['cedula_ServidorPolicial'] ?? '';
    
    $grado_AnAs = strtoupper($_POST['grado_AnAs'] ?? '');
    $Apellidos_Nombres_AnAs = strtoupper($_POST['Apellidos_Nombres_AnAs'] ?? '');
    $cedula_AnAs = $_POST['cedula_AnAs'] ?? '';
    
    $grado_JfAd = strtoupper($_POST['grado_JfAd'] ?? '');
    $Apellidos_Nombres_JfAd = strtoupper($_POST['Apellidos_Nombres_JfAd'] ?? '');
    $cedula_JfAd = $_POST['cedula_JfAd'] ?? '';
    
    $grado_DctCdtJfund = strtoupper($_POST['grado_DctCdtJfund'] ?? '');
    $Apellidos_Nombres_DctCdtJfund = strtoupper($_POST['Apellidos_Nombres_DctCdtJfund'] ?? '');
    $cedula_DctCdtJfund = $_POST['cedula_DctCdtJfund'] ?? '';
    
    // Datos de tipo de licencia y lugar de uso
    $tipoLicencia = $_POST['tipoLicencia'] ?? 'conRemuneracion';
    $lugarUso = $_POST['lugarUso'] ?? 'pais';
    $ciudadPais = strtoupper($_POST['ciudadPais'] ?? '');
    
    // Validar campos obligatorios
    if (empty($fecha_inicio) || empty($fecha_Fin) || empty($dias) || empty($grado) || 
        empty($apellidos) || empty($nombres) || empty($cedula) || empty($nomenclatura) || 
        empty($cargo) || empty($motivo_causa)) {
        die("Error: Todos los campos obligatorios deben ser completados.");
    }
    
    // Validar cédulas (10 dígitos)
    if (strlen($cedula) !== 10 || !ctype_digit($cedula) ||
        strlen($cedula_ServidorPolicial) !== 10 || !ctype_digit($cedula_ServidorPolicial) ||
        strlen($cedula_AnAs) !== 10 || !ctype_digit($cedula_AnAs) ||
        strlen($cedula_JfAd) !== 10 || !ctype_digit($cedula_JfAd) ||
        strlen($cedula_DctCdtJfund) !== 10 || !ctype_digit($cedula_DctCdtJfund)) {
        die("Error: Todas las cédulas deben tener 10 dígitos numéricos.");
    }
    
    // Validar días (3 u 8)
    if ($dias != 3 && $dias != 8) {
        die("Error: El permiso debe ser de 3 u 8 días exactamente.");
    }
    
    // Formatear las fechas en formato numérico DD/MM/AAAA
    $fechaInicioObj = new DateTime($fecha_inicio);
    $fechaFinObj = new DateTime($fecha_Fin);
    
    $fechaInicioFormateada = $fechaInicioObj->format('d/m/Y');
    $fechaFinFormateada = $fechaFinObj->format('d/m/Y');
    
    // Mapeo de abreviaturas de grado a nombres completos
    $gradosCompletos = [
        'Gral' => 'GENERAL',
        'Crnl' => 'CORONEL',
        'Tcnl' => 'TENIENTE CORONEL',
        'Mayr' => 'MAYOR',
        'Cptn' => 'CAPITÁN',
        'Tnte' => 'TENIENTE',
        'Sbte' => 'SUBTENIENTE',
        'Sbom' => 'SUBOFICIAL MAYOR',
        'Sbop' => 'SUBOFICIAL PRIMERO',
        'Sbos' => 'SUBOFICIAL SEGUNDO',
        'Sgop' => 'SARGENTO PRIMERO',
        'Sgos' => 'SARGENTO SEGUNDO',
        'Cbop' => 'CABO PRIMERO',
        'Cbos' => 'CABO SEGUNDO',
        'Poli' => 'POLICÍA',
    ];
    
    // Convertir abreviaturas a nombres completos
    $gradoCompleto = isset($gradosCompletos[$grado]) ? $gradosCompletos[$grado] : $grado;
    $gradoServidorCompleto = isset($gradosCompletos[$grado_ServidorPolicial]) ? $gradosCompletos[$grado_ServidorPolicial] : $grado_ServidorPolicial;
    $gradoAnAsCompleto = isset($gradosCompletos[$grado_AnAs]) ? $gradosCompletos[$grado_AnAs] : $grado_AnAs;
    $gradoJfAdCompleto = isset($gradosCompletos[$grado_JfAd]) ? $gradosCompletos[$grado_JfAd] : $grado_JfAd;
    $gradoDctCdtJfundCompleto = isset($gradosCompletos[$grado_DctCdtJfund]) ? $gradosCompletos[$grado_DctCdtJfund] : $grado_DctCdtJfund;
    
    try {
        // Cargar la plantilla (usar el nombre correcto de tu plantilla)
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('plantilla/plantilla_formulario.docx');
        
        // Reemplazar las variables en la plantilla
        $templateProcessor->setValue('fecha_inicio', $fechaInicioFormateada);
        $templateProcessor->setValue('fecha_Fin', $fechaFinFormateada);
        $templateProcessor->setValue('dias', $dias);
        $templateProcessor->setValue('grado', $gradoCompleto);
        $templateProcessor->setValue('apellidos', $apellidos);
        $templateProcessor->setValue('nombres', $nombres);
        $templateProcessor->setValue('cedula', $cedula);
        $templateProcessor->setValue('nomenclatura', $nomenclatura);
        $templateProcessor->setValue('cargo', $cargo);
        $templateProcessor->setValue('motivo_causa', $motivo_causa);
        
        // Firmas
        $templateProcessor->setValue('grado_ServidorPolicial', $gradoServidorCompleto);
        $templateProcessor->setValue('Apellidos_Nombres_servidor', $Apellidos_Nombres_servidor);
        $templateProcessor->setValue('cedula_ ServidorPolicial', $cedula_ServidorPolicial);
        
        $templateProcessor->setValue('grado_An/As', $gradoAnAsCompleto);
        $templateProcessor->setValue('Apellidos_Nombres_An/As', $Apellidos_Nombres_AnAs);
        $templateProcessor->setValue('cedula_ An/As', $cedula_AnAs);
        
        $templateProcessor->setValue('grado_Jf/Ad', $gradoJfAdCompleto);
        $templateProcessor->setValue('Apellidos_Nombres_Jf/Ad', $Apellidos_Nombres_JfAd);
        $templateProcessor->setValue('cedula_ Jf/Ad', $cedula_JfAd);
        
        $templateProcessor->setValue('grado_Dct/Cdt/Jfund', $gradoDctCdtJfundCompleto);
        $templateProcessor->setValue('Apellidos_Nombres_Dct/Cdt/Jfund', $Apellidos_Nombres_DctCdtJfund);
        $templateProcessor->setValue('cedula_Dct/Cdt/Jfund', $cedula_DctCdtJfund);
        
        // Configurar las casillas de verificación
        // Para el tipo de licencia
        if ($tipoLicencia === 'conRemuneracion') {
            $templateProcessor->setValue('conRemuneracion_X', 'X');
            $templateProcessor->setValue('sinRemuneracion_X', '');
        } else {
            $templateProcessor->setValue('conRemuneracion_X', '');
            $templateProcessor->setValue('sinRemuneracion_X', 'X');
        }
        
        // Para el lugar de uso
        if ($lugarUso === 'pais') {
            $templateProcessor->setValue('pais_X', 'X');
            $templateProcessor->setValue('exterior_X', '');
            $templateProcessor->setValue('ciudadPais', ''); // Limpiar el campo si no se usa
        } else {
            $templateProcessor->setValue('pais_X', '');
            $templateProcessor->setValue('exterior_X', 'X');
            $templateProcessor->setValue('ciudadPais', $ciudadPais);
        }
        
        // Generar un nombre de archivo único
        $fileName = 'Solicitud_Permiso_' . date('Y-m-d_H-i-s');
        $wordFilePath = 'documentos/' . $fileName . '.docx';
        
        // Asegurarse de que el directorio existe
        if (!file_exists('documentos')) {
            mkdir('documentos', 0777, true);
        }
        
        // Guardar el documento Word
        $templateProcessor->saveAs($wordFilePath);
        
        // Verificar si el archivo se creó correctamente
        if (!file_exists($wordFilePath)) {
            die("Error: No se pudo crear el archivo de documento Word.");
        }
        
        // Configurar las cabeceras para la descarga del Word
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $fileName . '.docx"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($wordFilePath));
        // Limpiar el buffer de salida
        ob_clean();
        flush();
        // Leer el archivo y enviarlo al navegador
        readfile($wordFilePath);
        // Eliminar el archivo temporal
        unlink($wordFilePath);
        
        exit;
        
    } catch (Exception $e) {
        // Registrar el error para depuración
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . ': ' . $e->getMessage() . "\n", FILE_APPEND);
        die("Error al generar el documento: " . $e->getMessage());
    }
} else {
    // Si alguien intenta acceder directamente a este archivo
    header('Location: index.html');
    exit;
}
?>