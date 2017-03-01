 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>人氣網模推薦-Za裸粧心機輕潤粉底液 新品上市</title>

<meta property="og:site_name" content="人氣網模推薦-Za裸粧心機輕潤粉底液 新品上市"/>
<meta name="keywords" content="粉紅戀夏,ZA,粉底液,裸粧心機">
<meta property="og:title" content="人氣網模推薦-Za裸粧心機輕潤粉底液 新品上市"/>
<meta name="description" content="人氣網模 粉紅戀愛推薦立即分享他們心得，將有機會免費獲得新品唷~（共10名）">
<meta property="og:description" content="人氣網模 粉紅戀愛推薦立即分享他們心得，將有機會免費獲得新品唷~（共10名）"/>
<meta property="og:image" content="<?=WEB_I?>/common/fb600_site1.jpg"/>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?=WEB_J?>/main.js"></script>
<script type="text/javascript" src="<?=WEB_J?>/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?=WEB_J?>/blogger.js"></script>

<link rel="shortcut icon" href="<?=WEB_I?>/common/16x16.ico" type="image/x-icon"/>
<link href="<?=WEB_C?>/reset.css" rel="stylesheet" type="text/css" />
<link href="<?=WEB_C?>/normal.css" rel="stylesheet" type="text/css" />
<link href="<?=WEB_C?>/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
<script>
        //ga code
	var publish_url="<?=site_url("ajax/publish")?>";        
	var user_data_url="<?=site_url("ajax/user_data")?>";

</script>

</head>

<body class="blo">
        <script>
         //im blogger page    
         var model_name='<?=$model_name?>';
         var model_num='<?=$model_num?>';
         //end
        </script>   
    
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
	<div class="container">
		<!--背景-->
		<img class="bgLay1" src="<?=WEB_I?>/index/bg_lay1.png"/>	
		<!--背景 end-->
		<!---------------------------------------------------------------------------->
		<!--變動區塊-->
		<div class="main">                                  <!--  omega tag-->
			<img class="blogger B1" src="<?=WEB_I?>/index/blogger_02.png"/>
		</div>
		<div class="net"></div>
		<div class="mainText">
            <a class="b1 cilBtn" alt="on" href="<?=site_url("homepage/blogger")?>/natalie" ></a>
			<a class="b2 cilBtn"  ></a>
			<a class="b3 cilBtn"  ></a>
			<a class="b4 cilBtn" href="<?=site_url("homepage/blogger")?>/stella"></a>
			<a class="b5 cilBtn" href="<?=site_url("homepage/blogger")?>/fifi" ></a>
			<a class="b6 cilBtn" href="<?=site_url("homepage/blogger")?>/anju" ></a>
			<a class="b7 cilBtn" href="<?=site_url("homepage/blogger")?>/tyra" ></a>
			<img class="title" src="<?=WEB_I?>/blogger/title.png" height="99" width="485" />
		</div>
		<div class="cons">
			<h2></h2>
			<h3 class="font19">Za 裸粧心機輕潤粉底液</h3>
			<p class="font12 context"><em class="font17"><?=$model_name?>推薦心得</em><br/>
						<?=$model_description?>
			</p>
			<a class="b0<?=$model_num?> share"></a>
			<!--  omega tag-->
			<img class="head" src="<?=WEB_I?>/blogger/head0<?=$model_num?>.png" height="122" width="122" />
		</div>
		<!--變動區塊 end-->
		<!---------------------------------------------------------------------------->
		<!--固定區塊 menu-->
		<?=$menu?>
		<!--固定區塊 end-->
                <?=$pop?>       
		<!--pop區塊-->
		<!--pop區塊 end-->
	</div>
        <!------------------------------FB分享回應窗口-------------------------------->
        <!------------------------------------END WINDOWS---------------------------------->
	<script>
	$(".context").mCustomScrollbar({
      theme:"dark-thick",
      scrollButtons:{
        enable: false,
        scrollType:"continuous"
      }
    });
	</script>
</body>
</html>
