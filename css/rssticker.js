// -------------------------------------------------------------------
// Advanced RSS Ticker (Ajax invocation) core file
// Author: Dynamic Drive (http://www.dynamicdrive.com)
// -------------------------------------------------------------------

//Relative URL syntax:
var lastrssbridgeurl="lastrss/bridge.php"

//Absolute URL syntax. Uncomment below line if you wish to use an absolute reference:
//var lastrssbridgeurl="http://"+window.location.hostname+"/lastrss/bridge.php"

////////////No need to edit beyond here//////////////

function createAjaxObj(){
var httprequest=false
// if Mozilla, Safari etc
  if (window.XMLHttpRequest) 
    httprequest = new XMLHttpRequest()
  // if IE
  else if (window.ActiveXObject){ 
    try {
      httprequest = new ActiveXObject("Msxml2.XMLHTTP")
    } 
    catch (e){
      try{ 
	  httprequest = new ActiveXObject("Microsoft.XMLHTTP") 
	  }catch (e){}
    }
  }else{
    alert('This Browser do not support AJAX-Technology!');
    return ;
  }

	
return httprequest
}

// -------------------------------------------------------------------
// Main RSS Ticker Object function
// rssticker_ajax(RSS_id, cachetime, divId, divClass, delay, optionallogicswitch)
// -------------------------------------------------------------------

function rssticker_ajax(RSS_id, cachetime, divId, divClass, delay, logicswitch){
this.RSS_id=RSS_id //Array key indicating which RSS feed to display
this.cachetime=cachetime //Time to cache feed, in minutes. 0=no cache.
this.tickerid=divId //ID of ticker div to display information
this.delay=delay //Delay between msg change, in miliseconds.
this.logicswitch=(typeof logicswitch!="undefined")? logicswitch : ""
this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over ticker (and pause it if it is)
this.pointer=0
this.opacitysetting=0.2 //Opacity value when reset. Internal use.
this.title=[], this.link=[], this.description=[], this.pubdate=[] //Arrays to hold each component of an RSS item
this.ajaxobj=createAjaxObj()
document.write('<div id="'+divId+'" class="'+divClass+'" >Initializing ticker...</div>')
if (window.getComputedStyle) //detect if moz-opacity is defined in external CSS for specified class
this.mozopacityisdefined=(window.getComputedStyle(document.getElementById(this.tickerid), "").getPropertyValue("-moz-opacity")==1)? 0 : 1
this.getAjaxcontent()
}

// -------------------------------------------------------------------
// getAjaxcontent()- Makes asynchronous GET request to "bridge.php" with the supplied parameters
// -------------------------------------------------------------------

rssticker_ajax.prototype.getAjaxcontent=function(){
if (this.ajaxobj){
var instanceOfTicker=this
var parameters="id="+encodeURIComponent(this.RSS_id)+"&cachetime="+this.cachetime+"&bustcache="+new Date().getTime()
this.ajaxobj.onreadystatechange=function(){instanceOfTicker.initialize()}
this.ajaxobj.open('GET', lastrssbridgeurl+"?"+parameters, true)
this.ajaxobj.send(null)
}
}

// -------------------------------------------------------------------
// initialize()- Initialize ticker method.
// -Gets contents of RSS content and parse it using JavaScript DOM methods 
// -------------------------------------------------------------------

rssticker_ajax.prototype.initialize=function(){ 
if (this.ajaxobj.readyState == 4){ //if request of file completed
if (this.ajaxobj.status==200){ //if request was successful
var xmldata=this.ajaxobj.responseXML
if(xmldata.getElementsByTagName("item").length==0){ //if no <item> elements found in returned content
document.getElementById(this.tickerid).innerHTML="<b>Error</b> fetching remote RSS feed!<br />"+this.ajaxobj.responseText
return
}
var instanceOfTicker=this
this.feeditems=xmldata.getElementsByTagName("item")
//Cycle through RSS XML object and store each peice of an item inside a corresponding array
for (var i=0; i<this.feeditems.length; i++)
	{
	this.title[i]=this.feeditems[i].getElementsByTagName("title")[0].firstChild.nodeValue
	this.link[i]=this.feeditems[i].getElementsByTagName("link")[0].firstChild.nodeValue
	this.description[i]=this.feeditems[i].getElementsByTagName("description")[0].firstChild.nodeValue
	this.pubdate[i]=this.feeditems[i].getElementsByTagName("pubDate")[0].firstChild.nodeValue
	}
document.getElementById(this.tickerid).onmouseover=function(){instanceOfTicker.mouseoverBol=1}
document.getElementById(this.tickerid).onmouseout=function(){instanceOfTicker.mouseoverBol=0}
this.rotatemsg()
}
}
}

