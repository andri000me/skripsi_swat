<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sp extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('m_sp');
	}

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
				$status_tanggal = $_POST['status_tanggal'];
				$jumlah_sp = $_POST['jumlah_sp'];

				for($i = 1; $i <= $jumlah_sp; $i++){
					$tgl_d = date('d');
					$tgl_m = date('m');
					$tgl_y = date('Y');
					$nomor = 0;

					if($status_tanggal == "sekarang" && $i == 1){
						$hasil = $this->m_uptd->tampil('v_sp_last_nomor')->row();
						$nomor = $hasil->nomor+3;
					}else if($status_tanggal == "sekarang" && $i != 1){
						$hasil = $this->m_uptd->tampil('v_sp_last_nomor')->row();
						$nomor = $hasil->nomor+1;
					}else if($status_tanggal == "pilih"){
						$tgl_d = $_POST['tgl_d'];
						$tgl_m = $_POST['tgl_m'];
						$tgl_y = $_POST['tgl_y'];

						$data['nomor_list'] = $this->m_sp->nomor_cari($tgl_d, $tgl_m, $tgl_y);
						$data['nomor_minmax'] = $this->m_sp->nomor_minmax($tgl_d, $tgl_m, $tgl_y)->row();
						$nomor_min = $data['nomor_minmax']->nomor_min;
						$nomor_max = $data['nomor_minmax']->nomor_max;
						$nomor_array = array();

						foreach ($data['nomor_list'] as $value) {
							array_push($nomor_array, $value->nomor);
						}

						for($no = $nomor_min; $no <= $nomor_max; $no++){
							//in_array(search_value, array_name, mode) 
						}

					}
				}

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