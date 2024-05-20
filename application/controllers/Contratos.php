<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contratos extends MY_Controller {

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

        $this->load->model('contratos_model', 'cm');
        $this->load->model('parcelas_model', 'pm');
        $this->load->model('clientes_model', 'clm');
        $this->load->model('status_model', 'sts');
        $this->load->model('categorias_model', 'cat');
        $this->load->model('produtos_model', 'prm');

		$this->data['userdata'] = $this->session->userdata();
	}

	/**
	 * Index Page for this controller.
	 * Listagem
	 */
	public function index($page = false)
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'contratos';

        $this->load->library('pagination');

        // DADOS        
		$returnTotalItems = $this->cm->selectAllItemsCount();
		$totalItems = $returnTotalItems->total;

        $limit_per_page = 50;
        $start_index = ($page) ?: 0;
        $total_records = $totalItems;

        if ($total_records > 0) {
            $this->data['items'] = $this->cm->getAll($limit_per_page,$start_index,$total_records);
            $this->data['pagination'] = $this->paginationLinks($total_records,$limit_per_page,'contratos');    
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

		$this->data['content'] = $this->load->view('content/contratos-lista', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/contratos', NULL, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }


    /*
    * Contratos do cliente
    */
    public function contratosCliente($cliente)
    {
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'contratos';

        $this->data['title'] = '';
        
        // Cliente
        $this->data['cliente'] = $this->clm->getById($cliente);

        // status
		$this->load->model('status_model', 'sm');
		$this->data['status'] = $this->sm->getAll(false);

		// cobradores
        $this->load->model('cobradores_model', 'cbm');
		$this->data['cobradores'] = $this->cbm->getAll(false);

        // Contratos
        $contratos = $this->cm->getAllByClientId($cliente);
        
        if (!$contratos) {
            $this->data['contratos'] = false;
        } else {
            foreach ($contratos as $key => $contrato) {
                $this->data['contratos'][$key] = $contrato;
                // parcelas
                $parcelas = $this->pm->getAllByContractId($contrato->id);
                if (!$contratos) {
                    $this->data['contratos'][$key]->parcelas = false;
                } else {
                    foreach ($parcelas as $keyParcela => $parcela) {
                        $this->data['contratos'][$key]->parcelas[$keyParcela] = $parcela;
                    }
                }
            }
        }
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/contratos-cliente-lista', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/contratos', NULL, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }


    /*
    * Contrato do cliente
    */
    public function contratoCliente($cliente,$contrato)
    {
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'contratos';

        $this->data['title'] = '';
        
        // Cliente
        $this->data['cliente'] = $this->clm->getById($cliente);

        // status
		$this->load->model('status_model', 'sm');
		$this->data['status'] = $this->sm->getAll(false);

		// cobradores
        $this->load->model('cobradores_model', 'cbm');
		$this->data['cobradores'] = $this->cbm->getAll(false);

        // Contrato
        $contrato = $this->cm->getByContractId($cliente,$contrato);
        
        if (!$contrato) {
            $this->data['contrato'] = false;
        } else {
                $this->data['contrato'] = $contrato;
                // parcelas
                $parcelas = $this->pm->getAllByContractId($contrato->id);
                foreach ($parcelas as $keyParcela => $parcela) {
                    $this->data['contrato']->parcelas[$keyParcela] = $parcela;
                }
        }
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/contrato-cliente-form', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/contratos', $this->data, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }

    /**
     * Último contrato do cliente
     */
    public function contratoClienteLast($cliente) {

        // ID do Contrato
        $idContrato = $this->cm->getContractIdByClient($cliente,'last');

        if ($idContrato) {
            redirect('contratos/visualizar/'.$idContrato.'/print');
        } else {
            redirect('contratos/cliente/'.$cliente);
        }

    }

    /**
	 * Index Page for this controller.
	 * Listagem
	 */
	public function view($id, $print = false)
	{
		$this->data['body_class'] = '';
		$this->data['body_id'] = 'clientes';

        // DADOS DO CONTRATO
        $returnItem = $this->cm->getById($id);

        if (!$returnItem)
            redirect(base_url());

        // PARCELAS
        $returnParcelas = $this->pm->getAllByContractId($returnItem->id);

        // DADOS DO CLIENTE
        $returnCliente = $this->clm->getById($returnItem->id_client);
        // DADOS DO STATUS
        $returnStatus = $this->sts->getById($returnCliente->id_status);
        // DADOS DA CATEGORIA
        $returnCategoria = $this->cat->getById($returnCliente->id_category);
        // DADOS DA CATEGORIA
        $returnProduto = $this->prm->getByCode($returnCliente->product);
        
        $this->data['contrato'] = $returnItem;
        $this->data['parcelas'] = $returnParcelas;
        $this->data['cliente'] = $returnCliente;
        $this->data['status'] = $returnStatus;
        $this->data['categoria'] = $returnCategoria;
        $this->data['produto'] = $returnProduto;

		// logo
		if (file_exists("./upload/logo/$returnCliente->id.jpg")) {
			$this->data['logo'] = "/upload/logo/$returnCliente->id.jpg";
		} else {
			$this->data['logo'] = asset_url()."img/logo.png";
        }
        
        // Impressão
        if ($print) {
            $this->data['imprimir'] = true;
        }

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/contrato-view', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/contratos', $this->data, TRUE));
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-default', $this->data);
    }

	/**
	 * Index Page for this controller.
	 * Incluir
	 */
	public function incluir($cliente = false, $contrato = false)
	{
		$this->data['body_class'] = '';
        $this->data['body_id'] = 'contratos';
        
        // cliente selecionado
        $this->data['id_client'] = $cliente;

        // contrato selecionado (para renovação)
        if ($contrato) {
            $this->data['contrato'] = $this->cm->getById($contrato);
            $this->data['contrato']->number = $this->data['contrato']->number+1;

        } else {
            $this->data['contrato'] = false;
        }

		// clientes
        $this->load->model('clientes_model', 'clm');
        if ($cliente) {
            $this->data['clientes'] = $this->clm->getById($cliente,'*',true);
        } else {
            $this->data['clientes'] = $this->clm->getAll(false);
        }

        // status
		$this->load->model('status_model', 'sm');
		$this->data['status'] = $this->sm->getAll(false);

		// cobradores
        $this->load->model('cobradores_model', 'cbm');
		$this->data['cobradores'] = $this->cbm->getAll(false);

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);
		$this->data['extra_head'] = array($this->load->view('css/contratos', NULL, TRUE));

		$this->data['brand'] = $this->load->view('brand', $this->data, TRUE);
		$this->data['aside'] = $this->load->view('aside', $this->data, TRUE);
		$this->data['header'] = $this->load->view('header', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/contratos-form', $this->data, TRUE);

		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/contratos', NULL, TRUE));
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
		$this->data['body_id'] = 'contratos';

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

		$this->data['content'] = $this->load->view('content/contratos-form', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
		$this->data['extra_scripts'] = array($this->load->view('js/contratos', NULL, TRUE));
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

        // CONTRATO
        if (isset($_POST['id_client'])) {
            $data['id_client'] = $this->input->post('id_client');
        }
        if (isset($_POST['id_collector'])) {
            $data['id_collector'] = $this->input->post('id_collector');           
        }
        if (isset($_POST['id_status'])) {
            $data['id_status'] = $this->input->post('id_status');
        }
        if (isset($_POST['number'])) {
            $amount = $this->input->post('amount');
            $amount = str_replace('R$ ','',$amount);
            $amount = str_replace('.','',$amount);
            $amount = str_replace(',','.',$amount);
            $data['number'] = $this->input->post('number');
        }
        if (isset($_POST['amount'])) {
            $data['amount'] = $amount;
        }

        /*$data = [
            'id_client'     =>  $this->input->post('id_client'),
            'id_collector'  =>  $this->input->post('id_collector'),
            'id_status'     =>  $this->input->post('id_status'),
            'number'        =>  $this->input->post('number'),
            'amount'        =>  $amount
        ];*/

        // update
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data['number'] = $this->input->post('number');
            $return = $this->cm->update($data,$id);
            $this->data['message'] = 'Cadastro alterado com sucesso.';    
        }
        // insert
        else {
            $return = $this->cm->insert($data);
            $id = $return;
            $this->data['message'] = 'Cadastro realizado com sucesso.';    
        }

        // PARCELAS
        $postedData = $this->input->post();
        foreach($postedData['quote_amount'] as $key => $quote) {

            if (isset($_POST['id_quote'][$key])) {
                $id_quote = $postedData['id_quote'][$key];
            } else {
                $id_quote = false;
            }
            
            // valor da parcela
            if ($postedData['quote_amount'][$key] !== '') {
                $quote_amount = $postedData['quote_amount'][$key];
                if (strpos($quote_amount, 'R$') !== false) {
                    $quote_amount = str_replace('R$ ','',$quote_amount);
                    $quote_amount = str_replace('.','',$quote_amount);
                    $quote_amount = str_replace(',','.',$quote_amount);
                }
            } else {
                $quote_amount = 0;
            }

            // valor da parcela paga
            if ($postedData['quote_amount_paid'][$key] !== '') {
                $quote_amount_paid = $postedData['quote_amount_paid'][$key];
                if (strpos($quote_amount_paid, 'R$') !== false) {
                    $quote_amount_paid = str_replace('R$ ','',$quote_amount_paid);
                    $quote_amount_paid = str_replace('.','',$quote_amount_paid);
                    $quote_amount_paid = str_replace(',','.',$quote_amount_paid);
                }
            } else {
                $quote_amount_paid = 0;
            }

            // data de vencimento
            $due_date = dataPTtoMySQL($postedData['due_date'][$key]);
    
            // status da parcela
            if ($postedData['payday'][$key] !== '' && $postedData['quote_amount_paid'][$key] !== '') {
                $status = "Paga";
                // data de vencimento
                $payday = dataPTtoMySQL($postedData['payday'][$key]);
            } else {
                $status = "Em aberto";
                // data de vencimento
                $payday = null;
            }

            // observação
            if ($postedData['obs'][$key] !== '') {
                $obs = $postedData['obs'][$key];
            } else {
                $obs = '';
            }
    

            $data = [
                'id_client'         =>  $this->input->post('id_client'),
                'id_contract'       =>  $id,
                'quote_amount'      =>  $quote_amount,
                'quote_type'        =>  'Regular',
                'due_date'          =>  $due_date,
                //'payment_method'    =>  $postedData['payment_method'][$key],
                'payday'            =>  $payday,
                'quote_amount_paid' =>  $quote_amount_paid,
                'status'            =>  $status,
                'obs'               =>  $obs
            ];
            
            if (isset($_POST['payment_method'][$key])) {
                $data['payment_method'] = $postedData['payment_method'][$key];
            }

            //print_r($data);
            //continue;

            // update
            if ($this->input->post('id')) {
                $data['contract_number'] = $this->input->post('number');
                $return = $this->pm->update($data,$id_quote);
                $this->data['message'] = 'Contrato alterado com sucesso.';    
            }
            // insert
            else {
                $return = $this->pm->insert($data);
                $this->data['message'] = 'Contrato cadastrado com sucesso.';    
            }

        }
        //exit;
            
        if ($return) {
            $this->data['alert'] = 'success';
        } else {
            $this->data['alert'] = 'danger';
            $this->data['message'] = 'Não foi possível realizar esta ação.';    
        }
    
        redirect('contratos/cliente/'.$this->input->post('id_client'));
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
	 * Remove o registro
	 */
	public function release()
	{
        if(!isset($_POST)) {
            redirect(base_url());
        }

        if ($this->pm->release($this->input->post('id'),$this->input->post('client'),$this->input->post('releaseQuotes'))) {
            $data = [
                'success'               => true,
                'title'                 => "Sucesso!",
                'message'               => "Na próxima tela continue informando as parcelas da quitação."
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