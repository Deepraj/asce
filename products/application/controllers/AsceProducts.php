<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class AsceProducts extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		// Construct the parent class
		parent::__construct ();
		$this->load->helper ( array ('form','url','xml','security','directory' ) );
		$this->load->database ();
		$this->load->library(array('email'));
		$this->load->library ( 'session' );
		$this->load->library ( 'encrypt' );
		$this->load->model ( 'LoginModel' );
		$this->load->model ( 'ProductModel' );
		$this->load->library ( 'template' );
		$this->lang->load('ion_auth');
		
	}

	public function index() {
		
		
		/* --------------------------------User Handling-------------------------------- */
		
		
			
			/* ------------------------------------End-------------------------------------- */
			//$this->session->unset_userdata ( 'MasterCustomerId' );
			//$this->session->unset_userdata ( 'ip' );
			//$this->session->unset_userdata ( 'validlogin' );
			//print_r( $_SESSION);	die;
			$currentIP = $this->input->ip_address ();
			$currentIP = trim ( $currentIP );		
			
			$this->session->set_userdata('validsubscription', 'N');
			//echo ($this->input->valid_ip($aa)?'Valid':'Not Valid');
			//echo $currentIP; die;
			$url=base_url()."index.php/product";
			$data['ipstatus']  = $this->ProductModel->check_ip ($currentIP);
		//print_r($data['ipstatus'][0]->aui_status); die;
		
			$data ['productList'] = $this->ProductModel->get_book ();
			 if($this->input->post('submit')){ 
                             
                    $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
                    $secret = $this->config->item('google_secret');

                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $currentIP;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $status = json_decode($output, true);
                    if ($status['success']) {
                         $email= $this->input->post('email');
			  $FirstName= $this->input->post('FirstName');
			  $LastName= $this->input->post('LastName');
			  $Company= $this->input->post('Company');
			  $Numberofsites= $this->input->post('Numberofsites');
			  
			 $to_email='gltestasce@gmail.com'; 
			$body="Email: ".$email."<br>FirstName: ".$FirstName."<br>LastName: ".$LastName."<br>Company: ".$Company."<br>Numberofsites: ".$Numberofsites;  
			$this->email->to($to_email);
			//$this->email->from('info@mpstechnologies.com');
                        $this->email->from('ascelibrary@asce.org','ASCE Publications');
			$this->email->subject('Request for Corporate Access Quotes Email');
			$this->email->message($body);
			$this->email->set_mailtype("html");
			$send=$this->email->send();
			$this->email->clear();	  
            $msg1= "<h5><strong>Your request has been submitted.</strong></h5>";
			$this->session->set_flashdata('bulkimportmessage',$msg1);
                    } else {
                        $this->session->set_flashdata('bulkimportmessage', 'Sorry Google Recaptcha Unsuccessful!!');
                    }
	}	
	
	$loginwithip = '';
	$IPS = $this->LoginModel->getIpaddress($currentIP);
	//print_r($IPS); die;
	if ($IPS) {
	    $loginwithip = "loginwithip";
	}
	/* --------------------------------User Handling-------------------------------- */
	if (!empty($this->session->userdata('validlogin')) || !empty($_REQUEST ['GUID']) ) {
	    if($this->session->userdata('validlogin')){
	        $GUID = $this->session->userdata('validlogin');
	    } else {
	        if(!empty($_REQUEST ['GUID']))
	        {
	            $GUID =$_REQUEST ['GUID'];
	            $this->session->set_userdata('validlogin', $_REQUEST ['GUID']);
	        }
	    }
	    $req = $this->LoginModel->get_Master_CustomerIdByGUID($GUID);
	    //echo "<pre>ddddddd";print_r($req);die;
	    if(isset($req->error) && ($req->error=='faultError')){
	        
	        //send mail to admin for API issue
	        $this->load->library('email');
	        $this->email->from('ascelibrary@asce.org', 'ASCE Publications');
	        $this->email->to(array('AMSDevelopers@asce.org','cvalliere@asce.org'));
	        //$this->email->to('pandey.shweta@mpslimited.com');
	        //$this->email->to('pandey.shweta@mpslimited.com');
	        $this->email->subject('Problem with Personify API of ASCE');
	        $this->email->message('Hi Team,<br/>ASCE online system getting the error right now<br/>.'.$req->errorvalue."<br/>Please look in to on priority.<br/><br/>Thanks<br/>ASCE Team.");
	        $this->email->send();
	        redirect('LoginHandling/unset_session_data?showpop=1', 'refresh');
	    }else{
	        //echo "<pre>Response"; print_r($req); die;
	        $MasterCustomerId = isset($req->GetCustomerByGUIDResult->MasterCustomerId) ? $req->GetCustomerByGUIDResult->MasterCustomerId : null;
	        $this->session->set_userdata(array('MasterCustomermainId' => $MasterCustomerId));
	        $LabelName = isset($req->GetCustomerByGUIDResult->LabelName)  ? $req->GetCustomerByGUIDResult->LabelName  : null;
	        $FirstName = isset($req->GetCustomerByGUIDResult->FirstName)  ? $req->GetCustomerByGUIDResult->FirstName  : null;
	        $LastName = isset($req->GetCustomerByGUIDResult->LastName)  ? $req->GetCustomerByGUIDResult->LastName  : null;
	        $OnlineEmailAddress = isset($req->GetCustomerByGUIDResult->PrimaryEmailAddress)  ? $req->GetCustomerByGUIDResult->PrimaryEmailAddress  : null;
	        if (!empty($this->LoginModel->get_Master_CustomerIdByEmail($OnlineEmailAddress))) {
	            $emailValue = $this->LoginModel->get_Master_CustomerIdByEmail($OnlineEmailAddress);
	            $MasterCustomerId = $emailValue [0]->master_id;
	            //echo $MasterCustomerId; die;
	        }
	        $checkAdmin = $this->LoginModel->checkMultiAdmin($MasterCustomerId, $OnlineEmailAddress);
	        $all = "all";
	        $fullname = $FirstName . '&nbsp;' . $LastName;
	        $carporationame = $carporationmasterid= $carorderid= '';
	        if ($checkAdmin == 'admin') {
	            $orderid = $this->LoginModel->checkCorporaitionMultiAdmin($MasterCustomerId, $OnlineEmailAddress);
	            $carorderid = $orderid[0]->m_orderid;
	            $CarporationAdmin = $this->LoginModel->checkOrderidMultiAdmin($orderid[0]->m_orderid);
	            // print_r( $CarporationAdmin); die;
	            $carporationmasterid = $CarporationAdmin[0]->m_masterid;
	            //echo $carporationmasterid; die;
	            $carporationame = $CarporationAdmin[0]->m_lastname;
	        }
	        $this->session->set_userdata(array('MasterCustomerId' => $MasterCustomerId, 'LabelName' => $LabelName, 'email' => $OnlineEmailAddress, 'OnlineEmailAddress' => $OnlineEmailAddress, 'isAdmin' => $checkAdmin, 'all' => $all, 'fullname' => $fullname, 'carporationame' => $carporationame, 'çarporationmasterid' => $carporationmasterid, 'orderid' => $carorderid));
	        //$m= $this->session->userdata('MasterCustomerId');
	        // print_r($m); die;
	        $datetime = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
	        $fullusername = $FirstName . $LastName;
	        $date = date_create($datetime);
	        $fromdate = date_format($date, 'Y-m-d');
	        $sessid = session_id();
	        $sesscount = $this->LoginModel->getSesscount($this->session->userdata('validlogin'));
	        $email = $this->session->userdata('email');
	        $master_id = $MasterCustomerId;
	        $user_role = $this->session->userdata('isAdmin');
	        if ($sesscount == 0) {
	            $ManageUserInsert = array('user_name' => $fullusername, 'master_id' => $master_id, 'email' => $email, 'ip' => $_SERVER[REMOTE_ADDR], 'token' => $this->session->userdata('validlogin'), 'referral_url' => $_SERVER[REQUEST_URI], 'sessid' => $sessid, 'user_role' => $user_role, 'creat_date' => $datetime, 'start_date' => $fromdate);
	            $this->LoginModel->insertmanagereport($ManageUserInsert);
	        }
	        
	        if ($checkAdmin == 'subuser') {
	            $datas = $this->LoginModel->selectSubUser($OnlineEmailAddress);
	            if ($datas == 0) {
	                $SubUserInsert = array('master_id' => $this->session->userdata('MasterCustomermainId'), 'username' => $LabelName, 'email' => $OnlineEmailAddress);
	                //print_r($SubUserInsert); die;
	                $this->LoginModel->insertsubuser($SubUserInsert);
	            }
	        }
	        //echo "<pre>".session_id();print_r($_SESSION);die;
	        //insertion for current logged in user
	        $sesionid = session_id();
	        $alertResponse = $this->LoginModel->saveLoggedInfo($_SESSION,$sesionid);
	        if($alertResponse=='Another session is active with this user'){
	            ?>
                  <script>  
                alert("Another session is active with this user");
                </script>
                <?php
                redirect('LoginHandling/sessiondestroy', 'refresh');
            }
            $type = (isset($_REQUEST ['type'])) ? $_REQUEST ['type'] : null;
            if (($type == 'cnt') || $type == null) {
                $val = $this->LoginModel->check_Exist_MasterId($MasterCustomerId);
                if (empty($val) && $type == 'cnt') {
                    $this->template->load ( 'pagetemplate/header', 'ProductList' );
                    $this->load->view ( 'AsceDashbord',$data);
                    $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                } else {
                    //echo $MasterCustomerId; die;
                    $ReqMasterId = $this->LoginModel->get_CustomerDetails_ByMasterId($MasterCustomerId);
                    //var_dump($ReqMasterId);exit;
                    if(isset($ReqMasterId->error) && ($ReqMasterId->error=='faultError')){
                
                        //send mail to admin for API issue
                        $this->load->library('email');
                        $this->email->from('ascelibrary@asce.org', 'ASCE Publications');
                        $this->email->to(array('AMSDevelopers@asce.org','cvalliere@asce.org'));
                        //$this->email->to('pandey.shweta@mpslimited.com');
                        $this->email->subject('Problem with Personify API of ASCE');
                        $this->email->message('Hi Team,<br/>ASCE online system getting the error right now<br/>.'.$req->errorvalue."<br/>Please look in to on priority.<br/><br/>Thanks<br/>ASCE Team.");
                        $this->email->send();
                        //destroying session
                        redirect('LoginHandling/unset_session_data?showpop=1', 'refresh');
                    }else{
                    
                    
                        //echo "anuj"; print_r($ReqMasterId); die;
                        if ($ReqMasterId == false) {
                        if ($ReqMasterId == false && !empty($loginwithip == "loginwithip")) {
                            //echo"dfdfdf"; die;
                            $detail = $this->ProductModel->notsubcribedproduct($MasterCustomerId);
                            //print_r($detail); die;
                            $LicenceInfo = $detail [0]->m_licence_type;
                            //$this->session->set_userdata ( array ('LicenceInfo' => $LicenceInfo ) );
                            if ($LicenceInfo == "") {
                                //echo"dsds"; die;
                                $LabelipName = $this->session->userdata('LabelipName');
                                //echo $LabelipName; die; 
                                $info = $this->ProductModel->getnoteorderid($LabelipName);
                                //print_r($info[0]->m_orderid); die;

                                $orderid = $info[0]->m_orderid;
                                $login = "login";
                                $LicenceInfo = "SINGLE";
                            }
                            if ($LicenceInfo != "") {
                                $LabelipName = $this->session->userdata('LabelipName');
                                //echo $LabelipName; die; 
                                $info = $this->ProductModel->getnoteorderid($LabelipName);
                                //print_r($info[0]->m_orderid); die;


                                $orderid = $info[0]->m_orderid;
                                $login = "login";
                            }
                            $fname = $detail [0]->m_firstname;
                            $lname = $detail [0]->m_lastname;
                            $fulname = $fname . " " . $lname;
                            $this->session->set_userdata(array('fullname' => $fulname, 'LicenceInfo' => $LicenceInfo, 'login' => $login, 'orderid' => $orderid));
                            $IPS = $this->LoginModel->getIpaddress($currentIP);
                            if (!empty($IPS) && !empty($GUID)) {

                                //echo"dsff"; die;
                                $high_ip = $IPS [0]->high_ip;
                                $high_ip = ip2long($high_ip);
                                $low_ip = $IPS [0]->low_ip;
                                $low_ip = ip2long($low_ip);
                                $ip = ip2long($currentIP);
                                $count = $IPS [0]->licence_count;
                                // print_r($count); die;
                               // $getIp = $this->LoginModel->getIp($ip);
                                $notsubcribed = "notsubcribed";
                                $counter = 0;
                                if ($ip <= $high_ip && $low_ip <= $ip) {
                                    $MasterCustomerId = $IPS [0]->master_id;
                                    $detail = $this->ProductModel->getDetail($MasterCustomerId);
                                    $UserName = $detail [0]->m_lablename;
                                    $LicenceInfo = $detail [0]->m_licence_type;
                                    $this->session->set_userdata(array('MasterCustomerId' => $MasterCustomerId, 'LabelipName' => $UserName, 'ip' => $ip, 'notsubcribed' => $notsubcribed));
                                    //print_r( $_SESSION); die;
                                    $msg = "You do not have access to any active licenses, please contact ASCE Customer Service
					for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am -
					6:00 pm ET or <a href='mailto:ascelibrary@asce.org'>ascelibrary@asce.org</a>";
                                    if ($count == 'N') {

                                        $this->session->set_flashdata('message', $msg);
                                        $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                        $this->load->view ( 'AsceDashbord',$data);
                                        $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                    } else if (empty($this->ProductModel->get_Subscribed_Book($MasterCustomerId))) {
                                        $this->session->set_flashdata('message', $msg);
                                        $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                        $this->load->view ( 'AsceDashbord',$data);
                                        $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                    } else {
                                        $getnumIp = $this->LoginModel->getNumIp($MasterCustomerId);
                                        // print_r($getnumIp); die;
                                        $counter = $getnumIp;
                                        // print_r($counter); die;
                                        $bookids = 0;
                                        // $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product ( $MasterCustomerId );
                                        $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                        if (!empty($data ['subscribedBookList'])) {
                                            $bookids = array();
                                            foreach ($data ['subscribedBookList'] as $subsBook) {
                                                array_push($bookids, $subsBook->m_bokid);
                                            }
                                        }
                                        $this->session->set_userdata('validsubscription', 'Y');
                                        $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                        $this->load->view ( 'AsceDashbord',$data);
                                        $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                    }
                                }
                            }
                        } else {

                            $LicenceType = $this->LoginModel->get_Login_Type($MasterCustomerId);
                            $updateorder = $this->LoginModel->updateorders($MasterCustomerId);
                            //  echo 	$LicenceType; die;	
                            if(isset($LicenceType)){
                            $this->session->set_userdata(array('LicenceInfo' => $LicenceType));
                            }
                            $this->session->set_flashdata('message', $this->lang->line('access_error'));
                            $this->template->load ( 'pagetemplate/header', 'ProductList' );
                            $this->load->view ( 'AsceDashbord',$data);
                            $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                        }
                    } else {

                        $LicenceType = $this->LoginModel->get_Login_Type($MasterCustomerId);
                        // echo "anuj".$LicenceType; die;
                        $this->session->set_userdata(array('LicenceInfo' => $LicenceType));
                        if (!empty($this->LoginModel->get_licence_count($MasterCustomerId))) {
                            $count = $this->LoginModel->get_licence_count($MasterCustomerId);
                            //print_r($count); die;
                            if ($count [0]->licence_count == 'N' && empty($loginwithip == "loginwithip")) {

                                $this->session->set_flashdata('message', $this->lang->line('access_error'));
                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                $this->load->view ( 'AsceDashbord',$data);
                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                            } else if (empty($this->ProductModel->get_Subscribed_Product($MasterCustomerId)) && empty($loginwithip == "loginwithip")) {
                                $this->session->set_flashdata('message', $this->lang->line('access_error'));
                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                $this->load->view ( 'AsceDashbord',$data);
                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                            } else if (empty($this->ProductModel->get_Subscribed_Book($MasterCustomerId)) && empty($loginwithip == "loginwithip")) {

                                $this->session->set_flashdata('message', $this->lang->line('access_error'));
                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                $this->load->view ( 'AsceDashbord',$data);
                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                            } else {

                                /* ---------------------Single User----------------------------------------------- */
                                if ($LicenceType == 'SINGLE' && empty($loginwithip == "loginwithip")) {
                                    //echo "dsdsd"; die;
                                    $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                    //echo "<pre>"; print_r($data ['subscribedProductList']); die;
                                    $fname = $data ['subscribedProductList'] [0]->m_firstname;
                                    $lname = $data ['subscribedProductList'] [0]->m_lastname;
                                    $fulname = $fname . " " . $lname;
                                    $login = "login";
                                    $email = $data ['subscribedProductList'] [0]->m_primaryemail;
                                    $this->session->set_userdata(array('email' => $email, 'fullname' => $fulname, 'login' => $login));
                                    $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedBookList']); die;
                                    $bookids = array();
                                    foreach ($data ['subscribedBookList'] as $subsBook) {
                                        array_push($bookids, $subsBook->m_bokid);
                                    }
                                    // $bookids=implode(',', $bookids);
                                    $this->session->set_userdata('validsubscription', 'Y');
                                    $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                    $this->load->view ( 'AsceDashbord',$data);
                                    $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                } elseif ($LicenceType == 'SINGLE' && !empty($loginwithip == "loginwithip")) {     //echo $currentIP; die;
                                    $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                    $fname = $data ['subscribedProductList'] [0]->m_firstname;
                                    $lname = $data ['subscribedProductList'] [0]->m_lastname;
                                    $LicenceInfo = $data ['subscribedProductList'] [0]->licence_type;
                                    $fulname = $fname . " " . $lname;
                                    $login = "login";
                                    $email = $data ['subscribedProductList'] [0]->m_primaryemail;
                                    // echo "<pre>"; print_r($data ['subscribedProductList']); die;
                                    $this->session->set_userdata(array('email' => $email, 'fullname' => $fulname, 'LicenceInfo' => $LicenceInfo, 'login' => $login, 'bookmasterid' => $MasterCustomerId));
                                    $data ['subscribedBookList1'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedBookList1']); die;
                                    $bookids = array();
                                    foreach ($data ['subscribedBookList1'] as $subsBook) {
                                        array_push($bookids, $subsBook->m_bokid);
                                    }
                                    $data ['productList1'] = $this->ProductModel->get_book($bookids);
                                    //echo "<pre>"; print_r($data ['productList']); 
                                    //data
                                    //$this->load->view ( 'ProductList1', $data );
                                    $IPS = $this->LoginModel->getIpaddress($currentIP);
                                    if (!empty($IPS) && !empty($GUID)) {
                                        //echo"dsff"; die;
                                        $high_ip = $IPS [0]->high_ip;
                                        $high_ip = ip2long($high_ip);
                                        $low_ip = $IPS [0]->low_ip;
                                        $low_ip = ip2long($low_ip);
                                        $ip = ip2long($currentIP);
                                        $count = $IPS [0]->licence_count;
                                        // print_r($count); die;
                                     //   $getIp = $this->LoginModel->getIp($ip);
                                        $counter = 0;
                                        if ($ip <= $high_ip && $low_ip <= $ip) {
                                            $MasterCustomerId = $IPS [0]->master_id;
                                            $detail = $this->ProductModel->getDetail($MasterCustomerId);
                                            $UserName = $detail [0]->m_lablename;
                                            $LicenceInfo = $detail [0]->m_licence_type;
                                            $this->session->set_userdata(array('MasterCustomerId' => $MasterCustomerId, 'LabelipName' => $UserName, 'ip' => $ip));
                                            //print_r( $_SESSION); die;
                                            $msg = "You do not have access to any active licenses, please contact ASCE Customer Service
					for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am -
					6:00 pm ET or <a href='mailto:ascelibrary@asce.org'>ascelibrary@asce.org</a>";
                                            if ($count == 'N') {
                                                $this->session->set_flashdata('message', $msg);
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            } else if (empty($this->ProductModel->get_Subscribed_Book($MasterCustomerId))) {
                                                $this->session->set_flashdata('message', $msg);
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            } else {
                                                $getnumIp = $this->LoginModel->getNumIp($MasterCustomerId);
                                                // print_r($getnumIp); die;
                                                $counter = $getnumIp;
                                                // print_r($counter); die;
                                                $bookids = 0;
                                                // $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product ( $MasterCustomerId );
                                                $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                                if (!empty($data ['subscribedBookList'])) {
                                                    $bookids = array();
                                                    foreach ($data ['subscribedBookList'] as $subsBook) {
                                                        array_push($bookids, $subsBook->m_bokid);
                                                    }
                                                }
                                                $this->session->set_userdata('validsubscription', 'Y');
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            }
                                        }
                                    }
                                    /* ----------------------------------------Multi User License--------------------------- */
                                } else if ($LicenceType == 'MULTI' && !empty($loginwithip == "loginwithip")) {

                                    $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedProductList']); die;
                                    $fname = $data ['subscribedProductList'] [0]->m_firstname;
                                    $lname = $data ['subscribedProductList'] [0]->m_lastname;
                                    $orderid = $data['subscribedProductList'] [0]->m_orderid;
                                    $LicenceInfo = $data ['subscribedProductList'] [0]->licence_type;
                                    $fulname = $fname . " " . $lname;
                                    $login = "login";
                                    $email = $data ['subscribedProductList'] [0]->m_primaryemail;
                                    $this->session->set_userdata(array('email' => $email, 'fullname' => $fulname, 'LicenceInfo' => $LicenceInfo, 'login' => $login, 'bookmasterid' => $MasterCustomerId, 'orderid' => $orderid));
                                    //print_r($_SESSION); die;
                                    $data ['subscribedBookList1'] = $this->ProductModel->get_Subscribed_Book_Multi($MasterCustomerId);
                                    //echo "<pre>"; print_r($data ['subscribedBookList']); die;
                                    $data ['NonSubscribeBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                    $bookids = array();
                                    foreach ($data ['NonSubscribeBookList'] as $subsBook) {
                                        array_push($bookids, $subsBook->m_bokid);
                                    }
                                    // $bookids=implode(',', $bookids);
                                    if (!empty($bookids)) {
                                        $data ['productList1'] = $this->ProductModel->get_book($bookids);
                                    }
                                    $val = $this->ProductModel->EmailAuth($MasterCustomerId);
                                    $IPS = $this->LoginModel->getIpaddress($currentIP);
                                    if (!empty($IPS) && !empty($GUID)) {
                                        //echo"dsff"; die;
                                        $high_ip = $IPS [0]->high_ip;
                                        $high_ip = ip2long($high_ip);
                                        $low_ip = $IPS [0]->low_ip;
                                        $low_ip = ip2long($low_ip);
                                        $ip = ip2long($currentIP);
                                        $count = $IPS [0]->licence_count;
                                        // print_r($count); die;
                                     //   $getIp = $this->LoginModel->getIp($ip);
                                        $counter = 0;
                                        if ($ip <= $high_ip && $low_ip <= $ip) {
                                            $MasterCustomerId = $IPS [0]->master_id;
                                            $detail = $this->ProductModel->getDetail($MasterCustomerId);
                                            $UserName = $detail [0]->m_lablename;
                                            $LicenceInfo = $detail [0]->m_licence_type;
                                            $this->session->set_userdata(array('MasterCustomerId' => $MasterCustomerId, 'LabelipName' => $UserName, 'ip' => $ip));
                                            //print_r( $_SESSION); die;
                                            $msg = "You do not have access to any active licenses, please contact ASCE Customer Service
					for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am -
					6:00 pm ET or <a href='mailto:cvalliere@asce.org'>cvalliere@asce.org</a>";
                                            if ($count == 'N') {
                                                $this->session->set_flashdata('message', $msg);
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            } else if (empty($this->ProductModel->get_Subscribed_Book($MasterCustomerId))) {
                                                $this->session->set_flashdata('message', $msg);
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            } else {
                                                $getnumIp = $this->LoginModel->getNumIp($MasterCustomerId);
                                                // print_r($getnumIp); die;
                                                $counter = $getnumIp;
                                                // print_r($counter); die;
                                                $bookids = 0;
                                                $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                                $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);

                                                if (!empty($data ['subscribedBookList'])) {
                                                    $bookids = array();
                                                    foreach ($data ['subscribedBookList'] as $subsBook) {
                                                        array_push($bookids, $subsBook->m_bokid);
                                                    }
                                                }
                                                $this->session->set_userdata('validsubscription', 'Y');
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            }
                                        }
                                    }
                                } else if ($LicenceType == 'MULTI' && empty($loginwithip == "loginwithip")) {
                                    // echo "hello"; die;	      
                                    $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                    //echo "<pre>"; print_r($data ['subscribedProductList']); die;
                                    $fname = $data ['subscribedProductList'] [0]->m_firstname;
                                    $lname = $data ['subscribedProductList'] [0]->m_lastname;
                                    $orderid = $data['subscribedProductList'] [0]->m_orderid;
                                    $fulname = $fname . " " . $lname;
                                    $email = $data ['subscribedProductList'] [0]->m_primaryemail;
                                    $login = "login";
                                    $this->session->set_userdata(array('email' => $email, 'fullname' => $fulname, 'orderid' => $orderid, 'login' => $login));
                                    //print_r($_SESSION); die;
                                    $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book_Multi($MasterCustomerId);
                                    //echo "<pre>"; print_r($data ['subscribedBookList']); die;
                                    $data ['NonSubscribeBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                    $bookids = array();
                                    foreach ($data ['NonSubscribeBookList'] as $subsBook) {
                                        array_push($bookids, $subsBook->m_bokid);
                                    }
                                    // $bookids=implode(',', $bookids);
                                    $data ['productList'] = $this->ProductModel->get_book($bookids);
                                    $val = $this->ProductModel->EmailAuth($MasterCustomerId);
                                    $this->session->set_userdata('validsubscription', 'Y');
                                    $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                    $this->load->view ( 'AsceDashbord',$data);
                                    $this->template->load ( 'pagetemplate/footer', 'ProductList' );

                                    /* ----------------------------------Ip Based User---------------------------------------- */
                                } else if ($LicenceType == 'IPBASED' && !empty($loginwithip == "loginwithip")) {
                                    ///echo "sdfdfd"; die;
                                    $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedProductList']); die;
                                    $fname = $data ['subscribedProductList'] [0]->m_firstname;
                                    $lname = $data ['subscribedProductList'] [0]->m_lastname;
                                    $orderid = $data['subscribedProductList'] [0]->m_orderid;
                                    $fulname = $fname . "" . $lname;
                                    $login = "login";
                                    $email = $data ['subscribedProductList'] [0]->m_primaryemail;
                                    $this->session->set_userdata(array('email' => $email, 'fullname' => $fulname, 'login' => $login, 'orderid' => $orderid));
                                    $data ['subscribedBookList1'] = $this->ProductModel->get_Subscribed_Book_Ip($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedBookList']); die;
                                    $data ['NonSubscribeBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                    $bookids = array();
                                    foreach ($data ['NonSubscribeBookList'] as $subsBook) {
                                        array_push($bookids, $subsBook->m_bokid);
                                    }
                                    // $bookids=implode(',', $bookids);
                                    $data ['productList1'] = $this->ProductModel->get_book($bookids);
                                    $val = $this->ProductModel->EmailAuth($MasterCustomerId);
                                    $IPS = $this->LoginModel->getIpaddress($currentIP);
                                    if (!empty($IPS) && !empty($GUID)) {
                                        //echo"dsff"; die;
                                        $high_ip = $IPS [0]->high_ip;
                                        $high_ip = ip2long($high_ip);
                                        $low_ip = $IPS [0]->low_ip;
                                        $low_ip = ip2long($low_ip);
                                        $ip = ip2long($currentIP);
                                        $count = $IPS [0]->licence_count;
                                        // print_r($count); die;
                                  //      $getIp = $this->LoginModel->getIp($ip);
                                        $counter = 0;
                                        if ($ip <= $high_ip && $low_ip <= $ip) {
                                            $MasterCustomerId = $IPS [0]->master_id;
                                            $detail = $this->ProductModel->getDetail($MasterCustomerId);
                                            $UserName = $detail [0]->m_lablename;
                                            $LicenceInfo = $detail [0]->m_licence_type;
                                            $this->session->set_userdata(array('MasterCustomerId' => $MasterCustomerId, 'LabelipName' => $UserName, 'LicenceInfo' => $LicenceInfo, 'ip' => $ip));
                                            //print_r( $_SESSION); die;
                                            $msg = "You do not have access to any active licenses, please contact ASCE Customer Service
					for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am -
					6:00 pm ET or <a href='mailto:cvalliere@asce.org'>cvalliere@asce.org</a>";
                                            if ($count == 'N') {
                                                $this->session->set_flashdata('message', $msg);
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            } else if (empty($this->ProductModel->get_Subscribed_Book($MasterCustomerId))) {
                                                $this->session->set_flashdata('message', $msg);
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            } else {
                                                $getnumIp = $this->LoginModel->getNumIp($MasterCustomerId);
                                                // print_r($getnumIp); die;
                                                $counter = $getnumIp;
                                                // print_r($counter); die;
                                                $bookids = 0;
                                                // $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product ( $MasterCustomerId );
                                                $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                                if (!empty($data ['subscribedBookList'])) {
                                                    $bookids = array();
                                                    foreach ($data ['subscribedBookList'] as $subsBook) {
                                                        array_push($bookids, $subsBook->m_bokid);
                                                    }
                                                }
                                                $this->session->set_userdata('validsubscription', 'Y');
                                                $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                                $this->load->view ( 'AsceDashbord',$data);
                                                $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                            }
                                        }
                                    }
                                } else if ($LicenceType == 'IPBASED' && empty($loginwithip == "loginwithip")) {
                                    //echo "fdfdfdfd"; die;
                                    $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedProductList']); die;
                                    $fname = $data ['subscribedProductList'] [0]->m_firstname;
                                    $lname = $data ['subscribedProductList'] [0]->m_lastname;
                                    $orderid = $data['subscribedProductList'] [0]->m_orderid;
                                    $fulname = $fname . "" . $lname;
                                    $login = "login";
                                    $email = $data ['subscribedProductList'] [0]->m_primaryemail;
                                    $this->session->set_userdata(array('email' => $email, 'fullname' => $fulname, 'login' => $login, 'orderid' => $orderid));
                                    $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book_Ip($MasterCustomerId);
                                    // echo "<pre>"; print_r($data ['subscribedBookList']); die;
                                    $data ['NonSubscribeBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
                                    $bookids = array();
                                    foreach ($data ['NonSubscribeBookList'] as $subsBook) {
                                        array_push($bookids, $subsBook->m_bokid);
                                    }
                                    // $bookids=implode(',', $bookids);
                                    $data ['productList'] = $this->ProductModel->get_book($bookids);
                                    $this->session->set_userdata('validsubscription', 'Y');
                                    $this->template->load ( 'pagetemplate/header', 'ProductList' );
                                    $this->load->view ( 'AsceDashbord',$data);
                                    $this->template->load ( 'pagetemplate/footer', 'ProductList' );
                                }
                            }
                        }
                    }
                    }
                    
                }
            }
        }    
        } else if (!empty($this->LoginModel->getIpaddress($currentIP))) {
	    //print_r($_SESSION); die;
	    
	    $sessid = session_id();
	    $datetime = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
	    $date = date_create($datetime);
	    $fromdate = date_format($date, 'Y-m-d');
	    $user_role = "IPBASED";
	    $flag = 0;
	    $IPS = $this->LoginModel->getIpaddress($currentIP);
	    $iprange_id = $IPS [0]->ipauth_id;
	    //print_r($iprange_id); die;
	    if (!empty($IPS) && empty($GUID)) {
	        $high_ip = $IPS [0]->high_ip;
	        $high_ip = ip2long($high_ip);
	        $low_ip = $IPS [0]->low_ip;
	        $low_ip = ip2long($low_ip);
	        $ip = ip2long($currentIP);
	        $count = $IPS [0]->licence_count;
	        //echo $count; die;
	        $getIp = $this->LoginModel->getIp($sessid, $iprange_id);
	        //print_r($getIp); die;
	        $counter = 0;
	        if ($ip <= $high_ip && $low_ip <= $ip) {
	            $MasterCustomerId = $IPS [0]->master_id;
	            //print_r($IPS); die;
	            //echo $MasterCustomerId; die;
	            $detail = $this->ProductModel->getDetail($MasterCustomerId);
	            $UserName = $detail [0]->m_lablename;
	            $LicenceInfo = $detail [0]->m_licence_type;
	            $orderid = $detail [0]->m_orderid;
	            $datas = $this->LoginModel->selectIPUser($UserName, $MasterCustomerId);
	            if ($datas == 0) {
	                
	                $IPUserInsert = array('master_id' => $MasterCustomerId, 'username' => $UserName);
	                //print_r($SubUserInsert); die;
	                $this->LoginModel->insertipuser($IPUserInsert);
	            }
	            $datareport = $this->LoginModel->selectIPUserReport($sessid, $MasterCustomerId);
	            if ($datareport == 0) {
	                
	                $ManageUserInsert = array('master_id' => $MasterCustomerId, 'ip' => $_SERVER['REMOTE_ADDR'], 'token' => $this->session->userdata('validlogin'), 'referral_url' => $_SERVER['REQUEST_URI'], 'sessid' => $sessid, 'flag' => $flag, 'user_role' => $user_role, 'creat_date' => $datetime, 'start_date' => $fromdate);
	                $this->LoginModel->insertipmanagereport($ManageUserInsert);
	            }
	            $login = "notlogin";
	            
	            $this->session->set_userdata(array('MasterCustomerId' => $MasterCustomerId, 'LabelipName' => $UserName, 'LicenceInfo' => $LicenceInfo, 'ip' => $ip, 'orderid' => $orderid, 'login' => $login));
	            //print_r( $_SESSION); die;
	            $msg = "You do not have access to any active licenses, please contact ASCE Customer Service
					for assistance at 1-800-548-2723 or 1-703-295-6300, 8:00 am -
					6:00 pm ET or <a href='mailto:cvalliere@asce.org'>cvalliere@asce.org</a>";
	            if ($count == 'N') {
	                $this->session->set_userdata('validsubscription', 'N');
	               
	            } else if (empty($this->ProductModel->get_Subscribed_Book($MasterCustomerId))) {
	                $this->session->set_userdata('validsubscription', 'N');
	            } else {
	                $getnumIp = $this->LoginModel->getNumIp($iprange_id);
	                //print_r($getnumIp); die;
	                $counter = $getnumIp;
	                //print_r($counter); die;
	                $bookids = 0;
	                if ($getIp > 0) {
	                    //echo "dsds"; die;
	                    $this->LoginModel->UpdateIpAddress($ip, $sessid, $iprange_id);
	                    $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
	                    if (!empty($data ['subscribedBookList'])) {
	                        $bookids = array();
	                        foreach ($data ['subscribedBookList'] as $subsBook) {
	                            array_push($bookids, $subsBook->m_bokid);
	                        }
	                    }
	                    $this->session->set_userdata('validsubscription', 'Y');
	                    $this->template->load ( 'pagetemplate/header', 'ProductList' );
	                    $this->load->view ( 'AsceDashbord',$data);
	                    $this->template->load ( 'pagetemplate/footer', 'ProductList' );
	                  
	                } else {
	                    if ($count > $counter) {
	                        //$this->LoginModel->Insertip ( $MasterCustomerId, $ip,$sessid,$iprange_id,$currentIP );
	                    }
	                    // $data ['subscribedProductList'] = $this->ProductModel->get_Subscribed_Product ( $MasterCustomerId );
	                    $data ['subscribedBookList'] = $this->ProductModel->get_Subscribed_Book($MasterCustomerId);
	                    if (!empty($data ['subscribedBookList'])) {
	                        $bookids = array();
	                        foreach ($data ['subscribedBookList'] as $subsBook) {
	                            array_push($bookids, $subsBook->m_bokid);
	                        }
	                    }
	                    $this->session->set_userdata('validsubscription', 'Y');
	                    $this->template->load ( 'pagetemplate/header', 'ProductList' );
	                    $this->load->view ( 'AsceDashbord',$data);
	                    $this->template->load ( 'pagetemplate/footer', 'ProductList' );
	                   
	                }
	            }
	        }
	    }
	}
 
//        redirect('AsceDashbord', 'refresh');
	else {
			
			//print_r($data ['productList']); die;
			$this->template->load ( 'pagetemplate/header', 'ProductList' );
			$this->load->view ( 'AsceDashbord',$data);
			$this->template->load ( 'pagetemplate/footer', 'ProductList' );
		}
	}
			

	
}

?>
