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
class Xmlload_model extends CI_Model
{
	private $chptable_name	= 'm_chapter';			// user accounts
	private $sectable_name	= 'm_section';	// user profiles
	private $booktable_name = 'm_book';
	private $volumetable_name = 'm_volume';
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
	
	
	
	function is_isbnexits($isbn){
		$this->db->select('m_bokid');
		$this->db->where('m_bokisbn',$isbn);
		$query = $this->db->get('m_book');
		$arrBok = $query->result();
		if($query->num_rows())
			return $arrBok[0]->m_bokid;
		else
			return false;
	}
	
	function is_volumeexists($book_id,$bokvolno){
		$this->db->select('m_volid');
		$this->db->where('m_volbokid',$book_id);
		$this->db->where('m_volseqno',$bokvolno);
		$query = $this->db->get('m_volume');
		$arrVol = $query->result();
		$book_vol_id = (isset($arrVol[0]->m_volid) ? $arrVol[0]->m_volid : 0);
		return $book_vol_id;
	}

	function add_isbn ($isbn,$user_id,$description,$booktitle,$booktitledes,$authors,$price,$book_thumb){
		$this->db->set('m_bokisbn',$isbn);
		$this->db->set('m_createdby',$user_id);
		$this->db->set('m_updatedby',$user_id);
		$this->db->set('m_bokdesc',$description);
		$this->db->set('m_boktitle',$booktitle);
		$this->db->set('m_boksubtitle',$booktitledes);
		$this->db->set('m_bokauthorname',$authors);
		//$this->db->set('m_bokprice',$price);
		$this->db->set('m_bokthump',$book_thumb);
		$this->db->set('m_createddate','NOW()',false);
		$this->db->set('m_updateddate','NOW()',false);
		$this->db->insert('m_book', $this);
		$book_id = $this->db->insert_id();
		return $book_id;
	}
	
	function add_volume ($bokvolno,$user_id,$book_id){
		
		$this->db->set('m_volbokid',$book_id);
		$this->db->set('m_createdby',$user_id);
		$this->db->set('m_updatedby',$user_id);
		$this->db->set('m_volnumber',$bokvolno);
		$this->db->set('m_volseqno',$bokvolno);
		$this->db->insert('m_volume', $this);
		$book_vol_id = $this->db->insert_id();
		return $book_vol_id;
	}
	
	function is_chapter_exist($chaplabel_id,$chapTitle,$panel_type,$volId){
		$this->db->select('m_chpid');
		$this->db->where('m_chptitle',$chapTitle);
		$this->db->where('m_chpbokvid',$volId);
		$this->db->where('m_chppaneltype',$panel_type);
		$this->db->where('m_chplabelid',$chaplabel_id);
		$query = $this->db->get('m_chapter');
		$arrCahp = $query->result();
		return (isset($arrCahp[0]->m_chpid) ? $arrCahp[0]->m_chpid : 0);
	}
	
	function add_chapter($user_id,$chap_title,$chap_label,$chpid,$chaplabel_id,$linkpage,$book_vol_id,$panel_type,$file_name,$toc_type){
		$this->db->set('m_chptitle', $chap_title);
		$this->db->set('m_chplabel', $chap_label);
		$this->db->set('m_chplabelid', $chaplabel_id);
		$this->db->set('m_chlinkpage', $file_name);
		$this->db->set('m_chpseqorder', $file_name);
		$this->db->set('m_chpfilename', $file_name);
		$this->db->set('m_chppaneltype', $panel_type);
		$this->db->set('m_chptoctype', $toc_type);
		$this->db->set('m_createdby',$user_id);
		$this->db->set('m_updatedby',$user_id);
		$this->db->set('m_createddate', 'NOW()', FALSE);
		$this->db->set('m_updateddate', 'NOW()', FALSE);
					
		$this->db->set('m_chpbokvid', $book_vol_id);
		$this->db->insert('m_chapter');
		$chapter_id= $this->db->insert_id();
		return $chapter_id;
	}
	
