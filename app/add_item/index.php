<?php
include('../auth.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Los MontaMarcos - Añadir apuestas</title>
  <script src="registro.js" defer></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      position: relative; /* necesario para posicionar el enlace */
    }
    .container {
      text-align: center;
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 100%;
    }
    h1 {
      margin-bottom: 30px;
    }
    button {
      display: block;
      margin: 15px auto;
      background: #4CAF50;
      color: white;
      padding: 16px 40px;
      border-radius: 5px;
      font-size: 18px;
      border: none;
      cursor: pointer;
      width: fit-content;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #45a049;
    }
    input, select {
      display: block;
      margin: 15px auto;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 5px;
      border: 1.5px solid #4CAF50;
      width: 300px;
      box-sizing: border-box;
      outline: none;
      transition: border-color 0.3s ease;
    }
    input:focus {
      border-color: #388E3C;
      box-shadow: 0 0 5px #4CAF50;
    }
    select {
    appearance: none;           /* Oculta el estilo nativo del navegador */
    -webkit-appearance: none;   /* Compatibilidad Safari/Chrome */
    -moz-appearance: none;      /* Compatibilidad Firefox */
    background-color: white;    /* Fondo uniforme */
    background-image: url('data:image/svg+xml;utf8,<svg fill="%234CAF50" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center; /* Posición de la flecha */
    background-size: 20px;
    cursor: pointer;
    }

    select:focus {
    border-color: #388E3C;
    box-shadow: 0 0 5px #4CAF50;
    }

    .volver-container {
      position: absolute;
      top: 10px;
      right: 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      font-family: Arial, sans-serif;
      font-size: 16px;
      color: #333;
      gap: 5px;
    }

    .volver-container a {
      background: #4CAF50;
      color: white;
      padding: 8px 16px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .volver-container a:hover {
      background: #45a049;
    }

  </style>
</head>
<body>
  <div class="volver-container">
    <?php
    echo "<a href=" . "/items/items.php?user=" . urlencode($email) . ">Volver</a>";
    ?>
  </div>

  <div class="container">
    <h1>Carreras:</h1>

    <?php

    $hostname = getenv("HOSTNAME");
    $username = getenv("USER");
    $password = getenv("PASSWORD");
    $db = getenv("DB");

    $conn = new mysqli($hostname, $username, $password, $db);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Ajuste: se usan los nombres 'cerdo' y 'idCarrera' en participante
    $sql = "
        SELECT
            ca.id AS carrera_id,
            ca.nombre AS carrera_nombre,
            ca.fecha AS carrera_fecha,
            ce.id AS cerdo_id,
            ce.nombre AS cerdo_nombre
        FROM
            carrera ca
        JOIN participante p ON ca.id = p.idCarrera
        JOIN cerdo ce ON ce.id = p.cerdo
        ORDER BY
            ca.id, ce.id
    ";

    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error en la consulta: " . $conn->error;
    } else {
        $carrera_actual = null;

        while ($row = $result->fetch_assoc()) {
            // Si es una nueva carrera, mostramos su información
            if ($carrera_actual !== $row['carrera_id']) {
                if ($carrera_actual !== null) {
                    echo "<br>"; // Separador entre carreras
                }
                echo "<strong> <u>Carrera:</u></strong><br>";
                echo " " . $row['carrera_nombre'] . "<br>";
                echo "Fecha: " . $row['carrera_fecha'] . "<br>";
                echo "<strong>Cerdos participantes:</strong><br>";
                $carrera_actual = $row['carrera_id'];
            }

            // Mostrar cada cerdo participante
            echo "- Cerdo ID: " . $row['cerdo_nombre'] . "<br>";
        }
    }

    ?>

  </div>
   &nbsp; &nbsp; &nbsp;
  <div class="container">
    <h1>Añadir nueva apuesta</h1>
    
    <?php
    $email = $_GET['user'] ?? '';
     // Consultar cerdos
    $cerdos_query = "SELECT id, nombre FROM cerdo ORDER BY nombre ASC";
    $cerdos_result = $conn->query($cerdos_query);

    // Consultar carreras
    $carreras_query = "SELECT id, nombre FROM carrera ORDER BY nombre ASC";
    $carreras_result = $conn->query($carreras_query);
    ?>

    <form id="add_form" action="procesar_adicion.php" method="POST">
      <input type="hidden" name="user" value="<?= htmlspecialchars($email) ?>">

      <label for="cerdo">Cerdos:</label>
      <select id="cerdo" name="cerdo" required>
        <option value="">Selecciona un cerdo</option> <!--Si ponemos que value es vacio, no se tendra en cuenta esa opcion-->
        <?php
        if ($cerdos_result && $cerdos_result->num_rows > 0) {
          while ($row = $cerdos_result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
          }
        }
        ?>
      </select>

      <label for="carrera">Carreras:</label>
      <select id="carrera" name="carrera" required>
        <option value="">Selecciona una carrera</option> <!--Si ponemos que value es vacio, no se tendra en cuenta esa opcion-->
        <?php
        if ($carreras_result && $carreras_result->num_rows > 0) {
          while ($row = $carreras_result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
          }
        }
        ?>
      </select>

      <label for="cantidad">Cantidad (€):</label>
      <input type="number" id="cantidad" name="cantidad" required />
      
      <?php
      echo "<input type='hidden' name='csrf_token' value='" . htmlspecialchars($_SESSION["csrf_token"]) . "' />";
      ?>

      <button id="item_add_summit" type="submit">Añadir apuesta</button>
    </form>
  <?php $conn->close(); ?>
  </div>
</body>
</html>
