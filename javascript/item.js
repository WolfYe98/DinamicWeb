let checkAllItemInputs = () => {
  let form = document.getElementById('formulario');
  if(form == null){
    form = document.getElementsByClassName('formulario');
    form = form[0];
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


let modifyItem = ()=>{
  if(!checkAllItemInputs()){return false}
  let descrip = document.getElementById('description-area').value;
  let imgPath = document.getElementById('file-selector').files;
  let id = document.getElementById('item-id').value
  let path = '';
  if (imgPath.length > 0){
    path = imgPath[0].name;
  }
  descrip = descrip.replaceAll(/\r?\n/g,'<br>');
  $.ajax({
    url:'updateItem.php',
    type:'POST',
    dataType:'html',
    data:{
      lugar:document.getElementById('lugar').value,
      pais:document.getElementById('pais').value,
      monumento:document.getElementById('monumento').value,
      description: descrip,
      imgPath:path,
      section:String(document.getElementsByClassName('lista-desplegable')[0].value),
      id:id
    }
  }).done(function(res){
    if (res == 1){
      alert('Item Actualizado!');
    }
    else if (res == 'ItemNotExist'){
      alert('Este item NO EXISTE!');
    }
    else if(res == 'Section'){
      alert('Esta sección NO EXISTE');
    }
    else{
      alert('INTERNAL SERVER ERROR!!');
    }
    window.location.replace('index.php');
  });
  return false;
}

let changeItem = (index)=>{
  let id = document.getElementById('item-id').value;
  let section = document.getElementById('cab-main-section').innerHTML;

  $.ajax({
    url:'returnNextItem.php',
    type:'POST',
    dataType:'html',
    data:{
      id: id,
      section:section,
      index:index
    }
  }).done(function(res){
    if (res == 'SectionNoItem'){
      alert('No hay más items en esta sección');
    }
    else if (res == 0){
      alert('SERVER INTERNAL ERROR!');
    }
    else if(res.indexOf('NoMoreItems') != -1){
      alert('Este es el único item de la sección '+section+'!');
    }
    else{
      document.getElementById('no-edit-main').innerHTML = res;
    }
  });
}


let deleteItem = (id) => {
  console.log(id);
  $.ajax({
    url:'deleteItem.php',
    type:'POST',
    dataType:'html',
    data:{
      id:id
    }
  }).done(function(res){
    if(res == 1){
      let main = document.getElementById('no-edit-main');
      let aviso = document.createElement('h1');
      aviso.innerHTML = 'ITEM ELIMINDADO';
      while(main.firstChild){
        main.removeChild(main.firstChild);
      }
      main.style.justifyContent = 'center';
      main.style.alignItems = 'center';
      main.appendChild(aviso);
    }
    else{
      main.innerHTML = res;
    }
  });
}

let appearDetail = (index)=>{
  let detalles = document.getElementsByClassName('detalles')[index];
  detalles.style.transitionDuration = '0.6s';
  detalles.style.width = 'inherit';
  detalles.style.height = 'auto';
  detalles.style.display = 'block';
  detalles.style.position = 'absolute';
  detalles.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
  detalles.style.flexDirection = 'column';
  detalles.style.color = 'white';
  detalles.style.textAlign = 'center';
}

let disappearDetail = (index)=>{
  let detalles = document.getElementsByClassName('detalles')[index];
  detalles.style.transitionDuration = '0.6s';
  detalles.style.display = 'none';
}
