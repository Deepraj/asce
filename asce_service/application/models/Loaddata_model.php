<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package	Tank_auth
 * @author	Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Loaddata_model extends CI_Model
{
	private $chptable_name	= 'm_chapter';			// user accounts
	private $sectable_name	= 'm_section';	// user profiles
	private $booktable_name = 'm_book';
	private $volumetable_name = 'm_volume';
	private $searchtable_name = 'm_advsearch';
	private $session_table_name = 'ci_sessions';

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->chptable_name	= $ci->config->item('db_table_prefix', 'asce').$this->chptable_name;
		$this->sectable_name	= $ci->config->item('db_table_prefix', 'asce').$this->sectable_name;
		$this->booktable_name	= $ci->config->item('db_table_prefix', 'asce').$this->booktable_name;
		$this->volumetable_name	= $ci->config->item('db_table_prefix', 'asce').$this->volumetable_name;
	}
	
	function get_xml_details($table_details,$figure_details,$section_details,$chapter_details){
		
		foreach($chapter_details as $chapter_detail){
			$getchapter_values = array_values($chapter_detail);
			$type = "Chapter";
			$chapterlabel = $getchapter_values[0];
			$ex_chap = explode(" ",$chapterlabel);
			$chaptertitle = $getchapter_values[1];
			
					$this->db->set('m_cntid', $ex_chap[1]);
					$this->db->set('m_cntlabel', $chapterlabel);
					$this->db->set('m_cnttitle', $chaptertitle);
					$this->db->set('m_cnttype', $type);	
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}
		
		
		foreach($section_details as $section_detail){
			$getsec_values = array_values($section_detail);
			
			$type = "Section";
			$secid = $getsec_values[0];
			$sectitle = $getsec_values[1];
			$secpara = $getsec_values[2];
			$seclabel = $getsec_values[3];
			
					$this->db->set('m_cntid', $secid);
					$this->db->set('m_cntlabel', $seclabel);
					$this->db->set('m_cnttitle', $sectitle);
					$this->db->set('m_cntcaption', $secpara);
					$this->db->set('m_cnttype', $type);	
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}
		
		foreach($table_details as $table_detail){
			$gettable_values = array_values($table_detail);
			$type = "Table";
			$tableid = $gettable_values[0];
			$tablepara = $gettable_values[1];
			$tablelabel = $gettable_values[2];
					
					$this->db->set('m_cntid', $tableid);
					$this->db->set('m_cntlabel', $tablelabel);
					$this->db->set('m_cntcaption', $tablepara);	
					$this->db->set('m_cnttype', $type);				
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}
		
		foreach($figure_details as $figure_detail){
			$getfig_values = array_values($figure_detail);
			$type = "Figure";
			$figid = $getfig_values[0];
			$figpara = $getfig_values[1];
			$figlabel = $getfig_values[2];
			
					$this->db->set('m_cntid', $figid);
					$this->db->set('m_cntlabel', $figlabel);
					$this->db->set('m_cntcaption', $figpara);
					$this->db->set('m_cnttype', $type);	
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}
		
		/*foreach($fm_details as $fm_detail){
			print_r($fm_detail);
			$getfm_values = array_values($fm_details);
			$type = "Front_Matter";

			$fmpara = $getfm_values[0];
			
					$this->db->set('m_cntcaption', $fmpara);
					$this->db->set('m_cnttype', $type);	
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}*/
		
		
		           $this->db->select('id,username');
					$this->db->from('users');
					$this->db->where(array('id' => $_SESSION['user_id'] ));
					$query_get = $this->db->get();
					$query_result = $query_get->result();
					$username= $query_result[0]->username;
					
					
					
		
	}
	
}