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
			$where = [
				'tahun' => date('Y'),
				'dihapus' => '0'
			];
			$data['sp'] = $this->m_uptd->tampil_where('v_sp', $where);

			$this->load->view('global/v_sidebar');
			$this->load->view('sp/v_sp', $data);
			$this->load->view('global/v_footer');
		}else{
			redirect(base_url().'login');
		}
	}

	public function tambah(){
		if($this->session->userdata('masuk') == '1'){
			
			if($this->input->post('submit') != NULL){
				$this->m_sp->lock_tbl_sp();

				$status_tanggal = $this->input->post('status_tanggal');
				$jumlah_sp = $this->input->post('jumlah_sp');
				$pegawai = $this->input->post('pegawai'); //array
				$tanggal_sp = $this->input->post('tanggal_sp'); //array
				$tujuan = $this->input->post('tujuan'); //array
				$hal = $this->input->post('hal');
				$keterangan = $this->input->post('keterangan');
				$tgl_terakhir = '';
				$data_warning['hasil'] = array();

				$hasil = $this->m_sp->id_terakhir(date('Y'))->row();
				$tgl_terakhir = $hasil->tahun.'-'.$hasil->bulan.'-'.$hasil->tanggal;


				for($i = 1; $i <= $jumlah_sp; $i++){
					$tgl_d = date('d');
					$tgl_m = date('m');
					$tgl_y = date('Y');
					$nomor = 0;

					if($status_tanggal == "sekarang" && $i == 1){
						$hasil = $this->m_sp->id_terakhir(date('Y'))->row();
						if(strtotime($tgl_terakhir) < strtotime(date("Y-m-d"))){
							$nomor = $hasil->nomor+6;
						}else{
							$nomor = $hasil->nomor+1;
						}
						
					}else if($status_tanggal == "sekarang" && $i != 1){
						$hasil = $this->m_sp->id_terakhir(date('Y'))->row();
						$nomor = $hasil->nomor+1;
					}else if($status_tanggal == "pilih"){
						$tgl_d = $this->input->post('tgl_d');
						$tgl_m = $this->input->post('tgl_m');
						$tgl_y = $this->input->post('tgl_y');

						$data['nomor_list'] = $this->m_sp->nomor_cari($tgl_d, $tgl_m, $tgl_y);
						if($data['nomor_list']->num_rows() > 0){
							$data['nomor_minmax'] = $this->m_sp->nomor_minmax($tgl_d, $tgl_m, $tgl_y)->row();
							$nomor_min = $data['nomor_minmax']->nomor_min;
							$nomor_max = $data['nomor_minmax']->nomor_max;

							$nomor_max = $nomor_max + $jumlah_sp;

							for($no = $nomor_min; $no <= $nomor_max; $no++){
								$where = [
									'nomor' => $no,
									'tahun' => $tgl_y
								];
								$data = $this->m_uptd->tampil_where('tbl_sp', $where)->row();
								if($data == NULL){
									$nomor = $no;
									break;
								}
							}

							if($nomor == 0){
								$hasil = $this->m_sp->id_terakhir(date('Y'))->row();
								if(strtotime($tgl_terakhir) < strtotime(date("Y-m-d"))){
									$nomor = $hasil->nomor+6;
								}else{
									$nomor = $hasil->nomor+1;
								}
								
							}
						}else{
							$hasil = $this->m_sp->id_terakhir(date('Y'))->row();
							if(strtotime($tgl_terakhir) < strtotime(date("Y-m-d"))){
								$nomor = $hasil->nomor+6;
							}else{
								$nomor = $hasil->nomor+1;
							}
							
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
						'ket' => $keterangan,
						'dihapus' => '0',
						'penomoran_id' => '3',
						'ditambah_oleh' => $this->session->userdata('pegawai_id'),
						'tgl_tambah' => date("Y-m-d H:i:s")
					];
					$sp_terakhir = $this->m_uptd->tambah('tbl_sp', $data);

					for($peg = 0; $peg < count($pegawai); $peg++){
						$data_pegawai = [
							'sp_id' => $sp_terakhir,
							'pegawai_id' => $pegawai[$peg],
							'ditambah_oleh' => $this->session->userdata('pegawai_id'),
							'tgl_tambah' => date("Y-m-d H:i:s")
						];
						$this->m_uptd->tambah('tbl_sp_pegawai', $data_pegawai);
					}

					array_push($data_warning['hasil'], array('nomor' => $nomor, 'ket' => $data['tanggal_sp']));
				}

				$this->m_sp->unlock_tbl_sp();

				$this->load->view('global/v_sidebar');
				$this->load->view('global/v_warning', $data_warning);
				$this->load->view('global/v_footer');

			}else{
				$data['pegawai'] = $this->m_uptd->tampil_where('tbl_pegawai', array('dihapus' => '0'));

				$this->load->view('global/v_sidebar');
				$this->load->view('sp/v_sp_tambah', $data);
				$this->load->view('global/v_footer');
			}
		}else{
			redirect(base_url().'login');
		}
	}

	public function tambah_bernomor(){
		if($this->session->userdata('masuk') == '1'){
			
			if($this->input->post('submit') != NULL){
				$nomor_awal = $this->input->post('nomor_awal');
				$nomor_akhir = $this->input->post('nomor_akhir');
				$tgl_d = $this->input->post('tgl_d');
				$tgl_m = $this->input->post('tgl_m');
				$tgl_y = $this->input->post('tgl_y');
				$pegawai = $this->input->post('pegawai'); //array
				$tanggal_sp = $this->input->post('tanggal_sp'); //array
				$tujuan = $this->input->post('tujuan'); //array
				$hal = $this->input->post('hal');
				$keterangan = $this->input->post('keterangan');

				$data_warning['hasil'] = array();

				$total = $nomor_akhir - $nomor_awal + 1;
				if($total < 1){
					$total = 1;
				}

				for($i = 0; $i < $total; $i++){
					$data = [
						'nomor' => $nomor_awal+$i,
						'tanggal' => $tgl_d,
						'bulan' => $tgl_m,
						'tahun' => $tgl_y,
						'tanggal_sp' => date('Y-m-d', strtotime($tanggal_sp[$i])),
						'tujuan' => $tujuan[$i],
						'hal' => $hal,
						'ket' => $keterangan,
						'dihapus' => '0',
						'ditambah_oleh' => $this->session->userdata('pegawai_id'),
						'tgl_tambah' => date("Y-m-d H:i:s")
					];

					$where = [
						'nomor' => $data['nomor'],
						'tahun' => $data['tahun']
					];
					$data = $this->m_uptd->tampil_where('tbl_sp', $where)->row();
					if($data == NULL){
						$sp_terakhir = $this->m_uptd->tambah('tbl_sp', $data);

						for($peg = 0; $peg < count($pegawai); $peg++){
							$data_pegawai = [
								'sp_id' => $sp_terakhir,
								'pegawai_id' => $pegawai[$peg],
								'ditambah_oleh' => $this->session->userdata('pegawai_id'),
								'tgl_tambah' => date("Y-m-d H:i:s")
							];
							$this->m_uptd->tambah('tbl_sp_pegawai', $data_pegawai);

							array_push($data_warning['hasil'], array('nomor' => $data['nomor'], 'ket' => $data['tujuan']));
						}
					}else{
						array_push($data_warning['hasil'], array('nomor' => $data['nomor'], 'ket' => 'SUDAH TERPAKAI'));
					}
				}
				$this->load->view('global/v_sidebar');
				$this->load->view('global/v_warning', $data_warning);
				$this->load->view('global/v_footer');

			}else{
				$data['pegawai'] = $this->m_uptd->tampil_where('tbl_pegawai', array('dihapus' => '0'));

				$this->load->view('global/v_sidebar');
				$this->load->view('sp/v_sp_tambah_bernomor', $data);
				$this->load->view('global/v_footer');
			}
		}else{
			redirect(base_url().'login');
		}
	}


	public function hapus(){
		if($this->session->userdata('masuk') == 1){
			$where['id'] = $this->uri->segment(3);
			$data = [
				'nomor' => NULL,
				'dihapus' => '1',
				'diedit_oleh' => $this->session->userdata('pegawai_id'),
				'tgl_edit' => date("Y-m-d H:i:s")
			];

			$this->m_uptd->ubah('tbl_sp', $data, $where);
			redirect(base_url().'sp');
		}else{
			redirect(base_url().'login');
		}
	}
}