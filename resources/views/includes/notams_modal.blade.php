<style type="text/css">
    /*    #progress_bar{
	    background-color:#f1292b;	
	}*/
    .ui-widget-content{
	border:none;
    }
    #progress_bar .ui-widget-header {
	background: repeating-linear-gradient( 45deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 10px, rgba(0, 0, 0, 0.3) 10px, rgba(0, 0, 0, 0.3) 20px );
	height: 15px;
	/*width: 100% !important;*/
    }
    .modal-body{
    	padding: 0 20px;
    text-align: center;
    font-size: 14px;
    }
    #notam-pg-box .modal-container{
    	/*background: none;*/
    	box-shadow: none;
    }
    .modal-backdrop.in {
	opacity: 0.4;
}
        .ui-progressbar-value {
		background: url(http://www.netanimations.net/Animated-fighter-plane-fly-by.gif) no-repeat;
		border:none;
	    }
	    .ui-progressbar {
		height: 20px
	    }
    /*.ui-autocomplete-loading { background:url("http://www.gifs.cc/aircraft/harrier-jet-animated-1.gif") no-repeat right center }
</style>
<div id="notam-pg-box" class="modal fade" style="display:none;" >
    <div class="modal-dialog modal-container">
	<section class="popupBody modal-body">

	    <div class="user_login">
		<div class="row">
		    <span class="fpl_loader"></span>
		    <p id="" style="width:98%;text-align: center">
		    <span class="fpl_loader"><a href=""><i style="color:#f1292b;font-size:1.3em" class="fa fa-spinner fa-spin"></i></a><span style="font-weight:bold" id="loaderText"> </span></span>
			<span id="progress_bar" ></span> <span id="percentage2" ></span>
		    </p>
		</div>
	    </div>
	</section>
    </div>
</div>


