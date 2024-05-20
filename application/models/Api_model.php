<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class api_model
 */
class api_model extends MY_Model{

    /**
     * wb_model constructor.
     */
    public final function __construct()
    {
        parent::__construct();
        //$this->save_log();

        $this->product_name = $this->checkToken();
		
        $this->load->library('pagination');
		//$this->load->model('logistica_model', 'lm');

	}


    /**
     * Conteúdo da Home
     * @access public
     * @author 
     * @return array
     */
    public final function home()
    {   
        if(checkParameter('access_token')){
			$jsonHome = $this->getHomeData();
			$this->dispatchSuccess($jsonHome);
        }
    }


    /**
     * Conteúdo da Categoria
     * @access public
     * @author 
     * @return array
     */
    public final function categoria()
    {   
        if(checkParameter('access_token')){
			$jsonHome = $this->getCategoryData($this->input->post('category_id', TRUE));
			$this->dispatchSuccess($jsonHome);
        }
    }


    /**
     * Conteúdo da Empresa
     * @access public
     * @author 
     * @return array
     */
    public final function empresa()
    {   
        if(checkParameter('access_token')){
			$jsonHome = $this->getClientData($this->input->post('client_id', TRUE));
			$this->dispatchSuccess($jsonHome);
        }
    }

    /**
     * Conteúdo da Busca
     * @access public
     * @author 
     * @return array
     */
    public final function busca()
    {   
        if(checkParameter('access_token')){
			$jsonHome = $this->getSearchData($this->input->post('search_terms', TRUE));
			$this->dispatchSuccess($jsonHome);
        }
    }


    /**
     * Envio de e-mail
     * @access public
     * @author 
     * @return array
     */
    public final function contato()
    {   
        if(checkParameter('access_token')){
			$jsonHome = $this->sendContactMail();
			$this->dispatchSuccess($jsonHome);
        }
    }


    /**
     * consulta negativados
     * @access public
     * @author 
     * @return array
     */
    public final function negativados()
    {   
        if(checkParameter('access_token')){
			$jsonNegativados = $this->getNegativados();
			$this->dispatchSuccess($jsonNegativados);
        }
    }


	/**
     * Dados da Home
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getHomeData()
    {
        $jsonHome = [];
        $jsonHome['categories'] = [];
        $jsonHome['clients'] = [];
        $jsonHome["meta"] = [];
        $jsonHome["featured"] = [];
		
		/**
		 * Categorias
		 */
		$categories = $this->getCategories();
        
        $limit_per_page = 20;
        $page = $this->input->post('per_page') ?: 1;
        // Calculate the offset for the query
        $start_index_count = ($page - 1)  * $limit_per_page;
        $start_index = $page;

        if ($page == 1) {
            $this->session->set_userdata('seed_rand', rand(100,999));
        }
        $seed_rand = $this->session->userdata('seed_rand');
        //echo $seed_rand;exit;

        $total_records = $this->getClients(false, false, false, $limit_per_page,$start_index_count,$page,0,true);

        if ($total_records > 0) 
        {
            $return = $this->getClients('featured DESC, RAND('.$seed_rand.')', false, false, $limit_per_page, $start_index,$page,$total_records);
            $clients = $return['itens'];
            $meta = $return['meta'];
        } else {
            $clients = false;
            $meta = false;
        }

		/**
		 * Clientes
		 */
		//$clients = $this->getClients('RANDOM');
		if ($clients) {
            foreach ($clients as $key => $client) {
                // logo
                if (file_exists("./upload/logo/$client->client_id.jpg")) {
                    $clients[$key]->image = URL_HOST_FILES."/upload/logo/$client->client_id.jpg";
                } else {
                    $clients[$key]->image = URL_HOST_FILES."/upload/logo/placeholder.jpg";
                }
            }
        }

        $jsonHome['categories'] = $categories;        
        $jsonHome['clients'] = $clients;
        $jsonHome['meta'] = $meta;
        
        //print_r($jsonHome);exit;
		
