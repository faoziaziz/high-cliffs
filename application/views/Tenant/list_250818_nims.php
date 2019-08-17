<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">Devices</a>
        </li>
    
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
   <h1 class="page-header">Tenant | Trumon</h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12 ui-sortable">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                   
                    </div>
                    <h4 class="panel-title">Tenant</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                    <p>
                         <?php //echo anchor('#modal-dialog','Tambah',"title='tambah-data', class='btn btn-success', data-toggle='modal'"); ?>
                          <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Tenant</button>
                    </p>
                    <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="mytable" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                                      <th>Nomor</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>PIC</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                        </thead>

                    </table>
                </div>
            </div>
            <!-- end panel --></div>
        <!-- end col-12 --></div>
    <!-- end row --></div>



<div class="modal fade" id="modal-edit" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Modal Dialog</h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtTenant"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Location</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtLocation"/>
                        </div>
                        <span class="help-block"></span>
                        
                    </div>
                    <div class="form-group">
                         <label class="col-sm-2 control-label" for="form-field-1">PIC</label>
                        <div class="col-md-4">
                            <input type="text" id="form-field-1" class="form-control" name="txtPIC"/>
                        </div>
                        <label class="col-md-2 control-label" for="form-field-1">Phone</label>
                        <div class="col-md-4">
                            <input type="text" id="form-field-1" class="form-control" name="txtPhoneNumber">
                        </div>
                        
                    </div> 
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form-field-1">Merk POS</label>
                        <div class="col-md-4">
                            <input type="text" id="form-field-1" class="form-control" name="txtPOS">
                        </div>

                        <label class="col-md-2 control-label" for="form-field-1">Merk Printer</label>
                        <div class="col-md-4">
                            <input type="text" id="form-field-1" class="form-control" name="txtPrinter">
                        </div>  
                    </div>
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="form-field-1">Cable</label>
                        <div class="col-md-4">
                            <select name="txtCable" class="form-control">
                                <option value="USB FS">USB FS</option>
                                <option value="USB HS">USB HS</option>
                                <option value="Serial">Serial</option>
                                <option value="Paralel SPP">Paralel SPP</option>
                                <option value="Paralel ECP">Paralel ECP</option>
                            </select>
                        </div>
                        <label class="col-md-2 control-label" for="form-field-1">Jenis</label>
                        <div class="col-md-4">
                            <select name="txtJenis" class="form-control">
                                <option value="Image">Image</option>
                                <option value="Text">Text</option>
                            </select>
                        </div>  
                    </div>
                     <div class="form-group">
                        <label class="col-md-2 control-label" for="form-field-1">Latitude</label>
                        <div class="col-md-4">
                            <input type="text" id="form-field-1" class="form-control" name="txtLat">
                        </div>

                        <label class="col-md-2 control-label" for="form-field-1">Longitude</label>
                        <div class="col-md-4">
                            <input type="text" id="form-field-1" class="form-control" name="txtLong">
                        </div>  
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-sm-1">
                            <button type="button" id="btnSave" name="submit" onclick="save()" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


  


!-- Modal Popup untuk Edit--> 


<!-- Modal Popup untuk delete--> 
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
      </div>
                
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
var save_method; //for save method string
        $(document).ready(function(){
            var t = $('#mytable').DataTable({
                "ajax": '<?php echo site_url('Tenant/data');?>',
                "order": [[3, 'desc']],
                "columns":[
                    {
                        "data":null,
                        "width":"50px",
                        "sClass": "text-center",
                        "orderable":false
                    },
                    {
                        "data":"Tenant",
                        "width":"400px"
                    },
                    {
                        "data": "Location",
                        "width": "120px",
                        "sClass" : "text-center"
                    },
                    { "data": "PIC"},
                   
                    {"data": "PhoneNumber"},
                     {"data":"aksi","width":"90px"},
                   
                ]
            });
            t.on('order.dt search.dt',function(){
                t.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell,i){
                    cell.innerHTML =i+1;
                });
            }).draw();





        });

        function add_person()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal-edit').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Devices'); // Set Title to Bootstrap modal title
        }



function save()
{
     
   
    var url;
 
 if(save_method == 'add') {
        url = "<?php echo site_url('Tenant/add')?>";
    } else {
        url = "<?php echo site_url('Tenant/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
         success: function(data)
        {
 
           
                $('#modal-edit').modal('hide');
                 location.reload();
        
 
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}

    function edit_person(id){
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
          url : "<?php echo site_url('Tenant/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           $('[name="id"]').val(data.id);
            $('[name="txtTenant"]').val(data.Tenant);
            $('[name="txtLocation"]').val(data.Location);
            $('[name="txtPIC"]').val(data.PIC);
            $('[name="txtPhoneNumber"]').val(data.PhoneNumber);
            $('[name="txtPOS"]').val(data.MerkTypePOS);
            $('[name="txtPrinter"]').val(data.MerkTypePrinter);
            $('[name="txtLat"]').val(data.Lat);
            $('[name="txtLong"]').val(data.Long);
            $('#modal-edit').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Tenant'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}


function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Tenant/delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal-edit').modal('hide');
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

