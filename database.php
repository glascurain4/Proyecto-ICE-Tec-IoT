<?php
	class Database {
		private static $dbName = 'esp32_mc_db'; // Nombre de la base de datos
		private static $dbHost = 'localhost'; // Host del servidor
		private static $dbUsername = 'root'; // Usuario de la base de datos
		private static $dbUserPassword = ''; // Contraseña de la base de datos
		 
		private static $cont  = null;
		 
		public function __construct() {
			die('Init function is not allowed');
		}
		 
		// Método para conectar a la base de datos
		public static function connect() {
			// Una sola conexión durante toda la aplicación
			if (null == self::$cont) {     
				try {
					self::$cont =  new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword); 
				} catch (PDOException $e) {
					die($e->getMessage()); 
				}
			}
			return self::$cont;
		}
		 
		// Método para desconectar
		public static function disconnect() {
			self::$cont = null;
		}

		// Métodos para acceder a las propiedades privadas
		public static function getDbName() {
			return self::$dbName;
		}

		public static function getDbHost() {
			return self::$dbHost;
		}

		public static function getDbUsername() {
			return self::$dbUsername;
		}

		public static function getDbUserPassword() {
			return self::$dbUserPassword;
		}
	}
?>

