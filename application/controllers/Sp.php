<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sp extends CI_Controller
{
	public function index(){
		if($this->session->userdata('masuk') == '1'){
			$data['sp'] = $this->m_uptd->tampil('v_sp');

			$this->load->view('global/v_sidebar');
			$this->load->view('sp/v_sp', $data);
			$this->load->view('global/v_footer');
		}else{
			redirect(base_url().'login');
		}
	}

	public function tambah(){
		if($this->session->userdata('masuk') == '1'){
			if(isset($_POST['submit'])){

			}else{
				$this->load->view('global/v_sidebar');
				$this->load->view('sp/v_sp_tambah');
				$this->load->view('global/v_footer');
			}
		}else{
			redirect(base_url().'login');
		}
	}
}