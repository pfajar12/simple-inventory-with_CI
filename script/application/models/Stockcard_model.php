<?php
class Stockcard_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_total_stockcard($value='')
        {
        	$query = $this->db->get('stockcard');
        	return $query->num_rows();
        }

        public function get_stockcard_per_warehouse($value='')
        {
        	$warehouse_id = htmlspecialchars($this->input->post('warehouse_id'));
        
	        $query = $this->db->query("SELECT a.qty_in, a.qty_out, a.note, a.date, b.book_code, b.name AS book_name, c.username FROM stockcard a JOIN book b ON a.book_id=b.id LEFT JOIN admin c ON a.user_id=c.id WHERE a.warehouse_id='$warehouse_id'")->result();
	        echo '{"items":'. json_encode($query).'}';
        }
}