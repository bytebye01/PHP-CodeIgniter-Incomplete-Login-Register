<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocked extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
    }

	public function index()
    {
        $currentIp = $_SERVER['REMOTE_ADDR'];
        $ipBlockData = $this->member_model->blocked_ip_list($currentIp, 'brute_force_attack');

        // ตรวจสอบว่ามีข้อมูลที่ถูกส่งไปยังหน้า View หรือไม่
        if ($ipBlockData) {
            // ส่งข้อมูลไปยัง View
            $data['ipBlockData'] = $ipBlockData;

            // โหลด View
            $this->load->view('blocked_view', $data);
        } else {
            // ถ้าไม่มีข้อมูลถูกส่งไปยังหน้า View ให้ redirect ไปที่ "user"
            redirect('', 'refresh');
        }
    }

}