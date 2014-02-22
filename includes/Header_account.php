<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <LINK REL=StyleSheet HREF="css/main.css" TYPE="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Account</title>
		  <script type="text/javascript" src="javascript/JQuery.js"></script>
          <script type="text/javascript" src="javascript/login.js"></script>
		  <script type="text/javascript" src="javascript/jquery-1.2.3.pack.js"></script>
		  <script type="text/javascript" src="javascript/runonload.js"></script>
          <style type="text/css">  
			fieldset {  
				height:110px;
				width:320px;  
				font-family:Verdana, Arial, Helvetica, sans-serif;  
				font-size:14px; 
				color:#FFF;
				background-color:#200000; 
			}  
			legend {  
				width:100px;  
				text-align:center;  
				background:#000;  
				border:solid 1px;  
				margin:1px;  
				font-weight:bold;  
				color:#fff;  
			}  
			.Login_Loading {
				height:92px;
				width:320px;  
				position:absolute;
				background-color:#000;
				opacity:0.7;
				filter:alpha(opacity=70);
				text-align: center; 
				vertical-align:middle;
			}
		  </style> 
<script>

function maininfo(FirstRun)
{
 checkVersion()
 document.getElementById('contact_form').style.display = "none";
 document.getElementById('maindiv').innerHTML='<center>Loading Characters<br><img src="images/loading.gif"></center>'
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
  {
	  if(xmlhttp.responseText == "Not Logged In!") {
		  document.getElementById('contact_form').style.display = "";
		  document.getElementById('maindiv').innerHTML = "";
		  if(FirstRun == false) document.getElementById('maindiv').innerHTML = "<div class=\"error\">Invalid Username or Password Please try again</div>";
	  }
	  else document.getElementById('maindiv').innerHTML=xmlhttp.responseText;
  }
 }
 xmlhttp.open("GET",'accounts.php',true);
 xmlhttp.send(null);
}

function getInternetExplorerVersion()
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
{
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}
function checkVersion()
{
  var msg = "You're not using Internet Explorer.";
  var ver = getInternetExplorerVersion();

  if ( ver > -1 )
  {
      document.getElementById('contact_form').innerHTML="<div class='noIE'><center>Internet Explorer is Not Supported Please use a different Web Browser<br /><a href=\"http://www.mozilla.com/en-US/firefox/new/\">FireFox<img src=\"http://www.mozilla.org/images/product-firefox-50.png\" width=\"32px\" height=\"32px\" /></a><a href=\"http://www.apple.com/safari/download/\"><img src=\"http://www.freenew.net/images/logo/safari.png\" width=\"32px\" height=\"32px\" /></a><a href=\"www.google.com/chrome\"><img src=\"http://img.brothersoft.com/icon/softimage/g/google_chrome-403411-1283997335.jpeg\" width=\"32px\" height=\"32px\" />Chrome</a><br /><a href=\"http://www.apple.com/safari/download/\">Safari</a></center></div>";
  }
}
  

</script>
</head>
<body bgcolor=#200000 onload="maininfo(true);">
<table width=750 align=center bgcolor=#666666>
<tr>
<td height=150 align=center colspan=3 bgcolor=#000000 style="background-position:top center;align:center;background-image: url(images/temp.jpg);background-repeat:no-repeat;">
</td>
</tr>
<tr>
<td width=10% bgcolor=#000000>

</td>
<td width=80%>
<?php include("includes/Error.php"); ?>
 <div id="maindiv">
</div>
<div id="contact_form" align="center">  

				<form name="contact" action="">  
				  <fieldset>  

                  <Legend>Login</Legend>
                  <div class="Login_Loading">
                  		<img src="images/loading.gif">
                  </div>
                  <table>
                  <tr>
                  <td></td><td></td><td><label class="errors" for="Username" id="Username_error">This field is required.</label></td>
                  </tr>
                  <tr>
					<td><label for="Username" id="Username_label">Username</label></td>
					<td><input type="text" name="Username" id="Username" size="30" value="" class="text-input" /> </td> 
					<td><label class="errors" for="Password" id="Password_error">This field is required.</label></td>  
				  </tr><tr>
					<td><label for="Password" id="Password_label">Password </label></td>
					<td><input type="password" name="Password" id="Password" size="30" value="" class="text-input" /> </td> 
					<td></td> 
 				  </tr><tr>
					<td colspan="3"><input type="submit" name="submit" class="button" id="submit_btn" value="Send" /> </td> 
                  </tr>
                  </table>
				  </fieldset>  
				</form>  
			</div>
           
</td>
<td  width=10% bgcolor=#000000>

</td>
</tr>
<tr>
<td colspan=3 bgcolor=#000000 align="center">
<font color=white> Privacy Policy  |   Anti-Spam Policy  |  Terms of Service</font>
</td>
</tr>
</table>
</body>
</html>
