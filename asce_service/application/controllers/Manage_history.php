<?php
error_reporting ( 0 );
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package CodeIgniter
 * @subpackage Rest Server
 * @category Controller
 * @author Phil Sturgeon, Chris Kacerguis
 * @license MIT
 * @link https://github.com/chriskacerguis/codeigniter-restserver
 */
class Manage_history extends MY_Controller {
	private $userid;
	private $chapter_id;
	private $Success_result;
	function __construct() {
		// Construct the parent class
		parent::__construct ();
		
		$this->load->helper ( array (
				'form',
				'url',
				'xml',
				'security',
				'directory' 
		) );
		$this->load->library ( array (
				'form_validation',
				'tank_auth',
				'xml',
				'session',
				'unzip',
				'HtmlDiff' 
		) );
		$this->userid = $this->session->userdata ( 'user_id' );
		$this->load->model ( 'history_model' );
	}
	public function index() {
//            die("hello");
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
                $searchparameter = array();
                $searchparameter['book_one_name'] = trim($this->input->post ('userNameSearch'));
                $searchparameter['book_two_name'] = trim($this->input->post ('userEmailSearch'));
                $searchparameter['created_date'] = trim($this->input->post ('userStatus'));
	        $this->List_history ($searchparameter,$sortBy);
		}
	}
	function userinfo() {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			// redirect ('/auth/login');
			$this->response ( array (
					'error' => 'Sorry User not logged in' 
			) );
		} else {
			$this->load->model ( 'Book_m' );
			$data = $this->Book_m->userinfo_get ( $this->userid );
			return $data [0];
		}
	}
	function Manage_history() {
		$data ['old_book'] = array (
				'name' => 'old_book',
				'id' => 'old_book',
				'value' => $this->list_books (),
				'maxlength' => 200,
				'size' => 30,
				'for' => "Old Book",
				'class' => "form-control col-sm-3",
				'selected' => '' 
		);
		$old_book = $this->input->post ( 'old_book' );
		$new_book = $this->input->post ( 'new_book' );
		if ($old_book != 0 && $new_book != 0) {
			$this->compare_data ( $old_book, $new_book );
			redirect ( 'manage_history/List_history' );
		} else {
			$this->load->pagetemplate ( 'manage_history', $data );
		}
	}
	function List_history($searchparameter=array()) {
            
		$data ['userInfo'] = $this->userinfo ();
                
                $sortBy = $this->input->get ('sortby');
//                echo"<pre12>";print_r($sortBy);
                $searchbookonename = $searchparameter ['book_one_name'];
                $searchbooktwoname = $searchparameter ['book_two_name'];
                $searchcreatedDate = $searchparameter ['created_date'];
		$data ['history_list'] = $this->history_model->get_history_data ($searchparameter,$sortBy);
//                echo"<pre>";print_r($data ['history_list']);
                
//                $data['history_list'] = $this->history_model->fetchdata($searchparameter,$searchbookonename,$searchbooktwoname,$searchcreatedDate,$sortBy,$id);
                
                $data['book_one_name']=$searchbookonename;
		$data['book_two_name']=$searchbooktwoname;
		$data['created_date']=$searchcreatedDate;
		$this->load->pagetemplate ( 'history_list', $data );
	}
	public function list_books($book_id = null) {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->load->model ( 'history_model' );
			$var = $this->history_model->list_Book ( $book_id );
			return $var;
		}
	}
	public function list_depend_books($book_id = null) {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->load->model ( 'history_model' );
			$var = $this->history_model->list_Depend_Book ( $book_id );
			$option = '<option value="0">Please Select Book..</option>';
			foreach ( $var as $key => $value ) {
				$option .= "<option value=" . $key . ">" . $value . "</option>";
			}
			$finalValue = $option;
			echo $option;
		}
	}
	function compare_data($book_one, $book_two) {

		$book_one_details = $this->history_model->get_book_details ( $book_one );
		$book_two_details = $this->history_model->get_book_details ( $book_two );
    //echo "<pre>"; print_r($book_one_details); die;
		$book_path = $this->config->item ( 'book_path' );
		$history_path = $this->config->item ( 'history_path' );
		@mkdir ( $history_path . $book_one . $book_two . Date ( 'jmY' ), 0777, TRUE );
		$folder_name = $book_one . $book_two . Date ( 'jmY' );
		$book_one_path = $this->config->item ( 'book_path' );
		$book_two_path = $this->config->item ( 'book_path' );
		$bookOne_arr = array ();
		$bookTwo_arr = array ();
		$bookOneId =array();
		$bookOnePath_arr = array ();
		$bookTwoPath_arr = array ();
		//echo "<pre>";print_r($book_one_details);die;
		foreach ( $book_one_details as $book_details ) {
			if ($book_details->m_chppaneltype == 'PAGES') {
				$pageType = 'pages';
			} else if ($book_details->m_chppaneltype == 'COMMENTARY') {
				$pageType = 'commentary';
			}
			$book_file_path = $book_path . $book_details->m_bokisbn . '/' . 'vol-' . $book_details->m_volnumber . '/' . $pageType . '/' . $book_details->m_chpfilename . '.html';
			array_push ( $bookOne_arr, $book_details->m_chpfilename );
			array_push ( $bookOnePath_arr, $book_file_path );
			$bookOneId=$book_details->m_bokid;
		}
		foreach ( $book_two_details as $book_twodetails ) {
			if ($book_twodetails->m_chppaneltype == 'PAGES') {
				$pageType = 'pages';
			} else if ($book_twodetails->m_chppaneltype == 'COMMENTARY') {
				$pageType = 'commentary';
			}
			$book_two_file_path = $book_path . $book_twodetails->m_bokisbn . '/' . 'vol-' . $book_twodetails->m_volnumber . '/' . $pageType . '/' . $book_twodetails->m_chpfilename . '.html';
			array_push ( $bookTwo_arr, $book_twodetails->m_chpfilename );
			array_push ( $bookTwoPath_arr, $book_two_file_path );
		}
                $finalArrayForCompare = [];
                $i=0;
		foreach ( $bookTwo_arr as $book_arr ) {
			if (in_array ( $book_arr, $bookOne_arr )) {
				$found_1 = array_search ( $book_arr, $bookOne_arr );
				$found_2 = array_search ( $book_arr, $bookTwo_arr );
				$final_file_name = $folder_name . '/' . $book_arr;
                                
                                $finalArrayForCompare[$i]['bookid'] =$bookOneId;
                                $finalArrayForCompare[$i]['onepath'] = PUBLIC_PATH.(str_replace('../','/',$bookOnePath_arr[$found_1]));
								
                                $finalArrayForCompare[$i]['twopath'] = PUBLIC_PATH.(str_replace('../','/',$bookTwoPath_arr [$found_2]));
                                $finalArrayForCompare[$i]['finalname'] = PUBLIC_PATH.'/asce_content/history/'.$final_file_name;

                                
				//$this->create_history_record ( $bookOnePath_arr [$found_1], $bookTwoPath_arr [$found_2], $final_file_name );
			}
                        $i++;
		}
		
                //echo PUBLIC_PATH;
               // echo "<pre>";print_r($finalArrayForCompare);die;
                //batch insert 
                if(count($finalArrayForCompare)>0)
                $book_one_name = $this->history_model->saveInCronQueue($finalArrayForCompare);
		$book_one_name = $this->history_model->get_book_name ( $book_one );
		$book_two_name = $this->history_model->get_book_name ( $book_two );
		$inserted = $this->history_model->add_details ( $book_one, $book_two, $book_one_name, $book_two_name );
		return $inserted;
	}
	function delete_history($book_id) {
		$delete = $this->history_model->delete_history_record ( $book_id );
		redirect ( 'manage_history/List_history' );
	}
	function change_status($curr_status, $book_id) {
		if ($curr_status == 0)
			$status = 1;
		if ($curr_status == 1)
			$status = 0;
		$status = $this->history_model->change_status ( $status, $book_id );
		redirect ( 'manage_history/List_history' );
	}
	/* ----------------------------------Function for Comparing Two Files------------------------ */
	function get_compared_result($file_one, $file_two, $file_name) {
		$from = '';
		$to = '';
		$granularity = 2;
		$rendered_diff = '';
		$from_content = file_get_contents ( $file_one );
		$to_content = file_get_contents ( $file_two );
		if (! empty ( $from_content ) && ! empty ( $to_content )) {
			$from = $from_content;
			$to = $to_content;
		}
		$from_len = strlen ( $from );
		$to_len = strlen ( $to );
		$start_time = gettimeofday ( true );
		$granularityStacks = array (
				FineDiff::$paragraphGranularity,
				FineDiff::$sentenceGranularity,
				FineDiff::$wordGranularity,
				FineDiff::$characterGranularity 
		);
		
		$diff = new FineDiff ( $from, $to, $granularityStacks [$granularity] );
		$edits = $diff->getOps ();
		$exec_time = sprintf ( '%.3f sec', gettimeofday ( true ) - $start_time );
		$rendered_diff = $diff->renderDiffToHTML ();
		$rendering_time = sprintf ( '%.3f sec', gettimeofday ( true ) - $start_time );
		$book_path = $this->config->item ( 'history_path' ) . $file_name . '.html';
		$this->create_history_file ( $book_path, $rendered_diff );
	}
	function create_history_record($file_one, $file_two, $file_name) {
		$version_file = explode ( '/', $file_name );
		$version = $version_file [0];
		$file = $version_file [1];
		$from_content = file_get_contents ( $file_one );
		$to_content = file_get_contents ( $file_two );
		if (! empty ( $from_content ) && ! empty ( $to_content )) {
			$from = $from_content;
			$to = $to_content;
		}
		$diff = new HtmlDiff ( $from, $to );
		$diff->build ();
		$diff = $diff->getDifference ();
		/* -----------------------For Creating record in database--------------------- */
		if (isset ( $diff )) {
			$dom = new DOMDocument ();
			$dom->loadHTML ( $diff );
			$xpath = new DOMXPath ( $dom );
			$history_data = $xpath->query ( '//div[contains(@class,"section")]' );
			foreach ( $history_data as $history_record ) {
				$history_value = $history_record;
				$history_value = $dom->saveXML ( $history_value );
				$data = $this->get_history_data ( $version, $file, $history_value );
			}
		}
		/* ------------------------------------End------------------------------------ */
		$book_path = $this->config->item ( 'history_path' ) . $file_name . '.html';
		$this->create_history_file ( $book_path, $diff );
	}
	function create_history_file($dir, $contents) {
		$result = '<link href="../history.css" rel="stylesheet" type="text/css"><script type="text/javascript"
				src="https://cdn.mathjax.org/mathjax/latest/MathJax.js">
			</script>';
		$result .= $contents;
		file_put_contents ( $dir, $result );
	}
	/* -----------------------------------------------End---------------------------------------- */
	/* -----------------------------------------------Function for getting history data------------------------------ */
	function get_history_data($version, $file, $dom_data) {
		$version_id_arr=array();
		$chapter_no_arr=array();
		$curr_section_arr=array();
		$data_arr=array();
		$version_id = $version;
		$chapter_no = $file;
		$dom = new DOMDocument ();
		$dom->loadHTML ( $dom_data );
		$ins = $dom->getElementsByTagName ( 'ins' );
		$sec_id = $dom->getElementsByTagName ( 'div' );
		$curr_section = '';
		foreach ( $sec_id as $sec ) {
			$curr_section = $sec->getAttribute ( 'id' );
			break;
		}
		foreach ( $ins as $attr ) {
			$value = $attr->nodeValue;
			if (! empty ( trim ( $value ) )) {
				$data = '<font style="color:green">' . $value . '</font>';
				array_push($version_id_arr, $version_id);
				array_push($chapter_no_arr,$chapter_no);
				array_push($curr_section_arr, $curr_section);
				array_push($data_arr, $data);
				//$insertData = $this->history_model->add_history ( $version_id, $chapter_no, $curr_section, $data );
			}
		}
		$del = $dom->getElementsByTagName ( 'del' );
		foreach ( $del as $del_attr ) {
			$value = $del_attr->nodeValue;
			if (! empty ( trim ( $value ) )) {
				$data = '<strike style="color:red">' . $value . '</strike>';
				array_push($version_id_arr, $version_id);
				array_push($chapter_no_arr,$chapter_no);
				array_push($curr_section_arr, $curr_section);
				array_push($data_arr, $data);
				//$insertData = $this->history_model->add_history ( $version_id, $chapter_no, $curr_section, $data );
			}
		}
		$insertData = $this->history_model->add_history ( $version_id_arr, $chapter_no_arr, $curr_section_arr, $data_arr );
	}
	/* -------------------------------------------------------------End---------------------------------------------- */
}
