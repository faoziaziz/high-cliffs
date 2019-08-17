<!-- AUTO COMPLETE-->
  <link href="<?php echo base_url(); ?>assets/css/default.css" rel="stylesheet" id="theme" />
  <link href="<?php echo base_url(); ?>assets/js/jquery.autocomplete.css" rel="stylesheet" id="theme" />




 <div id="modal_detail" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>


<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">Transaction</a>
        </li>
    
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Maintenance | Trumon</h1>
    <!-- end page-header -->
    <!-- begin row -->

  
    <div class="row">
        <!-- begin col-12 -->
       <p>
                         <?php //echo anchor('#modal-dialog','Tambah',"title='tambah-data', class='btn btn-success', data-toggle='modal'"); ?>
                          <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i>Add Issue</button>
                           <!--<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>--> 
                          
     
                    </p>

         <div class="tab-overflow overflow-right">
                                <ul class="nav nav-tabs">
                                    
                                   <li class=""><a href="#default-tab-1" data-toggle="tab">Monitoring </a></li>
                                    <li class="active"><a href="#default-tab-2" data-toggle="tab">Activity</a></li>
                                    
                                    
                                </ul>
                            </div>

                  <div class="tab-content">
                      <div class="tab-pane fade " id="default-tab-1">
                                <h3 class="m-t-10">Monitoring</h3>
                                  <p>Filtering Data</p>
                                  <h3>COMING SOON</h3>
                    </div>      
                      <div class="tab-pane fade active in" id="default-tab-2" style="overflow:auto">
                                <h3 class="m-t-10">Maintenance</h3>
                               <p>Filtering Data</p>

                               <table class="table table-bordered">
                                  

                                      <form id="form-filter">
                                    <tr>
                                       <td>Tenant</td>

                                      <td><?php echo cmb_activity('datawp','Tenant','Tenant','DeviceId', null,"id='datawp1'") ?> </td>
                                      <td>Jenis</td>
                                      <td><select name="txtjenis" id="jenis" onchange="chk()"  class="form-control ">
                                                   <option selected="selected">jenis</option>
                                                      <option value="0">Monthly</option>
                                                      <option value="1">Daily</option>
                                          </select>
                                      </td>
                                       <td><label>Tanggal Awal</label></td>
                                      <td><input id="dt1" name="txtdt1"  class="month-year-input form-control"></td>
                                      <td><label>Tanggal akhir</label></td>
                                      <td><input id="dt2" name="txtdt2"  class="month-year-input form-control"></td>
                                      <td><button id="btn-filter" type="button" class="btn btn-success">Submit</button> </td>
                                      </tr>
                                    </form>
                               
                                </table>
                                 <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="table" aria-describedby="sample_2_info">
                                    <thead>
                                        <tr>
                                               <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Device Id</th>
                                                 <th>Nama Wajib Pajak</th>
                                                <th>Masalah</th>
                                                <th>Tindakan</th>
                                                 <th>Status</th>
                                               
                                            </tr>
                                    </thead>
                                   <tbody>
                                   </tbody>
                                </table>
                        </div>
                             
                            
                        </div>
        
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
                        <label class="col-sm-2 control-label" for="form-field-1">DeviceId</label>
                        <div class="col-sm-10">
                            <input type="text" class='autocomplete form-control' id="autocomplete1" name="txtDeviceId"/>
                        </div>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Tenant</label>
                        <div class="col-sm-10">
                            <input type="text" id="tenant" class="form-control" name="txtTenant"/>
                        </div>
                        <span class="help-block"></span>
                        
                    </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" id="tanggal" class="form-control" name="txtTanggal"/>
                        </div>
                        <span class="help-block"></span>
                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Masalah</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtMasalah"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Tindakan</label>
                        <div class="col-sm-10">
                            <input type="text" id="form-field-1" class="form-control" name="txtTindakan"/>
                        </div>
                        <span class="help-block"></span>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="form-field-1">Status</label>
                        <div class="col-sm-10">
                              <select name="txtStatus" class="form-control">
                                <option value="pending">pending</option>
                                <option value="selesai">Selesai</option>
                           </select>
                        </div>
                        <span class="help-block"></span>
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

    <script type='text/javascript'>
        var site = "<?php echo site_url();?>";
         $(function(){
            $('.autocomplete').autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: site+'/Maintenance/search',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#tenant').val(''+suggestion.Tenant); // membuat id 'v_nim' untuk ditampilkan
                 
                }
            });
        });
    </script>
  
