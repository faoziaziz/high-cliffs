<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('ssp');
		$this->load->model('Model_Users');
		$this->load->model('Model_Dashboard');
		check_session();

	}
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->template->load('template','Users/list');
	}

	function data(){
		//nama table
		$table = 'View_User';
		// nama pk
			$primaryKey='id';
		//list table
		$columns = array(
		
			 array('db' => 'foto',
                'dt' => 'foto',
                'formatter' => function( $d) {
                   if(empty($d)){
                       return "<img class='img-responsive' style='width:200px' src='".  base_url()."/uploads/user-siluet.jpg'>";
                   }else{
                       return "<img class='img-responsive' style='width:200px'  src='".  base_url()."/uploads/".$d."'>";
                   }   
                }
            ),
			
			array('db'=>'username','dt'=>'username'),
			array('db'=>'nama_level','dt'=>'nama_level'),
			
			array(
				'db'=>'id',
				'dt'=>'aksi',
				'formatter'=>function ($d){
					//return "<a href='edit.php?id=$d'>EDIT</a>";
					return '<a class="btn btn-xs btn-primary tooltips" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$d."'".')"><i class="glyphicon glyphicon-pencil"></i></a> <a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$d."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

						
				}

				)
			
			);

		$sql_details=array(
			'user'=>$this->db->username,
			'pass' => $this->db->password,
			'db' => $this->db->database,
			'host' => $this->db->hostname
			);

		 echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
	}

	
	function add(){
	
			$data = array(
				'email'	=> $this->input->post('txtemail'),
				'username' => $this->input->post('txtusername'),
				'password' => md5($this->input->post('txtpassword')),
				'nip' => $this->input->post('txtnipd'),
				'nama_lengkap' => $this->input->post('txtnamalengkap'),
				'jenkel' => $this->input->post('txtjenkel'),
				'alamat' => $this->input->post('txtalamat'),
				'no_telp' => $this->input->post('txtTelp'),
				'id_level_user' => $this->input->post('txtlevel'),
			);

				if(!empty($_FILES['photo']['name']))
				{
					$upload = $this->upload_foto();
					$data['foto'] = $upload;
				}

				$insert = $this->Model_Users->save($data);

				echo json_encode(array("status" => TRUE));
				
	}

	 public function ajax_edit($id)
    {
        $data = $this->Model_Users->get_by_id($id);
     
        echo json_encode($data);
    }


    public function ajax_update()
	{
		
		$data = array(
				'email'	=> $this->input->post('txtemail'),
				'username' => $this->input->post('txtusername'),
				'password' => md5($this->input->post('txtpassword')),
				'nip' => $this->input->post('txtnipd'),
				'nama_lengkap' => $this->input->post('txtnamalengkap'),
				'jenkel' => $this->input->post('txtjenkel'),
				'alamat' => $this->input->post('txtalamat'),
				'no_telp' => $this->input->post('txtTelp') ,
				'id_level_user' => $this->input->post('txtlevel'),
			);


		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('./uploads/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('./uploads/'.$this->input->post('remove_photo'));
			$data['foto'] = '';
		}

		if(!empty($_FILES['photo']['name']))
		{
			$upload = $this->upload_foto();
			
			//delete file
			$Users = $this->Model_Users->get_by_id($this->input->post('id'));
			if(file_exists('./upload/'.$Users->foto) && $Users->foto)
				unlink('upload/'.$Users->photo);

			$data['foto'] = $upload;
		}

		$this->Model_Users->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
 

	
    public function delete($id){
    	//delete file
		$Users = $this->Model_Users->get_by_id($id);
		if(file_exists('./uploads/'.$Users->foto) && $Users->foto)
			unlink('./uploads/'.$Users->foto);
		
		$this->Model_Users->delete($id);
		echo json_encode(array("status" => TRUE));
    }

    function upload_foto(){
    	$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
      
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
    	$this->load->library('upload', $config);
 		if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
    	return $this->upload->data('file_name');	
    }


    function rule(){
    	$this->template->load('template','Users/rule');
    }


    function modul(){
    	$level_user = $_GET['level_user'];
    	echo ' <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="table" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                                    <th width=10%>Nomor</th>
                                    <th>Nama Module</th>
                                    <th>link</th>
                                    <th>Hak Akses</th>
                                  
                                </tr>';
          $menu = $this->db->get('tabel_menu');
          $no=1;
          foreach($menu->result() as $row){
               echo "<tr>
               			<td>$no</td>
               			<td>".strtoupper($row->judul_menu)."</td>
               			<td>$row->link</td>
               			<td><input type='checkbox' class='form-control' name='akses' ";
               			$this->check_akses($level_user,$row->id);
               			echo " onclick='addRule($row->id)'>

               			</td>
               		</tr>";
               $no++;
          }

          echo'</thead>

                    </table>';
    }

    function addrule(){
    	$level_user = $_GET['level_user'];
    	$id_menu 	= $_GET['id_menu'];
    	$data 		= array('id_level_user'=>$level_user,'id_menu'=>$id_menu);
    	$chek 		= $this->db->get_where('user_rule',$data);
    	if($chek->num_rows()<1){
    		$this->db->insert('user_rule',$data);

    	}else{
    		$this->db->where('id_menu',$id_menu);
    		$this->db->where('id_level_user',$level_user);
    		$this->db->delete('user_rule');
    	}
    }

    function check_akses($level_user,$id_menu){
    	$data = array('id_level_user'=>$level_user,'id_menu'=>$id_menu);
    	$chek = $this->db->get_where('user_rule',$data);
    	if($chek->num_rows()>0){
    		echo "checked";
    	}
    }

    function profile(){
    		$data = array(
			'record'=>$this->Model_Users->log()
			);
			$data['chart']=$this->Model_Dashboard->total_Maintenance();
    	$this->template->load('template','Users/profile',$data);
    }

   
}
