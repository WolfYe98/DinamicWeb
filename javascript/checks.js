let checkAllInputs = () => {
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
  if (!checkEmail()){
    paro = false;
    alert('Email invalido');
  }
  if(document.getElementById('passwd') != null && document.getElementById('passwd').value != ''){
    if(!checkPassword()){
      paro = false;
      alert('La contraseña debe tener al menos una letra mayuscula, una minuscula, un digito y un caracter especial');
    }
  }
  return paro;
}

let checkEmail = ()=>{
  let emailInput = document.getElementById('email');
  if (emailInput != null){
    emailInput = emailInput.value;
    let expresionMail = /^\w+([\.-]*\w*)*@\w+([\.-]*\w*)*\.(\w{2,4})+$/;
    let correct = true;
    if(!expresionMail.test(emailInput)){
      correct = false;
    }
    return correct;
  }
  return true;
}
let checkPassword = ()=>{
  let password = document.getElementById('passwd').value;
  if(password != null){
    password=password.value;
    let lowExpersion = /(?=.*[a-z])/;
    let upExpresion = /(?=.*[A-Z])/;
    let numbExpresion = /(?=.*[0-9])/;

    let nice = true;
    if(!lowExpersion.test(password)){ nice = false; }
    if(!upExpresion.test(password)){ nice = false; }
    if(!numbExpresion.test(password)){ nice = false; }
    return nice;
  }
  return true;
}
