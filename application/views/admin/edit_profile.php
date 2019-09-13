        <?php 
            if($this->session->flashdata('msg'))
            {
                ?>
                    <div class="alert alert-success">
                      <strong><?php echo $this->session->flashdata('msg'); ?></strong>
                    </div>
                <?php
            }
            ?> 
        
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-8">                
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="#nav-pills-tab-1" data-toggle="tab">
                            <span class="visible-xs">Edit Profile</span>
                            <span class="hidden-xs">Edit Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-2" data-toggle="tab">
                            <span class="visible-xs">Change Password</span>
                            <span class="hidden-xs">Change Password</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-3" data-toggle="tab">
                            <span class="visible-xs">View Profile</span>
                            <span class="hidden-xs">View Profile</span>
                        </a>
                    </li>
                    <!--<li>
                        <a href="#nav-pills-tab-4" data-toggle="tab">
                            <span class="visible-xs">Pills 4</span>
                            <span class="hidden-xs">Pills Tab 4</span>
                        </a>
                    </li>-->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-pills-tab-1">
                        <div class="panel panel-inverse" data-sortable-id="form-validation-1">                   
                    <div class="panel-body panel-form">
                        <form class="form-horizontal form-bordered" action="<?php echo base_url('admin/update_profile');?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">User Name * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="username" value="<?= $admin_details->username ?>" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="email">Email * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="email" value="<?= $admin_details->email ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Mobile:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="mobile" maxlength="10" value="<?= $admin_details->mobile ?>" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Location:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="location" value="<?= $admin_details->location ?>" required="required" />
                                    <input class="form-control" type="hidden" name="image" value="<?= $admin_details->image ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Image:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="file" name="image" />
                                </div>
                            </div>                     
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-2">
                        <div class="row">            
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-3">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                               data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                               data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                               data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                               data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Change Password</h4>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url(); ?>users/change_password" method="POST">
                            <fieldset>                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Current Password</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="current password" required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">New Password</label>
                                    <input type="password" class="form-control" name="newpassword"
                                           placeholder="New Password" required="required"/>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"/> Check me out
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary m-r-5">Update Password</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-3">
                       
                       
                       <div class="profile-container">            
            <div class="profile-section">               
                <div class="profile-left">                   
                    <div class="profile-image">
                        <img src="<?php echo base_url(); ?>images/<?= $user_data->image ?>"/>
                        <i class="fa fa-user hide"></i>
                    </div>                                                
                </div>             
                <div class="profile-right">
                    <!-- begin profile-info -->
                    <div class="profile-info">
                        <!-- begin table -->
                        <div class="table-responsive">
                            <table class="table table-profile">
                                <thead>
                                <tr>
                                <th></th>                                   
                                    <?php 
                                    if($user_data->username)
                                    {
                                    ?>
                                    <th>
                                        <h4><?= $user_data->username ?></h4>
                                    </th>
                                    <?php
                                    }
                                    
                                    if($user_data->clinic_name )
                                    {
                                    ?>
                                    <th>
                                        <h4><?= $user_data->clinic_name ?>
                                        </h4>
                                    </th>
                                    <?php
                                    }
                                    ?>                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if($user_data->clinic_manager_name)
                                {
                                ?>
                                <tr class="highlight">
                                    <td class="field">Clinic Manager Name</td>
                                    <td><?= $user_data->clinic_manager_name?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                
                                if($user_data->working_hours)
                                {
                                ?>
                                <tr class="highlight">
                                    <td class="field">Clinic Working Hours</td>
                                    <td><?= $user_data->working_hours ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <?php 
                                if($user_data->age)
                                {
                                ?>
                                <tr class="highlight">
                                    <td class="field">Age</td>
                                    <td><?= $user_data->age ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                 <?php 
                                if($user_data->about_dr)
                                {
                                ?>
                                <tr class="highlight">
                                    <td class="field">Aboout</td>
                                    <td><?= $user_data->about_dr ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <?php 
                                if($user_data->email)
                                {
                                ?>
                                <tr class="highlight">
                                    <td class="field">Email</td>
                                    <td><?= $user_data->email ?></td>
                                </tr>
                                <?php
                                }
                                ?>                                
                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>
                                <?php 
                                if($user_data->mobile)
                                {
	                         ?>
	                        	<tr>
	                            	  <td class="field">Mobile</td>
	                            		<td><i class="fa fa-mobile fa-lg m-r-5"></i><?= $user_data->mobile ?>
	                               </td>
	                        	</tr>
                                	
                                <?php
                                }
                                ?>
                                <?php 
                                if($user_data->location)
                                {
                                ?>
                                <tr>
                                    <td class="field">Location</td>
                                    <td><?= $user_data->location ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php 
                                if($user_data->doctor_speciality)
                                {
                                ?>
                                   <tr>
                                    <td class="field">Doctor Speciality</td>
                                    <td><?= $this->clinics_model->get_service_name_by_id($user_data->doctor_speciality)->service_name;  ?></td>
                                  </tr>
                                <?php
                                }
                                ?>
 
                                <?php 
                                if($user_data->professional_license)
                                {
                                ?>
                                <tr>
                                    <td class="field">Professional License</td>
                                    <td><img src="<?php echo base_url(); ?>images/<?= $user_data->professional_license ?>" class="img-rounded" alt="Cinque Terre"></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php 
                                if($user_data->clinic_number)
                                {
                                ?>
                                <tr>
                                    <td class="field">Clinic Number</td>
                                    <td><?= $user_data->clinic_number ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($user_data->provided_services)
                                {
                                ?>
                                <tr>
                                    <td class="field">Provided Services</td>
                                    <td><?php 
                                    $results = $this->clinics_model->get_provided_services_names($user_data->provided_services);
                                    //print_r($results);
                                    foreach($results as $result)
                                    {
                                    	echo $result->service_name."<br/>";
                                    }
                                     ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($user_data->accepted_insurance)
                                {
                                ?>
                                <tr>
                                    <td class="field">Accepted Insurances</td>
                                    <td><?php 
                                    $results = $this->clinics_model->get_accepted_insurance_names($user_data->accepted_insurance);
                                    foreach($results as $result)
                                    {
                                    	echo $result->insurance_name."<br/>";
                                    }
                                     ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($user_data->hospital_name)
                                {
                                ?>
                                <tr>
                                    <td class="field">Hospital Name</td>
                                    <td><?= $user_data->hospital_name ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($user_data->dentals)
                                {
                                ?>
                                <tr>
                                    <td class="field">Dentals</td>
                                    <td><?= $user_data->dentals ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($user_data->doc)
                                {
                                ?>
                                <tr>
                                    <td class="field">Date Of Creation</td>
                                    <td><?= $user_data->doc ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if($user_data->dom)
                                {
                                ?>
                                <tr>
                                    <td class="field">Date Of Modified</td>
                                    <td><?= $user_data->dom ?></td>
                                </tr>
                                <?php
                                }
                                ?> 
                                <?php
                                if($user_data->dols)
                                {
                                ?>
                                <tr>
                                    <td class="field">Last Signed Out Time</td>
                                    <td><?= $user_data->dols ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>                                
                                <tr class="highlight">
                                <td class="field">Status</td>
                                <td>
                                <?php
                                if($user_data->status == 0)
                                {
	                          ?><button type="button" class="btn btn-primary">Pending</button><?php
	                        }
	                        else if($user_data->status == 1)
	                        {
	                          ?><button type="button" class="btn btn-info">Active</button><?php
	                        }
	                        else if($user_data->status == 2)
	                        {
	                          ?><button type="button" class="btn btn-success">Deactivated</button><?php
	                        }
	                        else if($user_data->status == 3)
	                        {
	                          ?><button type="button" class="btn btn-warning">Rejected</button><?php
	                        }
                                ?>
                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <!-- end table -->
                    </div>
                    <!-- end profile-info -->
                </div>
                <!-- end profile-right -->
            </div>
            <!-- end profile-section -->           
                        <!-- end scrollbar -->
                    </div>         
                        <!-- end scrollbar -->
                    </div>
                    <!-- end col-4 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end profile-section -->
        </div>
        <!-- end profile-container -->
                       
                       
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-4">
                        <h3 class="m-t-10">Nav Pills Tab 4</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing
                            porttitor,
                            est diam sagittis orci, a ornare nisi quam elementum tortor.
                            Proin interdum ante porta est convallis dapibus dictum in nibh.
                            Aenean quis massa congue metus mollis fermentum eget et tellus.
                            Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien,
                            nec eleifend orci eros id lectus.
                        </p>
                    </div>
                </div>
            </div>
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
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function () {
        App.init();
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
</body>

<!-- Mirrored from pvradmin.palanivelayudam.net/pvradmin/ui_tabs_accordions.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 Dec 2017 10:04:07 GMT -->
</html>