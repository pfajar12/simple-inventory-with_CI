<?php
class Warehouse_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_total_warehouse($value='')
        {
        	$query = $this->db->get('warehouse');
        	return $query->num_rows();
        }

        public function get_data_list($value='')
        {
        	$query = $this->db->query("SELECT * FROM warehouse WHERE status = 1 AND id!=1 ORDER BY id DESC");
        	return $query;
        }

        public function get_data_list_nonactive($value='')
        {
            $query = $this->db->query("SELECT * FROM warehouse WHERE status = 0 AND id!=1 ORDER BY id DESC");
            return $query;
        }

        public function get_data($value='')
        {
        	$query = $this->db->query("SELECT * FROM warehouse WHERE status = 1 AND id!=1 ORDER BY id DESC")->result();
        	echo '{"items":'. json_encode($query).'}';

        }

        public function get_data_nonactive($value='')
        {
            $query = $this->db->query("SELECT * FROM warehouse WHERE status = 0 AND id!=1 ORDER BY id DESC")->result();
            echo '{"items":'. json_encode($query).'}';

        }

        public function get_by_id($id='')
        {
        	$query = $this->db->query("SELECT * FROM warehouse WHERE id='$id'");
        	return $query;
        }

        public function check_exist_warehouse($value='')
        {
        	$warehousename = htmlspecialchars($this->input->post('warehousename'));

        	$query = $this->db->query("SELECT id FROM warehouse WHERE name='$warehousename'")->num_rows();

        	if($query<1){
        		echo 'not exist';
        	}
        	else{
        		echo 'exist';
        	}
        }

        public function create_new_warehouse($value='')
        {
        	$warehousename = htmlspecialchars($this->input->post('warehousename'));
        	$query = $this->db->query("INSERT INTO warehouse(name) VALUES('$warehousename')");
        	if($query){
        		echo  'success';
        	}
        	else{
        		echo 'fail';
        	}
        }

        public function update_warehouse($value='')
        {
        	$warehousename = htmlspecialchars($this->input->post('warehousename'));
        	$id = htmlspecialchars($this->input->post('id'));
        	$query = $this->db->query("UPDATE warehouse SET name='$warehousename' WHERE id='$id'");
        	
        	if($query){
        		echo 'success';
        	}
        }

        public function delete_warehouse($value='')
        {
        	$id = htmlspecialchars($this->input->post('id'));
        	$query = $this->db->query("UPDATE warehouse SET status=0 WHERE id='$id'");

        	if($query){
        		echo 'success';
        	}
        }

        public function restore_data($value='')
        {
            $id = htmlspecialchars($this->input->post('id'));
            $query = $this->db->query("UPDATE warehouse SET status=1 WHERE id='$id'");
            
            if($query){
                echo 'success';
            }
        }

        public function get_all_list($value='')
        {
            $query = $this->db->query("SELECT * FROM warehouse WHERE status = 1 ORDER BY id DESC");
            return $query;
        }
}