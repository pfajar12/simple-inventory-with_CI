<?php
class Salestransaction_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_total_salestransaction($value='')
        {
        	$query = $this->db->get('sales_transaction');
        	return $query->num_rows();
        }
}