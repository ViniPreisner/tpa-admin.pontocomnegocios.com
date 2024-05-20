<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Negativados extends MY_Controller {

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

        $this->load->model('negativados_model', 'nm');

        $this->data['userdata'] = $this->session->userdata();
        
        /**
         * id
         * name
         * document
         * creditor
         * amount
         * negative
         * created_at
         * deleted_at
         */
	}

	/**
	 * Index Page for this controller.
	 * Listagem
	 */
	public function index($page = false)
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'negativados';

        $this->load->library('pagination');

		$terms = $this->input->get('term', TRUE);

        // DADOS        
		$returnTotalItems = $this->nm->selectAllItemsCount($terms);
		$totalItems = $returnTotalItems->total;

        $limit_per_page = 50;
        $start_index = ($page) ?: 0;
        $total_records = $totalItems;

        if ($total_records > 0) {
            $this->data['items'] = $this->nm->getAll($limit_per_page,$start_index,$total_records,$terms);
            $this->data['pagination'] = $this->paginationLinks($total_records,$limit_per_page,'negativados');    
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

		$this->data['content'] = $this->load->view('content/negativados-lista', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/negativados', NULL, TRUE));
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
		$this->data['body_id'] = 'negativados';
				
		// extra css
		$this->data['extra_css'] = array($this->load->view('css/negativados', NULL, TRUE));	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/negativados-form', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/negativados', NULL, TRUE));
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
		$this->data['body_id'] = 'negativados';

        // DADOS        
        $returnItem = $this->nm->getById($id);
        
        if (!$returnItem)
            redirect(base_url());

        $this->data['item'] = $returnItem;
				
		// extra css
		$this->data['extra_css'] = array($this->load->view('css/negativados', NULL, TRUE));	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/negativados-form', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/negativados', NULL, TRUE));
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

        $document = $this->input->post('document');
        $document = str_replace('.','',$document);
        $document = str_replace('/','',$document);
        $document = str_replace('-','',$document);
    
        $amount = $this->input->post('amount');
        $amount = str_replace('R$ ','',$amount);
        $amount = str_replace('.','',$amount);
		$amount = str_replace(',','.',$amount);
		
		$notedate = dataPTtoMySQL($this->input->post('notedate'));

			
        $data = [
			'document' => $document,
			'debtor' => $this->input->post('debtor'),
			'creditor' => $this->input->post('creditor'),
			'amount' => $amount,
			'negative' => $this->input->post('negative'),
			'note_date' => $notedate,
			'note_time' => $this->input->post('notetime'),
        ];

        // update
        if ($this->input->post('id')) {
			$id = $this->input->post('id');
			$return = $this->nm->update($data,$id);
            $this->data['message'] = 'Cadastro alterado com sucesso.';    
        }
        // insert
        else {
			// check CNPJ
			$checkIfExists = $this->nm->getByCNPJ($data['document']);
			if ($checkIfExists) {
				$this->data['alert'] = 'danger';
				$this->data['message'] = 'Esse CNPJ já existe na base de dados.';
				//return $this->incluir();
			}
			$return = $this->nm->insert($data);
			$id = $return;
            $this->data['message'] = 'Cadastro realizado com sucesso.';    
		}
            
        if ($return) {
            $this->data['alert'] = 'success';
        } else {
            $this->data['alert'] = 'danger';
            $this->data['message'] = 'Não foi possível realizar esta ação.';    
        }
    
		redirect('negativados');

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

        if ($this->nm->delete($this->input->post('id'))) {
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