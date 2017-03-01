<?php 
switch ($act){
	case "add":
?>
<h2>新增管理員</h2>
<?php
	break; 
	case "edit":
?>
<h2>編輯管理員</h2>
<?php 		
	break;
}	
?>
<br/>
<div id="content-table-inner">
	
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody><tr valign="top">
	<td>
		<!-- start id-form -->
		<form id="form1" name="form1" action="<?=$action?>" method="post" onsubmit="return check()">
		<table cellspacing="0" cellpadding="0" border="0" id="id-form">
		<tbody><tr>
			<th valign="top">id:</th>
			<td><?php 
                	switch ($act){
                		case "add":
                	?>		
							<input type="text" name="id" id="id" class="inp-form" value="<?=$id?>"/>
					<?php 

							break;
						case "edit":
					?>	
							<?=$id?>
							<input type="hidden" name="id" id="id" value="<?=$id?>"/>	
					<?php		
							break;
					}		  
							?>
			</td>
			<td>
				<div id="id_error" style="display:none">
					<div class="error-left"></div>
					<div id="id_error_inner" class="error-inner">This field is required.</div>
				</div>
			
			</td>
		</tr>
		<tr>
			<th valign="top">password:</th>
			<td>
				<input type="password" name="password" id="password" class="inp-form" value="<?=$password?>"/>
			</td>
			<td>
				<div id="password_error" style="display:none">
					<div class="error-left"></div>
					<div id="password_error_inner" class="error-inner">This field is required.</div>
				</div>
			</td>
		</tr>
		<tr>
			<th valign="top">姓名:</th>
			<td>
				<input type="text" name="manager_name" id="manager_name" class="inp-form" value="<?=$manager_name?>"/>
			</td>
			<td>
				<div id="manager_name_error" style="display:none">
					<div class="error-left"></div>
					<div id="manager_name_error_inner" class="error-inner">This field is required.</div>
				</div>
			</td>
		</tr>
		<tr>
			<th valign="top">權限:</th>
			<td>
				<?php 
                	if ($_SESSION[SESSION_PRE."sys_auth"]==0){?>
                	<input type="radio" name="sys_auth" value="0" <?php if($sys_auth==0){?>checked="checked"<?php }?>/>系統管理員<br/>
                	<?php 
                	}?>
                	<input type="radio" name="sys_auth" value="1" <?php if($sys_auth==1){?>checked="checked"<?php }?>/>最高管理員<br/>
                	<input type="radio" name="sys_auth" value="2" <?php if($sys_auth==2){?>checked="checked"<?php }?>/>一般使用者
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<th valign="top">狀態:</th>
			<td>
                	<input type="radio" name="status" value="A" <?php if($status=="A"){?>checked="checked"<?php }?>/>使用中<br/>
                	<input type="radio" name="status" value="C" <?php if($status=="C"){?>checked="checked"<?php }?>/>關閉<br/>
                	<?php 
                	if ($act=="edit"){?>
                		<input type="radio" name="status" value="D" />刪除(選擇此項目,該人員將不再於清單內出現)
                	<?php 
                	}?>	
            </td>
			<td>
			</td>
		</tr>				
		

	<tr>
		<th valign="top">備註:</th>
		<td><textarea class="form-textarea" id="memo" name="memo" cols="" rows=""><?=$memo?></textarea></td>
		<td></td>
	</tr>

	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="hidden" id="per_page" name="per_page" value="<?=$per_page?>"/>
			<input type="submit" class="form-submit" value="">
<!-- 			<input type="reset" class="form-reset" value=""> -->
		</td>
		<td></td>
	</tr>
	</tbody></table>
	</form>
	<!-- end id-form  -->

	</td>
	<td>



</td>
</tr>
<tr>
<td><img width="695" height="1" alt="blank" src="<?=WEB_I?>/manage/shared/blank.gif"></td>
<td></td>
</tr>
</tbody></table>
 
<div class="clear"></div>
 

</div>

<script>
                	
	function check(){
		var error=false;
		$("#id").attr("class","inp-form");
		$("#id_error").attr("style","display:none");
		$("#password").attr("class","inp-form");
		$("#password_error").attr("style","display:none");
		$("#manager_name").attr("class","inp-form");
		$("#manager_name_error").attr("style","display:none");
		
		if (Trim(document.form1.id.value)==""){
			$("#id").attr("class","inp-form-error");
			$("#id_error").attr("style","display:block");
			$("#id_error_inner").html("您忘了填寫id囉");
			error=true;
		}
		if (Trim(document.form1.password.value)==""){
			$("#password").attr("class","inp-form-error");
			$("#password_error").attr("style","display:block");
			$("#password_error_inner").html("您忘了填寫password囉");
			error=true;
			
		}
		if (Trim(document.form1.manager_name.value)==""){
			$("#manager_name").attr("class","inp-form-error");
			$("#manager_name_error").attr("style","display:block");
			$("#manager_name_error_inner").html("您忘了填寫姓名囉");
			error=true;
		}		
		if (error==true){
			return false;
		}
	}	
</script>
