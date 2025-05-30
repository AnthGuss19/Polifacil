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
          'otraCiudad',
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

  const form = document.getElementById("permisoForm")
  const submitBtn = document.getElementById("submitBtn")

  // Elementos de ciudad
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

  // Elementos de días y fechas
  const diasSelect = document.getElementById("dias")
  const fechaSeleccionadaInput = document.getElementById("fechaSeleccionada")
  const fechaPreview = document.getElementById("fechaPreview")
  const fechaTexto = document.getElementById("fechaTexto")
  const fechaSeleccionadaFormateadaInput = document.getElementById("fechaSeleccionadaFormateada")
  const diasnumeroInput = document.getElementById("diasnumero")

  // Elementos del motivo de felicitación
  const motivoRadios = document.querySelectorAll('input[name="Motivo_felicitacion"]')
  const motivoPreview = document.getElementById("motivoPreview")
  const motivoTexto = document.getElementById("motivoTexto")
  const controlOpcionalSelect = document.getElementById("controlOpcional");
  const opcionalHiddenInput = document.getElementById("opcional");

  // Formateo del número de oficio
  const numeroOficioInput = document.getElementById("numeroOficio2")

  // Formateo del número del memorando
  const numeroInput = document.getElementById("numero")
  const numeroFormateadoInput = document.getElementById("numeroFormateado")
  
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
  // Meses en español
  const meses = [
    "enero",
    "febrero",
    "marzo",
    "abril",
    "mayo",
    "junio",
    "julio",
    "agosto",
    "septiembre",
    "octubre",
    "noviembre",
    "diciembre",
  ]

  // Función para convertir días a número
  function convertirDiasANumero(diasTexto) {
    switch (diasTexto) {
      case "UN DIA":
        return "1"
      case "DOS DIAS":
        return "2"
      default:
        return ""
    }
  }

  // Función para formatear fecha en español
  function formatearFechaEspanol(fecha) {
    const fechaObj = new Date(fecha + "T00:00:00")
    const dia = fechaObj.getDate()
    const mes = meses[fechaObj.getMonth()]
    const año = fechaObj.getFullYear()
    return `${dia} de ${mes} de ${año}`
  }

  // Función para calcular el día siguiente
  function obtenerDiaSiguiente(fecha) {
    const fechaObj = new Date(fecha + "T00:00:00")
    fechaObj.setDate(fechaObj.getDate() + 1)
    return fechaObj.toISOString().split("T")[0]
  }

  // Función para actualizar la vista previa de fechas
  function actualizarVistaFechas() {
    const diasSeleccionados = diasSelect.value
    const fechaSeleccionada = fechaSeleccionadaInput.value

    // Actualizar diasnumero
    const numeroDesDias = convertirDiasANumero(diasSeleccionados)
    if (diasnumeroInput) {
      diasnumeroInput.value = numeroDesDias
    }

    if (diasSeleccionados && fechaSeleccionada) {
      let textoFecha = ""
      let fechaFormateada = ""

      if (diasSeleccionados === "UN DIA") {
        textoFecha = formatearFechaEspanol(fechaSeleccionada)
        fechaFormateada = textoFecha
      } else if (diasSeleccionados === "DOS DIAS") {
        const fecha1 = formatearFechaEspanol(fechaSeleccionada)
        const fechaSiguiente = obtenerDiaSiguiente(fechaSeleccionada)
        const fecha2 = formatearFechaEspanol(fechaSiguiente)

        // Extraer solo los días para el formato "29-30 de mayo de 2025"
        const dia1 = new Date(fechaSeleccionada + "T00:00:00").getDate()
        const dia2 = new Date(fechaSiguiente + "T00:00:00").getDate()
        const mes = meses[new Date(fechaSeleccionada + "T00:00:00").getMonth()]
        const año = new Date(fechaSeleccionada + "T00:00:00").getFullYear()

        textoFecha = `${fecha1} y ${fecha2}`
        fechaFormateada = `${dia1}-${dia2} de ${mes} de ${año}`
      }

      fechaTexto.textContent = textoFecha
      fechaPreview.style.display = "block"

      // Guardar la fecha formateada para enviar al documento
      if (fechaSeleccionadaFormateadaInput) {
        fechaSeleccionadaFormateadaInput.value = fechaFormateada
      }
    } else {
      fechaPreview.style.display = "none"
      if (fechaSeleccionadaFormateadaInput) {
        fechaSeleccionadaFormateadaInput.value = ""
      }
    }

    console.log("Días en número:", numeroDesDias)
  }

  // Función para actualizar la vista previa del motivo
  function actualizarVistaMotivo() {
    const motivoSeleccionado = document.querySelector('input[name="Motivo_felicitacion"]:checked')

    if (motivoSeleccionado) {
      motivoTexto.textContent = motivoSeleccionado.value
      motivoPreview.style.display = "block"
      console.log("Motivo seleccionado:", motivoSeleccionado.value)
    } else {
      motivoPreview.style.display = "none"
    }
  }

  // Event listeners para días y fechas
  if (diasSelect) {
    diasSelect.addEventListener("change", actualizarVistaFechas)
  }

  if (fechaSeleccionadaInput) {
    fechaSeleccionadaInput.addEventListener("change", actualizarVistaFechas)
  }

  // Event listeners para motivo de felicitación
  motivoRadios.forEach((radio) => {
    radio.addEventListener("change", actualizarVistaMotivo)
  })

  if (numeroInput) {
    numeroInput.addEventListener("input", function () {
      let valor = this.value.replace(/\D/g, "")
      if (valor.length > 4) {
        valor = valor.substring(0, 4)
      }
      this.value = valor
    })

    numeroInput.addEventListener("blur", function () {
      let valor = this.value.replace(/\D/g, "")
      if (valor.length > 0) {
        valor = valor.padStart(4, "0")
        this.value = valor
        if (numeroFormateadoInput) {
          numeroFormateadoInput.value = valor
        }
      }
    })
  }

  if (numeroOficioInput) {
    numeroOficioInput.addEventListener("input", function () {
      let valor = this.value.replace(/\D/g, "")
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
  if (controlOpcionalSelect && opcionalHiddenInput) {
    controlOpcionalSelect.addEventListener("change", function() {
        const textoOpcional = "Por lo antes expuesto solicito muy disciplinadamente se certifique si afecta o no la capacidad operativa y en caso de ser procedente se dirija mi solicitud hasta el escalón superior para que se me otorgue la respectiva autorización";
        opcionalHiddenInput.value = (this.value === "si") ? textoOpcional : "";
    });
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
    }
  }

  // Event listeners para el solicitante
  if (nombreSolicitanteInput) {
    nombreSolicitanteInput.addEventListener("input", actualizarIniciales)
    nombreSolicitanteInput.addEventListener("blur", actualizarIniciales)
  }

  // Función para manejar ciudad con "Otra" opción
  function configurarCiudad(selectElement, containerElement, inputElement) {
    if (selectElement && containerElement && inputElement) {
      selectElement.addEventListener("change", function () {
        if (this.value === "OTRA") {
          containerElement.style.display = "block"
          inputElement.setAttribute("required", "required")
        } else {
          containerElement.style.display = "none"
          inputElement.removeAttribute("required")
          inputElement.value = ""
        }
      })
    }
  }

  // Configurar selector de ciudad
  configurarCiudad(ciudadSelect, otraCiudadContainer, otraCiudadInput)

  // Actualizar número de oficio según distrito
  if (distrito && numeroOficio1) {
    distrito.addEventListener("change", function () {
      numeroOficio1.value = this.value
    })
  }

  // Establecer fecha actual
  const today = new Date()
  const formattedDate = today.toISOString().substr(0, 10)
  const fechaInput = document.getElementById("fecha")
  const fechaInicioInput = document.getElementById("fechaInicio")

  if (fechaInput) fechaInput.value = formattedDate
  if (fechaInicioInput) fechaInicioInput.value = formattedDate

  // Validación del formulario
  if (form && submitBtn) {
    form.addEventListener("submit", (event) => {
      console.log("=== ENVIANDO FORMULARIO ===")

      // Actualizar campos antes del envío
      actualizarIniciales()
      actualizarVistaFechas()
      actualizarVistaMotivo()

      // Formatear número de oficio
      if (numeroOficioInput && numeroOficioInput.value) {
        const valor = numeroOficioInput.value.replace(/\D/g, "")
        if (valor.length > 0) {
          numeroOficioInput.value = valor.padStart(4, "0")
        }
      }

      // Formatear número del memorando
      if (numeroInput && numeroInput.value) {
        const valor = numeroInput.value.replace(/\D/g, "")
        if (valor.length > 0) {
          const valorFormateado = valor.padStart(4, "0")
          numeroInput.value = valorFormateado
          if (numeroFormateadoInput) {
            numeroFormateadoInput.value = valorFormateado
          }
        }
      }

      // Validar campos requeridos
      let isValid = true
      const requiredFields = form.querySelectorAll("[required]")

      requiredFields.forEach((field) => {
        if (field.type === "radio") {
          // Validación especial para radio buttons
          const radioGroup = form.querySelectorAll(`input[name="${field.name}"]`)
          const isRadioGroupValid = Array.from(radioGroup).some((radio) => radio.checked)
          if (!isRadioGroupValid) {
            isValid = false
            // Marcar el contenedor del grupo de radio como error
            const container = field.closest(".motivo-felicitacion-container")
            if (container) {
              container.classList.add("error-field")
            }
          } else {
            const container = field.closest(".motivo-felicitacion-container")
            if (container) {
              container.classList.remove("error-field")
            }
          }
        } else if (!field.value.trim()) {
          isValid = false
          field.classList.add("error-field")
        } else {
          field.classList.remove("error-field")
        }
      })

      // Verificar campos críticos
      if (!inicialesSolicitanteInput || !inicialesSolicitanteInput.value) {
        alert("Error: Las iniciales del solicitante no se generaron. Verifique el nombre.")
        isValid = false
      }

      if (!fechaSeleccionadaFormateadaInput || !fechaSeleccionadaFormateadaInput.value) {
        alert("Error: Debe seleccionar los días y la fecha.")
        isValid = false
      }

      if (!diasnumeroInput || !diasnumeroInput.value) {
        alert("Error: No se pudo convertir los días a número.")
        isValid = false
      }

      // Verificar que se haya seleccionado un motivo de felicitación
      const motivoSeleccionado = document.querySelector('input[name="Motivo_felicitacion"]:checked')
      if (!motivoSeleccionado) {
        alert("Error: Debe seleccionar el tipo de felicitación (PÚBLICA o SOLEMNE).")
        isValid = false
      }

      if (!isValid) {
        event.preventDefault()
        alert("Por favor, complete todos los campos obligatorios.")
        submitBtn.textContent = "Generar Documento"
        submitBtn.disabled = false
      } else {
        console.log("Días en número enviado:", diasnumeroInput.value)
        console.log("Motivo de felicitación enviado:", motivoSeleccionado.value)
        submitBtn.textContent = "Generando documento..."
        submitBtn.disabled = true
      }
    })
  }

  // Ejecutar actualizaciones iniciales
  setTimeout(() => {
    if (nombreSolicitanteInput && nombreSolicitanteInput.value) {
      actualizarIniciales()
    }
    actualizarVistaFechas()
    actualizarVistaMotivo()
  }, 100)
})
