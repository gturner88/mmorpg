<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "World"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header
	
echo "<div id=\"atwindow\"style=\"z-index:13;position:absolute;background-color:#EBEBEB;cursor:hand;left:0px;top:0px;display:none\" onSelectStart=\"return false\"><div  onMousedown=\"initializedrag(event)\" onMouseup=\"stopdragat()\" style=\"background-color:gray\"><table width=100% border=0><td align=center>attack</td><td align=right><img src=\"images/minamize.gif\" onClick=\"closeat()\"><img src=\"images/close.gif\" onClick=\"closeattack()\"></td></table></div><div id=\"atwindowcontent\" style=\"height:100%\"><div id=\"Attack_mob\">test</div></div></div></div><script type=\"text/javascript\">//DHTML Window script- Copyright Dynamic Drive (http://www.dynamicdrive.com)
//For full source code, documentation, and terms of usage,
//Visit http://www.dynamicdrive.com/dynamicindex9/dhtmlwindow.htm
var atopened = 0
var dragapproved=false
var initialwidth,initialheight
var ie5=document.all&&document.getElementById
var ns6=document.getElementById&&!document.all

function iecompattest(){
 return (!window.opera && document.compatMode && document.compatMode!=\"BackCompat\")? document.documentElement : document.body
}

function drag_drop(e){
 if (ie5&&dragapproved&&event.button==1){
  document.getElementById(\"atwindow\").style.left=tempx+event.clientX-offsetx+\"px\"
  document.getElementById(\"atwindow\").style.top=tempy+event.clientY-offsety+\"px\"
 }
 else if (ns6&&dragapproved){
  document.getElementById(\"atwindow\").style.left=tempx+e.clientX-offsetx+\"px\"
  document.getElementById(\"atwindow\").style.top=tempy+e.clientY-offsety+\"px\"
 }
}

function initializedrag(e){
 offsetx=ie5? event.clientX : e.clientX
 offsety=ie5? event.clientY : e.clientY
 document.getElementById(\"atwindowcontent\").style.display=\"none\" //extra
 tempx=parseInt(document.getElementById(\"atwindow\").style.left)
 tempy=parseInt(document.getElementById(\"atwindow\").style.top)
 document.getElementById(\"select\").onSelectStart=\"return false\"
 dragapproved=true
 document.getElementById(\"body\").onmousemove=drag_drop
}

function loadat(url,width,height){
 atopened = 1
 if (!ie5&&!ns6)
 window.open(url,\"\",\"width=width,height=height,scrollbars=1\")
 else{
 document.getElementById(\"atwindow\").style.display=''
 document.getElementById(\"atwindow\").style.width=initialwidth=width+\"px\"
 document.getElementById(\"atwindow\").style.height=initialheight=height+\"px\"
 document.getElementById(\"atwindow\").style.left=\"550px\"
 document.getElementById(\"atwindow\").style.top=ns6? window.pageYOffset*1+200+\"px\" : iecompattest().scrollTop*1+200+\"px\"
 }
 loadattack()
}

function closeattack(){
 atopened = 0
 document.getElementById(\"atwindow\").style.display=\"none\"
}
function closeat(){
 document.getElementById(\"atwindow\").style.display=\"none\"
 document.getElementById(\"atdock\").style.display=\"\"
}
function reopenat(){
document.getElementById(\"atdock\").style.display=\"none\"
 document.getElementById(\"atwindow\").style.display=\"\"
}

function stopdragat(){
 dragapproved=false;
 document.getElementById(\"select\").onSelectStart=\"\"
 document.getElementById(\"atwindow\").onmousemove=null;
 document.getElementById(\"atwindowcontent\").style.display=\"\" //extra
}
var attackmob;

function Attackmob(mob_id){  
 document.getElementById('Errormsg').innerHTML = ''; 
 document.getElementById('Attack_mob').innerHTML = '<div style=\"background-color:#666;\"><iframe src=\"/Attack/?mob_id=' + mob_id + '\" bgcolor=\"#200000\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"0\" height=\"310px\" scrolling=\"no\" width=\"100%\"></iframe></div>';
 document.getElementById('Attack_mob').style.display = '';

 if(atopened == 0)
    loadat(\"\",550);    
 
}

function LoadMob(mob_id){  
 document.getElementById('Errormsg').innerHTML = ''; 
 document.getElementById('Attack_mob').innerHTML = '<div style=\"background-color:#666;\"><iframe src=\"/Mobtalk.php?json=1&id=' + mob_id + '\" bgcolor=\"#200000\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"0\" height=\"310px\" scrolling=\"no\" width=\"100%\"></iframe></div>';
 document.getElementById('Attack_mob').style.display = '';

 reopenat();

 if(atopened == 0)
    loadat(\"\",550);    
 
}


</script>
<script type=\"text/javascript\">

var Sections = [];

(function($) {
  var cache = [];
  // Arguments are image paths relative to the current page.
  $.preLoadImages = function() {
    var args_len = arguments.length;
    for (var i = args_len; i--;) {
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache.push(cacheImage);
    }
  }
})(jQuery)

function LoadSection(Section)
{
	var Continue = true;
	for(var i = 0; i < Sections.length; i++)
	{
		if(Sections[i] == Section) Continue = false;
	}
	if(Continue == true)
	{
		Sections.push(Section);
		$.getJSON('/getImages.php?section=' + Section, function(data) {
			Images = data.Images;
			imgLength = Images.length;
			for(var i = 0; i < imgLength; i++)
			{
				Image = Images[i].Image;
				jQuery.preLoadImages(Image, Image);
			}
		})
	}
}
	


var northRoom = 0;
var southRoom = 0;
var eastRoom = 0;
var westRoom = 0;
var curRoom = 0;
var process = 0;

function gotoRoom(destRoom)
{
  if(process)
     return false;
  
  process = 1;     
     
 $.getJSON('/Ajax_changeroom.php?room=' + destRoom, function(data) {   
   Errormsg = data.Errormsg;
   if(Errormsg) {
    $('#Errormsg').html('<font color=red><b>Error : ' + Errormsg + '</b></font>');
   }
   else
   {
	Map_Style = document.getElementById('mapinfo').style
    curRoom = data.curRoom;
    southRoom = data.south;
    northRoom = data.north;
    westRoom = data.west;
    eastRoom = data.east;
    roomName = data.name;
    roomInfo = data.roomDetails;
    mapInfo = data.mapHtml;
    mapImage = data.mappic;
    curRoompic = data.pic;
    curTime = data.curTime;
    curStamina = data.curStamina;
	Section = data.Section;
    
    $('#Errormsg').html('');
    $('#curTime').html(curTime);
    $('#curStamina').html(curStamina);
    $('#mapinfo').html(mapInfo);
    Map_Style.backgroundImage = 'URL(' + mapImage + ')';
    $('#roominfo').html(roomInfo);
    $('#roomname').html('-' + roomName + '-');
		
	LoadSection(Section);

   }
  process = 0;    
 });
}
//start of where keyboard use
var key1=\"87\";  //W
var key2=\"119\"; //w
var key3=\"83\";  //S
var key4=\"115\"; //s
var key5=\"68\";  //D
var key6=\"100\"; //d
var key7=\"65\";  //A
var key8=\"97\";  //a
var x='';
var movement;
movement = true;

function handler(e) 
{
    if(movement == true)
    {
      if (document.all) {
          var evnt = window.event; 
          x=evnt.keyCode;
        }
        else
            x=e.charCode;
            
    if(northRoom)
    {
            if (x==key1)
                gotoRoom(northRoom);
            if (x==key2)
                gotoRoom(northRoom);
    }
    if(southRoom)
    {
            if (x==key3)
                gotoRoom(southRoom);
            if (x==key4)
                gotoRoom(southRoom);
    }
    if(eastRoom)
    {
            if (x==key5)
                gotoRoom(eastRoom);
            if (x==key6)
                gotoRoom(eastRoom);
    }
    if(westRoom)
    {
            if (x==key7)
                gotoRoom(westRoom);
            if (x==key8)
                gotoRoom(westRoom);
    }
    }
}
    if (!document.all){
        window.captureEvents(Event.KEYPRESS);
        window.onkeypress=handler;
    }
    else
    {
        document.onkeypress = handler;
    } 
    //end of keyboard use
gotoRoom();
</script>
<div id=\"Errormsg\"></div>
<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" Width=\"650px\">
  <tr>
  <td align=\"center\" style=\"background-color:#222;color:#CCC;\"><div id=\"roomname\">- Loading -</div></td>
  <td colspan=\"2\" style=\"background-color:#222;color:#CCC;\" align=\"right\"><div style=\"display:none\" id=\"atdock\" onclick=\"reopenat();\">Open Attack Log</div></td>
  </tr>
  <tr>
    <td valign=\"top\" style=\"width:175px;height:175px;\">
    <div id=\"mapinfo\"></div>
    </td>
    <td rowspan=\"2\" colspan=\"2\" valign=\"top\" style=\"background-color:#A2A2A2;\">
          <div id=\"roominfo\"></div>
    </td>
  </tr>
  <tr>
    <td valign=\"top\">LEGEND</td>
  </tr>
</table>";
include("includes/Footer.php");
?>