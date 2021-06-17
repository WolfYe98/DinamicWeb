let checkAllItemInputs = (opcion) => {
  let form = null
  if(opcion == 0){
    form = document.getElementById('modificar-secciones');
  }
  else{
    form = document.getElementById('add-section');
  }
  let children = Array.from(form.children);
  let paro = true;
  for (let i = 0; i < children.length; i++){
    if(children[i].value==""){
      children[i].style.transition = "1s";
      children[i].style.borderColor="red";
      children[i].style.boxShadow = "0px 0px 15px 2px red";
      setTimeout(vuelta,400);
      function vuelta(){
        if(children[i].style.borderColor!="white"){
          children[i].style.borderColor="white";
          children[i].style.boxShadow = "0px 0px 0px 0px ";
        }
      }
      paro = false;
    }
  }
  return paro;
}

let modificar = ()=>{
  if(!checkAllItemInputs(0)){
    return false;
  }
  let children = Array.from(document.getElementsByClassName('secciones'));
  let hiddens = Array.from(document.getElementsByClassName('ids'));
  let datas = {};
  for(let i = 0; i < hiddens.length; i++){
    datas[hiddens[i].value] = children[i].value;
  }

  $.ajax({
    url:'updateSection.php',
    type:'POST',
    dataType:'HTML',
    data:datas
  }).done(function(res){
    console.log(res);
    if (res == 1){
      alert('Secciones Actualizadas!');
    }
    else if (res == 0){
      alert('Algunas Secciones no se han modificado');
    }
    else{
      alert('Ha habido un error en el servidor');
    }
    window.location.reload();
  });
  return false;
}

let addSection = ()=>{
  if(! checkAllItemInputs(1)){return false;}
  let section = document.getElementById('new-section').value
  $.ajax({
    url:'addSection.php',
    type:'POST',
    dataType:'html',
    data:{
      section:section
    }
  }).done(function(res){
    if (res == 1){
      alert('Sección añadida');
      window.location.reload();
    }
    else if('SectionAlreadyExist'){
      alert('La sección ya existe');
    }
    else{
      alert('Ha habido un error en el servidor');
    }
  });
  return false;
}

let deleteSelectedSection = (id)=>{
  $.ajax({
    url:'deleteSection.php',
    type:'POST',
    dataType:'html',
    data:{
      id:id
    }
  }).done(function(res){
    if (res == 'SectionNotExist'){
      alert('No existe la sección a eliminar');
    }
    else if(res == 1){
      alert('Sección eliminado');
      window.location.reload();
    }
    else if (res == 0){
      alert('No se pudo borrar la sección');
    }
    else{
      console.log(res);
      alert('INTERNAL SERVER ERROR');
    }
  });
  return false;
}
