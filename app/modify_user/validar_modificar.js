function validarDNI(dni) {
  const letras = "TRWAGMYFPDXBNJZSQVHLCKE";
  const expr = /^(\d{8})-([A-Z])$/;
  const match = dni.match(expr);
  if (!match) return false;
  const num = parseInt(match[1]);
  const letra = match[2];
  return letras[num % 23] === letra;
}

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("user_modify_form");

  form.addEventListener("submit", (e) => {
    const nombre = document.getElementById("nombre").value.trim();
    const dni = document.getElementById("dni").value.toUpperCase();
    const telefono = document.getElementById("telefono").value;
    const fecha = document.getElementById("fecha").value.trim();
    const email = document.getElementById("email").value;
    
    if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/.test(nombre)) {
        mostrarError("nombre", "Solo se permiten letras y espacios.");
        valido = false;
    }
    
    if (!validarDNI(dni)) {
      alert("El DNI no es válido.");
      e.preventDefault();
      return;
    }

    if (!/^[0-9]{9}$/.test(telefono)) {
      alert("El teléfono debe tener 9 dígitos.");
      e.preventDefault();
      return;
    }

    if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
      alert("El correo electrónico no es válido.");
      e.preventDefault();
      return;
    }
    
    if (!/^\d{4}-\d{2}-\d{2}$/.test(fecha)) {
        mostrarError("fecha", "Formato incorrecto (aaaa-mm-dd).");
        valido = false;
    }

  });
});

