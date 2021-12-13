<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginHandling extends CI_Controller {
    public $sentEmail=array();
    function __construct() {
        parent::__construct();
        $this->load->helper(array(
            'form',
            'url',
            'xml',
            'security',
            'directory'
        ));
        $this->load->model('LoginModel');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
        $this->lang->load('ion_auth');
        
    }

    public function index() {
         $wsdl = "https://asce770prodebiz.asce.org/ascewebservices/mps.asmx?WSDL";
		$opts = array(
								'ssl'   => array(
								'verify_peer'          => false,
								'verify_peer_name'     =>false,
								'allow_self-signed'    => true,                        
								'ciphers' => "SHA1"
							)
						);
				$streamContext = stream_context_create($opts);

				$params = array(    
							'features' => SOAP_SINGLE_ELEMENT_ARRAYS,                
							'stream_context'     => $streamContext,
							'cache_wsdl' => NULL,                    
						);

					
	        $cliente = new SoapClient($wsdl, $params);
        $req_service = $cliente->ASCE_GetOrdersInformation();
        if (empty($req_service)) {
            $this->session->set_flashdata('message', $this->lang->line('web_error'));
        } else {
            $x1 = $req_service->ASCE_GetOrdersInformationResult;
            $x1 = $x1->ASCE_LicenseInfo;
            foreach ($x1 as  $item) {
				
				echo "<pre>";print_r($item);echo "<hr>";
				
				
				if(strlen($item->LicenseCount)>1){
					
					if(is_string($item->LicenseCount) && preg_match("/[a-z]/i", $item->LicenseCount)){
						$item->LicenseCount = substr($item->LicenseCount,-1);
					}else{
						$item->LicenseCount = (int)$item->LicenseCount;
					}
					
                }
                $PrimaryEmailAddress='';
                $userType='';
                $FirstName='';
                $LastName = '';
                $LicenseType='';
                $MasterCustomerId =  $item->MasterCustomerId;
                $SubCustomerId =  $item->SubCustomerId;
                $CustomerType =  $item->CustomerType;
                $LabelName =  $item->LabelName;
                $FirstName =  $item->FirstName;
                $LastName =  $item->LastName;
                $PrimaryEmailAddress =  $item->PrimaryEmailAddress ;
                $OrderNo =  $item->OrderNo;
                $OrderLineNo =  $item->OrderLineNo;
                $ProductID =  $item->ProductID;
                $StartDate =  $item->StartDate;
                $EndDate =  $item->EndDate ;
                $GraceDate =  $item->GraceDate;
                $LicenseType =  $item->LicenseType ;
                $LicenseCount =  $item->LicenseCount ;
                $LineStatus =  $item->LineStatus ;
                $arr_data = array(
                    'm_masterid' => $MasterCustomerId,
                    'm_subcustid' => $SubCustomerId,
                    'm_custtype' => $CustomerType,
                    'm_lablename' => $LabelName,
                    'm_firstname' => $FirstName,
                    'm_lastname' => $LastName,
                    'm_licence_type' => $LicenseType,
                    'm_primaryemail' => $PrimaryEmailAddress,
                    'm_orderid' => $OrderNo,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'status' => '1'
                );
                //echo "anuj<pre>";print_r($arr_data); die;
                $StartDate = date_create($StartDate);
                $EndDate = date_create($EndDate);
                $GraceDate = date_create($GraceDate);
                $date1 = date_format($StartDate, "Y-m-d");
                $date2 = date_format($EndDate, "Y-m-d");
                $date3 = date_format($GraceDate, "Y-m-d");
                $order_array = array(
                    'master_id' => $MasterCustomerId,
                    'order_id' => $OrderNo,
                    'product_id' => $ProductID,
                    'start_date' => $date1,
                    'end_date' => $date2,
                    'grace_date' => $date3,
                    'licence_type' => $LicenseType,
                    'licence_count' => $LicenseCount,
                    'line_status' => $LineStatus,
                    'updated_date' => date('Y-m-d H:i:s')
                );
                //echo "anuj<pre>";print_r($order_array); die;
                $dataId = $this->LoginModel->getInfo($MasterCustomerId, $LicenseType, $OrderNo);
                //echo "anuj";  print_r($dataId); die;
                $to_email = $PrimaryEmailAddress;
                //$to_email='anujmn@gmail.com';
                $userType = $LicenseType;
                $data = array();
                $data['name'] = array(
                    'firstname' => $FirstName,
                    'lastname' => $LastName
                );
                $subject = 'Thank you for subscribing to ASCE 7 Online Platform';
                $StartDate = strtotime($date1);
                $taskdate = strtotime('2018-3-5');
                //$deleteUser=$this->LoginModel->deleteUser($MasterCustomerId,$taskdate);
                if ($StartDate >= $taskdate) {
                    if ($dataId > 0) {
                        $dataUpdated = $this->LoginModel->UpdateCustomer($MasterCustomerId, $LicenseType, $OrderNo, $arr_data);
                        /*if ($userType == 'MULTI') {
                                $body = $this->load->view('templatemessage', $data, TRUE);
                                $this->SendEmail($to_email, $subject, $body);
                            }*/
                    } else {
                        $dataInserted = $this->LoginModel->insertUser($arr_data);
                        if ($dataInserted) {
                            if ($userType == 'MULTI') {
                                $body = $this->load->view('templatemessage', $data, TRUE);
                                $this->SendEmail($to_email, $subject, $body);
                            }
                        }
                    }
                }
                $order = $this->LoginModel->getOrderUser($OrderNo, $MasterCustomerId);
                //echo "hello"; print_r($order); die;
                if ($StartDate > $taskdate) {
                    if ($order > 0) {
                        $this->LoginModel->UpdateCustomerOrder($OrderNo, $order_array, $MasterCustomerId);
                    } else {
                        $this->LoginModel->insertOrderUser($order_array);
                        if (isset($userType) && $userType == 'MULTI') {
                                $body = $this->load->view('templatemessage', $data, TRUE);
                                $this->SendEmail($to_email, $subject, $body);
                            }
                    }
                }
            }
        }
    }

    public function unset_session_data() {
          $url = "https://asce770prodebiz.asce.org/ASCEWebApp/SignIn/Signin.aspx?logoff=Y&ASCEURL=" . base_url();
        
        $this->session->unset_userdata('validlogin');
        $this->session->unset_userdata('GUID');
        $this->session->unset_userdata('MasterCustomerId');
        $this->session->unset_userdata('LicenceInfo');
        $this->session->unset_userdata('all');
        $this->session->unset_userdata('fullname');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('message');
        $this->session->unset_userdata('notsubcribed');
        $this->session->unset_userdata('bookmasterid');
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('SingleuserType');
        $this->session->unset_userdata('isAdmin');
        $this->session->unset_userdata('carporationame');
        $this->session->unset_userdata('çarporationmasterid');
        $this->session->unset_userdata('OnlineEmailAddress');
        $this->session->unset_userdata('MasterCustomerId');
        $this->session->unset_userdata('MasterCustomermainId');
        //$this->session->sess_destroy();
        //$content=$this->getUrlContent($url);
        $AllRequest = $_REQUEST['showpop'];
        if($AllRequest==1){
            redirect($url.'product?showpop=1', 'refresh');
        }else{
            redirect($url, 'refresh');
        }
        
        
        redirect('Product', 'refresh');
    }

    public function sessiondestroy() {
        $url = "https://asce770prodebiz.asce.org/ASCEWebApp/SignIn/Signin.aspx?logoff=Y&ASCEURL=" . base_url();
        //before destroy session clean the key for login other admin
        $sesionid = session_id();
        if(!empty($sesionid))
            $alertResponse = $this->LoginModel->deleteLoggedInfo($sesionid);
        $this->session->sess_destroy();
        redirect($url, 'refresh');
        redirect('Product', 'refresh');
    }

    function getUrlContent($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        echo $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode >= 200 && $httpcode < 300) ? $data : false;
    }

    //Abhinesh Pathak <abhinesh.pathak@mps-in.com>
    public function SendEmail($to_email, $subject, $body) {
        $multiadminoredrid = $this->LoginModel->getorderid($to_email);
        $carporateoredrid = $this->LoginModel->getcarporatesorderid($multiadminoredrid[0]->m_orderid);
        if(isset($carporateoredrid[0]->m_primaryemail) && (!in_array($carporateoredrid[0]->m_primaryemail,$this->sentEmail))){
            $this->sentEmail[] = $carporateoredrid[0]->m_primaryemail;
            
            $to_email = $carporateoredrid[0]->m_primaryemail;
            //$to_email = 'rahul.tiwari@mpslimited.com';
            //$from=$this->config->item('from');
            $this->email->to($to_email);
            $this->email->bcc("rahul.tiwari@mpslimited.com");
            //$this->email->from('ASCE Publications', 'ascelibrary@asce.org');
            $this->email->from('ascelibrary@asce.org', 'ASCE Publications');
            $this->email->subject($subject);
            $this->email->message($body);
            $this->email->send();
        }
        //echo $this->email->print_debugger();die;
    }

}

?>
