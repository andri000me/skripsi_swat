<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-5">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary" style="color: #15406a;">Tambah Kontrak</h6>
				</div>
				<div class="card-body">
					<form method="post" action="<?=base_url('kontrak/tambah')?>">
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
						<table class="table" style="width: 100%">
							<tr>
								<td style="width: 20%; color: #000000">Klien</td>
								<td style="width: 100%" class="float-left">
									<select name="klien_id" class="form-control">
										<?php
										foreach($klien->result() as $value){
										?>
											<option value="<?=$value->id?>"><?=$value->nama?></option>
										<?php	
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 20%; color: #000000">Devisi</td>
								<td style="width: 100%" class="float-left">
									<select name="devisi_id" class="form-control">
										<option value="1">Security</option>
										<option value="2">Cleaning Service</option>
										<option value="3">Parkir</option>
										<option value="4">BackOffice</option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 20%; color: #000000">Jumlah Pegawai</td>
								<td style="width: 100%" class="float-left">
									<input type="number" class="form-control" placeholder="" name="jumlah_pegawai" required="">
								</td>
							</tr>
							<tr>
								<td style="width: 20%; color: #000000">Lama Kontrak</td>
								<td style="width: 100%" class="float-left">
									<select name="lama_kontrak" class="form-control">
										<option value="3">3 Bulan</option>
										<option value="6">6 Bulan</option>
										<option value="9">9 Bulan</option>
										<option value="12">12 Bulan</option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 20%; color: #000000">Tanggal Mulai</td>
								<td style="width: 100%" class="float-left">
									<div class="input-group">
										<input type="number" class="form-control" placeholder="tanggal" name="tgl_mulai_tanggal" required="" max="31">
										<select name="tgl_mulai_bulan" class="form-control">
											<option value="1">Januari</option>
											<option value="2">Februari</option>
											<option value="3">Maret</option>
											<option value="4">April</option>
											<option value="5">Mei</option>
											<option value="6">Juni</option>
											<option value="7">Juli</option>
											<option value="8">Agustus</option>
											<option value="9">September</option>
											<option value="10">Oktober</option>
											<option value="11">November</option>
											<option value="12">Desember</option>
										</select>
										<input type="number" class="form-control" placeholder="tahun" name="tgl_mulai_tahun" required="">
									</div>
								</td>
							</tr>
							<tr>
								<td style="width: 20%; color: #000000"></td>
								<td style="width: 100%" class="float-left" align="right">
									<button class="btn btn-primary" type="submit" name="submit" value="1">Tambah Data</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>		
	</div>
</div>
