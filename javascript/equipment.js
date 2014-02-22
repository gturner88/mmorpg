//DHTML Window script- Copyright Dynamic Drive (http://www.dynamicdrive.com)
//For full source code, documentation, and terms of usage,
//Visit http://www.dynamicdrive.com/dynamicindex9/dhtmlwindow.htm

document.write('<div id="eqwindow"style="z-index:10000;position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none" onSelectStart="return false"><div  onMousedown="initializedrageq(event)" onMouseup="stopdrageq()" style="z-index:10000;background-color:gray"><table width=100% border=0><td align=center>equipment</td><td align=right><img src="images/close.gif" onClick="closeequipment()"></td></table></div><div id="eqwindowcontent" style="height:100%"><div id=equipment style="background-color:black"><font color=white>Retrieving Data please wait...</font></div></div></div>')

var dragapprovedeq=false
var initialwidtheq,initialheighteq
var ie5eq=document.all&&document.getElementById
var ns6eq=document.getElementById&&!document.all

function iecompattesteq()
{
 return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function drag_dropeq(e){
 if (ie5eq&&dragapprovedeq&&event.button==1){
  document.getElementById("eqwindow").style.left=tempx+event.clientX-offsetx+"px"
  document.getElementById("eqwindow").style.top=tempy+event.clientY-offsety+"px"
 }
 else if (ns6eq&&dragapprovedeq){
  document.getElementById("eqwindow").style.left=tempx+e.clientX-offsetx+"px"
  document.getElementById("eqwindow").style.top=tempy+e.clientY-offsety+"px"
 }
}

function initializedrageq(e){
 offsetx=ie5eq? event.clientX : e.clientX
 offsety=ie5eq? event.clientY : e.clientY
 document.getElementById("eqwindowcontent").style.display="none" //extra
 tempx=parseInt(document.getElementById("eqwindow").style.left)
 tempy=parseInt(document.getElementById("eqwindow").style.top)
 document.getElementById("body").onSelectStart="return false"
 dragapprovedeq=true
 document.getElementById("body").onmousemove=drag_dropeq
}

function loadeq(url,width,height){
 if (!ie5eq&&!ns6eq)
  window.open(url,"","width=width,height=height,scrollbars=1")
  else{
   document.getElementById("eqwindow").style.display=''
   document.getElementById("eqwindow").style.width=initialwidtheq=width+"px"
   document.getElementById("eqwindow").style.height=initialheighteq=height+"px"
   document.getElementById("eqwindow").style.left="150px"
   document.getElementById("eqwindow").style.top=ns6eq? window.pageYOffset*1+200+"px" : iecompattesteq().scrollTop*1+200+"px"
  }
 loadequipment()
}

function closeequipment(){
 document.getElementById("eqwindow").style.display="none"
}

function stopdrageq(){
 dragapprovedeq=false;
 document.getElementById("body").onSelectStart=""
 document.getElementById("eqwindow").onmousemove=null;
 document.getElementById("eqwindowcontent").style.display="" //extra
}
function loadequipment()
{
 if (window.XMLHttpRequest) 
   {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttpeq=new XMLHttpRequest();
   }
 else
   {// code for IE6, ie5eq
   xmlhttpeq=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttpeq.onreadystatechange=function()
 {
 if(xmlhttpeq.readyState==4)
   {document.getElementById('equipment').innerHTML=xmlhttpeq.responseText}
 }
 xmlhttpeq.open("GET",'equipment.php',true);
 xmlhttpeq.send(null);
}