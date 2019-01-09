<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('warehouse_model');
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

		$data['title'] = ucfirst('warehouse');
		$data['page'] = 'warehouse';

		$data['data_list'] = $this->warehouse_model->get_data_list()->result();
		$data['data_count'] = $this->warehouse_model->get_data_list()->num_rows();

		$data['data_list_nonactive'] = $this->warehouse_model->get_data_list_nonactive()->result();
		$data['data_count_nonactive'] = $this->warehouse_model->get_data_list_nonactive()->num_rows();

		$this->load->view('template/header', $data);
		$this->load->view('warehouse/index');
	}

	public function get_data($value='')
	{
		$this->warehouse_model->get_data();
	}

	public function get_data_nonactive($value='')
	{
		$this->warehouse_model->get_data_nonactive();
	}

	public function check_exist($value='')
	{
		$this->warehouse_model->check_exist_warehouse();
	}

	public function create($value='')
	{
		$this->warehouse_model->create_new_warehouse();
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

		if($id==1){
			redirect(base_url('warehouse'),'refresh');
		}
		
		$data['title'] = ucfirst('warehouse');
		$data['page'] = 'warehouse';

		$data['count_data'] = $this->warehouse_model->get_by_id($id)->num_rows();
		$data['warehouse_data'] = $this->warehouse_model->get_by_id($id)->row();
		$this->load->view('template/header', $data);
		$this->load->view('warehouse/edit', $data);
	}

	public function update($value='')
	{
		$this->warehouse_model->update_warehouse();
	}

	public function delete($value='')
	{
		$this->warehouse_model->delete_warehouse();
	}

	public function restore($id='')
	{
		$this->warehouse_model->restore_data();
	}
}
