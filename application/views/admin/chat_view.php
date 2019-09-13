
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<script type="text/javascript">

$(document).ready(function(){

 var objDiv = $(".panel-body");
 var h = objDiv.get(0).scrollHeight;
 objDiv.animate({scrollTop: h});

setInterval(function(){ 

var sender_id = '<?php echo $sender_id; ?>';
var receiver_id = '<?php echo $reciver_id; ?>';
//alert(sender_id +''+ receiver_id);
$.ajax({ url:'<?php echo base_url();?>/users/user_chat_view',
	type:'POST',
	data: {sid:sender_id,rid:receiver_id},
	success: function(data)
	{
	//alert(data);
	
        $("#chatmsg").html(data);
	//location.reload();
	}
      });
        var objDiv = $(".panel-body");
    	 var h = objDiv.get(0).scrollHeight;
    	 //objDiv.animate({scrollTop: h});

 }, 1000);



});
</script>


<style>
.chat-body {
    overflow-y: auto;
    height: auto;
}
 .pull-right {
    float: right !important;
}
.pull-left {
    float: left!important;
}
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
 
    margin-bottom: 25px;
    margin-top: 15px;
}

.chat li.right .chat-body
{
   margin-left: 60px;
 
    margin-bottom: 25px;
    margin-top: 15px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 400px;
	    padding: 15px;
    width: 100%;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}
.panel-body {
    padding: 15px;
}
.panel-footer .input-group .form-control {
    position: relative;
    z-index: 2;
    float: left;
    width: 100%;
    margin-bottom: 0;
    height: 60px;
}
.panel-footer {
padding: 10px 0px 10px 15px;
    background-color: #fafafa;
    border-top: 1px solid #eeeeee;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    width: 50%;
}
button#btn-chat {
    height: 60px;
    background: #6f106c;
    border: 1px solid #6f106c;
    font-size: 14px;
    letter-spacing: 0.5px;
    font-weight: 500;
}

span.chat-img img {
    width: 50px;
    height: 50px;
}
span.chat-img .on-active {
    position: relative;
    right: 15px;
    bottom: 15px;
		 color:green;
}


.chat li.left .chat-body ,
.chat li.right .chat-body{

}
 
 .on-active{
	 color:green;
 }
</style>

       
<!--chating coding here-->

<div class="content-wrapper">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 p-0">
                            <div class="main-header">
                                <h4>Messages</h4>
                            </div>
                        </div>
                    </div>

                    <!-- 1-1 blocks row start -->
                   
                 
   
                    <!-- 2nd row start -->
                   
                    <!-- 2nd row end -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card col-lg-12">
                                <div class="card-header">
                                    <h5 class="card-header-text">Conversion</h5>
                                </div>
                                <div class="table-responsive ">
                                    <div class="table-content">
                                        <div class="project-table p-20">
                                            <table id="product-list-dasbord" class="table dt-responsive nowrap" width="100%" cellspacing="0">
                                                <tbody>
                <div class="panel-body">                 
		<ul class="chat" id="chatmsg">			
												
			
									
		</ul>
		</div>				 
                <!--<div class="panel-footer" style="width:720px">
                    <div class="input-group">
                        <input id="msg_val" type="text"  class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat" onclick="submitdata()">Send</button>

                        </span>
                    </div>
		</div>	-->
					
		</tbody>
                </table>
                </div>
                  </div>

                                </div>
                            </div>
                        </div>
<!-- Contact card start -->
                        <div class="col-lg-6">
                        
                         <!--<div class="card col-lg-12">
                                <div class="card-header">
                                    <h5 class="card-header-text">Users</h5>
                                </div>
                             <div class="table-responsive dasboard-4-table-scroll">
                                    <div class="table-content">
                                        <div class="project-table p-20">
                                            <table id="product-list-dasbord" class="table dt-responsive nowrap" width="100%" cellspacing="0">
                                                <tbody>
 <ul class="chat" id="chatlist">
 
 
 
             
