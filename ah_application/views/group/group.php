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
        </script>
    </head>
    <body data-target=".bs-docs-sidebar" data-spy="scroll">   
        <div class="row">
            <div class="span9"> 
                <?=$menu?>   
                <div class="row-fluid">
                    <?=$pagination?>
                    <ul class="thumbnails">                        
                        <?php foreach ($group_infos as $key => $value): ?>
                        <li class="span4">
                            <div align="center">
                                <span class="label label-info"> <?= $value->group_name?></span> 
                                <a href="<?=  site_url('group/group_info')?>?gid=<?=$value->Id?>" class="thumbnail">                              
                                    <img src="<?=WEB_I?>/group/group<?=$value->Id?>.jpg" class="img-circle" width="300px" height="auto">
                                </a>
                                <?= $value->group_description?>
                                <span class="label label-info"> <?= $value->group_creattime?></span> 
                            </div>
                        </li>
                        <?php endforeach; ?>                      
                    </ul>
                </div>
                
                
               
            </div>   
        </div>        
    </body>
</html>
