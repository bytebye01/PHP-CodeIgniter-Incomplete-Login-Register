<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_management extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
        if($this->session->userdata('u_level') != 2)
        {
            redirect('user/central_management/path_finding');
        }
        $this->load->model('user/central_model');
    }

	public function index()
    {
        print_r($_SESSION);
        $data['query'] = $this->central_model->user_list();

        $my_u_id_session = $this->session->userdata('u_id');
        $data1['my_u_id_session'] = $my_u_id_session;
        
        $this->load->view('css');
		$this->load->view('header');
		$this->load->view('banner');
        $this->load->view('user/js_logout');
        $this->load->view('navbar', $data1);
        $this->load->view('user/boss/user_view', $data);
        $this->load->view('footer');
        $this->load->view('js');
    }


}