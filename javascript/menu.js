document.write('<div id="fixed_Item_menu" style="z-index:43543534544;color:red;position:absolute;width:75px;display:none;background:#200000;border:2px solid #FF9900"></div>')

var ie5=document.all&&document.getElementById
var ns6=document.getElementById&&!document.all
var timeout = 100;

function activateItem(Item_id)
{
	window.location = 'index.php?Item_action=' + Item_id;
}

function CvaultItem(Item_id)
{
killMenu()
if(document.getElementById("Cvault_" + Item_id).checked == true)
{
document.getElementById("Item_" + Item_id).style.border = ""
document.getElementById("Cvault_" + Item_id).checked = false
document.getElementById("Drop_" + Item_id).checked = false
}
else
{
document.getElementById("sec_id").style.display=""
document.getElementById("Item_" + Item_id).style.border = "solid 1px green"
document.getElementById("Drop_" + Item_id).checked = false
document.getElementById("Cvault_" + Item_id).checked = true
}
}

function Drop_item(Item_id)
{
killMenu()
if(document.getElementById("Drop_" + Item_id).checked == true)
{
document.getElementById("Item_" + Item_id).style.border = ""
document.getElementById("Cvault_" + Item_id).checked = false
document.getElementById("Drop_" + Item_id).checked = false
}
else
{
document.getElementById("sec_id").style.display=""
document.getElementById("Item_" + Item_id).style.border = "solid 1px red"
document.getElementById("Drop_" + Item_id).checked = true
document.getElementById("Cvault_" + Item_id).checked = false
}
}

function killMenu()
{
         delayhidetip()
	 document.getElementById("fixed_Item_menu").style.display="none"
}

function equipItem(Item_id)
{ 
 killMenu()
 if (window.XMLHttpRequest)
 {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttpequip=new XMLHttpRequest();
 }
 else
 {// code for IE6, IE5
  xmlhttpequip=new ActiveXObject("Microsoft.XMLHTTP");
 }
  xmlhttpequip.onreadystatechange=function()
 {
 if(xmlhttpequip.readyState==4)
   {
   loadequipment()
   document.getElementById('backpack').innerHTML=xmlhttpequip.responseText
   }
 }
 xmlhttpequip.open("GET",'backpack.php?equip=' + Item_id,true);
 xmlhttpequip.send(null);
}

function removeItem(Item_id)
{ 
 killMenu()
 if (window.XMLHttpRequest)
 {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttpremove=new XMLHttpRequest();
 }
 else
 {// code for IE6, IE5
  xmlhttpremove=new ActiveXObject("Microsoft.XMLHTTP");
 }
  xmlhttpremove.onreadystatechange=function()
 {
 if(xmlhttpremove.readyState==4)
   {
   loadbackpack()
   document.getElementById('equipment').innerHTML=xmlhttpremove.responseText
   }
 }
 xmlhttpremove.open("GET",'equipment.php?remove=' + Item_id,true);
 xmlhttpremove.send(null);
}

function vaultItem(Item_id)
{
 killMenu()
 if (window.XMLHttpRequest)
 {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttpvault=new XMLHttpRequest();
 }
 else
 {// code for IE6, IE5
  xmlhttpvault=new ActiveXObject("Microsoft.XMLHTTP");
 }
  xmlhttpvault.onreadystatechange=function()
 {
 if(xmlhttpvault.readyState==4)
   {
   document.getElementById('backpack').innerHTML=xmlhttpvault.responseText
   }
 }
 xmlhttpvault.open("GET",'backpack.php?vault=' + Item_id,true);
 xmlhttpvault.send(null);
}
// go close timer
function closetime()
{
	t = setTimeout("killMenu()", timeout);
}

// cancel close timer
function cancelclosetime()
{
		clearTimeout(t);
}

function MakeMenu(e,Item_id,activate,equip,vault,cvault,sell,drop)
{
        hidetip()
	var posx = 0;
	var posy = 0;
	if (!e) var e = window.event;
	if (e.pageX || e.pageY) 	{
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY) 	{
		posx = e.clientX + document.body.scrollLeft
			+ document.documentElement.scrollLeft;
		posy = e.clientY + document.body.scrollTop
			+ document.documentElement.scrollTop;
	}
 ddmenuitem = document.getElementById("fixed_Item_menu");
 document.getElementById("fixed_Item_menu").style.display="" //extra
 document.getElementById("fixed_Item_menu").innerHTML=""
 if(activate)
  document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:void();\"  onClick=\"activateItem('" + Item_id + "');\">Activate</a></div>"
 if(equip)
  document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:void();\" onClick=\"equipItem('" + Item_id + "');\">Equip</a><br>"
 if(vault)
  document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:void();\" onClick=\"vaultItem('" + Item_id + "');\">Vault</a><br>"
 if(cvault)
  document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:void();\" onClick=\"CvaultItem('" + Item_id + "');\">Crew Vault</a><br>"
 if(sell)
  document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:void();\">Sell</a><br>"
 if(drop)
  document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:void();\" onClick=\"Drop_item(" + Item_id + ")\">Drop</a><br>"
 document.getElementById("fixed_Item_menu").innerHTML+="<div onMouseout=\"closetime()\" onMouseover=\"cancelclosetime()\"><a style=\"color:red;text-decoration:none;\" href=\"javascript:Void();\" onclick=\"killMenu()\">Cancel</a><br>"
 document.getElementById("fixed_Item_menu").style.top = posy-10+"px"
 document.getElementById("fixed_Item_menu").style.left = posx-10+"px"
}

function swapuser()
{
	uid = document.getElementById('combo_uid').value;
	window.location = "/index.php?uid="+uid;
}

function moveon(move_state) {
	movement = move_state
}