
# Docker LAMP
Linux + Apache + MariaDB (MySQL) + PHP 7.2 on Docker Compose. Mod_rewrite enabled by default.

## Instructions

Primero hay que construir la imagen "web" en docker:

```bash
docker build -t="web" .
```

Introduce el siguiente comando para iniciar docker:
```bash
docker compose up -d
```

Para pararlo:
```bash
docker compose stop
```

## Integrantes del grupo:
Laura Calvo <br>
Marco Lartategui <br>
Iker Fuente <br>
Tabata Morente <br>
Ivan Herrera <br>
Gorka Bidaguren

## Manual de instrucciones del sitio web ##
El sitio web sirve para gestionar apuestas de carreras de cerdos asociadas a una cuenta.
Para ello, primero de todo, hace falta crear una cuenta, en caso de no tener una, e iniciar sesión.<br>

Dentro de la cuenta, se muestran las siguientes opciones:
* Modificar Datos: El usuario tiene la opción de cambiar la información que añadió al registrarse.
* Apuestas: Se encarga de las gestiones de apuestas.

En la página de Apuestas se ofrecen las siguientes opciones:
* Añadir apuesta: A partir de los cerdos disponibles y las carreras disponibles, permite apostar al usuario una cantidad de dinero por un cerdo en una carrera espécifica, si el cerdo no participa en una carrera no te dejará apostar por ese cerdo en esa carrera.
* Eliminar apuesta: Borra una apuesta realizada por el usuario con el que se ha iniciado sesión.
* Ver apuestas: Permite ver todas las apuestas registradas por todos los usuarios en el momento.
* Volver: Vuelves a la página del usuario.

## Funcionamiento de la web
**PHP:** genera el contenido dinámico (datos desde la base de datos, lógica, etc.). <br>

**HTML**: estructura la página (elementos como < div >, < table >, etc.). <br>

**CSS:** define el estilo (colores, fuentes, diseño responsivo). <br>

**JavaScript:** añade interacción en el navegador (validaciones, botones, animaciones, AJAX...). <br>


## Fuentes (Ikers)

**Plantilla login:** https://codepen.io/colorlib/pen/rxddKy/ <br>