		return $jsonHome;
				
    }


	/**
     * Dados da Categoria
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getCategoryData($category_id)
    {
        $jsonHome = [];
        $jsonHome['categories'] = [];
        $jsonHome['clients'] = [];
        $jsonHome["meta"] = [];
		
		/**
		 * Categorias
		 */
        $categories = $this->getCategories();
        
        $limit_per_page = 20;
        $page = $this->input->post('per_page') ?: 1;
        // Calculate the offset for the query
        $start_index = ($page - 1)  * $limit_per_page;

        $total_records = $this->getClients(false, $category_id, false, $limit_per_page,$start_index,$page,0,true);

        if ($total_records > 0) 
        {
            $return = $this->getClients(false, $category_id, false, $limit_per_page, $start_index,$page,$total_records);
            $clients = $return['itens'];
            $meta = $return['meta'];
        } else {
            $clients = false;
            $meta = false;
        }

		/**
		 * Clientes
		 */
		//$clients = $this->getClients(false,$category_id);
		if ($clients) {
            foreach ($clients as $key => $client) {
                // logo
                if (file_exists("./upload/logo/$client->client_id.jpg")) {
                    $clients[$key]->image = URL_HOST_FILES."/upload/logo/$client->client_id.jpg";
                } else {
                    $clients[$key]->image = URL_HOST_FILES."/upload/logo/placeholder.jpg";
                }
            }
        }

        /**
         * Categoria
         */
        $_category = $this->getCategories($category_id);
        $category_name = $_category[0]->name;

        $jsonHome['category_name'] = $category_name;
        $jsonHome['categories'] = $categories;        
        $jsonHome['clients'] = $clients;
        $jsonHome['meta'] = $meta;
		
		return $jsonHome;
				
    }

    /**
     * Dados da Busca
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getSearchData($search_terms)
    {
        $jsonHome = [];
        $jsonHome['search_terms'] = $search_terms;
        $jsonHome['categories'] = [];
        $jsonHome['clients'] = [];
        $jsonHome["meta"] = [];
		
		/**
		 * Categorias
		 */
		$categories = $this->getCategories();

        $limit_per_page = 20;
        $page = $this->input->post('per_page') ?: 1;
        // Calculate the offset for the query
        $start_index = ($page - 1)  * $limit_per_page;

        $total_records = $this->getClients(false, false, $search_terms, $limit_per_page,$start_index,$page,0,true);

        if ($total_records > 0) 
        {
            $return = $this->getClients(false, false, $search_terms, $limit_per_page, $start_index,$page,$total_records);
            $clients = $return['itens'];
            $meta = $return['meta'];
        } else {
            $clients = false;
            $meta = false;
        }

		/**
		 * Clientes
		 */
		//$clients = $this->getClients(false,false,$search_terms);
		if ($clients) {
            foreach ($clients as $key => $client) {
                // logo
                if (file_exists("./upload/logo/$client->client_id.jpg")) {
                    $clients[$key]->image = URL_HOST_FILES."/upload/logo/$client->client_id.jpg";
                } else {
                    $clients[$key]->image = URL_HOST_FILES."/upload/logo/placeholder.jpg";
                }
            }
        }

        $jsonHome['categories'] = $categories;        
        $jsonHome['clients'] = $clients;
        $jsonHome["meta"] = $meta;
		
		return $jsonHome;
				
    }

    /**
     * Dados da Empresa
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getClientData($client_id)
    {
        $jsonHome = [];
        $jsonHome['categories'] = [];
        $jsonHome['client'] = [];
		
		/**
		 * Categorias
		 */
		$categories = $this->getCategories();

		/**
		 * Clientes
		 */
		$client = $this->getClient($client_id);
		if ($client) {
            // logo
            if (file_exists("./upload/logo/$client->client_id.jpg")) {
                $client->image = URL_HOST_FILES."/upload/logo/$client->client_id.jpg";
            } else {
                $client->image = URL_HOST_FILES."/upload/logo/placeholder.jpg";
            }
        }

        $jsonHome['categories'] = $categories;        
        $jsonHome['client'] = $client;        
		
		return $jsonHome;
				
    }

    /**
     * Negativavdos
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getNegativados()
    {

        $document = $this->input->post('search_cnpj');
        $document = str_replace('.','',$document);
        $document = str_replace('/','',$document);
        $document = str_replace('-','',$document);

        // busca cnpj
        $this->db->select('id, , debtor, note_date, note_time, negative, creditor, amount', false);
        $this->db->where('document',$document);
        $this->db->where('deleted_at', NULL);
        $cnpj_query = $this->db->get('negated');
        $client = $cnpj_query->row();
		
		if($client) {

            if ($client->negative == 1) {

                $date = ($client->note_date != '0000-00-00') ? dataMySQLtoPT($client->note_date) : '';
                $time = ($client->note_time != '00:00:00') ? $client->note_time : '';
                $glue = ($date !== '' && $time !== '') ? ' às ' : '';

                $notedatetime = $date . $glue . $time;

                $jsonNegativados = [
                    'message' => 'Atenção, o CNPJ está sob protesto',
                    'class' => 'danger',
                    'creditor' => $client->creditor,
                    'debtor' => $client->debtor,
                    'notedatetime' => $notedatetime,
                    'amount' => money_format('%n',$client->amount)
                ];
            } else {
                $jsonNegativados = [
                    'message' => 'CNPJ sem nenhuma pendência',
                    'class' => 'success'
                ];
            }
    
        } else {
            $jsonNegativados = [
                'message' => 'CNPJ não encontrado no sistema',
                'class' => 'warning'
            ];
        }

        // grava consulta
        $ip_address = $this->input->ip_address();
        $date_request = date('Y-m-d');
        $time_request = date('H:i');

        $data = [
            'document' => $this->input->post('search_cnpj',TRUE),
            'response' => $jsonNegativados['message'],
            'datetime_request' => $date_request . ' ' . $time_request
        ];
        $this->db->insert('negated_history' , $data);
        
        $jsonNegativados['datetime'] = 'Consulta realizado por '.$ip_address.' dia '.dataMySQLtoPT($date_request).' às '.$time_request.'.';
        
		return $jsonNegativados;
				
    }


    /**
     * Lista de areas/cagegorias
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getCategories($category_id = false)
    {
		
        $this->db->select('id, name', false);
        $this->db->order_by('name','ASC');
        if ($category_id) {
            $this->db->where('id',$category_id);
        }
        $category_query = $this->db->get('categories');
		
		return $category_query->result();;
		
	}


    /**
     * Lista de areas/cagegorias
     * @param array $where
     * @access private
     * @author
     * @return array
     * $return = $this->getClients('featured DESC, RAND(123)', false, false, $limit_per_page, $start_index,$page,$total_records);
     */ 
    private final function getClients($order = false, $category_id = false,$search_terms = false, $limit_per_page = false, $start_index = false, $page = 1, $total_records = 0, $count = false)
    {
		
        $this->db->select('clients.id as client_id, clients.trade_name, clients.name, clients.featured, clients.city, clients.state, categories.id as category_id, categories.name as category', false);
        $this->db->join('categories','clients.id_category = categories.id');
        $this->db->where('clients.product',$this->product_name);
        $this->db->where('clients.is_published', 'Sim');
        $this->db->where('clients.deleted_at', NULL);
        // categoria
        if ($category_id) {
            $this->db->where('clients.id_category',$category_id);
        }    
        // ordenacao
        if ($order) {
            $this->db->order_by($order);
        } else {
            $this->db->order_by('clients.name','ASC');
        }    
        // busca
        if ($search_terms) {
            $this->db->group_start();
            $this->db->where('clients.trade_name',$search_terms);
            $this->db->or_where('clients.name',$search_terms);
            //$this->db->like('clients.trade_name',$search_terms);
            //$this->db->or_like('clients.name',$search_terms);
            //$this->db->or_like('categories.name',$search_terms);
            $this->db->group_end();
        }

        if ($count) {
            $category_query = $this->db->get('clients');
            return $category_query->num_rows();
        }
		
		// paginação
		if ($limit_per_page) {
			//$start_index;
			if ($start_index !== 0) {
				$start_index = ($start_index-1)*$limit_per_page;
			}
			$limit_per_page.' '.$start_index;
			$this->db->limit($limit_per_page,$start_index);
		}

        $category_query = $this->db->get('clients');
        $this->total = $category_query->num_rows();
        $this->total_itens = $category_query->num_rows();

        /*
        if (!$count) {
            echo $this->db->last_query();exit;
        }
        */
        
        $itens = $category_query->result();
        

		// trata o resultado
		if (!$itens) {
			$return	=	[
				'status'	    => false,
				'msg'		    => 'Nenhum item.',
				//'query'		=> $last_query,
                'total'		    => 0,
                'total_itens'   => $this->total_itens
			];
		} else {

            $page_count = (int)ceil($total_records / $limit_per_page);
            $end = ($start_index + $this->total);
            //$current_page = (int)ceil($this->total / $limit_per_page)

            $return['itens'] = $itens;
            $return['meta'] = [
                'current_page'  => $page,
                'from'          => $start_index+1,
                'last_page'     => $page_count,
                'per_page'      => $limit_per_page,
                'to'            => $end,
                'total'		    => $total_records
			];
        }

		
		return $return;
		
	}

    /**
     * Dados do cliente
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    private final function getClient($client_id)
    {
        $this->db->select(
            'clients.id as client_id, 
            clients.trade_name, 
            clients.name, 
            clients.zipcode, 
            clients.address, 
            clients.address_number, 
            clients.address_complement, 
            clients.city, 
            clients.state, 
            clients.neighborhood, 
            clients.phone_number_1, 
            clients.phone_number_2, 
            clients.website, 
            categories.id as category_id, 
            categories.name as category', false);
        $this->db->join('categories','clients.id_category = categories.id');
        $this->db->where('clients.id', $client_id);
        $this->db->where('clients.is_published', 'Sim');
        $this->db->where('clients.deleted_at', NULL);
        $category_query = $this->db->get('clients');
		
		return $category_query->row();;
    }
    



    public function sendContactMail() {
        
        $this->load->model('produtos_model', 'prm');

        $returnProduto = $this->prm->getByCode($this->product_name);
        
        $emailAddress = $returnProduto->email;
        
        $emailFrom = 'hostmaster@agiler.com.br';

        $this->load->library('email');
        
        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $message = $this->input->post('message', TRUE);
        
        $config['smtp_host'] = 'smtplw.com.br';
        $config['smtp_port'] = 587;
        $config['smtp_user'] = 'rdrocha5';
        $config['smtp_pass'] = 'KAtcWykK5793';
        $config['protocol'] = 'smtp';
        $config['validate'] = TRUE; 
        $config['mailtype'] = 'html';
        $this->email->initialize($config);  
        $this->email->set_newline("\r\n");
        $this->email->from($emailAddress,'TPA - Contato');

        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>TPA - Contato</title>
        </head>
        <body bgcolor="#ffffff">
            <table align="center" cellpadding="0" cellspacing="0" border="0" width="700" bgcolor="#FFFFFF">
                <tr>
                    <td>
                        <table align="center" cellpadding="10" cellspacing="10" border="0" width="100%">
                            <tr>
                                <td>
                                    <font face="Arial" size="4" color="#333333">
                                        <strong>TPA -Contato</strong>
                                    </font>
                                    <br><br>
                                    <font face="Arial" size="2" color="#333333">
                                        <p><strong>Nome</strong>: '.$name.'</p>
                                        <p><strong>E-mail</strong>: '.$email.'</p>
                                        <p><strong>Telefone</strong>: '.$phone.'</p>
                                        <p><strong>Mensagem</strong>: '.$message.' meses</p>
                                    </font>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>';

        // Paciente
        $this->email->initialize($config);  
        $this->email->set_newline("\r\n");
        $this->email->from($emailFrom,'TPA - Contato');
        $this->email->to($email);
        $this->email->subject('TPA - Contato');        
        $this->email->message($body);

        if ($this->email->send()) {
			$return	=	[
				'status'	    => true,
				'message'		=> 'Mensagem enviada com sucesso.',
			];
        } else {
			$return	=	[
				'status'	    => false,
				'message'		=> 'Houve um erro ao enviar sua mensagem.',
			];
        }

        return $return;
            
    }



    /**
     * Json Dados do cliente
     * @param array $where
     * @access private
     * @author
     * @return array
     */
    public function json_clientes($product_name)
    {
        
        $this->db->select(
            'clients.id as client_id, 
            clients.trade_name, 
            clients.name, 
            clients.zipcode, 
            clients.address, 
            clients.address_number, 
            clients.address_complement, 
            clients.city, 
            clients.state, 
            clients.neighborhood, 
            clients.phone_number_1, 
            clients.phone_number_2, 
            clients.website, 
            categories.id as category_id, 
            categories.name as category', false);
        $this->db->join('categories','clients.id_category = categories.id');
        $this->db->where('clients.product',$product_name);
        $this->db->where('clients.is_published', 'Sim');
        $this->db->where('clients.deleted_at', NULL);
        $this->db->order_by('clients.name', NULL);
        $this->db->order_by('clients.trade_name', NULL);
        $category_query = $this->db->get('clients');
		
        $itens = $category_query->result();

        $result = '';

        foreach($itens as $item) {

            $result .= '{';

            // category
            $category = ($item->category) ? $item->category : '';

            $result .= 'category: "'.$category.'",';

            // name
            $name = ($item->name) ? $item->name : $item->trade_name;

            $result .= 'name: "'.$name.'",';

            // address
            $address = ($item->address) ? $item->address : '';
            $address .= ($item->address_number) ? ','.$item->address_number : '';
            $address .= ($item->address_complement) ? ' - '.$item->address_complement : '';
            $address .= ($item->neighborhood) ? ' - '.$item->neighborhood : '';
            $address .= ($item->city) ? ' - '.$item->city : '';
            $address .= ((!$item->city || $item->city == ' ') && $item->state) ? ' - '.$item->state : '';
            $address .= ($item->city && $item->state) ? '/'.$item->state : '';

            $result .= 'address: "'.$address.'",';

            // phone
            $phone = ($item->phone_number_1) ? $item->phone_number_1 : '';
            $phone .= ($item->phone_number_1 && $item->phone_number_2) ? ' / ' : '';
            $phone .= ($item->phone_number_2) ? $item->phone_number_2 : '';

            $result .= 'phone: "'.$phone.'" },';

            $result .= "\n";
        }
        

        //print_r($itens);
        echo $result;

    }


}