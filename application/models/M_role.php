<?php

defined('BASEPATH') or exit('No direct script access allowed');


class M_role extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getRole()
    {
        $data = $this->db->get('role');
        return $data->result_array();
    }

    public function cekRoleExist($id)
    {
        $data = array('role_id' => $id);

        $this->db->where($data);
        $result = $this->db->get('role');

        if (empty($result->row_array())) {
            return false;
        }
        return true;
    }
}
