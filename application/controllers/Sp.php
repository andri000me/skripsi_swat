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
				$pegawai = $_POST['pegawai']; //array
				$tanggal_sp = $_POST['tanggal_sp']; //array
				$tujuan = $_POST['tujuan']; //array
				$hal = $_POST['hal'];
				$keterangan = $_POST['keterangan'];

				// echo '<pre>';
				// print_r($status_tanggal);
				// echo '<br>';
				// print_r($jumlah_sp);
				// echo '<br>';
				// print_r($pegawai[1-1]);
				// echo '<br>';
				// print_r($tanggal_sp[1-1]);
				// echo '<br>';
				// print_r($tujuan[1-1]);
				// echo '<br>';
				// print_r($hal);
				// echo '<br>';
				// print_r($keterangan);
				// echo '<br>';
				// echo '</pre>';

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
						if($data['nomor_list']->num_rows() > 0){
							$data['nomor_minmax'] = $this->m_sp->nomor_minmax($tgl_d, $tgl_m, $tgl_y)->row();
							$nomor_min = $data['nomor_minmax']->nomor_min;
							$nomor_max = $data['nomor_minmax']->nomor_max;
							$nomor_array = array();

							foreach ($data['nomor_list']->result() as $value) {
								array_push($nomor_array, $value->nomor);
							}

							for($no = $nomor_min; $no <= $nomor_max; $no++){
								if(!in_array($no, $nomor_array)){
									$data = $this->m_uptd->tampil_where('tbl_sp', array('nomor'=>$no))->row();
									if($data == NULL){
										$nomor = $no;
										break;
									}
								}
							}

							if($nomor == 0){
								$hasil = $this->m_uptd->tampil('v_sp_last_nomor')->row();
								$nomor = $hasil->nomor+3;
							}
						}else{
							$hasil = $this->m_uptd->tampil('v_sp_last_nomor')->row();
							$nomor = $hasil->nomor+3;
						}
						
					}

					//SCRIPT INPUT
					$data = [
						'nomor' => $nomor,
						'tanggal' => $tgl_d,
						'bulan' => $tgl_m,
						'tahun' => $tgl_y,
						'tanggal_sp' => date('Y-m-d', strtotime($tanggal_sp[$i-1])),
						'tujuan' => $tujuan[$i-1],
						'hal' => $hal,
						'ket' => $keterangan
					];
					$this->m_uptd->tambah('tbl_sp', $data);
					$sp_terakhir = $this->m_uptd->tampil_where('tbl_sp', $data)->row();

					for($peg = 0; $peg < count($pegawai); $peg++){
						$data_pegawai = [
							'sp_id' => $sp_terakhir->id,
							'pegawai_id' => $pegawai[$peg]
						];
						$this->m_uptd->tambah('tbl_sp_pegawai', $data_pegawai);
					}
				}
				redirect(base_url().'sp');

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