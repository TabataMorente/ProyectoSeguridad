document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("register_form");

    if (!form) {
        console.warn("No se encontró el formulario register_form");
        return; // evita el error
    }

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        console.log("Submit detectado");

        // Limpiar mensajes anteriores
        document.querySelectorAll(".error").forEach(el => el.textContent = "");

        let valido = true;

        // --- Validar Nombre y Apellidos ---
        const nombre = document.getElementById("nombre").value.trim();
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/.test(nombre)) {
            mostrarError("nombre", "Solo se permiten letras y espacios.");
            valido = false;
        }

        // --- Validar DNI ---
        const dni = document.getElementById("dni").value.toUpperCase().trim();
        const dniRegex = /^\d{8}-[A-Z]$/;
        if (!dniRegex.test(dni)) {
            mostrarError("dni", "Formato incorrecto (11111111-Z).");
            valido = false;
        } else {
            const numeros = parseInt(dni.substring(0, 8));
            const letra = dni.charAt(9);
            const letrasDNI = "TRWAGMYFPDXBNJZSQVHLCKE";
            const letraCorrecta = letrasDNI[numeros % 23];
            if (letra !== letraCorrecta) {
                mostrarError("dni", `Letra incorrecta. Debe ser ${letraCorrecta}.`);
                valido = false;
            }
        }

        // --- Validar Teléfono ---
        const telefono = document.getElementById("telefono").value.trim();
        if (!/^\d{9}$/.test(telefono)) {
            mostrarError("telefono", "Debe tener 9 dígitos numéricos.");
            valido = false;
        }

        // --- Validar Fecha de Nacimiento ---
        const fecha = document.getElementById("fecha").value.trim();
        if (!/^\d{4}-\d{2}-\d{2}$/.test(fecha)) {
            mostrarError("fecha", "Formato incorrecto (aaaa-mm-dd).");
            valido = false;
        }

        // --- Validar Email ---
        const email = document.getElementById("email").value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            mostrarError("email", "Email no válido.");
            valido = false;
        }

        // --- Si todo es válido ---
        if (valido) {
            alert("¡Registro válido!");
            form.submit(); // Enviar formulario al servidor si todo es correcto
        }
    });

    // Función para mostrar errores junto al input
    function mostrarError(id, mensaje) {
        let errorElem = document.getElementById(id + "-error");
        if (!errorElem) {
            const input = document.getElementById(id);
            errorElem = document.createElement("span");
            errorElem.id = id + "-error";
            errorElem.className = "error";
            errorElem.style.color = "red";
            input.parentNode.insertBefore(errorElem, input.nextSibling);
        }
        errorElem.textContent = mensaje;
    }
});
