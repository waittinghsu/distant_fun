
    <h2>網友列表</h2>
    <br/>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
    	<tr>
    		<td>
    			<a href="<?=site_url("manage/user/user_list_save_to_XLS")?>" target="_blank">匯出到excel</a>
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
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">fb_id</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">大頭照圖片</span></th>			
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">fb暱稱</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">性別</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">Email</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">生日</span></th>
			<!-- <th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">農曆生日</span></th> -->
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">姓名</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">聯絡電話</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">聯絡地址</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">發佈次數</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">utm_source</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">utm_medium</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">utm_campaign</span></th>
			
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">資料建立日期</span></th>
                        <th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">資料建立時間</span></th>
			<th class="table-header-repeat line-left"><span style="font-size: 13px;color:#FFFFFF;line-height:14px">資料建立IP</span></th>
		</tr>
		
		<?php
        $i=0;
        foreach ($users as $user){
               
			if ($i%2==0){?>
        	
		<tr>
		<?php 
			}else{?>
		<tr class="alternate-row">
			<?php 
			}?>
		
			<td><?=$user->fb_id?></td>
			<td>
				<img src='https://graph.facebook.com/<?=$user->fb_id?>/picture?type=large' width="80"/>
			</td>
			<td><?=$user->fb_name?></td>
			<td><?=$user->gender?></td>
			<td><?=$user->email?></td>
			<td><?=$user->birthday?></td>
			<!-- <td><?=$lunar_birthday[$user->fb_id]?></td> -->
			<td><?=$user->user_name?></td>
			<td><?=$user->phone?></td>
			<td><?=$user->address?></td>
			<td><?=$user->publish_times?></td>
			<td><?=$user->utm_source?></td>
			<td><?=$user->utm_medium?></td>
			<td><?=$user->utm_campaign?></td>			
			
			<td><?=$user->create_date_day?></td><!--20140625 將資料庫DATETIME格是換成 DATE  TIME-->
                        <td><?=$user->create_time?></td>
			<td><?=$user->create_ip?></td>
		</tr>	
		<?php 
			$i++;
		}?>
	</table>	



