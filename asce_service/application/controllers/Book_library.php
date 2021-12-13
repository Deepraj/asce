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
class Book_library extends MY_Controller {
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
				'unzip' 
		) );


		$this->lang->load ( 'tank_auth' );
		$this->load->model ( 'Xmlload_model' );
		$this->load->model ( 'Book_m' );
		$this->parse_data = array ();
		$this->masterId = array ();
		$this->load->database ();
		$this->userid = $this->session->userdata ( 'user_id' );
		$this->cus_book_id = $this->session->userdata ( 'cus_book_id' );
		$this->vol_id = $this->session->userdata ( 'vol_id' );
		$this->book_id = $this->session->userdata ( 'book_id' );
		
		if ((! $this->tank_auth->is_user_admin () && ! $this->tank_auth->is_user_student ())) {
			$data ['content'] = 'error_404'; // View name
			$this->load->view ( 'Book_library', $data ); // loading in my template
			                                             // echo "No rights to view Book Library";
			                                             // $this->load->view('book_library_error');
			                                             // redirect('Custombook_library/show_custombook', 'refresh');
			exit ();
		}

	
	}
	public function index() {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->list_book ();
		}
	}
	
	// Get the user details
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
	// //////////////manual_validation///////////////////
	function checkAlpha($str) {
		if (! preg_match ( '/^[a-zA-Z0-9-\s]*$/', $str )) {
			$this->form_validation->set_message ( 'checkAlpha', 'The book title field may only contain alphanumeric characters.' );
			return false;
		} else {
			return true;
		}
	}
	function checkAuthor($str) {
		if (! preg_match ( '/^[a-z .,\-]+$/i', $str )) {
			$this->form_validation->set_message ( 'checkAuthor', 'The author name may only contain alphabetical characters.' );
			return false;
		} else {
			return true;
		}
	}
	function numcheck($in) {
		if (intval ( $in ) < 1) {
			$this->form_validation->set_message ( 'numcheck', 'volume no must be greater than 0' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	function numisbncheck($in) {
		if (intval ( $in ) == 0) {
			$this->form_validation->set_message ( 'numisbncheck', 'This value not acceptable ' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	// //////////////////////////////////////////////////
	// fnction to add a book
	public function addbook($id = 0) {
	  
		if (! $this->tank_auth->is_logged_in ( TRUE ) && $this->tank_auth->is_user_admin ( TRUE )) // Users not logged in
          {
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$data ['booktitle'] = array (
					'name' => 'booktitle',
					'id' => 'booktitle',
					'value' => set_value ( 'booktitle' ),
					'maxlength' => 80,
					'size' => 30,
					'for' => "bookTitle",
					'class' => "form-control" 
			);
			
			$data ['booktitledes'] = array (
					'name' => 'booktitledes',
					'id' => 'booktitledes',
					'value' => set_value ( 'booktitledes' ),
					'for' => "BookSubTitle",
					'class' => "form-control" 
			);
			
			$data ['isbn'] = array (
					'name' => 'isbn',
					'id' => 'isbn',
					'value' => set_value ( 'isbn' ),
					'for' => "ISBN",
					'class' => "form-control",
					'maxlength' => 13,
					'size' => "13" 
			);
			
			$data ['volumeno'] = array (
					'name' => 'volumeno',
					'id' => 'volumeno',
					'value' => set_value ( 'volumeno' ),
					'for' => "Volume No",
					'class' => "form-control",
					'maxlength' => 2,
					'size' => "13" 
			);
			
			$data ['authors'] = array (
					'name' => 'authors',
					'id' => 'authors',
					'value' => set_value ( 'authors' ),
					'for' => "Authors",
					'class' => "form-control" 
			);
			$data ['description'] = array (
					'name' => 'description',
					'id' => 'description',
					'value' => set_value ( 'description' ),
					'for' => "Description",
					'class' => "form-control" 
			);
			
			/*
			 * $data['price'] = array(
			 * 'name' => 'price',
			 * 'id' => 'price',
			 * 'value' => set_value('price'),
			 * 'for' => "Price",
			 * 'class' => "form-control",
			 * 'maxlength' => 5,
			 * 'size' => "13",
			 * );
			 */
			
			$data ['userfile'] = array (
					'name' => 'userfile',
					'id' => 'userfile',
					// 'value' => set_value('userfile'),
					'for' => "userfile",
					'class' => "form-control",
					'onchange' => 'checkFileType(value)',
					'type' => 'file' 
			);
			
			$data ['book_img'] = array ( 
					'name' => 'book_img',
					'id' => 'book_img',
					'value' => set_value ( 'book_img' ),
					'for' => "book_img",
					'class' => "form-control",
					'type' => 'hidden' 
			);
			$data ['old_book_img'] = array (
					'name' => 'old_book_img',
					'id' => 'old_book_img',
					'value' => set_value ( 'old_book_img' ),
					'for' => "old_book_img",
					'class' => "form-control",
					'type' => 'hidden' 
			);
			$data ['bookid'] = array (
					'name' => 'bookid',
					'id' => 'bookid',
					'value' => set_value ( 'bookid' ),
					'for' => "bookid",
					'class' => "form-control",
					'type' => 'hidden' 
			);
			$data ['thump_img'] = array (
					'value' => '' 
			);
			
			$this->form_validation->set_rules ( 'booktitle', 'book title', 'trim|required|max_length[80]' ); // Form validation for book title
			$this->form_validation->set_rules ( 'booktitledes', 'book sub title', 'trim|required|max_length[80]' ); // Form validation for a book description
			$this->form_validation->set_rules ( 'isbn', 'isbn', 'trim|required|min_length[13]|integer|callback_numisbncheck|max_length[80]' ); // Form validation for ISBN
			$this->form_validation->set_rules ( 'authors', 'author name', 'trim|required' );
			$data ['bookid'] ['value'] = $id;
			if ($id == 0) {
				$this->form_validation->set_rules ( 'volumeno', 'volume no', 'required|numeric|callback_numcheck' ); // Form validation for volume number
				if (empty ( $_FILES ['userfile'] ['name'] [0] ))
					$this->form_validation->set_rules ( 'userfile', 'need content file', 'trim|required' ); // Form validation for user file
			}
			if ($this->form_validation->run ()) {
				if ($id == 0){
					$this->do_upload ();
					}else{
					$this->update_book ();
				   $this->upload_book_thump ();
				}
			} else if ($id == 0) {
				$this->load->pagetemplate ( 'addbook_form', $data );
			} else if ($id > 0) {
				$this->load->model ( 'Book_m' );
				$book_data = $this->Book_m->get_book ( $id );
				// echo "<pre>";print_r($book_data); die;
				$data ['isbn'] ['readonly'] = 'true';
				// $data['isbn']['disabled'] = 'true';
				$data ['volumeno'] ['readonly'] = 'true';
				// $data['volumeno']['disabled'] = 'true';
				$data ['bookid'] ['value'] = $book_data [0]->m_bokid;
				$data ['booktitle'] ['name'] = 'booktitle';
				$data ['booktitle'] ['value'] = $book_data [0]->m_boktitle;
				$data ['booktitledes'] ['value'] = $book_data [0]->m_boksubtitle;
				$data ['isbn'] ['value'] = $book_data [0]->m_bokisbn;
				$data ['volumeno'] ['value'] = $book_data [0]->m_volnumber;
				$data ['authors'] ['value'] = $book_data [0]->m_bokauthorname;
				$data ['description'] ['value'] = $book_data [0]->m_bokdesc;
				// $data['price']['value']= $book_data[0]->m_bokprice;
				$data ['old_book_img'] ['value'] = $book_data [0]->m_bokthump;
				$this->session->set_userdata ( 'edit_isbn', $book_data [0]->m_bokisbn );
				$this->session->set_userdata ( 'edit_vol', $book_data [0]->m_volnumber );
				$data ['thump_img'] ['value'] = base_url ( $this->config->item ( 'book_path' ) ) . "/" . $book_data [0]->m_bokisbn . "/vol-" . $book_data [0]->m_volnumber . "/" . "cover_img" . "/" . $book_data [0]->m_bokthump;
				$this->load->pagetemplate ( 'addbook_form', $data );
			}
		}
	}
	
	/* -------------------------------------Method For Updating Content------------------------------------- */
	public function updateContent($id = 0) {
		if (! $this->tank_auth->is_logged_in ( TRUE ) && $this->tank_auth->is_user_admin ( TRUE )) // Users not logged in
         {
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
	    } else {
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$data ['booktitle'] = array (
					'name' => 'booktitle',
					'id' => 'booktitle',
					'value' => set_value ( 'booktitle' ),
					'maxlength' => 80,
					'size' => 30,
					'for' => "bookTitle",
					'class' => "form-control" 
			);
			
			$data ['isbn'] = array (
					'name' => 'isbn',
					'id' => 'isbn',
					'value' => set_value ( 'isbn' ),
					'for' => "ISBN",
					'class' => "form-control",
					'maxlength' => 13,
					'size' => "13" 
			);
			
			$data ['volumeno'] = array (
					'name' => 'volumeno',
					'id' => 'volumeno',
					'value' => set_value ( 'volumeno' ),
					'for' => "Volume No",
					'class' => "form-control",
					'maxlength' => 2,
					'size' => "13" 
			);
			
			$data ['userfile'] = array (
					'name' => 'userfile',
					'id' => 'userfile',
					'value' => set_value ( 'userfile' ),
					'for' => "userfile",
					'class' => "form-control",
					'type' => 'file' 
			);
			$this->form_validation->set_rules ( 'booktitle', 'book title', 'trim|required' ); // Form validation for book title
			$this->form_validation->set_rules ( 'isbn', 'isbn', 'trim|required|min_length[13]|integer|callback_numisbncheck|max_length[80]' ); // Form validation for ISBN
			$this->form_validation->set_rules ( 'volumeno', 'volume no', 'trim|required|callback_numcheck' );
			// $this->form_validation->set_rules('price', 'Price', 'required|numeric');
			$data ['bookid'] ['value'] = $id;
			if ($id == 0) {
				$this->form_validation->set_rules ( 'volumeno', 'volume no', 'required|callback_numcheck' ); // Form validation for volume number
				if (empty ( $_FILES ['userfile'] ['name'] [0] ))
					$this->form_validation->set_rules ( 'userfile', 'need content file', 'trim|required' ); // Form validation for user file
			}
			if ($this->form_validation->run ()) {
				if ($id > 0)
					$this->updateBookContent ();
				else
					$this->update_book ();
			} else if ($id == 0) {
				$this->load->pagetemplate ( 'addbook_form', $data );
			} else if ($id > 0) {
				$this->load->model ( 'Book_m' );
				$book_data = $this->Book_m->get_book ( $id );
				$data ['isbn'] ['readonly'] = 'true';
				// $data['isbn']['disabled'] = 'true';
				$data ['volumeno'] ['readonly'] = 'true';
				$data ['booktitle'] ['readonly'] = 'true';
				// $data['volumeno']['disabled'] = 'true';
				$data ['bookid'] ['value'] = $book_data [0]->m_bokid;
				$data ['booktitle'] ['name'] = 'booktitle';
				$data ['booktitle'] ['value'] = $book_data [0]->m_boktitle;
				$data ['isbn'] ['value'] = $book_data [0]->m_bokisbn;
				$data ['volumeno'] ['value'] = $book_data [0]->m_volnumber;
				// $data['price']['value']= $book_data[0]->m_bokprice;
				$data ['old_book_img'] ['value'] = $book_data [0]->m_bokthump;
				$this->session->set_userdata ( 'edit_isbn', $book_data [0]->m_bokisbn );
				$this->session->set_userdata ( 'edit_vol', $book_data [0]->m_volnumber );
				$data ['thump_img'] ['value'] = base_url ( $this->config->item ( 'book_path' ) ) . "/" . $book_data [0]->m_bokisbn . "/vol-" . $book_data [0]->m_volnumber . "/" . "cover_img" . "/" . $book_data [0]->m_bokthump;
				$this->load->pagetemplate ( 'updateContent', $data );
			}
		}
	}
	/* ------------------------------------------------End-------------------------------------------------- */
	
	// Function for upload a thumbnail image
	public function upload_book_thump() {
		$name = time () . str_replace ( " ", "_", $_FILES ['book_thump_img'] ['name'] );
		$size = $_FILES ['book_thump_img'] ['size'];
		$valid_formats = array (
				"jpg",
				"png",
				"gif",
				"bmp",
				"jpeg",
				"JPEG" 
		);
		if ($_FILES ['book_thump_img'] ['error']) {
			echo "<span style='color:white;'>SIZE-EXCEEDS</span>";
			exit ();
		}
		if (strlen ( $name )) {
			$extension = pathinfo ( $name, PATHINFO_EXTENSION );
			if (in_array ( strtolower ( $extension ), $valid_formats )) {
				if ($size < (1024 * 1024 * 2)) // Image size max 2 MB
{
					$config ['upload_path'] = '.' . $this->config->item ( 'temp_upload_path' );
					$config ['allowed_types'] = 'gif|jpg|png|bmp|jpeg|JPEG';
					
					$this->load->library ( 'upload', $config );
					$this->upload->do_upload ( 'book_thump_img' );
					$data = $this->upload->data ();
					$name_array [] = $data ['file_name'];
					
					$config ['image_library'] = 'gd2';
					$config ['source_image'] = $config ['upload_path'] . $data ['file_name'];
					$config ['create_thumb'] = false;
					$config ['maintain_ratio'] = TRUE;
					$config ['width'] = 123;
					$config ['height'] = 181;
					
					$this->load->library ( 'image_lib', $config );
					
					$sizeImg = $this->image_lib->resize ();
					echo "<img id='book_thump_uploaded_img'  src='" . $this->config->item ( 'base_url' ) . $this->config->item ( 'temp_upload_path' ) . $data ['file_name'] . "' file_path ='" . $this->config->item ( 'temp_upload_path' ) . $data ['file_name'] . "' class='thump_collaimg'>";
				} else {
					echo "<span style='color:white;'>SIZE-EXCEEDS</span>";
				}
			} else {
				echo "<span style='color:white;'>NOT-SUPPORTABLE-FORMAT</span>";
			}
		} else {
			echo "<span style='color:white;'>EMPTY</span>";
		}
	}
	
	// Function to edit a book
	public function edit_book() {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->load->model ( 'Book_m' );
			$isbn = $this->input->get_post ( "title", TRUE );
			$data ['b'] = $this->Book_m->edit_book ( $isbn );
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$this->load->pagetemplate ( 'update_bookform', $data );
		}
	}
	
	// Function to update a book
	public function update_book() {
		$book_title = $this->input->post ( 'booktitle' );
		$book_id = $this->input->post ( 'bookid' );
		$booktitledes = $this->input->post ( 'booktitledes' );
		$authors = $this->input->post ( 'authors' );
		$isbn = $this->input->post ( 'isbn' );
		$description = $this->input->post ( 'description' );
		$book_img = $_FILES ['book_thump_img'] ['name'];
		$old_book_img = $this->input->post ( 'old_book_img' );
		if (trim ( $book_img ) == "") {
			$img = $old_book_img;
		} else {
			$img = $book_img;
			$this->file_temp = $_FILES ['book_thump_img'] ['tmp_name'];
			$path = $this->config->item ( 'book_path' ) . $this->session->userdata ( 'edit_isbn' ) . "/vol-" . $this->session->userdata ( 'edit_vol' ) . "/cover_img/" . $img;
			if (! @copy ( $this->file_temp, $path )) {
				if (! @move_uploaded_file ( $this->file_temp, $path )) {
					echo "Erorr in Uploading file";
				}
			}
		}
		$this->Book_m->update_book ( $book_id, $book_title, $booktitledes, $authors, $description, $isbn, $img );
		redirect ( 'book_library/', 'refresh' );
	}
	// Function to list a book details
	public function list_book() {
		if (! $this->tank_auth->is_logged_in_admin ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->load->model ( 'Book_m' );
			$search = $this->input->post ( 'booktitlesearch' );
			$sortBy = $this->input->get ( 'sortby' );
			$search_from_date = $this->input->post ( 'search_from_date' );
			$search_to_date = $this->input->post ( 'search_to_date' );
			$data ['books'] = $this->Book_m->list_book ( $this->userid, $search, $search_from_date, $search_to_date, $sortBy );
			$data ['search'] = $search;
			$data ['search_from_date'] = $search_from_date;
			$data ['search_to_date'] = $search_to_date;
			$data ['thumb_img_path'] = base_url ( $this->config->item ( 'book_path' ) ) . "/";
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$this->load->pagetemplate ('book_list', $data );
		}
	}
	
	// Function for Book Search
	function book_search() {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{
			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			$this->load->model ( 'Book_m' );
			$search = $this->input->post ( 'booktitlesearch' );
			$search_from_date = $this->input->post ( 'search_from_date' );
			$search_to_date = $this->input->post ( 'search_to_date' );
			$data ['books'] = $this->Book_m->book_search ( $search, $search_from_date, $search_to_date );
			$data ['thumb_img_path'] = base_url ( $this->config->item ( 'book_path' ) ) . "/";
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$this->load->pagetemplate ( 'book_list', $data );
		}
	}
	
	// Function for delete a book
	public function delete_book($bokid) {
		if (! $this->tank_auth->is_logged_in ( TRUE )) // Users not logged in
{			$this->session->set_userdata ( 'last_url', $this->uri->segment ( 1 ) );
			redirect ( 'auth/', 'refresh' );
		} else {
			// Delete Book Details
			$this->load->model ( 'Book_m' );
			$isbn=$this->Book_m->getIsbn($bokid);
			//print_r($isbn[0]->m_bokisbn); die;
			$src=$this->config->item('book_path').$isbn[0]->m_bokisbn;
			//print_r($src); die;
			$varid = $this->Book_m->delete_book ($bokid );
			if($varid){
			    $this->session->set_flashdata('msg','You have deleted book successfully.'); 
			}
			$isbnid = $this->Book_m->delete_isbn($src);
			$volid = $this->Book_m->delete_volume ($this->userid, $varid);
			
			$chapid = $this->Book_m->delete_chapter ( $this->userid, $volid->m_volid );
			//print_r($chapid); die;
			foreach($chapid as $row)
			{
			
			$secid = $this->Book_m->delete_section ( $this->userid, $row->m_chpid );
			$cnt_id = $this->Book_m->delete_content ( $this->userid, $row->m_chpid );
			}
			
			
			
			
			$bookmark_id = $this->Book_m->delete_bookmark ( $this->userid, $this->cus_book_id );
			$highlight_id = $this->Book_m->delete_txthighlight ( $this->userid, $this->cus_book_id );
			$notes_id = $this->Book_m->delete_txtnotes ( $this->userid, $this->cus_book_id );
			// Delete Custom Book Details
			$this->load->model ( 'Custombook_model' );
			$custbook_id = $this->Custombook_model->delete_custombook ( $this->userid, $notes_id );
			$this->Custombook_model->delete_custchapter ( $this->userid, $custbook_id );
			redirect ( 'Book_library/list_book', 'refresh' );
		}
	}
	
	// Upload a book (xml,cover image,content image)
	function do_upload() {
	    ini_set('post_max_size','99500M');
	    ini_set('upload_max_size','100000M');
	    ini_set('memory_limit','128M');
	    ini_set('max_execution_time','5000');
		$data ['userInfo'] = $this->userinfo ();
		$config ['upload_path'] = ("./" . $this->config->item ( 'upload_xml_path' ));
		$config ['allowed_types'] = '*';
		$config ['max_size'] = '9999999999';
		// print_r($config); die;
		$this->load->library ( 'upload', $config );
		if (! $this->upload->do_upload ()) {
			$error = array (
					'error' => $this->upload->display_errors () 
			);
			$this->load->view ( 'upload_xml', $error );
		} else {
			$basepath = $this->config->item ( 'base_url' );
			$playerpath = explode ( "/", $basepath );
			$folderpath = '../' . $playerpath [3] . '';
			// print_r ($playerpath);
			// exit;
			// $playerpath = "../ASCE_Services";
			// exit;
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			// $this->load->pagetemplate('upload_xmlsuccess', $data);
			$isbn ["isbn"] = $this->input->get_post ( "isbn", TRUE );
			$bokvolno ["volumeno"] = $this->input->get_post ( "volumeno", TRUE );
			$file_path = $data ['upload_data'] ['full_path'];
			// echo $file_path;die;
			
			$file = explode ( "/", $file_path );
			$file_xml = explode ( ".", $file [count ( $file ) - 1] );
			// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$zip = new ZipArchive ();
			$file = $data ['upload_data'] ['full_path'];
			$ext = pathinfo ( $file, PATHINFO_EXTENSION );
			$allowed = array (
					'zip' 
			);
			if (! in_array ( $ext, $allowed )) {
				echo "<font color='red'>Upload Zip folder  !!..</font>  </br>";
				echo 'Folder Must Contain XML File';
				echo '<br><a href="">Upload Again</a>';
				exit ();
			}
			
			$explode_files = explode ( "/", $file );
			$extract_file = explode ( ".", $explode_files [count ( $explode_files ) - 1] );
			
			$foldername = $extract_file [0];
			chmod ( $file, 0777 );
			if ($zip->open ( $file ) === TRUE) {
				$zip->extractTo ( "./" . $this->config->item ( 'upload_xml_path' ) . $foldername );
				$zip->close ();
				$result = array ();
				$isbn ["isbn"] = $this->input->get_post ( "isbn", TRUE );
				$separator = DIRECTORY_SEPARATOR;
				$paths = 'relative';
				$date = date ( 'Y-m-d H:i:s' );
				
				$dir = $this->config->item ( 'upload_xml_path' ) . $foldername;
				$files = glob ( "" . $dir . "/*xml" );
				$files1 = glob ( "" . $dir . "/*jpg" );
				$files2 = glob ( "" . $dir . "/*zip" );
				
				if (! $files) {
					$this->Success_result [] = " <font color='red'>XML files not there !!..</font>  </br>";
					echo 'Folder Must Contain XML File';
					echo '<br><a href="">Upload Again</a>';
					return False;
				}
				if (! $files1) {
					$this->Success_result [] = " <font color='red'>Cover Image not there !!..</font>  </br>";
				}
				if (! $files2) {
					$this->Success_result [] = " <font color='red'>Image files not there !!..</font>  </br>";
				}
				
				$cdir = scandir ( $dir );
				
				foreach ( $cdir as $key => $value ) {
					
					if (! in_array ( $value, array (
							".",
							".." 
					) )) {
						if (is_dir ( $dir . $separator . $value )) {
							$result [$value] = $this->dir_to_array ( $dir . $separator . $value, $separator, $paths );
						} else {
							if ($paths == 'relative') {
								$result [] = $dir . '/' . $value;
							} elseif ($paths == 'absolute') {
								$result [] = base_url () . $dir . '/' . $value;
							}
						}
					}
				}
			} else {
				echo 'failed';
			}
			// print_r($result); die;
			foreach ( $result as $key => $value ) {
				
				$data ['userInfo'] = $this->session->userdata ( 'userInfo' );
				/*
				 * if(!count($data['userInfo'])) Comment By Anuj
				 * redirect('admin/', 'refresh');
				 */
				$this->isbn = $this->input->get_post ( "isbn", TRUE );
				$this->vol_no = $this->input->get_post ( "volumeno", TRUE );
				$description = $this->input->get_post ( "description", TRUE );
				$booktitle = $this->input->get_post ( "booktitle", TRUE );
				$booktitledes = $this->input->get_post ( "booktitledes", TRUE );
				$authors = $this->input->get_post ( "authors", TRUE );
				$price = $this->input->get_post ( "price", TRUE );
				$file_path = $data ['upload_data'] ['full_path'];
				$file = explode ( "/", $file_path );
				$file_xml = explode ( ".", $file [count ( $file ) - 1] );
				$var = $this->session->userdata ( 'filename' );
				$var = $file_xml [0];
				$xml_dir = explode ( "/", $value );
				$explode_file = $xml_dir [count ( $xml_dir ) - 1];
				$file = explode ( ".xml", $explode_file );
				
				$filename = $file [0];
				if ($this->xml->load ( "../uploads/xml/" . $foldername . "/" . $filename . "" )) { // Relative to APPPATH, ".xml" appended
					$this->xml->parse ();
					$this->parse_data = $this->xml->get_xml_data ();
					
					$this->user_id = $_SESSION ['user_id'];
					
					$this->book_id = $this->Xmlload_model->is_isbnexits ( $this->isbn );
					if (! $this->book_id)
						$this->book_id = $this->Xmlload_model->add_isbn ( $this->isbn, $this->user_id, $description, $booktitle, $booktitledes, $authors, $price, $this->config->item ( 'book_thumb_destination_img' ) );
					$this->vol_id = $this->Xmlload_model->is_volumeexists ( $this->book_id, $this->vol_no );
					if (! $this->vol_id)
						$this->vol_id = $this->Xmlload_model->add_volume ( $this->vol_no, $this->user_id, $this->book_id );
					$content = $this->get_xml_details ( $this->parse_data, $filename );
					print_r($content);
					$num_length = strlen ( ( string ) $this->isbn );
					if ($num_length == 13) {
						
						// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
						
					    
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "commentary" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "pages" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "xml" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "cover_img" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "content_img" . "/", 0777, TRUE );
						/*
						 * This will create directory(For Thumbnail Directory)
						 */
						// @mkdir($this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/"."img/thumbs"."/", 0777, TRUE);
						/*
						 * End For Thumbnail Directory
						 */
						if ($zip->open ( "./" . $this->config->item ( 'upload_xml_path' ) . $foldername . "/images-png.zip" ) === TRUE) {
							$zip->extractTo ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "content_img" );
							$zip->close ();
						}
						/* -----------For Saving the thumbnails images(For Thumbnail Image Creation)------------------- */
						/*
						 * $dirname=$this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/"."content_img";
						 * $thumbwidth = 100;
						 * $thumbheight = 100;
						 * $quality=100;
						 * $newdir = scandir($dirname);
						 * foreach ($newdir as $key => $value) {
						 * if ($value!='.' && $value!='..') {
						 * $thumburl = $this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/"."content_img/thumbs/".$value;
						 * $sourcefile =$dirname.'/'. $value;
						 * $endfile = $thumburl;
						 * $this->makeThumbnail($sourcefile, $endfile, $thumbwidth, $thumbheight, $quality);
						 * }
						 * }
						 */
						/* -----------------------End For Showing thumbnail images----------- */
						// copy cover image to book path
						@copy ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $this->config->item ( 'book_thumb_source_img' ), $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/cover_img/" . $this->config->item ( 'book_thumb_source_img' ) );
						
						@copy ( '../asce_content/tmp/css/jats-preview.css', '../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/pages/jats-preview.css' );
						@copy ( '../asce_content/tmp/css/jats-preview.css', '../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/jats-preview.css' );
						
						$config ['image_library'] = 'gd2';
						$config ['source_image'] = $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/cover_img/cover_img.jpg";
						$config ['create_thumb'] = true;
						$config ['maintain_ratio'] = TRUE;
						$config ['width'] = 123;
						$config ['height'] = 181;
						
						$this->load->library ( 'image_lib', $config );
						
						$sizeImg = $this->image_lib->resize ();
						
						$code = $filename;
						$chars1 = preg_split ( "/[0-9]/", $code );
						$chars2 = preg_split ( "/[a-zA-Z]/", $code );
						$chars = array_merge ( $chars1, $chars2 );
						
						if (in_array ( ".ch", $chars )) {
							
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
				/*			$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/' 
							);*/
							
							/*
							 * Thums path Change(Image Zoom)
							 */
					/*		if ($code == '9780784412916.ch01') {
								$replace = array (
										'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
										"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
										"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
										"<!--<book-id \${1})>\${2}<\/book-id>-->",
										"<!--<book-title>\${1}<\/book-title>-->",
										"<!--<day>\${1}<\/day>-->",
										"<!--<month>\${1}<\/month>-->",
										"<year>\${1}</year>",
										"<!--<isbn \${1})>\${2}<\/isbn>-->",
										"<publisher-name>\${1}</publisher-name>",
										"<publisher-loc>\${1}</publisher-loc>",
										"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
										"<!--<copyright-year>\${1}<\/copyright-year>-->",
										"<!--<edition>\${1}<\/edition>-->",
										"<!--<collab>ASCE<\/collab>-->",
										"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
										"<!--<fpage>\${1}<\/fpage>-->",
										"<!--<lpage>\${1}<\/lpage>-->",
										"<sec \${1}>" 
								);
							} else {
								$replace = array (
										'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
										"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
										"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
										"<!--<book-id \${1})>\${2}<\/book-id>-->",
										"<!--<book-title>\${1}<\/book-title>-->",
										"<!--<day>\${1}<\/day>-->",
										"<!--<month>\${1}<\/month>-->",
										"<!--<year>\${1}<\/year>-->",
										"<!--<isbn \${1})>\${2}<\/isbn>-->",
										"<!--<publisher-name>\${1}<\/publisher-name>-->",
										"<!--<publisher-loc>\${1}<\/publisher-loc>-->",
										"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
										"<!--<copyright-year>\${1}<\/copyright-year>-->",
										"<!--<edition>\${1}<\/edition>-->",
										"<!--<collab>ASCE<\/collab>-->",
										"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
										"<!--<fpage>\${1}<\/fpage>-->",
										"<!--<lpage>\${1}<\/lpage>-->",
										"<sec \${1}>" 
								);
							} */
							/*
							 * End
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
							$result =  $xml ;
				/*			$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result ); */
							/* ---------------Replacement of special Characters---------------- */
						/*	$result = str_replace ( '&ldquo;', '&#x0201C;', $result );
							$result = str_replace ( '&rdquo;', '&#x0201D;', $result );
							$result = str_replace ( '&nbsp;', '&#xA0;', $result );
							$result = str_replace ( '&copy;', '&#xA9;', $result );
							$result = str_replace ( '&times;', '&#215;', $result );
							$result = str_replace ( '&alpha;', '&#x3B1;', $result );
							$result = str_replace ( '&beta;', '&#x392;', $result );
							$result = str_replace ( '&gamma;', '&#x393;', $result );
							$result = str_replace ( '&minus;', '&#045;', $result );
							$result = str_replace ( '&equals;', '&#61;', $result );
							$result = str_replace ( '&rsquo;', '&#x2019;', $result );
							$result = str_replace ( '&ThinSpace;', '&#8201;', $result );
							$result = str_replace ( '&mdash;', '&#8212;', $result );
							$result = str_replace ( '&ndash;', '&#8213;', $result );
							$result = str_replace ( '&ensp;', '&#x2002;', $result );
							$result = str_replace ( '&emsp;', '&#x02003;', $result );
							$result = str_replace ( '&ccedil;', '&#xe7;', $result );
							$result = str_replace ( '&le;', '&#x02264;', $result );
							$result = str_replace ( '&ge;', '&#x02264;', $result );
							$result = str_replace ( '&ApplyFunction;', '', $result );
							$result = str_replace ( '&thinsp;', '&#x000D7;', $result );
							$result = str_replace ( '&phi;', '&#x3A6;', $result );
							$result = str_replace ( '&Phi;', '&#x3A6;', $result );
							$result = str_replace ( '&psi;', '&#x3A8;', $result );
							$result = str_replace ( '&radic;', '&#x221A;', $result );
							$result = str_replace ( '&rho;', '&#x3A1;', $result );
							$result = str_replace ( '&theta;', '&#x398;', $result );
							$result = str_replace ( '&Delta;', '&#x394;', $result );
							$result = str_replace ( '&xi;', '&#x39E;', $result );
							$result = str_replace ( '&eta;', '&#x3B7;', $result );
							$result = str_replace ( '&Omega;', '&#x3A9;', $result );
							$result = str_replace ( '&omega;', '&#x3A9;', $result );
							$result = str_replace ( '&pi;', '&#x3C0;', $result );
							$result = str_replace ( '&le;', '&#x2264;', $result );
							$result = str_replace ( '&plusmn;', '&#177;', $result );
							$result = str_replace ( '&sum;', '&#x2211;', $result );
							$result = str_replace ( '&deg;', '&#176;', $result );
							$result = str_replace ( '&ntilde;', '&#209;', $result );
							$result = str_replace ( '&phiv;', '&#x003D5;', $result );
							$result = str_replace ( '&half;', '&#189;', $result );
							$result = str_replace ( '&frac14;', '&#188;', $result );
							$result = str_replace ( 'oasis:table frame="topbot"', 'oasis:table frame="topbot" xmlns:oasis="http://www.niso.org/standards/z39-96/ns/oasis-exchange/table"', $result );
							$result = str_replace ( 'oasis:table frame="none"', 'oasis:table frame="none" xmlns:oasis="http://www.niso.org/standards/z39-96/ns/oasis-exchange/table"', $result );
							*/
							/* --------------------------End------------------------------------ */
							/*
							 * End For Image Zoom
							 */
							$jpeg = explode ( ".", $explode_file );
							$image = $jpeg [1];
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$final_html = $explode [1] . ".html";
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/pages/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"' );
							
							$css_preview = "jats-preview.css";
						}
						
						if (in_array ( ".chc", $chars )) {
							
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
						/*	$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/' 
							);
							*/
							/*
							 * For Thumbnail Paths Image Zoom
							 */
						/*	$replace = array (
									'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
									"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
									"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
									"<!--<book-id \${1})>\${2}<\/book-id>-->",
									"<!--<book-title>\${1}<\/book-title>-->",
									"<!--<day>\${1}<\/day>-->",
									"<!--<month>\${1}<\/month>-->",
									"\${1}",
									"<!--<isbn \${1})>\${2}<\/isbn>-->",
									"\${1}",
									"\${1}",
									"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
									"<!--<copyright-year>\${1}<\/copyright-year>-->",
									"<!--<edition>\${1}<\/edition>-->",
									"<!--<collab>ASCE<\/collab>-->",
									"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
									"\${1}",
									"\${1}",
									"<sec \${1}>" 
							);*/
							/*
							 * end
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
					/*		$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result );*/
							$result = $xml ;
							/* ---------------Replacement of special Characters---------------- */
							/* --------------------------End------------------------------------ */
							/*
							 * End Code Image Zoom
							 */
							// $result = preg_replace($find, $replace, $xml);
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$final_html = $explode [1] . ".html";
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html-commentary.xsl"' );
							
							$css_preview = "jats-preview.css";
						}
						if (in_array ( ".ap", $chars ) || in_array ( ".apA", $chars ) || in_array ( ".apB", $chars ) || in_array ( ".apC", $chars ) || in_array ( ".apD", $chars ) || in_array ( ".apE", $chars ) || in_array ( ".apF", $chars ) || in_array ( ".apG", $chars )  )
						{
				//		if (in_array ( ".ap", $chars )) {
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
				/*			$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/' 
							); */
							
							/*
							 * For Thumbnails Image Zoom
							 */
		/*					$replace = array (
									'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
									"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
									"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
									"<!--<book-id \${1})>\${2}<\/book-id>-->",
									"<!--<book-title>\${1}<\/book-title>-->",
									"<!--<day>\${1}<\/day>-->",
									"<!--<month>\${1}<\/month>-->",
									"<!--<year>\${1}<\/year>-->",
									"<!--<isbn \${1})>\${2}<\/isbn>-->",
									"<!--<publisher-name>\${1}<\/publisher-name>-->",
									"<!--<publisher-loc>\${1}<\/publisher-loc>-->",
									"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
									"<!--<copyright-year>\${1}<\/copyright-year>-->",
									"<!--<edition>\${1}<\/edition>-->",
									"<!--<collab>ASCE<\/collab>-->",
									"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
									"<!--<fpage>\${1}<\/fpage>-->",
									"<!--<lpage>\${1}<\/lpage>-->",
									"<sec \${1}>" 
							); */
							/*
							 * End
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
							$result =  $xml ;
						/*	$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result );*/
							/*
							 * End Image Zoom
							 */
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$final_html = $explode [1] . ".html";
							$insert_string = "c";
							$newstring = substr_replace ( $explode [1], 'c', - 2, - 2 );
							$appefile = $newstring . ".html";
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/pages/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"' );
							
							$blank_html = "blank.html";
							$ap = '"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $blank_html . '"';
							
							if (file_exists ( $ap )) {
								
								echo "The file $filename exists";
							} else {
								@copy ( '../asce_content/tmp/blank/blank.html', '../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $appefile . '' );
							}
						}
						if (in_array ( ".apc", $chars ) || in_array ( ".apcA", $chars ) || in_array ( ".apcB", $chars ) || in_array ( ".apcC", $chars ) || in_array ( ".apcD", $chars ) || in_array ( ".apcE", $chars ) || in_array ( ".apcF", $chars ) || in_array ( ".apcG", $chars )  )
						{
					//	if (in_array ( ".apc", $chars )) {
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
					/*		$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/' 
							); */
							
							/*
							 * For Thumbnails Image Zoom
							 */
				/*			$replace = array (
									'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
									"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
									"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
									"<!--<book-id \${1})>\${2}<\/book-id>-->",
									"<!--<book-title>\${1}<\/book-title>-->",
									"<!--<day>\${1}<\/day>-->",
									"<!--<month>\${1}<\/month>-->",
									"\${1}",
									"<!--<isbn \${1})>\${2}<\/isbn>-->",
									"\${1}",
									"\${1}",
									"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
									"<!--<copyright-year>\${1}<\/copyright-year>-->",
									"<!--<edition>\${1}<\/edition>-->",
									"<!--<collab>ASCE<\/collab>-->",
									"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
									"\${1}",
									"\${1}",
									"<sec \${1}>" 
							); */
							/*
							 * End
							 *
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
							$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result );
							/*
							 * End Image Zoom
							 */
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$final_html = $explode [1] . ".html";
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html-commentary.xsl"' );
						}
					
					/**
					 * ********Updated By Arul ******************
					 */
						/*
						 * if(in_array(".cfm",$chars)){
						 * $fileext = ".xml";
						 * $xml= file_get_contents($this->config->item('upload_xml_path').$foldername."/".$explode_file);
						 *
						 * $find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" .
						 * "xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" ([^>]*)>/');
						 */
						
						/*
						 * For Thumbnails Image Zoom
						 */
						/* $replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<a href=\"../content_img/\${2}.jpg\" class='fancybox img-space'><graphic\${1} xlink:href=\"../img/thumbs/\${2}.jpg\"/></a>", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", "<sec \${1}>"); */
						/*
						 * End
						 */
						// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
						// $result=str_replace('</a>/>', '</a>', $result);
						// $result = preg_replace($find, $replace, $xml);
						/*
						 * End Image Zoom
						 */
						// $fwrite = file_put_contents($this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/xml/".$explode_file, $result);
						
						// /$explode = explode(".",$filename);
						// $final_file = $explode[1];
						// $chap_name = explode("_",$explode[0]);
						// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
						// $chars2 = preg_split("/[a-zA-Z]/",$code );
						// $chars = array_merge($chars1,$chars2);
						
						/*
						 * $final_html = $final_file.".html";
						 * $result = exec('java -jar '.$this->config->item('jar_path').' -s:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/xml/' . $explode_file . '" -o:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
						 *
						 * $blank_html = "blank.html";
						 * $cfm = '"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/commentary/' . $blank_html .'"';
						 *
						 * if (file_exists($cfm)) {
						 *
						 * echo "The file $filename exists";
						 * } else {
						 * @copy('../asce_content/tmp/blank/blank.html', '../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/commentary/'.'c'.$final_html.'');
						 * }
						 *
						 *
						 * }
						 */
					/**
					 * ********Update By Arul ******************
					 */
						// }
						
						// else{
						// echo "".$this->isbn." Exist";
						// }
					} else {
						echo "Please enter 13 Digit ISBN number";
					}
				}
			}
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$data ['result'] = $this->Success_result;
			$data ['result'] = $this->Success_result;
			$this->Book_m->delete_dir($dir);
			$this->Book_m->delete_zip($dir);
			$this->load->pagetemplate ( 'uploadbooks_sucess', $data );
			// redirect('Book_library/list_book', 'refresh');
		}
	}
	/* ------------------------------------------------Function For Updating XML Code---------------------------------- */
	function updateBookContent() {
		$data ['userInfo'] = $this->userinfo ();
		$config ['upload_path'] = ("./" . $this->config->item ( 'upload_xml_path' ));
		$config ['allowed_types'] = '*';
		$config ['max_size'] = '9999999999';
		
		$this->load->library ( 'upload', $config );
		
		if (! $this->upload->do_upload ()) {
			$error = array (
					'error' => $this->upload->display_errors () 
			);
			$this->load->view ( 'upload_xml', $error );
		} else {
			$basepath = $this->config->item ( 'base_url' );
			$playerpath = explode ( "/", $basepath );
			$folderpath = '../' . $playerpath [3] . '';
			// print_r ($playerpath);
			// exit;
			// $playerpath = "../ASCE_Services";
			// exit;
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			// $this->load->pagetemplate('upload_xmlsuccess', $data);
			$isbn ["isbn"] = $this->input->get_post ( "isbn", TRUE );
			$bokvolno ["volumeno"] = $this->input->get_post ( "volumeno", TRUE );
			$file_path = $data ['upload_data'] ['full_path'];
			$file = explode ( "/", $file_path );
			$file_xml = explode ( ".", $file [count ( $file ) - 1] );
			// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$zip = new ZipArchive ();
			$file = $data ['upload_data'] ['full_path'];
			$explode_files = explode ( "/", $file );
			$extract_file = explode ( ".", $explode_files [count ( $explode_files ) - 1] );
			$foldername = $extract_file [0];
			chmod ( $file, 0777 );
			if ($zip->open ( $file ) === TRUE) {
				$zip->extractTo ( "./" . $this->config->item ( 'upload_xml_path' ) . $foldername );
				$zip->close ();
				$result = array ();
				$isbn ["isbn"] = $this->input->get_post ( "isbn", TRUE );
				$separator = DIRECTORY_SEPARATOR;
				$paths = 'relative';
				$date = date ( 'Y-m-d H:i:s' );
				
				$dir = $this->config->item ( 'upload_xml_path' ) . $foldername;
				$files = glob ( "" . $dir . "/*xml" );
				$files1 = glob ( "" . $dir . "/*jpg" );
				$files2 = glob ( "" . $dir . "/*zip" );
				if ($files1) {
					$this->Success_result [] = " <font color=''>Cover Image Updated Successfully !!..</font>  </br>";
				}
				if ($files2) {
					$this->Success_result [] = " <font color=''>Images Updated Successfully !!..</font>  </br>";
				}
				
				$cdir = scandir ( $dir );
				
				foreach ( $cdir as $key => $value ) {
					
					if (! in_array ( $value, array (
							".",
							".." 
					) )) {
						if (is_dir ( $dir . $separator . $value )) {
							$result [$value] = $this->dir_to_array ( $dir . $separator . $value, $separator, $paths );
						} else {
							if ($paths == 'relative') {
								$result [] = $dir . '/' . $value;
							} elseif ($paths == 'absolute') {
								$result [] = base_url () . $dir . '/' . $value;
							}
						}
					}
				}
			} else {
				echo 'failed';
			}
			
			foreach ( $result as $key => $value ) {
				$data ['userInfo'] = $this->session->userdata ( 'userInfo' );
				/*
				 * if(!count($data['userInfo'])) Comment By Anuj
				 * redirect('admin/', 'refresh');
				 */
				$this->isbn = $this->input->post ( 'isbn' );
				$this->vol_no = $this->input->post ( 'volumeno' );
				$booktitle = $this->input->post ( 'booktitle' );
				$file_path = $data ['upload_data'] ['full_path'];
				$file = explode ( "/", $file_path );
				$file_xml = explode ( ".", $file [count ( $file ) - 1] );
				$var = $this->session->userdata ( 'filename' );
				$var = $file_xml [0];
				$xml_dir = explode ( "/", $value );
				$explode_file = $xml_dir [count ( $xml_dir ) - 1];
				$file = explode ( ".xml", $explode_file );
				$filename = $file [0];
				if ($this->xml->load ( "../uploads/xml/" . $foldername . "/" . $filename . "" )) { // Relative to APPPATH, ".xml" appended
					$this->xml->parse ();
					$this->parse_data = $this->xml->get_xml_data ();
					
					$this->user_id = $_SESSION ['user_id'];
					
					$this->book_id = $this->Xmlload_model->is_isbnexits ( $this->isbn );
					if (! $this->book_id)
						$this->book_id = $this->Xmlload_model->add_isbn ( $this->isbn, $this->user_id, $description, $booktitle, $booktitledes, $authors, $price, $this->config->item ( 'book_thumb_destination_img' ) );
					$this->vol_id = $this->Xmlload_model->is_volumeexists ( $this->book_id, $this->vol_no );
					if (! $this->vol_id)
						$this->vol_id = $this->Xmlload_model->add_volume ( $this->vol_no, $this->user_id, $this->book_id );
					$content = $this->get_xml_details ( $this->parse_data, $filename );
					
					$num_length = strlen ( ( string ) $this->isbn );
					if ($num_length == 13) {
						
						// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "commentary" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "pages" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "xml" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "cover_img" . "/", 0777, TRUE );
						@mkdir ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "content_img" . "/", 0777, TRUE );
						/*
						 * This will create directory(For Thumbnail Directory)
						 */
						// @mkdir($this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/"."img/thumbs"."/", 0777, TRUE);
						/*
						 * End For Thumbnail Directory
						 */
						if ($zip->open ( "./" . $this->config->item ( 'upload_xml_path' ) . $foldername . "/images-png.zip" ) === TRUE) {
							$zip->extractTo ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/" . "content_img" );
							$zip->close ();
						}
						/* -----------For Saving the thumbnails images(For Thumbnail Image Creation)------------------- */
						/*
						 * $dirname=$this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/"."content_img";
						 * $thumbwidth = 100;
						 * $thumbheight = 100;
						 * $quality=100;
						 * $newdir = scandir($dirname);
						 * foreach ($newdir as $key => $value) {
						 * if ($value!='.' && $value!='..') {
						 * $thumburl = $this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/"."content_img/thumbs/".$value;
						 * $sourcefile =$dirname.'/'. $value;
						 * $endfile = $thumburl;
						 * $this->makeThumbnail($sourcefile, $endfile, $thumbwidth, $thumbheight, $quality);
						 * }
						 * }
						 */
						/* -----------------------End For Showing thumbnail images----------- */
						// copy cover image to book path
						@copy ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $this->config->item ( 'book_thumb_source_img' ), $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/cover_img/" . $this->config->item ( 'book_thumb_source_img' ) );
						
						@copy ( '../asce_content/tmp/css/jats-preview.css', '../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/pages/jats-preview.css' );
						@copy ( '../asce_content/tmp/css/jats-preview.css', '../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/jats-preview.css' );
						
						$config ['image_library'] = 'gd2';
						$config ['source_image'] = $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/cover_img/cover_img.jpg";
						$config ['create_thumb'] = true;
						$config ['maintain_ratio'] = TRUE;
						$config ['width'] = 123;
						$config ['height'] = 181;
						
						$this->load->library ( 'image_lib', $config );
						
						$sizeImg = $this->image_lib->resize ();
						
						$code = $filename;
						$chars1 = preg_split ( "/[0-9]/", $code );
						$chars2 = preg_split ( "/[a-zA-Z]/", $code );
						$chars = array_merge ( $chars1, $chars2 );
						
						if (in_array ( ".ch", $chars )) {
							
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
				/*		$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/',
									'/<named-content content-type="insertion" ([^>]*)>(.*?)<\/named-content>/',
									'/<named-content content-type="deletion" ([^>]*)>(.*?)<\/named-content>/' 
							); */
							
							/*
							 * Thums path Change(Image Zoom)
							 */
				/*			if ($code == '9780784412916.ch01') {
								$replace = array (
										'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
										"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
										"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
										"<!--<book-id \${1})>\${2}<\/book-id>-->",
										"<!--<book-title>\${1}<\/book-title>-->",
										"<!--<day>\${1}<\/day>-->",
										"<!--<month>\${1}<\/month>-->",
										"<year>\${1}</year>",
										"<!--<isbn \${1})>\${2}<\/isbn>-->",
										"<publisher-name>\${1}</publisher-name>",
										"<publisher-loc>\${1}</publisher-loc>",
										"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
										"<!--<copyright-year>\${1}<\/copyright-year>-->",
										"<!--<edition>\${1}<\/edition>-->",
										"<!--<collab>ASCE<\/collab>-->",
										"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
										"<!--<fpage>\${1}<\/fpage>-->",
										"<!--<lpage>\${1}<\/lpage>-->",
										"<sec \${1}>",
										"<font style='color:green' \${1}>\${2}</font>",
										"<strike style='color:red' \${1}>\${2}</strike>" 
								);
							} else {
								$replace = array (
										'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
										"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
										"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
										"<!--<book-id \${1})>\${2}<\/book-id>-->",
										"<!--<book-title>\${1}<\/book-title>-->",
										"<!--<day>\${1}<\/day>-->",
										"<!--<month>\${1}<\/month>-->",
										"<!--<year>\${1}<\/year>-->",
										"<!--<isbn \${1})>\${2}<\/isbn>-->",
										"<!--<publisher-name>\${1}<\/publisher-name>-->",
										"<!--<publisher-loc>\${1}<\/publisher-loc>-->",
										"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
										"<!--<copyright-year>\${1}<\/copyright-year>-->",
										"<!--<edition>\${1}<\/edition>-->",
										"<!--<collab>ASCE<\/collab>-->",
										"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
										"<!--<fpage>\${1}<\/fpage>-->",
										"<!--<lpage>\${1}<\/lpage>-->",
										"<sec \${1}>",
										"<font style='color:green' \${1}>\${2}</font>",
										"<strike style='color:red' \${1}>\${2}</strike>" 
								);
							}  */
							/*
							 * End
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
					/*		$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result ); */
							$result = $xml;
							/*
							 * End For Image Zoom
							 */
							$jpeg = explode ( ".", $explode_file );
							$image = $jpeg [1];
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							$contentVersion = $this->get_string_between ( $filename, '_', '.' );
							if(!empty($contentVersion)){
							    $final_html = $explode [1] . '_' . $contentVersion . ".html";
							}
							else {
							    $final_html = $explode [1] . ".html";
							}$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/pages/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"' );
							
							$css_preview = "jats-preview.css";
						}
						
						if (in_array ( ".chc", $chars )) {
							
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
	/*						$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/',
									'/<named-content content-type="insertion" ([^>]*)>(.*?)<\/named-content>/',
									'/<named-content content-type="deletion" ([^>]*)>(.*?)<\/named-content>/' 
							); */
							
							/*
							 * For Thumbnail Paths Image Zoom
							 */
				/*			$replace = array (
									'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
									"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
									"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
									"<!--<book-id \${1})>\${2}<\/book-id>-->",
									"<!--<book-title>\${1}<\/book-title>-->",
									"<!--<day>\${1}<\/day>-->",
									"<!--<month>\${1}<\/month>-->",
									"<!--<year>\${1}<\/year>-->",
									"<!--<isbn \${1})>\${2}<\/isbn>-->",
									"<!--<publisher-name>\${1}<\/publisher-name>-->",
									"<!--<publisher-loc>\${1}<\/publisher-loc>-->",
									"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
									"<!--<copyright-year>\${1}<\/copyright-year>-->",
									"<!--<edition>\${1}<\/edition>-->",
									"<!--<collab>ASCE<\/collab>-->",
									"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
									"<!--<fpage>\${1}<\/fpage>-->",
									"<!--<lpage>\${1}<\/lpage>-->",
									"<sec \${1}>",
									"<font style='color:green' \${1}>\${2}</font>",
									"<strike style='color:red' \${1}>\${2}</strike>" 
							);*/
							/*
							 * end
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
					/*		$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result );*/
							$result =  $xml ;
							/*
							 * End Code Image Zoom
							 */
							// $result = preg_replace($find, $replace, $xml);
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$contentVersion = $this->get_string_between ( $filename, '_', '.' );
							if(!empty($contentVersion)){
							$final_html = $explode [1] . '_' . $contentVersion . ".html";
							}
							else {
							    $final_html = $explode [1] . ".html";
							}
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html-commentary.xsl"' );
							
							
							$css_preview = "jats-preview.css";
						}
						
				//		if (in_array ( ".ap", $chars )) {
						    if (in_array ( ".ap", $chars ) || in_array ( ".apA", $chars ) || in_array ( ".apB", $chars ) || in_array ( ".apC", $chars ) || in_array ( ".apD", $chars ) || in_array ( ".apE", $chars ) || in_array ( ".apF", $chars ) || in_array ( ".apG", $chars )  )
						    {
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
			/*				$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/',
									'/<named-content content-type="insertion" ([^>]*)>(.*?)<\/named-content>/',
									'/<named-content content-type="deletion" ([^>]*)>(.*?)<\/named-content>/' 
							); */
							
							/*
							 * For Thumbnails Image Zoom
							 */
					/*		$replace = array (
									'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
									"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
									"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
									"<!--<book-id \${1})>\${2}<\/book-id>-->",
									"<!--<book-title>\${1}<\/book-title>-->",
									"<!--<day>\${1}<\/day>-->",
									"<!--<month>\${1}<\/month>-->",
									"<!--<year>\${1}<\/year>-->",
									"<!--<isbn \${1})>\${2}<\/isbn>-->",
									"<!--<publisher-name>\${1}<\/publisher-name>-->",
									"<!--<publisher-loc>\${1}<\/publisher-loc>-->",
									"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
									"<!--<copyright-year>\${1}<\/copyright-year>-->",
									"<!--<edition>\${1}<\/edition>-->",
									"<!--<collab>ASCE<\/collab>-->",
									"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
									"<!--<fpage>\${1}<\/fpage>-->",
									"<!--<lpage>\${1}<\/lpage>-->",
									"<sec \${1}>",
									"<font style='color:green' \${1}>\${2}</font>",
									"<strike style='color:red' \${1}>\${2}</strike>" 
							);  */
							/*
							 * End
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
							$result =  $xml ;
					/*		$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result ); */
							/*
							 * End Image Zoom
							 */
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$contentVersion = $this->get_string_between ( $filename, '_', '.' );
							
							if(!empty($contentVersion)){
							    $final_html = $explode [1] . '_' . $contentVersion . ".html";
							}
							else {
							    $final_html = $explode [1] . ".html";
							}
							$insert_string = "c";
							$newstring = substr_replace ( $explode [1], 'c', - 2, - 2 );
							$appefile = $newstring . ".html";
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/pages/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"' );
							
							$blank_html = "blank.html";
							$ap = '"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $blank_html . '"';
							
							if (file_exists ( $ap )) {
								
								echo "The file $filename exists";
							} else {
								@copy ( '../asce_content/tmp/blank/blank.html', '../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $appefile . '' );
							}
						}
						
					//	if (in_array ( ".apc", $chars )) {
						    if (in_array ( ".apc", $chars ) || in_array ( ".apcA", $chars ) || in_array ( ".apcB", $chars ) || in_array ( ".apcC", $chars ) || in_array ( ".apcD", $chars ) || in_array ( ".apcE", $chars ) || in_array ( ".apcF", $chars ) || in_array ( ".apcG", $chars )  )
						    {
							$fileext = ".xml";
							$xml = file_get_contents ( $this->config->item ( 'upload_xml_path' ) . $foldername . "/" . $explode_file );
							
				/*			$find = array (
									'/<!DOCTYPE [^>]+>/',
									"/<graphic([^>]*)" . "xlink:href=\"([^\"]*).jpg\"/",
									"/<collection-id ([^>]*)>(.*?)<\/collection-id>/",
									"/<book-id ([^>]*)>(.*?)<\/book-id>/",
									"/<book-title>(.*?)<\/book-title>/",
									"/<day>(.*?)<\/day>/",
									"/<month>(.*?)<\/month>/",
									"/<year>(.*?)<\/year>/",
									"/<isbn ([^>]*)>(.*?)<\/isbn>/",
									"/<publisher-name>(.*?)<\/publisher-name>/",
									"/<publisher-loc>(.*?)<\/publisher-loc>/",
									"/<copyright-statement>(.*?)<\/copyright-statement>/",
									"/<copyright-year>(.*?)<\/copyright-year>/",
									"/<edition>(.*?)<\/edition>/",
									"/<collab>ASCE<\/collab>/",
									"/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/",
									"/<fpage>(.*?)<\/fpage>/",
									"/<lpage>(.*?)<\/lpage>/",
									'/<sec disp-level="0" ([^>]*)>/',
									'/<named-content content-type="insertion" ([^>]*)>(.*?)<\/named-content>/',
									'/<named-content content-type="deletion" ([^>]*)>(.*?)<\/named-content>/' 
							); */
							
							/*
							 * For Thumbnails Image Zoom
							 */
			/*				$replace = array (
									'<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->',
									"<a href=\"../content_img/\${2}.png\" class='fancybox img-space'><graphic\${1} xlink:href=\"../content_img/thumbs/\${2}_thumb.jpg\"/></a>",
									"<!--<collection-id \${1}>\${2}<\/collection-id>-->",
									"<!--<book-id \${1})>\${2}<\/book-id>-->",
									"<!--<book-title>\${1}<\/book-title>-->",
									"<!--<day>\${1}<\/day>-->",
									"<!--<month>\${1}<\/month>-->",
									"<!--<year>\${1}<\/year>-->",
									"<!--<isbn \${1})>\${2}<\/isbn>-->",
									"<!--<publisher-name>\${1}<\/publisher-name>-->",
									"<!--<publisher-loc>\${1}<\/publisher-loc>-->",
									"<!--<copyright-statement>\${1}<\/copyright-statement>-->",
									"<!--<copyright-year>\${1}<\/copyright-year>-->",
									"<!--<edition>\${1}<\/edition>-->",
									"<!--<collab>ASCE<\/collab>-->",
									"<!--<book-part-id \${1})>\${2}<\/book-part-id>-->",
									"<!--<fpage>\${1}<\/fpage>-->",
									"<!--<lpage>\${1}<\/lpage>-->",
									"<sec \${1}>",
									"<font style='color:green' \${1}>\${2}</font>",
									"<strike style='color:red' \${1}>\${2}</strike>" 
							); */
							/*
							 * End
							 *
							 */
							// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
							$result =  $xml ;
						/*	$result = preg_replace ( $find, $replace, $xml );
							$result = str_replace ( '</a>/>', '</a>', $result ); */
							/*
							 * End Image Zoom
							 */
							$fwrite = file_put_contents ( $this->config->item ( 'book_path' ) . $this->isbn . "/vol-" . $this->vol_no . "/xml/" . $explode_file, $result );
							
							$explode = explode ( ".", $filename );
							
							// $chap_name = explode("_",$explode[0]);
							// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
							// $chars2 = preg_split("/[a-zA-Z]/",$code );
							// $chars = array_merge($chars1,$chars2);
							
							$contentVersion = $this->get_string_between ( $filename, '_', '.' );
							
							if(!empty($contentVersion)){
							    $final_html = $explode [1] . '_' . $contentVersion . ".html";
							}
							else {
							    $final_html = $explode [1] . ".html";
							}
							$result = exec ( 'java -jar ' . $this->config->item ( 'jar_path' ) . ' -s:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/xml/' . $explode_file . '" -o:"../asce_content/book/' . $this->isbn . '/vol-' . $this->vol_no . '/commentary/' . $final_html . '" -xsl:"../asce_content/tool/src/xsl/jats-html-commentary.xsl"' );
						}
					
					/**
					 * ********Updated By Arul ******************
					 */
						/*
						 * if(in_array(".cfm",$chars)){
						 * $fileext = ".xml";
						 * $xml= file_get_contents($this->config->item('upload_xml_path').$foldername."/".$explode_file);
						 *
						 * $find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" .
						 * "xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" ([^>]*)>/');
						 */
						
						/*
						 * For Thumbnails Image Zoom
						 */
						/* $replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<a href=\"../content_img/\${2}.jpg\" class='fancybox img-space'><graphic\${1} xlink:href=\"../img/thumbs/\${2}.jpg\"/></a>", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", "<sec \${1}>"); */
						/*
						 * End
						 */
						// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
						// $result=str_replace('</a>/>', '</a>', $result);
						// $result = preg_replace($find, $replace, $xml);
						/*
						 * End Image Zoom
						 */
						// $fwrite = file_put_contents($this->config->item('book_path') .$this->isbn."/vol-".$this->vol_no."/xml/".$explode_file, $result);
						
						// /$explode = explode(".",$filename);
						// $final_file = $explode[1];
						// $chap_name = explode("_",$explode[0]);
						// $chars1 = preg_split("/[0-9]/",$chap_name[1]);
						// $chars2 = preg_split("/[a-zA-Z]/",$code );
						// $chars = array_merge($chars1,$chars2);
						
						/*
						 * $final_html = $final_file.".html";
						 * $result = exec('java -jar '.$this->config->item('jar_path').' -s:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/xml/' . $explode_file . '" -o:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
						 *
						 * $blank_html = "blank.html";
						 * $cfm = '"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/commentary/' . $blank_html .'"';
						 *
						 * if (file_exists($cfm)) {
						 *
						 * echo "The file $filename exists";
						 * } else {
						 * @copy('../asce_content/tmp/blank/blank.html', '../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/commentary/'.'c'.$final_html.'');
						 * }
						 *
						 *
						 * }
						 */
					/**
					 * ********Update By Arul ******************
					 */
						// }
						
						// else{
						// echo "".$this->isbn." Exist";
						// }
					} else {
						echo "Please enter 13 Digit ISBN number";
					}
				}
			}
			$this->session->set_userdata ( 'last_url', '' );
			$data ['userInfo'] = $this->userinfo ();
			$data ['result'] = $this->Success_result;
			$this->load->pagetemplate ( 'uploadbooks_sucess', $data );
			// redirect('Book_library/list_book', 'refresh');
		}
	}
	/* ---------------------------------------------------------End---------------------------------------------------- */
	// Get details from xml file
	public function get_xml_details($data, $file_name) {
		// Get front matter details
		$frontmatter_details = $this->parse_data->getElementsByTagName ( 'body' );
		
		foreach ( $frontmatter_details as $fm ) {
			$db_front = $this->add_frontmatter ( $fm );
		}
		$book_id = $this->book_id;
		$book_vol_id = $this->vol_no;
		$isbn = $this->isbn;
		$version = $this->get_string_between ( $file_name, '_', '.' );
		if (! empty ( $version )) {
			// Get References
			$sectionNo_details = $this->parse_data->getElementsByTagName ( 'sec' );
			$chapter_no = $this->get_last_occurence ( $file_name );
			foreach ( $sectionNo_details as $section ) {
				$sectionNo_Value = $section->getAttribute ( 'id' );
				$sectionNo_Size = strlen ( $sectionNo_Value );
				if ($sectionNo_Size > 5) {
					$namedContentValue = $section->getElementsByTagName ( 'named-content' );
					$noOfNodes = $namedContentValue->length;
					foreach ( $namedContentValue as $content ) {
						$updateType = $content->getAttribute ( 'content-type' );
						$contentVersion = $content->getAttribute ( 'specific-use' );
						$cntVersionYear = substr ( $contentVersion, 0, 4 );
						$cntVersionMonth = substr ( $contentVersion, 4, 2 );
						$cntVersionDay = substr ( $contentVersion, 6, 2 );
						// $finalVersion=$cntVersionMonth.'-'.$cntVersionDay.'-'.$cntVersionYear;
						$finalVersion = $cntVersionDay . '-' . $cntVersionMonth . '-' . $cntVersionYear;
						$value = $content->nodeValue;
						$section_no = $sectionNo_Value;
						if ($updateType == 'insertion') {
							$data = '<font style="color:green">' . $value . '</font>';
						}
						if ($updateType == 'deletion') {
							$data = '<strike style="color:red">' . $value . '</strike>';
						}
						$this->Book_m->add_ContentData ( $book_id, $book_vol_id, $isbn, $version, $finalVersion, $data, $chapter_no, $section_no );
					}
				}
			}
		}
		
		// Get chapter detils
		$chapter_details = $this->parse_data->getElementsByTagName ( 'book-part' );
		$updated_content = $this->parse_data->getElementsByTagName ( 'named-content' );
		$chapter_no = $this->get_last_occurence ( $file_name );
		$section_no = $chapter_details [0]->getAttribute ( 'id' );
		/* -----------------------------For Adding All Content In The Table------------------- */
		/*
		 * foreach($updated_content as $content){
		 * $updateType=$content->getAttribute('content-type');
		 * $contentVersion=$content->getAttribute('specific-use');
		 * $cntVersionYear=substr($contentVersion, 0, 4);
		 * $cntVersionMonth=substr($contentVersion, 4, 2);
		 * $cntVersionDay=substr($contentVersion, 6, 2);
		 * $finalVersion=$cntVersionMonth.'/'.$cntVersionDay.'/'.$cntVersionYear;
		 * $value=$content->nodeValue;
		 * if($updateType=='insertion'){
		 * $data='<font style="color:green">'.$value.'</font>';
		 * }
		 * if($updateType=='deletion'){
		 * $data='<strike style="color:red">'.$value.'</strike>';
		 * }
		 * $this->Book_m->add_ContentData($book_id,$book_vol_id,$isbn,$version,$finalVersion,$data, $chapter_no,$section_no);
		 * }
		 */
		/* --------------------------------------End----------------------------------------------- */
		foreach ( $chapter_details as $c ) {
			$return_arr = $this->add_chapter ( $c, $file_name );
			$title = $return_arr ['return'];
			if ($return_arr ['result']) {
				$this->Success_result [] = " chapter ' $title ' ( $file_name)  Updated !!..  </br>";
				/* -------------------Code For Updating New Updated Record------------------- */
				$this->Book_m->add_UpdateContent ( $book_id, $book_vol_id, $isbn, $version );
				/* ------------------------------------End----------------------------------- */
				return false;
			} else {
				$this->Success_result [] = " chapter ' $title ' ( $file_name)  has been added sucessfully !!..  </br>";
			}
			
			// Get Section detils
			$section_details = $this->parse_data->getElementsByTagName ( 'sec' );
			foreach ( $section_details as $s ) {
				$db_sec_id = $this->add_section ( $s );
			}
			// Get Table detils
			$table_details = $this->parse_data->getElementsByTagName ( 'table-wrap' );
			
			foreach ( $table_details as $t ) {
				$db_table_id = $this->add_table ( $t );
			}
			// Get figure detils
			$figure_details = $this->parse_data->getElementsByTagName ( 'fig' );
			
			foreach ( $figure_details as $f ) {
				$db_fig_id = $this->add_figure ( $f );
			}
			
			// Get chapter details for search
			foreach ( $chapter_details as $chcontent ) {
				$db_chc_id = $this->add_chcontent ( $chcontent );
			}
			// Get section details for search
			foreach ( $section_details as $seccontent ) {
				$db_chc_id = $this->add_seccontent ( $seccontent );
			}
		}
	}
	
	// Function to add chapter
	public function add_chapter($chapData, $file_name) {
		$return_arr ['result'] = false;
		$return_arr ['return'] = '';
		$chap_label = $chapData->getElementsByTagName ( 'label' )->item ( 0 )->nodeValue;
		$chap_title = $chapData->getElementsByTagName ( 'title' )->item ( 0 )->nodeValue;
		$chaplabel_id = $chapData->getAttribute ( 'id' );
		
		$explode = explode ( " ", $chap_label );
		$linkpage = $explode [1];
		$chap_name = explode ( ".", $file_name );
		
		$chars1 = preg_split ( "/[0-9]/", $chap_name [1] );
		$chars2 = preg_split ( "/[a-zA-Z]/", $chap_name [1] );
		$chars = array_merge ( $chars1, $chars2 );
		
		$explode = explode ( " ", $chap_label );
		$linkpage = $explode [1];
		$str_plabel = str_replace ( "s", "", $chaplabel_id );
		$str_clabel = str_replace ( "sc", "", $chaplabel_id );
		$str_linkpage = str_replace ( "C", "", $linkpage );
		
		$chpid = $explode [1];
		$pages = "PAGES";
		$commentary = "COMMENTARY";
		$chapters = "CONTENT";
		$appendix = "APPENDIX";
		$fm = "FRONT_MATTER";
		if ($chars [0] == "ch") {
			$panel_type = $pages;
			$toc_type = $chapters;
		}
		if ($chars [0] == "chc") {
			
			$panel_type = $commentary;
			$toc_type = $chapters;
		}
		
		if (in_array ( "ap", $chars ) || in_array ( "apA", $chars ) || in_array ( "apB", $chars ) || in_array ( "apC", $chars ) || in_array ( "apD", $chars ) || in_array ( "apE", $chars ) || in_array ( "apF", $chars ) || in_array ( "apG", $chars )  ) {
		    $panel_type = $pages;
			$toc_type = $appendix;
		}
		if (in_array ( "apc", $chars ) || in_array ( "apcA", $chars ) || in_array ( "apcB", $chars ) || in_array ( "apcC", $chars ) || in_array ( "apcD", $chars ) || in_array ( "apcE", $chars ) || in_array ( "apcF", $chars ) || in_array ( "apcG", $chars )  ) {
		    $panel_type = $commentary;
			$toc_type = $appendix;
		}
		if ($chars [0] == "cfm") {
			$panel_type = $pages;
			$toc_type = $fm;
		}
		
		$return_arr ['return'] = $chap_title;
		if ($this->Xmlload_model->is_chapter_exist ( $chaplabel_id, $chap_title, $panel_type, $this->vol_id )) {
			$return_arr ['result'] = true;
			return $return_arr;
		}
		$chap_name = explode ( ".", $file_name );
		
		$chars1 = preg_split ( "/[0-9]/", $chap_name [1] );
		$chars2 = preg_split ( "/[a-zA-Z]/", $chap_name [1] );
		$chars = array_merge ( $chars1, $chars2 );
		
		if (in_array ( "ch", $chars )) {
			$panel_type = $pages;
			$str_linkpage = $chars [3];
			$file = explode ( ".", $file_name );
			$filename = $file [1];
			$str = $chars [0] . $chars [5];
		}
		
		if (in_array ( "chc", $chars )) {
			
			$str_linkpage = $chars [4];
			$file = explode ( ".", $file_name );
			$filename = $file [1];
			$str = $filename;
		}
		
		if (in_array ( "ap", $chars ) || in_array ( "apA", $chars ) || in_array ( "apB", $chars ) || in_array ( "apC", $chars ) || in_array ( "apD", $chars ) || in_array ( "apE", $chars ) || in_array ( "apF", $chars ) || in_array ( "apG", $chars )  ) {
			
			$str_linkpage = $chars [0] . $chars [5];
			$file = explode ( ".", $file_name );
			$filename = $file [1];
			$str = $chars [0] . $chars [5];
		}
		if (in_array ( "apc", $chars ) || in_array ( "apcA", $chars ) || in_array ( "apcB", $chars ) || in_array ( "apcC", $chars ) || in_array ( "apcD", $chars ) || in_array ( "apcE", $chars ) || in_array ( "apcF", $chars ) || in_array ( "apcG", $chars )  )
		{
			
			$str_linkpage = $chars [0] . $chars [6];
			$file = explode ( ".", $file_name );
			$filename = $file [1];
			$str = $filename;
		}
		
		if (in_array ( "cfm", $chars )) {
			
			$str_linkpage = $chars [0];
			$file = explode ( ".", $file_name );
			$filename = $file [1];
			$str = $filename;
		}
		
		$this->chapter_id = $this->Xmlload_model->add_chapter ( $this->user_id, $chap_title, $chap_label, $chpid, $chaplabel_id, $str_linkpage, $this->vol_id, $panel_type, $str, $toc_type );
		
		return $return_arr;
	}
	
	// Function for add a chapter
	public function add_frontmatter($fmData) {
		$fm_para = $fmData->getElementsByTagName ( 'p' )->item ( 0 )->nodeValue;
		$panel_type = "PAGES";
		$fm_label = "Front_Matter";
		$type = "Front_Matter";
		$fm_id = "f1";
		$fm_data = $this->Xmlload_model->add_fm ( $this->chapter_id, $this->vol_id, $fm_label, $fm_id, $this->user_id, $fm_para, $type, $panel_type );
		return false;
	}
	
	// Function for add a reference
	public function add_reference($refData) {
		//error_reporting ( E_ALL ^ (E_NOTICE | E_WARNING) );
		$ref_id = $refData->getAttribute ( 'id' );
		$ref_title = $refData->getElementsByTagName ( 'title' )->item ( 0 )->nodeValue;
		$ref_para = $refData->getElementsByTagName ( 'mixed-citation' )->item ( 0 )->nodeValue;
		// $ref_id = "";
		// $ref_title = "";
		
		$commentry = "COMMENTARY";
		$str_ref = str_replace ( "cc", "", $ref_id );
		if ($ref_id == "cc" . $str_ref) {
			$type = "References";
			$panel_type = $commentry;
		}
		
		$reference_data = $this->Xmlload_model->add_content ( $this->chapter_id, $this->vol_id, $ref_title, $ref_id, $this->user_id, $ref_para, $type, $panel_type );
		return false;
	}
	
	// Function to add a section
	public function add_section($secData) {
		$sec_id = $secData->getAttribute ( 'id' );
		if (trim ( $sec_id ) == "")
			return;
		$sec_title = $secData->getElementsByTagName ( 'title' )->item ( 0 )->nodeValue;
		$sec_label = $secData->getElementsByTagName ( 'label' )->item ( 0 )->nodeValue;
		if (trim ( $sec_label ) == "")
			return;
		$sec_para = $secData->getElementsByTagName ( 'p' )->item ( 0 )->nodeValue;
		$sec_level = count ( explode ( ".", $sec_label ) ) - 2;
		$this->masterId [$sec_level] = 0;
		$sec_masterId = ($sec_level == 0 ? 0 : $this->masterId [$sec_level - 1]);
		$this->masterId [$sec_level] = $this->Xmlload_model->add_section ( $this->chapter_id, $sec_title, $this->vol_id, $sec_label, $sec_level, $sec_id, $this->user_id, $sec_masterId );
		return false;
	}
	
	// Function to add a table
	public function add_table($tableData) {
		//error_reporting ( E_ALL ^ (E_NOTICE | E_WARNING) );
		$table_id = $tableData->getAttribute ( 'id' );
		if (trim ( $table_id ) == "")
			return;
		$table_label = $tableData->getElementsByTagName ( 'label' )->item ( 0 )->nodeValue;
		if (trim ( $table_label ) == "")
			return;
		$table_para = $tableData->getElementsByTagName ( 'p' )->item ( 0 )->nodeValue;
		$type = "Table";
		$pages = "PAGES";
		$commentry = "COMMENTARY";
		$code = $table_id;
		$chars1 = preg_split ( "/[0-9]/", $code );
		$chars2 = preg_split ( "/[a-zA-Z]/", $code );
		$chars = array_merge ( $chars1, $chars2 );
		
		if (in_array ( "tc", $chars )) {
			$panel_type = $commentry;
			$table_data = $this->Xmlload_model->add_content ( $this->chapter_id, $this->vol_id, $table_label, $table_id, $this->user_id, $table_para, $type, $panel_type );
			return false;
		}
		if (in_array ( "t", $chars )) {
			$panel_type = $pages;
			$table_data = $this->Xmlload_model->add_content ( $this->chapter_id, $this->vol_id, $table_label, $table_id, $this->user_id, $table_para, $type, $panel_type );
			return false;
		}
	}
	
	// Function to add a figure
	public function add_figure($figureData) {
		$figure_id = $figureData->getAttribute ( 'id' );
		if (trim ( $figure_id ) == "")
			return;
		$figure_para = "";
		$figure_label = "";
		if ($figureData->getElementsByTagName ( 'p' )->length > 0) {
			$figure_para = $figureData->getElementsByTagName ( 'p' )->item ( 0 )->nodeValue;
			$figure_label = $figureData->getElementsByTagName ( 'label' )->item ( 0 )->nodeValue;
		}
		$type = "Figure";
		$pages = "PAGES";
		$commentry = "COMMENTARY";
		$str_fig = str_replace ( "fc", "", $figure_id );
		if ($figure_id == "fc" . $str_fig) {
			$panel_type = $commentry;
		} else {
			$panel_type = $pages;
		}
		$figure_data = $this->Xmlload_model->add_content ( $this->chapter_id, $this->vol_id, $figure_label, $figure_id, $this->user_id, $figure_para, $type, $panel_type );
		return false;
	}
	
	// Function to add a chapter content
	public function add_chcontent($chapchData) {
		$chap_label = $chapchData->getElementsByTagName ( 'label' )->item ( 0 )->nodeValue;
		$chap_title = $chapchData->getElementsByTagName ( 'title' )->item ( 0 )->nodeValue;
		$explode = explode ( " ", $chap_label );
		$linkpage = $explode [1];
		$chpid = $explode [1];
		$type = "Chapter";
		$pages = "PAGES";
		$commentry = "COMMENTARY";
		if ($chpid == "C" . $chpid) {
			$panel_type = $commentry;
		} else {
			$panel_type = $pages;
		}
		
		$chcontent_data = $this->Xmlload_model->add_chcontent ( $this->chapter_id, $chap_title, $this->vol_id, $chap_label, $chpid, $this->user_id, $type, $panel_type );
		return false;
	}
	
	// Function to add a section content
	public function add_seccontent($secchData) {
		$secch_id = $secchData->getAttribute ( 'id' );
		if (trim ( $secch_id ) == "")
			return;
		
		$secch_title = $secchData->getElementsByTagName ( 'title' )->item ( 0 )->nodeValue;
		$secch_label = $secchData->getElementsByTagName ( 'label' )->item ( 0 )->nodeValue;
		if (trim ( $secch_label ) == "")
			return;
		$secch_para = $secchData->getElementsByTagName ( 'p' )->item ( 0 )->nodeValue;
		$type = "Section";
		$str_commentry = str_replace ( "C", "", $secch_label );
		$pages = "PAGES";
		$commentary = "COMMENTARY";
		if ($secch_label == "C" . $str_commentry) {
			$panelch_type = $commentary;
		} else {
			$panelch_type = $pages;
		}
		
		$seccontent = $this->Xmlload_model->add_seccontent ( $this->chapter_id, $secch_title, $this->vol_id, $secch_label, $secch_id, $this->user_id, $secch_para, $type, $panelch_type );
		return false;
	}
	public function dir_to_array($dir, $separator = DIRECTORY_SEPARATOR, $paths = 'relative') {
		$result = array ();
		$cdir = scandir ( $dir );
		foreach ( $cdir as $key => $value ) {
			if (! in_array ( $value, array (
					".",
					".." 
			) )) {
				if (is_dir ( $dir . $separator . $value )) {
					$result [$value] = $this->dir_to_array ( $dir . $separator . $value, $separator, $paths );
				} else {
					if ($paths == 'relative') {
						$result [] = $dir . '/' . $value;
					} elseif ($paths == 'absolute') {
						$result [] = base_url () . $dir . '/' . $value;
					}
				}
			}
		}
		return $result;
	}
	/* ----------------This Function will create the thumbnail image(For Thumbnail Creation)-------------------------- */
	function makeThumbnail($sourcefile, $endfile, $thumbwidth, $thumbheight, $quality) {
		ini_set ( "memory_limit", "-1" );
		// Takes the sourcefile (path/to/image.jpg) and makes a thumbnail from it
		// and places it at endfile (path/to/thumb.jpg).
		// Load image and get image size.
		if (file_exists ( $sourcefile )) {
			
			$img = imagecreatefromjpeg ( $sourcefile );
			$width = imagesx ( $img );
			$height = imagesy ( $img );
			
			if ($width > $height) {
				
				$newwidth = $thumbwidth;
				$divisor = $width / $thumbwidth;
				$newheight = floor ( $height / $divisor );
			} else {
				
				$newheight = $thumbheight;
				$divisor = $height / $thumbheight;
				$newwidth = floor ( $width / $divisor );
			}
			
			// Create a new temporary image.
			$tmpimg = imagecreatetruecolor ( $newwidth, $newheight );
			
			// Copy and resize old image into new image.
			imagecopyresampled ( $tmpimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
			
			// Save thumbnail into a file.
			imagejpeg ( $tmpimg, $endfile, $quality );
			
			// release the memory
			imagedestroy ( $tmpimg );
			imagedestroy ( $img );
		} else {
			echo "The file " . $sourcefile . " does not exist";
		}
	}
	/* ------------------------------------Code End's Here------------------------------------- */
	/* --------------------------------------Getting String Between two Saprator--------------- */
	function get_string_between($string, $start, $end) {
		$string = ' ' . $string;
		$ini = strpos ( $string, $start );
		if ($ini == 0)
			return '';
		$ini += strlen ( $start );
		$len = strpos ( $string, $end, $ini ) - $ini;
		return substr ( $string, $ini, $len );
	}
	/* ------------------------------------------------End------------------------------------- */
	/* --------------------------------------Getting Last Occurence In String--------------- */
	function get_last_occurence($string) {
		$filename = substr ( strrchr ( $string, "." ), 1 );
		return $filename;
	}
	/* ------------------------------------------------End------------------------------------- */
	/* --------------------------------------Function For Getting Customised Data--------------- */
	public function GetCustomisedData() {
		$searchType = $this->input->post ( 'searchType' );
		$chapterNo = $this->input->post ( 'currentChap' );
		$commentaryNo = $this->input->post ( 'currComm' );
		$chapControl=$this->input->post ( 'chapControl' );;
		$versionControl=$this->input->post ( 'versionControl' );
                //echo "<pre>11111".$searchType."--#".$chapterNo."--*".$commentaryNo."--".$chapControl."--".$versionControl;die;
		if($versionControl=='diff_edition'){
                    $data ['historyContents'] = $this->Book_m->getAllHistoryContentsDiffEdition ( $this->book_id, $searchType, $chapterNo, $commentaryNo,$chapControl, $versionControl);
                    $str = '';
                    //echo "<pre>";print_r($data);die;
                    /*foreach ( $data ['historyContents'] as $value ) {
                            $Chap = $value->chapter_no;
                            $ChapName = preg_replace ( "/[^a-zA-Z]+/", "", $Chap );
                            $ChapNum = preg_replace ( "/[^0-9]+/", "", $Chap );
                            if ($ChapName == 'ch') {
                                    $chapNameValue = 'Chapter ' . $ChapNum;
                            }
                            if ($ChapName == 'chc') {
                                    $chapNameValue = 'Commentary ' . $ChapNum;
                            }
                            if ($ChapName == 'ap') {
                                    $chapNameValue = 'Appendix ' . $ChapNum;
                            }
                            if ($ChapName == 'apc') {
                                    $chapNameValue = 'Appendix Commentary ' . $ChapNum;
                            }
                            // alert(chapNameValue);
                            $str .= '<div class="row"><div class="pull-right date"></div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">' . $chapNameValue . '</div><div class="h_result_updated_diff" style="cursor: pointer; cursor: hand;" version="' . $value->version_id . '" chapter_no="' . $value->chapter_no . '" section_no="' . $value->section_no . '">' . $value->data . '</div></div>';
                    }*/
                    //echo "<pre>123456";print_r($data ['historyContents']);die;
                    foreach ( $data ['historyContents'] as $value ) {

                            $Chap = $value->chapter_no;
                            $ChapName = preg_replace ( "/[^a-zA-Z]+/", "", $Chap );
                            $ChapNum = preg_replace ( "/[^0-9]+/", "", $Chap );
                            $FileName = $value->filenamed ;
                            $datastory = $FileName;
                            $str .= '<div class="row"><div class="pull-right date"></div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">' . $chapNameValue . '</div><div class="h_result_updated_diff" style="cursor: pointer; cursor: hand;" version="' . $value->version_id . '" chapter_no="' . $value->chapter_no . '" section_no="' . $value->section_no . '">' . $value->data . '</div></div>';
                    }
                    if($chapControl=='all_chapter'){
                        $allContentValue = array();
                        $varsionid = $data ['historyContents'][0]->version_id;
                        $currentDirectoryPath =  getcwd(); 
                        $currentDirectoryPath = str_replace("asce_service","asce_content", $currentDirectoryPath);

                        $loadpathdirectory = $currentDirectoryPath."/history/".$varsionid;
                        $currentDirectoryPath = str_replace('\\', '/', $currentDirectoryPath);
                        //$directoryname=$this->input->post ( 'direcotryname' );
                        //echo "<pre>1234";print_r($loadpathdirectory);echo "<hr>";
                        $allhtmls = scandir($loadpathdirectory);
                        //echo "<pre>";print_r($allhtmls);die;
                        $icount=0;
                        foreach($allhtmls as $htmlsinglefile){
                        	$icount++;
                        if(($htmlsinglefile==".") || ($htmlsinglefile=="..")) {
                        continue;
                        }
                        if(((strlen($htmlsinglefile))!=9) || (substr($htmlsinglefile,0,2)!="ch"))
                        	continue;
                        //if($icount==2)
                        	//break;
                        $filenameforbook = $loadpathdirectory."/".$htmlsinglefile;
                        //echo "<pre>";print_r($filenameforbook);die;
                        $htmlcotentvalue = file_get_contents($filenameforbook);
                        $allContentValue[$htmlsinglefile] = $htmlcotentvalue;
                        //$varcontent = $allContentValue."<hr>";
                        }
                        //echo "<pre>M33333";print_r($allContentValue);die;
                        echo json_encode($allContentValue);die;
                        
                    }
		}
		else{
		$data ['historyContents'] = $this->Book_m->getAllHistoryContentsDynamic ( $this->book_id, $searchType, $chapterNo, $commentaryNo,$chapControl, $versionControl );
		$str = '';
		foreach ( $data ['historyContents'] as $value ) {
			$Chap = $value->chapter_no;
			$ChapName = preg_replace ( "/[^a-zA-Z]+/", "", $Chap );
			$ChapNum = preg_replace ( "/[^0-9]+/", "", $Chap );
			exit;
			if ($ChapName == 'ch') {
				$chapNameValue = 'Chapter ' . $ChapNum;
			}
			if ($ChapName == 'chc') {
				$chapNameValue = 'Commentary ' . $ChapNum;
			}
		//	if ($ChapName == 'ap') {
			if ($ChapName == "ap" || $ChapName == "apA" || $ChapName == "apB" || $ChapName == "apC" || $ChapName == "apD"|| $ChapName == "apE" || $ChapName == "apF"|| $ChapName == "apG" ){
			    
				$chapNameValue = 'Appendix ' . $ChapNum;
			}
		//	if ($ChapName == 'apc') {
			if ($ChapName == "apc" || $ChapName == "apcA" || $ChapName == "apcB" || $ChapName == "apcC" || $ChapName == "apcD"|| $ChapName == "apcE" || $ChapName == "apcF"|| $ChapName == "apcG" ){
			    
				$chapNameValue = 'Appendix Commentary ' . $ChapNum;
			}
			// alert(chapNameValue);
			$str .= '<div class="row"><div class="pull-right date">' . $value->final_version . '</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">' . $chapNameValue . '</div><div class="h_result_updated" style="cursor: pointer; cursor: hand;" version="' . $value->version . '" chapter_no="' . $value->chapter_no . '" section_no="' . $value->section_no . '">' . $value->data . '</div></div>';
		}
		}
		echo $str;
	}
	/* --------------------------------------Function For Getting Customised Data--------------- */
	public function GetAllData() {
        $typeofHistory = $this->input->post ( 'type' );
                
		$data ['historyContents'] = $this->Book_m->getAllHistoryContents ( $this->book_id,$typeofHistory );
		$str = '';
		foreach ( $data ['historyContents'] as $value ) {
			$Chap = $value->chapter_no;
			$ChapName = preg_replace ( "/[^a-zA-Z]+/", "", $Chap );
			$ChapNum = preg_replace ( "/[^0-9]+/", "", $Chap );
			if ($ChapName == 'ch') {
				$chapNameValue = 'Chapter ' . $ChapNum;
			}
			if ($ChapName == 'chc') {
				$chapNameValue = 'Commentary ' . $ChapNum;
			}
			if ($ChapName == "ap" || $ChapName == "apA" || $ChapName == "apB" || $ChapName == "apC" || $ChapName == "apD"|| $ChapName == "apE" || $ChapName == "apF"|| $ChapName == "apG" ){
			        
			    $chapNameValue = 'Appendix ' . $ChapNum;
			}
			if ($ChapName == "apc" || $ChapName == "apcA" || $ChapName == "apcB" || $ChapName == "apcC" || $ChapName == "apcD"|| $ChapName == "apcE" || $ChapName == "apcF"|| $ChapName == "apcG" ){
			        
			    $chapNameValue = 'Appendix Commentary ' . $ChapNum;
			}

			if ($ChapName == 'ch') {
				$sectionNumber = preg_replace ( "/[^0.-9]+/", "", $value->section_no );
			}
			
			// $stringReplace = '<div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">'.$sectionNumber;
			// $result = str_replace('<div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">',$stringReplace,$value->data);
			// // alert(chapNameValue);
			 $str .= '<div class="row"><div class="pull-right date">' . $value->final_version . '</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%">' . $chapNameValue . '</div><div class="h_result_updated" style="cursor: pointer; cursor: hand;" version="' . $value->version . '" chapter_no="' . $value->chapter_no . '" section_no="' . $value->section_no . '">' .$value->data . '</div></div>';

			//$str .= $value->data;
		}
		echo $str;
	}
	/* ------------------------------------------------------End--------------------------------- */
	/* --------------------------For Getting Data Between Two Dates-------------------------------- */
	public function GetDataBetweenDate() {
		$startDate = $this->input->post ( 'startDate' );
		$endDate = $this->input->post ( 'endDate' );
		$commentaryNo = $this->input->post ( 'currComm' );
		$data ['historyContents'] = $this->Book_m->getAllDataBetweenDate ( $this->book_id, $startDate, $endDate );
		$str = '';
		foreach ( $data ['historyContents'] as $value ) {
			$Chap = $value->chapter_no;
			$ChapName = preg_replace ( "/[^a-zA-Z]+/", "", $Chap );
			$ChapNum = preg_replace ( "/[^0-9]+/", "", $Chap );
			if ($ChapName == 'ch') {
				$chapNameValue = 'Chapter ' . $ChapNum;
			}
			if ($ChapName == 'chc') {
				$chapNameValue = 'Commentary ' . $ChapNum;
			}
			if ($ChapName == "ap" || $ChapName == "apA" || $ChapName == "apB" || $ChapName == "apC" || $ChapName == "apD"|| $ChapName == "apE" || $ChapName == "apF"|| $ChapName == "apG" ){
			    $chapNameValue = 'Appendix ' . $ChapNum;
			}
			if ($ChapName == "apc" || $ChapName == "apcA" || $ChapName == "apcB" || $ChapName == "apcC" || $ChapName == "apcD"|| $ChapName == "apcE" || $ChapName == "apcF"|| $ChapName == "apcG" ){
			    $chapNameValue = 'Appendix Commentary ' . $ChapNum;
			}
			// alert(chapNameValue);
			$str .= '<div class="row"><div class="pull-right date">' . $value->final_version . '</div><div class="pull-left date" style="padding-left: 0;padding-right: 0; width:100%;">' . $chapNameValue . '</div><div class="h_result_updated" style="cursor: pointer; cursor: hand;" version="' . $value->version . '" chapter_no="' . $value->chapter_no . '" section_no="' . $value->section_no . '">' . $value->data . '</div></div>';
		}
		echo $str;
	}
	public function deletebooks() {
		$bookid = $_POST ['id'];
		// echo $bookid; die;
                $this->delete_book($bookid);
		//$varid = $this->Book_m->deletebook ( $bookid );
		//$response = 0;
		//if ($varid == 1) {
			$response = 1;
			// echo "This book is use in product so can not delete:";
		//}
		
		echo $response;
	}
	/* ---------------------------------------End-------------------------------------------------- */
	/* --------------------------------------- Function for getting last updated history data----------- */
	function GetLastHistoryChapter() {
		$currLoadedChapter=$this->input->post ( 'loadedChapter' );
		$data ['historyDetails'] = $this->Book_m->getLastUpdated ( $this->book_id,$currLoadedChapter );
		echo $data ['historyDetails'];
	}
    
    public function SaveVersionIntoDb() {
    	$chapter_no = $this->input->post ( 'chapter_no' );
		$section_no = $this->input->post ( 'section_no' );
		$data = $this->input->post ( 'data' );
		$history_type=$this->input->post ( 'history_type' );

		//return $this->Book_m->save_ContentData($data,$chapter_no,$section_no,$history_type);
	}
        
	/* ------------------------------------------------------End---------------------------------------- */
}
