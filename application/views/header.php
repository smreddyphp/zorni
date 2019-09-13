<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Zorni | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/theme/default.css" rel="stylesheet" id="theme"/>
    <link href="<?php echo base_url(); ?>assets/css/essential.css" rel="stylesheet"/>
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/morris/morris.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/AutoFill/css/autoFill.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/ColReorder/css/colReorder.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/KeyTable/css/keyTable.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/RowReorder/css/rowReorder.bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet"/>
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<!-- begin #page-loader
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
end #page-loader -->
<?php 
$user_data = $this->users_model->view_profile($this->session->userdata('user_id'));
?>

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
            <br/>
                <img src="<?php echo base_url(); ?>assets/app_logo.png" height="42" width="42" alt="logo"> Zorni 
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <br/>
            <ul class="nav navbar-nav navbar-right hidden-xs">                       
                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url(); ?>images/<?= $user_data->image ?>" height="42" width="42"" alt=""/>
                        <span class="hidden-xs">
                        <?php 
                        if(!empty($user_data->clinic_name))
                        {
                        	echo $user_data->clinic_name;
                        }
                        else
                        {
                        	echo  $user_data->username;
                        }
                        
                         ?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li><a href="<?php echo base_url(); ?>users/user_view_profile">View Profile</a></li>
                        <?php if($this->session->userdata('role') == "admin")
                        {
                        ?>                        
                        <li><a href="<?php echo base_url(); ?>admin/edit_profile">Settings</a></li>
                        <?php 
                        }
                        ?>
                        <?php if($this->session->userdata('role') == "free_dental")
                        {
                        ?>                        
                        <li><a href="<?php echo base_url(); ?>free_dentals/edit_profile">Settings</a></li>
                        <?php 
                        }
                        ?>
                        <?php if($this->session->userdata('role') == "doctor")
                        {
                        ?>                        
                        <li><a href="<?php echo base_url(); ?>doctors/edit_profile">Settings</a></li>
                        <?php 
                        }
                        ?>
                        <?php if($this->session->userdata('role') == "clinic")
                        {
                        ?>                        
                        <li><a href="<?php echo base_url(); ?>clinics/edit_profile">Settings</a></li>
                        <?php 
                        }
                        ?>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>users/logout">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div id="sidebar" class="sidebar">
        <div data-scrollbar="true" data-height="100%">
            <ul class="nav">
                <li class="nav-profile">
                    <div class="image">
                        <a href="javascript:;"><img src="<?php echo base_url(); ?>images/<?= $user_data->image ?>" height="42" width="42"" alt=""/></a>
                    </div>
                    <div class="info">
                       <?php 
                        if(!empty($user_data->clinic_name))
                        {
                        	echo $user_data->clinic_name;
                        }
                        else
                        {
                        	echo  $user_data->username;
                        }
                        
                         ?>
                        <small><?= $user_data->role ?></small>
                    </div>
                </li>
            </ul>            
            <ul class="nav">
                <!--<li class="nav-header">Navigation</li>-->
                
                <?php if($this->session->userdata('role') == 'clinic')
                {
                ?>
                <li class="has-sub active">
                    <a href="<?php echo base_url(); ?>clinics/dashboard">
                        <i class="fa fa-laptop"></i>
                        <span>Dashboard</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-user-md"></i>
                        <span>Doctors Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>clinics/doctors">Doctors</a></li>                        
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-newspaper-o"></i>
                        <span>Tweets</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>users/post_tweet">Post tweet</a></li>
                        <li><a href="<?php echo base_url(); ?>users/tweets">Manage Tweets</a></li>                        
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-hospital-o"></i>
                        <span>Appointments (<?php echo count($this->clinics_model->get_appointment_unread($this->session->userdata('user_id'),0));?>)</span>
                    </a>
                  <ul class="sub-menu">
                    <li><a href="<?php echo base_url(); ?>users/get_pending_appointments">Pending Appointments (<?php echo count($this->clinics_model->get_appointment_unread($this->session->userdata('user_id'),0));?>)</a></li>
                    <li><a href="<?php echo base_url(); ?>users/get_confirmed_appointments">Confirmed Appointments</a></li>
                    <li><a href="<?php echo base_url(); ?>users/get_completed_appointments">Completed Appointments</a></li>
                    <li><a href="<?php echo base_url(); ?>users/get_cancelled_appointments">Cancelled Appointments</a></li>
                  </ul>
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>users/followers">
                        <i class="fa fa-heart-o"></i>
                        <span>Followers</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>users/ratings">
                        <i class="glyphicon glyphicon-star-empty"></i>
                        <span>Ratings</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>users/offers">
                        <i class="fa fa-tags"></i>
                        <span>Manage Offers</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>clinics/edit_profile">
                        <i class="fa fa-gear"></i>
                        <span>Settings</span>
                    </a>                    
                </li> 
                <?php 
                }
                ?>
                <?php if($this->session->userdata('role') == 'free_dental')
                {
                ?>
                <li class="has-sub active">
                    <a href="<?php echo base_url(); ?>free_dentals/dashboard">
                        <i class="fa fa-laptop"></i>
                        <span>Dashboard</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-hospital-o"></i>
                        <span>Appointments</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>users/get_pending_appointments">Pending Appointments</a></li>
                        <li><a href="<?php echo base_url(); ?>users/get_confirmed_appointments">Confirmed Appointments</a></li>
                        <li><a href="<?php echo base_url(); ?>users/get_cancelled_appointments">Cancelled Appointments</a></li>                        
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-newspaper-o"></i>
                        <span>Tweets</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>users/post_tweet">Post tweet</a></li>
                        <li><a href="<?php echo base_url(); ?>users/tweets">Manage Tweets</a></li>                        
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>users/followers">
                        <i class="fa fa-heart-o"></i>
                        <span>Followers</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>users/ratings">
                        <i class="glyphicon glyphicon-star-empty"></i>
                        <span>Ratings</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>users/offers">
                        <i class="fa fa-tags"></i>
                        <span>Manage Offers</span>
                    </a>                    
                </li>
                <li class="has-sub">
                    <a href="<?php echo base_url(); ?>free_dentals/edit_profile">
                        <i class="fa fa-gear"></i>
                        <span>Settings</span>
                    </a>                    
                </li>
                <?php 
                }
                ?>
                <?php if($this->session->userdata('role') == 'admin')
                {
                ?>
                <li class="has-sub active">
                    <a href="<?php echo base_url(); ?>admin/dashboard">
                        <i class="fa fa-laptop"></i>
                        <span>Dashboard</span>
                    </a>                    
                </li>               
             	 <li><a href="<?php echo base_url(); ?>admin/get_provided_services"><i class="glyphicon glyphicon-user"></i> <span>Provided Services</span></a></li>
             	 <li><a href="<?php echo base_url(); ?>admin/insurances"><i class="glyphicon glyphicon-tint"></i> <span>Accepted Insurances</span></a></li>              
		<li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-plus-square"></i>
                        <span>Clinics Management</span>
                    </a>
                    <ul class="sub-menu">                        
                        <li><a href="<?php echo base_url(); ?>admin/get_pending_clinics">Approval Clinics</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/get_active_clinics">All Clinics</a></li>
                        <!--<li class="has-sub">
                            <a href="javascript:;"><b class="caret pull-right"></b> Managed Tables</a>
                            <ul class="sub-menu">
                                <li><a href="table_manage.html">Default</a></li>
                                <li><a href="table_manage_autofill.html">Autofill</a></li>                                
                            </ul>
                        </li>-->
                    </ul>
                </li>
		<li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-user-md"></i>
                        <span>Doctors Management</span>
                    </a>
                    <ul class="sub-menu">
                    	<li><a href="<?php echo base_url(); ?>admin/get_pending_doctors">Approval Doctors</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/get_active_doctors">All Doctors</a></li>                        
                        <!--<li class="has-sub">
                            <a href="javascript:;"><b class="caret pull-right"></b>Managed Tables</a>
                            <ul class="sub-menu">
                                <li><a href="table_manage.html">Default</a></li>
                                <li><a href="table_manage_autofill.html">Autofill</a></li>                                
                            </ul>
                        </li>-->
                    </ul>
                </li>
		<li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-medkit"></i>
                        <span>Free Treatment Management</span>
                    </a>
                    <ul class="sub-menu">
                    	<li><a href="<?php echo base_url(); ?>admin/pending_free_dentals">Approval Free Dentals</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/active_free_dentals">All Free Dentals</a></li>                       
                       
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-users"></i>
                        <span>Users Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>admin/get_active_users">Active Users</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/get_deactive_users">Deactivated Users</a></li>
                        <!--<li class="has-sub">
                            <a href="javascript:;"><b class="caret pull-right"></b> Managed Tables</a>
                            <ul class="sub-menu">
                                <li><a href="table_manage.html">Default</a></li>
                                <li><a href="table_manage_autofill.html">Autofill</a></li>                                
                            </ul>
                        </li>-->
                    </ul>
                </li>
                 <li><a href="<?php echo base_url(); ?>admin/packages"><i class="fa fa-th"></i> <span>Manage Packages</span></a></li>
                 <li><a href="<?php echo base_url(); ?>admin/send_push_notification"><i class="fa fa-th"></i> <span>Send Push Notifications</span></a></li>
                 <li class="has-sub">
                    <a href="<?php echo base_url(); ?>admin/edit_profile">
                        <i class="fa fa-gear"></i>
                        <span>Settings</span>
                    </a>                    
                </li> 
                <li><a href="<?php echo base_url(); ?>admin/chat"><i class="glyphicon glyphicon-comment"></i> <span>Chat History</span></a></li>
                <?php 
                }
                ?>
                <!-- begin sidebar minify button -->
                <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar minify button -->
            </ul>
            <!-- end sidebar nav -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->

    <!-- begin #content -->
    <div id="content" class="content">
     