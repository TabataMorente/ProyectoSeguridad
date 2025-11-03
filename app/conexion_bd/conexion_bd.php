<?php
$TEXT_FILE = file_get_contents("../conexion_bd/conexion_bd.txt"); // Devuelve una cadena
$PATTERN = "/(\n)/"; // Patron por el que separaremos la cadena en un array

$array_contenido = preg_split($PATTERN, $TEXT_FILE); // Devuelve un array cuyo elemento es cada linea del archivo

$conexion_bd = new SplFixedArray(count($array_contenido)); // Crea un array de tamaino igual que $array_contenido
$indice = 0;

foreach ( $array_contenido as $linea ) {
        $PATTERN = "/(:)/"; // Patron por el que separaremos la cadena en un array
        $contenido_dividido = preg_split($PATTERN, $linea);
	/* Devuelve un array formada por dos elementos:
	 * Uno con todos los caracteres desde el
	 * principio de la linea hasta el ':' y 
	 * otro con todos los caracteres desde el primer
	 * despues de ':' hasta el final.
	 * Ejemplo:
	 * 	input: "UserName:Paquita"
	 *	output: {UserName, Paquita}
	 */
        $conexion_bd[$indice] = $contenido_dividido[1]; // Guardariamos en el array de resultado "Paquita"
        $indice += 1;
}

?>
