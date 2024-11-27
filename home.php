<?php
require_once 'database.php';

try {
    // Crear la conexión usando la clase Database
    $pdo = new PDO(
        "mysql:host=" . Database::getDbHost() . ";dbname=" . Database::getDbName(),
        Database::getDbUsername(),
        Database::getDbUserPassword()
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar los datos más recientes de la tabla
    $stmt = $pdo->prepare("SELECT temperature, humidity, time, date, LED_01, LED_02 FROM esp32_table_dht11_leds_update ORDER BY id DESC LIMIT 1");
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Variables para mostrar en el HTML
    $temperature = $data['temperature'] ?? 'N/A';
    $humidity = $data['humidity'] ?? 'N/A';
    $last_time = $data['time'] ?? 'N/A';
    $last_date = $data['date'] ?? 'N/A';
    $led1_status = $data['LED_01'] ?? 'OFF';
    $led2_status = $data['LED_02'] ?? 'OFF';

} catch (PDOException $e) {
    // Si hay un error en la conexión, mostrar un mensaje
    $temperature = $humidity = $last_time = $last_date = 'Error al conectar';
    $led1_status = $led2_status = 'Error';
}
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>ICETEC - Control y Monitoreo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="icon" href="data:,">
    <style>
      /* Estilo igual que en tu código anterior */
      html {font-family: Arial; display: inline-block; text-align: center;}
      p {font-size: 1.2rem;}
      h4 {font-size: 0.8rem;}
      body {margin: 0;}
      .topnav {
        overflow: hidden;
        background-color: #1a73e8;
        color: white;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        padding: 10px;
      }
      .topnav img {
        height: 50px;
        margin-right: 15px;
      }
      .topnav h3 {
        margin: 0;
      }
      .content {padding: 20px;}
      .card {
        background-color: white;
        box-shadow: 0px 0px 10px 1px rgba(140,140,140,.5);
        border: 1px solid #1a73e8;
        border-radius: 15px;
        padding: 15px;
      }
      .card.header {
        background-color: #1a73e8;
        color: white;
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-top-right-radius: 12px;
        border-top-left-radius: 12px;
        padding: 10px;
      }
      .cards {
        max-width: 700px;
        margin: 0 auto;
        display: grid;
        grid-gap: 2rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      }
      .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
      }
      .switch input {display: none;}
      .sliderTS {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #D3D3D3;
        transition: .4s;
        border-radius: 34px;
      }
      .sliderTS:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: #f7f7f7;
        transition: .4s;
        border-radius: 50%;
      }
      input:checked + .sliderTS {
        background-color: #1a73e8;
      }
      input:checked + .sliderTS:before {
        transform: translateX(26px);
      }
      .sliderTS:after {
        content:'OFF';
        color: white;
        display: block;
        position: absolute;
        transform: translate(-50%,-50%);
        top: 50%;
        left: 70%;
        font-size: 10px;
        font-family: Verdana, sans-serif;
      }
      input:checked + .sliderTS:after {  
        left: 25%;
        content:'ON';
      }
      .LEDColor {
        color: #1a73e8;
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 10px;
      }
    </style>
  </head>
  
  <body>
    <div class="topnav">
      <img src="LogoIceTec.svg" alt="Logo ICETEC">
      <h3>ICETEC - Control y Monitoreo</h3>
    </div>
    
    <br>
    
    <div class="content">
      <div class="card">
        <div class="card header">
            <h3>Datos Recientes</h3>
        </div>
        <div class="content">
            <p><strong>Temperatura:</strong> <?php echo $temperature; ?> °C</p>
            <p><strong>Humedad:</strong> <?php echo $humidity; ?> %</p>
            <p><strong>Última lectura:</strong> Hora: <?php echo $last_time; ?> | Fecha: <?php echo $last_date; ?></p>
        </div>
      </div>

      <!-- Controles de LED -->
      <div class="card">
        <div class="card header">
          <h3>CONTROLLING</h3>
        </div>
        <h4 class="LEDColor"><i class="fas fa-lightbulb"></i> LED 1</h4>
        <label class="switch">
          <input type="checkbox" id="ESP32_01_TogLED_01" onclick="GetTogBtnLEDState('ESP32_01_TogLED_01')" <?php echo ($led1_status === 'ON') ? 'checked' : ''; ?>>
          <div class="sliderTS"></div>
        </label>
        <h4 class="LEDColor"><i class="fas fa-lightbulb"></i> LED 2</h4>
        

        <label class="switch">
          <input type="checkbox" id="ESP32_01_TogLED_02" onclick="GetTogBtnLEDState('ESP32_01_TogLED_02')" <?php echo ($led2_status === 'ON') ? 'checked' : ''; ?>>
          <div class="sliderTS"></div>
        </label>
      </div>
    </div>
    
    <br>
    
    <!-- Últimos datos -->
    <div class="content">
      <div class="cards">
        <div class="card header" style="border-radius: 15px;">
            <h3 style="font-size: 0.7rem;">Últimos Datos Recibidos [ <?php echo $last_time . " - " . $last_date; ?> ]</h3>
            <button onclick="window.open('recordtable.php', '_blank');">Abrir Tabla de Registros</button>
        </div>
      </div>
    </div>
    
    <script>
      // Función para manejar el estado de los LEDs
      function GetTogBtnLEDState(togbtnid) {
        let togbtnchecked = document.getElementById(togbtnid).checked;
        let togbtncheckedsend = togbtnchecked ? "ON" : "OFF";
        Update_LEDs("esp32_01", togbtnid.replace("ESP32_01_Tog", ""), togbtncheckedsend);
      }

      // Función para actualizar el estado de los LEDs en la base de datos
      function Update_LEDs(id, lednum, ledstate) {
        if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("POST", "updateLEDs.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`id=${id}&lednum=${lednum}&ledstate=${ledstate}`);
      }
    </script>
  </body>
</html>
