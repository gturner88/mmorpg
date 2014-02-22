$(function() {
  $('.errors').hide();
  $('.Login_Loading').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

  $(".button").click(function() {
		// validate and process form
		// first hide any error messages
    $('.errors').hide();
	$('.error').hide();
	$('.Login_Loading').hide();
		
  	  var name = $("input#Username").val();
  		if (name == "") {
        $("label#Username_error").show();
        $("input#Username").focus();
        return false;
      }
  		var password = $("input#Password").val();
  		if (password == "") {
        $("label#Password_error").show();
        $("input#Password").focus();
        return false;
      }
		
		var dataString = 'Username='+ name + '&Password=' + password;
		//alert (dataString);return false;
		
		$.ajax({
      type: "POST",
      url: "accounts.php",
      data: dataString,
      success: function() {
        $("#contact_form").hide();
		maininfo(false)
      }
     });
    return false;
	});
});
runOnLoad(function(){
  $("input#name").select().focus();
});