let checkModifyUser = ()=>{
  let form = document.getElementById('formulario');
  if(form == null){
    form = document.getElementsByClassName('formulario');
    form = form[0];
  }
  let children = Array.from(form.children);
  let paro = true;

  for (let i = 0; i < children.length; i++){
    if(children[i].id == 'passwd'){continue}
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
  if (!checkEmail()){
    paro = false;
    alert('Email invalido');
  }
  if(document.getElementById('passwd').value != ''){
    if(!checkPassword()){
      paro = false;
      alert('La contraseña debe tener al menos una letra mayuscula, una minuscula, un digito y un caracter especial');
    }
  }
  if(paro){
    $.ajax(
      {
        url:"./updateUser.php",
        type:'POST',
        dataType: 'html',
        data:{
          name:document.getElementById('nombre').value,
          user:document.getElementById('user-id').value,
          password:document.getElementById('passwd').value,
          tipo:document.getElementById('type').value,
          email:document.getElementById('email').value
        }
      }
    ).done(function(res){
      if(res==0){
        alert('Ha ocurrido un error, revise los campos y evite que los campos esenciales esten vacío');
      }
      else if(res == 1){
        alert('Usuario modificado con éxito!');
        window.location.replace('ModifyUserData.php');
      }
      else{
        alert('SERVER INTERNAL ERROR!');
        window.location.replace('index.php');
      }
    });
    paro = false;
  }

  return paro;
}
