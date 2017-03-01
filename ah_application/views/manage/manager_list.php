
    <h2>管理員列表</h2>
    <br/>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
    	<tr>
    		<td align="left">
				<a href="<?=site_url("manage/manager/manager_add")?>">
					<img alt="icon" src="<?=WEB_I?>/manage/forms/icon_plus.gif"/>
				</a>
				新增管理員
    		</td>
    		<td align="right">
    			總筆數:<?=$total_row?>
    		</td>
    	</tr>
    </table>
	<div style="float:right">
	<table cellspacing="0" cellpadding="0" border="0" id="paging-table">
		<tbody>
			<tr>
				<td>
					<?=$pagination?>
				</td>
			</tr>
		</tbody>
	</table>	
	</div>
    

	
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="default-table">
		<tr>
			<th class="table-header-repeat line-left" style="margin:0 20px"><span style="font-size: 13px;color:#FFFFFF">id</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF">姓名</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF">權限</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF">狀態</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF">備註</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF">最後登入時間</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF">操作</span></th>
		</tr>
        <?php
        $i=0;
        foreach ($managers as $manager){
               
			if ($i%2==0){?>
        	
		<tr>
		<?php 
			}else{?>
		<tr class="alternate-row">
			<?php 
			}?>
		
			<td><?=$manager->id?></td>
			<td><?=$manager->manager_name?></td>
			<td><?php 
                	switch ($manager->sys_auth){
					case 0:
					?>
						系統人員
					<?	
						break;
					case 1:
					?>
						最高管理員
					<?	
						break;
					case 2:
					?>
						使用者
					<?	
						break;
					}
					?>
			</td>
			<td><?php 
                	switch ($manager->status){
					case "A":
					?>
						使用中
					<?	
						break;
					case "C":
					?>
						<font color="red">
						<b>暫時關閉</b>
						</font>
					<?	
						break;
					}
					?>
			</td>
			<td><?=str_replace("\n","<br/>",$manager->memo)?></td>
			<td>
				<?php
				if (!empty($manager->last_login_time)){?>
				<?=$manager->last_login_time?>
				<?php 
				}?>
			</td>
			<td class="options-width">
				<a href="<?=site_url("manage/manager/manager_edit")."?id=".$manager->id."&per_page=".$per_page?>" title="Edit" class="icon-1 info-tooltip"></a>
			</td>
		</tr>	
		<?php 
			$i++;
		}?>
	</table>	

