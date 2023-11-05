<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('pelanggan_model');
        $this->load->library('form_validation');

        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function index(){
        if(isset($_GET['search'])){
            $filter = array();
            if(!empty($_GET['value']) && $_GET['value'] != ''){
                $filter[$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
            }
            
            $total_row = $this->pelanggan_model->count_total_filter($filter);
            $data['pelanggans'] = $this->pelanggan_model->get_filter($filter,url_param());
        }else{
            $total_row = $this->pelanggan_model->count_total();
            $data['pelanggans'] = $this->pelanggan_model->get_all(url_param());
        }
        $data['paggination'] = get_paggination($total_row,get_search());

        $this->load->view('pelanggan/index',$data);
    }
    public function limit()
    {
        $data = [
            'data'=>$this->db->select('customer.customer_name,limit.created_at,limit.limit')->join('customer','limit.customer=customer.id')->like('limit.created_at',date("Y-m"))->get("limit")->result(),
        ];
        $this->load->view('pelanggan/limit',$data);
    }
    public function tambah_limit()
    {
        $cek = $this->db->get_where("customer",['id'=>$this->input->post('customers')]);
        if ($cek->num_rows() == 0) {
            $this->session->set_flashdata("pesan",'<div class="alert alert-danger pesan">ID Pelanggan tidak terdaftar</div>');
            redirect("pelanggan/limit");
        }else{
            $row = $cek->row();
            $new_balance = $row->limit+$this->input->post('limit');
            $save = $this->db->update("customer",['limit'=>$new_balance],['id'=>$this->input->post('customers')]);
            if ($save) {
                $this->db->insert("limit",[
                    'customer'=>$this->input->post('customers'),
                    'limit'=>$this->input->post('limit')
                ]);
            }
            $this->session->set_flashdata("pesan",'<div class="alert alert-success pesan">Data berhasil disimpan</div>');
            redirect("pelanggan/limit");
        }
    }
    public function create(){
        $code_supplier = $this->pelanggan_model->get_last_id();
        if($code_supplier){
            $id = $code_supplier[0]->id;
            $data['code_pelanggan'] = generate_code('CUST',$id,4);
        }else{
            $data['code_pelanggan'] = 'CUST0001';
        }

        $this->load->view('pelanggan/form',$data);
    }

    public function edit($id = ''){
        $check_id = $this->pelanggan_model->get_by_id($id);
        if($check_id){
            $data['pelanggan'] = $check_id[0];
            $this->load->view('pelanggan/form',$data);
        }else{
            redirect(site_url('pelanggan'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('customer_id', 'ID', 'required');
        $this->form_validation->set_rules('customer_name', 'Nama', 'required');
        $this->form_validation->set_rules('customer_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('limit', 'Limit', 'required');
        $data['id'] = escape($this->input->post('customer_id'));
        $data['customer_name'] = escape($this->input->post('customer_name'));
        $data['customer_phone'] = escape($this->input->post('customer_phone'));
        $data['customer_address'] = escape($this->input->post('customer_address'));
        $data['date'] = escape($this->input->post('customer_date'));
        $data['limit'] = escape($this->input->post('limit'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->pelanggan_model->get_by_id($id);
            if($check_id){
                unset($data['id']);
                $this->pelanggan_model->update($id,$data);
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->pelanggan_model->insert($data);
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('pelanggan/create'));
        }
        redirect(site_url('pelanggan'));
    }
    public function delete($id){
        $check_id = $this->pelanggan_model->get_by_id($id);
        if($check_id){
            $this->pelanggan_model->delete($id);
        }
        redirect(site_url('pelanggan'));
    }
    public function export_csv(){
        $filter = false;
        if(isset($_GET['search'])) {
            if (!empty($_GET['value']) && $_GET['value'] != '') {
                $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
            }
        }
        $data = $this->pelanggan_model->get_all_array($filter);
        $this->csv_library->export('pelanggan.csv',$data);
    }
}
