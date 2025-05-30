<?php
// plantilla_solicitud.php - Formulario de Solicitud de Permiso por Calamidad Doméstica
// Este archivo es incluido por plantilla.php

// Asegurarse de que este archivo no sea accedido directamente
if (!isset($plantilla_actual)) {
    header('Location: plantilla.php?tipo=informe');
    exit;
}
?>
  <style>
        /* Estilo para convertir texto a mayúsculas */
        .uppercase {
            text-transform: uppercase;
        }
        /* Estilo para mensajes de error */
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Estilo para campos de solo lectura */
        input[readonly] {
            background-color: #f3f4f6;
            cursor: not-allowed;
        }
        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: white;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
<a href="index.html" class="back-btn">← Volver a Plantillas</a>

<h1><?php echo $plantilla_actual['titulo']; ?></h1>
<p class="description"><?php echo $plantilla_actual['descripcion']; ?></p>
<style>
        .tab-navigation {
        display: flex;
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .tab-btn {
        padding: 12px 20px;
        text-decoration: none;
        color: #495057;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 500;
        font-size: 14px;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin: 0 2px;
        position: relative;
        overflow: hidden;
    }

    .tab-btn:hover {
        background-color: #e9ecef;
        color: #212529;
    }

    .tab-btn.active {
        background-color: #4a6bff;
        color: white;
        box-shadow: 0 4px 6px rgba(74, 107, 255, 0.2);
    }

    .tab-btn.active:hover {
        background-color: #3a5bef;
    }

    /* Efecto opcional para el botón activo */
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        height: 3px;
        background-color: white;
        border-radius: 3px 3px 0 0;
    }

    /* Efecto de onda al hacer clic */
    .tab-btn:active {
        transform: scale(0.98);
    }
</style>
<div class="tab-navigation">
    <a href="plantilla_solicitud.php" class="tab-btn">Solicitud de Permiso</a>
    <a href="plantilla_formulario.php" class="tab-btn active">Formulario de Solicitud</a>
