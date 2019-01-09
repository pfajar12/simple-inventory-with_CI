<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publisher extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('publisher_model');
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

		$data['title'] = ucfirst('publisher');
		$data['page'] = 'publisher';

		$data['data_list'] = $this->publisher_model->get_data_list()->result();
		$data['data_count'] = $this->publisher_model->get_data_list()->num_rows();

		$data['data_list_nonactive'] = $this->publisher_model->get_data_list_nonactive()->result();
		$data['data_count_nonactive'] = $this->publisher_model->get_data_list_nonactive()->num_rows();

		$this->load->view('template/header', $data);
		$this->load->view('publisher/index');
	}

	public function get_data($value='')
	{
		$this->publisher_model->get_data();
	}

	public function get_data_nonactive($value='')
	{
		$this->publisher_model->get_data_nonactive();
	}

	public function check_exist($value='')
	{
		$this->publisher_model->check_exist_data();
	}

	public function create($value='')
	{
		$this->publisher_model->create_new_data();
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

		$data['title'] = ucfirst('publisher');
		$data['page'] = 'publisher';

		$data['data_count'] = $this->publisher_model->get_by_id($id)->num_rows();
		$data['data'] = $this->publisher_model->get_by_id($id)->row();
		$this->load->view('template/header', $data);
		$this->load->view('publisher/edit', $data);
	}

	public function update($value='')
	{
		$this->publisher_model->update_data();
	}

	public function delete($value='')
	{
		$this->publisher_model->delete_data();
	}

	public function restore($id='')
	{
		$this->publisher_model->restore_data();
	}
}
