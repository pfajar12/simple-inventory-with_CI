<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('category_model');
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

		$data['title'] = ucfirst('category');
		$data['page'] = 'category';

		$data['data_list'] = $this->category_model->get_data_list()->result();
		$data['data_count'] = $this->category_model->get_data_list()->num_rows();

		$data['data_list_nonactive'] = $this->category_model->get_data_list_nonactive()->result();
		$data['data_count_nonactive'] = $this->category_model->get_data_list_nonactive()->num_rows();

		$this->load->view('template/header', $data);
		$this->load->view('category/index');
	}

	public function get_data($value='')
	{
		$this->category_model->get_data();
	}

	public function get_data_nonactive($value='')
	{
		$this->category_model->get_data_nonactive();
	}

	public function check_exist($value='')
	{
		$this->category_model->check_exist_data();
	}

	public function create($value='')
	{
		$this->category_model->create_new_data();
	}

	public function edit($id='')
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
		
		$data['title'] = ucfirst('category');
		$data['page'] = 'category';

		$data['data_count'] = $this->category_model->get_by_id($id)->num_rows();
		$data['data'] = $this->category_model->get_by_id($id)->row();
		$this->load->view('template/header', $data);
		$this->load->view('category/edit', $data);
	}

	public function update($value='')
	{
		$this->category_model->update_data();
	}

	public function delete($value='')
	{
		$this->category_model->delete_data();
	}

	public function restore($id='')
	{
		$this->category_model->restore_data();
	}
}