</div>
    <div class="form-container">
        <form id="permisoForm" action="procesar_fpcd.php" method="post">
            <!-- SECCIÓN 1: INFORMACIÓN PERSONAL -->
            <section class="form-section">
                <h2>Información Personal</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="grado">Grado</label>
                        <select id="grado" name="grado" required class="highlight-field uppercase">
                            <option value="">SELECCIONE UN GRADO</option>
                            <option value="Gral">GENERAL</option>
                            <option value="Crnl">CORONEL</option>
                            <option value="Tcnl">TENIENTE CORONEL</option>
                            <option value="Mayr">MAYOR</option>
                            <option value="Cptn">CAPITÁN</option>
                            <option value="Tnte">TENIENTE</option>
                            <option value="Sbte">SUBTENIENTE</option>
                            <option value="Sbom">SUBOFICIAL MAYOR</option>
                            <option value="Sbop">SUBOFICIAL PRIMERO</option>
                            <option value="Sbos">SUBOFICIAL SEGUNDO</option>
                            <option value="Sgop">SARGENTO PRIMERO</option>
                            <option value="Sgos">SARGENTO SEGUNDO</option>
                            <option value="Cbop">CABO PRIMERO</option>
                            <option value="Cbos">CABO SEGUNDO</option>
                            <option value="Poli">POLICÍA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="INGRESE SUS APELLIDOS" required class="highlight-field uppercase">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" id="nombres" name="nombres" placeholder="INGRESE SUS NOMBRES" required class="highlight-field uppercase">
                    </div>
                    <div class="form-group">
                        <label for="cedula">No. de Cédula</label>
                        <input type="text" id="cedula" name="cedula" placeholder="INGRESE SU NÚMERO DE CÉDULA (10 DÍGITOS)" required class="highlight-field" maxlength="10" pattern="[0-9]{10}">
                        <div id="cedulaError" class="error-message" style="display: none;">LA CÉDULA DEBE TENER 10 DÍGITOS NUMÉRICOS</div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nomenclatura">Descripción de la Nomenclatura</label>
                        <input type="text" id="nomenclatura" name="nomenclatura" placeholder="EJ: NDESC-Z5-SZ-LOS RIOS-DBABAHOYO" required class="highlight-field uppercase">
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo o función</label>
                        <input type="text" id="cargo" name="cargo" placeholder="INGRESE SU CARGO O FUNCIÓN" required class="highlight-field uppercase">
                    </div>
                </div>
            </section>

            <!-- SECCIÓN 2: INFORMACIÓN DEL PERMISO -->
            <section class="form-section">
                <h2>Información del Permiso</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" required class="highlight-field">
                    </div>
                    <div class="form-group">
                        <label for="dias">Tiempo en días</label>
                        <select id="dias" name="dias" required class="highlight-field">
                            <option value="3">3 DÍAS</option>
                            <option value="8">8 DÍAS</option>
                        </select>
                        <div id="fechaError" class="error-message" style="display: none;">EL TIEMPO DEBE SER DE 3 U 8 DÍAS EXACTAMENTE</div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_Fin">Fecha de finalización</label>
                        <input type="date" id="fecha_Fin" name="fecha_Fin" required class="highlight-field" readonly>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Tipo de Licencia:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="conRemuneracion" name="tipoLicencia" value="conRemuneracion" checked>
                                <label for="conRemuneracion">CON REMUNERACIÓN</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="sinRemuneracion" name="tipoLicencia" value="sinRemuneracion">
                                <label for="sinRemuneracion">SIN REMUNERACIÓN</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Hace uso en:</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="pais" name="lugarUso" value="pais" checked>
                                <label for="pais">EL PAÍS</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="exterior" name="lugarUso" value="exterior">
                                <label for="exterior">EL EXTERIOR</label>
                            </div>
                        </div>
                        <div id="ciudadPaisContainer" style="display: none; margin-top: 10px;">
                            <label for="ciudadPais">SEÑALE CIUDAD Y PAÍS:</label>
                            <input type="text" id="ciudadPais" name="ciudadPais" placeholder="EJ: MADRID, ESPAÑA" class="uppercase">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="motivo_causa">Motivo o causa:</label>
                    <textarea id="motivo_causa" name="motivo_causa" rows="3" placeholder="DESCRIBA EL MOTIVO O CAUSA DEL PERMISO" required class="highlight-field uppercase" style="width: 100%;"></textarea>
                </div>
            </section>

            <!-- SECCIÓN 3: FIRMAS DE RESPONSABILIDAD -->
            <section class="form-section">
                <h2>Firmas de Responsabilidad</h2>
                
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Servidor Policial</h3>
                        <label for="grado_ServidorPolicial">Grado</label>
                        <select id="grado_ServidorPolicial" name="grado_ServidorPolicial" required class="highlight-field uppercase">
                            <option value="">SELECCIONE UN GRADO</option>
                            <option value="Gral">GENERAL</option>
                            <option value="Crnl">CORONEL</option>
                            <option value="Tcnl">TENIENTE CORONEL</option>
                            <option value="Mayr">MAYOR</option>
                            <option value="Cptn">CAPITÁN</option>
                            <option value="Tnte">TENIENTE</option>
                            <option value="Sbte">SUBTENIENTE</option>
                            <option value="Sbom">SUBOFICIAL MAYOR</option>
                            <option value="Sbop">SUBOFICIAL PRIMERO</option>
                            <option value="Sbos">SUBOFICIAL SEGUNDO</option>
                            <option value="Sgop">SARGENTO PRIMERO</option>
                            <option value="Sgos">SARGENTO SEGUNDO</option>
                            <option value="Cbop">CABO PRIMERO</option>
                            <option value="Cbos">CABO SEGUNDO</option>
                            <option value="Poli">POLICÍA</option>
                        </select>
                        
                        <label for="Apellidos_Nombres_servidor" style="margin-top: 10px;">Apellidos y Nombres</label>
                        <input type="text" id="Apellidos_Nombres_servidor" name="Apellidos_Nombres_servidor" placeholder="APELLIDOS Y NOMBRES DEL SERVIDOR" required class="highlight-field uppercase">
                        
                        <label for="cedula_ServidorPolicial" style="margin-top: 10px;">C.C.</label>
                        <input type="text" id="cedula_ServidorPolicial" name="cedula_ServidorPolicial" placeholder="CÉDULA DEL SERVIDOR POLICIAL" required maxlength="10" pattern="[0-9]{10}" class="highlight-field uppercase">
                        <div id="cedulaServidorError" class="error-message" style="display: none;">LA CÉDULA DEBE TENER 10 DÍGITOS NUMÉRICOS</div>
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Analista/Asistente de Talento Humano</h3>
                        <label for="grado_AnAs">Grado</label>
                        <select id="grado_AnAs" name="grado_AnAs" required class="highlight-field uppercase">
                            <option value="">SELECCIONE UN GRADO</option>
                            <option value="Gral">GENERAL</option>
                            <option value="Crnl">CORONEL</option>
                            <option value="Tcnl">TENIENTE CORONEL</option>
                            <option value="Mayr">MAYOR</option>
                            <option value="Cptn">CAPITÁN</option>
                            <option value="Tnte">TENIENTE</option>
                            <option value="Sbte">SUBTENIENTE</option>
                            <option value="Sbom">SUBOFICIAL MAYOR</option>
                            <option value="Sbop">SUBOFICIAL PRIMERO</option>
                            <option value="Sbos">SUBOFICIAL SEGUNDO</option>
                            <option value="Sgop">SARGENTO PRIMERO</option>
                            <option value="Sgos">SARGENTO SEGUNDO</option>
                            <option value="Cbop">CABO PRIMERO</option>
                            <option value="Cbos">CABO SEGUNDO</option>
                            <option value="Poli">POLICÍA</option>
                        </select>
                        
                        <label for="Apellidos_Nombres_AnAs" style="margin-top: 10px;">Apellidos y Nombres</label>
                        <input type="text" id="Apellidos_Nombres_AnAs" name="Apellidos_Nombres_AnAs" placeholder="APELLIDOS Y NOMBRES DEL ANALISTA/ASISTENTE" required class="highlight-field uppercase">
                        
                        <label for="cedula_AnAs" style="margin-top: 10px;">C.C.</label>
                        <input type="text" id="cedula_AnAs" name="cedula_AnAs" placeholder="CÉDULA DEL ANALISTA/ASISTENTE" required maxlength="10" pattern="[0-9]{10}" class="highlight-field uppercase">
                        <div id="cedulaAnAsError" class="error-message" style="display: none;">LA CÉDULA DEBE TENER 10 DÍGITOS NUMÉRICOS</div>
                    </div>
                </div>
                
                <div class="form-row" style="margin-top: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Jefe de Administración de Talento Humano</h3>
                        <label for="grado_JfAd">Grado</label>
                        <select id="grado_JfAd" name="grado_JfAd" required class="highlight-field uppercase">
                            <option value="">SELECCIONE UN GRADO</option>
                            <option value="Gral">GENERAL</option>
                            <option value="Crnl">CORONEL</option>
                            <option value="Tcnl">TENIENTE CORONEL</option>
                            <option value="Mayr">MAYOR</option>
                            <option value="Cptn">CAPITÁN</option>
                            <option value="Tnte">TENIENTE</option>
                            <option value="Sbte">SUBTENIENTE</option>
                            <option value="Sbom">SUBOFICIAL MAYOR</option>
                            <option value="Sbop">SUBOFICIAL PRIMERO</option>
                            <option value="Sbos">SUBOFICIAL SEGUNDO</option>
                            <option value="Sgop">SARGENTO PRIMERO</option>
                            <option value="Sgos">SARGENTO SEGUNDO</option>
                            <option value="Cbop">CABO PRIMERO</option>
                            <option value="Cbos">CABO SEGUNDO</option>
                            <option value="Poli">POLICÍA</option>
                        </select>
                        
                        <label for="Apellidos_Nombres_JfAd" style="margin-top: 10px;">Apellidos y Nombres</label>
                        <input type="text" id="Apellidos_Nombres_JfAd" name="Apellidos_Nombres_JfAd" placeholder="APELLIDOS Y NOMBRES DEL JEFE" required class="highlight-field uppercase">
                        
                        <label for="cedula_JfAd" style="margin-top: 10px;">C.C.</label>
                        <input type="text" id="cedula_JfAd" name="cedula_JfAd" placeholder="CÉDULA DEL JEFE" required maxlength="10" pattern="[0-9]{10}" class="highlight-field uppercase">
                        <div id="cedulaJfAdError" class="error-message" style="display: none;">LA CÉDULA DEBE TENER 10 DÍGITOS NUMÉRICOS</div>
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Director / Comandante / Jefe de Unidad</h3>
                        <label for="grado_DctCdtJfund">Grado</label>
                        <select id="grado_DctCdtJfund" name="grado_DctCdtJfund" required class="highlight-field uppercase">
                            <option value="">SELECCIONE UN GRADO</option>
                            <option value="Gral">GENERAL</option>
                            <option value="Crnl">CORONEL</option>
                            <option value="Tcnl">TENIENTE CORONEL</option>
                            <option value="Mayr">MAYOR</option>
                            <option value="Cptn">CAPITÁN</option>
                            <option value="Tnte">TENIENTE</option>
                            <option value="Sbte">SUBTENIENTE</option>
                            <option value="Sbom">SUBOFICIAL MAYOR</option>
                            <option value="Sbop">SUBOFICIAL PRIMERO</option>
                            <option value="Sbos">SUBOFICIAL SEGUNDO</option>
                            <option value="Sgop">SARGENTO PRIMERO</option>
                            <option value="Sgos">SARGENTO SEGUNDO</option>
                            <option value="Cbop">CABO PRIMERO</option>
                            <option value="Cbos">CABO SEGUNDO</option>
                            <option value="Poli">POLICÍA</option>
                        </select>
                        
                        <label for="Apellidos_Nombres_DctCdtJfund" style="margin-top: 10px;">Apellidos y Nombres</label>
                        <input type="text" id="Apellidos_Nombres_DctCdtJfund" name="Apellidos_Nombres_DctCdtJfund" placeholder="APELLIDOS Y NOMBRES DEL DIRECTOR/COMANDANTE/JEFE" required class="highlight-field uppercase">
                        
                        <label for="cedula_DctCdtJfund" style="margin-top: 10px;">C.C.</label>
                        <input type="text" id="cedula_DctCdtJfund" name="cedula_DctCdtJfund" placeholder="CÉDULA DEL DIRECTOR/COMANDANTE/JEFE" required maxlength="10" pattern="[0-9]{10}" class="highlight-field uppercase">
                        <div id="cedulaDctCdtJfundError" class="error-message" style="display: none;">LA CÉDULA DEBE TENER 10 DÍGITOS NUMÉRICOS</div>
                    </div>
                </div>
                
                <!-- Campos ocultos para valores calculados -->
                <input type="hidden" id="miGrado" name="miGrado" value="">
                <input type="hidden" id="gradoPolicia" name="gradoPolicia" value="">
                <input type="hidden" id="numeroOficio1" name="numeroOficio1" value="">
                <input type="hidden" id="nombresSolicitante" name="nombresSolicitante" value="">
            </section>
            
            <div class="form-actions">
                <button type="submit" id="submitBtn" class="btn-form-action">Generar y Descargar Documento</button>
            </div>
        </form>
    </div>

    <script src="script_fpcd.js"></script>
</body>
</html>
