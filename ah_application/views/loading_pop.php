<!--nav-->
<div class="loading_popblock"  style="display:none;"></div>	
<div class="loadinggif" style="display:none;">
    <img width="auto" height="auto"class="tt2" src="<?= WEB_I ?>/loading/loading2.gif"/>            
</div>  
<!--end nav--> 
<script>
    function loading_pop_open() {
    $(".loading_popblock").show();
    $(".loadinggif").show();
    }
    function loading_pop_close() {     
            $(".loading_popblock").hide(); 
            $(".loadinggif").hide(); 
    }    
</script>