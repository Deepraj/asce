<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class institutePage extends MY_Controller  {
	private $userid;
	private $chapter_id;
	private $Success_result;
    function __construct()
    {
		// Construct the parent class
		parent::__construct();
		
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->library(array('form_validation', 'tank_auth','xml','session','unzip'));
		$this->load->library(array('email'));
		$this->lang->load('tank_auth');
		$this->load->model('Xmlload_model');
		$this->load->model('Institute_model');
		$this->parse_data = array();
		$this->masterId = array();
		$this->load->database();
		$this->userid = $this->session->userdata('user_id');
		$this->cus_book_id = $this->session->userdata('cus_book_id');
		
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
		}else{
	        $this->list_book();
		}
    }    
	
	// Get the user details
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
	//Function for getting All Admin Titles
	function getAdminTitles()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_Titles();
			return $var ;
		}
	}
	//Function for getting All Admin Status
	function getAllStatus()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_Status();
			return $var ;
		}
	}
	//Function for getting All Products
	function getProducts()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllProducts();
			return $var ;
		}
	}
	//Function for getting All Currency
	function getCurrency()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllCurrency();
			return $var ;
		}
	}
	//Function for getting All IP Versions
	function getAllIpVersion()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllIpVersions();
			return $var ;
		}
	}
	//Function for getting All Countries Names
	function getAllCountry()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllCountries();
			return $var ;
		}
	}
	// fnction to add a book
    public function addInstitute($id = 0)
    { 
	     error_reporting(0);
		 $LicenceInfo = end($this->uri->segment_array());
		 //echo $LicenceInfo; die;
		 //$LicenceInfo = $this->session->userdata ( 'LicenceInfo' );
		 $this->session->set_userdata('LicenceInfo',$LicenceInfo);
		//echo$id; die;		
		if (!$this->tank_auth->is_logged_in(TRUE) && $this->tank_auth->is_user_admin(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		
			$data['userInfo'] = $this->userinfo();
			$data['insIpVersion'] = array(
					'name'	=> 'insIpVersion1',
					'id'	=> 'insIpVersion1',
					'value'	=> $this->getAllIpVersion(),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "IP Version",
					'class' => "form-control col-sm-3",
					'selected' => ''
			);
			$data['insMinIp']=array(
					'name'=>'insMinIp1',
					'id'=>'insMinIp1',
					'value'=>set_value('insMinIp'),
					'for'=>'Minimum IP Address',
					'class'=>'form-control',
					'onBlur'=>'checkIPStatus(id)',
			);
			$data['insMaxIp']=array(
					'name'=>'insMaxIp1',
					'id'=>'insMaxIp1',
					'value'=>set_value('insMaxIp'),
					'for'=>'Maximum IP Address',
					'class'=>'form-control',
					'onBlur'=>'checkIPStatus(id)'
			);
			$data['insProductid12'] = array(
					'name'	=> 'insproductid12',
					'id'	=> 'insProductid12',
					'value'	=> set_value('insProductid12'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "insproductid12",
					'class' => "form-control",
			);
			$data['ipStatus'] = array(
					'name'	=> 'ipStatus1',
					'id'	=> 'ipStatus1',
					'value'	=> $this->getAllStatus(),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "IP Status",
					'class' => "form-control col-sm-3",
					'selected' => ''
			);
			$data['insemail'] = array(
					'name'	=> 'insEmail1',
					'id'	=> 'insEmail1',
					'value'	=> set_value('insEmail1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "Institute Email",
					'class' => "form-control"
			);
			$data['insFirstName'] = array(
					'name'	=> 'insFirstName1',
					'id'	=> 'insFirstName1',
					'value'	=> set_value('insFirstName1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "First Name",
					'class' => "form-control"
			);
			$data['insLastName'] = array(
					'name'	=> 'insLastName1',
					'id'	=> 'insLastName1',
					'value'	=> set_value('insLastName1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "Last Name",
					'class' => "form-control",
			);
			$data['insProductid'] = array(
					'name'	=> 'insProductid1',
					'id'	=> 'insProductid1',
					'value'	=> set_value('insProductid'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "Ins Productid",
					'class' => "form-control",
			);
			
			
			if ($this->input->post('addInstituteIPAddressnext') && $id >0){
				//$productid=$this->input->post('insproductid12');
				//echo $productid; die;
				$masterdetail=$this->Institute_model->getMasterID($id);
				$masterDet=$masterdetail[0]->m_masterid;
				//$delIP_id=$this->Institute_model->deleteInstituteIP($masterDet);
				$ipBased=$this->input->post('ipBased');
				$referralUrl=$this->input->post('referralUrl');
				$accessToken=$this->input->post('accessToken');
				//$updatedIPValue=$this->Institute_model->updateAccessStatues($ipBased,$referralUrl,$accessToken,$id);
			    $no_of_ips=$this->input->post('no_of_ips');
				
				
				//print_r($no_of_ips); die;
				for($i=1;$i<=$no_of_ips;$i++){
					$institution_id=$this->input->post('institution_id');
					$ip_version=$this->input->post('insIpVersion'.$i);
					$low_ip=$this->input->post('insMinIp'.$i);
					$high_ip=$this->input->post('insMaxIp'.$i);
					$aui_status=$this->input->post('ipStatus'.$i);
					$productid=$this->input->post('insproductid12'.$i);
					$delIP_id=$this->Institute_model->deleteInstituteIP($masterDet,$productid);
					//echo $productid;
					//die;
					if(!empty($ip_version) && !empty($low_ip) && !empty($high_ip)){
		              $this->Institute_model->add_IPAuthentications($id,$ip_version,$low_ip,$low_ip,$high_ip,$aui_status,$masterDet,$productid);
					}
				}
				redirect('institutePage/addInstitute/'.$id.'?tab=5', 'refresh');
			}
			
		//-------------------File upload  code -------------------------	
			
			else if($this->input->post('imageupload') && $id >0)
	     {
				
		     $usermaster=$this->input->post('usermaster');
			  $product_id=$this->input->post('Subscription');
			  $arr = explode("#", $product_id);
	          $product_id = $arr[1];
	         $order_id = $arr[0];
	         $product_name = $arr[2];
			// echo  $order_id."//". $product_name."//".$product_id; die;
			  $licence_count=$this->Institute_model->Getlicencecunt($usermaster,$product_id);
		                      $licencecount= $licence_count[0]->licence_count;
	         $image= $_FILES['userfile']['name'];
			 $ext = pathinfo( $image, PATHINFO_EXTENSION);
			 
			 // echo $ext; die;
		 switch ($ext) {
			 
	   case "xml":
		           
				    $msg ='';
					$msg1 ='';
					$msg2 = '';
					$msg5 = '';
					$msg3 = '';
					$wrongFrmt=0;
					$data11=array();
			$notinserted=array();
			$error= array();
			$success = array();
			$result = array();
			$inserted=array();
			$duplicate=array();
			  $image= $_FILES['userfile']['name'];
			  $image=str_replace(" - Copy","-1",$image);
              $config['upload_path'] = 'public/image';			  
              $config['file_name'] = $image;
              $config['overwrite'] = TRUE;
              $config["allowed_types"] = 'jpg|jpeg|png|gif|xml|xlsx';
              $config['max_size'] = '5000';
             // $config["max_width"] = 400;
              $config["max_height"] = 768;
		      //$config["encrypt_name"] = 768;
		    //$this->upload->initialize($config);
              $this->load->library('upload', $config);
			if(!$this->upload->do_upload()){
			   echo $this->upload->display_errors();
			}else{
			
			 $file="public/image/".$image;
		     $xml = simplexml_load_file($file);			 
			 //print_r((string)$xml->ASCE_MPS_LicenseInfo->FirstName); die;
			 //print_r($xml->children()); die;
			foreach($xml->children() as $emailval){
				$aa = count($emailval);
				if($aa == 3){
				 $data11[]=array(
			     'usermaster' => $usermaster,
				 'product_id' => $product_id,
				 'product_name' => $product_name,
				  'order_id' =>  $order_id,
		         'FirstName'=>trim((string)$emailval->fname),
			     'LastName'=>trim((string)$emailval->lname),
		         'PrimaryEmailAddress'=>(string)$emailval->email
		          );
				}
				//print_r($data11); die;
				else{
					$wrongFrmt=1;
				}
				 
			}
		    
				// print_r($data11); die;
				  if($wrongFrmt==1){
					  $msg = "<h5><strong>Invalid Format. Please check your file.</strong></h5>";
					  $this->session->set_flashdata('message',$msg);
				  }else{
				  $xmlcount=count($data11);
				  //print_r($xmlcount); 
				  //$dsd =  $xmlcount/5;
				 $msg3="<h4>Total ".$xmlcount." records</h4>";
				 $warningmsg = "<span style='color:red,'>You  can not add more than ".$licencecount."  users </span>";
		
				  foreach($data11 as $totaldata){
					  $duplicatecheck = $this->Institute_model->isExistEmail($totaldata['PrimaryEmailAddress'],$usermaster,$product_id);
					if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
					}
				     $val= $this->Institute_model->insertxml($totaldata);
					/*  if(!empty($val)){
					 $to_email=$data[3]; 
					 $this->SendEmail($to_email,$usermaster);
				  } */
		            // echo $data[3]; die;
		 		   if($val['error'] != '')
					   {
							$notinserted[]= $val['error'];
							
					   }else{
					   if($val['insertflage'])
					   {
					        $to_email=$val['insertemail']; 
			                $this->SendEmail($to_email,$usermaster);
							$inserted[] = $val['error'];
							
							}
						}
				  }
		
			//print_r($notinserted); die;
			if(count($inserted)>0){
							$msg = "<h5><strong>Total ".count($inserted)." records successfully added.</strong></h5>";
							
						}
			if(count($duplicate)>0){
							$msg5 = "<h5><strong>Total ".count($duplicate)." records duplicate</strong></h5> <span style='color:#800080'>".implode("<br>",$duplicate)."</span>";
							
		     	}			
			
			if(count($notinserted)>0){
							$msg1= "<h5><strong>Total ".count($notinserted)." records was not added due to invailide email formate.</strong></h5>";
							foreach($notinserted as $record){
								
								$msg2.= "<span style='color:red'>".$record."</br></span>";
								//print_r($msg2); die;
							}
						}
			$this->session->set_flashdata('message',$warningmsg.$msg3.$msg.$msg1.$msg2.$msg5);
			
		      }
		 
		    if($val = true)
					{
						unlink('public/image/'.$image); 
						redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
					}		
	 		}
		       break;	
			   
	 case "csv":
	   
	                $msg ='';
					$msg1 ='';
					$msg2 = '';
					$msg5 = '';
					$msg3 = '';
					$invalidmsg='';
			$notinserted=array();
			$error= array();
			$success = array();
			$result = array();
			$inserted= array();
			$duplicate=array();
			$notinformat=array();
	         $image= $_FILES['userfile']['name'];
			 $image=str_replace(" - Copy","-1",$image);
			 //print_r( $image); die;
	         $config['upload_path'] = 'public/image';
             $config['allowed_types'] = 'text/plain|text/csv|csv';
             $config['max_size'] = '5000';
             $config['file_name'] =  $image;
             $this->load->library('upload', $config);     
           if(!$this->upload->do_upload()) {
		   echo $this->upload->display_errors();
            }else {
				//echo "fdf"; die;
               $csvfilepath = "public/image/" . $image;
		       define('CSV_PATH','public/image/');
		       $csv_file = CSV_PATH . $image;	
            		//echo $csv_file; die;	   
		      if (($handle = fopen($csv_file, "r")) !== FALSE) 
		       {
			  
              // fgetcsv($handle);
               //print_r($handle); die;			   
			  $totval=0;	   
              while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	           {
			    
				  if($totval==0)
				  {
					  $totval++;
					  continue;
				  }
				  $totval++;
               $num = count($data);
			    //print_r($num); die;
			   
               for ($c=0; $c < $num; $c++){
				$data[$c] = $data[$c];
			    $aa=count($data); 
              }
			 // $aa=count($data); die;
			// print_r($data); die;
			  if($num!=3){
				  $notinformat[]= "Row ".$totval." is not in valid format.";
			  }else{
			$duplicatecheck = $this->Institute_model->isExistEmail($data[2],$usermaster,$product_id);
					if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
					}
                 $val= $this->Institute_model->insertcsv($data,$usermaster,$product_id,$product_name,$order_id);
				 //echo "anuj"; print_r($data[3]); die;
				/*  if(!empty($val)){
				    $to_email=$data[2]; 
					$this->SendEmail($to_email,$usermaster);
				 } */
				 if($val['error'] != '')
					   {
							$notinserted[]= $val['error'];
							
					   }else{
					    if($val['insertflage'])
						{
						    $to_email=$val['insertemail']; 
			                $this->SendEmail($to_email,$usermaster);
							$inserted[] = $val['error'];
							
							}
						}
			  }
						
            }
             fclose($handle);
           }else{
		   $msg6= "<h5><strong>File is empty.Please upload a not empty file.</strong></h5>";
		   $this->session->set_flashdata('message',$msg6);
		   unlink('public/image/'.$image);
		   redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
		   exit;
		   }
		    
    }
	    $totval=$totval-1;
	    $msg3="<h4>Total ".$totval ." records</h4>";
		$warningmsg = "<span style='color:red,'>You  can not add more than ".$licencecount."  users </span>";
			
			if(count($notinformat)>0){
				//$abc=count($notinformat);echo $abc;die;
							foreach($notinformat as $record1){
								$invalidmsg.= "<span style='color:red'>".$record1."</br></span>";
								
							}
							
						}
			if(count($inserted)>0){
							$msg = "<h5><strong>Total ".count($inserted)." records successfully added.</strong></h5>";
							
						}
			if(count($duplicate)>0){
							$msg5 = "<h5><strong>Total ".count($duplicate)." records duplicate</strong></h5> <span style='color:#800080'>".implode("<br>",$duplicate)."</span>";
							
			}			
			
			if(count($notinserted)>0){
							$msg1= "<h5><strong>Total ".count($notinserted)." records was not added due to invailide email formate.</strong></h5>";
							foreach($notinserted as $record){
								$msg2.= "<span style='color:red'>".$record."</br></span>";
								
							}
						}
						$this->session->set_flashdata('message',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
		    if($val = true)
					{
						//echo "submit";
						unlink('public/image/'.$image);
						redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
					}
					
					
                  break;
				  
				  
    case "xlsx":
                $image= $_FILES['userfile']['name'];
				$file=str_replace(" - Copy","-1",$image);
	            $config['upload_path'] = 'public/image';
                $config['allowed_types'] = 'xlsx|csv|xls';
                $config['max_size'] = '5000';
                $config['file_name'] =  $file;
                $this->load->library('upload', $config);
           if(!$this->upload->do_upload()) 
		      echo $this->upload->display_errors();
               define('CSV_PATH','public/image/');
		       $csv_file = CSV_PATH . $file; 
			     //print_r($csv_file); die;
               $this->load->library('excel');
               $objPHPExcel = PHPExcel_IOFactory::load($csv_file);
			  //print_r($objPHPExcel); die;
               $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			   $msg6='';
			   if(empty($cell_collection)){ 
			   $msg6 = "<h5><strong>File is Empty.There are no record.</strong></h5>";
			   $this->session->set_flashdata('message', $msg6);
			  }else{
            foreach ($cell_collection as $cell) 
	         {
			 $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
             $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
             $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
           //header will/should be in row 1 only. of course this can be modified to suit your need.
		  // print_r( $row); die;
          if ($row == 1)
		      {
               $header[$row][$column] = $data_value;
              } 
	       else 
	       {
            $arr_data[$row][$column] = $data_value;
			
           }
        }
	 
			        $msg ='';
					$msg1 ='';
					$msg2 = '';
					$msg5 = '';
					$msg3 = '';
					$rowcnt=0;
					$invalidmsg='';
			$notinserted=array();
			$error= array();
			$success = array();
			$result = array();
			$inserted=array();
			$duplicate=array();
			$notinformat=array();
			$msg3="<h4>Total ".count($arr_data)." records</h4>";
			$warningmsg = "<span style='color:red'>You  can not add more than".$licencecount."  users </span>";
			
	      foreach($arr_data as $val)
		   {
			   $rowcnt++;
			   $colcount=count($val);
			 // echo "<pre>"; print_r($val); die;
			   if($colcount!=3){
				   $notinformat[]= "Row ".$rowcnt." is not in valid format.";
			   }else{
			     $duplicatecheck = $this->Institute_model->isExistEmail($val['C'],$usermaster,$product_id);
			   if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
			   }
		     
			$amar = $this->Institute_model->insertxlxs($val,$usermaster,$product_id,$product_name,$order_id);
			/* if(!empty($amar)){
			   		 $to_email=$val[C]; 
					 $this->SendEmail($to_email,$usermaster);
				}	 */
			if($amar['error'] != '')
			{
				$notinserted[]= $amar['error'];	
			 }    
			else
			{
			if($amar['insertflage'])
			{
				$inserted[] = $amar['error'];
				 $to_email=$amar['insertemail']; 
			   $this->SendEmail($to_email,$usermaster);
				}
			}
		    }
		 }
			if(count($notinformat)>0){
				//$abc=count($notinformat);echo $abc;die;
							foreach($notinformat as $record1){
								$invalidmsg.= "<span style='color:red'>".$record1."</br></span>";
								
							}
							
						}
			if(count($inserted)>0){
							$msg = "<h5><strong>Total ".count($inserted)." records successfully added.</strong></h5>";
							
						}
			if(count($duplicate)>0){
							$msg5 = "<h5><strong>Total ".count($duplicate)." records duplicate</strong></h5> <span style='color:#800080'>".implode("<br>",$duplicate)."</span>";
							
			}			
			
			if(count($notinserted)>0){
							$msg1= "<h5><strong>Total ".count($notinserted)." records was not added due to invailide email formate.</strong></h5>";
							foreach($notinserted as $record){
								$msg2.= "<span style='color:red'>".$record."</br></span>";
								
							}
						}
						
			$this->session->set_flashdata('message',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
		
						unlink('public/image/'.$image);
				} 		
						
			redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
			  
		       break;
			 
			   
	  case "xls":
                $image= $_FILES['userfile']['name'];
				$image=str_replace(" - Copy","-1",$image);
	            $config['upload_path'] = 'public/image';
                $config['allowed_types'] = 'xlsx|csv|xls';
                $config['max_size'] = '5000';
                $config['file_name'] =  $image;

                $this->load->library('upload', $config);

           if(!$this->upload->do_upload()) echo $this->upload->display_errors();
               define('CSV_PATH','public/image/');
		       $csv_file = CSV_PATH . $image; 
			    // print_r($csv_file); die;
               $this->load->library('excel');
               $objPHPExcel = PHPExcel_IOFactory::load($csv_file);
			  // print_r($objPHPExcel); die;
               $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			   $msg6='';
			   if(empty($cell_collection)){ 
			   $msg6 = "<h5><strong>File is Empty.There are no record.</strong></h5>";
			   $this->session->set_flashdata('message', $msg6);
			  }else{
           foreach ($cell_collection as $cell) 
	       {
          $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
          $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
          $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
           //header will/should be in row 1 only. of course this can be modified to suit your need.
		  // print_r( $row); die;
          if ($row == 1)
		      {
               $header[$row][$column] = $data_value;
              } 
	       else 
	       {
            $arr_data[$row][$column] = $data_value;
           }
         }
			        $msg ='';
					$msg1 ='';
					$msg2 = '';
					$msg5 = '';
					$msg3 = '';
					$rowcnt=0;
					$invalidmsg='';
			$notinserted=array();
			$error= array();
			$success = array();
			$result = array();
			$inserted=array();
			$duplicate=array();
			$notinformat=array();
			$msg3="<h4>Total ".count($arr_data)." records</h4>";
			$warningmsg = "<span style='color:red'>You  can not add more than ".$licencecount." users </span>";
			
	      foreach($arr_data as $val)
		   {
			   $rowcnt++;
			   $colcount=count($val);
			   if($colcount!=3){
				   $notinformat[]= "Row ".$rowcnt." is not in valid format.";
			   }else{
			   $duplicatecheck = $this->Institute_model->isExistEmail($val['C'],$usermaster,$product_id);
			   if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
			   }  
			//echo "<pre>";   print_r($val); die;
			$amar = $this->Institute_model->insertxlxs($val,$usermaster,$product_id,$product_name,$order_id);
			/* if(!empty($amar)){
			   $to_email=$val[C]; 
			   $this->SendEmail($to_email,$usermaster);
			} */
            	
			if($amar['error'] != '')
			{
				$notinserted[]= $amar['error'];	
			  }   
			else
			{
			if($amar['insertflage'])
			{
			 $to_email=$amar['insertemail']; 
			   $this->SendEmail($to_email,$usermaster);
				$inserted[] = $amar['error'];
				}
			}
		    }
		   }
			if(count($notinformat)>0){
				//$abc=count($notinformat);echo $abc;die;
							foreach($notinformat as $record1){
								$invalidmsg.= "<span style='color:red'>".$record1."</br></span>";
								
							}
						}
			if(count($inserted)>0){
							$msg = "<h5><strong>Total ".count($inserted)." records successfully added.</strong></h5>";
							
						}
			if(count($duplicate)>0){
							$msg5 = "<h5><strong>Total ".count($duplicate)." records duplicate</strong></h5> <span style='color:#800080'>".implode("<br>",$duplicate)."</span>";
							
			}			
			
			if(count($notinserted)>0){
							$msg1= "<h5><strong>Total ".count($notinserted)." records was not added due to invailide email formate.</strong></h5>";
							foreach($notinserted as $record){
								$msg2.= "<span style='color:red'>".$record."</br></span>";
								
							}
						}
						
			$this->session->set_flashdata('message',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
		
						unlink('public/image/'.$image);
						
			}			
						redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
					
		       break;  
			       
		case "txt":
		            $msg ='';
					$msg1 ='';
					$msg2 = '';
					$msg5 = '';
					$msg3 = '';
					$totval=0;
					$val= true;
					$invalidmsg='';
					$notinformat=array();
					$data12=array();
			$notinserted=array();
			$error= array();
			$success = array();
			$result = array();
			$inserted=array();
			$duplicate=array();
            $file = $_FILES['userfile']['name'];
            $image= $_FILES['userfile']['name'];
			$image=str_replace(" - Copy","-1", $image);
			$file=str_replace(" - Copy","-1", $file);
			//print_r($file); die;
	            $config['upload_path'] = 'public/image';
                $config['allowed_types'] = 'txt';
                $config['max_size'] = '5000';
                $config['file_name'] =  $image;
                $this->load->library('upload', $config);
			if($_FILES['userfile']['size'] > 0){ 
           if(!$this->upload->do_upload()) echo $this->upload->display_errors();
            $handle = fopen("public/image/$file", "r");
			$first=0;
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
					$first++;
					$totval++;
					$lineArr = explode("\t", "$line");
					$datacount=count($lineArr);
					if($first==1)
						continue;
					if($datacount!=3){
						$notinformat[]= "Row ".$first." is not in valid format.";
					}else{
                    list($fname, $lname, $email ) = $lineArr;
					$data = Array(
						'usermaster' => $usermaster,
						'product_id' => $product_id,
						'product_name' => $product_name,
				        'order_id' =>  $order_id,
                        'fname' => $fname,
						'lname' => $lname,
						'email' =>  $email
                    );
   
                    $duplicatecheck = $this->Institute_model->isExistEmail(trim($data['email']),$usermaster,$product_id);
			
					if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
					}
					$val= $this->Institute_model->inserttxt($data);
					/* if(!empty($val)){
					 $to_email=$email;
					$this->SendEmail($to_email,$usermaster);
										 
					} */
					if($val['error'] != '')
					   {
							$notinserted[]= $val['error'];
							
					   }
							   
						else
						{
						if($val['insertflage'])
						{
						
						    $to_email=$val['insertemail']; 
			                $this->SendEmail($to_email,$usermaster);
							$inserted[] = $val['error'];
							}
						}
						
				}
                }
				
                fclose($handle);
           
            } else {
               
            }
			
			$totval1=$totval-1;
			$msg3="<h4>Total ".$totval1." records</h4>";
				$warningmsg = "<span style='color:red'>You  can not add more than ".$licencecount." users </span>";
			if(count($notinformat)>0){
				//$abc=count($notinformat);echo $abc;die;
							foreach($notinformat as $record1){
								$invalidmsg.= "<span style='color:red'>".$record1."</br></span>";
								
							}
							
						}
			if(count($inserted)>0){
							$msg = "<h5><strong>Total ".count($inserted)." records successfully added.</strong></h5>";
							
						}
			if(count($duplicate)>0){
							$msg5 = "<h5><strong>Total ".count($duplicate)." records duplicate</strong></h5> <span style='color:#800080'>".implode("<br>",$duplicate)."</span>";
							
			}			
			
			if(count($notinserted)>0){
							$msg1= "<h5><strong>Total ".count($notinserted)." records was not added due to invailide email formate .</strong></h5>";
							foreach($notinserted as $record){
								$msg2 = "<span style='color:red'>".$record."</br></span>";
								
							}
						}
						if($totval1==0){
							$msg1= "<h5><strong>File is invalid .</strong></h5>";
							$this->session->set_flashdata('message',$msg1);
						}else{
						$this->session->set_flashdata('message',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
						}
			 if($val == true)
					{
						unlink('public/image/'.$image);
						//echo "submit";
						redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
					}
				} else {
               
			                $msg1= "<h5><strong>Your text file is empty .</strong></h5>";
							$this->session->set_flashdata('message',$msg1);
							redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
          }	
			break;
		 }			
		
	}
	
			else if($this->input->post('addInstituteRefferalnext') && $id >0){
				$masterdetail=$this->Institute_model->getMasterID($id);
				$masterDet=$masterdetail[0]->m_masterid;
				//echo $masterDet; die; 
				$delRef_id=$this->Institute_model->deleteInstituteRefferals($masterDet);
				$ipBased=$this->input->post('ipBased');
				$referralUrl=$this->input->post('referralUrl');
				$accessToken=$this->input->post('accessToken');
				$updatedRefferalValue=$this->Institute_model->updateAccessStatues($ipBased,$referralUrl,$accessToken,$id);
			    $no_of_refs=$this->input->post('no_of_refs');
				//print '<pre>';
				//print_r($no_of_refs);
				//die('<br>tt');
				/*print '<pre>';
				print_r($_REQUEST['allgriddata']);
				die('<br>tt');*/
				$alldata = explode('&',$_REQUEST['allgriddata']);
				$alldatarray = array();
				//echo "<pre>";print_r($alldata);
				foreach($alldata as $dvalue){
					$innerdata = explode("=",$dvalue);
					$alldatarray[$innerdata[0]] = urldecode($innerdata[1]);
				}
				//echo "<pre>".$no_of_refs;print_r($alldatarray);die;
				
				for($i=1;$i<=$no_of_refs;$i++){
					if(isset($alldatarray['insEmail'.$i])){
					//$email_auth=$this->input->post('insEmail'.$i);
					$email_auth=$alldatarray['insEmail'.$i];
					$first_name=$alldatarray['insFirstName'.$i];
					$last_name=$alldatarray['insLastName'.$i];
					$product_id=$alldatarray['insProductid'.$i];
				if(!empty($email_auth) && !empty($first_name) && !empty($last_name)){
			    $this->Institute_model->add_EmailAuthentication($masterDet,$email_auth,$first_name,$last_name,$product_id);
					}
					}
				}
				redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
			}
			else if($id > 0){
				//die("test");
			$this->load->model('Institute_model');
			$User_data = $this->Institute_model->get_Institute($id);
			
			$master_id=$User_data[0]->m_masterid;
			$licence_type=$User_data[0]->m_licence_type;
			if($licence_type=='IPBASED'){
				$data['ip_detail']='IPBASED';
			$data['email_detail']='';
			}else if($licence_type=='MULTI'){
				$data['ip_detail']='';
			$data['email_detail']='MULTI';
			}else if($licence_type!=''){
				$licence=explode(",",$licence_type);
				$data['ip_detail']=$licence[0];
			$data['email_detail']=$licence[1];
			}
			else{ 
				$data['ip_detail']='';
			$data['email_detail']='';
			}
			
			$data['id']=$id;
			$data['masterid']=$User_data[0]->m_masterid;
			$data['sub_id']=$User_data[0]->m_subcustid;
			$data['cust_type']=$User_data[0]->m_custtype;
			$data['lablename']=$User_data[0]->m_lablename;
			$data['firstname']=$User_data[0]->m_firstname;
			$data['lastname']=$User_data[0]->m_lastname;
			$data['primarymail']=$User_data[0]->m_primaryemail;
			$data['onlinemale']=$User_data[0]->m_onlineemail;
			$data['admin']=$User_data[0]->admin_id;
			$data['adminstatus']=$User_data[0]->status;
			$orderId = $User_data[0]->m_orderid;
			//echo '<pre>';print_r($data); die;
			//print_r($data['status']); di
			//print_r($data['masterid']); die;
			$adminid=$this->Institute_model->get_Admin($orderId);
                        //new get admin by other way
                        if(!(isset($adminid[0]->id))){
                            //echo $orderId."dddd".$data->masterid;die;
                            $getNewAdmin = $this->Institute_model->get_AdminByOderId((array)$User_data[0]);
                            if(isset($getNewAdmin->master_id)){
                                $getNewAdminData = $this->Institute_model->get_AdminByMasterId($getNewAdmin->master_id);
                            }
                            $data['admin_id']=$getNewAdminData[0]->id;
                            $data['admin_firstname']=$getNewAdminData[0]->m_lablename;
                            
                        }else{
                            //print_r($adminid);   die;
                            $data['admin_id']=$adminid[0]->id;
                            $data['admin_firstname']=$adminid[0]->m_lablename;
                        }
                        
                        
			
			//$data['admin_lastname']=$adminid[0]->m_lastname;
			//$data['status']=$adminid[0]->status;
			
			 
			$data['subscriptions']=$this->Institute_model->get_AllSubscriptions($master_id);
		//echo "<pre>";print_r($data); die;
				$data['allIPaddres']=$this->Institute_model->get_AllIpAddress($master_id);
				//echo "<pre>";print_r($data['allIPaddres']); die;
				$data['allRefferals']=$this->Institute_model->get_AllEmails($master_id);
				//echo "<pre>";print_r($data['allRefferals']); die;
				$data['ipaddress']=$this->Institute_model->list_AllIpVersions();
				$data['status']=$this->Institute_model->list_Status();
				$data['allAccessToken']=$this->Institute_model->get_AllAccessTokens($id);
		       	$this->load->pagetemplate('addInstitute_form',$data);  
			}
		}
    }  
	public function search()
	{
		$productid=$_POST['productid'];
		$masterid=$_POST['masterid'];
		
		$data['allRefferals']=$this->Institute_model->get_AllEmails($masterid,$productid);
		$return=json_encode($data['allRefferals']);
		echo $return; die;
		//print_r($data['allRefferals']); die;
		//redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
	}
	public function editeurlInstitueemail()
	{
	$urlid=$_POST['emailCodes'];
	$data['allediteemail']=$this->Institute_model->editerow($urlid);
  $return=json_encode($data['allediteemail']);
		echo $return; die;	
	}
	
	public function checkediteInstituteEmailID()
	{
		$editemails=$_POST['editemail'];
		$hrefids=$_POST['hrefid'];
		$editeorderids=$_POST['editeorderid'];
		
		
		$dataRows=$this->Institute_model->checkediterow($editemails,$hrefids,$editeorderids);
		if($dataRows>0)
		{
    			echo true;
    	}
    	else {
    		echo false;
    	}
	}
	
	function checkaddemailInstituteEmailID()
	{
	$addemails=$_POST['addemail'];	
	$addorderids=$_POST['addorderid'];
	$dataRows=$this->Institute_model->checkaddrow($addemails,$addorderids);
		if($dataRows>0)
		{
    			echo true;
    	}
    	else {
    		echo false;
    	}
		
	}
	
	public function rowupdate()
	{
		$auivalue=$_POST['auivalue'];
		$rowsid=$_POST['rowsid'];
		$usermaster=$_POST['masterid'];
		//echo $rowsid; die;
		$data=$this->Institute_model->updaterow($rowsid,$auivalue);
		//$countRows=$this->Institute_model->countinsertip($usermaster);
		//if($countRows=='1'){
		  //$this->SendEmailIp($usermaster);
	//	}
		echo $data; die;
	}
	
	public function searchips()
	{
		$productid=$_POST['productid'];
		$masterid=$_POST['masterid'];
		
		$data['allIPaddres']=$this->Institute_model->get_AllIpAddress($masterid,$productid);
		$return=json_encode($data['allIPaddres']);
		echo $return; die;
		//print_r($data['allRefferals']); die;
		//redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
	}
	
	function deleteiprow()
	{
	$rowid=$_POST['rowid'];
   
      $data=$this->Institute_model->Deletet_Ip_Row($rowid);   
      echo $data; die;
		// header("Refresh:0");
	
	}
	
	
		public function searchip()
	{
		
		$productid=$_POST['productid'];
		$masterid=$_POST['masterid'];
		
		$data['allRefferals']=$this->Institute_model->get_AllEmails($masterid,$productid);
		$return=json_encode($data['allRefferals']);
		echo $return; die;
		//print_r($data['allRefferals']); die;
		//redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
	}
	##########UPdate User License############
	public function UpdateLicense(){
	   	       $master_id=$this->input->post('master_id');
			   $licence_count=$this->input->post('licence_count');
			    $order_id=$this->input->post('orderid');
		      // $start_date=$this->input->post('startDate');
              // $end_date=$this->input->post('endDate');
               $data = array(
		     	'Nigotiate_count'=>$licence_count,
				'updated_date'=>date('Y-m-d')
			  );
		  // print_r($data); die;
		   $update=$this->Institute_model->updateLicense($master_id,$order_id,$data);
		   	if($update){
			 echo "1"; die;
			}	
			die;
	}
	###############Function for view Institutes
	public function InstituteList($id='')
	{
		$sortBy = $this->input->get('sortby');
		 $arr = explode(" ",$sortBy);
			$sortBy = $arr[0];
	         $event_id = $arr[1];
		if (!$this->tank_auth->is_logged_in_admin(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$searchMastercustomerid = $this->input->post('mastercustomerid');
			$searchOrder = $this->input->post('orederid');
			$searchLablename = $this->input->post('lablename');
			//echo $searchLablename; die;
			$name = explode(" ",$searchLablename); 
			//print_r($name);die;
            $fname=	$name[0];
            $lname=$name[1];
			
			//echo $fname."//".$lname; die; 
			if($event_id=='')
			{
			$data['users'] = $this->Institute_model->list_Institute($this->userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname);
			$data['users1']=$this->Institute_model->get_multiuser($id);
			}
			else if($event_id=="InstituteList")
			{
			$data['users'] = $this->Institute_model->list_Institute($this->userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname);
			$data['users1']=$this->Institute_model->get_multiuser($id);
			}
			else if($event_id=="2")
			{
			$data['users'] = $this->Institute_model->list_InstituteII($this->userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname);
			$data['users1']=$this->Institute_model->get_multiuser($id);
			}
			else if($event_id=="1")
			{
			$data['users'] = $this->Institute_model->list_InstituteI($this->userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname);
			$data['users1']=$this->Institute_model->get_multiuser($id);
			}
			
			else if($event_id=="4")
			{
			$data['users'] = $this->Institute_model->list_InstituteIII($this->userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname);
			$data['users1']=$this->Institute_model->get_multiuser($id);
			}
			//convarting array by key
			$newusersarray = array();
			//echo'<pre>';print_r($data['users']); echo"<hr>";
			
			//echo'<pre>';print_r($data['users1']); echo"<hr>";die;
			foreach($data['users1'] as $newvalue){
					$newusersarray[$newvalue->m_orderid] = $newvalue;
			}
			
			//echo'<pre>';print_r($data['users']); echo "<hr>";
			foreach($data['users'] as $frnkey=>$filteredresult){
				if (array_key_exists($filteredresult->m_orderid, $newusersarray)) {
					$data['users'][$frnkey] = $newusersarray[$filteredresult->m_orderid];
				}
			}
			
			
			//in_array();
			//echo'<pre>';print_r($data['users']); die;
			//remove duplicates
			$finalarrayforusers = array();
			foreach($data['users'] as $frnkey=>$filteredresult){
				
					$finalarrayforusers[$filteredresult->m_orderid] = $filteredresult;
				
			}
			$data['users'] = $finalarrayforusers;
			//echo'<pre>';print_r($data['users']); die;
			
			
			if($id==4){
				$multiipuser =$this->Institute_model->get_multiuserAll();
				//echo "<pre>qqqqqq";print_r($multiipuser);echo "<hr>";
				//echo "<pre>qqqq222qq";print_r($data['users']);
				$data['users'] = array_merge($multiipuser,$data['users']);
				//echo "<pre>qqqq222qq";print_r($finalarraymixed);die;
			}
				
			
			
			$data['mastercustomerid']=$searchMastercustomerid;
			$data['orederidSearchValue']=$searchOrder;
			$data['lablenameValue']=$searchLablename;
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->userinfo();
			$this->session->set_flashdata('msg', '');
			$this->load->pagetemplate('Institute_list',$data);
		}
		
	}
	############function for deleting the institute
	public function deleteInstitute($instituteId){
		//echo $instituteId;
		//exit;
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		$data['institutes'] = $this->Institute_model->deleteInstitute($instituteId);
		$this->session->set_userdata('last_url','');
		$data['userInfo'] = $this->userinfo();
		$this->session->set_flashdata('msg', 'Institute Deleted');
		redirect('institutePage/InstituteList', 'refresh');
		}
	}		
	############Function for uploading logo
	public function do_upload()
	{
		//print_r($_FILES['userfile']);
		$target_dir = "./uploads/";
		$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
		move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file);
    } 
    ############################Function For checking whether given institute Id is already exist in table or not
    public function checkInstituteID()
    {
    	if($this->input->is_ajax_request()) {
    	$instituteCode=$this->input->post('instituteCode');
    	$numRows=$this->Institute_model->getInstituteDetails($instituteCode);
		//echo '<pre>'; print_r($numRows); die;
    	if($numRows>0)
    		echo true;
    	}
    	else {
    		echo false;
    	}
    }
   ###################Function for Checking Institute Email Id Whether Exist Or Not
    public function checkInstituteEmailID(){
    	if($this->input->is_ajax_request()) {
    		$adminEmail=$this->input->post('adminEmail');
    		$numRows=$this->Institute_model->getInstituteAdminEmail($adminEmail);
    		if($numRows>0)
    			echo true;
    	}
    	else {
    		echo false;
    	}
    	
    }
   ##################Function for Checking User Name Whether Exist Or Not
   public function checkInstituteUserName(){
   	if($this->input->is_ajax_request()) {
   		$adminUserName=$this->input->post('adminUserName');
   		$numRows=$this->Institute_model->getInstituteAdminUserName($adminUserName);
   		if($numRows>0)
   			echo true;
   			else {
   				echo false;
   			}
   	}
 }
 #############################Function For Checking IP Range Of existing Institute
 ##################Function for Checking User Name Whether Exist Or Not
 public function checkIPRange(){
	// echo "sdfsf"; die;
 	if($this->input->is_ajax_request()) {
 		$IPRangeValue=$this->input->post('IPRangeValue');
 		$numRows=$this->Institute_model->getInstituteIPRangeValue($IPRangeValue);
 		if($numRows>0)
 			echo true;
 			else {
 				echo false;
 			}
 	}
 }
 
 
 
  public function checkIPPopupRange(){
	// echo "sdfsf"; die;
 
 		$MinIPRange=$_POST['MinIPRange'];
		$MaxIPRange=$_POST['MaxIPRange'];
		$productid=$_POST['productid'];
		$masterid=$_POST['masterid'];
		//echo $masterid; die; 
     $numRows=$this->Institute_model->getInstituteIPPopupRangeValue($MinIPRange,$MaxIPRange,$productid,$masterid);
 		if($numRows>0)
 			echo true;
 			else {
 				echo false;
 			}
 	
 }
 
 public function updateaddemail()
 {
	// echo"fdfd"; die;
	  $LicenceInfo = $this->session->userdata ( 'LicenceInfo' );
	 $inshrefid=$this->input->post('edithrefid');
	 $insEmail=$this->input->post('Email');
	  $insFirstName=$this->input->post('insFirstName1');
	  $insLastName=$this->input->post('insLastName1');
	  $id=$this->input->post('userid');
	  $numRows=$this->Institute_model->updateurldata($inshrefid, $insEmail,$insFirstName, $insLastName);
	   redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
 }
 
 
 public function insertaddemail()
 {
	 
	// echo"sasas"; die;
	$LicenceInfo = $this->session->userdata ( 'LicenceInfo' );
    $insEmail=$this->input->post('insEmail'); 
	$insFirstName=$this->input->post('insFirstName');
	$insLastName=$this->input->post('insLastName');
	$id=$this->input->post('userid');
	$usermaster=$this->input->post('usermaster');
	$product_id=$this->input->post('Subscription');
	$arr = explode("#", $product_id);
	$product_id = $arr[1];
	$order_id = $arr[0];
	$product_name = $arr[2];
	 $data = array(
						'insEmail' => $insEmail,
                        'insFirstName' => $insFirstName,
						'insLastName' => $insLastName,
						'id' =>  $id,
						'usermaster' =>  $usermaster,
                        'productid'=>	$product_id	,
						'product_name'=>	$product_name,	
                        'order_id'=>$order_id						
                    );
				//	print_r($data); die;
		$duplicatecheck = $this->Institute_model->isExistEmail($insEmail,$usermaster,$product_id);
    if($duplicatecheck)
	  {
		$msg1= "Email id for this license already exist.";
		$this->session->set_flashdata('messageadduser',$msg1);  
	  }					//print_r($data); die;
	   else
      {
	    $numRows=$this->Institute_model->getInsertemail($data,$LicenceInfo);
		///echo $numRows; die;
	    if($numRows=='1'){
	      $to_email=$insEmail;
		  $this->SendEmail($to_email,$usermaster); 
		   $this->session->set_flashdata('messageadduser', 'You have added subuser successfully.');
		  
	    }
		else{
			$msg1= " You can not add more than license count.";
			$this->session->set_flashdata('messageadduser',$msg1);  
		}
		}
		 redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
	
 }
 
 
 
 public function insertaddip()
 {
	//echo"ip"; die;
	 $LicenceInfo = $this->session->userdata ( 'LicenceInfo' );
	 //echo $LicenceInfo; die;
    $insIpVersion=$this->input->post('insIpVersionip'); 
	$insMinIp=$this->input->post('MinIp');
	$insMaxIp=$this->input->post('MaxIp');
	$id=$this->input->post('userid');
	$usermaster=$this->input->post('usermaster1');
	$product_id=$this->input->post('Subscription1');
	$ipStatus=$this->input->post('ipStatus1');
	
	 $data = array(
						'insIpVersion' => $insIpVersion,
                        'insMinIp' => $insMinIp,
						'insMaxIp' => $insMaxIp,
						'id' =>  $id,
						'usermaster' =>  $usermaster,
                        'productid'=>	$product_id,
                        'ipStatus'=>	$ipStatus					
                    );
					//print_r($data); die;
		
	    $numRows=$this->Institute_model->getInsertip($data);
		$countRows=$this->Institute_model->countinsertip($usermaster);
		if($countRows=='1' && $ipStatus=='1' ){
		  $this->SendEmailIp($usermaster);
		}
		if($numRows=='')
		{
		$msg1= "<h5><strong> You can not add more than license count.</strong></h5>";
							$this->session->set_flashdata('message',$msg1); 	
		}
		//echo $numRows; die;
	   
		redirect('institutePage/addInstitute/'.$id.'?tab=5', 'refresh');
	
 }
 public function deleteInstituteemail()
 {
     //echo "hello"; die;
	 $emails = $_POST['emailCode'];
	 $this->Institute_model->deleteemail($emails); 
	
 }
  public function SendEmail($to_email,$usermaster){
        $data['name']=$this->Institute_model->fetchDetail($to_email);
		$data['corporateemail']=$this->Institute_model->corporateemail( $data['name'][0]->m_orderid);
		$body=$this->load->view('multiusermsg',$data,true); 
		$this->email->to($to_email);
		$this->email->from('ascelibrary@asce.org','ASCE Publications');
		$this->email->subject('You are invited to join ASCE 7 Online Platform');
		$this->email->message($body);
		$send=$this->email->send();
		$this->email->send();  
		//echo $this->email->print_debugger();die;		
  }
  
  public function SendEmailIp($usermaster){
        //$from=$this->config->item('from');
		$subject=$this->config->item('ipsubject');
		$orderId= $this->Institute_model->fetchDetailip($usermaster);
		//print_r($orderId[0]->m_orderid ); die;
		$to_email= $this->Institute_model->fetchcarporationemail($orderId[0]->m_orderid);
		$firstname=$to_email['0']->m_firstname;
		$lastname=$to_email['0']->m_lastname;
		$primaryemail=$to_email['0']->m_primaryemail;
		$data['name']=array(
		'firstname'=>$firstname,
		'lastname' =>$lastname
		);
		$body=$this->load->view('ipbasedmessage',$data,true); 
		$this->email->to($primaryemail);
		$this->email->from('ascelibrary@asce.org','ASCE Publications');
		$this->email->subject($subject);
		$this->email->message($body);
		$this->email->send();  
		//echo $this->email->print_debugger();die;		
} 

  
 public function deleteAdmin($adminid){
		//echo $adminid; die;
		//exit;
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		$data['institutes'] = $this->Institute_model->deleteAdmin($adminid);
		$this->session->set_userdata('last_url','');
		$data['userInfo'] = $this->userinfo();
		$this->session->set_flashdata('msg', 'You Have Delete Successfully.');
		
		redirect('institutePage/InstituteList', 'refresh');
		}
	} 
}
?>
