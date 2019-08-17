<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">All Transaction</a>
        </li>
    
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
   <h1 class="page-header">Trumon for Trial</h1>
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
                    <h4 class="panel-title">All Transaction</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                   
                    
                       <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="table" aria-describedby="sample_2_info" >
                            <thead>
                                <tr>
                                       <th>No</th>
                                        <th>Date / Time</th>
                                        <th>Device</th>
                                        <th>Tenant</th>
                                         <th>No. Transaction</th>
                                        <th>Amount</th>
                                        <th>Tax</th>
                                         <th>Total</th>
                                         <th>Ket 1</th>
                                         <th>Ket 2</th>
                                         <th>Ket 3</th>
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
            "url": "<?php echo site_url('All_Transaction/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.DeviceId = $('#datawp1').val();
                 data.txtBulan = $('#txtBulan1').val();
                  data.txtTahun = $('#txtTahun1').val();
               
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
