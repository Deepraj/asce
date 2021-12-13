<?php
error_reporting(0);
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
require_once (APPPATH . '/libraries/phpass-0.1/PasswordHash.php');
class Addproduct_model extends CI_Model {
	private $tableName='mps_product';
	function __construct() {
		parent::__construct ();
	}
	
	function fetchSubscription()
	  {
		$this->db->select('*');
		$this->db->from('mps_license');
		return $this->db->get()->result();
		
	  }
	  
	  function fetchbook()
	  {
		$this->db->select('*');
		$this->db->from('m_book');
		return $this->db->get()->result();
	    
	  }
	  
 ////------------change here-------start--------------
	
	  
	//--------------------end--------------------------  
	
	  
	function product($masterproductid='',$masterproductcode='',$productname='',$Subscription='',$bookname='',$MemberPrice='',$NonMemberPrice='',$ProductDiscription='',$status,$id=0)//--change here------
	{ 	  
	  
	  $arr=explode(',',$bookname);
	  $insert=$this->db->insert('mps_product',array('master_product_id'=>$masterproductid,'product_code'=>$masterproductcode,'product_name'=>$productname,'member_price'=>$MemberPrice,'nonmember_price'=>$NonMemberPrice,'product_discription'=>$ProductDiscription,'license_id'=>$Subscription,'status'=>$status)); 
	  $lastid = $this->db->insert_id();
	  if($insert){
	  for($i=0;$i<count($arr); $i++){
	  $this->db->insert('asce_product_book',array('product_id'=>$lastid,'book_id'=>$arr[$i],'license_id'=>$Subscription,'status'=>$status));
	  }
	 }
	return true;
	}
	//for update
	function udpateProduct($masterproductid='',$masterproductcode='',$productname='',$Subscription='',$bookname='',$MemberPrice='',$NonMemberPrice='',$ProductDiscription='',$status,$id=0)
	{
	     $arr=explode(',',$bookname);
		//	echo $bookname; die;
		$allData = array(
		'master_product_id'=>$masterproductid,
		'product_code'=>$masterproductcode,
		'product_name'=>$productname,
		'product_discription'=>$ProductDiscription,
		'license_id'=>$Subscription,
		'member_price'=>$MemberPrice,
		'status'=>$status,
		'nonmember_price'=>$NonMemberPrice
		 );
		$this->db->set($allData);
		$this->db->where('product_id', $id);
		$update=$this->db->update($this->tableName);
      if($update){
	    $delete=$this->db->delete( 'asce_product_book', array (
				'product_id' => $id 
		) );
       if($delete){ 
	  for($i=0;$i<count($arr); $i++){
	  $this->db->insert('asce_product_book',array('product_id'=>$id,'book_id'=>$arr[$i],'license_id'=>$Subscription,'status'=>$status));
	  }
	 }			
	}
	}
	
