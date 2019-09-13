        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-12">                
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="#nav-pills-tab-1" data-toggle="tab">
                            <span class="visible-xs">Clinic Profile</span>
                            <span class="hidden-xs">Clinic Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-2" data-toggle="tab">
                            <span class="visible-xs">Appointments</span>
                            <span class="hidden-xs">Appointments</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-3" data-toggle="tab">
                            <span class="visible-xs">Clinic Doctors</span>
                            <span class="hidden-xs">Clinic Doctors</span>
                        </a>
                    </li>                    
                    <li>
                        <a href="#nav-pills-tab-4" data-toggle="tab">
                            <span class="visible-xs">Ratings</span>
                            <span class="hidden-xs">Ratings</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-5" data-toggle="tab">
                            <span class="visible-xs">Followers</span>
                            <span class="hidden-xs">Followers</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-6" data-toggle="tab">
                            <span class="visible-xs">Tweets</span>
                            <span class="hidden-xs">Tweets</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-7" data-toggle="tab">
                            <span class="visible-xs">Offers</span>
                            <span class="hidden-xs">Offers</span>
                        </a>
                    </li>                     
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-pills-tab-1">
                        <div class="panel panel-inverse" data-sortable-id="form-validation-1">
						
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
                                    <td><?= $user_data->doctor_speciality ?></td>
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
                                    <td><img src="<?php echo base_url(); ?>images/<?= $user_data->professional_license ?>" class="img-rounded" alt="Cinque Terre" style="height:50px;width:50px"></td>
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
                                if($user_data->status == 1)
                                {
	                          ?><button type="button" class="btn btn-primary">Active</button><?php
	                        }
	                        else
	                        {
	                          ?><button type="button" class="btn btn-info">Pending</button><?php
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
                    <!-- end col-4 -->
                   
                </div>
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-2">
                        <div class="row">
            <!-- begin col-2 -->
            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-12">
                <div class="panel panel-inverse">
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
                        <h4 class="panel-title">Appointments</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="100px" nowrap>Name</th>
                                <th width="100px" nowrap>Mobile</th>
                                <th width="100px" nowrap>Date</th>
                                <th width="100px" nowrap>Time</th>
                                <th width="100px" nowrap>Service<th>                               
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                               <?php
                                foreach ($appointments as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->name ?></td>                                        
                                        <td><?= $row->mobile ?></td>
                                        <td><?= $row->date ?></td>
                                        <td><?= $row->time ?></td>
                                        <td>
                                        <?php echo $this->clinics_model->get_service_name_by_id($row->service)->service_name; ?>
                                        <td>
                                        <?php if($row->status == 0)
                                        {
                                        ?>                                     
                                    <button class="btn btn-success btn-sm br2 fs12" name="status">Pending</button>
                                       <?php }
                                       elseif($row->status == 1)
                                       {
                                       ?>                                       
                                         <button class="btn btn-info btn-sm br2 fs12" name="status">Confirmed</button>
                                  <?php }
                                  else if($row->status == 2){
                                   ?>
                                   <button class="btn btn-primary btn-sm br2 fs12" name="status">Cancelled</button>
                                     <?php }
                                        else if($row->status == 3)
                                       {
                                       ?>                                       
                                         <button class="btn btn-info btn-sm br2 fs12" name="status">Waiting For USer Conformation</button>
                                  <?php
                                        }
                                        else if($row->status == 4)
                                       {
                                       ?>                                       
                                         <button class="btn btn-info btn-sm br2 fs12" name="status">Completed</button>
                                  <?php
                                        }
                                        ?>
                                       </td>
                                      <td><a href="<?php echo base_url(); ?>users/user_view_profile/<?= $row->user_id ?>"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> View</button>         
                                      <?php 
                                    }
                                    ?>                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col-10 -->
        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-3">
                    
                    
                        
                        
                        
                        <div class="row">
            <!-- begin col-2 -->
            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-12">
                <div class="panel panel-inverse">
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
                        <h4 class="panel-title">Clinic Doctors</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="200px" nowrap>Doctor Name</th>
                                <th width="300px" nowrap>About</th>
                                <th width="100px" nowrap>Mobile</th>
                                <th width="100px" nowrap>Email</th>
                                <th width="100px" nowrap>Service</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($doctors as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->name ?></td>
                                        <td><?= $row->about ?></td>
                                        <td><?= $row->mobile ?></td>
                                        <td><?= $row->email ?></td>
                                        <td>
                                        <?php echo $this->clinics_model->get_service_name_by_id($row->service)->service_name ;?>
                                        </td>
                                        <td>
                                        <?php
	                                if($user_data->status == 1)
	                                {
		                          ?><button type="button" class="btn btn-primary">Active</button><?php
		                        }
		                        else
		                        {
		                          ?><button type="button" class="btn btn-info">Deactive</button><?php
		                        }
	                                ?>
                                	</td>         
                              <?php                                   
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col-10 -->
        </div>
        </div>
                        
                        

                        
                        
                        
                        
                        
                        
                        
                        
                                        
                    <div class="tab-pane fade" id="nav-pills-tab-4">
                        
                        
                        
                        <div class="row">
            <!-- begin col-2 -->
            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-12">
                <div class="panel panel-inverse">
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
                        <h4 class="panel-title">Ratings</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="100px" nowrap>User Name</th>
                                <th width="200px" nowrap>Email</th>
                                <th width="200px" nowrap>Mobile</th>
                                <th width="200px" nowrap>Ratings</th>
                                <th width="200px" nowrap>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ratings as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->username ?></td>
                                        <td><?= $row->email ?></td>
                                        <td><?= $row->mobile ?></td>
                                        <td><?= $row->ratings ?></td>
                                        <td><?= $row->date ?></td>
                                        <td><a href="<?php echo base_url(); ?>users/user_view_profile/<?= $row->user_id ?>"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> View</button>         
                              <?php                                   
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            <!-- end col-10 -->
        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-5">                        
                        
                        
                        <div class="row">
            <!-- begin col-2 -->
            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-12">
                <div class="panel panel-inverse">
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
                        <h4 class="panel-title">Followers</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="100px" nowrap>User Name</th>
                                <th width="200px" nowrap>Email</th>
                                <th width="200px" nowrap>Mobile</th>
                                <th width="200px" nowrap>Gender</th>
                                <th width="200px" nowrap>Age</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($followers as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->username ?></td>
                                        <td><?= $row->email ?></td>
                                        <td><?= $row->mobile ?></td>
                                        <td><?= $row->gender ?></td>
                                        <td><?= $row->age ?></td>
                                        <td><a href="<?php echo base_url(); ?>users/user_view_profile/<?= $row->user_id ?>"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> View</button>         
                              <?php                                   
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col-10 -->
        </div>
        </div>
        <div class="tab-pane fade" id="nav-pills-tab-6"> 
        
        
        
        <div class="row">
            <!-- begin col-2 -->
            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-12">
                <div class="panel panel-inverse">
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
                        <h4 class="panel-title">Manage Tweets</h4>
                    </div>
                    <div class="panel-body">
                        <?php 
                        	foreach($tweets as $tweet)
                        	{
                        	?>
                        		    <div class="panel panel-primary">
					      <div class="panel-heading"><?= $tweet->tweet_title ?></div>
					      <div class="panel-body"><?= $tweet->tweet ?></div>
					      <div class="panel-footer"><b>Posted On : </b><?= $tweet->date ?><!--<a style = "margin-left: 800px;background: #73800e !important;border-color: #0f5d24 !important;
" href = "<?php echo base_url();?>/users/post_tweet/<?= $tweet->id ?>" class = "btn btn-sm btn-success">Edit Tweet</a> <a style = "background: #73800e !important;border-color: #0f5d24 !important;
" href = "<?php echo base_url();?>/users/delete_tweet/<?= $tweet->id ?>" class = "btn btn-sm btn-success">Delete Tweet</a>--></div>
					    </div>
                        	<?php
                        	}
                        ?>
                    </div>
                </div>
            </div>
            <!-- end col-10 -->
        </div>
        
        
        
        
        
        </div>
        <div class="tab-pane fade" id="nav-pills-tab-7"> 
      
      
      
      
      <div class="row">
            <!-- begin col-2 -->
            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-12">
                <div class="panel panel-inverse">
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
                        <h4 class="panel-title">Offers</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="100px" nowrap>Sl.No</th>
                                <th width="200px" nowrap>Promo Code</th>
                                <th width="100px" nowrap>Disscount</th>
                                <th width="200px" nowrap>Description</th>
                                <th width="200px" nowrap>Expire Date</th>
                                <!--<th width="200px" nowrap>Status</th>-->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach ($offers as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                    	<td><?=$i++ ?></td>
                                        <td><?= $row->promo_code ?></td>
                                        <td><?= $row->percentage ?></td>
                                        <td><?= $row->description ?></td>
                                        <td><?= $row->expire_date ?></td>
                                        <!--<td>/*<?php 
                                              if(date("Y-m-d") <= $row->expire_date)
                                              {
                                                ?><button type="button" class="btn btn-primary">Available Now</button><?php
                                              }
                                              else
                                              {
                                               ?><button type="button" class="btn btn-warning">Expired</button><?php
                                             }
                                           $row->expire_date ?>*/</td>-->
                                        <td><?php
                                if($row->status == 1)
                                {
	                          ?><button type="button" class="btn btn-primary">Active</button><?php
	                        }
	                        else
	                        {
	                          ?><button type="button" class="btn btn-info">Deactivated</button><?php
	                        }
                                ?>
                                </td>                                                
                              <?php                                   
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col-10 -->
        </div>
      
      
      
      
       
        
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
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/AutoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/KeyTable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/RowReorder/js/dataTables.rowReorder.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/extensions/Select/js/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table_manage_combine_demo.js"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function () {
        App.init();
        TableManageCombine.init();
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

 function statusCheck(status_val,user_id)
 {
    //alert(status_val);alert(user_id);
if(confirm("are you sure you want to activate or deactivate this user ?"))
  {
   $.ajax({
    url:'<?php echo base_url('admin/changeUserstatus'); ?>',
    type:'POST',
    data: {id:user_id,status:status_val},
    success: function(data)
    {
     //alert(data);
     //$("#ajax_status"+mission_id).html(data);
     location.reload();
    }
   });
  }
 } 
</script>
</body>

<!-- Mirrored from pvradmin.palanivelayudam.net/pvradmin/table_manage_combine.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 Dec 2017 10:09:56 GMT -->
</html>