let changeSectionItems = (direction)=>{
  let ids = Array.from(document.getElementsByClassName('ids'));
  let lastId = -1;
  let section = document.getElementById('section-name').innerHTML;

  if (ids == null){
    alert('No hay items en la sección actual');
    return
  }
  if (direction == 1){ lastId = ids[ids.length -1].value;}
  else if(direction == -1){lastId = ids[0].value;}
  $.ajax({
    url:'nextItems.php',
    type:'POST',
    dataType:'HTML',
    data:{
      id:lastId,
      direction:direction,
      section:section
    }
  }).done(function(res){
    if (res == 'SectionNoItem' || res == 0){
      alert('No hay más items en esta sección');
    }
    else{
      if (res.indexOf('article') == -1){
        console.log(res);
        alert('SERVER INTERNAL ERROR!');
      }
      else{
        document.getElementsByTagName('section')[0].innerHTML = res;
      }
    }
  });
}
