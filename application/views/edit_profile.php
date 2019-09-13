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
                            <span class="visible-xs">Pills 3</span>
                            <span class="hidden-xs">Pills Tab 3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-pills-tab-4" data-toggle="tab">
                            <span class="visible-xs">Pills 4</span>
                            <span class="hidden-xs">Pills Tab 4</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-pills-tab-1">
                        <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                   
                    <div class="panel-body panel-form">
                        <form class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">User Name * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" id="fullname" name="username" value=""
                                           placeholder="Required" data-parsley-required="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="email">Email * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" id="email" name="email"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Mobile:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="url" id="website" name="mobile"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Location:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="url" id="website" name="location"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="website">Image:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="file" id="website" name="image"/>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="message">Message (20 chars min, 200
                                    max) :</label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea class="form-control" id="message" name="message" rows="4"
                                              data-parsley-range="[20,200]"
                                              placeholder="Range from 20 - 200"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="message">Digits :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" id="digits" name="digits" data-parsley-type="digits" placeholder="Digits"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="message">Mobile Number :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" id="number" name="mobile" placeholder="Mobile Number"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="message">Phone :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" id="data-phone" data-parsley-type="number"
                                           placeholder="(XXX) XXXX XXX"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="message">Image :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="file" id="data-phone"/>
                                </div>
                            </div>                           
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
                                <legend>Legend</legend>
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
                                <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
                    </div>
                    <div class="tab-pane fade" id="nav-pills-tab-3">
                        <h3 class="m-t-10">Nav Pills Tab 3</h3>
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