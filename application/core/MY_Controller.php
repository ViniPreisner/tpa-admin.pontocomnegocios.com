<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	* An array of variables to be passed through to the
	* view, layout and any asides
	*/
	protected $data = array();
	
   function __construct() {
	   
	   parent::__construct();

	   $this->output->set_header("Access-Control-Allow-Origin: *");

	   $this->session->set_userdata("firstAccess",false);
	   	   
   }
   
   	public function getmodel($model){
		$this->load->model($model);
		$m = $this->model;
		return $m;
	}
	  
	
	function paginationLinks($total_records,$limit_per_page,$url)
	{
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        //$config["uri_segment"] = 2;

        // custom paging configuration
        $config['num_links'] = $total_records;
        $config['use_page_numbers'] = TRUE;
        //$config['reuse_query_string'] = FALSE;
        $config['page_query_string'] = FALSE;
        //$config['attributes'] = array(':click' => 'loadPage()','ref' => 'pageLink');
            
        $config['full_tag_open'] = '<div class="btn-group m-b-10" style="padding-top: 20px;">';
        $config['full_tag_close'] = '</div>';
         
        $config['first_link'] = false;
        //$config['first_tag_open'] = '<span class="firstlink">';
        //$config['first_tag_close'] = '</span>';
         
        $config['last_link'] = false;
        //$config['last_tag_open'] = '<span class="lastlink">';
        //$config['last_tag_close'] = '</span>';
         
        $config['next_link'] = false;
        //$config['next_tag_open'] = '<span class="nextlink">';
        //$config['next_tag_close'] = '</span>';

        $config['prev_link'] = false;
        //$config['prev_tag_open'] = '<span class="prevlink">';
        //$config['prev_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<button type="button" class="btn btn-primary">';
        $config['cur_tag_close'] = '</button>';

        $config['num_tag_open'] = '<button type="button" class="btn btn-pagination btn-default">';
        $config['num_tag_close'] = '</button>';
         
        $this->pagination->initialize($config);
         
        // build paging links
        return $this->pagination->create_links();
	}

}
?>