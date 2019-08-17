<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">User</a>
        </li>
    
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">User List | Trumon</h1>
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
                    <h4 class="panel-title">List Users</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                    <p>
                         <?php //echo anchor('#modal-dialog','Tambah',"title='tambah-data', class='btn btn-success', data-toggle='modal'"); ?>
                          <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add User</button>
                           <!--<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>--> 
                           <?php echo anchor('users/rule','RULE USER',array('class'=>'btn btn-danger btn-sm')); ?>
     
                    </p>
                    <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="table" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                                      <th>Nomor</th>
                                    <th>Foto</th>
                                    <th>Username</th>
                                    <th>nama_level</th>
                                    
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
                <h4 class="modal-title">Add User</h4>
            </div>
            <div class="modal-body">
                <form action="#" id="form" class="form-horizontal" >
                     <input type="hidden" value="" name="id"/>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Username</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtusername"/>
                        </div>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="form-field-1" class="form-control" name="txtpassword"/>
                        </div>
                        <span class="help-block"></span>
                        
                    </div>
                      
                   
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Level</label>
                        <div class="col-sm-10">
                        <?php echo cmb_user('txtlevel','User_level','nama_level','id_level_user', null,"id='datawp'") ?>
                        
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Email</label>
                        <div class="col-sm-10">
                            <input type="email" id="form-field-1" class="form-control" name="txtemail"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">NIPD</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtnipd"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtnamalengkap"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Jenis Kelamin</label>
                        <div class="col-sm-10">
                           <select name="txtjenkel" class="form-control">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>

                           </select>
                        </div>
                        <span class="help-block"></span>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Alamat</label>
                        <div class="col-sm-10">
                           <textarea rows=5 name="txtalamat" class="form-control"></textarea>
                        </div>
                        <span class="help-block"></span>
                    </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">No Telp</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtTelp"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                     <div class="form-group" id="photo-preview">
                            <label class="control-label col-md-3">Photo</label>

                            <div class="col-md-9">
                                (No photo)
                                <span class="help-block"></span>
                            </div>
                        </div>
                    <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo">Upload Photo </label>
                            <div class="col-md-9">
                                <input name="photo" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                  
                     <div class="modal-footer">
                   
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

  


<script>
var save_method; //for save method string
        $(document).ready(function(){
            var t = $('#table').DataTable({
                "ajax": '<?php echo site_url('Users/data');?>',
                "order": [[3, 'desc']],
                "columns":[
                    {
                        "data":null,
                        "width":"50px",
                        "sClass": "text-center",
                        "orderable":false
                    },
                    {
                        "data":"foto",
                        "width": "120px",
                        
                    },
                    {
                        "data": "username",
                       
                        "sClass" : "text-center"
                    },
                  
                   
                    {"data": "nama_level"},
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
            $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
             $('#photo-preview').hide(); // hide photo preview modal

        }



function save()
{
     
   
    var url;
 
 if(save_method == 'add') {
        url = "<?php echo site_url('Users/add')?>";
    } else {
        url = "<?php echo site_url('Users/ajax_update')?>";
    }
 
    // ajax adding data to database
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
       data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
         success: function(data)
        {
 
             if(data.status) //if success close modal and reload ajax table
            {
                $('#modal-edit').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button 
 
 
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
          url : "<?php echo site_url('Users/ajax_edit/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           $('[name="id"]').val(data.id);
            $('[name="txtemail"]').val(data.email);
            $('[name="txtusername"]').val(data.username);
            $('[name="txtnipd"]').val(data.nip);
            $('[name="txtnamalengkap"]').val(data.nama_lengkap);
            $('[name="txtjenkel"]').val(data.jenkel);
            $('[name="txtTelp"]').val(data.no_telp);
            $('[name="txtalamat"]').val(data.alamat);
            $('[name="txtpassword"]').val(data.password);
            $('#modal-edit').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Tenant'); // Set title to Bootstrap modal title
             $('#photo-preview').show(); // show photo preview modal
              if(data.foto)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="<?php echo base_url(); ?>'+'uploads/'+data.foto+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.foto+'"/> Remove photo when saving'); // remove photo

            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
                $('#photo-preview div').html('<img src="'+base_url+'uploads/'+data.foto+'" class="img-responsive">'); // show photo
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



function reload_table()
{
    var table = $('#table').DataTable();
    table.ajax.reload(null,false); //reload datatable ajax 
}


function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Users/delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal-edit').modal('hide');
                  reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}



    </script>

