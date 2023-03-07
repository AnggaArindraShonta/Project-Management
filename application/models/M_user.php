<?php

defined('BASEPATH') or exit('No direct script access allowed');


class M_user extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUser()
    {

        // $this->db->select('user.user_id, user.user_name, user.user_email, user.password, role.role_id');
        $this->db->from('user');
        // $this->db->join('role', 'role.role_id = user.role_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserByRoleID($role_id)
    {
        $this->db->select('user.user_id, user.user_name, user.user_email, user.password, role.role_id');
        $this->db->from('user');
        $this->db->join('role', 'role.role_id = user.role_id');
        $this->db->where('role.role_id', $role_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertUser($data)
    {

        $this->db->insert('user', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('user', array('user_id' => $insert_id));

        return $result->row_array();
    }

    public function updateUser($data, $id)
    {
        $this->db->where('user_id', $id);
        $this->db->update('user', $data);

        $result = $this->db->get_where('user', array('user_id' => $id));
        return $result->row_array();
    }
    public function deleteUser($id)
    {
        $result = $this->db->get_where('user', array('user_id' => $id));

        $this->db->where('user_id', $id);
        $this->db->delete('user');

        return $result->row_array();
    }

    public function cekLoginUser($data)
    {
        $this->db->where($data);
        $result = $this->db->get('user');

        return $result->row_array();
    }

    public function cekUserExist($id)
    {
        $data = array('user_id' => $id);

        $this->db->where($data);
        $result = $this->db->get('user');

        if (empty($result->row_array())) {
            return false;
        }
        return true;
    }
}
