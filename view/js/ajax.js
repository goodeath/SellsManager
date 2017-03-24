
  function ajax(){
		


    //Div to return
    this.div;

    //Name file
    this.file

    //Url prameters
    this.parameters 

    //Fix bug
    this.$this = this;

    this.func = undefined;

    this.args;

    this.response;

		this.send = function(){
      var xmlhttp = new XMLHttpRequest();
      var div = this.div;
      var $this = this.$this;
			xmlhttp.onreadystatechange=function()  {
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
            $this.response = xmlhttp.responseText;
            if(div != ''){document.getElementById(div).innerHTML = $this.response}

            if($this.func != undefined){
              if($this.args == "response"){$this.args = $this.response;}

              $this.func.call('',$this.args);
            }
            return $this.response;
					}
			}
      xmlhttp.open("POST",$this.file+"?"+$this.parameters,true);
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.send();
		}

    this.getProperties = function(div,file,parameters){

      this.div = div;

      this.file = file;

      this.parameters = parameters;
    }
	
	}