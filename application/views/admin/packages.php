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
    <button class="btn btn-success" onclick="add_package()"><i class="glyphicon glyphicon-plus"></i> Add Package</button>
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
                        <h4 class="panel-title">Packages</h4>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="200px" nowrap>Package Name</th>
                                <th width="100px" nowrap>Price</th>
                                <th width="100px" nowrap>Months</th>
                                <!--<th width="100px" nowrap>Starting Date</th>
                                <th width="100px" nowrap>Ending Date</th>-->
                                <th width="100px" nowrap>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($packages as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->package_name ?></td>
                                        <td><?= $row->price ?></td>
                                        <td><?= $row->months ?></td>
                                         <td>
                                       <?php if($row->status == 1) {  ?>
                                        <button type="submit" value = "<?= $row->status ?>" class="btn btn-success btn-sm br2 fs12" name="status" onclick="statusCheck(this.value,'<?= $row->id ?>')">Activated</button>
                                       <?php } else { ?>
                                        <button type="submit" value = "<?= $row->status ?>" class="btn btn-info btn-sm br2 fs12" name="status" onclick="statusCheck(this.value,'<?= $row->id ?>')">Deactivated</button>
                                       <?php } ?>
                                      </td>
                                        <td><button class="btn btn-primary"  onclick="edit_package(<?= $row->id ?>)"><i class="glyphicon glyphicon-pencil"></i></button> <button class="btn btn-danger"  onclick="delete_package(<?= $row->id ?>)"><i class="glyphicon glyphicon-trash"></i></button></td>
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
if(confirm("Are You Sure you want to Activate or Deactivate this Package ?"))
  {
   $.ajax({
    url:'<?php echo base_url('admin/update_package_status'); ?>',
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
 
 
    function add_package()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_package(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
// alert(id);
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo base_url('admin/package_edit/'); ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
        	//alert(data);
        	//return false;
 	    $('[name="id"]').val(data.id);
            $('[name="package_name"]').val(data.package_name);
            $('[name="package_name_ar"]').val(data.package_name_ar);
            $('[name="price"]').val(data.price);
            $('[name="months"]').val(data.months);
            //$('[name="starting_date"]').val(data.starting_date);
           // $('[name="ending_date"]').val(data.ending_date);
            $('[name="doctors"]').val(data.doctors);
            $('[name="books"]').val(data.books);
            $('[name="appointments"]').val(data.appointments);
            $('[name="free_exams"]').val(data.free_exams);
            $('[name="calls"]').val(data.calls);            

 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Package'); // Set title to Bootstrap modal title
 
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
          url = "<?php echo base_url('admin/package_add')?>";
      }
      else
      {
        url = "<?php echo base_url('admin/package_update')?>";
      }
 	
 	var package_name = $('#package_name1').val();
 	var package_name_ar = $('#package_name_ar1').val();
 	var price = $('#price1').val();
 	var months = $('#months1').val();
 //	var starting_date  = $('#starting_date1').val();
 	//var ending_date  = $('#ending_date1').val();
 	var doctors = $('#doctors1').val();
 	var books = $('#books1').val();
 	var appointments = $('#appointments1').val();
 	var free_exams = $('#free_exams1').val();
 	var calls = $('#calls1').val();
 	
 	if(package_name == '' ){
        alert('Please enter your packagename.');
        $('#package_name1').focus();
        return false;
       }else if(package_name_ar.trim()== ''){
         alert('Please Enter Package Name In Arabic');
         $('#package_name_ar1').focus();
         return false;
       }else if(price .trim() == ''){
       	alert('Please Enter Price');
         $('#price1').focus();
         return false;
       }else if(months .trim()== ''){
       	alert('Please Enter Months');
         $('#months1').focus();
         return false;
       }
      /* else if(starting_date .trim() == ''){
        alert('Please Select Starting Date');
         $('#starting_date1').focus();
         return false;
       }else if(ending_date.trim() == ''){
        alert('Please Select Ending Date');
         $('#ending_date1').focus();
         return false;        
       }*/
       else{
       // ajax adding data to datab
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
 
    function delete_package(id)
    {
      if(confirm('Are you sure delete this Package ?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo base_url('admin/delete_package')?>/"+id,
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
        <h3 class="modal-title">Add Package</h3>
      </div>
      <div class="modal-body form">
        <form action="#" name="myform" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Package Name</label>
              <div class="col-md-9">
                <input name="package_name" id="package_name1" placeholder="Package Name" class="form-control" type="text" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Package Name (Arabic)</label>
              <div class="col-md-9">                                           
                <input name="package_name_ar" id="package_name_ar1" placeholder="Package Name In Arabic" class="form-control" type="text" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Price</label>
              <div class="col-md-9">
                <input name="price" id="price1" placeholder="Enter Price" class="form-control" type="text" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Months</label>
              <div class="col-md-9">
                <input name="months" id="months1" placeholder="Validity in Months" class="form-control" type="text" required>
              </div>
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Doctors</label>
              <div class="col-md-9">
		 <input name="doctors" id="doctors1" placeholder="Doctors" class="form-control" type="text" required> 
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Books</label>
              <div class="col-md-9">
		 <input name="books" id="books1" placeholder="Books" class="form-control" type="text" required> 
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Appointments</label>
              <div class="col-md-9">
		 <input name="appointments" id="appointments1" placeholder="Appointments" class="form-control" type="text" required> 
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Free Exams</label>
              <div class="col-md-9">
		 <input name="free_exams" id="free_exams1" placeholder="Free Exams" class="form-control" type="text" required> 
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Calls</label>
              <div class="col-md-9">
		 <input name="calls" id="calls1" placeholder="Calls" class="form-control" type="text" required> 
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