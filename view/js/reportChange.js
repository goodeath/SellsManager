function include(file)
{
  var script  = document.createElement('script');
  script.src  = file;
  script.type = 'text/javascript';
  script.defer = true;
  document.getElementsByTagName('head').item(0).appendChild(script);
}
include("/vendas/view/js/class/ajax.js");

function turnRelat(value,value2,graphic)
{
 if(value2 == "Visão Geral")
 {
  ajax('/vendas/view/reports/'+graphic+'/values.php?'+value+'=true',"report");
  }
}
function showRelat(value,value2)
{
 
  if(value2 == "Visão Geral")
  {
    switch(value)
    {
      case 'Valores' :  ajax('/vendas/view/reports/evolution/values.php?Val=true',"report");break;
      case 'Quantidade' : ajax('/vendas/view/reports/evolution/values.php?Qntd=true',"report");break;
    }
  }
  else
  {
    value == 'Valores' ? send = 'Val=val' : send = 'Quantidade=true';

    switch(value2)
    {
      case 'Visão Geral': ajax('/vendas/view/reports/evolution/values.php?'+send,"report");break;
      case 'Unidades': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Unidade',"report");break;
      case 'Estado': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Estado',"report");break;
      case 'Cidade': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Cidade',"report");break;
      case 'Representante': ajax('/vendas/view/reports/evolution/values.php?'+send+'&Rep=Representante',"report");break;
      case 'Canais': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Canais',"report");break;
      case 'Marcas': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Marcas',"report");break;
      case 'Clientes': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Clientes',"report");break;
      case 'Produtos': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Produtos',"report");break;
      case 'Linhas': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Linhas',"report");break;
      case 'Segmentos': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Segmentos',"report");break;
      case 'Grupos': ajax('/vendas/view/reports/evolution/values.php?'+send+'&field=Grupos',"report");break;
    }
  }
 
}

function showRelat2(value2)
{
 
  if(value2 == "Visão Geral")
  {
    switch(value)
    {
      case 'Valores' :  ajax('/vendas/view/reports/comparison/values.php?Val=true',"report");break;
      case 'Quantidade' : ajax('/vendas/view/reports/comparison/values.php?Qntd=true',"report");break;
    }
  }
  
  }