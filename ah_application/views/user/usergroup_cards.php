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
<!--            <link rel="shortcut icon" href="<?= WEB_I ?>/common/16x16.ico" type="image/x-icon"/>-->

        <script>
            var publish_url = "<?= site_url("ajax/publish") ?>";
            var do_login_url = "<?= site_url("user/do_login") ?>";
            var base_url = "<?= site_url('') ?>";
            $(document).ready(function(){               
               $('.CardInfo').bind('click',function(){    
                   if(confirm('確定選擇這一張牌嗎~~~~')){ 
                        $.ajax({
                             type: "POST",
                             url: "<?=  site_url('user/ajax_getcard')?>",
                             dataType: 'json',
                             data: {
                                 "groupId":"<?=$groupId?>",
                                 "CardInfo":$(this).prop('id')
                             },
                             success: function(result) {
                                 console.log(result);
                                 switch(result.status){
                                     case 'done':
                                         alert(result.msg);
                                         window.location=result.href;
                                         break;
                                     case 'noting':
                                         alert(result.msg);        
                                         break;
                                     default:
                                         alert(result.msg);
                                         window.location=result.href;
                                         break;
                                         
                                 }
     //                            if(resultobj.status == 'done'){
     //                                window.location=resultobj.href;
     //                            }
                             }, error: function(doc, error) {
                                     alert(error + doc);
                                 }

                        });
                   }
                   
               });
               
            });
        </script>
    </head>
    <body data-target=".bs-docs-sidebar" data-spy="scroll">           
        <div class="row">
            <div class="span9">
                <?=$menu?>                
                <div class="bs-docs-card">
                    <div class="control-group info">
                        <?php if(!empty($PickUser)):?>                          
                                <div class="thumbnail">
                                    <h2>你抽到這傢伙啦~</h2>                              
                                    <img src="https://graph.facebook.com/<?=$PickUser->Providerkey?>/picture?type=large" class="img-polaroid" width="auto" height="auto">
                                    <div class="caption">  
                                    <p align="center"><?=$PickUser->user_name?></p>
                                    <p align="center"><?=$PickUser->user_mobile_phone?></p>
                                    <p align="center"><?=$PickUser->user_address?></p>
                                    <p align="center"><?=$PickUser->user_address_memo?></p>                               
                                    </div>
                                </div>                           
                            <?php endif;?>
                    </div>
                 
                    <div class="row-fluid">
                        <ul class="thumbnails">
                            <?php foreach ($group_cards_data as $key => $value):?>
                            <li >                               
                                <div class="thumbnail">
                                    <img src="<?=WEB_I?>/common/<?=$value->picname?>" class="img-polaroid" width="130" height="443">
                                    <div class="caption">
                                    <p align="center"><a class="btn btn-primary CardInfo" id="<?=$value->piccode?>">I like this card</a></p>                                   
                                    </div>
                                </div>                               
                            </li>
                            <?php endforeach;?>                            
                        </ul>
                    </div>
                    
                </div>
            </div>   
        </div>        
    </body>
</html>
