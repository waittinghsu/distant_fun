                <div class="navbar navbar-inverse">                  
                    <div class="navbar-inner">
                      <div class="container">  
                        <!-- Be sure to leave the brand out there if you want it shown -->
                        <a class="brand" href="#">Title</a>
                        <ul id="menu_ul" class="nav">
                            <li id="menu_home"><a href="#">Home</a></li>
                            <li id="menu_group"><a href="<?=  site_url('group')?>">group</a></li>
                            <li id="menu_mygroup"><a href="<?=  site_url('group/mygroup')?>">mygroup</a></li>
                            <li id="menu_profile"><a href="<?=  site_url('user/profile')?>">profile</a></li>
                            <li id="menu_logout"><a href="<?=  site_url('user/logout')?>">logout</a></li>
                          </ul>
                      </div>
                    </div>
                </div>
<script>
    $(document).ready(function(){        
        $('#menu_'+'<?=$menu_tag?>').addClass('active');
    });
</script>