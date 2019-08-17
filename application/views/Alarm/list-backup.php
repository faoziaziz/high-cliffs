<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">Alarm</a>
        </li>
    
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
   <h1 class="page-header">Badan Keuangan Daerah</small></h1>
    <!-- end page-header -->
    <!-- begin row -->

  
    <div class="row">
     <div class="col-md-6 ui-sortable">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                     
                    </div>
                    <h4 class="panel-title">Geografis Information</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                    <?php echo $map['js'] ?>
                  <?php echo $map['html']; ?>
                </div>
            </div>
        </div>
           <div class="col-md-6 ui-sortable">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                     
                    </div>
                    <h4 class="panel-title">Status Perangkat Hari Ini</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                  <table id="data-table" class="table table-striped table-bordered">
                <thead>
                  <tr>  
                    <th>Tanggal</th>
                    <th>Nama WP</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                  foreach($last_alarm as $row){
                  
                ?>
                  <tr>
                    <td><?php echo $row->InsertTimeStamp; ?>
                    <td><?php echo $row->Tenant; ?>
                    <?php
                      if($row->AlarmType>100 or $row->AlarmType==3){
                        echo "<td><label class='label label-success'>$row->description</label</td>";
                      }
                      else{
                        echo "<td><label class='label label-danger'>$row->description</label</td>";
                      }
                    }
                    ?>
                  
                  </tr> 

                  
                </tbody>
              </table>
                </div>
            </div>
        </div>
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
                    <h4 class="panel-title">Alarm</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                    <p>Pencarian Data</p>
                     <table class="table table-bordered">
                          <tr>
                            <td>Tenant</td>
                            <td><?php echo cmb_dinamis('datawp','Tenant','Tenant','DeviceId', null,"id='datawp' onchange='filterData()'") ?> </td>
                          </tr>
                       
                        </table>
                      <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="data-table" aria-describedby="sample_1_info">
                         <thead>
                            <tr>
                                 <th>No</th>
                                  <th>Alarm Time</th>
                                  <th>InsertTime</th>
                                  <th>Device</th>
                                  <th>Tenant</th>
                                  <th>Code</th>
                                  <th>Description</th>
                            </tr>

                          </thead>
                          <tbody id="tabel">

                          </tbody>
                      </table>
                </div>
            </div>
            <!-- end panel --></div>
        <!-- end col-12 --></div>


         
    <!-- end row --></div>


  




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
    function loadData(){
        var wp = $('#datawp').val();
       

     $.ajax({
                type:"GET",
                url : '<?php echo base_url() ?>index.php/alarm/alarmDetail',
                data :'datawp='+wp,
                success:function(html){
                    $("#tabel").html(html);
                }
        });

        
    
    }

    function filterData(){
        loadData();

    }
</script>
