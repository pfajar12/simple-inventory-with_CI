<?php
class Publisher_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_total_publisher($value='')
        {
        	$query = $this->db->get('publisher');
        	return $query->num_rows();
        }

        public function get_data_list($value='')
        {
        	$query = $this->db->query("SELECT * FROM publisher WHERE status = 1 ORDER BY id DESC");
        	return $query;
        }

        public function get_data_list_nonactive($value='')
        {
            $query = $this->db->query("SELECT * FROM publisher WHERE status = 0 ORDER BY id DESC");
            return $query;
        }

        public function check_exist_data($value='')
        {
        	$publishername = htmlspecialchars($this->input->post('publishername'));

        	$query = $this->db->query("SELECT id FROM publisher WHERE name='$publishername'")->num_rows();

        	if($query<1){
        		echo 'not exist';
        	}
        	else{
        		echo 'exist';
        	}
        }

        public function create_new_data($value='')
        {
        	$publishername = htmlspecialchars($this->input->post('publishername'));
        	$query = $this->db->query("INSERT INTO publisher(name) VALUES('$publishername')");
        	if($query){
        		echo  'success';
        	}
        	else{
        		echo 'fail';
        	}
        }

        public function get_data($value='')
        {
        	$query = $this->db->query("SELECT * FROM publisher WHERE status = 1 ORDER BY id DESC")->result();
        	echo '{"items":'. json_encode($query).'}';

        }

        public function get_data_nonactive($value='')
        {
            $query = $this->db->query("SELECT * FROM publisher WHERE status = 0 ORDER BY id DESC")->result();
            echo '{"items":'. json_encode($query).'}';

        }

        public function get_by_id($id='')
        {
        	$query = $this->db->query("SELECT * FROM publisher WHERE id='$id'");
        	return $query;
        }

        public function update_data($value='')
        {
        	$publishername = htmlspecialchars($this->input->post('publishername'));
        	$id = htmlspecialchars($this->input->post('id'));
        	$query = $this->db->query("UPDATE publisher SET name='$publishername' WHERE id='$id'");
        	
        	if($query){
        		echo 'success';
        	}
        }

        public function delete_data($value='')
        {
        	$id = htmlspecialchars($this->input->post('id'));
        	$query = $this->db->query("UPDATE publisher SET status=0 WHERE id='$id'");

        	if($query){
        		echo 'success';
        	}
        }

        public function restore_data($value='')
        {
            $id = htmlspecialchars($this->input->post('id'));
            $query = $this->db->query("UPDATE publisher SET status=1 WHERE id='$id'");
            
            if($query){
                echo 'success';
            }
        }
}