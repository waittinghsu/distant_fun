<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ah solution</title>
        <meta property="og:site_name" content=""/>
        <meta name="keywords" content=""/>
        <meta property="og:title" content=""/>
        <meta name="description" content="">
        <meta property="og:description" content=""/>
        <!--<meta property="og:image" content="<?= WEB_I ?>/common/fb600_site2.jpg"/>-->

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= WEB_J ?>/bootstrap.js"></script>
        <script type="text/javascript" src="<?=WEB_J?>/user/login.js"></script>
        <link href="<?= WEB_C ?>/bootstrap.css" rel="stylesheet" type="text/css" />
<!--            <link rel="shortcut icon" href="<?= WEB_I ?>/common/16x16.ico" type="image/x-icon"/>-->

        <script>
            var publish_url = "<?= site_url("ajax/publish") ?>";
            var do_login_url = "<?= site_url("user/do_login") ?>";
            var base_url = "<?= site_url('') ?>";
        </script>
    </head>
    <body data-target=".bs-docs-sidebar" data-spy="scroll">   
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
        
        
        <div class="row">
            <div class="span9">
                <?=$menu?>  
                <div class="alert alert-<?=$msg_type?>">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4><?=$msg?>!</h4>                
                </div>
                <form class="bs-docs-example form-search" id="profile_modify_form" name="profile_modify_form" action="<?=  site_url('user/profile_update')?>" method="post">
                    <div class="control-group info">
                        <i class="icon-user"></i>
                        <label class="control-label" for="inputname">*姓名</label>
                        <div class="controls">
                            <input class="input-large" type="text" id="user_name" name="user_name" placeholder="姓名" value="<?=$userinfos->user_name?>">
                        </div>
                    </div>
                    <div class="control-group info">
                        <i class="icon-gift"></i>
                        <label class="control-label" for="inputbirthday">生日</label>
                        <div class="controls">
                           <span class="input-large uneditable-input"><?=$userinfos->user_birthday?></span>
                        </div>
                    </div>
                    <div class="control-group info">
                        <i class="icon-tag"></i>
                        <label class="control-label" for="inputnickname">暱稱</label>
                        <div class="controls">
                            <input class="input-large" type="text" id="user_nickname" name="user_nickname" placeholder="暱稱" value="<?=$userinfos->user_nickname?>">
                        </div>
                    </div>
                    <div class="control-group info">
                        <i class="icon-bell"></i>
                        <label class="control-label" for="inputmobile_phone">*行動電話</label>
                        <div class="controls">
                            <input class="input-large" type="text" id="user_mobile_phone" name="user_mobile_phone" placeholder="行動電話"value="<?=$userinfos->user_mobile_phone?>">
                        </div>
                    </div>
                    <div class="control-group info">
                        <i class="icon-bullhorn"></i>
                        <label class="control-label" for="inputcontact_phone">室內電話</label>
                        <div class="controls ">                            
                            <input class="input-mini" id="user_contact_phone" name="user_contact_phone" type="text" placeholder="XXX" value="<?=$userinfos->user_contact_phone_Zone?>">
                                 -
                                 <input class="input-medium" id="user_contact_phone2" name="user_contact_phone2" type="text" placeholder="XXXXXXXX" value="<?=$userinfos->user_contact_phone_Num?>">                            
                        </div>
                  
                    </div>
                    <div class="control-group info">
                        <i class="icon-home"></i>
                        <label class="control-label" for="inputaddress">*地址</label>
                        <div class="controls">
                            <input class="input-xxlarge" type="text" id="user_address" name="user_address" placeholder="地址"value="<?=$userinfos->user_address?>">
                        </div>
                    </div>
                    <div class="control-group info">
                        <i class="icon-road"></i>
                        <label class="control-label" for="inputaddress_memo">*地址註記</label>
                         <span class="label label-warning">(這裡填上您的詳細寄送地址，多點說明好讓寄件者安全寄出物品)</span> 
                        <div class="controls">
                            <textarea wrap="physical" rows="4"placeholder="這裡請詳細" id="user_address_memo" name="user_address_memo" style="height: 152px; width: 530px;"><?=$userinfos->user_address_memo?></textarea>
                        </div>
                    </div>
                    <div class="control-group info">
                        <i class="icon-envelope"></i>
                        <label class="control-label" for="inputEmail">*Email</label>
                        <div class="controls">
                            <input class="input-xlarge" type="text" id="user_email" name="user_email"  placeholder="Email"  value="<?=$userinfos->user_email?>" readonly>
                        </div>
                    </div>
                    <div class="control-group info">
                        <div class="controls">
                            <label class="checkbox">
                                <!--<input type="checkbox"> 確認-->
                            </label>
                            <button type="button" id="profile_submit" class="btn btn-info btn-large ">修改</button>                            
                        </div>
                    </div>
                </form>
            </div>   
        </div>        
    </body>
</html>
