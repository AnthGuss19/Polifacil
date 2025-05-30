<?php
if (!isset($plantilla_actual)) {
    header('Location: plantilla.php?tipo=vacaciones');
    exit;
}
?>
<a href="index.html" class="back-btn">← Volver a Plantillas</a>
<link rel="stylesheet" href="styles.css">
<h1><?php echo $plantilla_actual['titulo']; ?></h1>
<p class="description"><?php echo $plantilla_actual['descripcion']; ?></p>

    <div class="form-container">
    <div class="container">
        <form id="permisoForm" action="procesar_spcm.php" method="post">
            <section class="form-section">
                <h2>Información del Oficio</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="distrito">Distrito Policial</label>
                        <select id="distrito" name="distrito" required class="highlight-field">
                            <option value="">Seleccione un distrito</option>
                            <option value="DB">Babahoyo</option>
                            <option value="DM">Manta</option>
                            <option value="DTU">Tulcán</option>
                            <option value="DMF">Montúfar</option>
                            <option value="DES">Espejo</option>
                            <option value="DEM">Esmeraldas</option>
                            <option value="DEA">Eloy Alfaro</option>
                            <option value="DAT">Atacames</option>
                            <option value="DQU">Quinindé</option>
                            <option value="DSL">San Lorenzo</option>
                            <option value="DRV">Río Verde</option>
                            <option value="DCB">Ciudad Blanca</option>
                            <option value="DVA">Valle del Amanecer</option>
                            <option value="DTS">Tierra del Sol</option>
                            <option value="DSA">Samaniego</option>
                            <option value="DLA">Lago Agrio</option>
                            <option value="DPU">Putumayo</option>
                            <option value="DSH">Shushufindi</option>
                            <option value="DTA">Tarapoa</option>
                            <option value="DVQ">El Valle de Quijos</option>
                            <option value="DCA">Cayambe</option>
                            <option value="DMR">Mejía - Rumiñahui</option>
                            <option value="DNO">Noroccidente</option>
                            <option value="DJS">La Joya de los Sachas</option>
                            <option value="DLO">Loreto - Orellana</option>
                            <option value="DAG">Aguarico</option>
                            <option value="DRI">Riobamba</option>
                            <option value="DAL">Alausí</option>
                            <option value="DPA">Pallatanga</option>
                            <option value="DCO">Colta</option>
                            <option value="DGU">Guamote</option>
                            <option value="DLI">Lictoquigua</option>
                            <option value="DLM">La Maná</option>
                            <option value="DPG">Pangua</option>
                            <option value="DPJ">Pujilí</option>
                            <option value="DDZ">Danzak</option>
                            <option value="DSC">Salcedo</option>
                            <option value="DSQ">Saquisilí</option>
                            <option value="DPM">Pastaza - Mera - Santa Clara</option>
                            <option value="DAR">Arajuno</option>
                            <option value="DAN">Ambato Norte</option>
                            <option value="DAS">Ambato Sur</option>
                            <option value="DBA">Baños de Agua Santa</option>
                            <option value="DPT">Patate</option>
                            <option value="DSP">Santiago de Pillaro</option>
                            <option value="DQE">Quero</option>
                            <option value="DPO">Portoviejo</option>
                            <option value="DMN">Manta</option>
                            <option value="DJI">Jipijapa</option>
                            <option value="DEC">El Carmen</option>
                            <option value="DBO">Bolívar</option>
                            <option value="DCH">Chone</option>
                            <option value="DPI">Pichincha</option>
                            <option value="DPA">Paján</option>
                            <option value="DPE">Pedernales</option>
                            <option value="DSR">Sucre</option>
                            <option value="DRO">Rocafuerte</option>
                            <option value="DLC">La Concordia</option>
                            <option value="DGA">Guaranda</option>
                            <option value="DCI">Chillanes</option>
                            <option value="DSM">San Miguel</option>
                            <option value="DSU">Subtrópico</option>
                            <option value="DJB">Jujan - Simón Bolívar</option>
                            <option value="DNA">Naranjal</option>
                            <option value="DBL">Balao</option>
                            <option value="DPC">Pedro Carbo</option>
                            <option value="DTR">El Triunfo</option>
                            <option value="DMI">Milagro</option>
                            <option value="DNT">Naranjito</option>
                            <option value="DDA">Daule</option>
                            <option value="DSL">Salitre</option>
                            <option value="DYG">Yaguachi</option>
                            <option value="DPL">Playas</option>
                            <option value="DPV">Pueblo Viejo</option>
                            <option value="DQV">Quevedo</option>
                            <option value="DVE">Ventanas</option>
                            <option value="DVI">Vinces</option>
                            <option value="DBF">Buena Fe</option>
                            <option value="DGL">Galápagos</option>
                            <option value="DSE">Santa Elena</option>
                            <option value="DLL">La Libertad - Salinas</option>
                            <option value="DGN">Guayaquil Norte</option>
                            <option value="DCS">Cuenca Sur</option>
                            <option value="DGI">Girón</option>
                            <option value="DGL">Gualaceo</option>
                            <option value="DNA">Nabón</option>
                            <option value="DPA">Paute</option>
                            <option value="DCP">Camilo Ponce Enríquez</option>
                            <option value="DSG">Sigsig</option>
                            <option value="DAZ">Azogues</option>
                            <option value="DCA">Cañar</option>
                            <option value="DET">El Tambo</option>
                            <option value="DMO">Morona</option>
                            <option value="DSU">Sucúa</option>
                            <option value="DCS">Centro Sur</option>
                            <option value="DSR">Sur</option>
                            <option value="DTA">Taisha</option>
                            <option value="DME">Méndez</option>
                            <option value="DPA">Palora</option>
                            <option value="DHU">Huamboya</option>
                            <option value="DPA">Pastaza</option>
                            <option value="DPI">Pillaro</option>
                            <option value="DHQ">Huaquillas</option>
                            <option value="DSR">Santa Rosa</option>
                            <option value="DLO">Loja</option>
                            <option value="DCA">Catamayo</option>
                            <option value="DCR">Cariamanga</option>
                            <option value="DCT">Catacocha</option>
                            <option value="DSG">Saraguro</option>
                            <option value="DLI">Lojaindalo</option>
                            <option value="DCL">Calvas</option>
                            <option value="DMA">Macará</option>
                            <option value="DZA">Zamora</option>
                            <option value="DPQ">Paquisha</option>
                            <option value="DCH">Chinchipe</option>
                            <option value="DYA">Yantzaza</option>
                            <option value="DON">Oña Doturibe</option>
                            <option value="DCE">Celica</option>
                            <option value="DEO">El Oro</option>
                            <option value="DNP">Nueva Prosperina</option>
                            <option value="DFL">Florida</option>
                            <option value="DPA">Pascuales</option>
                            <option value="DSB">Samborondón</option>
                            <option value="DDU">Durán</option>
                            <option value="DNO">Norte</option>
                            <option value="DSR">Sur</option>
                            <option value="DMO">Modelo</option>
                            <option value="DPR">Pradera</option>
                            <option value="DCA">Calderón</option>
                            <option value="DLD">La Delicia</option>
                            <option value="DEA">Eloy Alfaro</option>
                            <option value="DEE">Eugenio Espejo</option>
                            <option value="DLC">Los Chillos</option>
                            <option value="DQU">Quitumbe</option>
                            <option value="DNA">Nanegal</option>
                            <option value="DTU">Tumbaco</option>
                            <option value="DMS">Manuela Sáenz</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numeroOficio2">Número Oficio</label>
                        <input type="text" id="numeroOficio2" name="numeroOficio2" placeholder="Ej: 10, 100, 1000" required maxlength="4" class="highlight-field" inputmode="numeric">
                        <small class="help-text">Ingrese cualquier número (1-9999). Se completará automáticamente con ceros (ej: 10 → 0010, 100 → 0100)</small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <select id="ciudad" name="ciudad" required class="highlight-field">
                        <option value="">Seleccione una ciudad</option>
                        <option value="Quito">Quito</option>
                        <option value="Guayaquil">Guayaquil</option>
                        <option value="Cuenca">Cuenca</option>
                        <option value="Manta">Manta</option>
                        <option value="Babahoyo">Babahoyo</option>
                        <option value="Machala">Machala</option>
                        <option value="Santo Domingo">Santo Domingo</option>
                        <option value="Tulcán">Tulcán</option>
                        <option value="Ibarra">Ibarra</option>
                        <option value="Loja">Loja</option>
                        <option value="Macas">Macas</option>
                        <option value="Portoviejo">Portoviejo</option>
                        <option value="Riobamba">Riobamba</option>
                        <option value="Salinas">Salinas</option>
                        <option value="Tena">Tena</option>
                        <option value="Zamora">Zamora</option>
                        <option value="Santa Elena">Santa Elena</option>
                        <option value="Latacunga">Latacunga</option>
                        <option value="Ambato">Ambato</option>
                        <option value="Orellana">Orellana</option>
                        <option value="Puyo">Puyo</option>
                        <option value="Morona">Morona</option>
                        <option value="Bahía de Caráquez">Bahía de Caráquez</option>
                        <option value="Jipijapa">Jipijapa</option>
                        <option value="Ventanas">Ventanas</option>
                        <option value="OTRA">Otra (Especifique)</option>
                    </select>
                    <div id="otraCiudadContainer" style="display: none;"><br>
                        <label for="otraCiudad">Especifique la ciudad:</label>
                        <input type="text" id="otraCiudad" name="otraCiudad" placeholder="Ingrese el nombre de la ciudad ¡Recuerde! la Primera letra con Mayúscula">
                    </div>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" required class="highlight-field">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="grado">Grado del Superior:</label>
                        <select id="grado" name="grado" required class="highlight-field">
                            <option value="">Seleccione un grado</option>
                            <option value="Gral">General</option>
                            <option value="Crnl">Coronel</option>
                            <option value="Tcnl">Teniente Coronel</option>
                            <option value="Mayr">Mayor</option>
                            <option value="Cptn">Capitán</option>
                            <option value="Tnte">Teniente</option>
                            <option value="Sbte">Subteniente</option>
                            <option value="Sbom">Suboficial Mayor</option>
                            <option value="Sbop">Suboficial Primero</option>
                            <option value="Sbos">Suboficial Segundo</option>
                            <option value="Sgop">Sargento Primero</option>
                            <option value="Sgos">Sargento Segundo</option>
                            <option value="Cbop">Cabo Primero</option>
                            <option value="Cbos">Cabo Segundo</option>
                            <option value="Poli">Policía</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombreApellidos">Nombres y Apellidos</label>
                        <input type="text" id="nombreApellidos" name="nombreApellidos" placeholder="Ingrese sus nombres y apellidos" required class="highlight-field">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="text" id="cargo" name="cargo" required placeholder="Ej: JEFE DE TALENTO HUMANO" class="highlight-field">
                </div>
            </section>

            <section class="form-section">
                <h2>Datos del Solicitante</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="gradoSolicitante">Grado del Solicitante:</label>
                        <select id="gradoSolicitante" name="gradoSolicitante" required class="highlight-field">
                            <option value="">Seleccione un grado</option>
                            <option value="General de Policia">General</option>
                            <option value="Coronel de Policia">Coronel</option>
                            <option value="Teniente Coronel de Policia">Teniente Coronel</option>
                            <option value="Mayor de Policia">Mayor</option>
                            <option value="Capitán de Policia">Capitán</option>
                            <option value="Teniente de Policia">Teniente</option>
                            <option value="Subteniente de Policia">Subteniente</option>
                            <option value="Suboficial Mayor de Policia">Suboficial Mayor</option>
                            <option value="Suboficial Primero de Policia">Suboficial Primero</option>
                            <option value="Suboficial Segundo de Policia">Suboficial Segundo</option>
                            <option value="Sargento Primero de Policia">Sargento Primero</option>
                            <option value="Sargento Segundo de Policia">Sargento Segundo</option>
                            <option value="Cabo Primero de Policia">Cabo Primero</option>
                            <option value="Cabo Segundo de Policia">Cabo Segundo</option>
                            <option value="Policía Nacional">Policía</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombreSolicitante">Nombres y Apellidos del Solicitante</label>
                        <input type="text" id="nombreSolicitante" name="nombreSolicitante" placeholder="Ingrese sus nombres y apellidos" required class="highlight-field">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cargoSolicitante">Cargo del Solicitante</label>
                    <input type="text" id="cargoSolicitante" name="cargoSolicitante" required 
                        placeholder="Ej: AGENTE DE POLICÍA" class="highlight-field"
                        oninput="this.value = this.value.toUpperCase()">
                </div>
            </section>

            <section class="form-section">
                <h2>Motivo de la Solicitud</h2>
                <div class="form-group">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fechaInicio">Fecha del evento</label>
                            <input type="date" id="fechaInicio" name="fechaInicio" required class="highlight-field">
                        </div>
                        <div class="form-group">
                            <label for="horaEvento">Hora del evento</label>
                            <div class="time-picker-container">
                                <div class="time-input-group">
                                    <input type="number" id="horas" class="time-input" min="1" max="12" placeholder="12" required>
                                    <span class="time-separator">:</span>
                                    <input type="number" id="minutos" class="time-input" min="0" max="59" placeholder="00" required>
                                    <select id="ampm" class="ampm-selector">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <div id="timeDisplay" class="time-display" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ciudad2">Ciudad del evento</label>
                        <select id="ciudad2" name="ciudad2" required class="highlight-field">
                            <option value="">Seleccione una ciudad</option>
                            <option value="Quito">Quito</option>
                            <option value="Guayaquil">Guayaquil</option>
                            <option value="Cuenca">Cuenca</option>
                            <option value="Manta">Manta</option>
                            <option value="Babahoyo">Babahoyo</option>
                            <option value="Machala">Machala</option>
                            <option value="Santo Domingo">Santo Domingo</option>
                            <option value="Tulcán">Tulcán</option>
                            <option value="Ibarra">Ibarra</option>
                            <option value="Loja">Loja</option>
                            <option value="Macas">Macas</option>
                            <option value="Portoviejo">Portoviejo</option>
                            <option value="Riobamba">Riobamba</option>
                            <option value="Salinas">Salinas</option>
                            <option value="Tena">Tena</option>
                            <option value="Zamora">Zamora</option>
                            <option value="Santa Elena">Santa Elena</option>
                            <option value="Latacunga">Latacunga</option>
                            <option value="Ambato">Ambato</option>
                            <option value="Orellana">Orellana</option>
                            <option value="Puyo">Puyo</option>
                            <option value="Morona">Morona</option>
                            <option value="Bahía de Caráquez">Bahía de Caráquez</option>
                            <option value="Jipijapa">Jipijapa</option>
                            <option value="Ventanas">Ventanas</option>
                            <option value="OTRA">Otra (Especifique)</option>
                        </select>
                        <div id="otraCiudadContainer2" style="display: none;">
                            <label for="otraCiudad2">Especifique la ciudad:</label>
                            <input type="text" id="otraCiudad2" name="otraCiudad2" placeholder="Ingrese el nombre de la ciudad ¡Recuerde! la Primera letra con Mayúscula">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lugar">Lugar:</label>
                        <textarea id="lugar" name="lugar" rows="3" placeholder="Describa el Lugar" required class="highlight-field" style="width: 100%;"></textarea>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <h2>Respuesta de Anexo</h2>
                <div class="form-group">
                    <label>Seleccione el tipo de respuesta de anexo:</label>
                    <div class="anexo-container">
                        <div class="anexo-options">
                            <div class="anexo-option" data-value="Comprobante de cita">
                                <input type="radio" id="anexo1" name="respuesta_anexo" value="Comprobante de Cita">
                                <label for="anexo2">Comprobante de cita</label>
                            </div>
                            <div class="anexo-option" data-value="Orden de hospitalización">
                                <input type="radio" id="anexo2" name="respuesta_anexo" value="Orden de Hospitalización">
                                <label for="anexo5">Orden Medico</label>
                            </div>
                            <div class="anexo-option" data-value="OTRA">
                                <input type="radio" id="anexoOtra" name="respuesta_anexo" value="OTRA">
                                <label for="anexoOtra">Otra (Especifique)</label><br>
                            </div>
                        </div>
                        <div id="anexoCustomContainer" class="anexo-custom">
                            <label for="anexoCustom">Especifique el tipo de anexo:</label>
                            <input type="text" id="anexoCustom" name="anexo_custom" placeholder="Ingrese el tipo de anexo" class="highlight-field">
                        </div>
                    </div>
                </div>
            </section>
                
            <!-- Campos ocultos para valores calculados -->
            <input type="hidden" id="numeroOficio1" name="numeroOficio1" value="">
            <input type="hidden" id="motivo" name="motivo" value="CITA MÉDICA">
            <input type="hidden" id="iniciales_solicitante" name="iniciales_solicitante" value="">
            <input type="hidden" id="horaFormateada" name="horaFormateada" value="">
            <input type="hidden" id="Grado_general_superior" name="Grado_general_superior" value="">

            <div class="form-actions">
                <button type="submit" id="submitBtn" class="btn-form-action">Generar Documento</button>
            </div>
            
        </form>
    </div>

    <script src="script_spcm.js"></script>
</body>
</html>
