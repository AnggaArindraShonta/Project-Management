<?php

defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');
require APPPATH . '/libraries/Firebase/JWT/JWT.php';

use \Firebase\JWT\JWT;

use Restserver\Libraries\REST_Controller;

class Api_gmp extends REST_Controller
{

    private $secret_key = "dsagdfg4353rtregmfdgo";

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_role');
        $this->load->model('M_user');
        $this->load->model('M_pic');
        $this->load->model('M_pma');
        $this->load->model('M_project');
        $this->load->model('M_report');
    }
    public function index_get()
    {
        $this->load->view('create_project');
    }


    public function role_get()
    {
        $result = $this->M_role->getRole();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "role" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    // // API Role End

    public function user_get()
    {
        $result = $this->M_user->getUser();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "user" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function user_by_role_id_get()
    {
        $this->cekToken();

        $result = $this->M_user->getUserByRoleID($this->input->get('role_id'));

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "user" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function user_post()
    {
        //Validasi
        $validation_message = [];

        if ($this->input->post("user_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->input->post("user_email") == "") {
            array_push($validation_message, "Email tidak boleh kosong");
        }

        if ($this->input->post("user_email") != "" && !filter_var($this->input->post("user_email"), FILTER_VALIDATE_EMAIL)) {
            array_push($validation_message, "Format Email tidak valid");
        }

        if ($this->input->post("password") == "") {
            array_push($validation_message, "Password tidak boleh kosong");
        }

        if ($this->input->post("role_id") == "") {
            array_push($validation_message, "Role ID tidak boleh kosong");
        }

        if ($this->input->post("role_id") != "" && !$this->M_role->cekRoleExist($this->input->post("role_id"))) {
            array_push($validation_message, "Role ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "user_name" => $this->input->post("user_name"),
            "user_email" => $this->input->post("user_email"),
            "password" => md5($this->input->post("password")),
            "role_id" => $this->input->post("role_id")
        );

        $result = $this->M_user->insertUser($data);

        $data_json = array(
            "success" => true,
            "message" => "Insert Berhasil",
            "data" => array(
                "user" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }


    public function user_put()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($this->put("user_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->put("user_email") == "") {
            array_push($validation_message, "Email tidak boleh kosong");
        }

        if ($this->put("user_email") != "" && !filter_var($this->put("user_email"), FILTER_VALIDATE_EMAIL)) {
            array_push($validation_message, "Format Email tidak valid");
        }

        if ($this->put("password") == "") {
            array_push($validation_message, "Password tidak boleh kosong");
        }

        if ($this->put("role_id") == "") {
            array_push($validation_message, "Role ID tidak boleh kosong");
        }

        if ($this->put("role_id") != "" && !$this->M_role->cekRoleExist($this->put("role_id"))) {
            array_push($validation_message, "Role ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "user_name" => $this->put("user_name"),
            "user_email" => $this->put("user_email"),
            "password" => md5($this->put("password")),
            "role_id" => $this->put("role_id")
        );

        $id = $this->put("user_id");

        $result = $this->M_user->updateUser($data, $id);

        $data_json = array(
            "success" => true,
            "message" => "Update Berhasil",
            "data" => array(
                "user" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }
    }
    public function user_delete()
    {
        $this->cekToken();

        $id = $this->delete("user_id");

        $result = $this->M_user->deleteUser($id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "user" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function user_by_role_id_delete()
    {
        $this->cekToken();

        $role_id = $this->delete("role_id");

        $result = $this->M_user->deleteUserByRoleID($role_id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "user" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function login_post()
    {
        $data = array(
            "user_name" => $this->input->post("user_name"),
            "user_email" => $this->input->post("user_email"),
            "password" => md5($this->input->post("password"))
        );

        $result = $this->M_user->cekLoginUser($data);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "error_code" => 1308,
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        } else {
            $date = new Datetime();

            $payload["user_id"] = $result["user_id"];
            $payload["user_name"] = $result["user_name"];
            $payload["user_email"] = $result["user_email"];
            $payload["iat"] = $date->getTimestamp();
            $payload["exp"] = $date->getTimestamp() + 3600;

            $data_json = array(
                "success" => true,
                "message" => "Otentikasi Berhasil",
                "data" => array(
                    "user" => $result,
                    "token" => JWT::encode($payload, $this->secret_key)
                )


            );

            $this->session->set_userdata('logged_in', true); // set session logged_in
            $this->response($data_json, REST_Controller::HTTP_OK);
            //     $this->session->set_userdata('logged_in', true); // set session logged_in
            // $this->load->view('dashboard');
        }
    }
    // // API User End

    // // API Pic Start
    public function pic_get()
    {
        $this->cekToken();

        $result = $this->M_pic->getPic();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "pic" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pic_by_user_id_get()
    {
        $this->cekToken();

        $result = $this->M_pic->getPicByUserID($this->input->get('user_id'));

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "pic" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pic_post()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($this->input->post("pic_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->input->post("user_id") == "") {
            array_push($validation_message, "User ID tidak boleh kosong");
        }

        if ($this->input->post("user_id") != "" && !$this->M_user->cekUserExist($this->input->post("user_id"))) {
            array_push($validation_message, "User ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "pic_name" => $this->input->post("pic_name"),
            "user_id" => $this->input->post("user_id")
        );

        $result = $this->M_pic->insertPic($data);

        $data_json = array(
            "success" => true,
            "message" => "Insert Berhasil",
            "data" => array(
                "pic" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pic_put()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($this->put("pic_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->put("user_id") == "") {
            array_push($validation_message, "User ID tidak boleh kosong");
        }

        if ($this->put("user_id") != "" && !$this->M_user->cekUserExist($this->put("user_id"))) {
            array_push($validation_message, "User ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "pic_name" => $this->put("pic_name"),
            "user_id" => $this->put("user_id")
        );

        $id = $this->put("pic_id");

        $result = $this->M_pic->updatePic($data, $id);

        $data_json = array(
            "success" => true,
            "message" => "Update Berhasil",
            "data" => array(
                "pic" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }
    }

    public function pic_delete()
    {
        $this->cekToken();

        $id = $this->delete("pic_id");

        $result = $this->M_pic->deletePic($id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "pic" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pic_by_user_id_delete()
    {
        $this->cekToken();

        $user_id = $this->delete("user_id");

        $result = $this->M_user->deletePicByUserID($user_id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "pic" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    // // API Pic End

    // // API Pma Start
    public function pma_get()
    {
        $this->cekToken();

        $result = $this->M_pma->getPma();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "pma" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pma_by_pic_id_get()
    {
        $this->cekToken();

        $result = $this->M_pma->getPmaByPicID($this->input->get('pic_id'));

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "pma" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pma_post()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($this->input->post("pma_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->input->post("pic_id") == "") {
            array_push($validation_message, "Pic ID tidak boleh kosong");
        }

        if ($this->input->post("pic_id") != "" && !$this->M_pic->cekPicExist($this->input->post("pic_id"))) {
            array_push($validation_message, "Pic ID tidak ditemukan");
        }

        if ($this->input->post("user_id") == "") {
            array_push($validation_message, "User ID tidak boleh kosong");
        }

        if ($this->input->post("user_id") != "" && !$this->M_user->cekUserExist($this->input->post("user_id"))) {
            array_push($validation_message, "User ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "pma_name" => $this->input->post("pma_name"),
            "pic_id" => $this->input->post("pic_id"),
            "user_id" => $this->input->post("user_id")
        );

        $result = $this->M_pma->insertPma($data);

        $data_json = array(
            "success" => true,
            "message" => "Insert Berhasil",
            "data" => array(
                "pma" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pma_put()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($this->put("pma_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->put("pic_id") == "") {
            array_push($validation_message, "Pic ID tidak boleh kosong");
        }

        if ($this->put("pic_id") != "" && !$this->M_pic->cekPicExist($this->put("pic_id"))) {
            array_push($validation_message, "Pic ID tidak ditemukan");
        }

        if ($this->put("user_id") == "") {
            array_push($validation_message, "User ID tidak boleh kosong");
        }

        if ($this->put("user_id") != "" && !$this->M_user->cekUserExist($this->put("user_id"))) {
            array_push($validation_message, "User ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "pma_name" => $this->put("pma_name"),
            "pic_id" => $this->put("pic_id"),
            "user_id" => $this->put("user_id")
        );

        $id = $this->put("pma_id");

        $result = $this->M_pma->updatePma($data, $id);

        $data_json = array(
            "success" => true,
            "message" => "Update Berhasil",
            "data" => array(
                "pma" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }
    }

    public function pma_delete()
    {
        $this->cekToken();

        $id = $this->delete("pma_id");

        $result = $this->M_pma->deletePma($id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "pma" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function pma_by_pic_id_delete()
    {
        $this->cekToken();

        $pic_id = $this->delete("pic_id");

        $result = $this->M_pic->deletePmaByPicID($pic_id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "pma" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    // // API Pma End

    // // API Project Start

    public function project_get()
    {
        $this->cekToken();

        $result = $this->M_project->getProject();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "project" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function project_by_member_get()
    {
        $this->cekToken();

        $result = $this->M_project->getProjectMember($this->input->get('user_id'));

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "project" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function project_post()
    {
        // $this->cekToken();
        //Validasi
        // $validation_message = [];

        // if ($this->input->post("project_name") == "") {
        //     array_push($validation_message, "Nama tidak boleh kosong");
        // }

        // if ($this->input->post("project_description") == "") {
        //     array_push($validation_message, "Deskripsi tidak boleh kosong");
        // }

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'png|jpg';
        $config['max_size'] = '20480';
        $project_picture = $_FILES['project_picture']['name'];
        $path = "./uploads/";

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('project_picture')) {
            // $this->response(array('status'=>'fail',502));
            $error = array('error' => $this->upload->display_errors());
            $this->response(array('status' => $error));


        } else {


            //Jika Lolos Validasi
            $data = array(
                "project_name" => $this->input->post("project_name"),
                "start_date" => date("y-m-d"),
                "end_date" => date("y-m-d"),
                "project_description" => $this->input->post("project_description"),
                "project_picture" => $project_picture,
                "pic_id" => $this->input->post("pic_id"),
                "member" => $this->input->post("member")
            );

            $insert = $this->db->insert('project', $data);
            $this->response($data, 200);

            // $result = $this->M_project->insertProject($data);

            // $data_json = array(
            //     "success" => true,
            //     "message" => "Insert Berhasil",
            //     "data" => array(
            //         "project" => $result
            //     )

            // );

            // $this->response($data_json, REST_Controller::HTTP_OK);

        }
    }

    public function project_put()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($this->put("project_name") == "") {
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if ($this->put("project_description") == "") {
            array_push($validation_message, "Deskripsi tidak boleh kosong");
        }

        if ($this->put("pma_id") == "") {
            array_push($validation_message, "Pma ID tidak boleh kosong");
        }

        if ($this->put("pma_id") != "" && !$this->M_pma->cekPmaExist($this->put("pma_id"))) {
            array_push($validation_message, "Pma ID tidak ditemukan");
        }

        if ($_FILES['project_picture']['size'] == 0) {
            $fname = 'no file';
            array_push($validation_message, "Foto tidak boleh kosong");
        } else {
            if (is_uploaded_file($_FILES['project_picture']['temp_name'])) {
                //Check for image type
                $allowed = array('png', 'jpg', 'jpeg', 'gif');
                $filename = $_FILES['project_picture']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["project_picture"]["tmp_name"];
                    $project_picture = "uploads/project/";

                    $lname = basename($_FILES["project_picture"]["name"]);
                    $newfilename = 'project_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $project_picture . $newfilename);
                    $data['project_picture'] = $newfilename;
                } else {
                    $Return['status'] = '0';
                    $Return['message'] = 'File upload failed!';
                }
            }
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "project_name" => $this->put("project_name"),
            "start_date" => date("y-m-d"),
            "end_date" => date("y-m-d"),
            "project_description" => $this->put("project_description"),
            "project_picture" => $this->put("project_picture"),
            "pma_id" => $this->put("pma_id")
        );

        $id = $this->put("project_id");

        $result = $this->M_project->updateProject($data, $id);

        $data_json = array(
            "success" => true,
            "message" => "Update Berhasil",
            "data" => array(
                "project" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }
    }

    public function project_delete()
    {
        $this->cekToken();

        $id = $this->delete("project_id");

        $result = $this->M_project->deleteProject($id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "project" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function project_by_pic_id_delete()
    {
        $this->cekToken();

        $pic_id = $this->delete("pic_id");

        $result = $this->M_project->deleteProjectByPicID($pic_id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "project" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function project_bulan_ini_get()
    {
        $this->cekToken();

        $result = $this->M_project->getProjectBulanIni();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "project" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    // // API Project End

    // // API Report Start

    public function report_get()
    {
        // $this->cekToken();

        $result = $this->M_report->getReport();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function report_by_member_get()
    {
        $this->cekToken();

        $result = $this->M_report->getReportByMember($this->input->get('user_id'));

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function report_by_pma_id_get()
    {
        $this->cekToken();

        $result = $this->M_report->getReportByPmaID($this->input->get('pma_id'));

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function report_postt()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($_FILES['report_progress']['size'] == 0) {
            $rname = 'no file';
            array_push($validation_message, "Foto tidak boleh kosong");
        } else {
            if (is_uploaded_file($_FILES['report_progress']['tmp_name'])) {
                //Check for image type
                $allowed = array('png', 'jpg', 'jpeg', 'gif');
                $filename = $_FILES['report_progress']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["report_progress"]["tmp_name"];
                    $report_progress = "uploads/report/progress";

                    $lname = basename($_FILES["report_progress"]["name"]);
                    $newfilename = 'progress_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $report_progress . $newfilename);
                    $rname = $newfilename;
                } else {
                    $Return['status'] = '0';
                    $Return['message'] = 'File upload failed!';
                }
            }
        }

        if ($_FILES['report_nota']['size'] == 0) {
            $nname = 'no file';
            array_push($validation_message, "Foto tidak boleh kosong");
        } else {
            if (is_uploaded_file($_FILES['report_nota']['tmp_name'])) {
                //Check for image type
                $allowed = array('png', 'jpg', 'jpeg', 'gif');
                $filename = $_FILES['report_nota']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["report_nota"]["tmp_name"];
                    $report_nota = "uploads/report/nota";

                    $lname = basename($_FILES["report_nota"]["name"]);
                    $newfilename = 'nota_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $report_nota . $newfilename);
                    $nname = $newfilename;
                } else {
                    $Return['status'] = '0';
                    $Return['message'] = 'File upload failed!';
                }
            }
        }

        if ($this->input->post("project_id") == "") {
            array_push($validation_message, "Project ID tidak boleh kosong");
        }

        if ($this->input->post("project_id") != "" && !$this->M_project->cekProjectExist($this->input->post("project_id"))) {
            array_push($validation_message, "Project ID tidak ditemukan");
        }

        if ($this->input->post("pma_id") == "") {
            array_push($validation_message, "Pma ID tidak boleh kosong");
        }

        if ($this->input->post("pma_id") != "" && !$this->M_pma->cekPmaExist($this->input->post("pma_id"))) {
            array_push($validation_message, "Pma ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "report_progress" => $rname,
            "report_nota" => $nname,
            "report_date" => date("y-m-d"),
            "report_time" => time("H:i:s"),
            "project_id" => $this->input->post("project_id"),
            "pma_id" => $this->input->post("pma_id")
        );

        $result = $this->M_report->insertReport($data);

        $data_json = array(
            "success" => true,
            "message" => "Insert Berhasil",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function report_post()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'png|jpg';
        $config['max_size'] = '20480';
        $report_progress = $_FILES['report_progress']['name'];
        $path = "./uploads/";

        $this->load->library('upload', $config);
        // $this->upload->initialize($config);

        if ($this->upload->do_upload('report_progress')) {
            // $this->response(array('status'=>'fail',502));
            $error = array('error' => $this->upload->display_errors());
            $this->response(array('status' => $error));


        } else {
            $data = array(
                "report_progress" => $report_progress,
                "report_nota" => $this->input->post("report_nota"),
                "report_date" => date("y-m-d"),
                "report_time" => $this->input->post("report_time"),
                "project_id" => $this->input->post("project_id"),
                "pma_id" => $this->input->post("pma_id"),
                "member" => $this->input->post("member")
            );
            $insert = $this->db->insert('report', $data);
            $this->response($data, 200);

        }
    }
    public function report_put()
    {
        $this->cekToken();
        //Validasi
        $validation_message = [];

        if ($_FILES['report_progress']['size'] == 0) {
            $rname = 'no file';
            array_push($validation_message, "Foto tidak boleh kosong");
        } else {
            if (is_uploaded_file($_FILES['report_progress']['tmp_name'])) {
                //Check for image type
                $allowed = array('png', 'jpg', 'jpeg', 'gif');
                $filename = $_FILES['report_progress']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["report_progress"]["tmp_name"];
                    $report_progress = "uploads/report/progress";

                    $lname = basename($_FILES["report_progress"]["name"]);
                    $newfilename = 'progress_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $report_progress . $newfilename);
                    $data['report_progress'] = $newfilename;
                } else {
                    $Return['status'] = '0';
                    $Return['message'] = 'File upload failed!';
                }
            }
        }

        if ($_FILES['report_nota']['size'] == 0) {
            $nname = 'no file';
            array_push($validation_message, "Foto tidak boleh kosong");
        } else {
            if (is_uploaded_file($_FILES['report_nota']['tmp_name'])) {
                //Check for image type
                $allowed = array('png', 'jpg', 'jpeg', 'gif');
                $filename = $_FILES['report_nota']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["report_nota"]["tmp_name"];
                    $report_nota = "uploads/report/nota";

                    $lname = basename($_FILES["report_nota"]["name"]);
                    $newfilename = 'nota_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $report_nota . $newfilename);
                    $data['report_nota'] = $newfilename;
                } else {
                    $Return['status'] = '0';
                    $Return['message'] = 'File upload failed!';
                }
            }
        }

        if ($this->put("project_id") == "") {
            array_push($validation_message, "Project ID tidak boleh kosong");
        }

        if ($this->put("project_id") != "" && !$this->M_pma->cekProjectExist($this->put("project_id"))) {
            array_push($validation_message, "Project ID tidak ditemukan");
        }

        if ($this->put("pma_id") == "") {
            array_push($validation_message, "Pma ID tidak boleh kosong");
        }

        if ($this->put("pma_id") != "" && !$this->M_pma->cekPmaExist($this->put("pma_id"))) {
            array_push($validation_message, "Pma ID tidak ditemukan");
        }

        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        //Jika Lolos Validasi
        $data = array(
            "report_progress" => $this->put("report_progress"),
            "report_nota" => $this->put("report_nota"),
            "report_date" => date("y-m-d"),
            "report_time" => time("H:i:s"),
            "project" => $this->put("project"),
            "pma_id" => $this->put("pma_id")
        );

        $id = $this->put("report_id");

        $result = $this->M_report->updateReport($data, $id);

        $data_json = array(
            "success" => true,
            "message" => "Update Berhasil",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
        if (count($validation_message) > 0) {
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }
    }

    public function report_delete()
    {
        $this->cekToken();

        $id = $this->delete("report_id");

        $result = $this->M_report->deleteReport($id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function report_by_project_id_delete()
    {
        $this->cekToken();

        $project_id = $this->delete("project_id");

        $result = $this->M_report->deleteReportByPicID($project_id);

        if (empty($result)) {
            $data_json = array(
                "success" => false,
                "message" => "Id tidak valid",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data_json = array(
            "success" => true,
            "message" => "Delete Berhasil",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    public function report_bulan_ini_get()
    {
        $this->cekToken();

        $result = $this->M_report->getReportBulanIni();

        $data_json = array(
            "success" => true,
            "message" => "Data found",
            "data" => array(
                "report" => $result
            )

        );

        $this->response($data_json, REST_Controller::HTTP_OK);
    }

    // // API Report End



    public function cekToken()
    {
        try {
            $token = $this->input->get_request_header('Authorization');

            if (!empty($token)) {
                $token = explode(' ', $token)[1];
            }

            $token_decode = JWT::decode($token, $this->secret_key, array('HS256'));
        } catch (Exception $e) {
            $data_json = array(
                "success" => false,
                "message" => "Token tidak valid",
                "error_code" => 1204,
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }
    }
}