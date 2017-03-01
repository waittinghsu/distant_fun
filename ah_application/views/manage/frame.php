<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8"/>
<title>AH-AOLUTION</title>
<link rel="stylesheet" href="<?=WEB_C?>/manage/screen.css" type="text/css" media="screen" title="default" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="<?=WEB_C?>/manage/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
<script src="<?=WEB_J?>/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="<?=WEB_J?>/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="<?=WEB_J?>/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(document).pngFix( );
	<?php 
	if ($menu1!=""){
	?>
	
    main_menu_select('<?=$menu1?>');
    <?php 
	}
	if ($menu2!=""){
	?>
	sub_menu_select('<?=$menu1?>','<?=$menu2?>');
	<?php 
	}?>	
});
</script>
<script>
function main_menu_select(menu){
	$("#"+menu).attr("class","current");
}
function sub_menu_select(menu1,menu2){
	
	$("#"+menu1+"_div").attr("class","select_sub show");
	$("#"+menu2).attr("class","sub_show");
}

</script>

<script>
// Author: Ariel Flesler
//http://flesler.blogspot.com/2008/11/fast-trim-function-for-javascript.html
//Licensed under BSD
function Trim(str) {
	var start = -1,
	end = str.length;
	while (str.charCodeAt(--end) < 33);
	while (str.charCodeAt(++start) < 33);
	return str.slice(start, end + 1);
};

