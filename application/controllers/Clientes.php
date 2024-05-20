<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends MY_Controller {

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

        $this->load->model('clientes_model', 'cm');

		$this->data['userdata'] = $this->session->userdata();
	}

	/**
	 * Index Page for this controller.
	 * Listagem
	 */
	public function index($page = false)
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'clientes';

        $this->load->library('pagination');

		$terms = $this->input->get('term', TRUE);

        // DADOS        
		$returnTotalItems = $this->cm->selectAllItemsCount($terms);
		$totalItems = $returnTotalItems->total;

        $limit_per_page = 50;
        $start_index = ($page) ?: 0;
        $total_records = $totalItems;

        if ($total_records > 0) {
            $this->data['items'] = $this->cm->getAll($limit_per_page,$start_index,$total_records,$terms);
            $this->data['pagination'] = $this->paginationLinks($total_records,$limit_per_page,'clientes');    
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

		$this->data['content'] = $this->load->view('content/clientes-lista', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/clientes', NULL, TRUE));
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
		$this->data['body_id'] = 'clientes';

		// status
		$this->load->model('status_model', 'sm');
		$this->data['status'] = $this->sm->getAll(false);

		// categorias
        $this->load->model('categorias_model', 'ctm');
		$this->data['categorias'] = $this->ctm->getAll(false);

		// produtos
        $this->load->model('produtos_model', 'pm');
		$this->data['produtos'] = $this->pm->getAll(false);

		$this->data['logo'] = false;

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/clientes-form', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/clientes', NULL, TRUE));
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
		$this->data['body_id'] = 'clientes';

        // DADOS        
        $returnItem = $this->cm->getById($id);
        
        if (!$returnItem)
            redirect(base_url());

        $this->data['item'] = $returnItem;

		// status
		$this->load->model('status_model', 'sm');
		$this->data['status'] = $this->sm->getAll(false);

		// categorias
        $this->load->model('categorias_model', 'ctm');
		$this->data['categorias'] = $this->ctm->getAll(false);

		// produtos
        $this->load->model('produtos_model', 'pm');
		$this->data['produtos'] = $this->pm->getAll(false);

		// logo
		if (file_exists("./upload/logo/$returnItem->id.jpg")) {
			$this->data['logo'] = "/upload/logo/$returnItem->id.jpg";
		} else {
			$this->data['logo'] = false;
		}


		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/clientes-form', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/clientes', NULL, TRUE));
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
			'is_published' => $this->input->post('is_published'),
			'id_status' => $this->input->post('id_status'),
			'type' => $this->input->post('type'),
			'product' => $this->input->post('product'),
			'cdrom' => $this->input->post('cdrom'),
			'featured' => $this->input->post('featured'),
			'id_category' => $this->input->post('id_categoria'),
			'trade_name' => $this->input->post('trade_name'),
			'document' => $this->input->post('document'),
			'name' => $this->input->post('name'),
			'zipcode' => $this->input->post('zipcode'),
			'address' => $this->input->post('address'),
			'address_number' => $this->input->post('address_number'),
			'address_complement' => $this->input->post('address_complement'),
			'neighborhood' => $this->input->post('neighborhood'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'phone_number_1' => $this->input->post('phone_number_1'),
			'phone_number_2' => $this->input->post('phone_number_2'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),
			'billing_address_type' => $this->input->post('billing_address_type'),
			'billing_zipcode' => $this->input->post('billing_zipcode'),
			'billing_address' => $this->input->post('billing_address'),
			'billing_address_number' => $this->input->post('billing_address_number'),
			'billing_address_complement' => $this->input->post('billing_address_complement'),
			'billing_neighborhood' => $this->input->post('billing_neighborhood'),
			'billing_city' => $this->input->post('billing_city'),
			'billing_state' => $this->input->post('billing_state'),
			'authorizer_name' => $this->input->post('authorizer_name'),
			'authorizer_phone_number' => $this->input->post('authorizer_phone_number'),
			'authorizer_role' => $this->input->post('authorizer_role'),
			'authorizer_cpf' => $this->input->post('authorizer_cpf'),
			'authorizer_rg' => $this->input->post('authorizer_rg'),
			'comments' => $this->input->post('comments')
        ];

        // update
        if ($this->input->post('id')) {
			$id = $this->input->post('id');
			$return = $this->cm->update($data,$id);
            $this->data['message'] = 'Cadastro alterado com sucesso.';    
        }
        // insert
        else {
			// check CNPJ
			if ($data['document'] !== '00.000.000/0000-00') {
				$checkIfExists = $this->cm->getByCNPJ($data['document']);
				if ($checkIfExists) {
					$this->data['alert'] = 'danger';
					$this->data['message'] = 'Esse CNPJ já existe na base de dados.';
					return $this->incluir();
				}
			}
			$return = $this->cm->insert($data);
			$id = $return;
            $this->data['message'] = 'Cadastro realizado com sucesso.';    
		}
		
		// upload
		if (isset($_FILES['logo']) && $_FILES['logo']) {
			$logo = $_FILES['logo'];
			$config = array(
				'upload_path'   => './upload/logo/',
				'allowed_types' => 'jpg|jpeg|png',
				'file_name'     => $id.'.jpg',
				'max_size'      => '5000'
     		);      
			$this->load->library('upload');
			$this->upload->initialize($config);
			if ($this->upload->do_upload('logo')) {

			}
		}

            
        if ($return) {
            $this->data['alert'] = 'success';
        } else {
            $this->data['alert'] = 'danger';
            $this->data['message'] = 'Não foi possível realizar esta ação.';    
        }
    
		//$this->index();
		if ($this->input->post('id')) {
			redirect('clientes');
		} else {
			redirect('contratos/incluir/'.$id);
		}
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

	/**
	 * 
	 * Remove o arquivo de logo
	 */
	public function deleteLogo()
	{
        if(!isset($_POST)) {
            redirect(base_url());
		}

		$this->load->helper("file");

		$id = $this->input->post('id');
		$file = "./upload/logo/$id.jpg";
		
		// logo
		if (file_exists($file)) {
			unlink($file);
            $data = [
                'success'               => true,
                'title'                 => "Sucesso!",
                'message'               => "O arquivo foi excluído."
            ];    
		} else {
            $data = [
                'success'               => false,
                'title'                 => "Ops!",
                'message'               => "Não foi possível excluir o arquivo."
            ];    
		}

        $this->output->set_content_type('application/json') -> set_output(json_encode($data));
        return $this->output;
    }

}