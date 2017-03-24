 function active(nava)
    {
      var nav = document.getElementById("nav1");
      var buttons = nav.getElementsByTagName("li");
      buttons[nava].setAttribute("class","active");
    } 

window._$ = function(arg,obj){
  obj = obj || document;
  var a = arg.substr(0,1);
  var data = arg.substr(1);
  switch(a){
    case "#": var b = arg.substr(1);
              return obj.getElementById(b);break;
    case ".": return obj.getElementsByClassName(data);break;
    default: return obj.getElementsByTagName(data);
  }
}

Element.prototype._$ = function(arg){
  var obj = this || document;
  var a = arg.substr(0,1);
  var data = arg.substr(1);
  switch(a){
    case "#": var b = arg.substr(1);
              return obj.getElementById(b);break;
    case ".": return obj.getElementsByClassName(data);break;
    default: return obj.getElementsByTagName(arg);
  }
}

window.eventAdd = function(id,evento,funcao){
  // Get element
  var element = id;

  
  try{
    if(element.addEventListener)
      element.addEventListener(evento,funcao);
    else
      element.attachEvent('on'+evento,funcao);
  }
  catch(err){
    console.log("Erro ocorrido com o id: "+id+" Mensagem: "+err);
    console.log("Função: "+funcao)
  }
	
}

window.include = function(file)
{
  var script  = document.createElement('script');
  script.src  = file;
  script.defer = true;
  document.getElementsByTagName('head').item(0).appendChild(script);
}