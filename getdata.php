<?php
/*
  include 'database.php';
  
  //---------------------------------------- Condition to check that POST value is not empty.
  if (!empty($_POST)) {
    // keep track post values
    $id = $_POST['id'];
    
    $myObj = (object)array();
    
    //........................................ 
    $pdo = Database::connect();
    // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_update'.
    // This table is used to store DHT11 sensor data updated by ESP32. 
    // This table is also used to store the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
    // To store data, this table is operated with the "UPDATE" command, so this table contains only one row.
    $sql = 'SELECT * FROM esp32_table_dht11_leds_update WHERE id="' . $id . '"';
    foreach ($pdo->query($sql) as $row) {
      $date = date_create($row['date']);
      $dateFormat = date_format($date,"d-m-Y");
      
      $myObj->id = $row['id'];
      $myObj->temperature = $row['temperature'];
      $myObj->humidity = $row['humidity'];
      $myObj->status_read_sensor_dht11 = $row['status_read_sensor_dht11'];
      $myObj->LED_01 = $row['LED_01'];
      $myObj->LED_02 = $row['LED_02'];
      $myObj->ls_time = $row['time'];
      $myObj->ls_date = $dateFormat;
      
      $myJSON = json_encode($myObj);
      
      echo $myJSON;
    }
    Database::disconnect();
    //........................................ 
  }
  //---------------------------------------- 
  */
  include 'database.php';
  header('Content-Type: application/json');
  
  $id = $_POST['id'] ?? $_GET['id'] ?? null;
  
  if ($id) {
      try {
          $pdo = Database::connect();
          $sql = 'SELECT * FROM esp32_table_dht11_leds_update WHERE id = ?';
          $q = $pdo->prepare($sql);
          $q->execute([$id]);
          $row = $q->fetch(PDO::FETCH_ASSOC);
  
          if ($row) {
              $response = [
                  'id' => $row['id'],
                  'temperature' => $row['temperature'],
                  'humidity' => $row['humidity'],
                  'status_read_sensor_dht11' => $row['status_read_sensor_dht11'],
                  'LED_01' => $row['LED_01'],
                  'LED_02' => $row['LED_02'],
                  'ls_time' => $row['time'],
                  'ls_date' => date("d-m-Y", strtotime($row['date']))
              ];
              echo json_encode($response);
          } else {
              echo json_encode(['error' => 'No data found for the given ID']);
          }
  
          Database::disconnect();
      } catch (Exception $e) {
          echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
      }
  } else {
      echo json_encode(['error' => 'No ID provided']);
  }
  ?>
  
// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