<script>
   function add_person()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal-edit').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Issue'); // Set Title to Bootstrap modal title
             $('#photo-preview').hide(); // hide photo preview modal

        }

  function save()
{
     
   
    var url;
 
 if(save_method == 'add') {
        url = "<?php echo site_url('Maintenance/add')?>";
    } else {
        url = "<?php echo site_url('Maintenance/ajax_update')?>";
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
/*$(document).ready(function() {
     $('#NoIconDemo').MonthPicker({ Button: false });
});*/
function chk(){
   var ddl = document.getElementById("jenis");
    var monthsLabels = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']

   if(ddl.selectedIndex==1){
      $("#dt1").datepicker("remove");
       $("#dt2").datepicker("remove");
      $('#dt1').unbind();
     // $('#dt1').MonthPicker({ Button: false,format: 'yyyy-mm' });
     var picker = jQuery('#dt1').MonthPicker({
      ShowIcon: false,
          OnAfterChooseMonth: function(){
              var elts = picker.val().split('/');
              picker.val(elts[1]+'-'+monthsLabels[parseInt(elts[0])-1]);
          }
      });
       $('#dt2').unbind();
        var picker1 = jQuery('#dt2').MonthPicker({
      ShowIcon: false,
          OnAfterChooseMonth: function(){
              var elts = picker1.val().split('/');
              picker1.val(elts[1]+'-'+monthsLabels[parseInt(elts[0])-1]);
          }
      });
    }
   else if(ddl.selectedIndex==2){
       $("#dt1").datepicker("remove");
       $("#dt2").datepicker("remove");
      $('#dt1').unbind();
      $("#dt1").datepicker({format: 'yyyy-mm-dd',autoclose:true});
       $('#dt2').unbind();
      $("#dt2").datepicker({format: 'yyyy-mm-dd',autoclose:true});
   }
    else{
         $("#NoIconDemo").datepicker("remove");
         $('#NoIconDemo').unbind();
    }
}

</script>

<script>
    function loadData(){
        var wp = $('#datawp').val();
        var bln = $('#txtBulan').val();
        var thn = $('#txtTahun').val();

     $.ajax({
                type:"GET",
                url : '<?php echo base_url() ?>index.php/transaction/transactionDetail',
                data :'datawp='+wp+'&txtBulan='+bln+'&txtTahun='+thn,
                success:function(html){
                    $("#tabel").html(html);
                }
        });

        
    
    }

   
    $("#search").click(function(){
      loadData();
    });
/*
    function edit_person(){

 
    //Ajax Load data from ajax
   
           $.ajax({
                url : "<?php echo site_url('transaction/ajax_edit/')?>/" + id,
                 type: "GET",
                dataType: "JSON",
              success: function(data)
              {
              
                
                  $('#modal-edit').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
          });
      
            $('#modal-edit').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
 
  
  }
*/
   function detail(){

 
    //Ajax Load data from ajax
    var wp = $('#datawp').val();
        var bln = $('#txtBulan').val();
        var thn = $('#txtTahun').val();
          
            var m = $(this).attr("id");
           $.ajax({
                   url: "<?php echo site_url('Transaction/Ajax_edit/')?>",
                   type: "GET",
                    data :'datawp='+wp+'&txtBulan='+bln+'&txtTahun='+thn,
                   success: function (html){
                   $("#post_modal").modal('show');
                    $('#tes').html(html);
               }
               });
    }
  

</script>

<script>
   var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Maintenance/Ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.txtJenis = $('#jenis').val();
                data.DeviceId = $('#datawp1').val();
                 data.txtdt1 = $('#dt1').val();
                  data.txtdt2 = $('#dt2').val();
               
            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload(null,false);  //just reload table
    });
 
});
 
</script>
  