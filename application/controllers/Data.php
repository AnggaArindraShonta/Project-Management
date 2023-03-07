<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		$this->data['CI'] = &get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		if ($this->session->userdata('is_login') != TRUE) {
			$url = base_url('index.php/login');
			redirect($url);
		}
	}

	public function index()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->db->select('project.*, user.*, pic.*');
		$this->db->from('project');
		$this->db->join('user', 'user.user_id = project.member', 'left');
		$this->db->join('pic', 'pic.pic_id = project.pic_id', 'left');
		$this->db->order_by('project.project_id', 'desc');
		$query = $this->db->get();
		$result = $query->result_array();


		$this->data['project'] = $result;

		$this->data['title_web'] = 'Data Project';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('project/project_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}
	public function report()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		// $this->data['report'] = $this->db->query("SELECT * FROM report ORDER BY report_id DESC");

		$this->db->select('report.*, project.project_name, user.user_name');
		$this->db->from('report');
		$this->db->join('project', 'project.project_id = report.project_id', 'left');
		$this->db->join('user', 'user.user_id = project.member', 'left');
		$query = $this->db->get();
		$result = $query->result_array();


		$this->data['report'] = $result;

		$this->data['title_web'] = 'Data Report';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('report/report_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}




	public function reporttambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$this->data['project'] = $this->db->query("SELECT * FROM project ORDER BY project_id DESC")->result_array();
		$this->data['pma'] = $this->db->query("SELECT * FROM user ORDER BY user_id DESC")->result_array();

		$this->data['title_web'] = 'Tambah Report';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('report/tambah_view', $this->data);

		$this->load->view('footer_view', $this->data);

	}
	public function projecttambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$this->data['member'] = $this->db->query("SELECT * FROM user ORDER BY user_id DESC")->result_array();
		$this->data['pic_id'] = $this->db->query("SELECT * FROM pic ORDER BY pic_id DESC")->result_array();


		$this->data['title_web'] = 'Tambah Project';
		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('project/tambah_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}


	public function prosesproject()
	{
		if ($this->session->userdata('is_login') != TRUE) {
			$url = base_url('index.php/login');
			redirect($url);
		}

		// hapus aksi form proses project
		if (!empty($this->input->get('project_id'))) {

			$project = $this->M_Admin->get_tableid_edit('project', 'project_id', htmlentities($this->input->get('project_id')));

			$project_picture = './assets/image/project/' . $project->project_picture;
			if (file_exists($project_picture)) {
				unlink($project_picture);
			}



			$this->M_Admin->delete_table('project', 'project_id', $this->input->get('project_id'));

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
					<p> Berhasil Hapus Project !</p>
				</div></div>');
			redirect(base_url('index.php/data'));
		}

		if (!empty($this->input->post('tambah'))) {
			$post = $this->input->post();
			$data = array(
				'pic_id' => htmlentities($post['pic_id']),
				'member' => htmlentities($post['member']),
				'project_name' => htmlentities($post['project_name']),
				'project_description' => htmlentities($post['project_description']),
				'start_date' => htmlentities($post['start_date']),
				'end_date' => htmlentities($post['end_date']),

			);



			if (!empty($_FILES['project_picture']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/projects/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('project_picture')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('project_picture', $file2['upload_data']['file_name']);
				} else {

					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Project Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data'));
				}
			}

			$this->db->insert('project', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Project Sukses !</p>
			</div></div>');
			redirect(base_url('index.php/data'));
		}


	}
	public function prosesbuku()
	{
		if ($this->session->userdata('masuk_perpus') != TRUE) {
			$url = base_url('login');
			redirect($url);
		}

		// hapus aksi form proses buku
		if (!empty($this->input->get('buku_id'))) {

			$buku = $this->M_Admin->get_tableid_edit('tbl_buku', 'id_buku', htmlentities($this->input->get('buku_id')));

			$sampul = './assets/image/buku/' . $buku->sampul;
			if (file_exists($sampul)) {
				unlink($sampul);
			}

			$lampiran = './assets/image/buku/' . $buku->lampiran;
			if (file_exists($lampiran)) {
				unlink($lampiran);
			}

			$this->M_Admin->delete_table('tbl_buku', 'id_buku', $this->input->get('buku_id'));

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
					<p> Berhasil Hapus Buku !</p>
				</div></div>');
			redirect(base_url('data'));
		}

		// tambah aksi form proses buku
		if (!empty($this->input->post('tambah'))) {
			$post = $this->input->post();
			$buku_id = $this->M_Admin->buat_kode('tbl_buku', 'BK', 'id_buku', 'ORDER BY id_buku DESC LIMIT 1');
			$data = array(
				'buku_id' => $buku_id,
				'id_kategori' => htmlentities($post['kategori']),
				'id_rak' => htmlentities($post['rak']),
				'isbn' => htmlentities($post['isbn']),
				'title' => htmlentities($post['title']),
				'pengarang' => htmlentities($post['pengarang']),
				'penerbit' => htmlentities($post['penerbit']),
				'thn_buku' => htmlentities($post['thn']),
				'isi' => $this->input->post('ket'),
				'jml' => htmlentities($post['jml']),
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			$this->load->library('upload', $config);
			if (!empty($_FILES['gambar']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('sampul', $file1['upload_data']['file_name']);
				} else {
					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Buku Gagal !</p>
						</div></div>');
					redirect(base_url('data'));
				}
			}

			if (!empty($_FILES['lampiran']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'pdf';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('lampiran', $file2['upload_data']['file_name']);
				} else {

					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Buku Gagal !</p>
						</div></div>');
					redirect(base_url('data'));
				}
			}

			$this->db->insert('tbl_buku', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Buku Sukses !</p>
			</div></div>');
			redirect(base_url('data'));
		}

		// edit aksi form proses buku
		if (!empty($this->input->post('edit'))) {
			$post = $this->input->post();
			$data = array(
				'id_kategori' => htmlentities($post['kategori']),
				'id_rak' => htmlentities($post['rak']),
				'isbn' => htmlentities($post['isbn']),
				'title' => htmlentities($post['title']),
				'pengarang' => htmlentities($post['pengarang']),
				'penerbit' => htmlentities($post['penerbit']),
				'thn_buku' => htmlentities($post['thn']),
				'isi' => $this->input->post('ket'),
				'jml' => htmlentities($post['jml']),
				'tgl_masuk' => date('Y-m-d H:i:s')
			);

			if (!empty($_FILES['gambar']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$gambar = './assets/image/buku/' . htmlentities($post['gmbr']);
					if (file_exists($gambar)) {
						unlink($gambar);
					}
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('sampul', $file1['upload_data']['file_name']);
				} else {
					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Buku Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data'));
				}
			}

			if (!empty($_FILES['lampiran']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/buku/';
				$config['allowed_types'] = 'pdf';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$lampiran = './assets_style/image/buku/' . htmlentities($post['lamp']);
					if (file_exists($lampiran)) {
						unlink($lampiran);
					}
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('lampiran', $file2['upload_data']['file_name']);
				} else {

					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Buku Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data'));
				}
			}

			$this->db->where('id_buku', htmlentities($post['edit']));
			$this->db->update('tbl_buku', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Edit Buku Sukses !</p>
				</div></div>');
			redirect(base_url('data/bukuedit/' . $post['edit']));
		}
	}
	public function prosesreport()
	{
		if ($this->session->userdata('is_login') != TRUE) {
			$url = base_url('login');
			redirect($url);
		}

		// hapus aksi form proses buku
		if (!empty($this->input->get('repot_id'))) {

			$report = $this->M_Admin->get_tableid_edit('report', 'report_id', htmlentities($this->input->get('report_id')));

			$report_progress = './assets/image/report/' . $report->report_progress;
			if (file_exists($report_progress)) {
				unlink($report_progress);
			}

			$report_nota = './assets/image/report/' . $report->report_nota;
			if (file_exists($report_nota)) {
				unlink($report_nota);
			}

			$this->M_Admin->delete_table('report', 'report_id', $this->input->get('report_id'));

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
					<p> Berhasil Hapus Report !</p>
				</div></div>');
			redirect(base_url('index.php/data/report'));

		}

		// tambah aksi form proses buku
		if (!empty($this->input->post('tambah'))) {
			$post = $this->input->post();
			// $buku_id = $this->M_Admin->buat_kode('tbl_buku', 'BK', 'id_buku', 'ORDER BY id_buku DESC LIMIT 1');
			$data = array(
				// 'buku_id' => $buku_id,
				'report_date' => htmlentities($post['report_date']),
				'report_time' => htmlentities($post['report_time']),
				'project_id' => htmlentities($post['project_id']),

				'ket_progress' => htmlentities($post['ket_progress']),
				'ket_nota' => htmlentities($post['ket_nota']),

			);

			$this->load->library('upload', $config);
			if (!empty($_FILES['report_progress']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/report/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('report_progress')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('report_progress', $file1['upload_data']['file_name']);
				} else {
					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Report Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data/report'));
				}
			}

			if (!empty($_FILES['report_nota']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/report/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('report_nota')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('report_nota', $file2['upload_data']['file_name']);
				} else {

					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Report Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data/report'));
				}
			}

			$this->db->insert('report', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Report Sukses !</p>
			</div></div>');
			redirect(base_url('index.php/data/report'));
		}

		// edit aksi form proses buku
		if (!empty($this->input->post('edit'))) {
			$post = $this->input->post();
			$data = array(
				'report_date' => htmlentities($post['report_date']),
				'report_time' => htmlentities($post['report_time']),
				'project_id' => htmlentities($post['project_id']),
				'ket_progress' => htmlentities($post['ket_progress']),
				'ket_nota' => htmlentities($post['ket_nota']),
			);

			if (!empty($_FILES['report_progress']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/report/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('report_progress')) {
					$this->upload->data();
					$report_progress = './assets/image/report/' . htmlentities($post['gmbr']);
					if (file_exists($report_progress)) {
						unlink($report_progress);
					}
					$file1 = array('upload_data' => $this->upload->data());
					$this->db->set('report_progress', $file1['upload_data']['file_name']);
				} else {
					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Report Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data/report'));
				}
			}

			if (!empty($_FILES['report_nota']['name'])) {
				// setting konfigurasi upload
				$config['upload_path'] = './assets_style/image/report/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
				// load library upload
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				// script uplaod file kedua
				if ($this->upload->do_upload('report_nota')) {
					$this->upload->data();
					$report_nota = './assets_style/image/report/' . htmlentities($post['lamp']);
					if (file_exists($report_nota)) {
						unlink($report_nota);
					}
					$file2 = array('upload_data' => $this->upload->data());
					$this->db->set('report_nota', $file2['upload_data']['file_name']);
				} else {

					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
							<p> Edit Report Gagal !</p>
						</div></div>');
					redirect(base_url('index.php/data/report'));
				}
			}

			$this->db->where('report_id', htmlentities($post['edit']));
			$this->db->update('report', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
					<p> Edit Report Sukses !</p>
				</div></div>');
			redirect(base_url('index.php/data/report/' . $post['edit']));
		}
	}


}