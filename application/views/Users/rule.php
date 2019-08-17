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
    <h1 class="page-header">User's Role | trumon </h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-4 ui-sortable">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                   
                    </div>
                    <h4 class="panel-title">Level User</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                      <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="table" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                                    <td style="line-height:30px">Pilih Level</td>
                                    <td><?php echo cmb_user('txtlevel','User_level','nama_level','id_level_user', null,"id='txtlevel' onchange='loadData()'") ?>
                                    </td>
                                </tr>
                        </thead>

                    </table>
                </div>
            </div>
            <!-- end panel --></div>


             <div class="col-md-8 ui-sortable">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                   
                    </div>
                    <h4 class="panel-title">Hak Akses</h4>
                </div>
                <div class="panel-body" style="overflow:auto">
                    <p>
                     
     
                    </p>
                   <div id="tabel"></div>
                </div>
            </div>
            <!-- end panel --></div>
        <!-- end col-12 --></div>
    <!-- end row --></div>



<script>
    $(document).ready(function(){
        loadData();
    }) 
</script>

<script>
    function loadData(){
        var level_user = $("#txtlevel").val();
        $.ajax({
            type:"GET",
            url :'<?php echo base_url() ?>index.php/Users/modul',
            data:'level_user='+level_user,
            success:function(html){
                $("#tabel").html(html);
            }
        });
    }


    function addRule(id_modul){
       var level_user = $("#txtlevel").val();
       $.ajax({
          type:"GET",
            url :'<?php echo base_url() ?>index.php/Users/addrule',
            data:'level_user='+level_user+'&id_menu='+id_modul,
            success:function(html){
               // loadData();
               alert('sukses memberikan akses');
            }
       })
    }

    
</script>