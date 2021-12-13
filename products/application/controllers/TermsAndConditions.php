<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class TermsAndConditions extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		// Construct the parent class
		parent::__construct ();
		$this->load->helper ( array ('form','url','xml','security','directory' ) );
		$this->load->database ();
		$this->load->library ( 'session' );
		$this->load->library ( 'encrypt' );
		//$this->load->model ( 'LoginModel' );
		$this->load->model ( 'ProductModel' );
		$this->load->library ( 'template' );
	}

	public function index() {
		
			
			$this->template->load ( 'pagetemplate/header', 'ProductList' );
			$this->load->view ( 'terms');
			$this->template->load ( 'pagetemplate/footer', 'ProductList' );
		}
		

	

	
}

?>
