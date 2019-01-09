<?php
class Admin_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_total_admin($value='')
        {
        	$query = $this->db->get('admin');
        	return $query->num_rows();
        }

        public function get_data_list($value='')
        {
        	$query = $this->db->query("SELECT a.id, a.username, b.name AS warehouse_name FROM admin a JOIN warehouse b ON a.warehouse_id=b.id WHERE a.role = 2 AND a.status = 1");
        	return $query;
        }
}