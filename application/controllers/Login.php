<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] = & get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');

    }

    public function index()
    {
        $this->data['title_web'] = 'Login | Admin Project Management';
        $this->load->view('login_view', $this->data);
    }

    public function auth()
    {
        $user = htmlspecialchars($this->input->post('user', TRUE), ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass', TRUE), ENT_QUOTES);
        // auth
        $proses_login = $this->db->query("SELECT * FROM user WHERE user_name='$user' AND password = md5('$pass')");
        $row = $proses_login->num_rows();
        if ($row > 0) {
            $hasil_login = $proses_login->row_array();

            // create session
            $this->session->set_userdata('is_login', TRUE);
            $this->session->set_userdata('role_id', $hasil_login['role_id']);
            $this->session->set_userdata('ses_id', $hasil_login['user_id']);
            // $this->session->set_userdata('anggota_id', $hasil_login['anggota_id']);

            echo '<script>window.location="' . base_url() . 'index.php/data";</script>';
        } else {

            echo '<script>alert("Login Gagal, Periksa Kembali Username dan Password Anda");
            window.location="' . base_url() . '"</script>';
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        echo '<script>window.location="' . base_url() . '";</script>';
    }
}