	//------change here-------------------------------
	function fetchdata($searchProductCode,$searchProductName,$searchProductId,$sortBy,$id)
	{ 
	                   $searchProductCode=trim($searchProductCode);
		    	       $searchProductName=trim($searchProductName);
		    	       $searchProductId=trim($searchProductId);
	if($id==1){
        $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		 where mps_product.license_id='1' 
		GROUP BY asce_product_book.product_id ";
		$result = $this->db->query($query)->result();
		/* $this->db->select('P.*,GROUP_CONCAT(S.m_booktitle)as Booktitle');
		$this->db->from('m_product_book as P');
		$this->db->where(array('P.license_id' => '1' ));
		$this->db->join('m_book as S','FIND_IN_SET(S.m_bookid,P.book_id )  > 0','',false);
		$this->db->group_by("P.product_id", "asce");
		$result = $this->db->get()->result(); 
		   echo "<pre>";*/
		   
		  return $result;
		
	}else if($id==2){
		    $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
	where (mps_product.license_id='2' or mps_product.license_id='3')
		GROUP BY asce_product_book.product_id ";
		   $result = $this->db->query($query)->result();
	//	 echo  $this->db->last_query(); die;
			/* $this->db->select('P.*,GROUP_CONCAT(S.m_booktitle)as Booktitle');
				$this->db->from('m_product_book as P');
				$this->db->where(array('P.license_id' => '2' ));
				$this->db->or_where(array('P.license_id' => '3' ));
				$this->db->join('m_book as S','FIND_IN_SET(S.m_bookid,P.book_id )  > 0','',false);
				$this->db->group_by("P.product_id", "asce");
				$result = $this->db->get()->result();
				/*  echo "<pre>";
		        print_r($result);die;   */
				return $result;
		}else{
		if($searchProductCode=='' && $searchProductName=='' && $searchProductId=='' && $sortBy==''){
		      $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		       GROUP BY asce_product_book.product_id ";
		           $result = $this->db->query($query)->result();
					
					/* $this->db->select('P.*,GROUP_CONCAT(S.m_booktitle)as Booktitle');
					$this->db->from('m_product_book as P');
					// $this->db->where(array('P.license_id' => '1' ));
					$this->db->join('m_book as S','FIND_IN_SET(S.m_bookid,P.book_id )  > 0','',false);
					$this->db->group_by("P.product_id", "asce");
					$result = $this->db->get()->result(); */ 
					 /*  echo "<pre>";
		            print_r($result);die;  */
					return $result;
	}else if($sortBy !=''){
	                $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		            inner join m_book on m_book.m_bokid=asce_product_book.book_id where mps_product.product_name LIKE '$sortBy%' 
		            GROUP BY asce_product_book.product_id";
				    
		            $result = $this->db->query($query)->result();
					 
					/* $this->db->select('P.*,GROUP_CONCAT(S.m_booktitle)as Booktitle');
					$this->db->from('m_product_book as P');
					// $this->db->where(array('P.license_id' => '1' ));
					$this->db->join('m_book as S','FIND_IN_SET(S.m_bookid,P.book_id )  > 0','',false);
					$this->db->group_by("P.product_id", "asce");
					//$this->db->join('m_book R','P.book_id=R.m_bokid','left');
					 $this->db->like('P.product_name',$sortBy, 'after');
					$result = $this->db->get()->result();*/
					/* echo "<pre>";
		            print_r($result);die; */  
					return $result;
		    }else if ($searchProductCode != '' || $searchProductName != '' || $searchProductId != '') {
			           
			        $where = '';
				if(!empty($searchProductCode))
				{
					$where.='mps_product.product_code like '.'"%'.$searchProductCode.'%" and ';
				}
				if(!empty($searchProductName)){
					$where.='mps_product.product_name like '.'"%'.$searchProductName.'%" and ';
				}
				if(!empty($searchProductId)){
					$where.='mps_product.master_product_id like '.'"%'.$searchProductId.'%" and ';
				}
			        $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		             inner join m_book on m_book.m_bokid=asce_product_book.book_id where ".$where." 1 GROUP BY asce_product_book.product_id ";
					 //echo $query; die;
			        $result = $this->db->query($query)->result();
					
/*					 $this->db->select('P.*,GROUP_CONCAT(S.m_boktitle)as Booktitle');
					$this->db->from('mps_product as P');
					// $this->db->where(array('P.license_id' => '1' ));
					$this->db->join('m_book as S','FIND_IN_SET(S.m_bokid,P.book_id )  > 0','',false);
					$this->db->group_by("P.product_id", "asce");
					 $this->db->join('mps_license L','P.license_id=L.license_id','left');
					$this->db->like('P.product_name',$searchProductName, 'after');
					$this->db->like('P.master_product_id',$searchProductId, 'after');
					$this->db->like('P.product_code',$searchProductCode, 'after'); 
					return $this->db->get()->result();
*/
					return $result;
			    }else if($searchProductCode != '' && $searchProductName != ''){
				     $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		             inner join m_book on m_book.m_bokid=asce_product_book.book_id where mps_product.product_id like '".$searchProductCode."' and mps_product.product_name like '".$searchProductName."'  GROUP BY asce_product_book.product_id ";
                    $result = $this->db->query($query)->result();
                     return $result;					
				}else if($searchProductName != '' && $searchProductId != ''){
				   $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		             inner join m_book on m_book.m_bokid=asce_product_book.book_id where mps_product.product_name like '".$searchProductName."' and mps_product.product_code like '".$searchProductId."'  GROUP BY asce_product_book.product_id ";
                    $result = $this->db->query($query)->result();
                     return $result;					     
				
				}else{
				   $query="select * from mps_product INNER JOIN asce_product_book on mps_product.product_id=asce_product_book.product_id 
		             inner join m_book on m_book.m_bokid=asce_product_book.book_id  GROUP BY asce_product_book.product_id ";
                    $result = $this->db->query($query)->result();
                     return $result;
				}
		}
	}
	
	
	
