<?php
  require_once("configuration.inc");
  class TagGenerator{
    private $tag = "";
    private $name = "";
    private $children = array();
    private $inner = "";
    private $endTag = "";


    public function __construct($tagName,$attributes=[]){
      $this->tag = "<".strtolower($tagName).">";
      $this->name = strtolower($tagName);
      $this->endTag = "</".$this->name.">";
      if(! empty($attributes)){
        $this->addVariousAtributesToTag($attributes);
      }
    }
    public function innerHTML($value){
      $this->inner = $value;
    }
    public function getTagName(){
      return $this->name;
    }

    public function addAtributeToTag($attribute,$value){
      if($this->tag != ""){
        $this->tag = substr_replace($this->tag," ".$attribute."=".'"'.$value.'"'.'>',-1);
      }
    }
    public function addAtributeToLastChild($attribute,$value){
      if (! empty($this->children)){
        $lastIndex = count($this->children)-1;
        $this->children[$lastIndex]->addAtributeToTag($attribute,$value);
      }
    }
    public function addVariousAtributesToTag($attributes){
      if(! empty($attributes)){
        foreach ($attributes as $key => $value) {
          $this->addAtributeToTag($key,$value);
        }
      }
    }
    public function addVariousAtributesToLastChild($attributes){
      if (! empty($this->children)){
        $lastIndex = count($this->children)-1;
        $this->children[$lastIndex]->addVariousAtributesToTag($attributes);
      }
    }
    public function addChildTag($childName){
      $child = new TagGenerator($childName);
      array_push($this->children,$child);
    }

    public function addChildObject($child){
      array_push($this->children,$child);
    }
    public function addChildrenObjects($childrenObjects){
      foreach ($childrenObjects as $child) {
        array_push($this->children,$child);
      }
    }
    public function returnHTML(){
      $html = "";
      if (empty($this->children)){
        $html = $this->tag.$this->inner.$this->endTag;
        if(array_key_exists($this->name,SPECIAL_TAGS)){
          $html = substr_replace($this->tag,'/>',-1);
        }
      }
      else{
        $html = $this->tag;
        foreach ($this->children as $obj) {
          $html .= $obj->returnHTML();
        }
        $html.=$this->endTag;
      }
      return $html;
    }
  }
?>
