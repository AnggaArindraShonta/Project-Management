<?php

defined('BASEPATH') or exit('No direct script access allowed');


class M_pic extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPic()
    {

        $this->db->select('pic.pic_id, pic.pic_name, user.user_id, user.user_name');
        $this->db->from('pic');
        $this->db->join('user', 'user.user_id = pic.user_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPicByUserID($user_id)
    {
        $this->db->select('pic.pic_id, pic.pic_name, pic.nama, user.user_id');
        $this->db->from('pic');
        $this->db->join('user', 'user.user_id = pic.user_id');
        $this->db->where('user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertPic($data)
    {

        $this->db->insert('pic', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('pic', array('pic_id' => $insert_id));

        return $result->row_array();
    }

    public function updatePic($data, $id)
    {
        $this->db->where('pic_id', $id);
        $this->db->update('pic', $data);

        $result = $this->db->get_where('pic', array('pic_id' => $id));
        return $result->row_array();
    }
    public function deletePic($id)
    {
        $result = $this->db->get_where('pic', array('pic_id' => $id));

        $this->db->where('pic_id', $id);
        $this->db->delete('pic');

        return $result->row_array();
    }

    public function cekPicExist($id)
    {
        $data = array('pic_id' => $id);

        $this->db->where($data);
        $result = $this->db->get('pic');

        if (empty($result->row_array())) {
            return false;
        }
        return true;
    }
}
