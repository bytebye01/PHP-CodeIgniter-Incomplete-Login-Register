<?php
class admin_model extends CI_Model {

    

    //===================================================================================================

    //ดึงข้อมูลจาก tbl_user มาเปรียบเทียบค่า input function adduser_ajax()

    //---เปรียบเทียบ username ซ้ำกับในฐานข้อมูลหรือไม่
    public function is_username_exists($username)
    {
        $this->db->where('u_username', $username);
        $query = $this->db->get('tbl_user');
        return $query->num_rows() > 0;
    }

    //---เปรียบเทียบ email ซ้ำกับในฐานข้อมูลหรือไม่
    public function is_email_exists($email)
    {
        $this->db->where('u_email', $email);
        $query = $this->db->get('tbl_user');
        return $query->num_rows() > 0;
    }

    //===================================================================================================

    //Logs เกี่ยวกับการจัดข้อมูล user ลงในตาราง tbl_logs_management_user :: Add User, Delete User, Reset Password
    public function log_user_management($logData)
    {
        $this->db->insert('tbl_logs_management_user', $logData);
    }

    //===================================================================================================


    
    //บันทึกข้อมูล user จาก function adduser_ajax() เข้าตาราง tbl_user 

    //เก็บ Logs "Add User" เข้าตาราง tbl_logs_management_user
    // Model
    public function insert_user($data)
    {
        $admin_ip = $_SERVER['REMOTE_ADDR'];
        $username_user = $data['u_username'];
        $username_admin = $this->session->userdata('u_username');
        $logData = array(
            'lp_log' => "Add User",
            'lp_user' => $username_user,
            'lp_action' => $username_admin,
            'lp_action_ip' => $admin_ip
        );
        // เรียกใช้ฟังก์ชัน log_user_management เพื่อบันทึก log
        $this->admin_model->log_user_management($logData);
        // Insert user data into the 'tbl_user' table
        $this->db->insert('tbl_user', $data);

        // Check if the insertion was successful
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if successful
        } else {
            return false; // Return false if unsuccessful
        }
    }

    // Model
    public function process_user_data($ref_pid, $u_username, $u_email, $u_password, $u_fname, $u_lname)
    {
        // Step 1: Check if Username or Email already exists
        $is_username_exists = $this->is_username_exists($u_username);
        $is_email_exists = $this->is_email_exists($u_email);

        // Step 2: Validate completeness of user data
        if (empty($ref_pid) || empty($u_username) || empty($u_email) || empty($u_password) || empty($u_fname) || empty($u_lname)) {
            return array('status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน');
        }

        // Step 3: Check for duplicate Username or Email
        if ($is_username_exists && $is_email_exists) {
            return array('status' => 'error', 'message' => 'Username และ Email นี้มีอยู่แล้วในระบบ');
        } elseif ($is_username_exists) {
            return array('status' => 'error', 'message' => 'Username นี้มีอยู่แล้วในระบบ');
        } elseif ($is_email_exists) {
            return array('status' => 'error', 'message' => 'Email นี้มีอยู่แล้วในระบบ');
        } else {
            // Step 4: Handle image upload
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

            // Step 5: Prepare user data for insertion
            $user_data = array(
                'ref_pid' => $ref_pid,
                'u_username' => $u_username,
                'u_password' => sha1($u_password),
                'u_fname' => $u_fname,
                'u_lname' => $u_lname,
                'u_email' => $u_email,
                'u_img' => $filename
                // Add other columns if needed
            );

            // Step 6: Insert user data into the database
            $insert_result = $this->insert_user($user_data);

            // Step 7: Return appropriate response
            if ($insert_result) {
                return array('status' => 'success', 'message' => 'บันทึกข้อมูลสำเร็จ');
            } else {
                return array('status' => 'error', 'message' => 'บันทึกไม่สำเร็จ');
            }
        }
    }

    
    //===================================================================================================

    //ลบข้อมูล user ในตาราง tbl_user จากฟังก์ชัน public function delete_user() 

    //เก็บ Logs "Delete User" เข้าตาราง tbl_logs_management_user
    public function delete_user($u_id)
    {
            $admin_ip = $_SERVER['REMOTE_ADDR'];
            $user_info = $this->admin_model->get_user_info($u_id);
            $username_user = $user_info->u_username;
    
            // ดึงข้อมูล admin ที่ทำการเปลี่ยนรหัส
            $username_admin = $this->session->userdata('u_username');
    
            $logData = array(
                'lp_log' => "Delete User",
                'lp_user' => $username_user,
                'lp_action' => $username_admin,
                'lp_action_ip' => $admin_ip
            );
    
            // เรียกใช้ฟังก์ชัน log_user_management เพื่อบันทึก log
            $this->admin_model->log_user_management($logData);

        $user_data = $this->db->get_where('tbl_user', array('u_id' => $u_id))->row_array();

        // Delete the user from the database
        $delete_result = $this->db->delete('tbl_user', array('u_id' => $u_id));
    
        if ($delete_result) {
            // If the user is successfully deleted from the database, unlink the image file
            $image_path = './img/' . $user_data['u_img'];
    
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
    
            return true;
        } else {
            return false;
        }
    }


    //===================================================================================================

    //ดึงข้อมูลในตาราง tbl_user ด้วย u_id ที่รับค่ามาจาก function user_edit($u_id) และ return ค่า $data ไป
    public function user_read_all($u_id)
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

    //ฟังก์ชันการแก้ไขด้วยการเปรียบเทียบ โดยใช้ u_id นั้น ๆ ในการเปรียบเทียบจากตาราง tbl_user
    public function edituser()
    {
        if (!$this->input->post('u_id') || !$this->input->post('u_username') || !$this->input->post('u_password')) {
            redirect(base_url());
        }
        
        $data = array(
            'u_username' => $this->input->post('u_username'),
            'u_password' => sha1($this->input->post('u_password'))
        );
            
        $this->db->where('u_id', $this->input->post('u_id'));
        $this->db->update('tbl_user', $data);
    }

    //===================================================================================================

    //เอาค่า u_username ด้วยการเปรียบเทียบ u_id ในตาราง tbl_user
    public function get_user_info($u_id)
    {
        $this->db->select('u_username');
        $this->db->from('tbl_user');
        $this->db->where('u_id', $u_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    //===================================================================================================



}