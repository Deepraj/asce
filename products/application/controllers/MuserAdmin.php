<?php
error_reporting(0);
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class MuserAdmin extends CI_Controller {
	
	function __construct() {
		// Construct the parent class
		parent::__construct ();
		$this->load->helper (array (
				'form',
				'url',
				'xml',
				'security',
				'directory' 
		));
		
		$this->load->database ();
		$this->load->model ( 'MuserModel' );
		$this->load->library(array('email'));
		$this->load->library ('session');
		$this->load->library('form_validation');
		if(empty($this->session->userdata("MasterCustomermainId"))){
            redirect(site_url(),'refresh');
		 }
		$this->lang->load('ion_auth');
		
	}
	public function index(){
	if($this->input->post('submit')){ 
	 $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
	 $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]|max_length[20]|alpha');
	 $this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required|min_length[3]|max_length[20]|alpha');
	 $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]|max_length[20]|alpha');
	// print_r($_POST); die;
	  $id=$this->input->post('id');
	  $data= array(
       'email' => $this->input->post('email'),
	   'first_name' => $this->input->post('first_name'),
	   'middle_name' => $this->input->post('middle_name'),
	   'last_name' => $this->input->post('last_name')
      );
	 
	 $update=$this->MuserModel->updateSubUser($id,$data);
	 $this->session->set_flashdata('message', 'You have updated subuser successfully.');
	}
	
	else if($this->input->post('imageupload') )
	     {
	$usermaster=$this->input->post('usermaster');
			  $product_id=$this->input->post('Subscription');
			  $arr = explode("#", $product_id);
	          $product_id = $arr[1];
	         $order_id = $arr[0];
	         $product_name = $arr[2];
			// echo  $order_id."//". $product_name."//".$product_id."//////".$usermaster; die;
	 $licence_count=$this->MuserModel->Getlicencecunt($usermaster,$product_id);
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
					  $this->session->set_flashdata('bulkimportmessage',$msg);
				  }else{
				  $xmlcount=count($data11);
				  //print_r($xmlcount); 
				  //$dsd =  $xmlcount/5;
				 $msg3="<h4>Total ".$xmlcount." records</h4>";
				 $warningmsg = "<span style='color:red,'>You  can not add more than ".$licencecount."  users </span>";
		
				  foreach($data11 as $totaldata){
					  $duplicatecheck = $this->MuserModel->isExistEmail($totaldata['PrimaryEmailAddress'],$usermaster,$product_id);
					if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
					}
				     $val= $this->MuserModel->insertxml($totaldata);
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
			$this->session->set_flashdata('bulkimportmessage',$warningmsg.$msg3.$msg.$msg1.$msg2.$msg5);
			
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
			  //$alldata = $data = fgetcsv($handle, 1000, ",");
			  
              while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
	           {
				   
			    
				  if($totval==0)
				  {
					  $totval++;
					  continue;
				  }
				  $totval++;
               $num = count($data);
			   // print_r($data); die;
			   
               for ($c=0; $c < $num; $c++){
				$data[$c] = $data[$c];
			    $aa=count($data); 
              }
			  $aa=count($data); 
			// print_r($data); die;
			  if($num!=3){
				  $notinformat[]= "Row ".$totval." is not in valid format.";
			  }else{
				 //echo "<pre>123";print_r($data);echo "<hr>"; 
			$duplicatecheck = $this->MuserModel->isExistEmail($data[2],$usermaster,$product_id);
					if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
					}
                 $val= $this->MuserModel->insertcsv($data,$usermaster,$product_id,$product_name,$order_id);
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
						{//echo "dsds"; die;
						    $to_email=$val['insertemail']; 
						//	echo "<pre>123".$to_email;print_r($usermaster);echo "<hr>";
			                $this->SendEmail($to_email,$usermaster);
							$inserted[] = $val['error'];
							
							}
						}
			  }
						
            }
			//die("Hello");
             fclose($handle);
			 //die("Hello");
           }else{
		   $msg6= "<h5><strong>File is empty.Please upload a not empty file.</strong></h5>";
		   $this->session->set_flashdata('bulkimportmessage',$msg6);
		   //echo "dsdsdsd"; die;
		   unlink('public/image/'.$image);
		   redirect('MuserAdmin', 'refresh');
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
						$this->session->set_flashdata('bulkimportmessage',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
		    if($val = true)
					{
						//echo "submit"; die;
						unlink('public/image/'.$image);
						redirect('MuserAdmin', 'refresh');
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
			     $duplicatecheck = $this->MuserModel->isExistEmail($val['C'],$usermaster,$product_id);
			   if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
			   }
		     
			$amar = $this->MuserModel->insertxlxs($val,$usermaster,$product_id,$product_name,$order_id);
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
						
			$this->session->set_flashdata('bulkimportmessage',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
		
						unlink('public/image/'.$image);
				} 		
						
			//redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
			  redirect('MuserAdmin', 'refresh');
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
			   $this->session->set_flashdata('bulkimportmessage', $msg6);
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
			   $duplicatecheck = $this->MuserModel->isExistEmail($val['C'],$usermaster,$product_id);
			   if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
			   }  
			//echo "<pre>";   print_r($val); die;
			$amar = $this->MuserModel->insertxlxs($val,$usermaster,$product_id,$product_name,$order_id);
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
						
			$this->session->set_flashdata('bulkimportmessage',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
		
						unlink('public/image/'.$image);
						
			}			
						//redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
					redirect('MuserAdmin', 'refresh');
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
   
                    $duplicatecheck = $this->MuserModel->isExistEmail(trim($data['email']),$usermaster,$product_id);
			
					if($duplicatecheck){
				    $duplicate[] = $duplicatecheck;
					continue;
					}
					$val= $this->MuserModel->inserttxt($data);
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
							$this->session->set_flashdata('bulkimportmessage',$msg1);
						}else{
						$this->session->set_flashdata('bulkimportmessage',$warningmsg.$msg3.$invalidmsg.$msg.$msg1.$msg2.$msg5);
						}
			 if($val == true)
					{
						unlink('public/image/'.$image);
						//echo "submit";
						//redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
						redirect('MuserAdmin', 'refresh');
					}
				} else {
               
			                $msg1= "<h5><strong>Your text file is empty .</strong></h5>";
							$this->session->set_flashdata('bulkimportmessage',$msg1);
							//redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
							redirect('MuserAdmin', 'refresh');
          }	
			break;
		 }			
		
	}
	 $master_id=$this->session->userdata('MasterCustomermainId');
	// $data['mid']=$master_id;
	  $orderid=$this->MuserModel->checkCorporaitionMultiAdmin ( $master_id );
	 //echo $orderid[0]->m_orderid; die;
	  $data['subscriptions']=$this->MuserModel->get_Allproduct($master_id);
	  $CarporationAdmin=$this->MuserModel->checkOrderidMultiAdmin ( $orderid[0]->m_orderid);
	 // $CarporationAdmin[0]->master_id
	  if(!empty($CarporationAdmin))
	 {
		
		$data['SubUserList']=$this->MuserModel->SubUserlist($CarporationAdmin[0]->m_masterid);
		
	 }
    else{
	$data['SubUserList']=$this->MuserModel->SubUserlist($master_id);
   }	 
	 $this->load->view('pagetemplate/header-inner', $data); 
	 $this->load->view('Muser',$data);
	 
	}
     public function search()
	{
		$productid=$_POST['productid'];
		$masterid=$_POST['masterid'];
		//echo $masterid; die; 
		$data['allRefferals']=$this->MuserModel->get_AllEmails($masterid,$productid);
		$return=json_encode($data['allRefferals']);
		echo $return; die;
		//print_r($data['allRefferals']); die;
		//redirect('institutePage/addInstitute/'.$id.'/'.$LicenceInfo.'?tab=6', 'refresh');
	 }
	 
	function deleteSubUser(){
	 $id=$this->uri->segment('3');
	 $delete=$this->MuserModel->deleteSubUser($id);
	// echo $delete; die;
	 $this->session->set_flashdata('message', 'You have deleted subuser successfully.');
	 redirect('MuserAdmin', 'refresh');
	}
	
	function EditSubUser(){
	$id=$_GET['id'];
 	$data['getSubUser']=$this->MuserModel->EditSubUser($id);
	//print_r($data['getSubUser']); die;
	$this->load->view('pagetemplate/header',$data);
	$this->load->view('ManageSubUser_form',$data);
	}
	
	function SortbyUser(){
	 $master_id=$this->session->userdata('MasterCustomermainId');
	 $sortBy = $this->input->get('sortby');
	 $email=$this->input->post('email');
	 $first_name=$this->input->post('first_name');
	 $data['subscriptions']=$this->MuserModel->get_Allproduct($master_id);
	 $data['SubUserList']=$this->MuserModel->fetchdata($email,$first_name,$sortBy,$master_id);
	 $this->load->view('pagetemplate/header',$data); 
	 $this->load->view('Muser',$data);
	}
	
	
	public function insertaddemail()
    {
	$LicenceInfo = $this->session->userdata ( 'LicenceInfo' );
    $insEmail=$this->input->post('insEmail'); 
	$insFirstName=$this->input->post('insFirstName');
	$insLastName=$this->input->post('insLastName');
	$product_id=$this->input->post('Subscription');
	$arr = explode("#", $product_id);
	//print_r($arr); die;
	$product_id = $arr[1];
	$order_id = $arr[0];
	$product_name = $arr[2];
	//$id=$this->input->post('userid');
	$usermaster=$this->input->post('usermaster');
	//echo $usermaster; die;
	 $data = array(
						'insEmail' => $insEmail,
                        'insFirstName' => $insFirstName,
						'insLastName' => $insLastName,
						'product_id' => $product_id,
						 'order_id'=>$order_id,
                          'product_name'=>	$product_name,					 
						'usermaster' =>  $usermaster	
                    );
					//print_r($data); die;
	$duplicatecheck = $this->MuserModel->isExistEmail($insEmail,$usermaster,$product_id);
	if($duplicatecheck)
	  {
		$msg1= "<h5><strong>Email id for this license already exist.</strong></h5>";
							$this->session->set_flashdata('message',$msg1);  
	  }	
				//print_r($data); die;
				else
     {
	    $numRows=$this->MuserModel->getInsertemail($data,$LicenceInfo);
		//echo $numRows; die;
	    if($numRows=='1'){
		$this->session->set_flashdata('message', 'You have added subuser successfully.');
	      $to_email=$insEmail;
		  $this->SendEmail($to_email,$usermaster); 
		  
	    }
		else{
		
			$msg2= $this->lang->line('exceed_user');
			$this->session->set_flashdata('message',$msg2);
		}
		}
		 redirect('MuserAdmin', 'refresh');
   }
   
    public function SendEmail($to_email,$usermaster){
        $data['name']=$this->MuserModel->fetchDetailsubuser($to_email);
		$data['corporateemail']=$this->MuserModel->corporateemail( $data['name'][0]->m_orderid);
		$body=$this->load->view('multiusermsg',$data,true); 
                $to_email = 'gltestasce@gmail.com';
		$this->email->to($to_email);
		$this->email->from('ascelibrary@asce.org','ASCE Publications');
		$this->email->subject('You are invited to join ASCE 7 Online Platform');
		$this->email->message($body);
		$send=$this->email->send();
	//	echo $this->email->print_debugger();die;		
  }
  
   function sendmailSubUser($to_email)
   {
		$data['name']=$this->MuserModel->fetchDetail($to_email);
		$data['corporateemail']=$this->MuserModel->corporateemail( $data['name'][0]->m_orderid);
		$to_email = 'gltestasce@gmail.com';
                $this->email->to($to_email);
                $body=$this->load->view('TemplateMessages',$data,True); 
		$this->email->from('ascelibrary@asce.org','ASCE Publications');
		$this->email->subject('You are invited to join ASCE 7 Online Platform');
		$this->email->message($body);
		$send=$this->email->send();
		if($send){
			$msg=$this->lang->line('send_msg');
		$this->session->set_flashdata('message',$msg);
		}
		redirect('MuserAdmin', 'refresh');
	
    }	
}
