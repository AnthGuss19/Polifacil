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
          'otraCiudad2',
          'otraCiudad',
          'nombreFamiliar',
          'lugar',
          'anexoCustom',
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

  const form = document.getElementById("permisoForm")
  const submitBtn = document.getElementById("submitBtn")
  const ciudadSelect = document.getElementById("ciudad")
  const otraCiudadContainer = document.getElementById("otraCiudadContainer")
  const otraCiudadInput = document.getElementById("otraCiudad")
  const numeroOficio1 = document.getElementById("numeroOficio1")
  const distrito = document.getElementById("distrito")
  const gradoSuperiorSelect = document.getElementById("grado")
  const gradoGeneralSuperiorInput = document.getElementById("Grado_general_superior")

  // Elementos del solicitante
  const nombreSolicitanteInput = document.getElementById("nombreSolicitante")
  const inicialesSolicitanteInput = document.getElementById("iniciales_solicitante")
  const gradoSolicitanteSelect = document.getElementById("gradoSolicitante")

  // ELEMENTOS PARA HORA - CORREGIDOS
  const horasInput = document.getElementById("horas")
  const minutosInput = document.getElementById("minutos")
  const ampmSelect = document.getElementById("ampm")
  const horaFormateadaInput = document.getElementById("horaFormateada")
  const timeDisplay = document.getElementById("timeDisplay")

  // ELEMENTOS PARA ANEXO PERSONALIZADO - CORREGIDOS
  const anexoOptions = document.querySelectorAll(".anexo-option")
  const anexoCustomContainer = document.getElementById("anexoCustomContainer")
  const anexoCustomInput = document.getElementById("anexoCustom")

  // ELEMENTOS PARA CIUDAD 2 - CORREGIDOS
  const ciudadSelect2 = document.getElementById("ciudad2")
  const otraCiudadContainer2 = document.getElementById("otraCiudadContainer2")
  const otraCiudadInput2 = document.getElementById("otraCiudad2")

  // Formateo automático del número de oficio
  const numeroOficioInput = document.getElementById("numeroOficio2")

  if (numeroOficioInput) {
    numeroOficioInput.addEventListener("input", function () {
      let valor = this.value.replace(/\D/g, "") // Solo números
      if (valor.length > 4) {
        valor = valor.substring(0, 4)
      }
      this.value = valor
    })

    numeroOficioInput.addEventListener("blur", function () {
      let valor = this.value.replace(/\D/g, "")
      if (valor.length > 0) {
        valor = valor.padStart(4, "0")
        this.value = valor
      }
    })
  }
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

  // FUNCIÓN CORREGIDA: Formatear hora
  function formatearHora() {
    console.log("Ejecutando formatearHora...")

    if (!horasInput || !minutosInput || !ampmSelect || !horaFormateadaInput) {
      console.error("Elementos de hora no encontrados")
      return ""
    }

    const horas = Number.parseInt(horasInput.value) || 0
    const minutos = Number.parseInt(minutosInput.value) || 0
    const ampm = ampmSelect.value

    console.log("Valores de hora:", { horas, minutos, ampm })

    if (horas >= 1 && horas <= 12 && minutos >= 0 && minutos <= 59) {
      const horasStr = horas.toString().padStart(2, "0")
      const minutosStr = minutos.toString().padStart(2, "0")
      const horaFormateada = `${horasStr}:${minutosStr} ${ampm}`

      // CRÍTICO: Actualizar el campo oculto
      horaFormateadaInput.value = horaFormateada

      // Mostrar la hora formateada
      if (timeDisplay) {
        timeDisplay.textContent = `Hora seleccionada: ${horaFormateada}`
        timeDisplay.style.display = "block"
      }

      console.log("Hora formateada correctamente:", horaFormateada)
      console.log("Campo oculto actualizado:", horaFormateadaInput.value)
      return horaFormateada
    } else {
      horaFormateadaInput.value = ""
      if (timeDisplay) {
        timeDisplay.style.display = "none"
      }
      console.log("Hora inválida, campo limpiado")
      return ""
    }
  }

  // FUNCIÓN CORREGIDA: Manejo de anexo personalizado
  function manejarAnexoPersonalizado() {
    console.log("Configurando manejo de anexo personalizado...")

    if (!anexoCustomContainer || !anexoCustomInput) {
      console.error("Elementos de anexo personalizado no encontrados")
      return
    }

    // Event listeners para las opciones de anexo
    anexoOptions.forEach((option, index) => {
      console.log(`Configurando opción ${index}:`, option)

      option.addEventListener("click", function (e) {
        console.log("Click en opción de anexo:", this)

        // Remover selección previa
        anexoOptions.forEach((opt) => opt.classList.remove("selected"))

        // Seleccionar la opción actual
        this.classList.add("selected")

        // Marcar el radio button
        const radio = this.querySelector('input[type="radio"]')
        if (radio) {
          radio.checked = true
          console.log("Radio seleccionado:", radio.value)

          // Mostrar/ocultar campo personalizado
          if (radio.value === "OTRA") {
            anexoCustomContainer.classList.add("show")
            anexoCustomContainer.style.display = "block"
            anexoCustomInput.setAttribute("required", "required")
            console.log("Mostrando campo personalizado de anexo")
          } else {
            anexoCustomContainer.classList.remove("show")
            anexoCustomContainer.style.display = "none"
            anexoCustomInput.removeAttribute("required")
            anexoCustomInput.value = ""
            console.log("Ocultando campo personalizado de anexo")
          }
        }
      })
    })

    // Event listener directo para los radio buttons
    const radioButtons = document.querySelectorAll('input[name="respuesta_anexo"]')
    radioButtons.forEach((radio) => {
      radio.addEventListener("change", function () {
        console.log("Cambio en radio button:", this.value)

        if (this.value === "OTRA") {
          anexoCustomContainer.classList.add("show")
          anexoCustomContainer.style.display = "block"
          anexoCustomInput.setAttribute("required", "required")
          console.log("Campo personalizado mostrado via radio change")
        } else {
          anexoCustomContainer.classList.remove("show")
          anexoCustomContainer.style.display = "none"
          anexoCustomInput.removeAttribute("required")
          anexoCustomInput.value = ""
          console.log("Campo personalizado ocultado via radio change")
        }
      })
    })
  }

  // FUNCIÓN CORREGIDA: Manejo de ciudades
  function configurarCiudades() {
    // Ciudad 1 (encabezado)
    if (ciudadSelect && otraCiudadContainer && otraCiudadInput) {
      ciudadSelect.addEventListener("change", function () {
        console.log("Cambio en ciudad 1:", this.value)
        if (this.value === "OTRA") {
          otraCiudadContainer.style.display = "block"
          otraCiudadInput.setAttribute("required", "required")
          console.log("Mostrando campo otra ciudad 1")
        } else {
          otraCiudadContainer.style.display = "none"
          otraCiudadInput.removeAttribute("required")
          otraCiudadInput.value = ""
          console.log("Ocultando campo otra ciudad 1")
        }
      })
    }

    // Ciudad 2 (evento)
    if (ciudadSelect2 && otraCiudadContainer2 && otraCiudadInput2) {
      ciudadSelect2.addEventListener("change", function () {
        console.log("Cambio en ciudad 2:", this.value)
        if (this.value === "OTRA") {
          otraCiudadContainer2.style.display = "block"
          otraCiudadInput2.setAttribute("required", "required")
          console.log("Mostrando campo otra ciudad 2")
        } else {
          otraCiudadContainer2.style.display = "none"
          otraCiudadInput2.removeAttribute("required")
          otraCiudadInput2.value = ""
          console.log("Ocultando campo otra ciudad 2")
        }
      })
    }
  }

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

  // Event listeners para la hora - CORREGIDOS
  if (horasInput && minutosInput && ampmSelect) {
    console.log("Configurando event listeners para hora...")

    horasInput.addEventListener("input", formatearHora)
    horasInput.addEventListener("change", formatearHora)
    minutosInput.addEventListener("input", formatearHora)
    minutosInput.addEventListener("change", formatearHora)
    ampmSelect.addEventListener("change", formatearHora)

    // Validación de rangos
    horasInput.addEventListener("blur", function () {
      const valor = Number.parseInt(this.value)
      if (isNaN(valor) || valor < 1) this.value = "1"
      if (valor > 12) this.value = "12"
      formatearHora()
    })

    minutosInput.addEventListener("blur", function () {
      const valor = Number.parseInt(this.value)
      if (isNaN(valor) || valor < 0) this.value = "00"
      if (valor > 59) this.value = "59"
      if (this.value.length === 1) this.value = "0" + this.value
      formatearHora()
    })
  }

  // Event listeners para el solicitante
  if (nombreSolicitanteInput) {
    nombreSolicitanteInput.addEventListener("input", actualizarIniciales)
    nombreSolicitanteInput.addEventListener("blur", actualizarIniciales)
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
      const horaFinal = formatearHora()

      console.log("Valores antes del envío:")
      console.log("- Iniciales:", inicialesSolicitanteInput?.value)
      console.log("- Hora formateada:", horaFormateadaInput?.value)
      console.log("- Hora calculada:", horaFinal)

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

      // Verificar que la hora esté completa
      if (!horaFormateadaInput || !horaFormateadaInput.value) {
        alert("Error: Debe completar la hora del evento.")
        isValid = false
      }

      // Verificar anexo personalizado si está seleccionado
      const anexoOtraRadio = document.getElementById("anexoOtra")
      if (anexoOtraRadio && anexoOtraRadio.checked) {
        if (!anexoCustomInput || !anexoCustomInput.value.trim()) {
          alert("Error: Debe especificar el tipo de anexo.")
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
        console.log("Hora formateada final a enviar:", horaFormateadaInput.value)
        submitBtn.textContent = "Generando documento..."
        submitBtn.disabled = true
      }
    })
  }

  // INICIALIZACIÓN CORREGIDA
  setTimeout(() => {
    console.log("Ejecutando inicialización...")

    // Configurar ciudades
    configurarCiudades()

    // Inicializar manejo de anexo personalizado
    manejarAnexoPersonalizado()

    // Establecer valores por defecto para la hora
    if (horasInput && !horasInput.value) horasInput.value = "08"
    if (minutosInput && !minutosInput.value) minutosInput.value = "00"
    if (ampmSelect && !ampmSelect.value) ampmSelect.value = "AM"

    // Formatear hora inicial
    formatearHora()

    // Inicializar otros campos
    if (nombreSolicitanteInput && nombreSolicitanteInput.value) {
      actualizarIniciales()
    }

    if (distrito && distrito.value && numeroOficio1) {
      numeroOficio1.value = distrito.value
    }

    console.log("Inicialización completada")
  }, 100)

  console.log("Script inicializado completamente")
})
