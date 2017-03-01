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
        <link href="<?= WEB_C ?>/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?= WEB_C ?>/common.css" rel="stylesheet" type="text/css" />
<!--            <link rel="shortcut icon" href="<?= WEB_I ?>/common/16x16.ico" type="image/x-icon"/>-->

        <script>
            var publish_url = "<?= site_url("ajax/publish") ?>";
            var do_login_url = "<?= site_url("user/do_login") ?>";
            var base_url = "<?= site_url('') ?>";
        </script>
    </head>
    <body data-target=".bs-docs-sidebar" data-spy="scroll">   
        <div class="row">
            <div class="span9">   
                <?=$menu?>               
                <span class="label label-info">參加者列表</span> <br />
                <?php foreach ($fb_pic as $key => $value):?>
                   <?=$value?>
                <?php endforeach;?>
                <div class="control-group info" align="center">                  
                    <?php if($join_check != 'N'):?>
                        <div class="controls">
                            <br />
                            <?php if($join_check->usergroup_check == 'Y'):?>
                            <a id="get_card" class="btn btn-large btn-primary disabled">開始加入遊戲搂</a>
                            <?php else: ?>       
                            <a href="#" class="btn btn-large btn-warning disabled">等候管理員認證</a>
                            <?php endif;?>       
                        </div>
                     <?php endif;?>
                        <div v class="controls" align="center">
                            <img src="<?=$group_pic?>" class="img-polaroid" width="500px" height="auto">                                     
                        </div>                    
                    
                        <div class="controls">
                            <br /><br />
                            <strong><?=$qroup_info_query->group_description?></strong>
                        </div>                    
                        <div class="controls">
                            <br />
                            <button type="button" id="profile_submit" class="btn btn-info btn-large ">加入此群組</button>                            
                        </div>
                </div>
            </div>   
        </div>        
        <?=$loading_pop?>
    </body>
</html>
<script>
    $(document).ready(function(){       
        $("#get_card").bind('click',function(){
                loading_pop_open();
               $.ajax({
                    type: "POST",
                    url: '<?=  site_url("user/ajax_usergroup_card")?>',
                    dataType: 'text',
                    data: "group=<?=$group_id?>",
                    success: function(result) {
                        var resultobj = jQuery.parseJSON(result);
                        console.log(resultobj);
                        if(resultobj.msg != ''){
                            setTimeout(function(){alert(resultobj.msg);loading_pop_close();window.location=resultobj.href;},3000);      
                            
                        }
                        
                    }, error: function(doc, error) {
//                            alert(error + doc);
                              alert('Something had Happened!!');  
                        }
                });                
               //ajax_usergroup_card
        });
        $("#profile_submit").bind('click',function(){
            $.ajax({
                    type: "POST",
                    url: '<?=  site_url("group/ajax_join_group")?>',
                    dataType: 'text',
                    data: "group=<?=$group_id?>",
                    success: function(result) {
                        var resultobj = jQuery.parseJSON(result);
//                        console.log(resultobj);
                        if(resultobj.msg != ''){
                            alert(resultobj.msg);
                            window.location=resultobj.href;
                        }                        
                    }, error: function(doc, error) {
//                            alert(error + doc);
                              alert('Something had Happened!!');  
                        }
                }); 
        });
    });
</script>
