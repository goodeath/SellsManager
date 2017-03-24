function printData(file,parameters)
{
  var con = document.getElementById("content");
  var field = con.getElementsByTagName("select");
  field[0].innerHTML = "";
  var xmlhttp;
  if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
    }
  else
    {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
    if(xmlhttp.readyState == 4 & xmlhttp.status == 200)
    {
      console.log(xmlhttp.responseText);
    field[0].innerHTML = xmlhttp.responseText;
    }
  }
  xmlhttp.open("post",file);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send(parameters)
}

function ajax(file,div)
{
  var xmlhttp;
  if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
    }
  else
    {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
    if(xmlhttp.readyState == 4 & xmlhttp.status == 200)
    {
    document.getElementById(div).innerHTML = xmlhttp.responseText;
    }
  }
  xmlhttp.open("POST",file);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send()
}
