function iniciar_sesion() {
	let formulario = document.login_formulario;
	let nombre = formulario.usuario;
	let contrasena = formulario.contrasena;

	let validar = true;

	if ( !nombre )
	{
		validar = false;
	}
	else if ( !contrasena )
	{
		validar = false;
	}

	if ( validar )
	{
		formulario.submit();
	}
}