		function fetch_manage_reports($username,$ip,$searchfromdate,$searchtodate,$id)
	{
		
		               $username=trim($username);
		    	       $ip=trim($ip);
		    	       $searchfromdate=trim($searchfromdate);
					   $fromdates = date("Y-m-d", strtotime($searchfromdate));
					   //echo $fromdates ."<br>"; die;
					   $searchtodate=trim($searchtodate);
					   $todates = date("Y-m-d", strtotime($searchtodate));
					if($todates=='1970-01-01')
					{
					$todates="";	
					}
					if($fromdates=='1970-01-01')
					{
					$fromdates="";	
					}
		if($username!='' || $ip!='' || $fromdates!='' || $todates!='' )
		{
			$where = '';
			
			if(!empty($username))
			{
				$where.='user_name like '.'"%'.$username.'%" and ';
			}
			
			if(!empty($ip))
			{
				$where.='ip like '.'"%'.$ip.'%" and ';
				
			}
			if(!empty($fromdates))
			{
				$where.='start_date like '.'"%'.$fromdates.'%" and ';
				
			}
			if(!empty($todates))
			{
				$where.='start_date like '.'"%'.$todates.'%" and ';
				
			}
			$query="select * from asce_userlogs where ".$where."1 ";
					//echo $query; die;
			        $result = $this->db->query($query)->result();
					
				 return $result;	
		}			
						
						
	}
	function update_book($id){
	 $query="SELECT distinct asce_product_book.book_id  FROM  asce_product_book inner join m_book
	on asce_product_book.book_id=m_book.m_bokid where 
	asce_product_book.product_id='".$id."' group by asce_product_book.book_id" ; 
	/* $query="SELECT book_id  FROM  asce_product_book  where 
	product_id='".$id."' group by book_id" ; */
	$result = $this->db->query($query)->result();
	/* echo "<pre>";
	print_r($result); die; */
	return $result;
	}
	function selectallUser()
	{
	 $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_custtype,m_licence_type' );
			$this->db->from ( "asce_licences" );
			$this->db->where ( "(m_licence_type='MULTI' OR m_licence_type ='IPBASED')",null,false );
			//$this->db->where ('m_custtype','I');
			//$this->db->or_where ('m_custtype','C');
			
			$this->db->group_by('m_masterid');
			$this->db->order_by ( 'id', 'desc' );
			return $this->db->get()->result();	
			//$query = $this->db->get ();
			//$aa = $this->db->last_query();
			//echo $aa; die;
			//return $query->result ();
		
	}
	
	function selectIPReportdata($search_from_date,$search_to_date,$master_id,$email)
	{
      
	
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
	$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id'";
	$this->db->where($where);
	$this->db->group_by('sessid');
    $result = $this->db->get()->result();
	//echo $completeQuery = $this->db->last_query (); die;
	 return $result;
	// return $this->db->get()->result();
	 //echo $completeQuery = $this->db->last_query (); die;
	}
	
	function selectIPReportdata1($search_from_date,$search_to_date,$master_id,$email)
	{

	/* $year = DateTime::createFromFormat('Y', $year, new DateTimeZone('UTC'));
    $year= $year->getTimestamp();
    $starttimestamp = $year."-".$month."-"."01"." "."00:00:00";
	$datevalue = "01-".$month."-".$year." 00:00:00";
    $starttimestamp =  strtotime($datevalue);
	$enddatevalue = $month."-30-".$year." 00:00:00";
	$endtimestamp = $year."-".$month."-"."31"." "."23:58:00";
    $endtimestamp =  strtotime($enddatevalue);
	echo $datevalue."--".$enddatevalue;echo "<hr>";
	echo $starttimestamp."****".$endtimestamp;die;
	echo $year."///".$month."////".$master_id; die; */
	
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y-%m') ='$year-$month' AND master_id='$master_id' AND email!='$email' AND flag='1'";
	$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id' AND email!='$email' AND flag='1'";
	$this->db->where($where);
	$this->db->group_by('sessid');
	 return $this->db->get()->result();	
	}

