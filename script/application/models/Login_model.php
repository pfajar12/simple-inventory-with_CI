<?php
class Login_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function auth($username='', $password='')
        {
        	$query = $this->db->query("SELECT * FROM admin WHERE username='$username' AND password='$password' AND status=1");
        	return $query;
        }
}