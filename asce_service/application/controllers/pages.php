<?php

//defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . '/libraries/REST_Controller.php';

class Pages extends MY_Controller {
	
	function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
		$this->load->database();
        $this->load->model('page_model');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        $this->load->helper('html');
		$this->load->library('excel_reader');
	}
	
	
	 function search($search_terms = '', $start = 0)
    {
      if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
	{
	 //redirect ('/auth/login');
	 $this->response(array('error' => 'Sorry User not logged in'));
	}
		else if ($this->input->post('q'))
		{
			redirect('/pages/search/' . $this->input->post('q'));
		}
		
		else if ($search_terms)
		{
			
			
			// Determine the number of results to display per page
			$results_per_page = $this->config->item('results_per_page');
			
			// Mark the start of search
			$this->benchmark->mark('search_start');
			
			// Load the model, perform the search and establish the total
			// number of results
			$this->load->model('page_model');
			$results = $this->page_model->search($search_terms, $start, $results_per_page);
			$total_results = $this->page_model->count_search_results($search_terms);
			
			// Mark the end of search
			$this->benchmark->mark('search_end');
			
			// Call a method to setup pagination
			$this->_setup_pagination('/pages/search/' . $search_terms . '/', $total_results, $results_per_page);
			
			// Work out which results are being displayed
			$first_result = $start + 1;
			$last_result = min($start + $results_per_page, $total_results);
		}
		
		// Render the view, passing it the necessary data
		$this->load->view('search_results', array(
			'search_terms' => $search_terms,
			'first_result' => @$first_result,
			'last_result' => @$last_result,
			'total_results' => @$total_results,
			'results' => @$results
		));
		
		// Enable the profiler
		$this->output->enable_profiler(TRUE);
        
    }

	/*function search($search_terms = '', $start = 0)
	{
		// If the form has been submitted, rewrite the URL so that the search
		// terms can be passed as a parameter to the action. Note that there
		// are some issues with certain characters here.
		if ($this->input->post('q'))
		{
			redirect('/pages/search/' . $this->input->post('q'));
		}
		
		if ($search_terms)
		{
			
			
			// Determine the number of results to display per page
			$results_per_page = $this->config->item('results_per_page');
			
			// Mark the start of search
			$this->benchmark->mark('search_start');
			
			// Load the model, perform the search and establish the total
			// number of results
			$this->load->model('page_model');
			$results = $this->page_model->search($search_terms, $start, $results_per_page);
			$total_results = $this->page_model->count_search_results($search_terms);
			
			// Mark the end of search
			$this->benchmark->mark('search_end');
			
			// Call a method to setup pagination
			$this->_setup_pagination('/pages/search/' . $search_terms . '/', $total_results, $results_per_page);
			
			// Work out which results are being displayed
			$first_result = $start + 1;
			$last_result = min($start + $results_per_page, $total_results);
		}
		
		// Render the view, passing it the necessary data
		$this->load->view('search_results', array(
			'search_terms' => $search_terms,
			'first_result' => @$first_result,
			'last_result' => @$last_result,
			'total_results' => @$total_results,
			'results' => @$results
		));
		
		// Enable the profiler
		$this->output->enable_profiler(TRUE);
	}*/
	
	/**
	 * Setup the pagination library.
	 *
	 * @param string $url The base url to use.
	 * @param string $total_results The total number of results.
	 * @param string $results_per_page The number of results per page.
	 * @return void
	 * @author Joe Freeman
	 */
	function _setup_pagination($url, $total_results, $results_per_page)
	{
		// Ensure the pagination library is loaded
		$this->load->library('pagination');
		
		// This is messy. I'm not sure why the pagination class can't work
		// this out itself...
		$uri_segment = count(explode('/', $url));
		
		// Initialise the pagination class, passing in some minimum parameters
		$this->pagination->initialize(array(
			'base_url' => site_url($url),
			'uri_segment' => 4,
			'total_rows' => $total_results,
			'per_page' => $results_per_page
		));
	}
}

/* End of file pages.php */
/* Location: ./system/application/controllers/pages.php */