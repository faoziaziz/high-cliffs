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
    <h1 class="page-header">Transaction | Trumon</h1>
    <!-- end page-header -->
    <!-- begin row -->

  
    <div class="row">
        <!-- begin col-12 -->
     

         <div class="tab-overflow overflow-right">
                                <ul class="nav nav-tabs">
                                    
                                    <li class=""><a href="#default-tab-1" data-toggle="tab">Monthly </a></li>
                                    <li class="active"><a href="#default-tab-2" data-toggle="tab">Activity</a></li>
                                    
                                    
                                </ul>
                            </div>

                  <div class="tab-content">
                            <div class="tab-pane fade " id="default-tab-1">
                                <h3 class="m-t-10">Monthly Transaction</h3>
                                  <p>Filtering Data</p>
                                <table class="table table-bordered">
                                    <tr>
                                      <td>Tenant</td>
                                      <td><?php echo cmb_dinamis('datawp','Tenant','Tenant','DeviceId', null,"id='datawp'") ?> </td>
                                       <td>Month</td>
                                        <td><select name="txtBulan" id="txtBulan" class="form-control">
                                        <option>Month</option>
                                          <?php
                                            $bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                            $cur_month = date('m');
                                            for($bln=1; $bln<=12; $bln++){
                                              if($bln<=9) { 
                                                echo "<option value='0$bln' ";
                                                if($cur_month==$bln){
                                                    echo ' selected="selected"';
                                                }
                                                echo ">$bulan[$bln]</option>"; 
                                              }
                                                else { 

                                                echo "<option value='0$bln' ";
                                                if($cur_month==$bln){
                                                    echo ' selected="selected"';
                                                }
                                                echo ">$bulan[$bln]</option>"; 
                                               }
                                             }
                                            
                                          ?>
                                        </select>
                                      </td>
                                       <td><label>Year</label></td>
                                      <td><select name="txtTahun" id="txtTahun"  class="form-control">
                                        <option  >Year</option>
                                          <?php
                                          
                                           $starting_year = date('Y',strtotime('-1 year'));
                                            $ending_year = date('Y',strtotime('+5 year'));
                                            $curr_year = date('Y');
                                            $sel;
                                            for($starting_year; $starting_year<=$ending_year; $starting_year++){
                                               echo '<option value="'.$starting_year.'"';
                                                if($curr_year==$starting_year){
                                                   echo ' selected="selected"';
                                                   }
                                                   echo ' >'.$starting_year.'</option>';
                                             }
                                          ?>
                                        </select>
                                      </td>
                                     
                                      
                                      <td><button id="search" class="btn btn-success">Submit</button></td>
                                    </tr>
                                    
                                 
                                </table>
                                <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="data-table" aria-describedby="sample_1_info">
                                   <thead>
                                      <tr>
                                           <th>No</th>
                                          <th>DeviceId</th>
                                           <th> Amount</th>
                                          <th align="right">Total </th>
                                          <th>Discount</th>
                                      </tr>

                                    </thead>
                                    <tbody id="tabel">

                                    </tbody>
                                </table>
                    </div>
                            <div class="tab-pane fade active in" id="default-tab-2" style="overflow:auto">
                                <h3 class="m-t-10">Activity Transaction</h3>
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
                                        <th>Date / Time</th>
                                        <th>Device</th>
                                        <th>Tenant</th>
                                         <th>No. Transaction</th>
                                        <th>Amount</th>
                                        <th>Tax</th>
                                         <th>Total</th>
                                         <th>Ket</th>
                                         <th>Diskon</th>
                                         <th>Net Sales</th>
                                    </tr>
                            </thead>
                           <tbody>
                           </tbody>
                        </table>
                            </div>
                              <div class="tab-pane fade " id="default-tab-3">


                                 <div class="panel panel-inverse" data-sortable-id="form-stuff-3">
                   
                        <div class="panel-body">
                            <?php echo form_open('Transaction/export_excel'); ?>
                                <fieldset>
                                    <legend>Report</legend>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tenant</label>
                                        <?php echo cmb_dinamis('datawp','Tenant','Tenant','DeviceId', null,"id='datawp'") ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Month</label>
                                       <select name="txtBulan" id="txtBulan" class="form-control">
                                        <option selected="selected" >Month</option>
                                          <?php
                                            $bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                            for($bln=1; $bln<=12; $bln++){
                                              if($bln<=9) { 
                                                echo "<option value='0$bln'>$bulan[$bln]</option>"; }
                                                else { echo "<option value='$bln'>$bulan[$bln]</option>"; }
                                                }
                                            
                                          ?>
                                        </select>
                                    </div>
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Year</label>
                                        <select name="txtTahun" id="txtTahun"  class="form-control">
                                        <option selected="selected">Tahun</option>
                                          <?php
                                          
                                            for($thn=2017; $thn<=2018; $thn++){
                                            
                                               echo "<option value='$thn'>$thn</option>"; 
                                             }
                                            
                                          ?>
                                        </select>
                                    </div>
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">testing</label>
                                        <select name="txtTahun" id="jenis" onchange="chk()"  class="form-control ">
                                         <option selected="selected">jenis</option>
                                            <option value="0">Monthly</option>
                                            <option value="1">Daily</option>
                                        </select>
                                    </div>

                                     <input id="NoIconDemo" name="tes" class="month-year-input tes">
                                     <span class="add-on"><i class="icon-th"></i></span>   
                                     <button type="submit" class="btn btn-success">export</button></td>
                                     
                                </fieldset>
                            </form>
                        </div>
                    </div>


                               
                            </div>
                            
                        </div>
        
    <!-- end row --></div>


<div class="modal fade" id="post_modal">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Detail Transaction Per Day</h4>
      </div>
      <div class="modal-body" id="post_detail">
        <div class="table-resposnive">
                        <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Device id</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Total</th>
                                <th>Discount</th>
                            </tr>
                          
                            </thead>
                         <tbody id="tes">
                          
                          
                        </tbody>
                    </table>
                    </div>

      </div>
      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
       
      </div>
    </div>
  </div>
</div>
  
<script>
/*$(document).ready(function() {
     $('#NoIconDemo').MonthPicker({ Button: false });
});*/
function chk(){
   var ddl = document.getElementById("jenis");
    var monthsLabels = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
    var today = new Date();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();

    if (mm <=9){
        month = "0" + mm;  

    }
    else{
      month = mm;
    }
   if(ddl.selectedIndex==1){
      $("#dt1").datepicker("remove");
       $("#dt2").datepicker("remove");

      $("#dt1").val(yyyy+'-'+month);
       $("#dt2").val(yyyy+'-'+month);
      $('#dt1').unbind();
      //$('#dt1').MonthPicker({ Button: false,format: 'yyyy-mm' });
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
      $("#dt1").datepicker({format: 'yyyy-mm-dd',autoclose:true}).datepicker("setDate",new Date());
       $('#dt2').unbind();
      $("#dt2").datepicker({format: 'yyyy-mm-dd',autoclose:true}).datepicker("setDate",new Date());
   }
     else if(ddl.selectedIndex==0){
        $("#dt1").datepicker("remove");
        $("#dt2").datepicker("remove");
        $('#dt1').unbind();
        $('#dt2').unbind();
        $("#dt1").val("");
        $("#dt2").val("");
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
            "url": "<?php echo site_url('Daily_Transaction/Ajax_list')?>",
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
            className: "text-right", "targets": [5,6,7,9,10],
            "width": "1%", "targets": 4, 
          
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
