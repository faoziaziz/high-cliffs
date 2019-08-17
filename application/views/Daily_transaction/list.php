<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">Daily Transaction</a>
        </li>
    
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Badan Keuangan Daerah</h1>
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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Daily Transaction</h4>
                </div>
                <div class="panel-body">
                      <p>Filtering Data</p>
                     <table class="table table-bordered">
                        <form id="form-filter">
                          <tr>
                            <td>Tenant</td>
                            <td><?php echo cmb_dinamis('DeviceId','DataWP','CompanyName','DeviceId', null,"id='datawp'") ?> </td>
                             <td>Bulan</td>
                            <td><select name="txtBulan" id="txtBulan" class="form-control">
                             
                                <?php
                                  $bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                  for($bln=1; $bln<=12; $bln++){
                                    if($bln<=9) { 
                                      echo "<option value='0$bln'>$bulan[$bln]</option>"; }
                                      else { echo "<option value='$bln'>$bulan[$bln]</option>"; }
                                      }
                                  
                                ?>
                              </select>
                            </td>
                             <td><label>Tahun</label></td>
                            <td><select name="txtTahun" id="txtTahun"  class="form-control">
                             
                                <?php
                                
                                  for($thn=2017; $thn<=2018; $thn++){
                                  
                                     echo "<option value='$thn'>$thn</option>"; 
                                   }
                                  
                                ?>
                              </select>
                            </td>
                            <td><button id="btn-filter" type="button" class="btn btn-success">Submit</button>
                            </form>
                          </tr>
                          </tr>
                           <tr>

                       
                        </table>
                    <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="table" aria-describedby="sample_1_info">

                        <thead>
                            <tr role="row">
                                   <th>No</th>
                                    <th>Date / Time</th>
                                    <th>Device</th>
                                    <th>Tenant</th>
                                     <th>No. Transaction</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                     <th>Total</th>
                                </tr>
                        </thead>
                       <tbody>
                       </tbody>
                    </table>
                </div>
            </div>
            <!-- end panel --></div>
        <!-- end col-12 --></div>


         
    <!-- end row --></div>


  



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
            "url": "<?php echo site_url('Daily_Transaction/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.DeviceId = $('#datawp').val();
                 data.txtBulan = $('#txtBulan').val();
                  data.txtTahun = $('#txtTahun').val();
               
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
