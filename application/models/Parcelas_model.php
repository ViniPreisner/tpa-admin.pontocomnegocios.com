<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Parcelas_model extends CI_Model
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
    function selectAllItemsCount(){
        $this->db->select('COUNT(id) as total');
        $this->db->from('quotes');
        $this->db->where('quotes.deleted_at', NULL); 
        $query = $this->db->get();
        return $query->row();
    }

	/**
	 * Lista todos as parcelas
	 */
    function getAll($limit_per_page = false, $start_index = false, $count = false){

        // paginação
		if ($limit_per_page) {
            if ($start_index > 1) {
                $offset = ($start_index-1)*$limit_per_page;
            } else {
                $offset = 0;
            }
			$this->db->limit($limit_per_page, $offset);
		}

		/* Parcelas */
        $this->db->select('*');
        $this->db->from('quotes');
        $this->db->where('quotes.deleted_at', NULL); 
        $this->db->order_by('quotes.id','asc');
				
		$query = $this->db->get();
		$this->total = $query->num_rows();

		$items = $query->result();

        return $items;

    }

	/**
	 * Lista todos as parcelas
	 */
    function getAllByContractId($id_contract){

		/* Parcelas */
        $this->db->select('*');
        $this->db->from('quotes');
        $this->db->where('quotes.deleted_at', NULL); 
        $this->db->where('quotes.id_contract', $id_contract); 
        $this->db->where('quotes.status <> ', 'Cancelada'); 
        $this->db->order_by('quotes.id','asc');
				
		$query = $this->db->get();
		$this->total = $query->num_rows();

		$items = $query->result();

        return $items;

    }


    /**
	 * Get item
	 */
    function getById($id,$fields = '*'){

		/* Parcelas */
        $this->db->select($fields);
        $this->db->from('quotes');
        $this->db->where('quotes.deleted_at', NULL); 
        $this->db->where('quotes.id', $id); 
        
        $query = $this->db->get();
        $item = $query->row();

        return $item;
    }
	
	public function insert($data){
        $this->db->insert('quotes' , $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

	public function update($data,$id){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->where('quotes.deleted_at', NULL); 
        return $this->db->update('quotes');
    }
    
	public function delete($id){
        $this->db->set('deleted_at',$this->timestamp);
        $this->db->where('quotes.id',$id);
        $this->db->where('quotes.deleted_at', NULL); 
        return $this->db->update('quotes');
	}

	public function release($id,$client,$releaseQuotes){
        // cancela parcelas abertas
        $this->db->set('status','Cancelada');
        $this->db->where('quotes.id_contract',$id);
        $this->db->where('quotes.status','Em aberto');
        $this->db->where('quotes.deleted_at', NULL); 
        $this->db->update('quotes');
        // cria novas parcelas
        $i = 0;
        while ($i < $releaseQuotes) {
            $data = [
                'id_client'         =>  $client,
                'id_contract'       =>  $id,
                'quote_amount'      =>  0,
                'quote_type'        => 'Release',
                'due_date'          =>  null,
                'payday'            =>  null,
                'quote_amount_paid' =>  0,
                'status'            =>  'Em aberto'
            ];
            $this->insert($data);
            $i++;
        }
        return true;
	}

}
?>