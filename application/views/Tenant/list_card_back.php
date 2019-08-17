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

        
        <div id="owl-demo" class="owl-carousel owl-theme">
    
            <?php
                        $rows = 0;
                        foreach($tenant->result() as $r){
                          $rows ++;
                       

                    ?>
             <div class="item">
   
                            <div class="panel panel-count  contact-card card-view">
                                <div class="panel-heading panel-color<?php echo $rows ?>">
                                    <div class="pull-left">
                                      
                                        <div class="pull-left user-detail-wrap">    
                                            <span class="block card-user-name">
                                               <?php echo $r->Tenant ?>
                                            </span>
                                            <span class="block card-user-desn">
                                                Restaurant
                                            </span>
                                        </div>
                                    </div>
                                    <div class="pull-right">

                                         <li class="dropdown" style="list-style: none; display:inline-block">
                                            <a href="javascript:;" data-toggle="dropdown" class=" pull-left inline-block mr-15">
                                                 <i class="zmdi zmdi-money-box"></i>
                                                <span class="top-nav-icon-badge" id="<?php echo $r->DeviceId ?>">5</span>
                                            </a>
                                            <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                                                <li class="dropdown-header">Notifications (5)</li>
                                                <li class="media">
                                                    <a href="javascript:;">
                                                        <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                                                        <div class="media-body">
                                                            <h6 class="media-heading">Server Error Reports</h6>
                                                            <div class="text-muted f-s-11">3 minutes ago</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="media">
                                                    <a href="javascript:;">
                                                        <div class="media-left"><img src="assets/img/user-1.jpg" class="media-object" alt="" /></div>
                                                        <div class="media-body">
                                                            <h6 class="media-heading">John Smith</h6>
                                                            <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                                            <div class="text-muted f-s-11">25 minutes ago</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="media">
                                                    <a href="javascript:;">
                                                        <div class="media-left"><img src="assets/img/user-2.jpg" class="media-object" alt="" /></div>
                                                        <div class="media-body">
                                                            <h6 class="media-heading">Olivia</h6>
                                                            <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                                            <div class="text-muted f-s-11">35 minutes ago</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="media">
                                                    <a href="javascript:;">
                                                        <div class="media-left"><i class="fa fa-plus media-object bg-green"></i></div>
                                                        <div class="media-body">
                                                            <h6 class="media-heading"> New User Registered</h6>
                                                            <div class="text-muted f-s-11">1 hour ago</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="media">
                                                    <a href="javascript:;">
                                                        <div class="media-left"><i class="fa fa-envelope media-object bg-blue"></i></div>
                                                        <div class="media-body">
                                                            <h6 class="media-heading"> New Email From John</h6>
                                                            <div class="text-muted f-s-11">2 hour ago</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="dropdown-footer text-center">
                                                    <a href="javascript:;">View more</a>
                                                </li>
                                            </ul>
                                        </li>
                                      
                                        <a class="pull-left inline-block mr-15" href="#">
                                            <i class="zmdi zmdi-notifications-active"></i>
                                        </a>
                                        <div class="pull-left inline-block dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert txt-light"></i></a>
                                            <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Full Info</a></li>
                                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Send Message</a></li>
                                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Follow</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="row">
                                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                       
                                            <div class="panel-body">
                                                <h4 class="text-center">Graphic</h4>
                                                <div id="morris-line-chart" class="height-sm"></div>
                                            </div>
                   
                                         </div>
                                        


                                    </div>
                                    <div class="panel-body row">
                                        <div class="user-others-details pl-15 pr-15">
                                            <div class="mb-15">
                                                <i class="zmdi zmdi-email-open inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">markh@gmail.com</span>
                                            </div>
                                            <div class="mb-15">
                                                <i class="zmdi zmdi-smartphone inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">9192372533</span>
                                            </div>
                                            <div class="mb-15">
                                                <i class="zmdi zmdi-phone inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">0203878654</span>
                                            </div>
                                            <div>   
                                                <i class="zmdi zmdi zmdi-skype inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">jberincker</span>
                                            </div>
                                        </div>
                                        <hr class="light-grey-hr mt-20 mb-20"/>
                                        <div class="emp-detail pl-15 pr-15">
                                            <div class="mb-5">
                                                <span class="inline-block capitalize-font mr-5">joininig date:</span>
                                                <span class="txt-dark">12-10-2014</span>
                                            </div>
                                            <div>
                                                <span class="inline-block capitalize-font mr-5">salery:</span>
                                                <span class="txt-dark">$12000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        

                       

                     </div><!--item-->
             <?php } ?>
         </div>

         <div class="customNavigation">
  <a class="btn prev">Previous</a>
  <a class="btn next">Next</a>
  <a class="btn play">Autoplay</a>
  <a class="btn stop">Stop</a>
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
                <div class="panel-body" style="overflow:auto">
                  <?php
                        $rows = 0;
                        foreach($tenant->result() as $row){
                          $rows ++;
                       

                    ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="panel panel-count  contact-card card-view">
                                <div class="panel-heading panel-color<?php echo $rows ?>">
                                    <div class="pull-left">
                                      
                                        <div class="pull-left user-detail-wrap">    
                                            <span class="block card-user-name">
                                               <?php echo $row->Tenant ?>
                                            </span>
                                            <span class="block card-user-desn">
                                                designer
                                            </span>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <a class="pull-left inline-block mr-15" href="#">
                                            <i class="zmdi zmdi-money-box"></i>
                                        </a>
                                        <a class="pull-left inline-block mr-15" href="#">
                                            <i class="zmdi zmdi-notifications-active"></i>
                                        </a>
                                        <div class="pull-left inline-block dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert txt-light"></i></a>
                                            <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Full Info</a></li>
                                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Send Message</a></li>
                                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Follow</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="row">
                                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                       
                                            <div class="panel-body">
                                                <h4 class="text-center">Audi Vehicles Sales Report in UK</h4>
                                                <div id="morris-line-chart" class="height-sm"></div>
                                            </div>
                   
                                         </div>
                                        


                                    </div>
                                    <div class="panel-body row">
                                        <div class="user-others-details pl-15 pr-15">
                                            <div class="mb-15">
                                                <i class="zmdi zmdi-email-open inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">markh@gmail.com</span>
                                            </div>
                                            <div class="mb-15">
                                                <i class="zmdi zmdi-smartphone inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">9192372533</span>
                                            </div>
                                            <div class="mb-15">
                                                <i class="zmdi zmdi-phone inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">0203878654</span>
                                            </div>
                                            <div>   
                                                <i class="zmdi zmdi zmdi-skype inline-block mr-10"></i>
                                                <span class="inline-block txt-dark">jberincker</span>
                                            </div>
                                        </div>
                                        <hr class="light-grey-hr mt-20 mb-20"/>
                                        <div class="emp-detail pl-15 pr-15">
                                            <div class="mb-5">
                                                <span class="inline-block capitalize-font mr-5">joininig date:</span>
                                                <span class="txt-dark">12-10-2014</span>
                                            </div>
                                            <div>
                                                <span class="inline-block capitalize-font mr-5">salery:</span>
                                                <span class="txt-dark">$12000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <?php } ?>
                </div>
            </div>
            <!-- end panel --></div>
        <!-- end col-12 --></div>
    <!-- end row --></div>


<script>

$(document).ready(function(){

    function load_unseen_notification(view=''){

 
    //Ajax Load data from ajax
  
           $.ajax({
                   url: "<?php echo site_url('Card/notif/')?>",
                   type: "POST",
                    data :{view:view},
                    dataType:"json"
                   success: function (data){
                        
                    }
            });
    }


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
     
      owl.owlCarousel({
           items : 2,
        lazyLoad : true,
        navigation : true,
        autoPlay:5000,
        navigationText:["<",">"]
      });
     
    
    });


    </script>

<script src="<?php echo base_url(); ?>assets/plugins/owl-carousel/owl.carousel.js"></script>
