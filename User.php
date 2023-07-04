<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function profile()
    {
        $data['title'] = 'Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profile()
    {
        $data['title'] = 'Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit_profile', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();
            $this->User_model->edit_profile();
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Profil <strong>berhasil</strong> diedit!!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>'
            );
            redirect('user/profile');
        }
    }

    public function daftar_eskul($id)
    {

        $data['title'] = 'Ekstrakurikuler';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['data_eskul'] =  $this->Eskul_model->geteskul_by_id($id);
        $data['kelas'] = $this->db->get('kelas')->result_array();



        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]', [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama terlalu pendek'
        ]);
        $this->form_validation->set_rules('tempat', 'Tempat', 'required|min_length[3]', [
            'required' => 'Tempat harus diisi',
            'min_length' => 'Tempat terlalu pendek'
        ]);
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal_lahir', 'required|min_length[3]', [
            'required' => 'Tanggal_lahir harus diisi',
            'min_length' => 'Tanggal_lahir terlalu pendek'
        ]);

        $this->form_validation->set_rules('kelas', 'Kelas', 'required|min_length[3]', [
            'required' => 'Kelas harus diisi',
            'min_length' => 'Kelas terlalu pendek'
        ]);
        $this->form_validation->set_rules('no_wa', 'No_whatsapp', 'required|min_length[3]', [
            'required' => 'No_whatsapp harus diisi',
            'min_length' => 'No_whatsapp terlalu pendek'
        ]);
        $this->form_validation->set_rules('alasan', 'Alasan', 'required|min_length[3]', [
            'required' => 'Alasan harus diisi',
            'min_length' => 'Alasan terlalu pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();

            $data['data_eskul'] =  $this->Eskul_model->geteskul_by_id($id);
            $data['kelas'] = $this->db->get('kelas')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/form_daftar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('User_model');
            $this->User_model->daftar();
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Pendaftaran <strong>berhasil</strong> disimpan, cek status secara berkala!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>'
            );
            redirect('user/info_daftar');
        }
    }


    public function info_daftar()
    {
        $data['title'] = 'Pendaftaran';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['info'] = $this->db->get_where('formulir_daftar', array('id_user'))->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/info_pendaftaran', $data);
        $this->load->view('templates/footer');
    }

    public function komplain()
    {
        $data['title'] = 'Komplain';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['data_eskul'] = $this->Eskul_model->getEskul();
        $data['kelas'] = $this->db->get('kelas')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]', [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama terlalu pendek'
        ]);

        $this->form_validation->set_rules('kelas', 'Kelas', 'required|min_length[3]', [
            'required' => 'Kelas harus diisi',
            'min_length' => 'Kelas terlalu pendek'
        ]);

        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required|min_length[3]', [
            'required' => 'Keluhan harus diisi',
            'min_length' => 'Keluhan terlalu pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();


            $data['data_eskul'] = $this->Eskul_model->getEskul();
            $data['kelas'] = $this->db->get('kelas')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/form_komplain', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('User_model');
            $this->User_model->komplain();
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Komplain <strong>berhasil</strong> disimpan, cek status secara berkala!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>'
            );
            redirect('user/info_komplain');
        }
    }


    public function info_komplain()
    {
        $data['title'] = 'Komplain';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['komplan'] = $this->db->get_where('komplan', array('id_user'))->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/info_komplain', $data);
        $this->load->view('templates/footer');
    }

    public function undur()
    {
        $data['title'] = 'Undur Diri';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['data_eskul'] = $this->Eskul_model->getEskul();
        $data['kelas'] = $this->db->get('kelas')->result_array();


        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]', [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama terlalu pendek'
        ]);


        $this->form_validation->set_rules('kelas', 'Kelas', 'required|min_length[3]', [
            'required' => 'Kelas harus diisi',
            'min_length' => 'Kelas terlalu pendek'
        ]);

        $this->form_validation->set_rules('alasan', 'Alasan', 'required|min_length[3]', [
            'required' => 'Alasan harus diisi',
            'min_length' => 'Alasan terlalu pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['email' =>
            $this->session->userdata('email')])->row_array();


            $data['data_eskul'] = $this->Eskul_model->getEskul();
            $data['kelas'] = $this->db->get('kelas')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/form_undur', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('User_model');
            $this->User_model->undur();
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Pengunduran diri <strong>berhasil</strong> disimpan, cek status secara berkala!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>'
            );
            redirect('user/info_undur');
        }
    }

    public function info_undur()
    {
        $data['title'] = 'Undur Diri';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['undur'] = $this->db->get_where('undur', array('id_user'))->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/info_undur', $data);
        $this->load->view('templates/footer');
    }
}
