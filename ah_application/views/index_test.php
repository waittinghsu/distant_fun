<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>test</title>

        <meta property="og:site_name" content="人"/>
        <meta name="keywords" content="">
            <meta property="og:title" content=""/>
            <meta name="description" content="">
                <meta property="og:description" content=""/>
                <meta property="og:image" content="<?= WEB_I ?>/common/fb600_site3.jpg"/>


                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
                <script type="text/javascript" src="<?= WEB_J ?>/main.js"></script>
                <script type="text/javascript" src="<?= WEB_J ?>/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- <link rel="shortcut icon" href="<?= WEB_I ?>/common/16x16.ico" type="image/x-icon"/> -->
<!--<link href="<?= WEB_C ?>/reset.css" rel="stylesheet" type="text/css" />-->
                <link href="<?= WEB_C ?>/normal.css" rel="stylesheet" type="text/css" />
                <link href="<?= WEB_C ?>/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

                <script>
                    //ga code
                    var publish_url = "<?= site_url("ajax/publish") ?>";
                    var user_data_url = "<?= site_url("ajax/user_data") ?>";

                </script>
                </head>
                <body class="" data-page="index"> 
                    <div style="background: <?= WEB_I ?>/index/bg_lay1.png;" class="container">
                        <!--背景-->
                        <br /><br /><br /><br /><br /><br />                
                        <img src="<?= WEB_I ?>/fb_img_make/100004391437677.png" />
                        <br />  
                        <select id="city"name="city">
                            <option value="">請選擇縣市</option>
                            <?php foreach ($city as $key => $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->city_name ?></option>
                            <?php endforeach; ?>
                        </select>  
                        <select id="town"name="town">
                            <option value="">請選擇鄉鎮</option>                    
                        </select>       



                    </div> 


                    <script>
                        var CI_town = jQuery.parseJSON('<?= $town ?>');
                        $(document).ready(function() {
                            $("#city").bind("change", function() {
                                var CI_city = parseInt($(this).val());
                                $("#town").html("");
                                $("#town").append("<option value=''>請選擇鄉鎮</option>");
                                for (var i = 0; i < CI_town[CI_city].length; i++) {
                                    $("#town").append("<option value='" + $('#city :selected').text() + CI_town[CI_city][i].town_name + "'>" + CI_town[CI_city][i].town_name + "</option>");
                                    //                    console.log(CI_town[CI_city][i].town_name );
                                }
                            });
                        });
                    </script>
                </body>
                </html>
