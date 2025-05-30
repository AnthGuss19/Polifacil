document.addEventListener("DOMContentLoaded", () => {
  console.log("Script cargado correctamente");

  // Función para capitalizar la primera letra de cada palabra
  function capitalizarPrimeraLetra(texto) {
      if (!texto) return texto;
      return texto.toLowerCase().replace(/(?:^|\s)\S/g, function(letra) {
          return letra.toUpperCase();
      });
  }

  // Función para convertir todo a mayúsculas
  function convertirAMayusculas(texto) {
      if (!texto) return texto;
      return texto.toUpperCase();
  }

  // Configurar event listeners para los campos específicos
  function configurarFormatosDeTexto() {
      // Campos con primera letra mayúscula
      const camposCapitalizados = [
          'nombreApellidos',
          'cargo',
          'nombreFamiliar',
          'nombreSolicitante'
      ];

      // Campo con todo mayúsculas
      const campoMayusculas = 'cargoSolicitante';

      // Configurar eventos para campos capitalizados
      camposCapitalizados.forEach(id => {
          const campo = document.getElementById(id);
          if (campo) {
              campo.addEventListener('blur', function() {
                  this.value = capitalizarPrimeraLetra(this.value);
              });
              // También convertir mientras se escribe para mejor experiencia
              campo.addEventListener('input', function() {
                  if (this.value.length > 0) {
                      const posicionCursor = this.selectionStart;
                      this.value = capitalizarPrimeraLetra(this.value);
                      this.setSelectionRange(posicionCursor, posicionCursor);
                  }
              });
          }
      });

      // Configurar eventos para campo en mayúsculas
      const campoMayus = document.getElementById(campoMayusculas);
      if (campoMayus) {
          campoMayus.addEventListener('blur', function() {
              this.value = convertirAMayusculas(this.value);
          });
          // También convertir mientras se escribe
          campoMayus.addEventListener('input', function() {
              this.value = convertirAMayusculas(this.value);
          });
      }
  }

  // Llamar a la función de configuración
  configurarFormatosDeTexto();

  // Resto del código existente...
  const form = document.getElementById("permisoForm");
  const submitBtn = document.getElementById("submitBtn");
  const ciudadSelect = document.getElementById("ciudad")
  const otraCiudadContainer = document.getElementById("otraCiudadContainer")
  const otraCiudadInput = document.getElementById("otraCiudad")
  const numeroOficio1 = document.getElementById("numeroOficio1")
  const distrito = document.getElementById("distrito")

  // Elementos del solicitante
  const nombreSolicitanteInput = document.getElementById("nombreSolicitante")
  const inicialesSolicitanteInput = document.getElementById("iniciales_solicitante")
  const gradoSolicitanteSelect = document.getElementById("gradoSolicitante")
  const gradoSolicitanteInput = document.getElementById("miGrado_solicitante")
  const gradoSuperiorSelect = document.getElementById("grado")
  const gradoGeneralSuperiorInput = document.getElementById("Grado_general_superior")

  // Elementos de calamidad
  const fallecioRadio = document.getElementById("fallecio")
  const hospitalizadoRadio = document.getElementById("hospitalizado")
  const motivoInput = document.getElementById("motivo")

  // Elementos de certificado
  const certDefuncion = document.getElementById("certDefuncion")
  const certHospitalizacion = document.getElementById("certHospitalizacion")
  const presentaraCertificado = document.getElementById("presentaraCertificado")
  const tipoCertificadoContainer = document.getElementById("tipoCertificadoContainer")
  const certificadoInput = document.getElementById("certificado")

  // Elementos para cálculo de días
  const familiarSelect = document.getElementById("familiar")
  const gradoPoliciaInput = document.getElementById("gradoPolicia")

  // Elementos de anexo
  const anexoInput = document.getElementById("anexo")
  const respuestaAnexoInput = document.getElementById("respuesta_anexo")

  // FORMATEO CORREGIDO del número de oficio
  const numeroOficioInput = document.getElementById("numeroOficio2")

  if (numeroOficioInput) {
    numeroOficioInput.addEventListener("input", function () {
      let valor = this.value

      // Permitir solo números y limitar a 4 caracteres
      valor = valor.replace(/[^0-9]/g, "")

      // Limitar a 4 dígitos máximo
      if (valor.length > 4) {
        valor = valor.substring(0, 4)
      }

      this.value = valor
    })

    // Validación al perder el foco - asegurar que tenga 4 dígitos
    numeroOficioInput.addEventListener("blur", function () {
      let valor = this.value.replace(/[^0-9]/g, "")

      if (valor.length > 0) {
        // Si tiene menos de 4 dígitos, rellenar con ceros al inicio
        if (valor.length < 4) {
          valor = valor.padStart(4, "0")
        }
        this.value = valor
      }
    })

    // Permitir pegar números con ceros al inicio
    numeroOficioInput.addEventListener("paste", function (e) {
      e.preventDefault()
      const pastedData = (e.clipboardData || window.clipboardData).getData("text")
      let valor = pastedData.replace(/[^0-9]/g, "")

      if (valor.length > 4) {
        valor = valor.substring(0, 4)
      }

      this.value = valor
    })
  }

  // Diccionario de grados completos
  const gradosCompletos = {
    Gral: "General",
    Crnl: "Coronel",
    Tcnl: "Teniente Coronel",
    Mayr: "Mayor",
    Cptn: "Capitán",
    Tnte: "Teniente",
    Sbte: "Subteniente",
    Sbom: "Suboficial Mayor",
    Sbop: "Suboficial Primero",
    Sbos: "Suboficial Segundo",
    Sgop: "Sargento Primero",
    Sgos: "Sargento Segundo",
    Cbop: "Cabo Primero",
    Cbos: "Cabo Segundo",
    Poli: "Policía",
  }
  // Agregar esta función para actualizar el grado del superior
  function actualizarGradoSuperior() {
      if (gradoSuperiorSelect && gradoGeneralSuperiorInput) {
          const gradoAbrev = gradoSuperiorSelect.value
          const gradoCompleto = gradosCompletos[gradoAbrev] || ""
          
          gradoGeneralSuperiorInput.value = gradoCompleto
          console.log("Grado superior actualizado:", {
              abreviatura: gradoAbrev,
              completo: gradoCompleto
          })
      }
  }

  // Agregar este event listener para el grado del superior
  if (gradoSuperiorSelect) {
      gradoSuperiorSelect.addEventListener("change", actualizarGradoSuperior)
  }

  // En la sección de inicialización, agregar:
  setTimeout(() => {
      // ... código existente ...
      
      if (gradoSuperiorSelect && gradoSuperiorSelect.value) {
          actualizarGradoSuperior()
      }
  }, 100)
  
  // Función para generar iniciales
  function generarIniciales(nombreCompleto) {
    if (!nombreCompleto || nombreCompleto.trim() === "") return ""

    const palabras = nombreCompleto.trim().split(/\s+/)
    let iniciales = ""

    for (let i = 0; i < palabras.length; i++) {
      if (palabras[i].length > 0) {
        iniciales += palabras[i][0].toUpperCase()
      }
    }

    return iniciales
  }

  // Función para actualizar iniciales
  function actualizarIniciales() {
    if (nombreSolicitanteInput && inicialesSolicitanteInput) {
      const nombre = nombreSolicitanteInput.value
      const iniciales = generarIniciales(nombre)
      inicialesSolicitanteInput.value = iniciales
      console.log("Iniciales actualizadas:", iniciales)
    }
  }

  

  // FUNCIÓN CORREGIDA: Sincronización automática entre calamidad y certificado
  function sincronizarCertificadoConCalamidad() {
    console.log("Sincronizando certificado con calamidad...")

    if (fallecioRadio && fallecioRadio.checked) {
      console.log("Calamidad: FALLECIO - Seleccionando certificado de defunción")
      if (certDefuncion) {
        certDefuncion.checked = true
        if (certHospitalizacion) certHospitalizacion.checked = false
      }
    } else if (hospitalizadoRadio && hospitalizadoRadio.checked) {
      console.log("Calamidad: HOSPITALIZADO - Seleccionando certificado de hospitalización")
      if (certHospitalizacion) {
        certHospitalizacion.checked = true
        if (certDefuncion) certDefuncion.checked = false
      }
    }

    // Actualizar el texto del certificado después de la sincronización
    actualizarCertificado()
  }

  // Event listeners para el solicitante
  if (nombreSolicitanteInput) {
    nombreSolicitanteInput.addEventListener("input", actualizarIniciales)
    nombreSolicitanteInput.addEventListener("blur", actualizarIniciales)
  }

  if (gradoSolicitanteSelect) {
    gradoSolicitanteSelect.addEventListener("change", function () {
      console.log("Grado seleccionado:", this.value)
      actualizarGrado()
    })
  }

  // EVENTOS CORREGIDOS: Calamidad con sincronización automática
  if (fallecioRadio) {
    fallecioRadio.addEventListener("change", function () {
      if (this.checked) {
        console.log("Seleccionado: FALLECIO")
        if (motivoInput) motivoInput.value = this.value

        // Si la sección de certificados está visible, sincronizar inmediatamente
        if (tipoCertificadoContainer.style.display !== "none") {
          sincronizarCertificadoConCalamidad()
        }
      }
    })
  }

  if (hospitalizadoRadio) {
    hospitalizadoRadio.addEventListener("change", function () {
      if (this.checked) {
        console.log("Seleccionado: HOSPITALIZADO")
        if (motivoInput) motivoInput.value = this.value

        // Si la sección de certificados está visible, sincronizar inmediatamente
        if (tipoCertificadoContainer.style.display !== "none") {
          sincronizarCertificadoConCalamidad()
        }
      }
    })
  }

  // Mostrar/ocultar campo "Otra ciudad"
  if (ciudadSelect && otraCiudadContainer && otraCiudadInput) {
    ciudadSelect.addEventListener("change", function () {
      if (this.value === "OTRA") {
        otraCiudadContainer.style.display = "block"
        otraCiudadInput.setAttribute("required", "required")
      } else {
        otraCiudadContainer.style.display = "none"
        otraCiudadInput.removeAttribute("required")
      }
    })
  }

  // Calcular días de permiso según familiar
  if (familiarSelect && gradoPoliciaInput) {
    familiarSelect.addEventListener("change", function () {
      const valor = this.value.toUpperCase()
      let gradoPolicia = 0

      const grupo8 = ["MADRE", "PADRE", "HIJO", "HIJA", "ENTENADO", "ENTENADA", "ESPOSA", "ESPOSO", "SUEGRA", "SUEGRO"]
      const grupo3 = ["ABUELO", "ABUELA", "CUÑADO", "CUÑADA", "HERMANO", "HERMANA"]

      if (grupo8.includes(valor)) {
        gradoPolicia = 8
      } else if (grupo3.includes(valor)) {
        gradoPolicia = 3
      }

      gradoPoliciaInput.value = gradoPolicia
      console.log("Días de permiso calculados:", gradoPolicia)
    })
  }

  // FUNCIÓN CORREGIDA: Actualizar certificado
  function actualizarCertificado() {
    if (!certificadoInput || !presentaraCertificado) return

    let tipoCertificado = ""
    const opcionCertificado = presentaraCertificado.value

    // Determinar el tipo de certificado basado en la selección
    if (certDefuncion && certDefuncion.checked) {
      tipoCertificado = "el certificado de defunción"
    } else if (certHospitalizacion && certHospitalizacion.checked) {
      tipoCertificado = "el certificado de hospitalización"
    }

    let textoCertificado = ""
    let anexoTexto = ""
    let respuestaAnexoTexto = ""

    if (opcionCertificado === "opcion1" && tipoCertificado) {
      textoCertificado = "por lo antes expuesto me permito adjuntar " + tipoCertificado
      // Configurar anexo cuando se presenta certificado
      anexoTexto = "Anexo:"
      if (certDefuncion && certDefuncion.checked) {
        respuestaAnexoTexto = "- Certificado de defunción"
      } else if (certHospitalizacion && certHospitalizacion.checked) {
        respuestaAnexoTexto = "- Certificado de hospitalización"
      }
    } else if (opcionCertificado === "opcion2" && tipoCertificado) {
      textoCertificado =
        "cabe indicar que posterior de culminar con los trámites respectivos haré llegar " + tipoCertificado
      // No hay anexo cuando se presentará después
      anexoTexto = ""
      respuestaAnexoTexto = ""
    } else {
      // No se presenta certificado
      anexoTexto = ""
      respuestaAnexoTexto = ""
    }

    certificadoInput.value = textoCertificado

    // Actualizar campos de anexo
    if (anexoInput) anexoInput.value = anexoTexto
    if (respuestaAnexoInput) respuestaAnexoInput.value = respuestaAnexoTexto

    console.log("Texto del certificado actualizado:", textoCertificado)
    console.log("Anexo actualizado:", anexoTexto)
    console.log("Respuesta anexo actualizada:", respuestaAnexoTexto)
  }

  // EVENTOS CORREGIDOS: Certificado con sincronización automática
  if (presentaraCertificado && tipoCertificadoContainer) {
    presentaraCertificado.addEventListener("change", function () {
      if (this.value !== "") {
        tipoCertificadoContainer.style.display = "block"
        console.log("Mostrando sección de certificados")

        // Sincronizar certificado según la calamidad seleccionada
        sincronizarCertificadoConCalamidad()
      } else {
        tipoCertificadoContainer.style.display = "none"
        if (certificadoInput) certificadoInput.value = ""
        console.log("Ocultando sección de certificados")
      }
    })
  }

  // Event listeners para los radio buttons de certificado
  if (certDefuncion) {
    certDefuncion.addEventListener("change", function () {
      if (this.checked) {
        console.log("Certificado de defunción seleccionado manualmente")
        actualizarCertificado()
      }
    })
  }

  if (certHospitalizacion) {
    certHospitalizacion.addEventListener("change", function () {
      if (this.checked) {
        console.log("Certificado de hospitalización seleccionado manualmente")
        actualizarCertificado()
      }
    })
  }

  // Actualizar número de oficio según distrito
  if (distrito && numeroOficio1) {
    distrito.addEventListener("change", function () {
      numeroOficio1.value = this.value
      console.log("Distrito actualizado:", this.value)
    })
  }

  // Establecer fecha actual
  const today = new Date()
  const formattedDate = today.toISOString().substr(0, 10)
  const fechaInput = document.getElementById("fecha")
  const fechaInicioInput = document.getElementById("fechaInicio")

  if (fechaInput) {
    fechaInput.value = formattedDate
  }

  if (fechaInicioInput) {
    fechaInicioInput.value = formattedDate
  }

  // VALIDACIÓN CORREGIDA del formulario
  if (form && submitBtn) {
    form.addEventListener("submit", (event) => {
      console.log("Enviando formulario...")

      // Actualizar todos los campos antes del envío
      actualizarIniciales()
      actualizarGrado()

      // Actualizar motivo si hay calamidad seleccionada
      if (fallecioRadio && fallecioRadio.checked && motivoInput) {
        motivoInput.value = fallecioRadio.value
      } else if (hospitalizadoRadio && hospitalizadoRadio.checked && motivoInput) {
        motivoInput.value = hospitalizadoRadio.value
      }

      // Asegurar sincronización final del certificado
      if (tipoCertificadoContainer.style.display !== "none") {
        sincronizarCertificadoConCalamidad()
      }

      // VALIDACIÓN ESPECÍFICA: Verificar que Grado_general tenga valor
      if (!gradoGeneralInput || !gradoGeneralInput.value.trim()) {
        alert("Error: El grado del solicitante no se estableció correctamente. Por favor, seleccione un grado.")
        if (gradoSolicitanteSelect) gradoSolicitanteSelect.focus()
        event.preventDefault()
        return
      }

      // Validar que el número de oficio tenga exactamente 4 dígitos
      if (numeroOficioInput && numeroOficioInput.value.length !== 4) {
        alert("El número de oficio debe tener exactamente 4 dígitos.")
        numeroOficioInput.focus()
        event.preventDefault()
        return
      }

      // Validar campos requeridos
      let isValid = true
      const requiredFields = form.querySelectorAll("[required]")

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false
          field.classList.add("error-field")
          console.log("Campo requerido vacío:", field.name || field.id)
        } else {
          field.classList.remove("error-field")
        }
      })

      // Verificar campos críticos específicos
      if (!inicialesSolicitanteInput || !inicialesSolicitanteInput.value) {
        alert("Error: Las iniciales del solicitante no se generaron. Verifique el nombre.")
        isValid = false
      }

      if (!gradoSolicitanteInput || !gradoSolicitanteInput.value) {
        alert("Error: El grado del solicitante no se estableció. Verifique la selección.")
        isValid = false
      }

      // Verificar que se haya seleccionado una calamidad
      if (!fallecioRadio.checked && !hospitalizadoRadio.checked) {
        alert("Error: Debe seleccionar un tipo de calamidad.")
        isValid = false
      }

      // Verificar certificado si se va a presentar
      if (presentaraCertificado.value !== "" && tipoCertificadoContainer.style.display !== "none") {
        if (!certDefuncion.checked && !certHospitalizacion.checked) {
          alert("Error: Debe seleccionar un tipo de certificado.")
          isValid = false
        }
      }

      if (!isValid) {
        event.preventDefault()
        alert("Por favor, complete todos los campos obligatorios.")
        submitBtn.textContent = "Generar Documento"
        submitBtn.disabled = false
      } else {
        console.log("Formulario válido, enviando...")
        console.log("Valores finales:")
        console.log("- Grado_general:", gradoGeneralInput.value)
        console.log("- miGrado_solicitante:", gradoSolicitanteInput.value)
        console.log("- iniciales_solicitante:", inicialesSolicitanteInput.value)
        submitBtn.textContent = "Generando documento..."
        submitBtn.disabled = true
      }
    })
  }

  // INICIALIZACIÓN CORREGIDA: Ejecutar actualizaciones iniciales
  setTimeout(() => {
    console.log("Ejecutando inicialización...")

    if (nombreSolicitanteInput && nombreSolicitanteInput.value) {
      actualizarIniciales()
    }
    if (gradoSolicitanteSelect && gradoSolicitanteSelect.value) {
      actualizarGrado()
    }
    if (distrito && distrito.value) {
      numeroOficio1.value = distrito.value
    }

    // Verificar estado inicial de certificados
    if (tipoCertificadoContainer && presentaraCertificado && presentaraCertificado.value !== "") {
      tipoCertificadoContainer.style.display = "block"
      sincronizarCertificadoConCalamidad()
    }

    // NUEVO: Forzar actualización de grado si hay un valor preseleccionado
    if (gradoSolicitanteSelect && gradoSolicitanteSelect.value) {
      console.log("Forzando actualización de grado en inicialización...")
      actualizarGrado()
    }
  }, 100)

  console.log("Script inicializado completamente")
})
