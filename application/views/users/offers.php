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
        <?php 
       /*$auth_level = $this->session->userdata('auth_level');
        $user_id = $this->session->userdata('user_id');
        $ofrs = $this->users_model->offers($auth_level,$user_id);
        $ofr = count($offers);
        if($ofr <= 0)
        {*/
        ?>
        <br />
    <button class="btn btn-success" onclick="add_offer()"><i class="glyphicon glyphicon-plus"></i> Add New Offer</button>
    <br />
        <?php        
        //}        
        ?>
        
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
                                <th width="200px" nowrap>Promo Code</th>
                                <th width="100px" nowrap>Percentage</th>
                                <th width="200px" nowrap>Description</th>
                                <th width="100px" nowrap>Expire Date</th>
                                <th width="100px" nowrap>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($offers as $row)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= $row->promo_code ?></td>
                                        <td><?= $row->percentage ?></td>
                                        <td><?= $row->description ?></td>
                                         <td><?= $row->expire_date ?></td>                                        
                                         <td>
                                       <?php if($row->status == 1) {  ?>
                                        <button type="submit" value = "<?= $row->status ?>" class="btn btn-success btn-sm br2 fs12" name="status" onclick="statusCheck(this.value,'<?= $row->id ?>')">Activated</button>
                                       <?php } else { ?>
                                        <button type="submit" value = "<?= $row->status ?>" class="btn btn-info btn-sm br2 fs12" name="status" onclick="statusCheck(this.value,'<?= $row->id ?>')">Deactivated</button>
                                       <?php } ?>
                                      </td>
                                        <td><button class="btn btn-primary"  onclick="edit_offer(<?= $row->id ?>)"><i class="glyphicon glyphicon-pencil"></i></button> 
                                        <button class="btn btn-danger"  onclick="delete_offer(<?= $row->id ?>)"><i class="glyphicon glyphicon-trash"></i></button></td>
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
if(confirm("Are You Sure you want to Activate or Deactivate this Offer ?"))
  {
   $.ajax({
    url:'<?php echo base_url('users/update_offer_status'); ?>',
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
 
 
    function add_offer()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }
 
    function edit_offer(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
 
// alert(id);
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo base_url('users/ajax_edit/'); ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
        	//alert(data);
        	//return false;
 	    $('[name="id"]').val(data.id);
            $('[name="promo_code"]').val(data.promo_code);
            $('[name="percentage"]').val(data.percentage);
            $('[name="description"]').val(data.description);
            $('[name="description_ar"]').val(data.description_ar);
            $('[name="expire_date"]').val(data.expire_date);                     

 
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
          url = "<?php echo base_url('users/offer_add'); ?>";
      }
      else
      {
        url = "<?php echo base_url('users/offer_update'); ?>";
      }
      
    var promo_code = $('#promo_code1').val();
    var percentage = $('#percentage1').val();
    var description = $('#description1').val();
    var description_ar = $('#description_ar1').val();
    var expire_date = $('#expire_date1').val();
    if(promo_code .trim() == '' ){
        alert('Please Enter Promo Code.');
        $('#promo_code1').focus();
        return false;
    }else if(percentage .trim() == '' ){
        alert('Please Enter Percentage.');
        $('#percentage1').focus();
        return false;
    }else if(description .trim() == ''){
        alert('Please Enter Description.');
        $('#description1').focus();
        return false;
    }else if(description_ar .trim() == '' ){
        alert('Please Enter Description In Arabic.');
        $('#description_ar1').focus();
        return false;
    }else if(expire_date == '' ){
        alert('Please Select Expire Date');
        $('#expire_date1').focus();
        return false;
    }else{
 
       // ajax adding data to database
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
 
    function delete_offer(id)
    {
      if(confirm('Are you sure delete this Offer ?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo base_url('users/offer_delete')?>/"+id,
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
        <h3 class="modal-title">Add Offer</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Promo Code</label>
              <div class="col-md-9">
                <input name="promo_code" id="promo_code1" placeholder="Promo Code" class="form-control" type="text" required = 'required'>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Percentage</label>
              <div class="col-md-9">
                <input name="percentage" id="percentage1" placeholder="Enter Percentage" class="form-control" type="text" required = 'required'>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Description</label>
              <div class="col-md-9">
                <textarea name="description" id="description1" placeholder="Description" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Description (Arabic)</label>
              <div class="col-md-9">
                <textarea name="description_ar" id="description_ar1" placeholder="Description In Arabic" class="form-control"></textarea>
              </div>
            </div>            
            <div class="form-group">
              <label class="control-label col-md-3">Expire Date</label>
              <div class="col-md-9">
		 <input name="expire_date" id="expire_date1" placeholder="Expire Date" class="form-control" type="date"> 
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