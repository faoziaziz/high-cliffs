<?php





    function cmb_dinamis($name,$table,$field,$pk,$selected=null,$extra=null){
      $ci =& get_instance();
    	$cmb = "<select name='$name'  class='form-control' $extra> ";
      $data = $ci->db->get($table)->result();
      foreach($data as $row){
        $cmb .= "<option value='".$row->$pk."'";
        $cmb .= $selected==$row->$pk?'selected':'';
        $cmb .= ">".$row->$field."-".$row->$pk."</option>";
      }
    	$cmb .= "</select>";
    	return $cmb;
    }

     function cmb_activity($name,$table,$field,$pk,$selected=null,$extra=null){
      $ci =& get_instance();
      $cmb = "<select name='$name'  class='form-control' $extra> ";
      $cmb .= "<option value='-' selected disabled>Pilih</option>";
   
      $data = $ci->db->get($table)->result();
      
      foreach($data as $row){
        
        $cmb .= "<option value='".$row->$pk."'";
        $cmb .= $selected==$row->$pk?'selected':'';
        $cmb .= ">".$row->$field."-".$row->$pk."</option>";
      }
      $cmb .= "</select>";
      return $cmb;
    }
     function cmb_activity2($name,$table,$field,$pk,$selected=null,$extra=null){
      $ci =& get_instance();
      $cmb = "<select name='$name'  class='form-control' $extra> ";
      $cmb .= "<option value='-' selected disabled>Pilih</option>";
      $cmb .= "<option value='all'>Semua Tenant</option>";
      $data = $ci->db->get($table)->result();
      
      foreach($data as $row){
        
        $cmb .= "<option value='".$row->$pk."'";
        $cmb .= $selected==$row->$pk?'selected':'';
        $cmb .= ">".$row->$field."-".$row->$pk."</option>";
      }
      $cmb .= "</select>";
      return $cmb;
    }

   function cmb_user($name,$table,$field,$pk,$selected=null,$extra=null){
      $ci =& get_instance();
      $cmb = "<select name='$name'  class='form-control' $extra> ";
    
      $data = $ci->db->get($table)->result();
      foreach($data as $row){
        $cmb .= "<option value='".$row->$pk."'";
        $cmb .= $selected==$row->$pk?'selected':'';
        $cmb .= ">".$row->$field."-".$row->$pk."</option>";
      }
      $cmb .= "</select>";
      return $cmb;
    }
       function check_session(){
        $ci = & get_instance();



         $controller = $ci->uri->segment(1);
          $method = $ci->uri->segment(2);

          // chek url
          if (empty($method)) {
              $url = $controller;
          } else {
              $url = $controller . '/' . $method;
          }

    // chek id menu nya
          $menu = $ci->db->get_where('tabel_menu', array('link' => $url))->row_array();
              $cek = $ci->session->userdata('id_level_user');

        if(!empty($cek)){
           /* $chek = $ci->db->get_where('user_rule', array('id_level_user' => $cek, 'id_menu' => $menu['id']));
            if ($chek->num_rows() < 1 and $method != 'data' and $method != 'add' and $method != 'profile'  and $method != 'ajax_edit'  and $method != 'editd' and $method != 'delete') {
                echo "ANDA TIDAK BOLEH MENGAKSES MODUL INI";
                die;
            }
          */
        }
            else {
            redirect('auth/login');
        }
      }

        function check_session_login(){
        $CI = & get_instance();
        $session = $CI->session->userdata('role');
        if($session=='login'){
          redirect('welcome');
        }
      } 


      //api

      function get_api($url){

        $base_url = $url;
        $result = file_get_contents($url);
        $show = json_decode($result);
        return $show;
      }