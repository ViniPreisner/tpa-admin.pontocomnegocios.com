<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model
{

    public $total = 0;
	public $pages = 1;
	public $current = 1;
    public $links = '';

	public function __construct()
	{
		parent::__construct();
        $this->timestamp = date('Y-m-d H:i');
	}

	/**
	 * Retorna total de registros
	 */
    function selectAllItemsCount($terms = false){
        $this->db->select('COUNT(clients.id) as total');
        $this->db->from('clients');
        $this->db->join('contracts', 'clients.id = contracts.id_client', 'left');
        $this->db->where('clients.deleted_at', NULL); 

        if ($terms) {
            $this->db->group_start();
            $this->db->like('clients.trade_name', $terms);
            $this->db->or_like('clients.name', $terms);
            $this->db->or_like('clients.document', $terms);
            $this->db->or_like('contracts.number', $terms);
            $this->db->group_end();
        }

        $query = $this->db->get();
        return $query->row();
    }

	/**
	 * Lista todos os registros
	 */
    function getAll($limit_per_page = false, $start_index = false, $count = false, $terms = false){

        // paginação
		if ($limit_per_page) {
            if ($start_index > 1) {
                $offset = ($start_index-1)*$limit_per_page;
            } else {
                $offset = 0;
            }
			$this->db->limit($limit_per_page, $offset);
		}

		/* Clientes */
        $this->db->select('
            clients.id,
            clients.trade_name,
            clients.type,
            clients.document,
            clients.name,
            clients.email,
            DATE(clients.created_at) as created_at, 
            status.name as status_name,
            contracts.number as number_contract
            ');
        $this->db->from('clients');
        $this->db->join('status', 'clients.id_status = status.id','left');
        $this->db->join('contracts', 'clients.id = contracts.id_client', 'left');
        $this->db->group_by('clients.id'); 
        $this->db->where('clients.deleted_at', NULL); 

        if ($terms) {
            $this->db->like('clients.trade_name', $terms);
            $this->db->or_like('clients.name', $terms);
            $this->db->or_like('clients.document', $terms);
            $this->db->or_like('contracts.number', $terms);
        }

        $this->db->order_by('clients.trade_name','asc');
        $this->db->order_by('clients.name','asc');
        //$this->db->order_by('clients.id','asc');
        //$this->db->order_by('contracts.id','asc');
				
        $query = $this->db->get();
		$this->total = $query->num_rows();

		$items = $query->result();

        return $items;

    }

	/**
	 * Get item
	 */
    function getById($id,$fields = '*',$array = false){

		/* Clientes */
        $this->db->select($fields);
        $this->db->from('clients');
        $this->db->where('clients.deleted_at', NULL); 
        $this->db->where('clients.id', $id); 
        
        $query = $this->db->get();
        if ($array) {
            $item = $query->result();
        } else {
            $item = $query->row();
        }

        return $item;
    }
    
    /**
	 * Get item by CNPJ
	 */
    function getByCNPJ($document,$fields = '*',$array = false){

		/* Clientes */
        $this->db->select($fields);
        $this->db->from('clients');
        $this->db->where('clients.deleted_at', NULL); 
        $this->db->where('clients.document', $document); 
        
        $query = $this->db->get();
        if ($array) {
            $item = $query->result();
        } else {
            $item = $query->row();
        }

        return $item;
    }

	public function insert($data){
        $this->db->insert('clients' , $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

	public function update($data,$id){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->where('clients.deleted_at', NULL); 
        return $this->db->update('clients');
    }
    
	public function delete($id){
        $this->db->set('deleted_at',$this->timestamp);
        $this->db->where('clients.id',$id);
        $this->db->where('clients.deleted_at', NULL); 
        return $this->db->update('clients');
	}

}
?>