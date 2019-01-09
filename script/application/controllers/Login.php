<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('login_model');
            // $this->load->helper('url_helper');
    }

	public function index()
	{
		if($this->session->userdata('username')){
			redirect('home','refresh');
		}

		$data['title'] = ucfirst('Batam Book St');
		$data['page'] = 'login';

		$this->load->view('template/header', $data);
		$this->load->view('login');
	}

	public function auth($value='')
	{
		$username = htmlspecialchars($this->input->post('username'));
		$password = htmlspecialchars($this->input->post('password'));

		$checklogin = $this->login_model->auth($username, md5($password));
		
		if($checklogin->num_rows()>=1){
			$data = $checklogin->row_array();
			$array = array(
				'id' => $data['id'],
				'username' => $data['username'],
				'warehouse_id' => $data['warehouse_id'],
				'role' => $data['role']
			);
			
			$this->session->set_userdata( $array );

			if($this->session->userdata('role')!=1){
				if($this->session->userdata('warehouse_id')==1){
					redirect(base_url('inventory'),'refresh');
				}
				else if($this->session->userdata('warehouse_id')==''){
					redirect(base_url('login'),'refresh');
				}
				else{
					redirect(base_url('stock'),'refresh');
				}
			}
			
			redirect(base_url('home'),'refresh');
		}
		else{
			echo $this->session->set_flashdata('msg','Invalid Login. Make sure your account is active');
            redirect(base_url('login'));
		}
	}

	public function logout(){
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

}
