<?php
// defined('BASEPATH') OR exit('No direct script access allowed');



// class Admin_user extends CI_Controller {
// 	public function __construct()
//     {
//         parent::__construct();
//         if($this->session->userdata('u_level') != 1)
//         {
//             redirect('user','refresh');
//         }
//         $this->load->model('member_model');
//     }






// 	public function index()
// 	{
//         print_r($_SESSION);
//         $data['query']=$this->member_model->list_user();
//         // echo '<pre>';
//         // print_r($data);
//         // echo '</pre>';
//         // exit;
// 		$this->load->view('css');
//         $this->load->view('header');
//         $this->load->view('banner');
//         $this->load->view('navbar');
//         $this->load->view('admin/Admin_user_insertview');
//         $this->load->view('user_view', $data);
//         $this->load->view('footer');
//         $this->load->view('js');
// 	}
//     public function adduser()
//     {
//         // โค้ดที่คอยรับค่าจากฟอร์ม
//         $u_username = $this->input->post('u_username');
//         $u_email = $this->input->post('u_email');

//         // เรียกใช้ฟังก์ชันเพื่อตรวจสอบ
//         $is_username_exists = $this->member_model->is_username_exists($u_username);
//         $is_email_exists = $this->member_model->is_email_exists($u_email);

//         // ตรวจสอบว่า Username หรือ Email ซ้ำหรือไม่
//         if ($is_username_exists && $is_email_exists) {
//             // ถ้าทั้ง Username และ Email ซ้ำ
//             echo "<script>alert('Username และ Email นี้มีอยู่แล้วในระบบ');</script>";
//             redirect('admin_user', 'refresh');
//         } elseif ($is_username_exists) {
//             // ถ้า Username ซ้ำ
//             echo "<script>alert('Username นี้มีอยู่แล้วในระบบ');</script>";
//         } elseif ($is_email_exists) {
//             // ถ้า Email ซ้ำ
//             echo "<script>alert('Email นี้มีอยู่แล้วในระบบ');</script>";
//         } else {
//             // ถ้าไม่มีการซ้ำทั้งคู่ ทำการบันทึกข้อมูล

//             $data = array(
//                 'ref_pid' => $this->input->post('ref_pid'),
//                 'u_username' => $u_username,
//                 'u_password' => sha1($this->input->post('u_password')),
//                 'u_fname' => $this->input->post('u_fname'),
//                 'u_lname' => $this->input->post('u_lname'),
//                 'u_email' => $u_email,
//                 // คอลัมน์อื่น ๆ ที่ต้องการบันทึก
//             );

//             // เรียกใช้ฟังก์ชันบันทึกข้อมูลใน Model
//             $this->member_model->insert_user($data);
//             echo "<script>alert('ยันทึกสำเร็จ');</script>";
//             // Redirect หลังจากบันทึก
//             redirect('admin_user', 'refresh');
//         }
//     }
//     public function adduser_ajax()
//     {
//         // โค้ดที่คอยรับค่าจากฟอร์ม
//         $ref_pid = $this->input->post('ref_pid');
//         $u_username = $this->input->post('u_username');
//         $u_password = $this->input->post('u_password');
//         $u_fname = $this->input->post('u_fname');
//         $u_lname = $this->input->post('u_lname');
//         $u_email = $this->input->post('u_email');
    
//         // ตรวจสอบความครบถ้วนของข้อมูล
//         if (empty($ref_pid) ||empty($u_username) || empty($u_email) || empty($u_password) || empty($u_fname)|| empty($u_lname)) {
//             // ถ้าไม่ครบถ้วน
//             $response = array('status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน');
//         } else {
//             // เรียกใช้ฟังก์ชันเพื่อตรวจสอบ
//             $is_username_exists = $this->member_model->is_username_exists($u_username);
//             $is_email_exists = $this->member_model->is_email_exists($u_email);
    
//             // ตรวจสอบว่า Username หรือ Email ซ้ำหรือไม่
//             if ($is_username_exists && $is_email_exists) {
//                 // ถ้าทั้ง Username และ Email ซ้ำ
//                 $response = array('status' => 'error', 'message' => 'Username และ Email นี้มีอยู่แล้วในระบบ');
//             } elseif ($is_username_exists) {
//                 // ถ้า Username ซ้ำ
//                 $response = array('status' => 'error', 'message' => 'Username นี้มีอยู่แล้วในระบบ');
//             } elseif ($is_email_exists) {
//                 // ถ้า Email ซ้ำ
//                 $response = array('status' => 'error', 'message' => 'Email นี้มีอยู่แล้วในระบบ');
//             } else {
//                 // ถ้าไม่มีการซ้ำทั้งคู่ ทำการบันทึกข้อมูล
//                 $data = array(
//                     'ref_pid' => $this->input->post('ref_pid'),
//                     'u_username' => $u_username,
//                     'u_password' => sha1($this->input->post('u_password')),
//                     'u_fname' => $this->input->post('u_fname'),
//                     'u_lname' => $this->input->post('u_lname'),
//                     'u_email' => $u_email,
//                     // คอลัมน์อื่น ๆ ที่ต้องการบันทึก
//                 );
    
