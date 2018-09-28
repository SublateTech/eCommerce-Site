//Chrome Drop Down Menu- Author: Dynamic Drive (http://www.dynamicdrive.com)
//Last updated: Jan 1st, 06'

var cssdropdown={
disappeardelay: 250, //set delay in miliseconds before menu disappears onmouseout

//No need to edit beyond here////////////////////////
dropmenuobj: null, ie: document.all, firefox: document.getElementById&&!document.all,

getposOffset:function(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset 
},

showhide:function(obj, e, visible, hidden){
if (this.ie || this.firefox)
this.dropmenuobj.style.left=this.dropmenuobj.style.top="-500px"
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
obj.visibility=visible
else if (e.type=="click")
obj.visibility=hidden
},

iecompattest:function(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
},

clearbrowseredge:function(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=this.ie && !window.opera? this.iecompattest().scrollLeft+this.iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
this.dropmenuobj.contentmeasure=this.dropmenuobj.offsetWidth
if (windowedge-this.dropmenuobj.x < this.dropmenuobj.contentmeasure)  //move menu to the left?
edgeoffset=this.dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=this.ie && !window.opera? this.iecompattest().scrollTop : window.pageYOffset
var windowedge=this.ie && !window.opera? this.iecompattest().scrollTop+this.iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
this.dropmenuobj.contentmeasure=this.dropmenuobj.offsetHeight
if (windowedge-this.dropmenuobj.y < this.dropmenuobj.contentmeasure){ //move up?
edgeoffset=this.dropmenuobj.contentmeasure+obj.offsetHeight
if ((this.dropmenuobj.y-topedge)<this.dropmenuobj.contentmeasure) //up no good either?
edgeoffset=this.dropmenuobj.y+obj.offsetHeight-topedge
}
}
return edgeoffset
},

dropit:function(obj, e, dropmenuID){
if (this.dropmenuobj!=null) //hide previous menu
{
this.dropmenuobj.style.visibility="hidden"
}
this.clearhidemenu()
this.dropmenuobj=document.getElementById(dropmenuID)
//to use CurbyCorners temporary
//this.dropmenuobj.style.position="relative"

if (this.ie||this.firefox){
obj.onmouseout=function(){cssdropdown.delayhidemenu()}
this.dropmenuobj=document.getElementById(dropmenuID)
this.dropmenuobj.onmouseover=function(){cssdropdown.clearhidemenu()}
this.dropmenuobj.onmouseout=function(){cssdropdown.dynamichide(e)}
this.dropmenuobj.onclick=function(){cssdropdown.delayhidemenu()}
this.showhide(this.dropmenuobj.style, e, "visible", "hidden")
this.dropmenuobj.x=this.getposOffset(obj, "left") - 2
this.dropmenuobj.y=this.getposOffset(obj, "top") //- 40
this.dropmenuobj.style.left=this.dropmenuobj.x-this.clearbrowseredge(obj, "rightedge")+"px"
this.dropmenuobj.style.top=this.dropmenuobj.y-this.clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
}
},

contains_firefox:function(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
},

dynamichide:function(e){
var evtobj=window.event? window.event : e
if (this.ie&&!this.dropmenuobj.contains(evtobj.toElement))
this.delayhidemenu()
else if (this.firefox&&e.currentTarget!= evtobj.relatedTarget&& !this.contains_firefox(evtobj.currentTarget, evtobj.relatedTarget))
this.delayhidemenu()
},

delayhidemenu:function(){
this.delayhide=setTimeout("cssdropdown.dropmenuobj.style.visibility='hidden'",this.disappeardelay)
},

clearhidemenu:function(){
if (this.delayhide!="undefined")
clearTimeout(this.delayhide)
}
}

var win = null;
function NewWindow(mypage,myname,w,h,features) {
  var winl = (screen.width-w)/2;
  var wint = (screen.height-h)/2;
  if (winl < 0) winl = 0;
  if (wint < 0) wint = 0;
  var settings = 'height=' + h + ',';
  settings += 'width=' + w + ',';
  settings += 'top=' + wint + ',';
  settings += 'left=' + winl + ',';
  settings += 'status=no , menubar=no , location=no , directories = no';
  win = window.open(mypage,myname,settings);
  win.window.focus();
}


/*
 * Cookie
 */


function setCookie(cookieName,cookieValue,nDays,domain) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)
                 + ";path=/"
                 + ";expires="+expire.toGMTString()
                 + ";domain=" + domain;
}


function deleteCookie(name, domain)
{
    alert("delete cookie function");
    if (getCookie(name))
    {
        alert("getcookie has worked");
        document.cookie = name + "=" +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}


function getCookie(name)
{
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1)
    {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1)
    {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

	function kadabra(zap) {

				 if (document.getElementById) {
					  var abra = document.getElementById(zap).style;
					  if (abra.display == "block") {
							   abra.display = "none";
					  } else {
							   abra.display = "block";
					  } 
					  return false;
				  } else {	
					  	return true;
					}	
				}
				
	// quick browser tests
	var ns4 = (document.layers) ? true : false;
	var ie4 = (document.all && !document.getElementById) ? true : false;
	var ie5 = (document.all && document.getElementById) ? true : false;
	var ns6 = (!document.all && document.getElementById) ? true : false;

	function show(sw,obj) 
		{
		// show/hide the divisions
		if (sw && (ie4 || ie5) ) document.all[obj].style.visibility = 'visible';
		if (!sw && (ie4 || ie5) ) document.all[obj].style.visibility = 'hidden';
		if (sw && ns4) document.layers[obj].visibility = 'visible';
		if (!sw && ns4) document.layers[obj].visibility = 'hidden';
		}
