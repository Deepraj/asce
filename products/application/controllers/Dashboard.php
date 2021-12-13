<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Dashboard extends CI_Controller {
	
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
		$this->load->helper (array (
				'form',
				'url',
				'xml',
				'security',
				'directory' 
		));
		$this->load->database ();
		$this->load->model ( 'ProductDescriptionModel' );
		$this->load->library ( 'session' );
		$this->load->library ( 'Encryption' );
	}
	public function index() {
		$GUID = $this->session->userdata( 'GUID' );
		$master_id = $this->session->userdata ('MasterCustomerId');
		//print_r($master_id ); die;
		//print_r($_SESSION); die;
		$id = $this->input->get ( 'id', TRUE );
		$value = $this->input->post ('getValue');
		$values = $this->input->post ('product_id');
		$data ['subscribedProductList'] = $this->ProductDescriptionModel->get_Subscribed_Product ( $master_id );
		//print_r($data ['subscribedProductList']);
		$prodids = array ();
		foreach ($data ['subscribedProductList'] as $subsProd ) {
			array_push ( $prodids, $subsProd->product_id );
		}
		$data ['bookDetail'] = $this->ProductDescriptionModel->getDetailBooks ( $value );
		$data ['productList'] = $this->ProductDescriptionModel->getAllProducts ( $id, $prodids );
		// $data ['subsProductList'] = $this->ProductDescriptionModel->getAllSubsBooks ( $id,$prodids );
		// $data ['productList'] = $this->ProductDescriptionModel->getAllBooks ( $id );
		$data ['bookInfo'] = $this->ProductDescriptionModel->getBookInfo ( $id );
		$str = array ();
		foreach ( $data ['productList'] as $productList ) {
			array_push ( $str, $productList->product_id );
		}
		$str = implode ( ',', $str );
		$str = rtrim ( $str, "," );
		$subsBook = '';
		// $data ['SubsBooks']=$this->ProductDescriptionModel->getbook ( $subsBook );
		$data ['SubsBooks'] = $this->ProductDescriptionModel->getSubsBook ( $prodids );
		$data ['IpBased'] = $this->ProductDescriptionModel->getbook ( $str );
		$this->load->view ( 'pagetemplate/header', $data );
		$this->load->view ( 'ProductDescription', $data );
	}
	public function show_dashboard() {
		$this->load->view ( 'pagetemplate/header');
		$this->load->view('Dashboard'); 
}
}