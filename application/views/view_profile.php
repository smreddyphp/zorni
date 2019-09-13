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
                                    <td class="field"><b>Clinic Manager Name :</b></b></td>
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
                                    <td class="field"><b>Clinic Working Hours :</b></td>
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
                                    <td class="field"><b>Age :</b></td>
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
                                    <td class="field"><b>Aboout :</b></td>
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
                                    <td class="field"><b>Email :</b></td>
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
	                            	  <td class="field"><b>Mobile :</b></td>
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
                                    <td class="field"><b>Location :</b></td>
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
                                    <td class="field"><b>Doctor Speciality :</b></td>
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
                                    <td class="field"><b>Professional License :</b></td>
                                    <td><img src="<?php echo base_url(); ?>images/<?= $user_data->professional_license ?>" class="img-rounded" alt="Cinque Terre"></td>
                                </tr>
                                <?php
                                }
                                ?>
                                 <?php 
                                if($user_data->id_card)
                                {
                                ?>
                                <tr>
                                    <td class="field"><b>Professional License :</b></td>
                                    <td><img src="<?php echo base_url(); ?>idcards/<?= $user_data->id_card ?>" class="img-rounded" alt="Cinque Terre"></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php 
                                if($user_data->clinic_number)
                                {
                                ?>
                                <tr>
                                    <td class="field"><b>Clinic Number:</b></td>
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
                                    <td class="field"><b>Provided Services :</b></td>
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
                                    <td class="field"><b>Accepted Insurances :</b></td>
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
                                    <td class="field"><b>Hospital Name :</b></td>
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
                                    <td class="field"><b>Dentals :</b></td>
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
                                    <td class="field"><b>Date Of Creation :</b></td>
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
                                    <td class="field"><b>Date Of Modified :</b></td>
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
                                    <td class="field"><b>Last Signed Out Time :</b></td>
                                    <td><?= $user_data->dols ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>                                
                                <tr class="highlight">
                                <td class="field"><b>Status :</b></td>
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
            <div class="row m-t-12">
                <div class="col-md-5 control-label double-line">Header Styling</div>
                <div class="col-md-7">
                    <select name="header-styling" class="form-control input-sm">
                        <option value="1">default</option>
                        <option value="2">inverse</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-12">
                <div class="col-md-5 control-label">Header</div>
                <div class="col-md-7">
                    <select name="header-fixed" class="form-control input-sm">
                        <option value="1">fixed</option>
                        <option value="2">default</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-12">
                <div class="col-md-5 control-label double-line">Sidebar Styling</div>
                <div class="col-md-7">
                    <select name="sidebar-styling" class="form-control input-sm">
                        <option value="1">default</option>
                        <option value="2">grid</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-12">
                
                <div class="col-md-12">
                    <select name="sidebar-fixed" class="form-control input-sm">
                        <option value="1">fixed</option>
                        <option value="2">default</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-12">
                <div class="col-md-5 control-label double-line">Sidebar Gradient</div>
                <div class="col-md-7">
                    <select name="content-gradient" class="form-control input-sm">
                        <option value="1">disabled</option>
                        <option value="2">enabled</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-12">
                <div class="col-md-5 control-label double-line">Content Styling</div>
                <div class="col-md-7">
                    <select name="content-styling" class="form-control input-sm">
                        <option value="1">default</option>
                        <option value="2">black</option>
                    </select>
                </div>
            </div>
            <div class="row m-t-12">
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

<!-- Mirrored from pvradmin.palanivelayudam.net/pvradmin/extra_profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 Dec 2017 10:11:23 GMT -->
</html>