// -------------------------------------------------------------------
// rotatemsg()- Rotate through RSS messages and displays them
// -------------------------------------------------------------------

rssticker_ajax.prototype.rotatemsg=function(){
var instanceOfTicker=this
if (this.mouseoverBol==1) //if mouse is currently over ticker, do nothing (pause it)
setTimeout(function(){instanceOfTicker.rotatemsg()}, 100)
else{ //else, construct item, show and rotate it!
var tickerDiv=document.getElementById(this.tickerid)
var linktitle='<div class="rsstitle"><a href="'+this.link[this.pointer]+'">'+this.title[this.pointer]+'</a></div>'
var description='<div class="rssdescription">'+this.description[this.pointer]+'</div>'
var feeddate='<div class="rssdate">'+this.pubdate[this.pointer]+'</div>'
if (this.logicswitch.indexOf("description")==-1) description=""
if (this.logicswitch.indexOf("date")==-1) feeddate=""
var tickercontent=linktitle+feeddate+description //STRING FOR FEED CONTENTS 
this.fadetransition("reset") //FADE EFFECT- RESET OPACITY
tickerDiv.innerHTML=tickercontent
this.fadetimer1=setInterval(function(){instanceOfTicker.fadetransition('up', 'fadetimer1')}, 100) //FADE EFFECT- PLAY IT
this.pointer=(this.pointer<this.feeditems.length-1)? this.pointer+1 : 0
setTimeout(function(){instanceOfTicker.rotatemsg()}, this.delay) //update container every second
}
}

// -------------------------------------------------------------------
// fadetransition()- cross browser fade method for IE5.5+ and Mozilla/Firefox
// -------------------------------------------------------------------

rssticker_ajax.prototype.fadetransition=function(fadetype, timerid){
var tickerDiv=document.getElementById(this.tickerid)
if (fadetype=="reset")
this.opacitysetting=0.2
if (tickerDiv.filters && tickerDiv.filters[0]){
if (typeof tickerDiv.filters[0].opacity=="number") //IE6+
tickerDiv.filters[0].opacity=this.opacitysetting*100
else //IE 5.5
tickerDiv.style.filter="alpha(opacity="+this.opacitysetting*100+")"
}
else if (typeof tickerDiv.style.MozOpacity!="undefined" && this.mozopacityisdefined){
tickerDiv.style.MozOpacity=this.opacitysetting
}
if (fadetype=="up")
this.opacitysetting+=0.2
if (fadetype=="up" && this.opacitysetting>=1)
clearInterval(this[timerid])
}

// -------------------------------------------------------------------
// Ajax XML Ticker (txt file source)
// Author: Dynamic Drive (http://www.dynamicdrive.com)
// -------------------------------------------------------------------

////////////No need to edit beyond here//////////////

// -------------------------------------------------------------------
// Main Ajax Ticker Object function
// ajax_ticker(xmlfile, divId, divClass, delay, optionalfadeornot)
// -------------------------------------------------------------------

function ajax_ticker(xmlfile, divId, divClass, delay, fadeornot){
this.xmlfile=xmlfile //Variable pointing to the local ticker xml file (txt)
this.tickerid=divId //ID of ticker div to display information
this.delay=delay //Delay between msg change, in miliseconds.
this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over ticker (and pause it if it is)
this.pointer=0
this.opacitystring=(typeof fadeornot!="undefined")? "width: 100%; filter:progid:DXImageTransform.Microsoft.alpha(opacity=100); -moz-opacity: 1" : ""
if (this.opacitystring!="") this.delay+=500 //add 1/2 sec to account for fade effect, if enabled
this.opacitysetting=0.2 //Opacity value when reset. Internal use.
this.messages=[] //Arrays to hold each message of ticker
this.ajaxobj=createAjaxObj()
document.write('<div id="'+divId+'" class="'+divClass+'"><div style="'+this.opacitystring+'">Initializing ticker...</div></div>')
this.getXMLfile()
}

// -------------------------------------------------------------------
// getXMLfile()- Use Ajax to fetch xml file (txt)
// -------------------------------------------------------------------