         function list_book()
 {
  $this->db->select ( 'm_bokid,m_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice,m_bokthump,m_volnumber,m_volid' );
   $this->db->from ( 'm_book' );
   $this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
   $this->db->order_by ( 'm_createddate', 'desc' );
   // $this->db->where(array('m_createdby' =>$userid));
   $query = $this->db->get ();
   $finalQuery = $this->db->last_query ();
   //echo $finalQuery; die;
   return $query->result ();
 }
	
	function selectAllsessionReportdata($search_from_date,$search_to_date)
	{
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
		$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date'";
	$this->db->where($where);
	$this->db->group_by('sessid');
   return $this->db->get()->result();	
	//echo $completeQuery = $this->db->last_query (); die;	
	}
	
	
	
	function selectmonthReportdata($search_from_date,$search_to_date,$master_id,$email)
	{
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
		$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id'";
	$this->db->where($where);
   return $this->db->get()->result();	
	//echo $completeQuery = $this->db->last_query (); die;	
	}
	
	function selectbookReportdata($search_from_date,$search_to_date,$book_id)
	{
		//echo $search_from_date."////".$search_to_date."//".$book_id; die;
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
		$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND bookid='$book_id' AND flag='1'";
	$this->db->where($where);
   return $this->db->get()->result();	
	//echo $completeQuery = $this->db->last_query (); die;	
	}
	function checkCorporaitionMultiAdmin ( $master_id,$email ){
			//echo $OnlineEmailAddress; die;
		$this->db->select ( 'm_orderid' );
		$this->db->from ( 'asce_licences' );
		//$this->db->join ( 'asce_licences', 'asce_institute_email_auth.master_id=asce_licences.m_masterid', 'inner' );
		$this->db->where ( 'm_masterid="' . $master_id . '" and m_primaryemail="' . $email . '"' );
		$query = $this->db->get ()->result ();
		//print_r($query);
		return $query;
		//	$qq = $this->db->last_query ();
		 //echo $qq; die;
		
	}
	function checkOrderidMultiAdmin ( $orderid){
		$licencetype="C";
		$this->db->select ( 'm_lastname,m_primaryemail,m_masterid' );
		$this->db->from ( 'asce_licences' );
		$this->db->where ( 'm_custtype="' . $licencetype . '" and m_orderid="' . $orderid . '"' );
		$query = $this->db->get ()->result ();
		//print_r($query[0]); die;
		$result = $query[0]->m_lastname;
		//print_r($result); die()	;
		//$query->num_rows(); 
		if(is_array($query) && (!empty($result)))
		{
			return $query;
		}
		else{
			return false;
		}	
	}
	
	function fetchproductdetail($id)
	{
	   $this->db->select('*');
		$this->db->select('P.*,R.rate_code,L.license_type');
		$this->db->from('mps_product P');
		$this->db->join('mps_rate R','P.rate_id=R.id','left');
		$this->db->join('mps_license L','P.license_id=L.license_id','left');
		$this->db->where('P.product_id',$id);
		return $this->db->get()->row();
		
	}
	function selectReportdata()
	{
	   $this->db->select('*');
		//$this->db->select('P.*,R.rate_code,L.license_type');
		$this->db->from('asce_userlogs');
		return $this->db->get()->result();
		
	}
	
	function deleteProduct($productId)
	{
	$this->db->delete( 'mps_product', array (
				'product_id' => $productId 
		));	
	$this->db->delete('asce_product_book',array('product_id' => $productId));
		return $productId;
	}
	
	function booklist($id){
	$query = "SELECT  asce_product_book.book_id,m_book.m_bokdesc,
			m_book.m_boktitle,asce_product_book.product_id,asce_product_book.license_id FROM 
			`asce_product_book` inner join mps_product on mps_product.product_id=asce_product_book.product_id 
			inner join m_book on asce_product_book.book_id=m_book.m_bokid  where asce_product_book.product_id='".$id."'  
			 group by asce_product_book.book_id";
			$result = $this->db->query($query)->result();
			//echo '<pre>';
			//print_r($result);
			//die;
            return $result;
	}
	//---------------end here---------------------
}
?>
