<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class History_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	// Get user information
	function list_Book($book_id) {
		$book_id = $this->input->post ( 'book_id' );
		$this->db->select ( 'm_boktitle,m_bokid,m_volid' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
		$this->db->where_not_in ( 'm_bokid', $book_id );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		$results ['0'] = 'Please Select';
		foreach ( $recSet as $row ) {
			$results [$row->m_bokid] = $row->m_boktitle;
		}
		return $results;
	}
	function list_Depend_Book($book_id) {
		$book_id = $this->input->post ( 'book_id' );
		$this->db->select ( 'm_boktitle,m_bokid,m_volid' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
		$this->db->where_not_in ( 'm_bokid', $book_id );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->m_bokid] = $row->m_boktitle;
		}
		return $results;
	}
	function add_details($book_one, $book_two, $book_one_name, $book_two_name) {
		$book_version = $book_one . $book_two . Date ( 'jmY' );
		$this->db->set ( 'version_id ', $book_version );
		$this->db->set ( 'book_one_id ', $book_one );
		$this->db->set ( 'book_two_id', $book_two );
		$this->db->set ( 'book_one_name ', $book_one_name );
		$this->db->set ( 'book_two_name', $book_two_name );
		$this->db->set ( 'active_status', '0' );
		$this->db->set ( 'created_date', 'NOW()', FALSE );
		$this->db->insert ( 'asce_version_history' );
		$inserted_id = $this->db->insert_id ();
		$final_query = $this->db->last_query ();
		return $inserted_id;
	}
	function get_history_data($searchParam=array(),$sortBy='') {
                $this->db->select ( '*' );
		$this->db->from ( 'asce_version_history' );
		if(!empty($sortBy)){
                   $this->db->like('book_one_name', $sortBy, 'after');
                }else{
                
//		if(isset($searchParam['book_one_name'])&& (!empty($searchParam['book_one_name']))){
                    foreach($searchParam as $keys=>$datas){
                        if(!empty($datas)){
                            $this->db->like($keys, $datas, 'both');
                        }
                    }
//                }
                }
                $query = $this->db->get ();
		
                $result = $query->result ();
		$final_query = $this->db->last_query ();
		return $result;
	}
	function get_book_name($book_id) {
		$this->db->select ( 'm_boktitle' );
		$this->db->from ( 'm_book' );
		$this->db->where ( 'm_bokid', $book_id );
		$query = $this->db->get ();
		$result = $query->result_array ();
		$final_query = $this->db->last_query ();
		$result = $result [0] ['m_boktitle'];
		return $result;
	}
	function delete_history_record($id) {
		$deleted = $this->db->delete ( 'asce_version_history', array (
				'id' => $id 
		) );
		$final_query = $this->db->last_query ();
		return $deleted;
	}
	function change_status($status, $id) {
		$data = array (
				'active_status' => $status 
		);
		$this->db->where ( 'id', $id );
		$updated_id = $this->db->update ( 'asce_version_history', $data );
		$final_query = $this->db->last_query ();
		return $updated_id;
	}
	function get_book_details($book_one) {
		$this->db->select ( 'book.m_bokid,book.m_bokisbn,volume.m_volnumber,chapter.m_chpfilename,chapter.m_chppaneltype' );
		$this->db->from ( 'm_book book' );
		$this->db->join ( 'm_volume volume', 'book.m_bokid=volume.m_volbokid', 'inner' );
		//$this->db->join ( 'm_chapter chapter', 'book.m_bokid=chapter.m_chpbokvid' );
		$this->db->join ( 'm_chapter chapter', 'volume.m_volid=chapter.m_chpbokvid' , 'inner');
		$this->db->where ( 'm_bokid', $book_one );
		$query = $this->db->get ();
		$result = $query->result ();
		$final_query = $this->db->last_query ();
		//die($this->db->last_query());
		return $result;
	}
	/* -----------------------------------------------End------------------------------------------------ */
	function add_history($version_id, $chapter_no, $section_no, $data,$book_path) {
		$curr_date=date("Y-m-d H:i:s");
		$count=count($version_id);
		if($count>0){
		$inserted_value=array();
//		for($i=0;$i<$count;$i++){
//			//$inserted_value[]=array('version_id'=>$version_id[$i],'chapter_no'=>$chapter_no[$i],'section_no'=>$section_no[$i],'data'=>$data[$i],'created_date'=>$curr_date,'filenamed'=>$book_path);
//			$inserted_value =array('version_id'=>$version_id[$i],'chapter_no'=>$chapter_no[$i],'section_no'=>$section_no[$i],'data'=>$data[$i],'created_date'=>$curr_date,'filenamed'=>$book_path);
//		}
                $inserted_value =array('version_id'=>$version_id,'chapter_no'=>$chapter_no,'section_no'=>'','data'=>'','created_date'=>$curr_date,'filenamed'=>$book_path);
		/*$this->db->set ( 'version_id', $version_id );
		$this->db->set ( 'chapter_no', $chapter_no );
		$this->db->set ( 'section_no', $section_no );
		$this->db->set ( 'data', $data );
		$this->db->set ( 'created_date', 'NOW()', FALSE );*/
                //echo "<pre>11111";print_r($inserted_value);die;
		//$this->db->insert_batch('asce_history',$inserted_value);
                //echo "<pre>1234";print_r($inserted_value);die;
		$this->db->insert('asce_history',$inserted_value);
		$article_id = $this->db->insert_id ();
		return $article_id;
		}
	}

	//function for save data in cron queue
    public function saveInCronQueue($alldata=array()) {
        $newarray = array_values($alldata);
       // echo "<pre>";print_r($newarray);die;
        $this->db->insert_batch('asce_cronfiles_queue', $newarray); 
       // die($this->db->last_query());
    }
}