
var navAction = function()
{
  $this = this;
  this.item;
  this.nav;
  
  var dates = _$("#fields");
  var inputs = dates.getElementsByTagName("input");
  
  //Get Fields
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
  var nav = document.getElementById("nav2");
  var field = nav.getElementsByTagName("li");
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  var select = document.getElementById("content");
  var options = select.getElementsByTagName('select');
  var sendForm = document.getElementById("submit");
  var form = _$("#sendData")
  var form2 = document.getElementById("items2")
  //Set eventAdds
    eventAdd(_$("#delete"),"click",function(){$this.removeItem();});
  eventAdd(_$("#teste"),"click",function(){$this.addItem()});
  eventAdd(field[1],"click",function(){$this.requestItems('Unidades');});
  eventAdd(field[2],"click",function(){$this.nav=1;$this.state();});
  eventAdd(field[3],"click",function(){$this.nav=1;$this.city()});
  eventAdd(field[4],"click",function(){$this.nav=1;$this.region()});
  eventAdd(field[5],"click",function(){$this.requestItems('Gerentes');});
  eventAdd(field[6],"click",function(){$this.requestItems('Representantes');});
  eventAdd(field[7],"click",function(){$this.requestItems('Canais');});
  eventAdd(field[8],"click",function(){$this.requestItems('Segmentos');});
  eventAdd(field[9],"click",function(){$this.requestItems('Marcas');});
  eventAdd(field[10],"click",function(){$this.requestItems('Linhas');});
  eventAdd(field[11],"click",function(){$this.requestItems('Grupos');});
  eventAdd(field[12],"click",function(){$this.requestItems('Produtos');});
  eventAdd(field[13],"click",function(){$this.requestItems('Clientes');});
  eventAdd(inputs[0],"blur",function(){$this.getDate()});
  eventAdd(inputs[1],"blur",function(){$this.getDate()});
  eventAdd(sendForm,"click",function(){$this.sendData()});
  eventAdd(form,"dblclick",function(){$this.removeItem()});
  
  if(_$("#nav3") || _$("#nav4")){
  if(_$("#nav3")){
    var nava = _$("#nav3");
    var field = nava._$("li");
    var z = 2;
  }else if(_$("#nav4")){
    var nava = _$("#nav4");
    var field = nava._$("li"); 
    var z = 3;
  }
  
  eventAdd(field[1],"click",function(){$this.requestItems('Unidades',z)});
    eventAdd(field[2],"click",function(){$this.nav=z;$this.state()});
    eventAdd(field[3],"click",function(){$this.nav=z;$this.city()});
    eventAdd(field[4],"click",function(){$this.nav=z;$this.region()});
    eventAdd(field[5],"click",function(){$this.requestItems('Gerentes',z);});
    eventAdd(field[6],"click",function(){$this.requestItems('Representantes',z);});
    eventAdd(field[7],"click",function(){$this.requestItems('Canais',z);});
    eventAdd(field[8],"click",function(){$this.requestItems('Segmentos',z);});
    eventAdd(field[9],"click",function(){$this.requestItems('Marcas',z);});
    eventAdd(field[10],"click",function(){$this.requestItems('Linhas',z);});
    eventAdd(field[11],"click",function(){$this.requestItems('Grupos',z);});
    eventAdd(field[12],"click",function(){$this.requestItems('Produtos',z);});
    eventAdd(field[13],"click",function(){$this.requestItems('Clientes',z);});
    eventAdd(form2,"dblclick",function(){$this.nav=z;$this.removeItem()});
  }
/*************************************
  Functions that shows data for
  include in queries
**************************************/

  /* Name: requestItems
   * Description: Return list of items
   * Parameters: itemName -> Label name
   *             nav -> Defines nav
   */

  this.requestItems = function(itemName,nav){
    // Chosen nav or the only one
    $this.nav = nav || 1;
    // Item label
    $this.item = itemName;
    //
    if(nav == 2){
      addSecond(); 
      return false;
    }
    // Initialize ajax class
    var async = new ajax();
    // Get properties
    async.getProperties("centerNava","/vendas/controller/frontEnd.php","action=getItems&item="+itemName);
    // Send request
    async.send();
  }
  
  /* Name: checkOptLabel
   * Description: Check if an label exist in menu
   * Parameters: label -> Name of label to check.
   */

  this.checkOptLabel = function(label){
    //Nav that receive data
    var items = $this.nav == 1 ? _$('#items') : _$("#items2");
    var labels = items._$("OPTGROUP");
    var limit = labels.length;
    for(var x=0;x<limit;x++){
      if(labels[x].label == label){
        return true;
      }
    }
    return false;
  }

  /* Name: checkOptLabel
   * Description: Check if an label exist in menu
   * Parameters: label -> Name of label to check.
   */
  //Show regions
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  this.region = function(){
    $this.item = 'Região';
    if($this.nav == 1){var items = document.getElementById('items');}
    else{var items = document.getElementById('items2');}
    
    if($this.checkOptLabel("Estado")){
      alert("Você já escolheu um estado");
        return false;
      }
    // Initialize ajax class
    var async = new ajax();
    //
    async.getProperties("centerNava","/vendas/controller/frontEnd.php","action=getItems&item=Regiao");
    async.send();
    
   
  }
  
  //Show cities
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  this.city = function()
  {
    $this.item = 'Cidade'
    var string ="";
    //Nav that receive data
    var items = $this.nav == 1 ? _$('#items') : _$("#items2");
    if($this.nav == 2){addSecond();return false;}
    //if($this.nav == 1){}
    //else{addSecond(); return false;}
    var async = new ajax();
    //
    var news = "BA";
    async.getProperties("centerNava","/vendas/controller/frontEnd.php","action=getItems&item=Cidades&estado="+news);
    async.send();
    return true;
    /*
    var getLabels = items.getElementsByTagName("OPTGROUP");
    var limit = getLabels.length;
    for(var x=0;x<limit;x++)
    {
      if(getLabels[x].label == 'Estado')
      {
        var options = getLabels[x].getElementsByTagName('option');
        var len = options.length
        for(var y=0;y<len;y++)
        {
          string += "'"+options[y].value+"'";
          y < len-1 ? string += "," : '';
        }
        var ptern = /Estado-/gi;
        var news = string.replace(ptern,'');
        
      }
      
      // Initialize ajax class
        var async = new ajax();
        //
        async.getProperties("centerNava","/vendas/controller/frontEnd.php","action=getItems&item=Cidades&estado="+news);
        async.send();
        return true;
    }
    alert("Por favor escolha um ou mais Estados");*/
  }
  
  //Show States
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
  this.state = function(){
    $this.item = 'Estado';
    if($this.nav == 2){addSecond();return false;}
    var items = document.getElementById('items');
    
    if($this.checkOptLabel("Região")){
      alert("Você já escolheu uma região");
      return false;
    }
    
      // Initialize ajax class
      var async = new ajax();
      //
      async.getProperties("centerNava","/vendas/controller/frontEnd.php","action=getItems&item=Estados");
      async.send();
    
  }
  
  
  //Get Date
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  
  
  this.getDate = function(){
    
    var pattern = /[0-9\-\\]/g;
    // Check date field 1
    var check = pattern.test(inputs[0].value);
    // Check date field 2
    var check2 = pattern.test(inputs[1].value);
    if(!(check || check2)){
      // Disable submit button
      _$("#submit").disabled = true;
    }
    else{
      // Enable submit button
      _$("#submit").disabled = false
      console.log(inputs);
      // Period
      var data = inputs[0].value +','+ inputs[1].value
      
      // Get date input
      var y = _$("#sendData")._$("input");
      // Set value
      y[0].value = data;
      if(inputs[2] && inputs[3]){
         var data2 = inputs[2].value +','+ inputs[3].value
         y[1].value = data2;
      }
    }
  }
  
  //Select data to send
  //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
  
  this.sendData = function()
  {
    var y = document.getElementById("sendData");
    var w = y.getElementsByTagName("OPTION");
    var limit = w.length;
   
    for(x=0;x<limit;x++)
    {
      console.log(w[x]);
      w[x].selected = true;
    }
  }
      
 this.checkItem = function(item)
  {

    //Nav that receive data
    var items = document.getElementById('items');

    //Get options of 'items'
    var getOptions = items.getElementsByTagName("option");

    //Count options
    var numOptions = getOptions.length

    var obj = item;
    var option = item.value;

    //Get 'items' optgroup's label
    var getLabels = items.getElementsByTagName("OPTGROUP");

    var limit = getLabels.length;

      //Check if exists equal items or not  
      for(i=0;i<numOptions;i++)
      {
        if(getOptions[i].value == $this.item+'-'+option)
        {
          alert(option+" já foi selecionado");
          console.log(option);
          return false;
        }
      }


    for(var x=0;x<limit;x++)    
    {
      
      if(getLabels[x].label == $this.item)
      {
        var opt = document.createElement("OPTION");
        opt.value = $this.item+"-"+option;
        opt.text = option;
        opt.name = option;
        getLabels[x].appendChild(opt);
        return false;
      }
    }

    return true;
  }

  
  //Function that add items to analyze

  this.addItem = function(){
    //Nav that receive data
    var items = $this.nav == 1 ? _$('#items') : _$("#items2");
    // Get labels in destiny container
    var itemLabels = items._$("OPTGROUP");
    // Get options in destiny container
    var itemOptions = items._$("option");
    // Source data
    var source = _$("#centerNava");
    // Source options
    var sourceOptions = source._$("option");
    //Get number of options in source container
    var sourceLimit = source.length;
    // Unselect duplicate items
    this.checkDuplicate(source,items);

    // :: For ::
    teste: for(var x=0;x<sourceLimit;x++){
      // If is not selected, skip
      if(!sourceOptions[x].selected) continue;
      else sourceOptions[x].selected = false;
      // Get text
      var iActive = sourceOptions[x].label;

      // :: For ::
      for(var y=0;y<itemLabels.length;y++){
        
        if(itemLabels[y].label == $this.item){
          var opt = document.createElement("OPTION");
          opt.value = $this.item+"-"+iActive;
          opt.text = iActive;
          opt.name = iActive;
          itemLabels[y].appendChild(opt);
            continue teste;
        }
      }
      
      var group = document.createElement("OPTGROUP");
      group.label = $this.item;
      group.name = $this.item;      
      var opt = document.createElement("OPTION");
      opt.value = $this.item+"-"+iActive;
      opt.text = iActive;
      opt.name = iActive;
      group.appendChild(opt);
      items.appendChild(group);;
      
    }
    

  }
  
  this.checkDuplicate = function(origin,destiny){
    var cache;
    // Get all origin options
    var originOptions = origin._$("option");
    // Origin length
    var originLength = originOptions.length;
    // Get all destiny options
    var destinyOptions = destiny._$("option");
    // Destiny length
    var destinyLength = destinyOptions.length
    
    // :: For ::
    for(var x=0;x<originLength;x++){
      var item = originOptions[x];
      if(!item.selected) continue;
      // :: For ::
      for(var y=0;y<destinyLength;y++){
        var destinyValue = destinyOptions[y].value.split("-")[1];
        console.log(item.value+"/"+destinyValue)
        if(item.value == destinyValue){
          // Unselect item
          item.selected = false;
        }
      }
    }
  }

  //Add second item
  //=-=-=-=-=-=-==--=
  
  function addSecond()
  {
    var items = document.getElementById('items2');
    var getOptions = items.getElementsByTagName("option");
    var numOptions = getOptions.length
    if(numOptions > 0){alert("Você já selecionou um item");return false;}
    var group = document.createElement("OPTGROUP");
    group.label = $this.item;
    group.name = $this.item;
    var opt = document.createElement("OPTION");

    if($this.nav == 2 ){opt.value = $this.item;}
    else{opt.value = $this.item+"-"+$this.item;}
    opt.text = $this.item;
    opt.name = $this.item;
    group.appendChild(opt);
    items.appendChild(group);
  
  }
    this.selectAll = function()
  {
    var source = document.getElementById("centerNava");

    //Get number of options in source container
    var sourceLimit = source.length;
    for(x=0;x<sourceLimit;x++)
    {
      var option = source.options[x]
      option.selected = true;
    }
  }
  
  //Function that remove items 
  this.removeItem = function(){
    var i;
    // Get options
    options = form._$("option");
    // Limit of options
    var limit = options.length;
    // :: For :: //
    for(i=0;i<limit;i++){
      // Refresh limit
      limit = options.length;
      // If there is option and is selectged
      if(options[i] != undefined && options[i].selected == true){
        // option value
        var value =  options[i].value;
        // Split value
        var group = value.split("-");
        // Remove item
        options[i].remove(options[i].selectedIndex);
        
        i = -1;
       
        var selected = group[0];  

    var opt = form.getElementsByTagName("optgroup");
    console.log(opt);
    for (var z=0;z<opt.length; z++)
    {
      console.log("z: "+z)
      if ( opt[z].label === selected ) 
      {
        if(opt[z].label == "Estado")
        {
          for (var w=0;w<opt.length; w++)
          {
            console.log(opt[w].label);
            if(opt[w].label == "Cidade")
            {
              group2 = opt[w];
            }
            else {group2 = '';}
          }
        }
       var  groupa = opt[z];
        var pa = groupa.parentNode;
        var opta = opt[z].getElementsByTagName("OPTION");
        var qntd = opta.length;
       if(qntd == 0){
        pa.removeChild(groupa);
        }
      }
    }
    
    
    

       
      }
    }

    
    
  
    
  }
}

window.onload=function(){var start = new navAction(); start.getDate()}



