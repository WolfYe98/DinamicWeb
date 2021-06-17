let checkInputsAndModifyEndl = ()=>{
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
  let imgPath = document.getElementById('file-selector').files;
  if (imgPath.length == 0){
    let seccion = document.getElementsByClassName('upload')[0];
    let tam = Array.from(seccion.children).length;
    if(tam < 4){
      let aviso = document.createElement('h1');
      aviso.innerHTML = 'Es obligatorio subir una imagen';
      aviso.style.color = 'red';
      seccion.appendChild(aviso);
      tam+=1;
    }
    else{
      Array.from(seccion.children)[tam-1].style.display = 'block';
    }
    setTimeout(quitarAviso,500);
    function quitarAviso(){
      Array.from(seccion.children)[tam-1].style.display = 'none';
    }
    paro = false;
  }
  if(paro){
    let descript = document.getElementById('description');
    descript.value = descript.value.replaceAll(/\r?\n/g,'<br>');

    $.ajax({
      url:'addItem.php',
      type:'POST',
      dataType: 'html',
      data:{
        lugar:document.getElementById('lugar').value,
        pais:document.getElementById('pais').value,
        monumento:document.getElementById('monumento').value,
        description:descript.value,
        imgPath:imgPath[0].name,
        section:String(document.getElementsByClassName('lista-desplegable')[0].value)
      }
    }).done(function(res){
      console.log(res);
      if(res=='Item'){
        alert('Ya existe un item con esta ciudad!');
      }
      else if(res == 1){
        alert('Item añadido con éxito!');
      }
      else if(res == 'Section'){
        alert('La seccion elegida no existe');
      }
      else{
        alert('SERVER INTERNAL ERROR!');
      }
      window.location.replace('index.php');
    });
  }
  return false;
}

let previewImage = ()=>{
  let fselector = document.getElementById('file-selector');
  let preview = document.getElementById('item-image');
  const [file] = fselector.files;
  if (file) {
    console.log(preview);
    preview.src = URL.createObjectURL(file);
  }
}
