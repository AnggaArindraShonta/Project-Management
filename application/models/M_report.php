<?php

defined('BASEPATH') or exit('No direct script access allowed');


class M_report extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getReport()
    {

        $this->db->select('report.report_id, report.report_progress, report.ket_nota, report.ket_progress,report.report_nota, report.report_date,report.report_time,report.project_id, project.project_name, user.user_name');
        $this->db->from('report');
        $this->db->join('project', 'project.project_id = report.project_id');
        $this->db->join('user', 'user.user_id = project.member');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getReportByMember($user_id)
    {
        // $this->db->select('report.report_id, report.report_progress, report.report_nota, report.report_date, report.report_time, report.project_id, project.project_name');
        // $this->db->from('report');
        // // $this->db->join('user', 'user.user_id = report.member');
        // $this->db->join('project', 'project.project_id = report.project_id');
        // // $this->db->join('project', 'project.project_id = report.project_id');
        // $this->db->join('user', 'member.project_id = project.project_id');
        // $this->db->where('member.user_id', $user_id);
        // // $this->db->where('report.member', $user_id);
        $this->db->select('report.report_id, report.report_progress, report.ket_nota, report.ket_progress,report.report_nota, report.report_date,report.report_time,report.project_id, project.project_name, user.user_name');
        $this->db->from('report');
        $this->db->join('project', 'project.project_id = report.project_id');
        $this->db->join('user', 'user.user_id = project.member');
        $this->db->where('user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getReportByPmaID($pma_id)
    {
        $this->db->select('report.report_id, report.report_progress, report.project_nota, report.report_date, report.report_time, pma.pma_id, project.project_id');
        $this->db->from('report');
        $this->db->join('pma', 'pma.pma_id = report.pma_id');
        $this->db->where('pma.pma', $pma_id);
        $query = $this->db->get();
        die($query);
        return $query->result_array();
    }

    public function getReportBulanIni()
    {
        $this->db->select('report.report_id, report.report_progress, report.project_nota, report.report_date, report.report_time, pma.pma_id, project.project_id');
        $this->db->from('report');
        $this->db->join('project', 'project.project_id = report.report_id');
        $this->db->where('month(report_date)', date('m'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertReport($data)
    {

        $this->db->insert('project', $data);
        $insert_id = $this->db->insert_id();
        $result = $this->db->get_where('project', array('project_id' => $insert_id));

        return $result->row_array();
    }

    public function updateReport($data, $id)
    {
        $this->db->where('project_id', $id);
        $this->db->update('project', $data);

        $result = $this->db->get_where('project', array('project_id' => $id));
        return $result->row_array();
    }
    public function deleteReport($id)
    {
        $result = $this->db->get_where('project', array('project_id' => $id));

        $this->db->where('project_id', $id);
        $this->db->delete('project');

        return $result->row_array();
    }

    public function cekReportExist($id)
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