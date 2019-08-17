<?php
defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller{


	function __construct(){
			parent::__construct();
			$this->load->library('ssp');
			$this->load->model('Model_Tenant');
			check_session();
	}


	function index(){
	
		$data['tenant'] = $this->Model_Tenant->get_tenant_card();
		$this->template->load('template','Tenant/list_card',$data);
	}

	function notif_transaction(){
		$data = $this->Model_Tenant->get_notif();
		echo json_encode($data);
		
	}

	function notif4(){

		$tenant= $this->db->get('Tenant');
		foreach($tenant->result_array() as $r){

			$ids= $r['DeviceId'];
			$n='';
			$output='';
              $sql = "SELECT * FROM Transaksi where DeviceId='$ids' and NilaiDanPajak <> '' order by FileTime DESC limit 5 ";     
              	$notif = $this->db->query($sql)->result();
		    foreach($notif as $row){

		    
	             //$output.="$row->NilaiDanPajak"." ". "$row->DeviceId" . " " ;
	             $row->NilaiDanPajak;         
	            	$output .="
	                     
	                       <li class='media'>
	                           <a href='javascript:;'>
	                               <div class='media-left'><i class='fa fa-bug media-object bg-red'></i></div>
	                               <div class='media-body'>
	                                  <h6 class='media-heading'> $row->NilaiDanPajak >$row->DeviceId</h6>
	                                   <div class='text-muted f-s-11'></div>
	                               </div>
	                          </a>
	                      </li>";                           
	                                            
		    }
		    
		}
		echo $output;
	}

	function notif(){

		
		$tenant= $this->db->get('Tenant');
		$rows=0;
		$output='';
	
       foreach($tenant->result() as $r){
            $rows ++;
            $ids = $r->DeviceId;           
                      // $id   = $_GET['id'];
            $tenant = $r->Tenant;
        	echo '
        
   			 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                             <div class="panel panel-count  contact-card card-view">
                                <div class="panel-heading panel-color'. $rows .'">
                                    <div class="pull-left">
                                      
                                        <div class="pull-left user-detail-wrap">    
                                            <span class="block card-user-name">
                                              '. $tenant . '
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
                                                <span class="top-nav-icon-badge" id="'.$r->DeviceId . '"><input type="hidden" class="devid" value="'.$r->DeviceId . '">5</span>
                                            </a>
                                            <ul class="dropdown-menu media-list pull-right animated fadeInDown">

                                                <li class="dropdown-header" id="notifs">Notifications (5)</li>';
                                                 $sql = "SELECT * FROM Transaksi where DeviceId='$ids ' and NilaiDanPajak <> '' order by FileTime DESC limit 5 ";     
                                                    $notif = $this->db->query($sql)->result();
                                                    $output='';
                                                foreach($notif as $row){

                                                    $output .=" 
                                                             
                                                               <li class='media'>
                                                                   <a href='javascript:;'>
                                                                       <div class='media-left'><i class='fa fa-bug media-object bg-red'></i></div>
                                                                       <div class='media-body'>
                                                                          <h6 class='media-heading'>$row->NilaiDanPajak</h6>
                                                                           <div class='text-muted f-s-11'>$row->FileTime</div>
                                                                       </div>
                                                                  </a>
                                                              </li>";
                                                     //$output.="$row->NilaiDanPajak"." ". "$row->DeviceId" . " " ;
                                                                                        
                                                                                    
                                                }
                                                echo $output;

                                             
                   echo  '                        
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
                        

                       

                     </div>





        	';
        	          
		}
	
	
	}

	function notif3(){

		
		$tenant= $this->db->get('Tenant');
		$rows=0;
		$output='';
		echo '	  <div id="owl-demo " class="owl-carousel owl-theme ">';
       foreach($tenant->result() as $r){
            $rows ++;
            $ids = $r->DeviceId;           
                      // $id   = $_GET['id'];
            $tenant = $r->Tenant;
        	echo '
        	
        		
   
                             <div class="panel panel-count  contact-card card-view">
                                <div class="panel-heading panel-color'.$rows .'">
                                    <div class="pull-left">
                                      
                                        <div class="pull-left user-detail-wrap">    
                                            <span class="block card-user-name">
                                              '. $tenant . '
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
                                                <span class="top-nav-icon-badge" id="'.$r->DeviceId . '"><input type="hidden" class="devid" value="'.$r->DeviceId . '">5</span>
                                            </a>
                                            <ul class="dropdown-menu media-list pull-right animated fadeInDown">

                                                <li class="dropdown-header" id="notifs">Notifications (5)</li>';
                                                 $sql = "SELECT * FROM Transaksi where DeviceId='$ids ' and NilaiDanPajak <> '' order by FileTime DESC limit 5 ";     
                                                    $notif = $this->db->query($sql)->result();
                                                    $output='';
                                                foreach($notif as $row){

                                                    $output .=" 
                                                             
                                                               <li class='media'>
                                                                   <a href='javascript:;'>
                                                                       <div class='media-left'><i class='fa fa-bug media-object bg-red'></i></div>
                                                                       <div class='media-body'>
                                                                          <h6 class='media-heading'>$row->NilaiDanPajak</h6>
                                                                           <div class='text-muted f-s-11'>$row->FileTime</div>
                                                                       </div>
                                                                  </a>
                                                              </li>";
                                                     //$output.="$row->NilaiDanPajak"." ". "$row->DeviceId" . " " ;
                                                                                        
                                                                                    
                                                }
                                                echo $output;

                                             
                   echo  '                        
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
                        

                       

                     </div>





        	';
        	          
		}
		echo '</div>';
	
	}

	function notif2(){

		
		$tenant= $this->db->get('Tenant');
	
		$output='';
     
        	
              $sql = "SELECT * FROM Transaksi where DeviceId='APS010700040' and NilaiDanPajak <> '' order by FileTime DESC limit 5 ";     
              	$notif = $this->db->query($sql)->result();
		    foreach($notif as $row){

		    
	             //$output.="$row->NilaiDanPajak"." ". "$row->DeviceId" . " " ;
	                         echo"
	                     
	                       <li class='media'>
	                           <a href='javascript:;'>
	                               <div class='media-left'><i class='fa fa-bug media-object bg-red'></i></div>
	                               <div class='media-body'>
	                                  <h6 class='media-heading'>$row->NilaiDanPajak >$row->DeviceId</h6>
	                                   <div class='text-muted f-s-11'>$row->FileTime</div>
	                               </div>
	                          </a>
	                      </li>";                       
	                                            
		    }
		     /* $data = array(
	    		'notification' =>$output

	    	);*/

	    		
	    
		

	 // echo json_encode($data);
	}
}