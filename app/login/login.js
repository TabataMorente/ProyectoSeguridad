function iniciar_sesion() {
	let formulario = document.getElementById("login_form");
	let nombre = document.getElementById("nombre").value;
	let contrasena = document.getElementById("contrasena").value;

	var validar = true;

	if ( !nombre )
	{
		validar = false;
		mostrarError("nombre", "nombre de usuario incorrecto.");
	}
	else if ( !contrasena )
	{
		validar = false;
		mostrarError("contrasena", "contraseña incorrecta.");
	}

	if ( validar )
	{
		formulario.submit();
	}
}

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
