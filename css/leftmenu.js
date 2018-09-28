    // Impede Seleção
    document.onselectstart = function() { return false; }
  /*  var ar1 = document.getElementById("open");
		for (var i=0; i<ar1.length; i++){
					if (ar1[i].className=="open")
						ar1[i].style.display = "block"; */ 
		
	
	
    // Menu Lateral
    if (document.getElementById){
    document.write('<style type="text/css">\n')
    document.write('.options{display: none;}\n')
	//document.write('.open{display: none;}\n')
    document.write('</style>\n')
    }
    function SwitchMenu(obj){
    	if(document.getElementById){
    	var el = document.getElementById(obj);
    	var ar = document.getElementById("masterdiv").getElementsByTagName("span");
		/*var ar1 = document.getElementById("masterdiv").getElementsByTagName("open");*/
    		if(el.style.display != "block"){
    			for (var i=0; i<ar.length; i++){
    				if (ar[i].className=="options")
    					ar[i].style.display = "none";
		/*		for (var i=0; i<ar1.length; i++){
					if (ar1[i].className=="open")
						ar1[i].style.display = "block";*/
						
    			}
    			el.style.display = "block";
    		}else{
    			el.style.display = "none";
    		}
    	}
    }

function showm(obj) {
	   	var el = document.getElementById(obj);
    		if(el.style.display != "block"){
    			el.style.display = "block";
    		}else{
    			el.style.display = "none";
    		}
    	
    	
	}
	