</ul>
                                               </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        
                        </div>
 Contact card End -->
 
                    </div>
                </div>
        <!-- Container-fluid ends -->
     </div>


        <!-- end row -->
        <!-- begin row -->
            <!-- end col-8 -->
            <!-- begin col-4 -->
            
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->

    <!-- begin theme-panel -->
    <div class="theme-panel">
        <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
        <div class="theme-panel-content">
            <h5 class="m-t-0">Color Theme</h5>
            <ul class="theme-list clearfix">
                <li class="active"><a href="javascript:;" class="bg-green" data-theme="default"
                                      data-click="theme-selector" data-toggle="tooltip" data-trigger="hover"
                                      data-container="body" data-title="Default">&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-red" data-theme="red" data-click="theme-selector"
                       data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
                <li><a href="javascript:;" class="bg-blue" data-theme="blue" data-click="theme-selector"
                       data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue">&nbsp;</a>
                </li>
                <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-click="theme-selector"
                       data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a>
                </li>
                <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-click="theme-selector"
                       data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a>
                </li>
                <li><a href="javascript:;" class="bg-black" data-theme="black" data-click="theme-selector"
                       data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a>
                </li>
            </ul>
            <div class="divider"></div>
            <div class="row m-t-10">
                <div class="col-md-5 control-label double-line">Header Styling</div>
                <div class="col-md-7">
                    <select name="header-styling" class="form-control input-sm">
                        <option value="1">default</option>
                        <option value="2">inverse</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-5 control-label">Header</div>
                <div class="col-md-7">
                    <select name="header-fixed" class="form-control input-sm">
                        <option value="1">fixed</option>
                        <option value="2">default</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-5 control-label double-line">Sidebar Styling</div>
                <div class="col-md-7">
                    <select name="sidebar-styling" class="form-control input-sm">
                        <option value="1">default</option>
                        <option value="2">grid</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-5 control-label">Sidebar</div>
                <div class="col-md-7">
                    <select name="sidebar-fixed" class="form-control input-sm">
                        <option value="1">fixed</option>
                        <option value="2">default</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-5 control-label double-line">Sidebar Gradient</div>
                <div class="col-md-7">
                    <select name="content-gradient" class="form-control input-sm">
                        <option value="1">disabled</option>
                        <option value="2">enabled</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-5 control-label double-line">Content Styling</div>
                <div class="col-md-7">
                    <select name="content-styling" class="form-control input-sm">
                        <option value="1">default</option>
                        <option value="2">black</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-10">
                <div class="col-md-12">
                    <a href="#" class="btn btn-inverse btn-block btn-sm" data-click="reset-local-storage"><i
                            class="fa fa-refresh m-r-3"></i> Reset Local Storage</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end theme-panel -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
            class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<script>
    /* function checkone()
     {
        alert('hello');
                   var sender_id = '<?php echo $sender_id; ?>';
                   var receiver_id = '<?php echo $reciver_id; ?>'; 
                    var msg = document.getElementById("msg_val").value;

if(msg =='')
{
document.getElementById("msg_val").focus();

}
else
{
//alert(msg);
//alert(sender_id);
//alert(receiver_id);

$.ajax({ url:'<?php echo base_url();?>/users/chat_message',
	type:'POST',
	data: {sid:sender_id,rid:receiver_id, message:msg},
	success: function(data)
	{
	//alert(data);
if(data)
{
       document.getElementById("msg_val").value='';
	$("#chatmsg").html(data);

         var objDiv = $(".panel-body");
    	 var h = objDiv.get(0).scrollHeight;
    	 objDiv.animate({scrollTop: h});


 }      
	//location.reload();
	}
      });


}

}*/
</script>



<!-- ================== BEGIN BASE JS ================== -->

<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/crossbrowserjs/html5shiv.js"></script>
<script src="<?php echo base_url(); ?>assets/crossbrowserjs/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-cookie/js.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morris/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morris/morris.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dashboard_demo.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function () {
        App.init();
        Dashboard.init();
    });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-66289183-4"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-66289183-4');
</script>


<script type="text/javascript">

 $('#msg_val').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    //alert('You pressed a "enter" key in textbox'); 
                submitdata();                
}             
                event.stopPropagation();
            });

function submitdata()
{
//alert('oye');
var sender_id = '<?php echo $sender_id; ?>';
var receiver_id = '<?php echo $reciver_id; ?>'; 
var msg = document.getElementById("msg_val").value;

if(msg =='')
{
document.getElementById("msg_val").focus();

}
else
{
//alert(msg);
//alert(sender_id);
//alert(receiver_id);

$.ajax({ url:'<?php echo base_url();?>/users/chat_message',
	type:'POST',
	data: {sid:sender_id,rid:receiver_id, message:msg},
	success: function(data)
	{
    	//alert(data);
    	document.getElementById("msg_val").value='';
        if(data)
        {
               //document.getElementById("msg_val").value='';
               $('#msg_val').val('');
               
        	$("#chatmsg").html(data);

                 var objDiv = $(".panel-body");
            	 var h = objDiv.get(0).scrollHeight;
            	 objDiv.animate({scrollTop: h});
         }      
	//location.reload();
	}
      });


}

}

</script>


</body>











<!-- Mirrored from pvradmin.palanivelayudam.net/pvradmin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 Dec 2017 10:02:58 GMT -->
</html>