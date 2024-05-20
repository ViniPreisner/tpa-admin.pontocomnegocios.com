<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Controller {

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

        $this->load->model('categorias_model', 'cm');

		$this->data['userdata'] = $this->session->userdata();
	}

	/**
	 * Index Page for this controller.
	 * Listagem
	 */
	public function index($page = false)
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'categorias';

        $this->load->library('pagination');

        // DADOS        
		$returnTotalItems = $this->cm->selectAllItemsCount();
		$totalItems = $returnTotalItems->total;

        $limit_per_page = 50;
        $start_index = ($page) ?: 0;
        $total_records = $totalItems;

        if ($total_records > 0) {
            $this->data['items'] = $this->cm->getAll($limit_per_page,$start_index,$total_records);
            $this->data['pagination'] = $this->paginationLinks($total_records,$limit_per_page,'categorias');    
        } else {
            $this->data['items'] = false;
            $this->data['pagination'] = '';    
        }

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/categorias-lista', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/categorias', NULL, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }

	/**
	 * Index Page for this controller.
	 * Incluir
	 */
	public function incluir()
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'categorias';

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/categorias-form', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/home', NULL, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }

	/**
	 * 
	 * Incluir
	 */
	public function editar($id = null)
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'categorias';

        // DADOS        
        $returnItem = $this->cm->getById($id);
        
        if (!$returnItem)
            redirect(base_url());

        $this->data['item'] = $returnItem;


		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/categorias-form', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/home', NULL, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }

	/**
	 * 
	 * Insere ou atualiza novo registro
	 */
	public function post()
	{
        if(!isset($_POST))
            redirect(base_url());

        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status')
        ];

        // update
        if ($this->input->post('id')) {
            $return = $this->cm->update($data,$this->input->post('id'));
            $this->data['message'] = 'Cadastro alterado com sucesso.';    
        }
        // insert
        else {
            $return = $this->cm->insert($data);
            $this->data['message'] = 'Cadastro realizado com sucesso.';    
        }
            
        if ($return) {
            $this->data['alert'] = 'success';
        } else {
            $this->data['alert'] = 'danger';
            $this->data['message'] = 'Não foi possível realizar esta ação.';    
        }
    
        $this->index();
    }


	/**
	 * 
	 * Remove o registro
	 */
	public function delete()
	{
        if(!isset($_POST)) {
            redirect(base_url());
        }

        if ($this->cm->delete($this->input->post('id'))) {
            $data = [
                'success'               => true,
                'title'                 => "Sucesso!",
                'message'               => "O registro foi excluído."
            ];    
        } else {
            $data = [
                'success'               => false,
                'title'                 => "Ops!",
                'message'               => "Não foi possível realizar esta ação."
            ];    
        }

        $this->output->set_content_type('application/json') -> set_output(json_encode($data));
        return $this->output;
    }

}