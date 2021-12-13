<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(0);

class Authentication extends MY_Controllerreader {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('tank_auth', 'session');
        $this->load->model('Book_m');
    }

    function index($book_type = '', $book_id = '', $vol_id = '', $user_id = '', $login = '', $userType = '', $orderid = '') {

        $currentURL = current_url();
        $mainurl = explode("/", $currentURL);
        $lenvalue = count($mainurl);
        $getval = $mainurl[$lenvalue - 2];
        if ($getval == 'login') {
            $master_id = $this->uri->segment(7);
            $orderid = $this->uri->segment(8);
            $uri = $this->uri->segment(9);
            $login = $this->uri->segment(10);
            //echo $orderid; die;
            $this->session->set_userdata('login', $login);
            $userType = end($this->uri->segment_array());

            // echo $master_id."//".$orderid."//". $uri."//".$userType; die;

            $this->session->set_userdata('SingleuserType', $userType);
        } else {

            $master_id = $this->uri->segment(6);
            $orderid = $this->uri->segment(7);
            $uri = $this->uri->segment(9);
            $login = $getval;
            // echo $orderid; die;
            $this->session->set_userdata('login', $login);
            $userType = end($this->uri->segment_array());

            // echo $master_id."//".$orderid."//". $uri."//".$userType; die;

            $this->session->set_userdata('SingleuserType', $userType);
        }
//echo $this->session->userdata('SingleuserType'); die; 
        if ($master_id == "" && $uri == "") {
            $master_id = "0000000";
            $uri = "superadmin";



            // $userinfo = $this->Book_m->subuserinfo_gets($uri);
            $this->session->set_userdata(array(
                'OnlineEmailAddress' => $uri,
                'master_id' => $master_id,
                'userinfo' => $uri,
                'orderid' => $orderid
            ));
        } else {
            // echo $master_id; die;

            $this->session->set_userdata(array(
                'OnlineEmailAddress' => $uri,
                'master_id' => $master_id
            ));
            $userinfo = $this->Book_m->subuserinfo_gets($uri);

            $this->session->set_userdata(array(
                'OnlineEmailAddress' => $uri,
                'master_id' => $master_id,
                'userinfo' => $userinfo,
                'orderid' => $orderid
            ));
        }
        $flage = 0;
        if (empty($user_id)) {
            $flage = 0;
            if (empty($this->session->userdata("user_id"))) {
                $this->session->set_flashdata('message_name', 'Session has been Expired!');
                redirect(site_url('auth/login'));
            }
        } else {
            $flage = 1;
        }

        if ($flage == 0) {
            if (empty($this->session->userdata("user_id"))) {
                $this->session->set_flashdata('message_name', 'Session has been Expired!');
                redirect(site_url('auth/login'));
            }
        }

        // print_r($user_id); die;
        $this->session->set_userdata('cus_book_id', '');
        //print_r($_SESSION); die;
        $userDetail = $this->Book_m->SelectUser($user_id);
        //echo $userDetail[0]->username; die;

        /* ---------------------------Handling Single User--------------- */
        $this->session->set_userdata('sesionidvalue', session_id());
        if ($book_type == "SINGLE") {
            //echo "chill"; die;
            if ($this->Book_m->is_valid_book($book_id, $vol_id)) {
                $this->session->set_userdata('book_type', 'SINGLE');
                $this->session->set_userdata('vol_id', $vol_id);
                $this->session->set_userdata('book_id', $book_id);
                $this->session->set_userdata('user_id', $userDetail[0]->id);
                $this->session->set_userdata('username', $userDetail[0]->username);
                $this->session->set_userdata('role', 'publisher');
                $this->session->set_userdata('status', '1');
                redirect($this->config->item('player_url') . "/index.html?ver=" . APP_VERSION);
            }
        }
        /* ---------------------------Handling Multi User---------------- */
        if ($book_type == "MULTI") {
            //echo "chill"; die;
            if ($this->Book_m->is_valid_book($book_id, $vol_id)) {
                $this->session->set_userdata('book_type', 'MULTI');
                $this->session->set_userdata('book_types', 'PRIMARY');
                $this->session->set_userdata('vol_id', $vol_id);
                $this->session->set_userdata('book_id', $book_id);
                $this->session->set_userdata('user_id', $userDetail[0]->id);
                $this->session->set_userdata('username', $userDetail[0]->username);
                $this->session->set_userdata('role', 'publisher');
                $this->session->set_userdata('status', '1');

                redirect($this->config->item('player_url') . "/index.html?ver=" . APP_VERSION);
            }
        }
        /* ---------------------------Handling IP Based------------------ */
        if ($book_type == "IPBASED") {
            //echo "chill"; die;
            if ($this->Book_m->is_valid_book($book_id, $vol_id)) {
                if ($login == "login") {
                    $this->session->set_userdata('login', $login);
                }
                if ($login == "notlogin") {
                    $this->session->set_userdata('login', $login);
                }
                $this->session->set_userdata('book_type', 'IPBASED');
                $this->session->set_userdata('vol_id', $vol_id);
                $this->session->set_userdata('book_id', $book_id);
                $this->session->set_userdata('user_id', $userDetail[0]->id);
                $this->session->set_userdata('username', $userDetail[0]->username);
                $this->session->set_userdata('role', 'publisher');
                $this->session->set_userdata('status', '1');
                $this->session->set_userdata('orderid', $orderid);
                redirect($this->config->item('player_url') . "/index.html?ver=" . APP_VERSION);
            }
        }
        /* ------------------------------Handling Admin User ------------- */
        if ($book_type == "PRIMARY") {
            //echo "chill"; die;
            if ($this->Book_m->is_valid_book($book_id, $vol_id)) {
                $this->session->set_userdata('book_type', 'PRIMARY');

                $this->session->set_userdata('vol_id', $vol_id);
                $this->session->set_userdata('book_id', $book_id);

                $this->session->set_userdata('user_id', $userDetail[0]->id);
                $this->session->set_userdata('username', $userDetail[0]->username);
                $this->session->set_userdata('role', 'publisher');
                $this->session->set_userdata('status', '1');
                redirect($this->config->item('player_url') . "/index.html?ver=" . APP_VERSION);
            } else {

                $this->Read_book_message[] = "not a valid book ! please check in booklibrary </br>";
                $data['result'] = $this->Read_book_message;
                $this->load->pagetemplate('readbook_message', $data);
                exit;
            }
        } else if ($book_type == "COSTOM") {
            $custom_book_id = $book_id;
            $primary_book_detail = $this->Book_m->get_custom_book_details($book_id);
            if (!$primary_book_detail) {
                echo "not a valid book ! please check in booklibrary";
                exit;
            }

            $book_id = $primary_book_detail->m_custmbokid;
            $vol_id = $primary_book_detail->m_custbokvid;
            if ($this->Book_m->is_valid_book($book_id, $vol_id)) {
                $this->session->set_userdata('book_type', 'CUSTOM');
                $this->session->set_userdata('vol_id', $vol_id);
                $this->session->set_userdata('cus_book_id', $custom_book_id);
                $this->session->set_userdata('book_id', $book_id);
                redirect($this->config->item('player_url') . "/index.html?ver=" . APP_VERSION);
            } else {
                echo "not a valid book ! please check in booklibrary";
                exit;
            }
        } else {
            echo "not a valid book ! please check in booklibrary";
            exit;
        }
    }

    /*  public function timeout(){
      $userid=$this->session->userdata("user_id");
      $booktype=$this->session->userdata('book_type');
      $SingleuserType=$this->session->userdata('SingleuserType');
      $login=$this->session->userdata('login');
      //  echo $userType; die;
      if($booktype=='IPBASED' && $SingleuserType=='SINGLE'){
      echo '1';
      }
      elseif($login=='login' && $SingleuserType=='MULTI')
      {
      echo '1';
      }
      elseif($booktype=='IPBASED'){
      echo '1';
      }
      } */

    public function timeout() {
        $userid = $this->session->userdata("user_id");
        $booktype = $this->session->userdata('book_type');
        $SingleuserType = $this->session->userdata('SingleuserType');
        $login = $this->session->userdata('login');
        // echo $userType; die;
        if ($booktype == 'IPBASED' && $SingleuserType == 'SINGLE') {
            echo '1';
        } elseif ($booktype == 'IPBASED') {
            echo '1';
        }
    }

    /* function session_timeout(){
      $this->session->sess_destroy();
      $this->load->view('sessionpopup');
      } */
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
