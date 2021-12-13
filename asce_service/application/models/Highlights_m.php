<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Highlights_m extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	private $hightlight_tablename = 't_txthighlight'; // Highlight

    function __construct()
    {
        parent::__construct();
    }
    
	//Add Highlight
    function addhighlight($cus_book_id,$highlight_chapterId,$highlight_paraData,$highlight_paraId,$highlight_sectionId,$user_id)
    {
		//t_txhusrid, t_txhchapid,t_txhsecid,t_txhcus_book_id,
	    $this->db->select('t_txhid ');
        $this->db->from('asce_para_opration');
		$this->db->where(
		array('t_txhusrid' => $user_id,
		't_txhcus_book_id' => $cus_book_id,
		't_txhchapid'=>$highlight_chapterId,
		't_txhsecid'=>$highlight_sectionId,
		't_txhparaid'=>$highlight_paraId));
		$query = $this->db->get();
		/* echo $this->db->last_query();
		print  $query->num_rows(); 
		echo $this->db->last_query(); die(); */
		if($query->num_rows() >0){
		$this->db->set('t_txhchapid',$highlight_chapterId);
		$this->db->set('paraData',$highlight_paraData);
		$this->db->set('t_txhparaid',$highlight_paraId);
		$this->db->set('t_txhsecid',$highlight_sectionId);
		$this->db->set('t_txhcus_book_id',$cus_book_id);
		$this->db->set('t_txhusrid',$user_id);
		$this->db->where(
		array('t_txhusrid' => $user_id,
		't_txhcus_book_id' => $cus_book_id,
		't_txhchapid'=>$highlight_chapterId,
		't_txhsecid'=>$highlight_sectionId,
		't_txhparaid'=>$highlight_paraId));
		$this->db->update('asce_para_opration', $this);
		}else{
			$this->db->set('t_txhchapid',$highlight_chapterId);
			$this->db->set('paraData',$highlight_paraData);
			$this->db->set('t_txhparaid',$highlight_paraId);
			$this->db->set('t_txhsecid',$highlight_sectionId);
			$this->db->set('t_txhcus_book_id',$cus_book_id);
			$this->db->set('t_txhusrid',$user_id);
			$this->db->insert('asce_para_opration', $this);
		}
        
		//echo $this->db->last_query(); die();
        return $this->db->insert_id();
    }
	
	//Retreive Highlight
	function retrivehighlights($chapId,$cus_book_id,$user_id)
    {
		if($chapId == ''){
		$this->db->select('t_txhid,t_txhparaid,t_txhusrid,t_txhsecid,t_txhchapid,t_txhcus_book_id,paraData');
        $this->db->from('asce_para_opration');
		$this->db->order_by("t_txhid", "asc");
		$this->db->where(array('t_txhusrid' => $user_id));
		$this->db->where(array('t_txhcus_book_id' => $cus_book_id)); 
		}
		else{
		$this->db->select('t_txhid,t_txhparaid,t_txhusrid,t_txhsecid,t_txhchapid,t_txhcus_book_id,paraData');
        $this->db->from('asce_para_opration');
		$this->db->order_by("t_txhid", "asc");
		$this->db->where(array('t_txhusrid' => $user_id));
		$this->db->where(array('t_txhcus_book_id' => $cus_book_id));
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}function gethlightsData($chapId,$book_id,$user_id,$secId,$pId)
    {
		$this->db->select('t_txhid,t_txhparaid,t_txhusrid,t_txhsecid,t_txhchapid,t_txhcus_book_id,paraData');
        $this->db->from('asce_para_opration');
		$this->db->order_by("t_txhid", "asc");
		$this->db->where(array('t_txhusrid' => $user_id,'t_txhcus_book_id' => $book_id,'t_txhchapid'=>$chapId,'t_txhparaid'=>$pId,'t_txhsecid'=>$secId));
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $query->result_array();
	}
    
	//Delete Highlight    
	function deletehighlights($user_id,$cus_book_id,$arrayData)
	{	
		$arrayData=(object)$arrayData;
		$this->db->set('t_txhchapid',$arrayData->chapterId);
		$this->db->set('paraData',$arrayData->paraData);
		$this->db->set('t_txhparaid',$arrayData->paraId);
		$this->db->set('t_txhsecid',$arrayData->sectionId);
		$this->db->set('t_txhcus_book_id',$cus_book_id);
		$this->db->set('t_txhusrid',$user_id);
		$this->db->where(
		array('t_txhusrid' => $user_id,
		't_txhcus_book_id' => $cus_book_id,
		't_txhchapid'=>$arrayData->chapterId,
		't_txhsecid'=>$arrayData->sectionId,
		't_txhparaid'=>$arrayData->paraId));
		$this->db->update('asce_para_opration', $this);
		//print $this->db->last_query(); 
		return true;
	}
	//For Updating Highlight Color Code
	function UpdateHightLight($color_code){
		$this->db->select("t_txhid,t_txhusrid");
		$this->db->from('t_txthighlight');
		$this->db->order_by("t_txhid","Desc");
		$this->db->limit(1);
		$query = $this->db->get();
        $data=$query->result(); 
		$this->db->set ( 't_txhcolorcode', $color_code );
		$this->db->where ( 't_txhid', $data[0]->t_txhid );
		$this->db->update ( 't_txthighlight', $this );
		return true;
		
	}
}