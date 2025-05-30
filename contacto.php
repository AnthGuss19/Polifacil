<?php
// contacto.php - Manejo del formulario de contacto

// Configuración de la base de datos (opcional)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "polifacil";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));
    
    // Validar los datos
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre es requerido.";
    }
    
    if (empty($email)) {
        $errores[] = "El email es requerido.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    
    if (empty($mensaje)) {
        $errores[] = "El mensaje es requerido.";
    }
    
    // Si no hay errores, procesar el formulario
    if (empty($errores)) {
        try {
            // Opción 1: Guardar en base de datos
            /*
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, mensaje, fecha) VALUES (:nombre, :email, :mensaje, NOW())");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mensaje', $mensaje);
            $stmt->execute();
            */
            
            // Opción 2: Enviar por email
            $to = "admin@polifacil.com";
            $subject = "Nuevo mensaje de contacto - POLIFACIL";
            $body = "
            Nuevo mensaje de contacto recibido:
            
            Nombre: $nombre
            Email: $email
            Mensaje: $mensaje
            
            Fecha: " . date('Y-m-d H:i:s') . "
            ";
            
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            // Enviar email (requiere configuración del servidor)
            // mail($to, $subject, $body, $headers);
            
            // Opción 3: Guardar en archivo de texto
            $archivo = "contactos.txt";
            $contenido = "Fecha: " . date('Y-m-d H:i:s') . "\n";
            $contenido .= "Nombre: $nombre\n";
            $contenido .= "Email: $email\n";
            $contenido .= "Mensaje: $mensaje\n";
            $contenido .= "------------------------\n\n";
            
            file_put_contents($archivo, $contenido, FILE_APPEND | LOCK_EX);
            
            $mensaje_exito = "¡Gracias por tu mensaje! Te contactaremos pronto.";
            
        } catch (Exception $e) {
            $errores[] = "Error al procesar el mensaje. Por favor, inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - POLIFACIL</title>
    <link rel="stylesheet" href="styles.css">
    <style>  
        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            padding: 0.5rem 1rem;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .back-link:hover {
            background: #5a6268;
        }
    </style>
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
            <a href="index.html" class="back-link">← Volver al inicio</a>
            
            <h1>Contacto</h1>
            
            <?php if (isset($mensaje_exito)): ?>
                <div class="alert alert-success">
                    <?php echo $mensaje_exito; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="contact-info">
                <div class="contact-item">
                    <h3>Dirección</h3>
                    <p>Av. Principal 123, Ciudad</p>
                </div>
                <div class="contact-item">
                    <h3>Teléfono</h3>
                    <p>(123) 456-7890</p>
                </div>
                <div class="contact-item">
                    <h3>Email</h3>
                    <p>info@polifacil.com</p>
                </div>
            </div>

            <div class="contact-form">
                <h2>Envíanos un Mensaje</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" required 
                               value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje">Mensaje *</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required><?php echo isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-form-action">Enviar Mensaje</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>