//DHTML Window script- Copyright Dynamic Drive (http://www.dynamicdrive.com)
//For full source code, documentation, and terms of usage,
//Visit http://www.dynamicdrive.com/dynamicindex9/dhtmlwindow.htm

document.write('<div id="bpwindow"style="position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none;z-index:10000;" onSelectStart="return false"><div  onMousedown="initializedrag(event)" onMouseup="stopdragbp()" style="z-index:10000;background-color:gray"><table width=100% border=0><td align=center>Backpack</td><td align=right><img src="images/close.gif" onClick="closebackpack()"></td></table></div><div id="bpwindowcontent" style="height:100%"><div id=backpack style="background-color:black"><font color=white>Retrieving Data please wait...</font></div></div></div>')

var dragapproved=false
var initialwidth,initialheight
var ie5=document.all&&document.getElementById
var ns6=document.getElementById&&!document.all

function iecompattest(){
 return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function drag_drop(e){
 if (ie5&&dragapproved&&event.button==1){
  document.getElementById("bpwindow").style.left=tempx+event.clientX-offsetx+"px"
  document.getElementById("bpwindow").style.top=tempy+event.clientY-offsety+"px"
 }
 else if (ns6&&dragapproved){
  document.getElementById("bpwindow").style.left=tempx+e.clientX-offsetx+"px"
  document.getElementById("bpwindow").style.top=tempy+e.clientY-offsety+"px"
 }
}

function initializedrag(e){
 offsetx=ie5? event.clientX : e.clientX
 offsety=ie5? event.clientY : e.clientY
 document.getElementById("bpwindowcontent").style.display="none" //extra
 tempx=parseInt(document.getElementById("bpwindow").style.left)
 tempy=parseInt(document.getElementById("bpwindow").style.top)
 document.getElementById("select").onSelectStart="return false"
 dragapproved=true
 document.getElementById("body").onmousemove=drag_drop
}

function loadbp(url,width,height){
 if (!ie5&&!ns6)
 window.open(url,"","width=width,height=height,scrollbars=1")
 else{
 document.getElementById("bpwindow").style.display=''
 document.getElementById("bpwindow").style.width=initialwidth=width+"px"
 document.getElementById("bpwindow").style.height=initialheight=height+"px"
 document.getElementById("bpwindow").style.left="650px"
 document.getElementById("bpwindow").style.top=ns6? window.pageYOffset*1+200+"px" : iecompattest().scrollTop*1+200+"px"
 }
 loadbackpack()
}

function closebackpack(){
 document.getElementById("bpwindow").style.display="none"
}

function stopdragbp(){
 dragapproved=false;
 document.getElementById("select").onSelectStart=""
 document.getElementById("bpwindow").onmousemove=null;
 document.getElementById("bpwindowcontent").style.display="" //extra
}

function loadbackpack()
{
 if (window.XMLHttpRequest)
 {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttpbp=new XMLHttpRequest();
 }
 else
 {// code for IE6, IE5
  xmlhttpbp=new ActiveXObject("Microsoft.XMLHTTP");
 }
  xmlhttpbp.onreadystatechange=function()
 {
 if(xmlhttpbp.readyState==4)
   {document.getElementById('backpack').innerHTML=xmlhttpbp.responseText}
 }
 xmlhttpbp.open("GET",'backpack.php',true);
 xmlhttpbp.send(null);
}