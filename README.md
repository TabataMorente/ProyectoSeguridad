
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



## Funcionamiento de la web
**PHP:** genera el contenido dinámico (datos desde la base de datos, lógica, etc.). <br>

**HTML**: estructura la página (elementos como < div >, < table >, etc.). <br>

**CSS:** define el estilo (colores, fuentes, diseño responsivo). <br>

**JavaScript:** añade interacción en el navegador (validaciones, botones, animaciones, AJAX...). <br>


## Fuentes (Ikers)

**Plantilla login:** https://codepen.io/colorlib/pen/rxddKy/ <br>
