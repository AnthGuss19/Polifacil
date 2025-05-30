document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("permisoForm")
  const submitBtn = document.getElementById("submitBtn")
  const fechaInicioInput = document.getElementById("fecha_inicio")
  const fechaFinInput = document.getElementById("fecha_Fin")
  const diasSelect = document.getElementById("dias")
  const fechaError = document.getElementById("fechaError")
  const lugarUsoRadios = document.querySelectorAll('input[name="lugarUso"]')
  const ciudadPaisContainer = document.getElementById("ciudadPaisContainer")
  const ciudadPaisInput = document.getElementById("ciudadPais")

  // Campos personales
  const gradoSelect = document.getElementById("grado")
  const apellidosInput = document.getElementById("apellidos")
  const nombresInput = document.getElementById("nombres")
  const cedulaInput = document.getElementById("cedula")
  const cedulaError = document.getElementById("cedulaError")

  // Campos de grado en firmas
  const gradoServidorSelect = document.getElementById("grado_ServidorPolicial")
  const gradoAnAsSelect = document.getElementById("grado_AnAs")
  const gradoJfAdSelect = document.getElementById("grado_JfAd")
  const gradoDctCdtJfundSelect = document.getElementById("grado_DctCdtJfund")

  // Campos de nombres en firmas
  const nombreServidorInput = document.getElementById("Apellidos_Nombres_servidor")
  const cedulaServidorInput = document.getElementById("cedula_ServidorPolicial")
  const cedulaServidorError = document.getElementById("cedulaServidorError")

  // Otros campos de cédula
  const cedulaAnAsInput = document.getElementById("cedula_AnAs")
  const cedulaAnAsError = document.getElementById("cedulaAnAsError")
  const cedulaJfAdInput = document.getElementById("cedula_JfAd")
  const cedulaJfAdError = document.getElementById("cedulaJfAdError")
  const cedulaDctCdtJfundInput = document.getElementById("cedula_DctCdtJfund")
  const cedulaDctCdtJfundError = document.getElementById("cedulaDctCdtJfundError")

  // Campos ocultos
  const miGradoInput = document.getElementById("miGrado")
  const gradoPoliciaInput = document.getElementById("gradoPolicia")
  const numeroOficio1 = document.getElementById("numeroOficio1")
  const nombresSolicitanteInput = document.getElementById("nombresSolicitante")

  // Establecer la fecha actual como valor predeterminado para la fecha inicial
  const today = new Date()
  const formattedStartDate = today.toISOString().substr(0, 10)
  fechaInicioInput.value = formattedStartDate

  // Calcular la fecha final basada en la fecha inicial y los días
  // Modificar la función calcularFechaFinal en script_fpcd.js