function isDate(year, month, day) {
   month = month - 1; // javascript month range 0 - 11
   var tempDate = new Date(year,month,day);
   if ((year == tempDate.getFullYear()) &&
	   (month == tempDate.getMonth()) &&
	   (day == tempDate.getDate()) ) {
       return true;
   } else {
	   return false;
   }
}
</script>
</head>
<body> 
	<!-- Start: page-top-outer -->
	<div id="page-top-outer">    

		<!-- Start: page-top -->
		<div id="page-top">

			<!-- start logo -->
			<div id="logo">
				<a href="#"><img src="<?=WEB_I?>/manage/shared/logo.png" alt="" /></a>
			</div>
			<!-- end logo -->
	
 			<div class="clear"></div>

		</div>
		<!-- End: page-top -->

	</div>
	<!-- End: page-top-outer -->
	
	<div class="clear">&nbsp;</div>
 
	<!--  start nav-outer-repeat................................................................................................ START -->
	<div class="nav-outer-repeat"> 
		<!--  start nav-outer -->
		<div class="nav-outer"> 

			<!-- start nav-right -->
			<div id="nav-right">
		
				<div class="nav-divider">&nbsp;</div>
				<a href="<?=site_url("manage/manager/logout")?>" id="logout"><img src="<?=WEB_I?>/manage/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
				<div class="clear">&nbsp;</div>
		
			</div>
			<!-- end nav-right -->


			<!--  start nav -->
			<div class="nav">
				<div class="table">
				
					<ul id="user" class="select">
						<li>
							<a href="#nogo"><b>網友資訊</b></a>
							
							<table><tr><td>
							<div id="user_div" class="select_sub">
								<ul class="sub">
									<li id="user_list"><a href="<?=site_url("manage/user/user_list")?>">網友列表</a></li>
                                                                        <li id="user_share_message"><a href="<?=site_url("manage/user/user_share_message")?>">網友分享文章列表</a></li>
								</ul>
								
							</div>
							</td></tr></table>
							
						</li>
					</ul>
					
					<?php 
					if ($_SESSION[SESSION_PRE."sys_auth"]<=1){?>  		
					<div class="nav-divider">&nbsp;</div>
		
					<ul id="manager" class="select">
						<li>
							<a href="#nogo"><b>管理員</b><!--[if IE 7]><!--></a><!--<![endif]-->
							<table><tr><td>
							<div id="manager_div" class="select_sub">
								<ul class="sub">
									<li id="manager_list"><a href="<?=site_url("manage/manager/manager_list")?>">管理員列表</a></li>
								</ul>
							</div>
							</td></tr></table></a>
						</li>
					</ul>
                                        <?php 
					}?>
		
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<!--  end nav -->

		</div>
		<div class="clear"></div>
		<!--  start nav-outer -->
	</div>
	<!--  start nav-outer-repeat................................................... END -->

 	<div class="clear"></div>
 
	<!-- start content-outer ....................................................................................START -->
	<div id="content-outer">
		<!-- start content -->
		<div id="content">

			<table border="0" width="100%" cellpadding="0" cellspacing="0" class="content-table">
				<tr>
					<th rowspan="3" class="sized"><img src="<?=WEB_I?>/manage/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
					<th class="topleft"></th>
					<td id="tbl-border-top">&nbsp;</td>
					<th class="topright"></th>
					<th rowspan="3" class="sized"><img src="<?=WEB_I?>/manage/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
				</tr>
				<tr>
					<td id="tbl-border-left"></td>
					<td>
					<!--  start content-table-inner ...................................................................... START -->
						<div class="content-table-inner">
		
							<!--  start table-content  -->
							<div id="table-content">
							<?php
							if (!empty($msg)){
								switch ($msg){
								case "auth_error":
									$color="yellow";
									$message="權限不足";
									break;
								case "parms_error":
									$color="red";
									$message="參數錯誤";
									break;
								case "add_fin":
									$color="green";
									$message="新增完成";
									break;
								case "edit_fin":
									$color="green";
									$message="編輯完成";
									break;
								case "sort_fin":
									$color="green";
									$message="排序完成";
									break;
								case "upload_type_error":
									$color="yellow";
									$message="上傳格式錯誤";
									break;
								case "upload_error":
									$color="red";
									$message="上傳發生錯誤";
									break;
								case "id_exits":
									$color="yellow";
									$message="id 或名稱已存在";
									break;
								case "id_not_exists":
									$color="yellow";			
									$message="id 不存在";
									break;
								case "id_error":
									$color="red";
									$message="id 只能包含a-zA-Z,-_及0-9";
									break;
								case "input_content_error":
									$color="red";		
									$message="輸入內容有誤";
									break;
									
								default:
									$color="red";
									$message="不明錯誤";
									break;
								}
								
								switch ($color){
					
								case "yellow":
							?> 						
								<!--  start message-yellow -->
								<div id="message-yellow">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="yellow-left"><?=$message?></td>
											<td class="yellow-right"><a class="close-yellow"><img src="<?=WEB_I?>/manage/table/icon_close_yellow.gif"   alt="" /></a></td>
										</tr>
									</table>
								</div>
								<!--  end message-yellow -->
							<?php 
									break;
								case "red":?>
				
									<!--  start message-red -->
								<div id="message-red">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="red-left"><?=$message?></td>
											<td class="red-right"><a class="close-red"><img src="<?=WEB_I?>/manage/table/icon_close_red.gif"   alt="" /></a></td>
										</tr>
									</table>
								</div>
									<!--  end message-red -->
							<?php 
									break;
								case "blue":?>
								<!--  start message-blue -->
								<div id="message-blue">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="blue-left"><?=$message?></td>
											<td class="blue-right"><a class="close-blue"><img src="<?=WEB_I?>/manage/table/icon_close_blue.gif"   alt="" /></a></td>
										</tr>
									</table>
								</div>
									<!--  end message-blue -->
							<?php 
									break;
								case "green":?>
								<!--  start message-green -->
								<div id="message-green">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="green-left"><?=$message?></td>
											<td class="green-right"><a class="close-green"><img src="<?=WEB_I?>/manage/table/icon_close_green.gif"   alt="" /></a></td>
										</tr>
									</table>
								</div>
								<!--  end message-green -->
							<?php 
									break;
								}
							}?>
								<!-- 主內容 -->
		 						<?=$content?>
		 						<!-- 主內容End -->
							</div>
							<!--  end content-table  -->
							<div class="clear"></div>
		 
						</div>
						<!--  end content-table-inner ............................................END  -->
					</td>
					<td id="tbl-border-right"></td>
				</tr>
				<tr>
					<th class="sized bottomleft"></th>
					<td id="tbl-border-bottom">&nbsp;</td>
					<th class="sized bottomright"></th>
				</tr>
			</table>
			<div class="clear">&nbsp;</div>

		</div>
		<!--  end content -->
		<div class="clear">&nbsp;</div>
	</div>
	<!--  end content-outer........................................................END -->

	<div class="clear">&nbsp;</div>
    
	<!-- start footer -->         
	<div id="footer">
		<!--  start footer-left -->
		<div id="footer-left">
			design by AH SOLUTION 
		</div>
		<!--  end footer-left -->
		<div class="clear">&nbsp;</div>
	</div>
	<!-- end footer -->
 
</body>

</html>