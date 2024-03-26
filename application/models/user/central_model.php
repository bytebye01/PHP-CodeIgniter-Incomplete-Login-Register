<?php
class central_model extends CI_Model {

    //===================================================================================================

    //ดึงข้อมูล user_list ไปแสดงที่ ctl admin/user_management
    public function user_list()
    {
        $this->db->select('u.u_id,u.ref_pid,u.u_username,u.u_password,u.u_fname,u.u_lname,u.u_email,u.u_datesave,u.u_img,p.pname');
        $this->db->from('tbl_user as u');
        $this->db->join('tbl_position as p', 'u.ref_pid=p.pid');
        $query=$this->db->get();
        if($query->num_rows()> 0){
            $results = $query->result();
        }
        return $results;
    }

    //===================================================================================================

    public function my_user($u_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('u_id',$u_id);
        $query=$this->db->get();
        if($query->num_rows()> 0){
            $data = $query->row();
            return $data;
        }
        return false;
    }

    //===================================================================================================

    public function my_u_id($u_id)
    {
        $my_u_id = $this->session->userdata('u_id');
        return ($u_id == $my_u_id);
    }

    //===================================================================================================

    //ฟังก์ชันการแก้ไขด้วยการเปรียบเทียบ โดยใช้ u_id นั้น ๆ ในการเปรียบเทียบจากตาราง tbl_user
    public function edituser()
    {
        if (!$this->input->post('u_id') || !$this->input->post('u_username') || !$this->input->post('u_password')) {
            redirect(base_url());
        }
        date_default_timezone_set('Asia/Bangkok');
        $u_time = date("Y-m-d H:i:s", time());
        $data = array(
            'u_username' => $this->input->post('u_username'),
            'u_password' => sha1($this->input->post('u_password')),
            'u_update' => $u_time
        );
        $this->db->where('u_id', $this->input->post('u_id'));
        $this->db->update('tbl_user', $data);

        $admin_ip = $_SERVER['REMOTE_ADDR'];
        $username_user = $this->input->post('u_username');
        $username_admin = $this->session->userdata('u_username');
        $logData = array(
            'lp_log' => "Edit User",
            'lp_user' => $username_user,
            'lp_action' => $username_admin,
            'lp_action_ip' => $admin_ip
        );
        // เรียกใช้ฟังก์ชัน log_user_management เพื่อบันทึก log
        $this->admin_model->log_user_management($logData);
    }

    //===================================================================================================

    public function editprofile()
    {
        $my_uid = $this->session->userdata('u_id');
        date_default_timezone_set('Asia/Bangkok');
        $u_time = date("Y-m-d H:i:s", time());

        // ตรวจสอบว่ามีรูปภาพเก่าหรือไม่
        $user_data = $this->db->get_where('tbl_user', array('u_id' => $my_uid))->row();
        
        if ($user_data->u_img) {
            // ถ้ามีรูปภาพเก่า ให้ลบรูปภาพเก่า
            $old_image_path = './img/' . $user_data->u_img;
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        $config['upload_path'] = './img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2000';
        $config['max_width'] = '3000';
        $config['max_height'] = '3000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('u_img')) {
            return array('status' => 'error', 'message' => $this->upload->display_errors());
        }

        $data = $this->upload->data();
        $filename = $data['file_name'];
        
        $admin_ip = $_SERVER['REMOTE_ADDR'];
        $username_admin = $this->session->userdata('u_username');
        $logData = array(
            'lp_log' => "Upload Profile Image",
            'lp_user' => $username_admin,
            'lp_action' => $username_admin,
            'lp_action_ip' => $admin_ip
        );
        // เรียกใช้ฟังก์ชัน log_user_management เพื่อบันทึก log
        $this->admin_model->log_user_management($logData);

        $data = array(
            'u_img' => $filename,
            'u_update' => $u_time
        );
        $this->db->where('u_id', $my_uid);
        $this->db->update('tbl_user', $data);
    }
}