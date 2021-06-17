<?php
  require_once('DataBaseObject.inc');
  class Sections extends DataBaseObject{

    public function getAllSections(){
      $connection = parent::conectar();
      $consulta = 'SELECT seccionName,id FROM '.SECTIONS;
      try {
        $sentence = $connection->prepare($consulta);
        $sentence->execute();
        $secciones = $sentence->fetchAll();
        parent::desconectar($connection);
        return $secciones;
      } catch (PDOException $e) {
        parent::desconectar($connection);
        die('Consulta Fallida en secciones: '.$e->getMessage());
      }
    }
    public function checkSectionExist($section='',$id=-1){
      $exist = false;
      $connection = parent::conectar();
      $query = 'SELECT ID FROM '.SECTIONS.' WHERE ';
      if($section != '' && $id > -1){
        $query.='seccionName=:section and id=:id';
      }
      else if ($section != ''){
        $query.='seccionName=:section';
      }
      else if ($id > -1){
        $query .= 'id=:id';
      }
      try{
        $sentence = $connection->prepare($query);
        if($section != '' && $id > -1){
          $sentence->bindValue(':section',$section,PDO::PARAM_STR);
          $sentence->bindValue(':id',$id,PDO::PARAM_INT);
        }
        else if ($section != ''){
          $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        }
        else if ($id > -1){
          $sentence->bindValue(':id',$id,PDO::PARAM_INT);
        }

        $sentence->execute();
        $rows = $sentence->fetchAll();
        if(! empty($rows)){
          $exist = true;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return $exist;
    }
    public function createSection($sectionName){
      $existe = $this->checkSectionExist($sectionName);
      if($existe){
        return 'SectionAlreadyExist';
      }
      $inserted = false;
      if($existe == false){
        $connection = parent::conectar();
        $consulta = "INSERT INTO ".SECTIONS." VALUES(:id,:sectionName)";
        $sentence = $connection->prepare($consulta);
        try{
          $sentence->bindValue(":id",0,PDO::PARAM_INT);
          $sentence->bindValue(":sectionName",$sectionName,PDO::PARAM_STR);
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

    public function deleteSection($section='',$id=-1){
      if(!$this->checkSectionExist($section,$id)){return 'SectionNotExist';}
      $connection = parent::conectar();
      $query = 'DELETE FROM '.SECTIONS.' WHERE ';
      if($section != '' && $id > -1){
        $query.='seccionName=:section and id=:id';
      }
      else if ($section != ''){
        $query.='seccionName=:section';
      }
      else if ($id > -1){
        $query .= 'id=:id';
      }
      try{
        $sentence = $connection->prepare($query);
        if($section != '' && $id > -1){
          $sentence->bindValue(':section',$section,PDO::PARAM_STR);
          $sentence->bindValue(':id',$id,PDO::PARAM_INT);
        }
        else if ($section != ''){
          $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        }
        else if ($id > -1){
          $sentence->bindValue(':id',$id,PDO::PARAM_INT);
        }
        $sentence->execute();
        parent::desconectar($connection);
        return true;
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return false;
    }
    public function updateSection($id,$newVal){
      $connection = parent::conectar();
      $query = 'UPDATE '.SECTIONS.' SET seccionName=:newVal WHERE id=:id';

      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':newVal',$newVal,PDO::PARAM_STR);
        $sentence->bindValue(':id',$id,PDO::PARAM_INT);
        $sentence->execute();
        parent::desconectar($connection);
        return true;
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return false;
    }
  }
?>
