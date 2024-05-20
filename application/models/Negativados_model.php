<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Negativados_model extends CI_Model
{

    public $total = 0;
	public $pages = 1;
	public $current = 1;
    public $links = '';

	public function __construct()
	{
		parent::__construct();
        $this->timestamp = date('Y-m-d H:i');

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
	 * Retorna total de registros
	 */
    function selectAllItemsCount($terms = false){
        $this->db->select('COUNT(negated.id) as total');
        $this->db->from('negated');
        $this->db->join('contracts', 'negated.id = contracts.id_client', 'left');

        if ($terms) {
            $this->db->like('negated.trade_name', $terms);
            $this->db->or_like('negated.name', $terms);
            $this->db->or_like('negated.document', $terms);
            $this->db->or_like('contracts.number', $terms);
        }

        $this->db->where('negated.deleted_at', NULL); 
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
            negated.id,
            negated.name,
            negated.document,
            negated.creditor,
            negated.amount,
            DATE(negated.created_at) as created_at, 
            negated.negative
            ');
        $this->db->from('negated');
        $this->db->where('negated.deleted_at', NULL); 

        $this->db->order_by('negated.name','asc');
				
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
        $this->db->from('negated');
        $this->db->where('negated.deleted_at', NULL); 
        $this->db->where('negated.id', $id); 
        
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
        $this->db->from('negated');
        $this->db->where('negated.deleted_at', NULL); 
        $this->db->where('negated.document', $document); 
        
        $query = $this->db->get();
        if ($array) {
            $item = $query->result();
        } else {
            $item = $query->row();
        }

        return $item;
    }

	public function insert($data){
        $this->db->insert('negated' , $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

	public function update($data,$id){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->where('negated.deleted_at', NULL); 
        return $this->db->update('negated');
    }
    
	public function delete($id){
        $this->db->set('deleted_at',$this->timestamp);
        $this->db->where('negated.id',$id);
        $this->db->where('negated.deleted_at', NULL); 
        return $this->db->update('negated');
	}

}
?>