ajax_ticker.prototype.getXMLfile=function(){
if (this.ajaxobj){
	var instanceOfTicker=this
	var url=this.xmlfile+"?bustcache="+new Date().getTime()
	this.ajaxobj.onreadystatechange=function(){instanceOfTicker.initialize()}
	this.ajaxobj.open('GET', url, true)
	this.ajaxobj.send(null)
	}
}

// -------------------------------------------------------------------
// initialize()- Initialize ticker method.
// -Gets contents of xml file and parse it using JavaScript DOM methods 
// -------------------------------------------------------------------

ajax_ticker.prototype.initialize=function(){ 
if (this.ajaxobj.readyState == 4){ //if request of file completed
	if (this.ajaxobj.status==200 || window.location.href.indexOf("http")==-1){ //if request was successful
		this.contentdiv=document.getElementById(this.tickerid).firstChild //div of inner content that holds the messages
		var xmldata=this.ajaxobj.responseText
		this.contentdiv.style.display="none"
		this.contentdiv.innerHTML=xmldata
		if (this.contentdiv.getElementsByTagName("div").length==0){ //if no messages were found
			this.contentdiv.innerHTML="<b>Error</b> fetching remote ticker file!"
			return
			}
	var instanceOfTicker=this
	document.getElementById(this.tickerid).onmouseover=function(){instanceOfTicker.mouseoverBol=1}
	document.getElementById(this.tickerid).onmouseout=function(){instanceOfTicker.mouseoverBol=0}
	if (window.attachEvent) //Clean up loose references in IE
		window.attachEvent("onunload", function(){instanceOfTicker.contentdiv=instanceOfTicker.ajaxobj=null})
		//	Cycle through XML object and store each message inside array
	for (var i=0; i<this.contentdiv.getElementsByTagName("div").length; i++){
		if (this.contentdiv.getElementsByTagName("div")[i].className=="message")
			this.messages[this.messages.length]=this.contentdiv.getElementsByTagName("div")[i].innerHTML
			}
	this.contentdiv.innerHTML=""
	this.contentdiv.style.display="block"
	this.rotatemsg()
	}
}
}

// -------------------------------------------------------------------
// rotatemsg()- Rotate through ticker messages and displays them
// -------------------------------------------------------------------

ajax_ticker.prototype.rotatemsg=function(){
var instanceOfTicker=this
if (this.mouseoverBol==1) //if mouse is currently over ticker, do nothing (pause it)
	setTimeout(function(){instanceOfTicker.rotatemsg()}, 100)
else{ //else, construct item, show and rotate it!
	this.fadetransition("reset") //FADE EFFECT- RESET OPACITY
	this.contentdiv.innerHTML=this.messages[this.pointer]
	this.fadetimer1=setInterval(function(){instanceOfTicker.fadetransition('up', 'fadetimer1')}, 100) //FADE EFFECT- PLAY IT
	this.pointer=(this.pointer<this.messages.length-1)? this.pointer+1 : 0
	setTimeout(function(){instanceOfTicker.rotatemsg()}, this.delay) //update container periodically
	}
}

// -------------------------------------------------------------------
// fadetransition()- cross browser fade method for IE5.5+ and Mozilla/Firefox
// -------------------------------------------------------------------

ajax_ticker.prototype.fadetransition=function(fadetype, timerid){
var contentdiv=this.contentdiv
if (fadetype=="reset")
this.opacitysetting=0.2
if (contentdiv.filters && contentdiv.filters[0]){
	if (typeof contentdiv.filters[0].opacity=="number") //IE6+
		contentdiv.filters[0].opacity=this.opacitysetting*100
	else //IE 5.5
		contentdiv.style.filter="alpha(opacity="+this.opacitysetting*100+")"
	}
else if (typeof contentdiv.style.MozOpacity!="undefined" && this.opacitystring!=""){
	contentdiv.style.MozOpacity=this.opacitysetting
	}
	else
		this.opacitysetting=1
if (fadetype=="up")
	this.opacitysetting+=0.1
if (fadetype=="up" && this.opacitysetting>=1)
	clearInterval(this[timerid])
}

function addEvent(obj, evType, fn){ 
 if (obj.addEventListener){ 
   obj.addEventListener(evType, fn, false); 
   return true; 
 } else if (obj.attachEvent){ 
   var r = obj.attachEvent("on"+evType, fn); 
   return r; 
 } else { 
   return false; 
 } 
}


