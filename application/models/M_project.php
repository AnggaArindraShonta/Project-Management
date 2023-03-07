<?php

defined('BASEPATH') or exit('No direct script access allowed');


class M_project extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getProject()
    {

        $this->db->select('project.project_id, project.project_name, DATE_FORMAT(project.start_date, "%d %M %Y") AS start_date, DATE_FORMAT(project.end_date, "%d %M %Y") AS end_date, project.project_description, project.project_picture,user.user_name as member,pic.pic_name');
        $this->db->from('project');
        $this->db->join('user', 'user.user_id = project.member');
        $this->db->join('pic','pic.pic_id = project.pic_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProjectMember($user_id)
    {
      $this->db->select('project.project_id, project.project_name, DATE_FORMAT(project.start_date, "%d %M %Y") AS start_date, DATE_FORMAT(project.end_date, "%d %M %Y") AS end_date, project.project_description, project.project_picture,user.user_name,pic.pic_name');
        $this->db->from('project');
        $this->db->join('user', 'user.user_id = project.member');
        $this->db->join('pic','pic.pic_id = project.pic_id');

        $this->db->where('project.member', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProjectBulanIni()
    {
        $this->db->select('project.project_id, project.project_name, project.start_date, project.end_date, project.project_description, project.project_picture, pic.pic_id');
        $this->db->from('project');
        $this->db->join('pic', 'pic.pic_id = project.project_id');
        $this->db->where('month(start_date)', date('m'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertProject($data)
    {

        $this->db->insert('project', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('project', array('project_id' => $insert_id));

        return $result->row_array();
    }

    public function updateProject($data, $id)
    {
        $this->db->where('project_id', $id);
        $this->db->update('project', $data);

        $result = $this->db->get_where('project', array('project_id' => $id));
        return $result->row_array();
    }
    public function deleteProject($id)
    {
        $result = $this->db->get_where('project', array('project_id' => $id));

        $this->db->where('project_id', $id);
        $this->db->delete('project');

        return $result->row_array();
    }

    public function cekProjectExist($id)
    {
        $data = array('project_id' => $id);

        $this->db->where($data);
        $result = $this->db->get('project');

        if (empty($result->row_array())) {
            return false;
        }
        return true;
    }
}
