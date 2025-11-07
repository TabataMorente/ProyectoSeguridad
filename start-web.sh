#!/bin/bash
# start-web.sh

# Habilitar mod_headers si no está activo
a2enmod headers

# Iniciar Apache en primer plano
apache2-foreground
