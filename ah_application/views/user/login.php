<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ah solution</title>
<meta property="og:site_name" content=""/>
<meta name="keywords" content=""/>
<meta property="og:title" content=""/>
<meta name="description" content="">
<meta property="og:description" content=""/>
<meta property="og:image" content="<?=WEB_I?>/common/fb600_site2.jpg"/>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=WEB_J?>/jquery/sakura.js"></script>
<script type="text/javascript" src="<?=WEB_J?>/user/login.js"></script>

<link href="<?=WEB_C?>/login.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?=WEB_I?>/common/16x16.ico" type="image/x-icon"/>
<?=$sakura?>
<script>             
	var publish_url="<?=site_url("ajax/publish")?>";        
	var do_login_url="<?=site_url("user/do_login")?>";       
        var base_url="<?=  site_url('')?>";           
</script>
</head>
<body class="ulogin">   
        <!-- FB Start-->
	<div id="fb-root"></div>
	<script>        
	(function() {
	var e = document.createElement('script');
	e.src = document.location.protocol + '//connect.facebook.net/zh_TW/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);
	}());
	window.fbAsyncInit = function() {	
		FB.init({
		appId  : '<?=FBAPP_ID?>',  //253125941500085
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true // parse XFBML
		});	
	};
	</script>
	<!-- FB End -->       
    <div class="nav">
            <a alt="off" class="des font13">活動辦法</a>
            <a alt="off" class="des font13">孔雀餅乾</a>
            <a alt="off" class="des font13">喀拉姆揪</a>
            <a alt="off" class="des font13">iphone6</a>
            <a alt="off" class="des font13" href="<?=  site_url('user/login')?>" >哈秋哈秋</a>
    </div>
    <canvas id="sakura" height='1024px'></canvas>   
    
    <div class="wrapper login-wrapper">        
        <div class="page-content">
            <div class="tab-block">            
                <nav>
                    <ul>
                        <li class="last active"><a href="#">登入</a></li>
                        <li class="first"><a href="#">註冊</a></li>

                    </ul>
                </nav>            
                <div class="tab-block-content">                
                    <div class="oauth" >
                        <p>您可以透過下列帳號登入：</p>
                        <a  class="fb btn-login" id="facebooklogin">Facebook</a>
                        <div id="customBtn"><a  class="googleplus btn-login" >googleplus</a></div>                    
                    </div>
                    <div class="normal first_form" style="display: none">
                        <p>註冊新香蕉帳號：</p>
                        <!--<form novalidate="novalidate" method="post" id="new_user" class="simple_form new_user" action="<?=site_url('/user/login')?>" accept-charset="UTF-8"><div style="display:none"><input type="hidden" value="✓" name="utf8"><input type="hidden" value="EoVv7Z92DgGWUTYX0JOEzXnbxE41wctsfVWxA7NE8j4=" name="authenticity_token"></div>-->
                        <form method="post" id="new_user" class="simple_form new_user"  accept-charset="UTF-8">                                    
                                    <div style="display:none"><input type="hidden" value="✓" name="utf8"><input type="hidden" value="EoVv7Z92DgGWUTYX0JOEzXnbxE41wctsfVWxA7NE8j4=" name="authenticity_token"></div>
                                    <div class="control-group string required user_login"><div class="controls"><input type="text" title="只能使用字母、數字或底線" rel="tooltip" placeholder="使用者名稱" name="user[login]" id="user_login" class="string required"></div></div>
                                    <div class="control-group email required user_email"><div class="controls"><input type="email" value="" rel="tooltip" placeholder="Email" name="user[email]" id="user_email" class="string email required"></div></div>
                                    <div class="control-group password required user_password"><div class="controls"><input type="password" title="需大於 8 個字" rel="tooltip" placeholder="密碼" name="user[password]" id="user_password" class="password required"></div></div>
                                    <div class="control-group password required user_password_confirmation"><div class="controls"><input type="password" placeholder="再次輸入密碼以供確認" name="user[password_confirmation]" id="user_password_confirmation" class="password required"></div></div>
                                    <input  id="user_register" type="button" value="註冊" name="user_register" class="btn btn normal btn-login"/>
                        </form>            
                    </div>
                    <div class="normal last_form" style="display: ">
                        <p>或使用香蕉帳號登入：</p>
                        <form method="post" id="old_user" class="simple_form new_user"  accept-charset="UTF-8">
                                    <div style="display:none"><input type="hidden" value="✓" name="utf8"><input type="hidden" value="EoVv7Z92DgGWUTYX0JOEzXnbxE41wctsfVWxA7NE8j4=" name="authenticity_token"></div>
                                    <div class="control-group email required user_email"><div class="controls"><input type="email" value="" rel="tooltip" placeholder="Email" name="user[email]" id="user_email" class="string email required"></div></div>
                                    <div class="control-group password required user_password"><div class="controls"><input type="password" title="需大於 8 個字" rel="tooltip" placeholder="密碼" name="user[password]" id="user_password" class="password required"></div></div>
                                    <input id="user_login" type="button" value="登入" name="user_login" class="btn btn normal btn-login"/>
                        </form>            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>         
        $(document).ready(function(){
            $("nav li").bind("click",function(){
                $("nav li").each(function(){
                    $(this).removeClass("active");                   
                });                 
                var divopen =$(this).attr("class");
                $(this).addClass("active");
                $("div[class$='_form']").hide();
                $("."+divopen+"_form").show();
            });
            $("input[id^='user_']").bind('click',function(){
                    alert('施工中請用FB登入');
            });
        });    
    </script>
        
</body>
</html>
