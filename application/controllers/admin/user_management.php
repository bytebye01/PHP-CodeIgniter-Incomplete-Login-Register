<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_management extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
        if($this->session->userdata('u_level') != 1)
        {
            redirect('user/central_management/path_finding');
        }
        $this->load->model('user/admin_model');
        $this->load->model('user/central_model');
    }

	public function index()
	{
        print_r($_SESSION);
        $data['query']=$this->central_model->user_list();
        $user_data = $this->central_model->user_list();
        $current_user_id = $this->session->userdata('u_id');
        $current_user_data = null;

        foreach ($user_data as $user) {
            if ($user->u_id == $current_user_id) {
                $current_user_data = $user;
                break;
            }
        }

        if ($current_user_data) {
            // ส่งข้อมูลไปยัง view
            $this->load->view('css');
            $this->load->view('header');
            $this->load->view('banner');
            $this->load->view('user/js_logout');
            $this->load->view('navbar', [
                'my_u_id_session' => $current_user_id,
                'current_user_data' => $current_user_data, // เพิ่มบรรทัดนี้
            ]);
            $this->load->view('user/admin/user_insert');
            $this->load->view('user/admin/user_view', $data);
            $this->load->view('footer');
            $this->load->view('js');
        } else {
            redirect('user/central_management/path_finding');
        }
	}


    public function adduser_ajax()
    {
        // โค้ดที่คอยรับค่าจากฟอร์ม
        $ref_pid = $this->input->post('ref_pid');
        $u_username = $this->input->post('u_username');
        $u_password = $this->input->post('u_password');
        $u_fname = $this->input->post('u_fname');
        $u_lname = $this->input->post('u_lname');
        $u_email = $this->input->post('u_email');

        // ตรวจสอบความครบถ้วนของข้อมูล
        if (empty($ref_pid) || empty($u_username) || empty($u_email) || empty($u_password) || empty($u_fname) || empty($u_lname)) {
            $response = array('status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน');
        } else {
            $response = $this->admin_model->process_user_data($ref_pid, $u_username, $u_email, $u_password, $u_fname, $u_lname);
        }

        // ส่ง JSON response กลับไปที่ JavaScript
        echo json_encode($response);
    }

        public function delete_user()
        {
            $data['success'] = false;
            $data['message'] = 'ไม่สามารถลบข้อมูลได้';

            $userId = $this->input->post('id');

            // ดำเนินการลบข้อมูลจากฐานข้อมูล และส่งกลับเป็น JSON
            // (เพิ่มโค้ดลบข้อมูลตาม ID ที่รับมาจาก Ajax)

            if ($this->admin_model->delete_user($userId)) {
                $data['success'] = true;
                $data['message'] = 'ลบข้อมูลสำเร็จ';
                
            }

            echo json_encode($data);
        }

    public function user_edit($u_id)
	{
        $data['rsedit'] = $this->admin_model->user_read_all($u_id);
        $my_u_id_session = $this->session->userdata('u_id');
        $data1['my_u_id_session'] = $my_u_id_session;
        //print_r($data);
        //exit;
        $this->load->view('css');
		$this->load->view('header');
		$this->load->view('banner');
		$this->load->view('navbar',$data1);
		$this->load->view('user_edit_view', $data); 
		$this->load->view('footer');
        $this->load->view('js');
	}

    // public function editing()
	// {
    //     $this->admin_model->edituser();
    //     redirect('','refresh');
	// }
    public function editing_ajax()
    {
        $this->admin_model->edituser();
        $response['success'] = true;
        echo json_encode($response);
    }

    public function reset_password($u_id)
    {
        // ตรวจสอบว่ามีการกำหนดค่า $u_id มาหรือไม่
        if ($u_id) {
            // สร้างรหัสผ่านใหม่
            $newPassword = "123456";
            $u_time = date("Y-m-d H:i:s", time());
            // เข้ารหัสรหัสผ่านใหม่
            $hashedPassword = sha1($newPassword);
            $admin_ip = $_SERVER['REMOTE_ADDR'];
            // ดึงข้อมูล user ที่โดนเปลี่ยนรหัส
            $user_info = $this->admin_model->get_user_info($u_id);
            $username_user = $user_info->u_username;
    
            // ดึงข้อมูล admin ที่ทำการเปลี่ยนรหัส
            $username_admin = $this->session->userdata('u_fname');
    
            $logData = array(
                'lp_log' => "Reset Password",
                'lp_user' => $username_user,
                'lp_action' => $username_admin,
                'lp_action_ip' => $admin_ip
            );
    
            // เรียกใช้ฟังก์ชัน log_user_management เพื่อบันทึก log
            $this->admin_model->log_user_management($logData);
    
            // ทำการอัปเดตรหัสผ่านในฐานข้อมูล
            
            $this->db->where('u_id', $u_id);
            $this->db->update('tbl_user', array('u_password' => $hashedPassword, 'u_update' => $u_time));
    
            echo json_encode(array('status' => 'success', 'message' => 'รหัสผ่านถูกรีเซ็ตเป็น 123456'));
        } else {
            // ถ้าไม่มี $u_id ส่งมา
            echo json_encode(array('status' => 'error', 'message' => 'ไม่พบข้อมูลผู้ใช้'));
        }
    }
    
}



// public function adduser()
    // {
    //     // โค้ดที่คอยรับค่าจากฟอร์ม
    //     $u_username = $this->input->post('u_username');
    //     $u_email = $this->input->post('u_email');

    //     // เรียกใช้ฟังก์ชันเพื่อตรวจสอบ
    //     $is_username_exists = $this->member_model->is_username_exists($u_username);
    //     $is_email_exists = $this->member_model->is_email_exists($u_email);

    //     // ตรวจสอบว่า Username หรือ Email ซ้ำหรือไม่
    //     if ($is_username_exists && $is_email_exists) {
    //         // ถ้าทั้ง Username และ Email ซ้ำ
    //         echo "<script>alert('Username และ Email นี้มีอยู่แล้วในระบบ');</script>";
    //         redirect('admin_user', 'refresh');
    //     } elseif ($is_username_exists) {
    //         // ถ้า Username ซ้ำ
    //         echo "<script>alert('Username นี้มีอยู่แล้วในระบบ');</script>";
    //     } elseif ($is_email_exists) {
    //         // ถ้า Email ซ้ำ
    //         echo "<script>alert('Email นี้มีอยู่แล้วในระบบ');</script>";
    //     } else {
    //         // ถ้าไม่มีการซ้ำทั้งคู่ ทำการบันทึกข้อมูล

    //         $data = array(
    //             'ref_pid' => $this->input->post('ref_pid'),
    //             'u_username' => $u_username,
    //             'u_password' => sha1($this->input->post('u_password')),
    //             'u_fname' => $this->input->post('u_fname'),
    //             'u_lname' => $this->input->post('u_lname'),
    //             'u_email' => $u_email,
    //             // คอลัมน์อื่น ๆ ที่ต้องการบันทึก
    //         );

    //         // เรียกใช้ฟังก์ชันบันทึกข้อมูลใน Model
    //         $this->member_model->insert_user($data);
    //         echo "<script>alert('ยันทึกสำเร็จ');</script>";
    //         // Redirect หลังจากบันทึก
    //         redirect('admin_user', 'refresh');
    //     }
    // }