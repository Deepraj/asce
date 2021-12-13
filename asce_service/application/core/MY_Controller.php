<?php
//require_once SYSDIR . '/libraries/Session/Session.php';
class MY_Controller extends CI_Controller  {
function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		 $this->load->helper('form');
		$this->load->library('session');
		  //print_r($_SESSION);die;
		  $userdata = $this->session->get_userdata('user_id');
		  //echo "<pre>Jio";print_r($this->session);die;
		  //echo $this->session->userdata("user_id");echo "asdsa";die;
                  $ITLOGINVALUE = $this->session->userdata("login");
		  if(empty($this->session->userdata("user_id"))){
		    $this->session->set_flashdata('message_name', 'Session has been Expired!');
		   //secho "asdasd";die;
		     //$this->load->view('login_form');
              redirect(site_url('auth/login'));
	}
        elseif($ITLOGINVALUE=='notlogin'){
            $this->session->sess_destroy();
            ?>
            <script>
                window.location.href='';
            </script>
            <?php
           // $this->session->set_flashdata('message_name', 'Access denied');
           // $this->session->unset_userdata('username');
            //$this->session->unset_userdata('user_id');
           // $this->session->unset_userdata('status');
              //redirect($_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']);
              //redirect('http://localhost:8080/asce-project/asce_service/index.php/auth/login');
        }
        else{
	
		
	}
}
}
class MY_Controllerreader extends CI_Controller  {
function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		 $this->load->helper('form');
		$this->load->library('session');
		  //print_r($_SESSION);die;
		  //$userdata = $this->session->get_userdata('user_id');
		  //echo "<pre>Jio";print_r($userdata['user_id']);die;
		  //echo $this->session->userdata("user_id");echo "asdsa";die;
		  /* if(empty($this->session->userdata("user_id"))){
		    $this->session->set_flashdata('message_name', 'Session has been Expired!');
		   //secho "asdasd";die;
		     //$this->load->view('login_form');
              redirect(site_url('auth/login'));
	}else{
	
		
	} */
}
}
?>