<?php
class Stock_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_total_stock($value='')
    {
    	$query = $this->db->get('stock');
    	return $query->num_rows();
    }

    public function get_stock_by_id_warehouse($value='')
    {
        $book   = htmlspecialchars($this->input->post('book'));
        $sender = htmlspecialchars($this->input->post('warehouse_id'));
        $qty    = htmlspecialchars($this->input->post('qty'));

        $check_stock = $this->db->query("SELECT qty FROM stock WHERE warehouse_id='$sender' AND book_id='$book'");
        $stock_count = $check_stock->num_rows();

        if($stock_count!=0){
            $get_stock = $check_stock->row();
            $stock = $get_stock->qty;
        }
        else{
            $stock = 0;
        }

        $qty_book = $stock - $qty;
        echo $qty_book;
    }

    public function get_data_list($value='')
    {
        $query = $this->db->query("SELECT a.id, a.qty, b.book_code, b.name AS book_name FROM stock a JOIN book b ON a.book_id=b.id WHERE a.warehouse_id = 1");
        return $query;
    }

    public function get_data($value='')
    {
        $query = $this->db->query("SELECT a.id, a.qty, b.book_code, b.name AS book_name FROM stock a JOIN book b ON a.book_id=b.id WHERE a.warehouse_id = 1")->result();
        echo '{"items":'. json_encode($query).'}';

    }

    public function check_exist_data($value='')
    {
        $book         = htmlspecialchars($this->input->post('book'));
        $qty          = htmlspecialchars($this->input->post('qty'));
        $warehouse_id = htmlspecialchars($this->input->post('warehouse_id'));

        $check_exist = $this->db->query("SELECT id FROM stock WHERE warehouse_id='$warehouse_id' AND book_id='$book'")->num_rows();
        
        if($check_exist==0){
            $this->insert_new_stock($book, $qty, $warehouse_id);
        }
        else{
            $this->update_stock($book, $qty, $warehouse_id);
        }
    }

    public function insert_new_stock($book='', $qty='', $warehouse_id='')
    {
        $insert_into_stock = $this->db->query("INSERT INTO stock(warehouse_id, book_id, qty) VALUES('$warehouse_id', '$book', '$qty')");

        $insert_into_stockcard = $this->db->query("INSERT INTO stockcard(warehouse_id, qty_in, note, user_id, book_id) VALUES('$warehouse_id', '$qty', 'inventory in from publisher', '".$this->session->userdata('id')."', '$book')");

        if($insert_into_stock && $insert_into_stockcard){
            echo 'success';
        }
    }

    public function update_stock($book='', $qty='', $warehouse_id='')
    {
        $current_stock = $this->db->query("SELECT qty FROM stock WHERE warehouse_id='$warehouse_id' AND book_id='$book'")->row();
        $new_stock = $current_stock->qty + $qty;

        $update_stock = $this->db->query("UPDATE stock SET qty='$new_stock' WHERE book_id='$book' AND warehouse_id='$warehouse_id'");

        $insert_into_stockcard = $this->db->query("INSERT INTO stockcard(warehouse_id, qty_in, note, user_id, book_id) VALUES('$warehouse_id', '$qty', 'inventory in from publisher', '".$this->session->userdata('id')."', '$book')");

        if($update_stock && $insert_into_stockcard){
            echo 'success';
        }
    }

    public function books_distributing($value='')
    {
        $book         = htmlspecialchars($this->input->post('book'));
        $qty          = htmlspecialchars($this->input->post('qty'));
        $sender       = htmlspecialchars($this->input->post('sender'));
        $destination  = htmlspecialchars($this->input->post('destination'));

        $get_destination = $this->db->query("SELECT name FROM warehouse WHERE id='$destination'")->row();

        $sender_current_stock_check = $this->db->query("SELECT qty FROM stock WHERE warehouse_id='$sender' AND book_id='$book'");
        $destination_current_stock_check = $this->db->query("SELECT qty FROM stock WHERE warehouse_id='$destination' AND book_id='$book'");

        $sender_exist_stock = $sender_current_stock_check->num_rows();
        $destination_exist_stock = $destination_current_stock_check->num_rows();

        // sender current stock
        if($sender_exist_stock==1){
            $sender_stock_qty = $sender_current_stock_check->row()->qty;
        }
        else{
            $sender_stock_qty = 0;
        }

        // destination current stock
        if($destination_exist_stock==1){
            $destination_stock_qty = $destination_current_stock_check->row()->qty;
        }
        else{
            $destination_stock_qty = 0;
        }

        $sender_newstock = $sender_stock_qty - $qty;
        $destination_newstock = $destination_stock_qty + $qty;

        // SENDER
        if($sender_stock_qty<=0 || $sender_stock_qty<$qty){
            return null;
        }
        else{
            // stock
            $sender_update_stock = $this->db->query("UPDATE stock SET qty='$sender_newstock' WHERE book_id='$book' AND warehouse_id='$sender'");

            // stockcard
            $sender_insert_into_stockcard = $this->db->query("INSERT INTO stockcard(warehouse_id, qty_out, note, user_id, book_id) VALUES('$sender', '$qty', 'send stock to ".$get_destination->name."', '".$this->session->userdata('id')."', '$book')");
        }

        // DESTINATION
        if($destination_stock_qty==0){
            // stock
            $insert_into_stock = $this->db->query("INSERT INTO stock(warehouse_id, book_id, qty) VALUES('$destination', '$book', '$qty')");
        }
        else{
            // stock
            $destination_update_stock = $this->db->query("UPDATE stock SET qty='$destination_newstock' WHERE book_id='$book' AND warehouse_id='$destination'");

        }
        // stockcard
        $destination_insert_into_stockcard = $this->db->query("INSERT INTO stockcard(warehouse_id, qty_in, note, book_id) VALUES('$destination', '$qty', 'accept stock from distribution centre', '$book')");

        echo 'success';
    }

    public function get_stock_per_warehouse($value='')
    {
        $warehouse_id = htmlspecialchars($this->input->post('warehouse_id'));
        
        $query = $this->db->query("SELECT a.qty, b.book_code, b.name AS book_name FROM stock a JOIN book b ON a.book_id=b.id WHERE a.warehouse_id='$warehouse_id'")->result();
        echo '{"items":'. json_encode($query).'}';
    }
}