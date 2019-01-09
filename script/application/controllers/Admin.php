<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('admin_model');
    }

	public function index()
	{
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

		$data['title'] = ucfirst('admin');
		$data['page'] = 'admin';

		$data['data'] = $this->admin_model->get_data_list()->result();
		$data['data_count'] = $this->admin_model->get_data_list()->num_rows();

		$this->load->view('template/header', $data);
		$this->load->view('admin/index');
	}

}
