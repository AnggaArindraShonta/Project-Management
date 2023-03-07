<?php

defined('BASEPATH') or exit('No direct script access allowed');


class M_pma extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getPma()
    {

        $this->db->select('pma.pma_id, pma.pma_name, pic.pic_id, user.user_id');
        $this->db->from('pma');
        $this->db->join('pic', 'pic.pic_id = pma.pma_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPmaByPicID($pic_id)
    {
        $this->db->select('pma.pma_id, pma.pma_name, pic.pic_id, user.user_id');
        $this->db->from('pma');
        $this->db->join('pic', 'pic.pic_id = pma.pma_id');
        $this->db->where('pic.pic_id', $pic_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertPma($data)
    {

        $this->db->insert('pma', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('pma', array('pma_id' => $insert_id));

        return $result->row_array();
    }

    public function updatePma($data, $id)
    {
        $this->db->where('pma_id', $id);
        $this->db->update('pma', $data);

        $result = $this->db->get_where('pma', array('pma_id' => $id));
        return $result->row_array();
    }
    public function deletePma($id)
    {
        $result = $this->db->get_where('pma', array('pma_id' => $id));

        $this->db->where('pma_id', $id);
        $this->db->delete('pma');

        return $result->row_array();
    }

    public function cekPmaExist($id)
    {
        $data = array('pma_id' => $id);

        $this->db->where($data);
        $result = $this->db->get('pma');

        if (empty($result->row_array())) {
            return false;
        }
        return true;
    }
}