	function add_section($chapter_id,$title,$bokvolno,$label,$sec_level,$seclink_id,$userId,$sec_masterId){
	
		$labelc_explode = str_replace("C","",$label);
		$sec_clinkid = str_replace("sc", "" ,$seclink_id);
		$sec_plinkid = str_replace("s", "" ,$seclink_id);
		
		$this->db->set('m_sectitle',$title);
		$this->db->set('m_secvid',$bokvolno);
		$this->db->set('m_seclabel',$label);
		$this->db->set('m_seclevel',$sec_level);
		if($labelc_explode == $sec_clinkid){
			$commetry = "COMMENTARY";
			$this->db->set('m_secpaneltype', $commetry);
			}
		else if($label == $sec_plinkid) {
		$pages = "PAGES";
		$this->db->set('m_secpaneltype',$pages);
		}
		else{
		$pages = "PAGES";
		$this->db->set('m_secpaneltype',$pages);
		}
		$this->db->set('m_seclinkpage',$seclink_id);
		$this->db->set('m_createdby',$userId);
		$this->db->set('m_updatedby',$userId);
		$this->db->set('m_createddate', 'NOW()', FALSE);
		$this->db->set('m_updateddate', 'NOW()', FALSE);
		$this->db->set('m_secbokcid',$chapter_id);
		$this->db->set('m_secmasterid',$sec_masterId);
		$this->db->insert('m_section');
		return $this->db->insert_id();
		
		
		
		
	}
	
	function add_fm($chap_id,$vol_id,$fm_label,$fm_id,$user_id,$fm_para,$type,$panel_type){
					
		$this->db->set('m_cntlinkid', $fm_id);
		$this->db->set('m_cntchapid', $fm_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $fm_label);
		$this->db->set('m_cnttitle', '');
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', $fm_para);
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');

	}
	
	
	
	/*function add_table($chap_id,$vol_id,$t_label,$table_id,$user_id,$table_para,$type,$panel_type){
					
		$this->db->set('m_cntlinkid', $table_id);
		$this->db->set('m_cntchapid', $chap_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $t_label);
		$this->db->set('m_cnttitle', $table_para);
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', '');
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');

	}
	
	function add_reference($chap_id,$vol_id,$ref_title,$ref_id,$user_id,$ref_para,$type,$panel_type){
					
		$this->db->set('m_cntlinkid', $ref_id);
		$this->db->set('m_cntchapid', $chap_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $ref_title);
		$this->db->set('m_cnttitle', $ref_para);
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', '');
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');

	}
	
	function add_figure($chap_id,$vol_id,$f_label,$figure_id,$user_id,$figure_para,$type,$panel_type){
					
		$this->db->set('m_cntlinkid', $figure_id);
		$this->db->set('m_cntchapid', $chap_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $f_label);
		$this->db->set('m_cnttitle', $figure_para);
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', '');
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');

	}*/
	
	function add_chcontent($chap_id,$chap_title,$vol_id,$chap_label,$chpid,$user_id,$type,$panel_type){
					
		$this->db->set('m_cntlinkid', $chap_id);
		$this->db->set('m_cntchapid', $chap_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $chap_label);
		$this->db->set('m_cnttitle', $chap_title);
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', '');
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');

	}
	
	function add_seccontent($chap_id,$secch_title,$vol_id,$secch_label,$secch_id,$user_id,$secch_para,$type,$panel_type){
	
		$this->db->set('m_cntlinkid', $secch_id);
		$this->db->set('m_cntchapid', $chap_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $secch_label);
		$this->db->set('m_cnttitle', $secch_title);
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', $secch_para);
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');

	}
	
	
	
