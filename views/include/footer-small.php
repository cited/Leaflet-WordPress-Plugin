<html>
 
<head>
<style>
/*rs style*/
#rs_main_footer .rs_new_row_bottom {
     background: none repeat scroll 0 0 #444444;
    color: #b3b3b3;
    font-size: 14px;
  padding-bottom: 10px;
    padding-top: 10px;
}
#rs_main_footer .container{width:1070px !important;}
#rs_main_footer .rs_footer_s {
    margin-bottom: 0;
    text-align: right;
}
#rs_main_footer .rs_new_row_top{
    background: none repeat scroll 0 0 #6dbd63;
   padding-bottom:20px;
 margin-top: 20px;
}
#rs_main_footer .new_footer_about_p{color:#fff;font-size: 14px;}
#rs_main_footer .rs_more{color: #377130;
    font-size: 16px;}

#rs_main_footer .title{   color: #2e5f28;
    font-size: 22px;
    font-weight: normal;}
#rs_main_footer .rs_new_ul li a {
    color: #377130;
    font-size: 16px;
}
#rs_main_footer .rs_only_right_side p {
   color: #377130;
    font-size: 18px;
}
#rs_main_footer .rs_eemail a{ color: #377130 !important;
    font-size: 16px;}
#rs_main_footer .rs_footer_s li a {
    color: #b3b3b3;
    font-size: 20px;
    margin-left: 7px;
}
#rs_main_footer .rs_footer_s li {
    margin-bottom: 0;
}
#rs_main_footer .rs_new_row_bottom .copyright {
    padding-top: 5px;
}
#rs_main_footer .rs_new_ul li {
    margin-bottom: 10px;
}
</style>
</head> 



<div style="clear:both;">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
<div class="rs_footer3" id="rs_main_footer">


<footer2 class="footer2">

        <div class="footer2-content">

            <div class="container">
                <div class="row rs_new_row_top">


        <div class="bottom-bar2">
            <div class="container">
                <div class="row rs_new_row_bottom">
                    <small class="copyright col-md-6 col-sm-6 col-xs-12"><?=MF_COPYRIGHT_TEXT?>.<br><a href="http://www.acugis.com/" target="_blank">AcuGIS</a> GIS Hosting | <a href="https://www.brainfurnace.com" target="_blank">Brainfurnace</a> PostgreSQL</small>
                    <ul class="social2 rs_footer_s col-md-6 col-sm-6 col-xs-12 list-inline">
                        <li><a href="<?=MF_TWITTER_URL?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?=MF_FACEBOOK_URL?>" target="_blank"><i class="fa fa-facebook"></i></a></li>                        
                        <li><a href="<?=MF_LINKEDIN_URL?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li class="last"><a href="<?=MF_GITHUB_URL?>" target="_blank"><i class="fa fa-github"></i></a></li>
                    </ul><!--//social-->
              </div><!--//row-->
            </div><!--//container-->
        </div><!--//bottom-bar-->
    </footer2>



</div>

</html>



<script>
	function Alert(message, type) {
		title = ""
		if(!message)
			message = "";
		switch(type) {
			case "default":
				type = BootstrapDialog.TYPE_DEFAULT;
				title = "Information!";
				break;
			case "info":
				type = BootstrapDialog.TYPE_INFO;
				title = "Information!";
				break;
			case "primary":
				type = BootstrapDialog.TYPE_PRIMARY;
				title = "Information!";
				break;
			case "notify":
				type = BootstrapDialog.TYPE_PRIMARY;
				title = "Notification!";
				break;
			case "success":
				type = BootstrapDialog.TYPE_SUCCESS;
				title = "Success!";
				break;
			case "warning":
				type = BootstrapDialog.TYPE_WARNING;
				title = "Warning!";
				break;
			case "danger":
			case "error":
				type = BootstrapDialog.TYPE_DANGER;
				title = "Error!";
				break;
			default :
				type = BootstrapDialog.TYPE_DEFAULT;
				title = "Information!";
		}
		bd = BootstrapDialog.alert(message);
		bd.setType(type);
		bd.setTitle(title);
	}
	$(document).ready(function(){
		$('a.btn.btn-danger').click(function(e){
			var text = $.trim($(this).text());
			
			if(text == "Remove" || text == "Delete" || $(this).find('.fa.fa-remove').length == 1) {
				var href = $(this).attr('href');
				e.preventDefault();
				
				BootstrapDialog.confirm("Are you Sure you want to delete it?", function(result){
					if(result) {
						window.location = href;
					}
				});
			}
		});
	});
</script>
<style>
	.breadcrumb-arrow li.pull-right.help a {
		border: none!important;
		background: none!important;
	}
	.breadcrumb-arrow li.pull-right.help a:before, .breadcrumb-arrow li.pull-right.help a:after {
		border: none!important;
	}
	.breadcrumb-arrow li.pull-right.help a:focus {
		outline:none;
	}
</style>