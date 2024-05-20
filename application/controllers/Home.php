<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url'));

		setlocale(LC_MONETARY, 'pt_BR.UTF8');
		date_default_timezone_set('America/Sao_Paulo');
		
		if (!$this->session->userdata("loggedin")) {
			redirect(base_url().'login');
		}

		$this->data['userdata'] = $this->session->userdata();
	}

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'home';
		$this->data['extra_head'] = array();

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/home', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/home', NULL, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
	}

}