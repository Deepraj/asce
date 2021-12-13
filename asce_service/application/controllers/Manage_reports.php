<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_reports extends MY_Controller  {
	private $userid;
	private $chapter_id;
	private $Success_result;
    function __construct()
    {
		parent::__construct();
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->library(array('form_validation', 'tank_auth','xml','session','unzip'));
		$this->lang->load('tank_auth');
		$this->load->model('Xmlload_model');
		$this->load->model('Addproduct_model');
		$this->parse_data = array();
		$this->masterId = array();
		$this->load->database();
		$this->userid = $this->session->userdata('user_id');
		$this->cus_book_id = $this->session->userdata('cus_book_id');
		$this->load->library('form_validation');
		
		if(!$this->tank_auth->is_user_admin()){
		 $data['content'] = 'error_404'; // View name 
         $this->load->view('Book_library',$data);//loading in my template 
		exit;
		}
		
    }
	
	
	 public function index()
    {
		   
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}
		$data['userInfo'] = $this->userinfo();
	    $data['alluser'] = $this->Addproduct_model->selectallUser();
	    $data ['books'] = $this->Addproduct_model->list_book ();
	    //echo'<pre>'; print_r( $data  ); die;
		$this->load->pagetemplate('manageReportList',$data);
		
	}
	/* function manageReportlist($id='')
   {
    //$sortBy = $this->input->get('sortby');
	$username = $this->input->post('username');
	$ip = $this->input->post('ip');
	$searchfromdate = $this->input->post('search_from_date');	
	$searchtodate = $this->input->post('search_to_date');
	 $data['reportdata'] = $this->Addproduct_model->fetch_manage_reports($username,$ip,$searchfromdate,$searchtodate,$id);
	//echo"<pre>";print_r($data['reportdata']); die;
	 $data['username']=$username;
	$data['ip']=$ip;
	$data['searchfromdate']=$searchfromdate; 
	$data['userInfo'] = $this->userinfo();
    $this->load->pagetemplate('manageReportList',$data);	
  } */
  
 function downloadReport()
  {
     
            
            
	   $this->load->library('excel');
	   //if($this->input->post('submit'))
	   if($this->input->post('masterid'))
		{ 
                $data = $this->input->post();
                if (isset($data['submitNT'])) {
                    //turnaround report case
                    $data['masterid'] = 'All User';
                    $data['masterid2'] = 'All User';
                    
                    $data['search_from_date'] = '';
                    $data['search_to_date'] = '';
                    $data['search_from_date2'] = '';
                    $data['search_to_date2'] = '';
                    
                } else if (isset($data['submitNB'])) {
                    $data['masterid'] = 'All User';
                    $data['masterid1'] = 'All User';
                    
                    $data['search_from_date'] = '';
                    $data['search_to_date'] = '';
                    $data['search_from_date1'] = '';
                    $data['search_to_date1'] = '';
                    
                    
                } else {
                    $data['masterid2'] = 'All User';
                    $data['masterid1'] = 'All User';
                    
                    $data['search_from_date2'] = '';
                    $data['search_to_date2'] = '';
                    $data['search_from_date1'] = '';
                    $data['search_to_date1'] = '';
                }
                $this->load->library('excel');
		//$search_from_date2 = $this->input->post ( 'search_from_date2' );
		$search_from_date2 = $data['search_from_date2'];
		//if(empty($search_from_date2))
		if(!isset($data['submitNB']))
		{
		$search_from_date = $data['search_from_date'];
		
		if($search_from_date!="")
		{
			  $search_to_date=$data['search_to_date'];
		}
		else{
			
		      $search_from_date = $data['search_from_date1'];
		      $search_to_date=$data['search_to_date1'];
		}
		
		$masteridemail=$data['masterid'];
		$masteridemail1=$data['masterid1'];
		if($masteridemail!="All User")
		{
			$arr = explode("#", $masteridemail);
			$licencetype = $arr[2];
			$email = $arr[1];
			$master_id = $arr[0];
			$firstdropdown=$arr[4];
			$labelname=$arr[3];
		}
		else if($masteridemail1!="All User") {
			$arr = explode("#", $masteridemail1);
			$licencetype = $arr[2];
			$email = $arr[1];
			$master_id = $arr[0];
			$labelname=$arr[3];
			$firstdropdown=$arr[4];
		}elseif($masteridemail=="All User")
		{
		$firstdropdown='4';
		$labelname='All User';
		//$licencetype="ALL";
		//	echo	$firstdropdown; die;	
		}
                $orderid=$this->Addproduct_model->checkCorporaitionMultiAdmin ($master_id,$email );
		$CarporationAdmin=$this->Addproduct_model->checkOrderidMultiAdmin ($orderid[0]->m_orderid);
		//print_r($CarporationAdmin); //die;
		$instituteName=$CarporationAdmin['0']->m_lastname; 
		
		if($CarporationAdmin[0]->m_masterid!="")
		{
			$master_id=$CarporationAdmin[0]->m_masterid;
		}
		if($CarporationAdmin['0']->m_lastname=="")
		{
			$instituteName="All User";
		}
		else{
			$instituteName=$CarporationAdmin['0']->m_lastname;
		}
		//print_r($instituteName); die;
////////////////////////////Date Formate///////////////////////////////////////////////
		$output = [];
		$time   = strtotime($search_from_date);
		$last   = date('F-Y', strtotime($search_to_date));

		do{
			$month = date('F-Y', $time);
			$total = date('t', $time);
			// $month = date_format($month,"%M %Y")
			$output[$month] = $month;
		   $time = strtotime('+1 month', $time);
		}
		   while ($month != $last);

		//echo "<pre>";print_r($firstdropdown.'--'.$licencetype);echo "<hr>"; //die();
		//echo "<pre>";print_r($licencetype);echo "<hr>"; //die();
		
/////////////////////////////////////////////////////////////////////////////////////////	
	  
		if($licencetype!='IPBASED' && $firstdropdown==1 )
		{
		  $data = $this->Addproduct_model->selectmonthReportdata($search_from_date,$search_to_date,$master_id,$email);
		}		
		else if($licencetype=='IPBASED' && $firstdropdown==1)
		{
		  //print_r($search_from_date.'--to--'.$search_to_date.'--id--'.$master_id.'--email--'.$email);echo "<hr>"; //die;
		  $data = $this->Addproduct_model->selectIPReportdata($search_from_date,$search_to_date,$master_id,$email);
		  
		 //print_r($data); die;
		}
		
		else if($licencetype=='IPBASED' && $firstdropdown==2)
		{

		  $data = $this->Addproduct_model->selectIPReportdata1($search_from_date,$search_to_date,$master_id,$email);
		// print_r($data); die;
		}
		else if($firstdropdown==4)
		{
		//echo "dsfsf"; die;
		  $data = $this->Addproduct_model->selectAllsessionReportdata($search_from_date,$search_to_date);
		// print_r($data); die;
		}
	}else{
		$search_from_date=$search_from_date2;
		$search_to_date = $this->input->post ( 'search_to_date2' );
		$book_id=$this->input->post('masterid2');
		$output = [];
		$time   = strtotime($search_from_date);
		$last   = date('F-Y', strtotime($search_to_date));
		do {
			$month = date('F-Y', $time);
			$total = date('t', $time);
			// $month = date_format($month,"%M %Y")
			$output[$month] = $month;
		   $time = strtotime('+1 month', $time);
		}
		 while ($month != $last);
		 $data = $this->Addproduct_model->selectbookReportdata($search_from_date,$search_to_date,$book_id);
		
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
            ->setCellValue('A1', 'ASCE 7 Online Uses Report For "'.$instituteName.'"');	
			
       $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Month');
			
		//echo'<pre>';print_r($firstdropdown);echo'<hr>';die();
       if($firstdropdown==1 || $firstdropdown==4)
		{  
		$reporttype="UniqueSessionsReport.xls";
		$this->excel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Unique Sessions');
		}
		elseif( $firstdropdown==2 ) {
			$reporttype="TurnawaysReport.xls";
          $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'turnaways');
           
		}
		elseif( $firstdropdown=="" ) {
			$reporttype="BrokendownReport.xls";
			 $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Brokendown');
		}
		
			   $starttimestamp = $year."-".$month."-"."01";
			   $time=strtotime($starttimestamp);
               $month=date("F",$time); 
	   
				if(is_array($data)){
				$resultarray = array();
				foreach($data as $currentDataValue){
				//print_r($currentDataValue);  
				$resultarray[$currentDataValue->month][] = $currentDataValue->id;
		}
		$columnno = 3;
		
		
		$resultarrayfinal = array();
		foreach($output as $manualdatakey=>$manualdatavalue){
			if(array_key_exists($manualdatavalue, $resultarray)) {
				$resultarrayfinal[$manualdatakey] = count($resultarray[$manualdatavalue]);
			}else{
				$resultarrayfinal[$manualdatakey] = 0;
			}
		}
		//echo "<pre>!!!!";print_r($resultarrayfinal);die;
		foreach($resultarrayfinal as $monthname=>$monthdata){
			$this->excel->getActiveSheet()->getCell("A".$columnno)->setValue($monthname);
			$this->excel->getActiveSheet()->getCell("B".$columnno)->setValue($monthdata);
			$columnno++;
		}
			//echo "<pre>!!!!";print_r($resultarray);die;
	}else{
			$this->excel->getActiveSheet()->getCell("A2")->setValue($month." ".$year);
			$this->excel->getActiveSheet()->getCell("B2")->setValue($data);
	}		
    $this->excel->setActiveSheetIndex(0);
	 $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $filename='UserReport.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$labelname."-".$reporttype.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		ob_start();	 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
   
		die; 
	
	  }  
	$this->load->view('manageReportList'); 
  }
        
	function userinfo()
    {
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
        $this->load->model('Book_m');
        $data = $this->Book_m->userinfo_get($this->userid);
		
		return $data[0];
       }
    }
}
?>
