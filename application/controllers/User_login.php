<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_login extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('user/login_model');
    }

	public function index()
	{
        print_r($_SESSION);

		$this->load->view('mycss');
		$this->load->view('login/login_form');
	}
    
    public function login_checking()
    {
        if($this->input->post('u_username')==''){
            $this->session->unset_userdata('u_id');
            $this->session->unset_userdata('u_level');
            $this->session->unset_userdata('u_fname');
            $this->session->unset_userdata('u_username');
            redirect('','refresh');
            
        } else {
            echo '<pre>';
            print_r($this->input->post());
            echo '</pre>';

            $currentIp = $_SERVER['REMOTE_ADDR'];
            $ipBlockData = $this->login_model->blocked_ip_list($currentIp, 'brute_force_attack');
            if ($ipBlockData) {
                // ถ้า IP ถูกบล็อกในตาราง
                $this->session->unset_userdata('login_attempts');
                redirect('security/Blocked','refresh');
            }


            // exit;
            $result = $this->login_model->fetch_user_login(
                $this->input->post('u_username'),
                sha1($this->input->post('u_password'))
            );
            
            print_r($result);

            // exit;

            if(!empty($result)){
                $sess=array(
                    'u_id'         => $result->u_id,
                    'u_level'      => $result->ref_pid,
                    'u_fname'      => $result->u_fname,
                    'u_username'   => $result->u_username
                );
                echo '<br>';
                print_r($sess);
                //exit;

                $this->session->set_userdata($sess);
                $this->session->unset_userdata('login_attempts');
                $check_ip = $_SERVER['REMOTE_ADDR'];
                $logsData = array(
                    'll_log' => "Login",
                    'll_status' => "Success",
                    'll_username' => $this->session->userdata('u_username'),
                    'll_password' => "-",
                    'll_ip_check' => $check_ip
                );
                $this->login_model->log_loging($logsData);

                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                print_r($_SESSION);

                $u_level = $_SESSION['u_level'];

                //echo ' level '.$u_level;
                echo '<hr>';
                if($u_level==1)
                {
                    redirect('admin/user_management', 'refresh');
                } elseif ($u_level==2){
                    redirect('boss/user_management', 'refresh');
                }elseif ($u_level==3){
                    echo 'staffee';
                }elseif ($u_level==4){
                    echo 'Employeee';
                }
            } else {
                $check_ip = $_SERVER['REMOTE_ADDR'];
                $logsData = array(
                    'll_log' => "Login",
                    'll_status' => "Fail",
                    'll_username' => $this->input->post('u_username'),
                    'll_password' => $this->input->post('u_password'),
                    'll_ip_check' => $check_ip
                );
                $this->login_model->log_loging($logsData);
                $this->session->unset_userdata(array('u_id', 'u_level', 'u_fname', 'u_username'));

                // บันทึกจำนวนครั้งที่เข้าสู่ระบบผิดพลาด
                $loginAttempts = $this->session->userdata('login_attempts');
                $loginAttempts = ($loginAttempts) ? $loginAttempts + 1 : 1;
                $this->session->set_userdata('login_attempts', $loginAttempts);

                // ตรวจสอบจำนวนครั้งที่เข้าสู่ระบบผิดพลาด
                if ($loginAttempts >= 5) {
                    // ถ้าเข้าสู่ระบบผิดพลาดครบ 5 ครั้ง ให้บล็อก IP
                    // $this->session->set_userdata('Blocked_IP', true);

                    // ตั้งค่าให้ IP ถูกบล็อกเป็นเวลา 10 วินาที
                    // $this->session->set_tempdata('Blocked_IP', true, 10);
                    $logDangerIP = array(
                        'lib_activity' => "brute_force_attack",
                        'lib_ip' => $check_ip,
                        'lib_bfa_username' => $this->input->post('u_username')
                    );
                    $this->login_model->log_block_ip($logDangerIP);
            
                }
                redirect('');
            }
        }
    }
    public function logout()
    {
        $check_ip = $_SERVER['REMOTE_ADDR'];
        // $user_info =  $this->session->userdata('u_id');
        // $username_user = $user_info->u_username;
        $logsData = array(
            'll_log' => "Logout",
            'll_status' => "-",
            'll_username' => $this->session->userdata('u_username'),
            'll_password' => "-",
            'll_ip_check' => $check_ip
        );
        
        // เรียกใช้ฟังก์ชัน log_password เพื่อบันทึก log
        $this->login_model->log_loging($logsData);

        $this->session->unset_userdata('u_id');
        $this->session->unset_userdata('u_level');
        $this->session->unset_userdata('u_fname');
        $this->session->unset_userdata('u_username');
        // $this->session->unset_userdata('failed_login_attempts');
        // $this->session->unset_userdata('locked_ips');
        $this->session->unset_userdata('login_attempts');
        
        redirect('','refresh');
    }
    
}

// public function check()
    // {
    //     // echo '<pre>';
    //     // print_r($_POST);
    //     // echo '</pre>';
    //     // exit;

    //     $u_username=$this->input->post('u_username');
    //     $u_password=$this->input->post('u_password');

    //     // echo 'user = ' .$m_username;
    //     // echo '<br>';
    //     // echo 'pass = ' .$m_password;
    //     // exit;
    //     if($u_username=='admin' && $u_password=='admin'){
    //         //จำลองการเป็นแอดมิน เมื่อกรอก admin & admin จะทำให้ level = admin
    //         $this->session->set_userdata('u_level', 'admin');
    //         print_r($_SESSION);
    //         redirect('admin','refresh');
    //     }else{
    //         print_r($_SESSION);
    //         redirect('admin','refresh');
    //         // echo 'wrong wrong wrong';
    //     }
    // }