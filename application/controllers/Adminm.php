<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // ตรวจสอบเงื่อนไข ว่าถ้าไม่ใช่แอดมิน จะถูกรีไดเรคไปล็อกอิน
        if($this->session->userdata('u_level') != 1)
        {
            redirect('user','refresh');
        }

        $this->load->model('member_model');
        $this->load->library('encryption');
    }

    public function index()
	{
        print_r($_SESSION);
		// $data['query'] = $this->member_model->showdata8();
        $data['query1'] = $this->member_model->decrypt_c_idnumber();
        // echo '<pre>';
        // print_r ($data);
        // echo '</pre>';
        // exit;
        $this->load->view('css');
        $this->load->view('header');
        $this->load->view('banner');
        $this->load->view('navbar');
        $this->load->view('insert_view2');
        $this->load->view('member_view', $data);
        $this->load->view('footer');
        $this->load->view('js');
    }
    
}