<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ah-solution</title>
<link rel="stylesheet" href="<?=WEB_C?>/manage/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="<?=WEB_J?>/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="<?=WEB_J?>/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="<?=WEB_J?>/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="#"><img src="<?=WEB_I?>/manage/shared/login.png" width="299" height="97" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<!--  start login-inner -->
	<div id="login-inner">
		<form action="<?=site_url("manage/manager/login")?>" name="login" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><input type="text"  class="login-inp" name="id"/></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" value="" name="password" onfocus="this.value=''" class="login-inp" /></td>
		</tr>
<!-- 		
		<tr>
			<th></th>
			<td valign="top"><input type="checkbox" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
		</tr>
 -->		
		<tr>
			<th></th>
			<td><br/><br/><input type="submit" class="submit-login" /></td>
		</tr>
		</table>
		</form>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
<!-- 	
	<a href="" class="forgot-pwd">Forgot Password?</a>
 -->	
 </div>
 <!--  end loginbox -->
 
	<!--  start forgotbox ................................................................................... -->
<!-- 	
	<div id="forgotbox">
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
<!--		
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value=""   class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="button" class="submit-login"  /></td>
		</tr>
		</table>
		</div>
-->		
		<!--  end forgot-inner -->
<!-- 		
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	</div>
 -->	
	<!--  end forgotbox -->

</div>
<!-- End: login-holder -->
<!-- start footer -->         
<div id="footer">
	<!--  start footer-left -->
	<div id="footer-left">design by AH SOLUTION </div>
<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
</body>
</html>
