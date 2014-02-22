//DHTML Window script- Copyright Dynamic Drive (http://www.dynamicdrive.com)
//For full source code, documentation, and terms of usage,
//Visit http://www.dynamicdrive.com/dynamicindex9/dhtmlwindow.htm

var attackinfo = '<div id="atwindow"style="z-index:13;position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none" onSelectStart="return false"><div  onMousedown="initializedrag(event)" onMouseup="stopdragat()" style="background-color:gray"><table width=100% border=0><td align=center>attack</td><td align=right><img src="images/close.gif" onClick="closeattack()"></td></table></div><div id="atwindowcontent" style="height:100%"><div style="border:solid 2px #000;" id="Attack_mob">test</div></div></div>'
document.write(attackinfo)
var dragapproved=false
var initialwidth,initialheight
var ie5=document.all&&document.getElementById
var ns6=document.getElementById&&!document.all

function iecompattest(){
 return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function drag_drop(e){
 if (ie5&&dragapproved&&event.button==1){
  document.getElementById("atwindow").style.left=tempx+event.clientX-offsetx+"px"
  document.getElementById("atwindow").style.top=tempy+event.clientY-offsety+"px"
 }
 else if (ns6&&dragapproved){
  document.getElementById("atwindow").style.left=tempx+e.clientX-offsetx+"px"
  document.getElementById("atwindow").style.top=tempy+e.clientY-offsety+"px"
 }
}

function initializedrag(e){
 offsetx=ie5? event.clientX : e.clientX
 offsety=ie5? event.clientY : e.clientY
 document.getElementById("atwindowcontent").style.display="none" //extra
 tempx=parseInt(document.getElementById("atwindow").style.left)
 tempy=parseInt(document.getElementById("atwindow").style.top)
 document.getElementById("select").onSelectStart="return false"
 dragapproved=true
 document.getElementById("body").onmousemove=drag_drop
}

function loadat(url,width,height){
 if (!ie5&&!ns6)
 window.open(url,"","width=width,height=height,scrollbars=1")
 else{
 document.getElementById("atwindow").style.display=''
 document.getElementById("atwindow").style.width=initialwidth=width+"px"
 document.getElementById("atwindow").style.height=initialheight=height+"px"
 document.getElementById("atwindow").style.left="550px"
 document.getElementById("atwindow").style.top=ns6? window.pageYOffset*1+200+"px" : iecompattest().scrollTop*1+200+"px"
 }
 loadattack()
}

function closeattack(){
 moveon(true)
 document.getElementById("atwindow").style.display="none"
}

function stopdragat(){
 dragapproved=false;
 document.getElementById("select").onSelectStart=""
 document.getElementById("atwindow").onmousemove=null;
 document.getElementById("atwindowcontent").style.display="" //extra
}