//                 // เรียกใช้ฟังก์ชันบันทึกข้อมูลใน Model
//                 $insert_result = $this->member_model->insert_user($data);
    
//                 if ($insert_result) {
//                     $response = array('status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ');
//                 } else {
//                     $response = array('status' => 'error', 'message' => 'บันทึกไม่สำเร็จ');
//                 }
//             }
//         }
    
//         // ส่ง JSON response กลับไปที่ JavaScript
//         echo json_encode($response);
//     }
//     public function get_user_data()
//     {
//         $data['success'] = false;
//         $data['message'] = 'ไม่สามารถดึงข้อมูลได้';

//         // ดึงข้อมูลจากฐานข้อมูล และส่งกลับเป็น JSON
//         $result = $this->member_model->list_user();

//         if (!empty($result)) {
//             $data['success'] = true;
//             $data['message'] = 'ดึงข้อมูลสำเร็จ';
//             $data['data'] = $result;
//         }

//         echo json_encode($data);
//     }
//     public function delete_user()
//     {
//         $data['success'] = false;
//         $data['message'] = 'ไม่สามารถลบข้อมูลได้';

//         $userId = $this->input->post('id');

//         // ดำเนินการลบข้อมูลจากฐานข้อมูล และส่งกลับเป็น JSON
//         // (เพิ่มโค้ดลบข้อมูลตาม ID ที่รับมาจาก Ajax)

//         if ($this->member_model->delete_user($userId)) {
//             $data['success'] = true;
//             $data['message'] = 'ลบข้อมูลสำเร็จ';
            
//         }

//         echo json_encode($data);
//     }
//     public function user_edit($u_id)
// 	{
//         $data['rsedit'] = $this->member_model->user_read($u_id);

//         //print_r($data);
//         //exit;
//         $this->load->view('css');
// 		$this->load->view('header');
// 		$this->load->view('banner');
// 		$this->load->view('navbar');
// 		$this->load->view('user_edit_view', $data); 
// 		$this->load->view('footer');
//         $this->load->view('js');
// 	}
//     public function editing()
// 	{
//         $this->member_model->edituser();
//         redirect('','refresh');
// 	}
//     public function editing_ajax()
//     {
//         $this->member_model->edituser();
//         $response['success'] = true;
//         echo json_encode($response);
//     }
//     public function reset_password($u_id)
//     {
//         // ตรวจสอบว่ามีการกำหนดค่า $u_id มาหรือไม่
//         if ($u_id) {
//             // สร้างรหัสผ่านใหม่
//             $newPassword = "123456";
    
//             // เข้ารหัสรหัสผ่านใหม่
//             $hashedPassword = sha1($newPassword);
//             $admin_ip = $_SERVER['REMOTE_ADDR'];
//             // ดึงข้อมูล user ที่โดนเปลี่ยนรหัส
//             $user_info = $this->member_model->get_user_info($u_id);
//             $username_user = $user_info->u_username;
    
//             // ดึงข้อมูล admin ที่ทำการเปลี่ยนรหัส
//             $username_admin = $this->session->userdata('u_fname');
    
//             $logData = array(
//                 'lp_log' => "Reset Password",
//                 'lp_user' => $username_user,
//                 'lp_admin' => $username_admin,
//                 'lp_admin_ip' => $admin_ip
//             );
    
//             // เรียกใช้ฟังก์ชัน log_password เพื่อบันทึก log
//             $this->member_model->log_password($logData);
    
//             // ทำการอัปเดตรหัสผ่านในฐานข้อมูล
//             $this->db->where('u_id', $u_id);
//             $this->db->update('tbl_user', array('u_password' => $hashedPassword));
    
//             echo json_encode(array('status' => 'success', 'message' => 'รหัสผ่านถูกรีเซ็ตเป็น 123456'));
//         } else {
//             // ถ้าไม่มี $u_id ส่งมา
//             echo json_encode(array('status' => 'error', 'message' => 'ไม่พบข้อมูลผู้ใช้'));
//         }
//     }
// }
//backup for admin/user_management