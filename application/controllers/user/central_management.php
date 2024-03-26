<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class central_management extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
        if ($this->session->userdata('u_level') != 1 && 
            $this->session->userdata('u_level') != 2 &&
            $this->session->userdata('u_level') != 3 &&
            $this->session->userdata('u_level') != 4) {
            redirect('');
        }
        $this->load->model('user/central_model');
    }
    public function index() 
    {
        redirect('user/central_management/path_finding');
    }
    public function path_finding() 
    {
        if (isset($_SESSION['u_level'])) {
            $u_level = $_SESSION['u_level'];
    
            if ($u_level == 1) {
                redirect('admin/user_management', 'refresh');
            } elseif ($u_level == 2) {
                redirect('boss/user_management', 'refresh');
            } elseif ($u_level == 3) {
                echo 'staffee';
            } elseif ($u_level == 4) {
                echo 'Employeee';
            } else {
                redirect('' , 'redirect'); // Redirect for unknown u_level
            }
        } else {
            redirect('' , 'redirect'); // Redirect when not logged in
        }
    }
    
    
	public function get_user_data()
    {
        $data['success'] = false;
        $data['message'] = 'ไม่สามารถดึงข้อมูลได้';
        $result = $this->central_model->user_list();
        if (!empty($result)) {
            $data['success'] = true;
            $data['message'] = 'ดึงข้อมูลสำเร็จ';
            $data['data'] = $result;
        }
        echo json_encode($data);
    }

    //Edit User ของตัวเอง
    public function my_user_edit($u_id)
	{
        $user_data = $this->central_model->user_list();
        $current_user_id = $this->session->userdata('u_id');
        $current_user_data = null;

        foreach ($user_data as $user) {
            if ($user->u_id == $current_user_id) {
                $current_user_data = $user;
                break;
            }
        }
        if (!$this->central_model->my_u_id($u_id)) {
            echo "คุณไม่ได้รับสิทธิ์ในการแก้ไขข้อมูลนี้";
            return;
        }
    
        $data['rsedit'] = $this->central_model->my_user($u_id);
        $this->load->view('css');
		$this->load->view('header');
		$this->load->view('banner');
        $this->load->view('user/js_logout');
		$this->load->view('navbar', [
            'my_u_id_session' => $current_user_id,
            'current_user_data' => $current_user_data, // เพิ่มบรรทัดนี้
        ]);
		$this->load->view('user_edit_view', $data); 
		$this->load->view('footer');
        $this->load->view('js');
	}
    public function my_profile_edit($u_id)
	{
        $user_data = $this->central_model->user_list();
        $current_user_id = $this->session->userdata('u_id');
        $current_user_data = null;

        foreach ($user_data as $user) {
            if ($user->u_id == $current_user_id) {
                $current_user_data = $user;
                break;
            }
        }
        if (!$this->central_model->my_u_id($u_id)) {
            echo "คุณไม่ได้รับสิทธิ์ในการแก้ไขข้อมูลนี้";
            return;
        }
        
    
        $data['rsedit'] = $this->central_model->my_user($u_id);
        $this->load->view('css');
		$this->load->view('header');
		$this->load->view('banner');
        $this->load->view('user/js_logout');
		$this->load->view('navbar', [
            'my_u_id_session' => $current_user_id,
            'current_user_data' => $current_user_data, // เพิ่มบรรทัดนี้
        ]);
		$this->load->view('user/upload_photo', $data); 
		$this->load->view('footer');
        $this->load->view('js');
	}

    public function editing()
	{
        $this->central_model->edituser();
        redirect('','refresh');
	}

    public function editing_ajax()
    {
        $this->load->model('user/admin_model');
        $this->central_model->edituser();
        $response['success'] = true;
        echo json_encode($response);
    }
    public function upload_no_response()
    {
        $this->load->model('user/admin_model');
        $this->central_model->upload_profile();
    }
    public function uploading_profile()
    {
        $this->load->model('user/admin_model');
        $this->central_model->editprofile();
        $response['success'] = true;
        echo json_encode($response);
    }

    public function welcome_page()
    {
        // $this->load->model('user/central_model');
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
            $data2['current_user_data'] = $current_user_data;
            $this->load->view('css');
            $this->load->view('header');
            $this->load->view('banner');
            $this->load->view('user/js_logout');
            $this->load->view('navbar', [
                'my_u_id_session' => $current_user_id,
                'current_user_data' => $current_user_data, // เพิ่มบรรทัดนี้
            ]);
            $this->load->view('welcome_view', $data2);
            $this->load->view('footer');
            $this->load->view('js');
        } else {
            redirect('user/central_management/path_finding');
        }
    }

}