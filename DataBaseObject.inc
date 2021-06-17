<?php
  require_once("configuration.inc");
  abstract class DataBaseObject{
    public function __construct(){}
    protected static function conectar(){
      try{
        $connection = new PDO(DB_DSN,DB_USUARIO,DB_CONTRASENIA);
        $connection->setAttribute(PDO::ATTR_PERSISTENT, true);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch(PDOException $e){
        echo "Conexión fallida: ".$e->getMessage();
      }
      return $connection;
    }
    protected static function desconectar($connection){
      $connection = null;
    }
  }
 ?>
