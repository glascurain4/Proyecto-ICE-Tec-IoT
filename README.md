# Proyecto ICE-Tec IoT

Este proyecto propone una solución innovadora como parte de una start-up centrada en la implementación del Internet de las Cosas (IoT). 
El objetivo principal es desarrollar un sistema integrado para la monitorización ambiental y control remoto utilizando sensores y dispositivos conectados.

## Descripción General

La solución utiliza el sensor DHT11 para capturar datos ambientales (temperatura y humedad) y los combina con una plataforma web para visualizar y gestionar la información. Adicionalmente, se integra un control remoto de LEDs, que ilustra la interacción entre dispositivos IoT y usuarios finales.

Este sistema demuestra las posibilidades del IoT en la mejora de procesos y la optimización de recursos en entornos inteligentes.

## Funcionalidades Principales

1. **Monitorización Ambiental**
   - Captura de datos de temperatura y humedad mediante el sensor DHT11.
   - Almacenamiento y visualización en tiempo real en una base de datos.

2. **Control de Dispositivos**
   - Activación y desactivación de LEDs mediante la interfaz web.

3. **Gestión de Datos**
   - Almacenamiento en una base de datos MySQL configurada en XAMPP.
   - Actualización dinámica de los registros desde el servidor.

4. **Interfaz Web**
   - Visualización de datos en una tabla dinámica.
   - Interacción amigable para el control de dispositivos.

## Componentes del Proyecto

### Hardware
- **ESP32**: Placa microcontroladora utilizada para la comunicación entre el sensor y el servidor.
- **DHT11**: Sensor de temperatura y humedad.
- **LEDs**: Actuadores controlados remotamente para demostrar el control IoT.

### Software
- **Servidor XAMPP**: Manejo de la base de datos y archivos PHP.
- **PHP**: Lenguaje de programación para gestionar datos y control.
- **HTML/CSS/JavaScript**: Construcción de la interfaz web.

### Archivos Relevantes
- `database.php`: Configuración de la conexión a la base de datos.
- `getdata.php`: Obtención de datos del sensor.
- `updateDHT11data_and_recordtable.php`: Actualización de datos y tabla de registros.
- `updateLEDs.php`: Control de LEDs desde la interfaz.

## Manuales Incluidos
- `DHT11 MANUAL.pdf`: Uso del sensor DHT11.
- `MANUAL ESP32.pdf`: Configuración de la placa ESP32.
- `MANUAL ARDUINO.pdf`: Soporte adicional para configuraciones con Arduino.
- `XAMPP MANUAL.pdf`: Configuración del servidor local.

## Propuesta de Start-up

El proyecto ICE-Tec IoT es una base sólida para una start-up que se enfoque en soluciones de monitorización y control en tiempo real. Los posibles mercados incluyen:
- Gestión de recursos en hogares inteligentes.
- Optimización de procesos en oficinas y fábricas.
- Implementaciones educativas para enseñar conceptos de IoT.

## Ejecución del Proyecto

1. Configura el entorno:
   - Instala XAMPP y configura la base de datos según el archivo `database.php`.
   - Sube los archivos PHP al servidor local.

2. Conecta el hardware:
   - Configura el sensor DHT11 y los LEDs al ESP32.
   - Asegúrate de que el ESP32 tenga la programación adecuada para interactuar con el servidor.

3. Accede al sistema web:
   - Abre el archivo `home.php` en el navegador para visualizar y controlar los dispositivos.

## Documentación Técnica

Consulta el archivo `Reporte Técnico - ITO - ICETEC (1).pdf` para obtener detalles sobre la arquitectura y diseño del proyecto.

## Autoría

Este proyecto fue desarrollado como parte de la materia de implementación de IoT, con un enfoque en demostrar la viabilidad técnica y comercial de soluciones IoT en un contexto de start-up.
