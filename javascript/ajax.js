/***********************************************
* Fixed ToolTip script- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
* Modified here to use max tooltip width by
* jscheuer1 in http://www.dynamicdrive.com/forums
***********************************************/

var tipwidth=300 //max tooltip width
var tipbgcolor='black' //tooltip bgcolor
var disappeardelay=250 //tooltip disappear speed onMouseout (in miliseconds)
var vertical_offset="0px" //horizontal offset of tooltip from anchor link
var horizontal_offset="-3px" //horizontal offset of tooltip from anchor link

/////No further editting needed
var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
 document.write('<div id="fixedtipdiv" style="visibility:hidden;max-width:'+tipwidth+'px;background-color:'+tipbgcolor+'" ></div>')
if (ie4&&fixedtipdiv.filters){
 document.write("<style type='text/css'>\n\
#fixedtipdiv {width:expression(Math.min(fix.offsetWidth, "+tipwidth+")+'px');}\n\
<\/style>")
 document.write('<span id="fix" style="border:none;padding:0;margin:0;visibility:hidden;position:absolute;z-index:-1;"></span>')
}
function getposOffset(what, offsettype){
 var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
 var parentEl=what.offsetParent;
 while (parentEl!=null){
  totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
  parentEl=parentEl.offsetParent;
 }
 return totaloffset;
}


function showhide(obj, e, visible, hidden)
{
 if (ie4||ns6)
  dropmenuobj.style.left=dropmenuobj.style.top=-500+'px'
 if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
  obj.visibility=visible
 else if (e.type=="click")
  obj.visibility=hidden
}

function iecompattest(){
 return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
 if (whichedge=="rightedge"){
  var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
  dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
  if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
   edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
 }
 else{
 var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
 dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
 if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
  edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
 }
return edgeoffset
}

function fixedtooltip(menucontents, obj, e)
{
 if (window.event) event.cancelBubble=true
 else if (e.stopPropagation) e.stopPropagation()
 clearhidetip()
 dropmenuobj=document.getElementById? document.getElementById("fixedtipdiv") : fixedtipdiv
 dropmenuobj.innerHTML='<font color=white>'+menucontents+'</font>'
 if (dropmenuobj.filters)
  fix.innerHTML=menucontents
 if (ie4||ns6){
  showhide(dropmenuobj.style, e, "visible", "hidden")
  dropmenuobj.x=getposOffset(obj, "left")
  dropmenuobj.y=getposOffset(obj, "top")
  dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
  dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
 }
}

function hidetip(e)
{
 if (typeof dropmenuobj!="undefined")
 {
  if (ie4||ns6)
  dropmenuobj.style.visibility="hidden"
 }
}

function delayhidetip()
{
 if (ie4||ns6)
  delayhide=setTimeout("hidetip()",disappeardelay)
}

function clearhidetip()
{
 if (typeof delayhide!="undefined")
  clearTimeout(delayhide)
}

function ajaxtooltip(Item_id, obj, e){
 if (window.event) event.cancelBubble=true
 else if (e.stopPropagation) e.stopPropagation()
  clearhidetip()
 dropmenuobj=document.getElementById? document.getElementById("fixedtipdiv") : fixedtipdiv
 dropmenuobj.innerHTML='<font color=white>Retrieving Data please wait...</font>'
 if (dropmenuobj.filters)
  fix.innerHTML=menucontents
 if (ie4||ns6){
  showhide(dropmenuobj.style, e, "visible", "hidden")
  dropmenuobj.x=getposOffset(obj, "left")
  dropmenuobj.y=getposOffset(obj, "top")
  dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
  dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px" 
 }
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
  if(xmlhttp.readyState==4)
  {document.getElementById('fixedtipdiv').innerHTML=xmlhttp.responseText}
 }
 xmlhttp.open("GET",'Item_rollover.php?id=' + Item_id,true);
 xmlhttp.send(null);
}