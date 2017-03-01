 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ah solution</title>

<meta property="og:site_name" content=""/>
<meta name="keywords" content="">
<meta property="og:title" content=""/>
<meta name="description" content="">
<meta property="og:description" content=""/>
<meta property="og:image" content="<?=WEB_I?>/common/fb600_site2.jpg"/>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=WEB_J?>/main.js"></script>
<script type="text/javascript" src="<?=WEB_J?>/jquery/sakura.js"></script>
<link rel="shortcut icon" href="<?=WEB_I?>/common/16x16.ico" type="image/x-icon"/>
<link href="<?=WEB_C?>/reset.css" rel="stylesheet" type="text/css" />
<link href="<?=WEB_C?>/normal.css" rel="stylesheet" type="text/css" />

<?=$sakura?>
<script>
        
        //ga code       
	var publish_url="<?=site_url("ajax/publish")?>";        
	var user_data_url="<?=site_url("ajax/user_data")?>";

       
</script>

</head>

<body class="index">
	<div class="container">
            <canvas id="sakura"></canvas> 
		<img src="<?=WEB_I?>/index/bg_lay1.png" />
		<!--背景-->	

		<!--背景 end-->
		<!---------------------------------------------------------------------------->
		<!--變動區塊-->
		<!--變動區塊 end-->
		<!---------------------------------------------------------------------------->
		<!--固定區塊menu-->
                <?=$menu?>
		<!--固定區塊 end-->
		<!--pop區塊-->
		 		<?=$pop?>    		
		<!--pop區塊 end-->

	</div>
</body>
</html>
