<?php
  require_once('DataBaseObject.inc');

  class Items extends DataBaseObject{
    public function checkItemExists($lugar){
      $connection = parent::conectar();
      $query = "SELECT id FROM ".ITEMS." WHERE lugar=:lugar";
      $exist = false;
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':lugar',$lugar,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        if(!empty($rows)){
          $exist = true;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta fallida: '.$e->getMessage());
      }
      return $exist;
    }
    public function createItem($lugar,$pais,$monumento,$descripcion,$imgPath,$section){
      if($this->checkItemExists($lugar)){return 'Item';}
      if(!$this->checkSectionExist($section)){return 'Section';}
      $connection = parent::conectar();
      $query = "INSERT INTO ".ITEMS." VALUES(:id,:lugar,:pais,:monumento,:descripcion,:imgPath,:section)";
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':id',0,PDO::PARAM_INT);
        $sentence->bindValue(':lugar',$lugar,PDO::PARAM_STR);
        $sentence->bindValue(':pais',$pais,PDO::PARAM_STR);
        $sentence->bindValue(':monumento',$monumento,PDO::PARAM_STR);
        $sentence->bindValue(':descripcion',$descripcion,PDO::PARAM_STR);
        $sentence->bindValue(':imgPath',$imgPath,PDO::PARAM_STR);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->execute();
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta fallida: '.$e->getMessage());
      }
      return true;
    }
    public function checkSectionExist($section){
      $exist = false;
      $connection = parent::conectar();
      $query = 'SELECT ID FROM '.SECTIONS.' WHERE seccionName=:section';
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
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
    public function getSectionItems($section){
      if(! $this->checkSectionExist($section)){return 'SectionNoItem';}
      $connection = parent::conectar();
      $query = 'SELECT lugar,pais,monumento,descripcion,imgPath,id FROM '.ITEMS.' WHERE section=:section';

      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        if(!empty($rows)){
          return $rows;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return false;
    }
    public function getItemByPlace($lugar){
      if(! $this->checkItemExists($lugar)){return 'ItemNotExist';}
      $connection = parent::conectar();
      $query = 'SELECT lugar,pais,monumento,descripcion,imgPath,section,id FROM '.ITEMS.' WHERE lugar=:lugar';

      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':lugar',$lugar,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        if(!empty($rows)){
          return $rows;
        }
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return false;
    }
    public function deleteItemByPlace($lugar){
      if(! $this->checkItemExists($lugar)){return 'ItemNotExist';}
      $connection = parent::conectar();
      $query = 'DELETE FROM '.ITEMS.' WHERE lugar=:lugar';

      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':lugar',$lugar,PDO::PARAM_STR);
        $sentence->execute();
        return true;
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return false;
    }
    public function deleteItemByID($id){
      $connection = parent::conectar();
      $query = 'DELETE FROM '.ITEMS.' WHERE id=:id';

      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':id',$id,PDO::PARAM_STR);
        $sentence->execute();
        parent::desconectar($connection);
        return true;
      }catch(PDOException $e){
        parent::desconectar($connection);
        die("Consulta Fallida: ". $e->getMessage());
      }
      return false;
    }
    public function updateItem($lugar,$pais,$monumento,$descripcion,$imgPath,$section,$id){
      if(!$this->checkItemExists($lugar)){return 'ItemNotExist';}
      if(!$this->checkSectionExist($section)){return 'Section';}
      $connection = parent::conectar();

      $query = "UPDATE ".ITEMS." SET lugar=:lugar, pais=:pais, monumento=:monumento, descripcion=:descripcion, section=:section";
      if ($imgPath != ""){
        $query .=",imgPath=:imgPath";
      }
      $query .= " WHERE id=:id";
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':lugar',$lugar,PDO::PARAM_STR);
        $sentence->bindValue(':pais',$pais,PDO::PARAM_STR);
        $sentence->bindValue(':monumento',$monumento,PDO::PARAM_STR);
        $sentence->bindValue(':descripcion',$descripcion,PDO::PARAM_STR);
        if ($imgPath != ""){
          $sentence->bindValue(':imgPath','./imagenes/'.$imgPath,PDO::PARAM_STR);
        }
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->bindValue(':id',$id,PDO::PARAM_INT);

        $sentence->execute();
        parent::desconectar($connection);
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta fallida: '.$e->getMessage());
      }
      return true;
    }

    public function biggestId($section){
      $connection = parent::conectar();
      $query = 'SELECT MAX(id) FROM '.ITEMS.' WHERE section=:section';
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        parent::desconectar($connection);
        if(!empty($rows)){
          return $rows[0][0];
        }
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta fallida: '.$e->getMessage());
      }
      return false;
    }
    public function lowerId($section){
      $connection = parent::conectar();
      $query = 'SELECT MIN(id) FROM '.ITEMS.' WHERE section=:section';
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        parent::desconectar($connection);
        if(!empty($rows)){
          return $rows[0][0];
        }
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta fallida: '.$e->getMessage());
      }
      return false;
    }
    public function nextItem($index,$id,$section){
      $connection = parent::conectar();
      $query = '';
      if ($index == 1){
        $maxID = $this->biggestId($section);
        if($maxID == false){
          return 'SectionNoItem';
        }
        $query = 'SELECT lugar,pais,monumento,descripcion,imgPath,section,id FROM '.ITEMS;
        if ($id == $maxID){
          $query.=' WHERE section=:section and id<:id ORDER BY id ASC';
        }
        else{
          $query.=' WHERE section=:section and id>:id ORDER BY id ASC';
        }
      }
      else if ($index == -1){
        $minID = $this->lowerId($section);
        if ($minID == false){
          return 'SectionNoItem';
        }
        $query = 'SELECT lugar,pais,monumento,descripcion,imgPath,section,id FROM '.ITEMS;
        if ($id == $minID){
          $query.=' WHERE section=:section and id>:id ORDER BY id DESC';
        }
        else{
          $query.=' WHERE section=:section and id<:id ORDER BY id DESC';
        }
      }
      try{
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->bindValue(':id',$id,PDO::PARAM_INT);
        $sentence->execute();

        $rows = $sentence->fetchAll();

        parent::desconectar($connection);
        if(! empty($rows)){
          return $rows[0];
        }
        else{
          return 'SectionNoItem';
        }
      }catch(PDOException $e){
        parent::desconectar($connection);
        die('Consulta fallida: '.$e->getMessage());
      }
      return false;
    }

    public function getNextItemsOfSection($section,$lastId,$direction){
      if(! $this->checkSectionExist($section)){return false;}
      $connection = parent::conectar();
      $signo = '<';
      $maximo = MAXITEMPERSECTION;
      if ($direction == 1){
        if ($lastId < $this->biggestId($section)){
          $signo = '>';
        }
      }
      if($direction == -1){
        if($lastId == $this->lowerId($section)){
          $signo = '>';
        }
      }
      $query = 'SELECT lugar,pais,monumento,descripcion,imgPath,id FROM '.ITEMS.' WHERE section=:section and id'.$signo.':id LIMIT '.$maximo;
      try {
        $sentence = $connection->prepare($query);
        $sentence->bindValue(':id',$lastId,PDO::PARAM_INT);
        $sentence->bindValue(':section',$section,PDO::PARAM_STR);
        $sentence->execute();
        $rows = $sentence->fetchAll();
        parent::desconectar($connection);
        if(!empty($rows)){
          return $rows;
        }
        return 'SectionNoItem';
      } catch (PDOException $e) {
        parent::desconectar($connection);
        die('Consulta Fallida: '.$e->getMessage());
      }
      return false;
    }
  }
?>
