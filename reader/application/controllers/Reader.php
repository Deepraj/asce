<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');
class Reader extends CI_Controller {
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->database();
		$this->load->model('ReaderModel');
		$this->load->model('DataUpdate_Model');	
		$this->load->library('email');
		$this->load->library('session');
	}
	public function index()
	{
		 // $lvar="http://".$_SERVER['HTTP_HOST'];
/////////////////Start.Get Ip address///////////////////////////////////////		
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP')){
			$ipaddress = getenv('HTTP_CLIENT_IP');
		} else if(getenv('HTTP_X_FORWARDED_FOR')){
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		}else if(getenv('HTTP_X_FORWARDED')){
			$ipaddress = getenv('HTTP_X_FORWARDED');
		}else if(getenv('HTTP_FORWARDED_FOR')){
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		}else if(getenv('HTTP_FORWARDED')){
			$ipaddress = getenv('HTTP_FORWARDED');
		}else if(getenv('REMOTE_ADDR')){
			$ipaddress = getenv('REMOTE_ADDR');
		} else{
			$ipaddress = 'UNKNOWN';
		}
	   // $ipaddress='121.244.128.250';
		$ipaddress=trim($ipaddress);
		
////////////////////////////End Get Ip Address .Start get Master Id by GUID/////////////////////////////////		
		if(!empty($_REQUEST['GUID'])){
		
			 $wsdl = "https://secure.asce.org/PUPGCustomwebservices/customer.asmx?WSDL";
			//$int_zona = 5;
			$GUID=$_GET['GUID'];
			$cliente = new SoapClient($wsdl);
			$request='<?xml version="1.0" encoding="utf-8"?>
			<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
			  <soap12:Body>
			    <GetCustomerByGUID xmlns="http://asce.org/">
			      <GUID>'.$GUID.'</GUID>
			    </GetCustomerByGUID>
			  </soap12:Body>
			</soap12:Envelope>';
			$location='http://secure.asce.org/PUPGCustomwebservices/customer.asmx';
			$action='http://asce.org/GetCustomerByGUID';
			$version='2';
			$req=$cliente->__doRequest($request, $location, $action, $version, $one_way = 0);
			//echo "<pre>"; print_r(htmlentities($req)); die;
			//echo $req->MasterCustomerId; die;
			//echo "REQUEST:\n" . $cliente->__getLastRequest() . "\n";
			if(is_soap_fault($request)){
				echo "<h2>Web Service Not Working. Please try after some time.</h2>";
				
			}else{
			$dom = new DOMDocument();
			$dom->loadXML($req);
		    $MasterCustomerId = isset($dom->getElementsByTagName('MasterCustomerId')->item(0)->nodeValue)?$dom->getElementsByTagName('MasterCustomerId')->item(0)->nodeValue:null;
			//var_dump($MasterCustomerId);die;
		    if(!$MasterCustomerId){	
		    echo "<h2>Invalid Request Please go to  &nbsp;<a href='http://asce.mpstechnologies.com/products/'> Product List </a></h2>";
		    }else{  
		     $data['orderid']=$this->ReaderModel->getInfo($MasterCustomerId); 
		     /* echo "<pre>";print_r( $data['orderid']);
		     print_r($data['orderid'][0]->id); die; */
		       if(empty($data['orderid'][0]->m_orderid)){
		    	$MasterCustomerId = $dom->getElementsByTagName('MasterCustomerId')->item(0)->nodeValue;
		    	$SubCustomerId= $dom->getElementsByTagName('SubCustomerId')->item(0)->nodeValue;
		    	$LabelName= $dom->getElementsByTagName('LabelName')->item(0)->nodeValue;
		    	$FirstName= $dom->getElementsByTagName('FirstName')->item(0)->nodeValue;
		    	$LastName= $dom->getElementsByTagName('LastName')->item(0)->nodeValue;
		    	$PrimaryEmailAddress= $dom->getElementsByTagName('PrimaryEmailAddress')->item(0)->nodeValue;
		    	$OnlineEmailAddress= $dom->getElementsByTagName('OnlineEmailAddress')->item(0)->nodeValue;
		    	$arr_data=array(
		    			'm_masterid'=>$MasterCustomerId,
		    			'm_subcustid'=>$SubCustomerId,
		    			'm_lablename'=>$LabelName,
		    			'm_firstname'=>$FirstName,
		    			'm_lastname'=>$LastName,
		    			'm_primaryemail'=>$PrimaryEmailAddress,
		    			'm_onlineemail'=>$OnlineEmailAddress
		    	     );
		    	    if(empty($data['orderid'][0]->id)){   
		    	    $this->ReaderModel->insert($arr_data);
		    	    }
				 
		    	  redirect($lvar.'/products/');
		      	   
		     
		    }else{ 
			  
				$this->session->set_userdata(array(
								'user_id'	=> $MasterCustomerId,
								
						)); 
						
						//print_r($this->session->get_userdata());	
						//echo $this->session->userdata("user_id");echo "asdsa";die;
		      $wsdl = "https://secure.asce.org/PUPGCustomWebServices/mps.asmx?WSDL";
			  $cliente = new SoapClient($wsdl);
				$request_service='<?xml version="1.0" encoding="utf-8"?>
				<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
				  <soap12:Body>
				    <ASCE_GetOrderInformation xmlns="http://asce.org/">
				      <MasterCustomerID>'.$MasterCustomerId.'</MasterCustomerID>
				    </ASCE_GetOrderInformation>
				  </soap12:Body>
				</soap12:Envelope>';
				//print_r(htmlentities($request_service));  die;
				$location='https://secure.asce.org/PUPGCustomWebServices/mps.asmx';
				$action='https://secure.asce.org/PUPGCustomWebServices/mps.asmx?op=ASCE_GetOrderInformation';
				$version='2';
				$req_service=$cliente->__doRequest($request_service, $location, $action, $version, $one_way = 0);
				//print_r(htmlentities($req_service));
				//echo "REQUEST:\n" . $cliente->__getLastRequest() . "\n";
				 $domdata = new DOMDocument();
				 $domdata->loadXML($req_service); 
                 $MasterCustomerId = $domdata->getElementsByTagName('MasterCustomerId')->item(0)->nodeValue; 				 
			     $SubCustomerId= $domdata->getElementsByTagName('SubCustomerId')->item(0)->nodeValue;
				 $CustomerType=$domdata->getElementsByTagName('CustomerType')->item(0)->nodeValue;
			     $LabelName= $domdata->getElementsByTagName('LabelName')->item(0)->nodeValue;
				 $FirstName= $domdata->getElementsByTagName('FirstName')->item(0)->nodeValue; 
				 $LastName= $domdata->getElementsByTagName('LastName')->item(0)->nodeValue;
				 $PrimaryEmailAddress= $domdata->getElementsByTagName('PrimaryEmailAddress')->item(0)->nodeValue;
				 $OrderNo= $domdata->getElementsByTagName('OrderNo')->item(0)->nodeValue;
				 $OrderLineNo=$domdata->getElementsByTagName('OrderLineNo')->item(0)->nodeValue;
				 $ProductID=$domdata->getElementsByTagName('ProductID')->item(0)->nodeValue;
				 $StartDate=$domdata->getElementsByTagName('StartDate')->item(0)->nodeValue; 
				 $EndDate=$domdata->getElementsByTagName('EndDate')->item(0)->nodeValue; 
				 $LicenseType=$domdata->getElementsByTagName('LicenseType')->item(0)->nodeValue;
				 $LicenseCount=$domdata->getElementsByTagName('LicenseCount')->item(0)->nodeValue;
				 $LineStatus=$domdata->getElementsByTagName('LineStatus')->item(0)->nodeValue;
				 $Alldata= array(
						'm_subcustid'=>$SubCustomerId,
						'm_custtype'=>$CustomerType,
						'm_lablename'=>$LabelName,
						'm_firstname'=>$FirstName,
						'm_lastname'=>$LastName,
				 		'm_licence_type'=>$LicenseType,
						'm_primaryemail'=>$PrimaryEmailAddress,
				 		'm_orderid'=>$OrderNo
				       
				);
	/////////Start Reader Login information Insert into user table////////////////			 
				 $inusert=array(
				 'email'=>$PrimaryEmailAddress,
				 'master_id'=> $MasterCustomerId,
				 'm_usrfirstname'=>$FirstName,
				 'm_usrlastname' =>$LastName,
				 'username'=>$LabelName,
				 'created'=>date('Y-m-d:h:i:sa')
				 );
				// print_r($inusert); die;
				 $updateuser=array(
				 'email'=>$PrimaryEmailAddress,
				 'm_usrfirstname'=>$FirstName,
				 'm_usrlastname' =>$LastName,
				 'username'=>$LabelName,
				 'modified'=>date('Y-m-d:h:i:sa')
				 );
				$data=$this->ReaderModel->selectInsert($MasterCustomerId);
				if($data>0){
				$this->ReaderModel->UpdateInsert($MasterCustomerId,$updateuser);
				}else{
				  $this->ReaderModel->userinsert($inusert);
				}
				
	////////////////End Reader Login information///////////////////////////////////			 
				  $StartDate=date_create($StartDate);
				  $EndDate=date_create($EndDate);
				  $date1=date_format($StartDate,"Y-m-d"); 
				  $date2=date_format($EndDate,"Y-m-d"); 
			      $order_arr = array(
				 		'master_id'=>$MasterCustomerId,
				 		'order_id'=>$OrderNo,
				 		'product_id'=>$ProductID,
				 		'start_date'=>$date1,
				 		'end_date'=>$date2,
				 		'licence_type'=>$LicenseType,
				 		'licence_count'=>$LicenseCount,
				 		'line_status'=>	$LineStatus
				 );
				 /* echo "<pre>";
				print_r($Alldata); die;  */
				
				$this->ReaderModel->update($MasterCustomerId,$Alldata);
				
				$data=$this->ReaderModel->getOrder($MasterCustomerId);
				
				if($data>0){
				   $this->ReaderModel->UpdateOrder($MasterCustomerId,$order_arr);
				}else{
					$this->ReaderModel->insertOrder($order_arr);
				}
				$data['productList']=$this->session->get_userdata();
				$data['productList'] = $this->ReaderModel->getAllBooks($MasterCustomerId);
				//$data['getMultiUser']=$this->ReaderModel->getMultiUser($MasterCustomerId);
				  /* echo "<pre>";
				print_r($data['getMultiUser']); die;     */
				$this->load->view('ReaderList',$data);
				
		}
		}
	    }   
		}else{
		 $data['ip']=$this->ReaderModel->getIpaddress($ipaddress);
		 //echo "<pre>"; print_r($data['ip']); die;
		 $this->load->view('IpBasedList',$data);
		 
		}
		
//////////////Notificatio User Subscription Renewal//////////////////

		$dataType=$this->ReaderModel->getSingleUser();
		//echo "<pre>"; print_r($dataType);
		foreach($dataType as $data){
	    //$to_email= $data->m_primaryemail; 
		$to_email="anujmn@gmail.com";
	    $this->email->from('anuj032@yahoo.com', 'ASCE');
	    $this->email->to($to_email);
	    $this->email->subject('Email Test');
	    $this->email->message('Your Product expire on'.$data->end_date.'Please Subscribe again');
	    $date1=date_create($data->end_date);
	    $date2=date_create(date('Y-m-d'));
	    $interval = $date2->diff($date1)->format("%a");
	    if ($interval==2) {
	    	$this->email->send();
	    } else {
	    	//echo  '<p class="error_msg">Mail not sent !</p>';
	    }
	 }
		
   }
	
}

?>