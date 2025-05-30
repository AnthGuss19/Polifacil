<?php
// plantilla.php - Sistema integrado de formularios POLIFACIL

// Obtener el tipo de plantilla desde la URL
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'calamidad';

// Configuración de plantillas
$plantillas = [
    'calamidad' => [
        'titulo' => 'Solicitud de Permiso por Calamidad Doméstica',
        'descripcion' => 'Complete el formulario para generar su solicitud de permiso por calamidad doméstica.',
        'archivo_procesamiento' => 'procesar_spcd.php',
        'archivo_formulario' => 'plantilla_solicitud.php'
    ],
    'vacaciones' => [
        'titulo' => 'Solicitud de Vacaciones',
        'descripcion' => 'Complete el formulario para solicitar su período de vacaciones.',
        'archivo_procesamiento' => 'procesar_spcm.php',
        'archivo_formulario' => 'plantilla_citaMedica.php'
    ],
    'certificado' => [
        'titulo' => 'Solicitud de Certificado',
        'descripcion' => 'Complete el formulario para solicitar certificados institucionales.',
        'archivo_procesamiento' => 'procesar_sdmfpf.php',
        'archivo_formulario' => 'plantilla_franco.php'
    ],
    'informe' => [
        'titulo' => 'Informe de Actividades',
        'descripcion' => 'Complete el formulario para presentar su informe de actividades.',
        'archivo_procesamiento' => 'procesar_fpcd.php',
        'archivo_formulario' => 'plantilla_formulario.php'
    ]
];

// Verificar si el tipo de plantilla existe
if (!isset($plantillas[$tipo])) {
    $tipo = 'calamidad';
}
$plantilla_actual = $plantillas[$tipo];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $plantilla_actual['titulo']; ?> - POLIFACIL</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo-container">
                <img src="" alt="POLIFACIL" class="logo">
                <h1 class="logo-text">POLIFACIL</h1>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="index.html#plantillas" class="active">Plantillas</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <?php
            // Incluir el archivo de formulario correspondiente
            if (file_exists($plantilla_actual['archivo_formulario'])) {
                include($plantilla_actual['archivo_formulario']);
            } else {
                echo "<div class='error-message'>El formulario solicitado no está disponible.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>