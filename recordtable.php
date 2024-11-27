<!DOCTYPE HTML>
<html>
  <head>
    <title>ICETEC - Tabla de Registros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      html {font-family: Arial; display: inline-block; text-align: center;}
      body {margin: 0;}
      p {font-size: 1.2rem;}
      h4 {font-size: 0.8rem;}
      
      /* Encabezado estilo ICETEC */
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

      /* Estilo de la tabla */
      .styled-table {
        border-collapse: collapse;
        margin: 20px auto;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        overflow: hidden;
        width: 90%;
      }

      .styled-table thead tr {
        background-color: #1a73e8;
        color: #ffffff;
        text-align: left;
      }

      .styled-table th, .styled-table td {
        padding: 12px 15px;
        text-align: left;
      }

      .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
      }

      .styled-table tbody tr:hover {
        background-color: rgba(26, 115, 232, 0.15);
      }

      /* Botones de navegación */
      .btn-group .button {
        background-color: #1a73e8;
        border: 1px solid #e3e3e3;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
        margin: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
      }

      .btn-group .button:hover {
        background-color: #155db8;
        transform: translateY(-2px);
        box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.3);
      }

      .btn-group .button:active {
        transform: translateY(0);
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
      }

      .btn-group .button:disabled {
        background-color: #a0a0a0;
        cursor: not-allowed;
        pointer-events: none;
      }
    </style>
  </head>
  
  <body>
    <!-- Encabezado con logo -->
    <div class="topnav">
      <img src="LogoIceTec.svg" alt="Logo ICETEC">
      <h3>ICETEC - Tabla de Registros</h3>
    </div>
    
    <br>
    
    <h3 style="color: #1a73e8;">ESP32_01 RECORD DATA TABLE</h3>
    
    <!-- Tabla de registros -->
    <table class="styled-table" id="table_id">
      <thead>
        <tr>
          <th>NO</th>
          <th>ID</th>
          <th>BOARD</th>
          <th>TEMPERATURE (°C)</th>
          <th>HUMIDITY (%)</th>
          <th>STATUS READ SENSOR DHT11</th>
          <th>LED 01</th>
          <th>LED 02</th>
          <th>TIME</th>
          <th>DATE (dd-mm-yyyy)</th>
        </tr>
      </thead>
      <tbody id="tbody_table_record">
        <?php
          include 'database.php';
          $num = 0;
          $pdo = Database::connect();
          $sql = 'SELECT * FROM esp32_table_dht11_leds_record ORDER BY date, time';
          foreach ($pdo->query($sql) as $row) {
            $date = date_create($row['date']);
            $dateFormat = date_format($date,"d-m-Y");
            $num++;
            echo '<tr>';
            echo '<td>'. $num . '</td>';
            echo '<td>'. $row['id'] . '</td>';
            echo '<td>'. $row['board'] . '</td>';
            echo '<td>'. $row['temperature'] . '</td>';
            echo '<td>'. $row['humidity'] . '</td>';
            echo '<td>'. $row['status_read_sensor_dht11'] . '</td>';
            echo '<td>'. $row['LED_01'] . '</td>';
            echo '<td>'. $row['LED_02'] . '</td>';
            echo '<td>'. $row['time'] . '</td>';
            echo '<td>'. $dateFormat . '</td>';
            echo '</tr>';
          }
          Database::disconnect();
        ?>
      </tbody>
    </table>
    
    <br>
    
    <!-- Controles de paginación -->
    <div class="btn-group">
      <button class="button" id="btn_prev" onclick="prevPage()">Prev</button>
      <button class="button" id="btn_next" onclick="nextPage()">Next</button>
      <p style="display: inline; margin-left: 10px;">Page: <span id="page"></span></p>
      <select name="number_of_rows" id="number_of_rows">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
      <button class="button" id="btn_apply" onclick="apply_Number_of_Rows()">Apply</button>
    </div>
    
    <br>
    
    <script>
      var current_page = 1;
      var records_per_page = 10;
      var l = document.getElementById("table_id").rows.length;

      function apply_Number_of_Rows() {
        var x = document.getElementById("number_of_rows").value;
        records_per_page = x;
        changePage(current_page);
      }

      function prevPage() {
        if (current_page > 1) {
          current_page--;
          changePage(current_page);
        }
      }

      function nextPage() {
        if (current_page < numPages()) {
          current_page++;
          changePage(current_page);
        }
      }

      function changePage(page) {
        var btn_next = document.getElementById("btn_next");
        var btn_prev = document.getElementById("btn_prev");
        var listing_table = document.getElementById("table_id");
        var page_span = document.getElementById("page");

        if (page < 1) page = 1;
        if (page > numPages()) page = numPages();

        [...listing_table.getElementsByTagName('tr')].forEach((tr, index) => {
          tr.style.display = index === 0 || (index > (page - 1) * records_per_page && index <= page * records_per_page) ? '' : 'none';
        });

        page_span.textContent = `${page}/${numPages()} (Total Rows: ${l - 1})`;

        btn_prev.disabled = page === 1;
        btn_next.disabled = page === numPages();
      }

      function numPages() {
        return Math.ceil((l - 1) / records_per_page);
      }

      window.onload = function() {
        changePage(current_page);
      };
    </script>
  </body>
</html>
