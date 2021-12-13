<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginModel extends CI_Model {
    private $loggedTable = 'asce_noof_login';
    function __construct() {
        parent::__construct();
    }

    // Get user information
    function get_MasterId($guid) {
        $this->db->select('*');
        $this->db->from('asce_guidmasterid');
        $this->db->where('guid=' . $guid);
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        return $query->result();
    }

    function get_Login_Type($MasterCustomerId) {
        //print_r($MasterCustomerId); die;
        $this->db->select('m_licence_type');
        $this->db->from('asce_licences');
        $this->db->where('m_masterid=' . $MasterCustomerId);
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        $result = $query->result_array();
        if(isset($result[0])){
        $result = $result [0] ['m_licence_type'];
        }
        return $result;
    }

    function updateorders($MasterCustomerId) {
        //print_r($MasterCustomerId); die;
        $update = array(
            'line_status' => 'C'
        );
        $this->db->where('master_id', $MasterCustomerId);

        $this->db->update('asce_products', $update);
    }

    function getIpaddress($ipaddress) {
        //echo"fdfd"; die;
        $this->db->select('ip_auth.low_ip,ip_auth.high_ip,ip_auth.ipauth_id,ip_auth.master_id,ip_auth.institute_id,asce_products.licence_count,asce_products.Nigotiate_count');
        $this->db->from('asce_ip_authentication as ip_auth');
        $this->db->join('asce_products', 'ip_auth.master_id=asce_products.master_id', 'left');
        $this->db->join('asce_licences', 'asce_licences.m_masterid=asce_products.master_id', 'inner');
        $this->db->join('mps_product', 'mps_product.master_product_id=asce_products.product_id', 'inner');
        $this->db->join('asce_product_book', 'asce_product_book.product_id=mps_product.product_id', 'left');
        $this->db->join('m_book', 'asce_product_book.book_id = m_book.m_bokid', 'left');
        $this->db->join('m_volume', 'm_book.m_bokid = m_volume.m_volbokid', 'left');
        $this->db->where("INET_ATON('$ipaddress') between INET_ATON(ip_auth.low_ip) and INET_ATON(ip_auth.high_ip) and asce_products.line_status='A' and asce_products.licence_type='IPBASED' and asce_products.grace_date>'" . date('Y-m-d') . "' and  ip_auth.aui_status='1'");
        $this->db->group_by('ip_auth.institute_id');
        $query = $this->db->get();
        //  echo $completeQuery = $this->db->last_query ();die;
        $allresult = $query->result();
        //echo "<pre>!!!33333";print_r($allresult);
//print_r($completeQuery); die;
        foreach ($allresult as &$ipvalues) {
            if ($ipvalues->licence_count == 'N') {
                //echo "<pre>Chull";print_r($ipvalues->licence_count);
                $ipvalues->licence_count = $ipvalues->Nigotiate_count;
            }
        }
        //echo "<pre>33333";print_r($allresult);die;
        return $allresult;
        //return $query->result ();
    }

    function getIp($sessid, $iprange_id) {
        //print_r($ip); die;
        $this->db->select('*');
        $this->db->from('asce_ip_count');
        $this->db->where('sessid="' . $sessid . '"');
        $this->db->where('ip_id="' . $iprange_id . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //print_r($completeQuery); die;	
        return $query->num_rows();
    }

    function getSesscount($sessid) {
        $this->db->select('*');
        $this->db->from('asce_userlogs');
        //$this->db->where ( 'sessid!="' . $sessid . '"' );
        $this->db->where('token="' . $sessid . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //print_r($completeQuery); die;	
        return $query->num_rows();
    }

    function getorderid($email) {
        $this->db->select('m_orderid', false);
        $this->db->from('asce_licences');
        $this->db->where('m_primaryemail', $email);
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //echo $completeQuery; die;
        return $query->result();
    }

    function getcarporatesorderid($orderid) {
        $lic = 'I';
        $this->db->select('m_primaryemail');
        $this->db->from('asce_licences');
        $this->db->where('m_orderid', $orderid);
        $this->db->where('m_custtype', $lic);
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //echo $completeQuery; die;
        return $query->result();
    }

    function getNumIp($iprange_id) {
        $this->db->select('*');
        $this->db->from('asce_ip_count');
        //$this->db->where ( 'sessid!="' . $sessid . '"' );
        $this->db->where('ip_id="' . $iprange_id . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //print_r($completeQuery); die;	
        return $query->num_rows();
    }

    function UpdateIpAddress($ip, $sessid, $iprange_id) {
        $update = array(
            'flag' => 1
        );
        $this->db->where('ipaddress', $ip);
        $this->db->where('sessid', $sessid);
        $this->db->where('ip_id', $iprange_id);
        $this->db->update('asce_ip_count', $update);
        //$completeQuery = $this->db->last_query ();
        //	echo $completeQuery; die;
    }

    function UpdateAjjaxIpAddress($sessid) {
        $update = array(
            'flag' => 1,
            'created_date' => date('Y-m-d:H:i:s')
        );
        $this->db->where('sessid', $sessid);
        $this->db->update('asce_ip_count', $update);
        return 'update';
        //$completeQuery = $this->db->last_query ();
        //	echo $completeQuery; die;
    }

    function CheckInsertip($sessid, $MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('asce_ip_count');
        $this->db->where('sessid="' . $sessid . '"');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //print_r($completeQuery); die;	
        return $query->num_rows();
    }

    function Insertip($MasterCustomerId, $ip, $sessid, $iprange_id, $currentIP) {
        //echo "anuj"; die;
        $currentRecord = $this->CheckInsertip($sessid, $MasterCustomerId);
        //echo "<pre>@";print_r($currentRecord);die;
        if ($currentRecord == 0) {
            $data = array(
                'master_id' => $MasterCustomerId,
                'ipaddress' => $ip,
                'sessid' => $sessid,
                'ip_id' => $iprange_id,
                'current_ip' => $currentIP,
                'flag' => 1,
                'created_date' => date('Y-m-d:H:i:s')
            );
            //echo "<pre>";print_r($data);die;
            $this->db->insert('asce_ip_count', $data);
        }
    }

    function GetAsceIpCount() {
        $this->db->select('*');
        $this->db->from('asce_ip_count');
        $query = $this->db->get();
        return $query->result();
    }

    function Deleteiprow($sesid) {
        $this->db->delete('asce_ip_count', array(
            'sessid' => $sesid
        ));
        return $sesid;
    }

    /* -----------------------------------Getting Master Customer Id Using GUID------------------- */

    function get_Master_CustomerIdByGUID($GUID) {
        
        $wsdl = "https://asce770prodebiz.asce.org/ascewebservices/customer.asmx?WSDL";
		try{				   
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

					
	        $cliente = new SoapClient($wsdl, $params);  // The trace param will show you errors stack
            $requestPara = array('GUID'=>$GUID);
            $req_service = $cliente->GetCustomerByGUID($requestPara);
            
            ob_start();
            echo "GUID : " .$GUID ." ";
            
            var_dump($req_service);
            $cust_result = ob_get_clean();
           
            log_message('info', 'CustomerID Info :' . $cust_result);
            
            //echo "<pre>MPS";print_r($req_service);die;
        }catch(Exception $e){
          $xml = false;
          //echo "<pre>Error";print_r($e);die;
            $req_service = (object) array('error'=>'faultError','errorvalue'=>$e);
        }
        return $req_service;
    }

    function check_Exist_MasterId($getMaster_id) {
        $this->db->select('*');
        $this->db->from('asce_licences');
        $this->db->where('m_masterid="' . $getMaster_id . '"');
        $query = $this->db->get();
        $que = $this->db->last_query();
        return $query->num_rows();
    }

public function date_compare($array1, $array2)
    {
        $t1 = strtotime($array1['EndDate']);
        $t2 = strtotime($array2['EndDate']);
        return $t2 - $t1;
    } 
    public function get_CustomerDetails_ByMasterId($getMasterId) {
        //print_r($getMasterId); die;
        if(!empty($getMasterId)) {
    try{
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

     //   $cliente = new SoapClient($wsdl, array('stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE));  // The trace param will show you errors stack
        $requestPara = array('MasterCustomerID'=>$getMasterId);
        $req_service = $cliente->ASCE_GetOrderInformation($requestPara);
        ob_start();
        echo "Masterid : " .$getMasterId." ";
        print_r($req_service);
        $cust_details_result = ob_get_clean();
        
        log_message('info', 'Customer Details Info :' . $cust_details_result);
        if(isset($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo)){
        $req_service_response = $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo;
        if(is_array($req_service_response) && isset($req_service_response[0])){
            $FinalLicense = array();
            foreach($req_service_response as $dataOfInterest){
                $EndDate = '';
                $EndDate = $dataOfInterest->GraceDate;
                $CurrentDate =  strtotime("now");
                $EndDateInTime = strtotime($EndDate);
                if($dataOfInterest->LineStatus==='A' && $CurrentDate<$EndDateInTime){
                   $FinalLicense =  $dataOfInterest;
                }
            }
            $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo = $FinalLicense;
        }
         if(count($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo) == 0){
              return false;
          }
         
//    echo "<pre>";
//print_r($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo);
//usort($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo, 'date_compare');
//print_r($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo);
//exit;

          if(count($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo) > 1){
               usort($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo, 'date_compare');
               $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo = $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo[0];
          }  

        //if (empty($req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->MasterCustomerId)) {
          //  return false;
        //} else {
            $MasterCustomerId = $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->MasterCustomerId;
            $SubCustomerId = $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->SubCustomerId;
            $CustomerType =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->CustomerType;
            $LabelName =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->LabelName;
            $FirstName =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->FirstName;
            $LastName =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->LastName;
            $PrimaryEmailAddress =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->PrimaryEmailAddress;
            $OrderNo =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->OrderNo;
            $OrderLineNo =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->OrderLineNo;
            $ProductID =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->ProductID;
            $StartDate =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->StartDate;
            $EndDate =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->EndDate;
            $GraceDate =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->GraceDate;
            $LicenseType =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->LicenseType;
            $LicenseCount =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->LicenseCount;
            $LineStatus =  $req_service->ASCE_GetOrderInformationResult->ASCE_LicenseInfo->LineStatus;

            $Alldata = array(
                'm_masterid' => $MasterCustomerId,
                'm_subcustid' => $SubCustomerId,
                'm_custtype' => $CustomerType,
                'm_lablename' => $LabelName,
                'm_firstname' => $FirstName,
                'm_lastname' => $LastName,
                'm_licence_type' => $LicenseType,
                'm_primaryemail' => $PrimaryEmailAddress,
                'm_orderid' => $OrderNo,
                'updated_date' => date('Y-m-d:h:i:s'),
                'status' => '1'
            );
            //echo "<pre>"; print_r($Alldata); die;
            $val = $this->LoginModel->check_Exist_MasterId($MasterCustomerId);
            // print_r($val); die;
            if ($val > 0) {
                $this->LoginModel->update($MasterCustomerId, $Alldata);
            } else {
                $insert = $this->LoginModel->insert($Alldata);
            }

            $StartDate = date_create($StartDate);
            $EndDate = date_create($EndDate);
            $GraceDate = date_create($GraceDate);
            $date1 = date_format($StartDate, "Y-m-d");
            $date2 = date_format($EndDate, "Y-m-d");
            $date3 = date_format($GraceDate, "Y-m-d");
            $order_arr = array(
                'master_id' => $MasterCustomerId,
                'order_id' => $OrderNo,
                'product_id' => $ProductID,
                'start_date' => $date1,
                'end_date' => $date2,
                'grace_date' => $date3,
                'licence_type' => $LicenseType,
                'licence_count' => $LicenseCount,
                'line_status' => $LineStatus,
                'updated_date' => date('Y-m-d:h:i:s')
                    //'status'=>'1'
            );
            $Row = $this->LoginModel->getOrder($MasterCustomerId,$OrderNo); 
            if ($Row > 0) {
                $this->LoginModel->UpdateOrder($MasterCustomerId, $ProductID, $order_arr);
            } else {
                $this->LoginModel->insertOrder($order_arr);
            }
            return true;
            }
    	}catch(Exception $e){
          $xml = false;
            $req_service = (object) array('error'=>'faultError','errorvalue'=>$e);
        }
        }else
        {
            return false;
        }
    }

    function insert($Alldata) {
        $this->db->insert('asce_licences', $Alldata);
    }

    function update($MasterCustomerId, $Alldata) {
        //print_r($Alldata); die;
        $this->db->where('m_masterid', $MasterCustomerId);
        $this->db->update('asce_licences', $Alldata);
        //$completeQuery = $this->db->last_query ();
        //print_r($completeQuery); die;
    }

    function getOrder($MasterCustomerId,$OrderNo=null) {
        // print_r($MasterCustomerId); die;
        $this->db->select('order_id');
        $this->db->from('asce_products');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $this->db->where('order_id', $OrderNo);
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        return $query->num_rows();
    }

    function UpdateOrder($MasterCustomerId, $order_id, $order_arr) {
        $this->db->where('master_id', $MasterCustomerId);
        $this->db->where('order_id', $order_id);
        $this->db->update('asce_products', $order_arr);
    }

    function insertOrder($order_arr) {
        $this->db->insert('asce_products', $order_arr);
    }

    function get_licence_count($MasterCustomerId) {
        $this->db->select('licence_count,Nigotiate_count');
        $this->db->from('asce_products');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $this->db->where('line_status="A"');
        $this->db->or_where('line_status="C"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        // print_r($completeQuery); die;
        $Allresult = $query->result();


        foreach ($Allresult as &$ipvalues) {
            if ($ipvalues->licence_count == 'N') {
                $ipvalues->licence_count = $ipvalues->Nigotiate_count;
            }
        }
        return $Allresult;
    }

    function UserInsert($UserInsert) {
        $this->db->insert('users', $UserInsert);
    }

    function selectUser($MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        return $query->num_rows();
    }

    function UpdateUser($MasterCustomerId, $updateuser) {
        $this->db->where('master_id', $MasterCustomerId);
        $this->db->update('users', $updateuser);
    }

    /* ---------------------Web Services Crone Jobs Query---------------------- */

    function getInfo($MasterCustomerId, $LicenseType, $OrderNo) {
        $this->db->select('*');
        $this->db->from('asce_licences');
        $this->db->where("m_masterid", $MasterCustomerId);
        //$this->db->where("m_licence_type", $LicenseType );
        $result = $this->db->get()->num_rows();
        return $result;
    }

    function getData($MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('asce_licences');
        $this->db->join('asce_products', 'asce_products.master_id=asce_licences.m_masterid', 'inner');
        $this->db->where('asce_licences.m_masterid="' . $MasterCustomerId . '"');
        $query = $this->db->get();
        return $query->result();
    }

    function getOrderUser($OrderNo, $MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('asce_products');
        $this->db->where('order_id="' . $OrderNo . '"');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $query = $this->db->get();
        //$quur=$this->db->last_query();
        //echo $quur.'<br>'; 
        return $query->num_rows();
    }

    function getByemail($MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('asce_institute_email_auth');
        $this->db->join('asce_products', 'asce_products.master_id=asce_institute_email_auth.master_id', 'inner');
        $this->db->where('asce_institute_email_auth.master_id="' . $MasterCustomerId . '" and asce_products.licence_type="MULTI" and asce_products.line_status="A"');
        $query = $this->db->get();
        $quer = $this->db->last_query();
        //echo $quer; die;
        return $query->result();
    }

    function getDate($MasterCustomerId, $OrderNo) {
        $this->db->select('*');
        $this->db->from('asce_products');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $this->db->where('order_id="' . $OrderNo . '"');
        $query = $this->db->get();
        $qq = $this->db->last_query();
        //echo $qq.'<br>'; 
        return $query->result();
    }

    function insertUser($arr_data) {
        //echo "<pre>";print_r($arr_data); die;
        $this->db->insert('asce_licences', $arr_data);
        //echo $this->db->last_query().'<br>';
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    function insertOrderUser($order_array) {
        //print_r($order_array); die;
        $this->db->insert('asce_products', $order_array);
        //echo $this->db->last_query(); die;
    }

    function UpdateCustomer($MasterCustomerId, $LicenseType, $OrderNo, $arr_data) {
        //echo "<pre>".$MasterCustomerId;print_r($arr_data); die;
        $this->db->where('m_masterid', $MasterCustomerId);
        $this->db->where('m_licence_type', $LicenseType);
        $this->db->where('m_orderid', $OrderNo);
        $this->db->update('asce_licences', $arr_data);
        //echo $this->db->last_query().'<br>';
    }

    function insertsubuser($SubUserInsert) {
        $this->db->insert('users', $SubUserInsert);
        //$completeQuery = $this->db->last_query ();
        //  echo $completeQuery; die; 
    }

    function insertipuser($SubUserInsert) {
        $this->db->insert('users', $SubUserInsert);
        //$completeQuery = $this->db->last_query ();
        //  echo $completeQuery; die; 
    }

    function insertmanagereport($ManageUserInsert) {

        $this->db->insert('asce_userlogs', $ManageUserInsert);

        //$completeQuery = $this->db->last_query ();
        // echo $completeQuery; die; 
        //$completeQuery = $this->db->last_query ();
        //  echo $completeQuery; die; 
    }

    function insertipmanagereport($ManageUserInsert) {

        $this->db->insert('asce_userlogs', $ManageUserInsert);

        //$completeQuery = $this->db->last_query ();
        // echo $completeQuery; die; 
        //$completeQuery = $this->db->last_query ();
        //  echo $completeQuery; die; 
    }

    function selectSubUser($OnlineEmailAddress) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email="' . $OnlineEmailAddress . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //echo $completeQuery; die;  
        return $query->num_rows();
    }

    function selectIPUser($LabelipName, $MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username="' . $LabelipName . '"');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //echo $completeQuery; die;  
        return $query->num_rows();
    }

    function selectIPUserReport($sessid, $MasterCustomerId) {
        $this->db->select('*');
        $this->db->from('asce_userlogs');
        $this->db->where('sessid="' . $sessid . '"');
        $this->db->where('master_id="' . $MasterCustomerId . '"');
        $query = $this->db->get();
        $completeQuery = $this->db->last_query();
        //echo $completeQuery; die;  
        return $query->num_rows();
    }

    function UpdateCustomerOrder($OrderNo, $order_array, $MasterCustomerId) {
        //print_r($order_array); die;
        $this->db->where('order_id', $OrderNo);
        $this->db->where('master_id', $MasterCustomerId);
        $this->db->update('asce_products', $order_array);
        //echo $this->db->last_query().'<br>'; die;
    }

    function fetchRecord() {
        $this->db->select('asce_products.end_date,asce_products.licence_type,asce_products.master_id,asce_licences.m_primaryemail');
        $this->db->from('asce_products');
        $this->db->join('asce_licences', 'asce_products.master_id=asce_licences.m_masterid', 'inner');
        $query = $this->db->get();
        $qq = $this->db->last_query();
        //echo $qq;
        return $query->result();
    }

    function InsertStatus($status, $master_id) {
        //echo $status."/".$master_id; die; 
        $data = array(
            'master_id' => $master_id,
            'status' => $status
        );
        $this->db->insert('asce_emailstatus', $data);
        //echo $qq=$this->db->last_query(); die;
    }

    function getStatus($master_id) {
        //echo $master_id; 
        $this->db->select('status,afterstatus');
        $this->db->from('asce_emailstatus');
        $this->db->where('master_id="' . $master_id . '"');
        $query = $this->db->get();
        //$qq=$this->db->last_query(); 
        //echo $qq; die;
        return $query->result();
    }

    function UpdateStatus($afterstatus, $master_id) {
        $data = array(
            'afterstatus' => $afterstatus
        );
        $this->db->where('master_id', $master_id);
        $this->db->update('asce_emailstatus', $data);
    }

    function UpdateEmailStatus($status, $afterstatus, $MasterCustomerId) {
        //echo $status."/".$afterstatus."/"."$MasterCustomerId"; die;
        $data = array(
            'status' => $status,
            'afterstatus' => $afterstatus
        );
        $this->db->where('master_id', $MasterCustomerId);
        $this->db->update('asce_emailstatus', $data);
    }

    function get_Master_CustomerIdByEmail($OnlineEmailAddress) {
        $this->db->select('master_id');
        $this->db->from('asce_institute_email_auth');
        $this->db->where('email="' . $OnlineEmailAddress . '"');
        $query = $this->db->get();
        $qq = $this->db->last_query();
        //echo $qq; die;
        return $query->result();
    }

    function checkMultiAdmin($MasterCustomerId, $OnlineEmailAddress) {
        //echo $OnlineEmailAddress; die;
        $lic = "I";
        $this->db->select('*');
        $this->db->from('asce_licences');
        //$this->db->join ( 'asce_licences', 'asce_institute_email_auth.master_id=asce_licences.m_masterid', 'inner' );
        $this->db->where('m_masterid="' . $MasterCustomerId . '" and m_primaryemail="' . $OnlineEmailAddress . '"');
        $this->db->where('m_custtype="' . $lic . '"');
        $query = $this->db->get();
        $qq = $this->db->last_query();
        // echo $qq; die;
        $count = count($query->result());
        if ($count > 0)
            return 'admin';
        else
            return 'subuser';
    }

    function checkCorporaitionMultiAdmin($MasterCustomerId, $OnlineEmailAddress) {
        //echo $OnlineEmailAddress; die;
        $this->db->select('m_orderid');
        $this->db->from('asce_licences');
        //$this->db->join ( 'asce_licences', 'asce_institute_email_auth.master_id=asce_licences.m_masterid', 'inner' );
        $this->db->where('m_masterid="' . $MasterCustomerId . '" and m_primaryemail="' . $OnlineEmailAddress . '"');
        $query = $this->db->get()->result();
        return $query;
        ///$qq = $this->db->last_query ();
        // echo $qq; die;
    }

    function checkOrderidMultiAdmin($orderid) {
        $licencetype = "C";
        $this->db->select('m_lastname,m_primaryemail,m_masterid');
        $this->db->from('asce_licences');
        $this->db->where('m_custtype="' . $licencetype . '" and m_orderid="' . $orderid . '"');
        $query = $this->db->get()->result();
        //print_r($query[0]); die;
        $result = $query[0]->m_lastname;
        //print_r($result); die;
        //$query->num_rows(); 
        if (is_array($query) && (!empty($result))) {
            return $query;
        } else {
            return false;
        }
    }

    function deleteSessionId($sessionId) {
        $this->db->where('sessid', $sessionId);
        $this->db->delete('asce_ip_count');
        $this->db->last_query();
    }

    /* function deleteUser($MasterCustomerId,$taskdate){
      $this ->db ->where('master_id="' . $MasterCustomerId . '" and  start_date <="'.$taskdate.'"');
      $this ->db->delete('asce_products');
      $this->db->last_query();
      } */
    function checkForExitenceByMIDDiffSesId($mid=0,$sessionId=0){
        $this->db->select('id');
        $this->db->from($this->loggedTable);
        $this->db->where(array('mastercustomerId'=>$mid));
        $this->db->where('active_sessionid <> "'.$sessionId.'"');
        $query = $this->db->get();
        //die($this->db->last_query());
        //$completeQuery = $this->db->last_query();
        $result = $query->row();
        //$result = $result [0] ['m_licence_type'];
        return $result;
    }
    function checkForExitenceByMID($mid=0,$sessionId=0){
        $this->db->select('id');
        $this->db->from($this->loggedTable);
        $this->db->where(array('mastercustomerId'=>$mid,'active_sessionid'=>$sessionId));
        $query = $this->db->get();
        //$completeQuery = $this->db->last_query();
        $result = $query->row();
        //$result = $result [0] ['m_licence_type'];
        return $result;
    }
    function saveLoggedInfo($sessionvalue,$saveLoggedInfo) {
      //$loggedTable  
       $diffId='';
       $resultID='';
      //check for existenc
      if(!empty($sessionvalue['MasterCustomermainId']))
      $diffId = $this->checkForExitenceByMIDDiffSesId($sessionvalue['MasterCustomermainId'],$saveLoggedInfo);
      if(!empty($diffId->id)){
          return ("Another session is active with this user");
      }
      if(!empty($sessionvalue['MasterCustomermainId']))
      $resultID = $this->checkForExitenceByMID($sessionvalue['MasterCustomermainId'],$saveLoggedInfo);
      if(empty($resultID->id)){
      $dataarray = array(
                            'mastercustomerId'=>$sessionvalue['MasterCustomermainId'],
                            'active_sessionid'=>$saveLoggedInfo
                        );
      if(!empty($sessionvalue['MasterCustomermainId']))
         $this->db->insert($this->loggedTable, $dataarray);
      return "success";
      }else{
            $update = array(
               'login_time' =>date("Y-m-d H:i:s")
            );
            $this->db->where('id', $resultID->id );
            if(!empty($sessionvalue['MasterCustomermainId']))
                $this->db->update($this->loggedTable, $update); 
            return "updated";
      }
      
    }
    //delete login
    function deleteLoggedInfo($sessionId) {
        $this->db->where('active_sessionid', $sessionId);
        $this->db->delete($this->loggedTable);
        $this->db->last_query();
    }
    //get all login information
    function getAllCustomerLogged() {
        $this->db->select('*');
        $this->db->from($this->loggedTable);
        $query = $this->db->get();
        return $query->result();
    }
}

?>
