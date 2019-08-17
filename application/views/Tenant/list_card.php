  <link href="<?php echo base_url(); ?>assets/plugins/morris/morris.css" rel="stylesheet" />

  
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

        
      
    
          
         </div>

      

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
                 <div id="tes" class="panel-body" style="overflow: auto"></div>


            </div>
        </div>



         <div class="customNavigation">
  <a class="btn prev">Previous</a>
  <a class="btn next">Next</a>
  <a class="btn play">Autoplay</a>
  <a class="btn stop">Stop</a>
</div>
     
        <!-- end col-12 --></div>
    <!-- end row --></div>


<script>

$(document).ready(function(){

   


 
    //random panel color
   
   
       //Ajax Load data notification      
    function notif(){
           $.ajax({
                   url: "<?php echo site_url('Card/notif/')?>",
                   type: "GET",
                   //data : 'id='+id,
                  
                   success: function (data){
                        $('#tes').html(data);
                           var panel = $(".panel-count").length;
                            function getRandomRgb() {
                                var num = Math.round(0xffffff * Math.random());
                                var r = num >> 16;
                                var g = num >> 8 & 255;
                                var b = num & 255;
                                return 'rgb(' + r + ', ' + g + ', ' + b + ')';
                            }
                       for(var i = 1; i <= panel ; i++){
                            var rgb = [];
                            rgb.push(Math.floor(Math.random() * 255));
                            //document.getElementsByClassName('panel-color'+i).style.backgroundColor = 'rgb('+ rgb.join(',') + ')';
                           $(".panel-color"+i + ".panel-heading").css("backgroundColor", getRandomRgb());
                        }
                       
                    
                    }
            });

  }
  setInterval(function(){
        notif();
   },5000)


});

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

 $(document).ready(function() {
     
      var owl = $("#owl-demo");
     
    
     
    
    });


    </script>

<script src="<?php echo base_url(); ?>assets/plugins/owl-carousel/owl.carousel.js"></script>
