<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DataUpdate extends CI_Controller {
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->database();
		$this->load->model('DataUpdate_Model');
		$this->load->library('email');
	}
	public function index()
	{       	
	 
	    $wsdl = "https://secure.asce.org/PUPGCustomWebServices/mps.asmx?WSDL";
		$cliente = new SoapClient($wsdl);
		$request_service='<?xml version="1.0" encoding="utf-8"?>
			<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
			  <soap12:Body>
				<ASCE_GetOrdersInformation xmlns="http://asce.org/" />
			  </soap12:Body>
			</soap12:Envelope>';
		$location='https://secure.asce.org/PUPGCustomWebServices/mps.asmx';
		$action='https://secure.asce.org/PUPGCustomWebServices/mps.asmx?op=ASCE_GetOrdersInformation';
		$version='2';
		$req_service=$cliente->__doRequest($request_service, $location, $action, $version, $one_way = 0);
		$domdata = new DOMDocument();
		$domdata->loadXML($req_service);
		//echo "<pre>"; print_r($req_service);  die;
		$x=$domdata->getElementsByTagName('ASCE_GetOrdersInformationResponse');
		//print_r( $x); die;
		$x1=$domdata->getElementsByTagName('ASCE_LicenseInfo');
		//echo "<pre>"; print_r($x1);  die;
		for($i=0;$i<$x1->length;$i++){
			foreach($x as $item)
			{
			    $MasterCustomerId= $domdata->getElementsByTagName('MasterCustomerId')->item($i)->nodeValue; 
				$SubCustomerId= $domdata->getElementsByTagName('SubCustomerId')->item($i)->nodeValue;
				$CustomerType=$domdata->getElementsByTagName('CustomerType')->item($i)->nodeValue;
				$LabelName= $domdata->getElementsByTagName('LabelName')->item($i)->nodeValue;
				$FirstName= $domdata->getElementsByTagName('FirstName')->item($i)->nodeValue;
				$LastName= $domdata->getElementsByTagName('LastName')->item($i)->nodeValue;
				$PrimaryEmailAddress= $domdata->getElementsByTagName('PrimaryEmailAddress')->item($i)->nodeValue;
				$OrderNo= $domdata->getElementsByTagName('OrderNo')->item($i)->nodeValue;
				$OrderLineNo=$domdata->getElementsByTagName('OrderLineNo')->item($i)->nodeValue;
				$ProductID=$domdata->getElementsByTagName('ProductID')->item($i)->nodeValue;
				$StartDate=$domdata->getElementsByTagName('StartDate')->item($i)->nodeValue;
			    $EndDate=$domdata->getElementsByTagName('EndDate')->item($i)->nodeValue; 
				$LicenseType=$domdata->getElementsByTagName('LicenseType')->item($i)->nodeValue;
				$LicenseCount=$domdata->getElementsByTagName('LicenseCount')->item($i)->nodeValue;
				$LineStatus=$domdata->getElementsByTagName('LineStatus')->item($i)->nodeValue;
				$arr_data[]= array(
						'm_masterid'=> $MasterCustomerId,
						'm_subcustid'=>$SubCustomerId,
						'm_custtype'=>$CustomerType,
						'm_lablename'=>$LabelName,
						'm_firstname'=>$FirstName,
						'm_lastname'=>$LastName,
						'm_licence_type'=>$LicenseType,
						'm_primaryemail'=>$PrimaryEmailAddress,
						'm_orderid'=>$OrderNo,
						'updated_date'=>date('Y-m-d H:i:s')
						 
				);
				$StartDate=date_create($StartDate);
				$EndDate=date_create($EndDate);
				$date1=date_format($StartDate,"Y-m-d");
			    $date2=date_format($EndDate,"Y-m-d"); 
				$order_array[]=array(
						'master_id'=>$MasterCustomerId,
						'order_id'=>$OrderNo,
						'product_id'=>$ProductID,
						'start_date'=>$date1,
						'end_date'=>$date2,
						'licence_type'=>$LicenseType,
						'licence_count'=>$LicenseCount,
						'line_status'=> $LineStatus,
						'updated_date'=>date('Y-m-d H:i:s')
				);
		       // echo $MasterCustomerId; die;
				$dataId=$this->DataUpdate_Model->getInfo($MasterCustomerId);
				//print_r($dataId); die; 
				$getDate=$this->DataUpdate_Model->getDate($MasterCustomerId);
				//echo "<pre>";print_r($getDate); die;
				$getData=$this->DataUpdate_Model->getData($MasterCustomerId);
				//echo "<pre>";print_r($getData); die;
			    $to_email=$getData[0]->m_primaryemail;
				//$to_email="anujmn@gmail.com";
				$this->email->from('anuj032@yahoo.com', 'ASCE');
				$this->email->to($to_email);
				$this->email->subject('Email Test');
				if($dataId>0){	
					$dataUpdated=$this->DataUpdate_Model->Update($MasterCustomerId,$arr_data[$i]);
					foreach($getDate as $val){
					 $enddate=strtotime($val->end_date);  
					 $date=strtotime($date2);
					if($date > $enddate){
					$this->email->message('Your Product has been Renewal.Now you can Use.');
					$send=$this->email->send();
					}
				 }	
					
				}else{
					
					$dataInserted=$this->DataUpdate_Model->insert($arr_data[$i]);
					if($dataInserted){
					$this->email->message('Your Product has been Subscribed.Now you can Use.');
					$send=$this->email->send();	
					//if($send){echo "data inserted";}else{ echo "data not inserted";}
					
					$datavalue = $this->DataUpdate_Model->getByemail($MasterCustomerId);
					/* echo "<pre>";
					 print_r($data['emailBased']); die;  */
					foreach($datavalue as $userdata){
						$to_email=$userdata->email;
						//$to_email="anujmn@gmail.com";
						$this->email->from('anuj032@yahoo.com', 'ASCE');
						$this->email->to($to_email);
						$this->email->subject('Email Test');
						$this->email->message('Please Click on link Registration In Asce &nbsp;<a href="<?php echo site_url()/reader; ?>"> Registration</a>');
						$this->email->send();
					}	
				  }
				}
						
				$order=$this->DataUpdate_Model->getOrder($MasterCustomerId);
				//print_r($order); die;
				if($order>0){
		
					$this->DataUpdate_Model->UpdateOrder($OrderNo,$order_array[$i]);
		
				}else{
		
					$this->DataUpdate_Model->insertOrder($order_array[$i]);
		
				}
		
			}
		}	     // $this->load->view('DataUpdateView'); 
	}
}
?>