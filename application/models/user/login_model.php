<?php
class login_model extends CI_Model {

    //===================================================================================================
    
    //รับค่าจาก function login_checking() ตรวจสอบ IP ที่เข้าสู่ระบบว่าตรงกับในฐานข้อมูล tbl_logs_ip_block หรือไม่ และดำเนินการต่อไป
    public function blocked_ip_list($ip, $activity)
    {
        $this->db->where('lib_ip', $ip);
        $this->db->where('lib_activity', $activity);
        $query = $this->db->get('tbl_logs_ip_block');
        return $query->row();
    }

    //===================================================================================================
    
    //ตรวจสอบ username,password ที่กรอกเข้ามา กับข้อมูลในตาราง tbl_user แล้วส่งค่ากลับไป
    public function fetch_user_login($u_username,$u_password)
    {
        $this->db->where('u_username',$u_username);
        $this->db->where('u_password',$u_password);
        $query = $this->db->get('tbl_user');
        return $query->row();
    }

    //===================================================================================================

    //Logs เกี่ยวกับ เข้าสู่ระบบ, ออกจากระบบของ user ลงในตาราง tbl_logs_loging :: Login, Logout, (Success, Fail)
    public function log_loging($logsData)
    {
        $this->db->insert('tbl_logs_loging', $logsData);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    //===================================================================================================

    //Logs เก็บ IP ที่มีกิจกรรมที่เป็นภัยต่อเว็บไซต์ โดย IP ที่ถูกบันทึกลงในตาราง tbl_logs_ip_block จะไม่สามารถเข้าใช้งานเว็บไซต์ได้ 
    //ตามเงื่อนไขการตรวจสอบจาก  function login_checking() - if ($ipBlockData)

    //brute_force_attack
    //เมื่อมีการพยายามเข้าสู่ระบบมากเกินไป โดยจะใช้ตัวแปร $loginAttempts ในการเก็บการกรอกข้อมูล user ผิด เมื่อกรอกผิดครบ 5 ครั้ง IP จะถูกเก็บเข้าตาราง tbl_logs_ip_block
    public function log_block_ip($logDangerIP)
    {
        $this->db->insert('tbl_logs_ip_block', $logDangerIP);
        return ($this->db->affected_rows() > 0) ? true : false;
    }
    
    //===================================================================================================

}