<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_reports extends CI_Controller   {
	private $userid;
	private $chapter_id;
	private $Success_result;
    function __construct()
    {
		parent::__construct();
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->library(array('form_validation','xml','session','unzip'));
		
		$this->load->database ();
		$this->load->model ( 'IpuserModel' );
		$this->load->library ('session');
		$this->load->library('form_validation');
		
		if(empty($this->session->userdata("MasterCustomerId"))){
            redirect(site_url(),'refresh');
		 }
		
		
    }
	
	
	 public function index()
    {
		if($this->input->post('submit')){ 
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$master_id=$this->session->userdata("MasterCustomerId");
		$data = $this->IpuserModel->selectReportdata($year,$month,$master_id);
		//echo $year; die;
	}
	
	//echo "<pre>"; print_r($_SESSION); die;
	//echo'<pre>'; print_r( $data['reportdata']); die;
	$this->load->view('pagetemplate/header-inner');
		$this->load->view('userReportList');
		
    } 
	
 function downloadReport()
  {
	 
  if($this->input->post('submit')){ 
	     //print_r( $_REQUEST); die;
		$this->load->library('excel');
		$search_from_date = $this->input->post ( 'search_from_date' );
		$search_to_date=$this->input->post('search_to_date');
		$email=$this->session->userdata("email");
		$licence=$this->input->post("licence");
		//$value1=$this->session->userdata("bookmasterid");
		
		$aa=$this->session->userdata('çarporationmasterid');
		if(isset($aa))
		{
			$value1=$this->session->userdata('çarporationmasterid');
		}else{
			$masterid=$this->session->userdata('MasterCustomermainId'); 
		}	
	    $value2=$this->session->userdata('MasterCustomerId');
	 // echo !empty($value1)?$value1:$value2;
		if($value1=="")
		{
		$master_id= $value2;	
		}
		else{
		$master_id=$value1;
		}
		//$master_id=$this->session->userdata("bookmasterid");
		$instituteName= $this->IpuserModel->getInstituteDetail($master_id);
	////////////////////////////////////////////////////////////////////////////////////	
		$output = [];
		//$year=[];
		$time   = strtotime($search_from_date);
		$last   = date('F-Y', strtotime($search_to_date));

		do{
			   $month = date('F-Y', $time);
			  //$year = substr($month,-4);
		    $total = date('t', $time);
			// $month = date_format($month,"%M %Y")
			$output[$month] = $month;
		   $time = strtotime('+1 month', $time);
		}
		   while ($month != $last);
  
		//echo "<pre>";print_r($output);echo "<hr>"; die();
	/////////////////////////////////////////////////////////////////////////////////	
		if($licence!='IPBASED' && (!empty($month)))
		{
			//echo"fdf"; print_r($output); die();
			
		$data = $this->IpuserModel->selectReportdata($search_from_date,$search_to_date,$master_id,$email);
		}else if($licence!='IPBASED' && (empty($month)))	
		{
			
		 $data = $this->IpuserModel->selectmonthReportdata($search_from_date,$search_to_date,$master_id,$email);	
		//echo "<pre>!!!!";print_r($data);echo "<hr>";die();
		}
		else if($licence=='IPBASED' && (!empty($month)))
		{
			//print_r($search_from_date.'--to--'.$search_to_date.'--id--'.$master_id.'--email--'.$email);echo "<hr>"; //die;
		  $data = $this->IpuserModel->selectIPReportdata($search_from_date,$search_to_date,$master_id,$email);
		}
		else if($licence=='IPBASED' && (empty($month)))
		{
			$data = $this->IpuserModel->selectIPmonthReportdata($search_from_date,$search_to_date,$master_id,$email);
		}
		
	  define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        // Set document properties
        $this->excel->getProperties()->setCreator("ASCE")
            ->setLastModifiedBy("ASCE")
            ->setTitle("ASCE")
            ->setSubject("ASCE")
            ->setDescription("ASCE.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("resources");

		$this->excel->setActiveSheetIndex(0)
            ->mergeCells('A1:C1');
		$this->excel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ASCE 7 Online Uses Report For "'.$instituteName['0']->m_lablename.'"');	
			
		$this->excel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Month');
		$this->excel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Unique Sessions');	
		/*	
      if($licence!='IPBASED')
		{  
			$this->excel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Unique Sessions');
		}else{
			$this->excel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Turnaways');
           
		}*/
			    $starttimestamp = $year."-".$month."-"."01";
			    $time=strtotime($starttimestamp);
                $month=date("F",$time);
            //echo "<pre>!!!!";print_r($data);die;
	
				if(is_array($data)){
				$resultarray = array();
				foreach($data as $currentDataValue){
				
				$resultarray[$currentDataValue->month][] = $currentDataValue->id;
		}
		
		$columnno = 3;
		$resultarrayfinal = array();
		
		//echo "<pre>!!!!";print_r($resultarray);
		//echo "<pre>!!!!eee";print_r($output);die();
		foreach($output as $manualdatakey=>$manualdatavalue){
			if(array_key_exists($manualdatavalue, $resultarray)) {
				$resultarrayfinal[$manualdatakey] = count($resultarray[$manualdatavalue]);
			}else{
				$resultarrayfinal[$manualdatakey] = 0;
			}
		}
		//echo "<pre>!!!!";print_r($resultarrayfinal);die();
		//echo "<pre>!!!!";print_r($resultarrayfinal);die;
		foreach($resultarrayfinal as $monthname=>$monthdata){
			$this->excel->getActiveSheet()->getCell("A".$columnno)->setValue($monthname);
			$this->excel->getActiveSheet()->getCell("B".$columnno)->setValue($monthdata);
			$columnno++;
		}
			//echo "<pre>!!!!";print_r($resultarray);die;
	}else{
		//echo "<pre>!!!!";print_r($resultarray);die;
			$this->excel->getActiveSheet()->getCell("A2")->setValue($month." ".$year);
			$this->excel->getActiveSheet()->getCell("B2")->setValue($data);
	}		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$filename='UserReport.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache        
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		ob_start();	 
        $objWriter->save('php://output');
   		die; 
	  }
	    $this->load->view('pagetemplate/header-inner');
		$this->load->view('userReportList');   
  }
}
?>