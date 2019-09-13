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
        <br />
    <button class="btn btn-success" onclick="add_doctor()"><i class="glyphicon glyphicon-plus"></i> Add Doctor</button>
    <br />
        <br />
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
                        <h4 class="panel-title">Active Doctors</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="50px" nowrap>ID</th>
                                <th width="100px" nowrap>Doctor Name</th>
                                <th width="100px" nowrap>Mobile</th>
                                <th width="100px" nowrap>Email</th>
                                <th width="100px" nowrap>Service</th>
                                <th width="100px" nowrap>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($doctors as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->id ?></td>
                                        <td><?= $row->name ?></td>
                                        <td><?= $row->mobile ?></td>
                                         <td><?= $row->email ?></td>

                                        <td><?php 
                                         $a = $this->clinics_model->get_service_name_by_id($row->service);
                                         echo $a->service_name;
                                         ?></td>
                                         <td>
                                       <?php if($row->status == 1) {  ?>
                                        <button type="submit" value = "<?= $row->status ?>" class="btn btn-success btn-sm br2 fs12" name="status" onclick="statusCheck(this.value,'<?= $row->id ?>')">Activated</button>
                                       <?php } else { ?>
                                        <button type="submit" value = "<?= $row->status ?>" class="btn btn-info btn-sm br2 fs12" name="status" onclick="statusCheck(this.value,'<?= $row->id ?>')">Deactivated</button>
                                       <?php } ?>
                                      </td>
                                        <td><button class="btn btn-primary"  onclick="edit_doctor(<?= $row->id ?>)"><i class="glyphicon glyphicon-pencil"></i></button> <button class="btn btn-danger"  onclick="delete_doctor(<?= $row->id ?>)"><i class="glyphicon glyphicon-trash"></i></button></td>
                                    </tr>
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

 function statusCheck(status_val,id)
 {
    //alert(status_val);alert(user_id);
if(confirm("are you sure you want to activate or deactivate this Doctor ?"))
  {
   $.ajax({
    url:'<?php echo base_url('clinics/change_doctor_status'); ?>',
    type:'POST',
    data: {id:id,status:status_val},
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

  <script type="text/javascript">
  $(document).ready( function () {
      $('#table_id').DataTable();
  } );
    var save_method; //for save method string
    var table;
 
 
    function add_doctor()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_doctor(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
// alert(id);
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo base_url('clinics/ajax_edit/'); ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
        	//alert(data);
        	//return false;
 	    $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);
            $('[name="about"]').val(data.about);
             $('[name="about_ar"]').val(data.about_ar);
            $('[name="mobile"]').val(data.mobile);
            $('[name="email"]').val(data.email);
            $('[name="service"]').val(data.service);

 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Doctor'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }
 
 
 
    function save()
    {
      var url;
      if(save_method == 'add')
      {
          url = "<?php echo base_url('clinics/doctor_add')?>";
      }
      else
      {
        url = "<?php echo base_url('clinics/doctor_update')?>";
      }
 	
      var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
      var name = $('#name1').val();
      var about = $('#about1').val();
      var about_ar = $('#about_ar1').val();
      var mobile = $('#mobile1').val();
      var email = $('#email1').val();
      var service = $('#service1').val();
      
      if(name.trim() == ''){
      	alert('Please Enter Doctor Name');
      	$('#name1').focus();
      	return false;      
      }else if(about .trim() == ''){
      alert('Enter about Doctor');
      $('#about1').focus();
      return false;
      }else if(about_ar .trim() == ''){
      alert('Enter about Doctor In Arabic');
      $('#about_ar1').focus();
      return false;       
      }else if(mobile.trim() ==''){
      	alert('Please Enter Mobile Number');
      	$('#mobile1').focus();
      	return false;
      }else if(email.trim()==''){
      	alert('Please Enter Email Id');
      	$('#email1').focus();
      	return false;
      }else if(email.trim() != '' && !reg.test(email)){
        alert('Please enter valid email.');
        $('#email1').focus();
        return false;
      }else if(service == ''){
      alert('Please Select Service');
      	$('#service1').focus();
      	return false;
      }else{
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
              location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
       }
    }
 
    function delete_doctor(id)
    {
      if(confirm('Are You Sure You Want to Delete this Doctor ?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo base_url('clinics/doctor_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
      }
    }
 
  </script>

<!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Doctor</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Doctor Name</label>
              <div class="col-md-9">
                <input name="name" id="name1" placeholder="Name" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">About</label>
              <div class="col-md-9">
                <textarea name="about" id="about1" placeholder="About Doctor" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">About (Arabic)</label>
              <div class="col-md-9">
                <textarea name="about_ar" id="about_ar1" placeholder="About Doctor In Arabic" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Mobile</label>
              <div class="col-md-9">
                <input name="mobile" id="mobile1" placeholder="mobile1" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-9">
		 <input name="email" id="email1" placeholder="Email" class="form-control" type="text"> 
              </div>
            </div>
		<div class="form-group">
			<label class="control-label col-md-3">Select Service</label>
			<div class="col-md-9">
			<select class="form-control" id="service1" name = "service" value="service">
			   <option value="">Select Service</option>				
			<?php
			foreach($services as $service)
			{ ?>
			<option value="<?= $service->id ?>"><?= $service->service_name ?></option>
			<?php			
			}
			?>
			</select>	
			</div>
		</div> 
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>

<!-- Mirrored from pvradmin.palanivelayudam.net/pvradmin/table_manage_combine.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 Dec 2017 10:09:56 GMT -->
</html>