<?php
  require_once('DataBaseObject.inc');

  class Users extends DataBaseObject{

    public function insertUser($name,$username,$password,$type,$email){
      $existe = $this->checkUserNameExists($username);
      $inserted = false;
      if($existe == false){
        $connection = parent::conectar();
        $pass = hash('sha256',$password);
        $consulta = "INSERT INTO ".USERS." VALUES(:id,:name,:username,:passwd,:type,:admin,:email)";
        $sentence = $connection->prepare($consulta);
        try{

          $sentence->bindValue(":id",0,PDO::PARAM_INT);
          $sentence->bindValue(":name",$name,PDO::PARAM_STR);
          $sentence->bindValue(":username",$username,PDO::PARAM_STR);
          $sentence->bindValue(":passwd",$pass,PDO::PARAM_STR);
          $sentence->bindValue(":type",$type,PDO::PARAM_INT);
          $sentence->bindValue(":admin",0,PDO::PARAM_INT);
          $sentence->bindValue(":email",$email,PDO::PARAM_STR);
          $sentence->execute();
          parent::desconectar($connection);
        }catch(PDOException $e){
          parent::desconectar($connection);
          die( "Consulta fallida: " . $e->getMessage());
        }
        $inserted = true;
      }
      return $inserted;
    }
    public function getUserInfo($us,$id){
      if($us=='' || $id == ''){
        return array();
      }
      $connection = parent::conectar();
      $query = 'SELECT * FROM '.USERS.' WHERE ID=:id and userName=:userName';
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(":id",$id,PDO::PARAM_INT);
        $sentence->bindValue(":userName",$us,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        parent::desconectar($connection);
        return $rows;
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta Fallida: '.$e->getMessage());
      }
    }

    public function updateUserInfo($name,$userName,$password,$type,$email,$id){
      if($name=='' || $userName=='' || $type=='' || $email == ''){
        return false;
      }
      $connection = parent::conectar();
      $query = 'UPDATE '.USERS.' SET name=:name, userName=:userName, tipo=:type, email=:email';
      if ($password != ''){
        $query .= ', password=:password';
      }
      $query .= ' WHERE ID=:id';
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(":id",$id,PDO::PARAM_INT);
        $sentence->bindValue(":name",$name,PDO::PARAM_STR);
        $sentence->bindValue(":userName",$userName,PDO::PARAM_STR);
        $sentence->bindValue(":type",$type,PDO::PARAM_INT);
        $sentence->bindValue(":email",$email,PDO::PARAM_STR);
        if ($password != ''){
          $password = hash('sha256',$password);
          $sentence->bindValue(":password",$password,PDO::PARAM_STR);
        }
        $sentence->execute();
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta Fallida: '.$e->getMessage());
      }
      return true;
    }

    private function checkEmailExists($email){
      if($email == ""){
        return true;
      }
      $connection = parent::conectar();
      $consulta = "SELECT ID FROM ".USERS." WHERE email = :email";
      $existe = false;
      try{
        $sentence = $connection->prepare($consulta);
        $sentence->bindValue(':email',$email,PDO::PARAM_STR);
        $sentence->execute();
        $filas = null;
        $filas = $sentence->fetchAll();
        if (! empty($filas)){
          $existe = true;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return $existe;
    }

    private function checkUserNameExists($username){
      if($username == ""){
        return true;
      }
      $connection = parent::conectar();
      $consulta = "SELECT ID FROM ".USERS." WHERE userName = :user";
      $existe = false;
      try{
        $sentence = $connection->prepare($consulta);
        $sentence->bindValue(':user',$username,PDO::PARAM_STR);
        $sentence->execute();
        $filas = null;
        $filas = $sentence->fetchAll();
        if (! empty($filas)){
          $existe = true;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return $existe;
    }

    public function checkUser($username,$passwd){
      $connection = parent::conectar();
      $pass = hash('sha256',$passwd);
      $consulta = "SELECT ID,userName,admin FROM ".USERS." WHERE userName = :user AND password = :passwd";
      $sentence = $connection->prepare($consulta);
      $existe = [];
      try{
        $sentence->bindValue(":passwd",$pass,PDO::PARAM_STR);
        $sentence->bindValue(":user",$username,PDO::PARAM_STR);
        $sentence->execute();
        $exist = $sentence->fetchAll();
        if (! empty($exist)){
          $existe = $exist;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return $existe;
    }

  }

?>