	function add_content($chap_id,$vol_id,$f_label,$figure_id,$user_id,$figure_para,$type,$panel_type){
		
		$this->db->set('m_cntlinkid', $figure_id);
		$this->db->set('m_cntchapid', $chap_id);
		$this->db->set('m_cntvolid', $vol_id);
		$this->db->set('m_cntlabel', $f_label);
		$this->db->set('m_cnttitle', $figure_para);
		$this->db->set('m_cntpaneltype', $panel_type);
		$this->db->set('m_cntcaption', '');
		$this->db->set('m_cnttype', $type);
		$this->db->set('m_cntcreatedby', $user_id);
		$this->db->set('m_cntupdatedby', $user_id);	
		$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
		$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
		$this->db->insert('m_content');
	}

	
	function get_bokvol_details($isbn,$bokvolno,$chapter_details,$section_details,$table_details,$figure_details){
		$userId = $_SESSION['user_id'];
		$this->db->select('m_bokid');
		$this->db->where('m_bokisbn',$isbn);
		$query = $this->db->get('m_book');
		$book = $query->result();
		if(!count($book)){
			$this->db->set('m_bokisbn',$isbn);
            $this->db->set('m_createdby',$userId);
            $this->db->set('m_updatedby',$userId);
            $this->db->set('m_createddate','NOW()',false);
            $this->db->set('m_updateddate','NOW()',false);
			$this->db->insert('m_book', $this);
			$book_id = $this->db->insert_id();
		}else{
			$book_id = $book[0]->m_bokid;
		}
		$this->db->select('m_volid');
		$this->db->where('m_volbokid',$book_id);
		$this->db->where('m_volseqno',$bokvolno);
		$query = $this->db->get('m_volume');
		$arrVol = $query->result();
		$book_vol_id = (isset($arrVol[0]->m_volid) ? $arrVol[0]->m_volid : 0);
		if(!count($arrVol)){
			$this->db->set('m_volbokid',$book_id);
            $this->db->set('m_createdby',$userId);
            $this->db->set('m_updatedby',$userId);
			$this->db->set('m_volnumber',$bokvolno);
			$this->db->set('m_volseqno',$bokvolno);
			$this->db->insert('m_volume', $this);
			$book_vol_id = $this->db->insert_id();
		}
		
		$last_item = NULL;
		 $last_sec_id = '';
		foreach($chapter_details as $chapter_detail){
			$getchp_values = array_values($chapter_detail);
			$chpid = $getchp_values[0];
			$title = $getchp_values[1];
			$label = $getchp_values[2];
			$linkpage = explode(" " , $label);
			$commentry_chapid = $linkpage[1];
			
		}
			
		$this->db->set('m_chptitle', $title);
		$this->db->set('m_chplabel', $label);
		$this->db->set('m_chplabelid', $chpid);
		if($chpid == "s".$linkpage[1]){
		$pages = "PAGES";
		$this->db->set('m_chlinkpage', $linkpage[1]);
		$this->db->set('m_chpseqorder', $linkpage[1]);
		$this->db->set('m_chppaneltype',$pages);
		}
		else if($chpid == "sc".$commentry_chapid[1]){
			$commetry = "COMMENTARY";
		$this->db->set('m_chlinkpage', $commentry_chapid[1]);
		$this->db->set('m_chpseqorder', $commentry_chapid[1]);
		$this->db->set('m_chppaneltype',$commetry);
		}
		
		
		$this->db->set('m_createdby',$userId);
		$this->db->set('m_updatedby',$userId);
		$this->db->set('m_createddate', 'NOW()', FALSE);
		$this->db->set('m_updateddate', 'NOW()', FALSE);
					
		$this->db->set('m_chpbokvid', $book_vol_id);
		$this->db->insert('m_chapter');
		$chapter_id= $this->db->insert_id();

		if(is_array($section_details)){
			foreach($section_details as $key => $value){
				$label = mysql_real_escape_string( $value['label'] );
				$sec_level = count(explode(".", $label)) - 2;
				$masterId[$sec_level] = 0;
				
				$label = mysql_real_escape_string( $value['label'] );
				$sec_level = count(explode(".", $label)) - 2;
				$seclink_id = mysql_real_escape_string( $value['id'] );
				$title = mysql_real_escape_string( $value['title'] );
				$find = ', \n';
				$replace = ', ';
				$title_sec = str_replace($find,$replace,$title);
				
				
				$this->db->set('m_sectitle',$title_sec);
				$this->db->set('m_secvid',$book_vol_id);
				$this->db->set('m_seclabel',$label);
				$this->db->set('m_seclevel',$sec_level);
				$this->db->set('m_seclinkpage',$seclink_id);
				$this->db->set('m_createdby',$userId);
				$this->db->set('m_updatedby',$userId);
				$this->db->set('m_createddate', 'NOW()', FALSE);
				$this->db->set('m_updateddate', 'NOW()', FALSE);
				$this->db->set('m_secbokcid',$chapter_id);
				
				$last_item = $sec_level;
				if($sec_level > 0){
					$this->db->set('m_secmasterid',($sec_level ==0 ? 0 : $masterId[$sec_level-1]));
				}
				
				$this->db->insert('m_section');
				$masterId[$sec_level] = $this->db->insert_id();
				
			
			}
			echo "Uploading Done!";
			echo anchor('upload_xmlfile', 'Upload Another File!');
			}
			
			foreach($chapter_details as $chapter_detail){
				
				
			$getchapter_values = array_values($chapter_detail);
			
			$type = "Chapter";
			$chapterlabel = $getchapter_values[2];
			$ex_chap = explode(" ",$getchapter_values[2]);
			$comm_explode = str_replace("C","",$ex_chap);
			$chaptertitle = $getchapter_values[1];
			$commentry_chapid = "C".$ex_chap[1];
			
			$pages = "PAGES";
			
					$this->db->set('m_cntlinkid', $ex_chap[1]);
					if($commentry_chapid){
					$this->db->set('m_cntchapid', $comm_explode[1]);
					}else{
					$this->db->set('m_cntchapid', $ex_chap[1]);
					}
					$this->db->set('m_cntvolid', $book_vol_id);
					$this->db->set('m_cntlabel', $chapterlabel);
					$this->db->set('m_cnttitle', $chaptertitle);
					if($ex_chap[1] == "C".$comm_explode[1]){
						$commetry = "COMMENTARY";
					$this->db->set('m_cntpaneltype', $commetry);
					}
					else{
						$this->db->set('m_cntpaneltype', $pages);
					}
					$this->db->set('m_cnttype', $type);	
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}
		
		// Content Section Insertion
		foreach($section_details as $section_detail){
			$getsec_values = array_values($section_detail);
			$type = "Section";
			$secid = $getsec_values[0];
			$sectitle = $getsec_values[1];
			$secpara = $getsec_values[3];
			$seclabel = $getsec_values[2];
			$commentry_chapid = "C".$ex_chap[1];
			$pages = "PAGES";
			
			
					$this->db->set('m_cntlinkid', $secid);
					if($commentry_chapid){
					$this->db->set('m_cntchapid', $comm_explode[1]);
					}else{
					$this->db->set('m_cntchapid', $ex_chap[1]);
					}
					$this->db->set('m_cntvolid', $book_vol_id);
					$this->db->set('m_cntlabel', $seclabel);
					$this->db->set('m_cnttitle', $sectitle);
					$this->db->set('m_cntcaption', $secpara);
					if($ex_chap[1] == "C".$comm_explode[1]){
						$commetry = "COMMENTARY";
					$this->db->set('m_cntpaneltype', $commetry);
					}
					else{
						$this->db->set('m_cntpaneltype', $pages);
					}
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
			$commentry_chapid = "C".$ex_chap[1];
			$pages = "PAGES";
					
					$this->db->set('m_cntlinkid', $tableid);
					$this->db->set('m_cnttitle', $tablepara);
					if($commentry_chapid){
					$this->db->set('m_cntchapid', $comm_explode[1]);
					}else{
					$this->db->set('m_cntchapid', $ex_chap[1]);
					}
					$this->db->set('m_cntvolid', $book_vol_id);
					$this->db->set('m_cntlabel', $tablelabel);
					//$this->db->set('m_cntcaption', $tablepara);	
					if($ex_chap[1] == "C".$comm_explode[1]){
						$commetry = "COMMENTARY";
					$this->db->set('m_cntpaneltype', $commetry);
					}
					else{
						$this->db->set('m_cntpaneltype', $pages);
					}
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
			$commentry_chapid = "C".$ex_chap[1];
			$pages = "PAGES";
			
					$this->db->set('m_cntlinkid', $figid);
					$this->db->set('m_cnttitle', $figpara);
					if($commentry_chapid){
					$this->db->set('m_cntchapid', $comm_explode[1]);
					}else{
					$this->db->set('m_cntchapid', $ex_chap[1]);
					}
					$this->db->set('m_cntvolid', $book_vol_id);
					$this->db->set('m_cntlabel', $figlabel);
					//$this->db->set('m_cntcaption', $figpara);
					if($ex_chap[1] == "C".$comm_explode[1]){
						$commetry = "COMMENTARY";
					$this->db->set('m_cntpaneltype', $commetry);
					}
					else{
						$this->db->set('m_cntpaneltype', $pages);
					}
					$this->db->set('m_cnttype', $type);	
					$this->db->set('m_cntcreateddate', 'NOW()', FALSE);
					$this->db->set('m_cntupdateddate', 'NOW()', FALSE);
					$this->db->insert('m_content');
		}
		
			
			
	}
	
}