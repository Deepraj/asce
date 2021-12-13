<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class addProduct extends MY_Controller  {
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
	
	
	 public function index($id=0)
    {
		
		
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			
			 $data = array();
			 $data['h']=$this->Addproduct_model->fetchSubscription();
		     $data['book']=$this->Addproduct_model->fetchbook();
			 
			if($this->input->post('submit'))
			{
				$masterproductid = $this->input->post('product_id');
				$masterproductcode = $this->input->post('product_code');
				$productname = $this->input->post('ProductName');				
				$Subscription = $this->input->post('Subscription');
				$booknames = $this->input->post('basicOptgroup');			
				if(isset($booknames))
				{
					$bookname = implode(",",$booknames);
					
				} 
				
					
				$MemberPrice = $this->input->post('MemberPrice');
			    $NonMemberPrice = $this->input->post('NonMemberPrice'); 
                $ProductDiscription = $this->input->post('ProductDiscription');
				 $status = $this->input->post('status');
				
				 if($status =='')
				 {
					$status = 0; 
					
				 }
				
				if($id ==0){
				$this->form_validation->set_rules('product_id', 'master product id', 'required|is_unique[mps_product.master_product_id]|alpha_numeric');
				}
				
				if($id>0)
				{
					$Duplcateprodid = $this->input->post('duplimaster');
					if($masterproductid!=$Duplcateprodid){
					$this->form_validation->set_rules('product_id', 'master product id', 'required|is_unique[mps_product.master_product_id]|numeric|max_length[20]');
					}
					else
					{
						
					}
				}
				
				$this->form_validation->set_rules('product_code', 'master product code', 'required|alpha_numeric');
				
				$this->form_validation->set_rules('NonMemberPrice', 'price', 'required|numeric|max_length[8]');
				 $this->form_validation->set_rules('MemberPrice', 'member price', 'required|numeric|max_length[8]');
				if(!$booknames){
				$this->form_validation->set_rules('basicOptgroup','book name','required');
                }
			
				$this->form_validation->set_rules('Subscription', 'subscription', 'required');
				$this->form_validation->set_rules('ProductName', 'product name', 'trim|required');
              	$this->form_validation->set_rules('ProductDiscription', 'product description', 'required');
				if (!$this->form_validation->run() == FALSE){
					if($id>0){
						
						$val = $this->Addproduct_model->udpateProduct($masterproductid,$masterproductcode,$productname,$Subscription,$bookname,$MemberPrice,$NonMemberPrice,$ProductDiscription,$status,$id);
					}else
					{
						 $val = $this->Addproduct_model->product($masterproductid,$masterproductcode,$productname,$Subscription,$bookname,$MemberPrice,$NonMemberPrice,$ProductDiscription,$status,$id); 
					}
					
					if($val = true)
					{
						
						redirect('addProduct/productlist');
					}
				}
             				

		}
			else{
				if($id>0)
				{
					$val = $this->Addproduct_model->fetchproductdetail($id); 
					
					$data['productdetail']=(array)$val;
					
				}
			
			}
		       
		}
		$data['userInfo'] = $this->userinfo();
		if(isset($id) && $id>0)
		$data['id']=$id;
        $data['bookid']=$this->Addproduct_model->update_book($id);
		   /* echo "<pre>";s
       print_r($data); die;   */ 
		$this->load->pagetemplate('addProduct_form', $data);
		
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
//--------change here----start--------------------------

//-------change here------end---------------------- 

   function productlist($id='')
   {


 if (!$this->tank_auth->is_logged_in_admin(TRUE)) // Users not logged in
    {
            $this->session->set_userdata('last_url',$this->uri->segment(1));
             redirect('auth/', 'refresh');
    }


    $sortBy = $this->input->get('sortby');
	$searchProductCode = $this->input->post('productcodesearch');
	$searchProductName = $this->input->post('productnamesearch');
	$searchBookName = $this->input->post('booknamesearch');	
	$data['list'] = $this->Addproduct_model->fetchdata($searchProductCode,$searchProductName,$searchBookName,$sortBy,$id);
	//echo"<pre>";print_r($data['list']); die;
	$data['productcodesearch']=$searchProductCode;
	$data['productnamesearch']=$searchProductName;
	$data['booknamesearch']=$searchBookName;
	$data['userInfo'] = $this->userinfo();
    $this->load->pagetemplate('product_list',$data);	
  }
    public function booklist(){
	$id=$_POST['product_id'];
	$val = $this->Addproduct_model->booklist($id);
	echo "<span style='font-weight: bold;'>BOOK NAME:</span>";
	foreach($val as  $k=>$h)
	 {
       echo "<div class='booktit;'>".$h->m_boktitle."</div>";	  
	}
  }
    
   public function deleteProduct($productId){
		//echo $instituteId;
		//exit;
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		$data['institutes'] = $this->Addproduct_model->deleteProduct($productId);
		$this->session->set_userdata('last_url','');
		$data['userInfo'] = $this->userinfo();
		$this->session->set_flashdata('message', 'You Have Delete Successfully.');
		
		redirect('addProduct/productlist', 'refresh');
		}
	}
	public function update_book()
	{
	    //$val=$_GET['id'];
		echo $val;
	}
  
	
}

?>
