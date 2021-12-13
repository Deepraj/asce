<?php

class Page_model extends CI_Model
{
	
	private $pages			= 'm_pages';			// user accounts
	
	function __construct()
    {
        parent::__construct();
    }
	 
	function Page_model()
	{
		parent::Model();
 
		// Make the database available to all the methods
		$this->load->database();
	}
	
	/**
	 * Perform a FULLTEXT search on the page content for the specified search
	 * terms.
	 * 
	 * This method supports pagination. To enable pagination,
	 * $results_per_page must be set.
	 *
	 * @param string $terms The search terms.
	 * @param integer $start The record to start at (default is 0). Only applicable if $results_per_page is also set.
	 * @param integer $results_per_page The maximum number of results to return at once.
	 * @return array The search results.
	 * @author Joe Freeman
	 */
	function search($terms, $start = 0, $results_per_page = 0)
	{
		// Determine whether we need to limit the results
		if ($results_per_page > 0)
		{
			$limit = "LIMIT $start, $results_per_page";
		}
		else
		{
			$limit = '';
		}
		
		// Execute our SQL statement and return the result
		$sql = "SELECT m_page_url, m_pagetitle, m_pagecontent
				FROM m_pages
				WHERE MATCH (m_pagecontent) AGAINST (?) > 0
				$limit";
				
		$query = $this->db->query($sql, array($terms, $terms));
		echo $this->db->last_query();
		exit;
		return $query->result();
	}
	
	/**
	 * Determine the total number of results that will be returned by a seach
	 * on the specified search terms.
	 *
	 * @param string $terms The search terms.
	 * @return integer Total number of search results.
	 * @author Joe Freeman
	 */
	function count_search_results($terms)
	{
		// Run SQL to count the total number of search results
		$sql = "SELECT COUNT(*) AS count
				FROM m_pages
				WHERE MATCH (m_pagecontent) AGAINST (?)";
		$query = $this->db->query($sql, array($terms));
		
		return $query->row()->count;
	}
}

/* End of file page_model.php */
/* Location: ./system/application/models/page_model.php */