function calcularFechaFinal() {
    if (fechaInicioInput.value && diasSelect.value) {
        const inicio = new Date(fechaInicioInput.value);
        const dias = Number.parseInt(diasSelect.value);
        const fin = new Date(inicio);

        // Ajustar el cálculo según los días seleccionados
        if (dias === 3) {
            // Para 3 días de permiso: fecha final = fecha inicio + 2 días (total 3 días)
            fin.setDate(inicio.getDate() + 3);
        } else if (dias === 8) {
            // Para 8 días de permiso: fecha final = fecha inicio + 7 días (total 8 días)
            fin.setDate(inicio.getDate() + 8);
        }

        // Formatear la fecha final
        const year = fin.getFullYear();
        const month = String(fin.getMonth() + 1).padStart(2, "0");
        const day = String(fin.getDate()).padStart(2, "0");
        const formattedEndDate = `${year}-${month}-${day}`;

        fechaFinInput.value = formattedEndDate;
        return true;
    }
    return false;
}


  // Recalcular la fecha final cuando cambia la fecha inicial
  fechaInicioInput.addEventListener("change", calcularFechaFinal)

  // Recalcular la fecha final cuando cambia el número de días
  diasSelect.addEventListener("change", calcularFechaFinal)

  // Inicializar el cálculo de la fecha final
  setTimeout(calcularFechaFinal, 100)

  // Mostrar/ocultar campo "Ciudad y País" según selección
  lugarUsoRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      if (this.value === "exterior") {
        ciudadPaisContainer.style.display = "block"
        ciudadPaisInput.setAttribute("required", "required")
      } else {
        ciudadPaisContainer.style.display = "none"
        ciudadPaisInput.removeAttribute("required")
        ciudadPaisInput.value = ""
      }
    })
  })

  // Validación de cédula - solo números y 10 dígitos
  function validarCedula(input, errorElement) {
    input.addEventListener("input", function () {
      // Permitir solo números
      this.value = this.value.replace(/[^0-9]/g, "")

      // Validar longitud
      if (this.value.length !== 0 && this.value.length !== 10) {
        errorElement.style.display = "block"
        this.classList.add("error-field")
        return false
      } else {
        errorElement.style.display = "none"
        this.classList.remove("error-field")
        return true
      }
    })
  }

  // Aplicar validación a todos los campos de cédula
  validarCedula(cedulaInput, cedulaError)
  validarCedula(cedulaServidorInput, cedulaServidorError)
  validarCedula(cedulaAnAsInput, cedulaAnAsError)
  validarCedula(cedulaJfAdInput, cedulaJfAdError)
  validarCedula(cedulaDctCdtJfundInput, cedulaDctCdtJfundError)

  // Convertir texto a mayúsculas mientras se escribe
  const textInputs = document.querySelectorAll('input[type="text"]:not([id^="cedula"]), textarea')
  textInputs.forEach((input) => {
    input.addEventListener("input", function () {
      this.value = this.value.toUpperCase()
    })
  })

  // Actualizar campo oculto miGrado cuando cambia el grado principal
  function actualizarMiGrado() {
    if (gradoSelect.selectedIndex > 0) {
      const gradoValor = gradoSelect.value

      // Actualizar miGrado con el valor completo del grado
      const gradosCompletos = {
        Gral: "GENERAL",
        Crnl: "CORONEL",
        Tcnl: "TENIENTE CORONEL",
        Mayr: "MAYOR",
        Cptn: "CAPITÁN",
        Tnte: "TENIENTE",
        Sbte: "SUBTENIENTE",
        Sbom: "SUBOFICIAL MAYOR",
        Sbop: "SUBOFICIAL PRIMERO",
        Sbos: "SUBOFICIAL SEGUNDO",
        Sgop: "SARGENTO PRIMERO",
        Sgos: "SARGENTO SEGUNDO",
        Cbop: "CABO PRIMERO",
        Cbos: "CABO SEGUNDO",
        Poli: "POLICÍA",
      }
      miGradoInput.value = gradosCompletos[gradoValor] || ""
    }
  }

  // Actualizar grado cuando cambia la selección
  gradoSelect.addEventListener("change", actualizarMiGrado)

  // Validación del formulario
  form.addEventListener("submit", (event) => {
    event.preventDefault() // Prevenir envío para validar primero

    // Asegurarse de que la fecha final esté calculada correctamente
    calcularFechaFinal()

    let isValid = true
    const requiredFields = form.querySelectorAll("[required]")

    // Validar campos requeridos
    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        isValid = false
        field.classList.add("error-field")

        const nextElement = field.nextElementSibling
        if (nextElement && nextElement.classList.contains("error")) {
          nextElement.remove()
        }

        const errorMsg = document.createElement("div")
        errorMsg.textContent = "ESTE CAMPO ES OBLIGATORIO"
        errorMsg.classList.add("error")
        field.parentNode.insertBefore(errorMsg, field.nextSibling)
      } else {
        field.classList.remove("error-field")

        const nextElement = field.nextElementSibling
        if (nextElement && nextElement.classList.contains("error")) {
          nextElement.remove()
        }
      }
    })

    // Validar cédulas (10 dígitos)
    const cedulaInputs = [cedulaInput, cedulaServidorInput, cedulaAnAsInput, cedulaJfAdInput, cedulaDctCdtJfundInput]
    cedulaInputs.forEach((input) => {
      if (input.value.length !== 10) {
        isValid = false
        input.classList.add("error-field")
        const errorElement = document.getElementById(input.id + "Error") || input.nextElementSibling
        if (errorElement) {
          errorElement.style.display = "block"
        }
      }
    })

    if (!isValid) {
      alert("POR FAVOR, COMPLETE TODOS LOS CAMPOS OBLIGATORIOS CORRECTAMENTE.")
    } else {
      // Asegurarse de que el campo oculto nombresSolicitante tenga valor
      if (nombresSolicitanteInput.value === "" && nombreServidorInput.value !== "") {
        nombresSolicitanteInput.value = nombreServidorInput.value
      }

      // Convertir todos los valores de texto a mayúsculas antes de enviar
      textInputs.forEach((input) => {
        input.value = input.value.toUpperCase()
      })

      submitBtn.textContent = "GENERANDO DOCUMENTO..."
      submitBtn.disabled = true

      // Enviar el formulario
      form.submit()
    }
  })

  // Restaurar el estado del botón al volver a la página
  window.addEventListener("pageshow", () => {
    submitBtn.textContent = "Generar y Descargar Documento"
    submitBtn.disabled = false
  })
})
