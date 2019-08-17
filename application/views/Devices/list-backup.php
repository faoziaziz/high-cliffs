<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li>
            <a href="javascript:;">Home</a>
        </li>
        <li>
            <a href="javascript:;">Tables</a>
        </li>
        <li class="active">Managed Tables</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Tenant <small>Tenant</small></h1>
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
                    <h4 class="panel-title">Data Table - Default</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="mytable" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                                      <th>Nomor</th>
                                    <th>Id Device</th>
                                    <th>Nama Tenant</th>
                                    <th>Alamat</th>
                                    <th>No Hp</th>
                                </tr>
                        </thead>

                    </table>
                </div>
            </div>
            <!-- end panel --></div>
        <!-- end col-12 --></div>
    <!-- end row --></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.0/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script>
<script>
        $(document).ready(function(){
            var t = $('#mytable').DataTable({
                "ajax": '<?php echo site_url('tenant/data');?>',
                "order": [[2, 'asc']],
                "columns":[
                    {
                        "data":null,
                        "width":"50px",
                        "sClass": "text-center",
                        "orderable":false
                    },
                    {
                        "data":"DeviceId",
                        "width":"50px"
                    },
                    {
                        "data": "CompanyName",
                        "width": "120px",
                        "sClass" : "text-center"
                    },
                    { "data": "Address"},
                   
                    {"data": "PhoneNumber"},
                ]
            });
            t.on('order.dt search.dt',function(){
                t.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell,i){
                    cell.innerHTML =i+1;
                });
            }).draw();
        });
    </script>