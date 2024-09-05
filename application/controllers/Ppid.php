<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Ppid extends RestController {

	private $bearerToken = '79da20dbfabb88ca0iarb229d05512v54a0540bfd8906616d9a720ef1d1a4924';

	public function __construct(){
		parent::__construct();
	}
	public function index_get()
	{
		/*$response['status']=200;
		$response['error']=false;
		$response['message']='Hello';
		$this->response( $response, 200 );*/
	}

	public function verification_token()
	{
		$authHeader = $this->input->get_request_header('Authorization');

		if(strpos($authHeader, 'Bearer ') === 0) {
			$receivedToken = str_replace('Bearer ', '', $authHeader);

			if ($receivedToken === $this->bearerToken) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	public function ticket_get()
	{
		$response['status']=200;
		$response['error']=false;
		$response['message']='Hello';
		$this->response( $response, 200 );
	}

	public function master_get()
	{	
		if ($this->verification_token()) {
			$array = array();
			$city_raw = $this->Ppid_model->get_city_ppid();
			$city_data = $city_raw->result();
	
			$kabupaten_raw = $this->Ppid_model->get_kabupaten_ppid();
			$kabupaten_data = $kabupaten_raw->result();
	
			$provinsi_raw = $this->Ppid_model->get_provinsi_ppid();
			$provinsi_data = $provinsi_raw->result();
	
			$profesi_raw = $this->Ppid_model->get_profesi_ppid();
			$profesi_data = $profesi_raw->result();
	
			$cara_oleh_info_raw = $this->Ppid_model->get_olehinfo_ppid();
			$cara_oleh_info = $cara_oleh_info_raw->result();
	
			$cara_dapat_info_raw = $this->Ppid_model->get_dapatinfo_ppid();
			$cara_dapat_info = $cara_dapat_info_raw->result();
	
			$direktorat_raw = $this->Ppid_model->get_direktorat_ppid();
			$direktorat_data = $direktorat_raw->result();

			$alasan_keberatan_raw = $this->Ppid_model->get_alasan_keberatan();
			$alasan_keberatan_data = $alasan_keberatan_raw->result();
			
			$array['kota'] = $city_data;
			$array['kabupaten'] = $kabupaten_data;
			$array['provinsi'] = $provinsi_data;
			$array['profesi'] = $profesi_data;
			$array['cara_oleh_info'] = $cara_oleh_info;
			$array['cara_dapat_info'] = $cara_dapat_info;
			$array['direktorat_data'] = $direktorat_data;
			$array['alasan_keberatan'] = $alasan_keberatan_data;
			
			$response['status'] = 200;
			$response['error'] = false;
			$response['message'] = $array;
			$this->response( $response, 200 );
		} else {
			$response['status'] = 403;
			$response['error'] = true;
			$response['message'] = "Authorization Failed";
			$this->response( $response, 403 );
		}
		
	}

	public function draftppid_post(){
		if ($this->verification_token()) {
			$reqbody = json_decode(json_encode($this->post()));

			if(!isset($reqbody->user_id_admin) && $reqbody->user_id_admin == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "user id admin ppid perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->kota) && $reqbody->kota == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "kota perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->tanggal_pengajuan) && $reqbody->tanggal_pengajuan == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "tanggal_pengajuan perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->nama) && $reqbody->nama == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "nama perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->alamat) && $reqbody->alamat == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "alamat perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->provinsi) && $reqbody->provinsi == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "provinsi perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->kabupaten) && $reqbody->kabupaten == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "kabupaten perlu diisi";
				$this->response( $response, 403 );
			}

			// if(!isset($reqbody->pekerjaan) && $reqbody->pekerjaan == ""){
			// 	$response['status'] = 403;
			// 	$response['error'] = true;
			// 	$response['message'] = "pekerjaan perlu diisi";
			// 	$this->response( $response, 403 );
			// }

			if(!isset($reqbody->no_telepon) && $reqbody->no_telepon == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "no_telepon perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->email) && $reqbody->email == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "email perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->rincian_informasi) && $reqbody->rincian_informasi == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "rincian_informasi perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->tujuan_penggunaan) && $reqbody->tujuan_penggunaan == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "tujuan_penggunaan perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->cara_memperoleh_info) && $reqbody->cara_memperoleh_info == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "cara_memperoleh_info perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->cara_mendapatkan_info) && $reqbody->cara_mendapatkan_info == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "cara_mendapatkan_info perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->ditujukan_unit) && $reqbody->ditujukan_unit == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "ditujukan_unit perlu diisi";
				$this->response( $response, 403 );
			}

			// - Tanggal Pengajuan vs desk_drafts.tglpengaduan
			// - Nama vs desk_drafts.iden_nama
			// - Alamat vs desk_drafts.iden_alamat
			// - Provinsi vs desk_drafts.iden_provinsi (text)
			// - Kabupaten vs desk_drafts.iden_kota
			// - Pekerjaan vs desk_drafts.iden_profesi
			// - No Telepon vs desk_drafts.iden_telp
			// - Email vs desk_drafts.iden_email
			// - Rincian Informasi  vs desk_ppid_drafts.rincian
			// - Tujuan Penggunaan vs desk_ppid_drafts.tujuan

			// {
			// 	"kota" : "UNIT TEKNIS",
			// 	"tanggal_pengajuan" : "2024-08-15",
			// 	"nama" : "Iman Akbar Ramadhan",
			// 	"alamat" : "Haji Merin Meruya Selatan",
			// 	"provinsi" : "DKI Jakarta",
			// 	"kabupaten" : "KOTA JAKARTA PUSAT",
			// 	"pekerjaan" : 2,
			// 	"no_telepon" : "085717595719",
			// 	"email" : "ramadhan.iman@gmail.com",
			// 	"rincian_informasi" : "test informasi rincian",
			// 	"tujuan_penggunaan" : "test info tujuan",
			// 	"cara_memperoleh_info" : "1,2",
			// 	"cara_mendapatkan_info" : "1,2,4,5",
			// 	"ditujukan_unit" : 414
			// }

			$data_desk_drafts = array(
				"tglpengaduan" => $reqbody->tanggal_pengajuan,
				"iden_nama" => $reqbody->nama,
				"iden_alamat" => $reqbody->alamat,
				"iden_provinsi" => $reqbody->provinsi,
				"iden_kota" => $reqbody->kabupaten,
				//"iden_profesi" => $reqbody->pekerjaan,
				"iden_telp" => $reqbody->no_telepon,
				"iden_email" => $reqbody->email,
				"kota" => $reqbody->kota,
				"jenis" => "PPID",
				"category" => 2,
				"is_sent" => "0",
				"owner_dir" => $reqbody->ditujukan_unit,
				"owner" => $reqbody->user_id_admin
			);

			$draft_id = $this->Ppid_model->insert_drafts($data_desk_drafts);

			$data_desk_ppid_drafts = array(
				"id" => $draft_id,
				"cara_memperoleh_info" => $reqbody->cara_memperoleh_info,
				"cara_mendapat_salinan" => $reqbody->cara_mendapatkan_info,
				"rincian" => $reqbody->rincian_informasi,
				"tujuan" => $reqbody->tujuan_penggunaan,
			);

			$this->Ppid_model->insert_ppid_drafts($data_desk_ppid_drafts);

			$response['status'] = 200;
			$response['error'] = false;
			$response['message'] = array(
				"draft_id" => $draft_id
			);
			$this->response( $response, 200 );
		} else {
			$response['status'] = 403;
			$response['error'] = true;
			$response['message'] = "Authorization Failed";
			$this->response( $response, 403 );
		}
	}

	public function draftkeberatan_post(){
		if ($this->verification_token()) {
			$reqbody = json_decode(json_encode($this->post()));

			if(!isset($reqbody->user_id_admin) && $reqbody->user_id_admin == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "user id admin ppid perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->kota) && $reqbody->kota == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "kota perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->tanggal_pengajuan) && $reqbody->tanggal_pengajuan == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "tanggal_pengajuan perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->nama) && $reqbody->nama == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "nama perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->alamat) && $reqbody->alamat == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "alamat perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->provinsi) && $reqbody->provinsi == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "provinsi perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->kabupaten) && $reqbody->kabupaten == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "kabupaten perlu diisi";
				$this->response( $response, 403 );
			}

			// if(!isset($reqbody->pekerjaan) && $reqbody->pekerjaan == ""){
			// 	$response['status'] = 403;
			// 	$response['error'] = true;
			// 	$response['message'] = "pekerjaan perlu diisi";
			// 	$this->response( $response, 403 );
			// }

			if(!isset($reqbody->no_telepon) && $reqbody->no_telepon == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "no_telepon perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->email) && $reqbody->email == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "email perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->no_reg_keberatan) && $reqbody->no_reg_keberatan == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "No Registrasi Keberatan perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->kasus_posisi) && $reqbody->kasus_posisi == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "Kasus Posisi perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->alasan_keberatan) && $reqbody->alasan_keberatan == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "Alasan Keberatan perlu diisi";
				$this->response( $response, 403 );
			}

			if(!isset($reqbody->tanggal_reg_keberatan) && $reqbody->tanggal_reg_keberatan == ""){
				$response['status'] = 403;
				$response['error'] = true;
				$response['message'] = "Tanggal Reg Keberatan perlu diisi";
				$this->response( $response, 403 );
			}

			// - Tanggal Pengajuan vs desk_drafts.tglpengaduan
			// - Nama vs desk_drafts.iden_nama
			// - Alamat vs desk_drafts.iden_alamat
			// - Provinsi vs desk_drafts.iden_provinsi (text)
			// - Kabupaten vs desk_drafts.iden_kota
			// - Pekerjaan vs desk_drafts.iden_profesi
			// - No Telepon vs desk_drafts.iden_telp
			// - Email vs desk_drafts.iden_email
			// - no Reg Permohonan vs desk_ppid_drafts.keberatan_no
			// - Kasus Posisi vs desk_ppid_drafts.kasus_posisi
			// - Alasan vs desk_ppid_drafts.alasan_keberatan (master data desk alasan keberatan)
			// - Tanggal Reg Keberatan vs desk_ppid_drafts.keberatan_tgl

			$data_desk_drafts = array(
				"tglpengaduan" => $reqbody->tanggal_pengajuan,
				"iden_nama" => $reqbody->nama,
				"iden_alamat" => $reqbody->alamat,
				"iden_provinsi" => $reqbody->provinsi,
				"iden_kota" => $reqbody->kabupaten,
				//"iden_profesi" => $reqbody->pekerjaan,
				"iden_telp" => $reqbody->no_telepon,
				"iden_email" => $reqbody->email,
				"kota" => $reqbody->kota,
				"jenis" => "PPID",
				"category" => 3,
				"is_sent" => "0",
				"owner_dir" => $reqbody->ditujukan_unit,
				"owner" => $reqbody->user_id_admin
			);

			$draft_id = $this->Ppid_model->insert_drafts($data_desk_drafts);

			$data_desk_ppid_drafts = array(
				"id" => $draft_id,
				'kuasa_nama' => $reqbody->nama,
				'kuasa_alamat' => $reqbody->alamat,
				'kuasa_telp' => $reqbody->no_telepon,
				'kuasa_email' => $reqbody->email,
				"keberatan_no" => $reqbody->no_reg_keberatan,
				"alasan_keberatan" => $reqbody->alasan_keberatan,
				"kasus_posisi" => $reqbody->kasus_posisi,
				"keberatan_tgl" => $reqbody->tanggal_reg_keberatan,
			);

			$this->Ppid_model->insert_ppid_drafts($data_desk_ppid_drafts);

			$response['status'] = 200;
			$response['error'] = false;
			$response['message'] = array(
				"draft_id" => $draft_id
			);
			$this->response( $response, 200 );
		} else {
			$response['status'] = 403;
			$response['error'] = true;
			$response['message'] = "Authorization Failed";
			$this->response( $response, 403 );
		}
	}
	
	public function ticket_post()
	{
		
		$key = "Ek2B7UePOcS92P0cnSVOqcHYDJNyMkp1";
		$token = $this->post("token");
		if(empty($token))
		{
			 $this->response(array('status' => 'gagal','message'=>'Token empty'), 502);
			 return;
		}
		
		if($token != $key)
		{
			$this->response(array('status' => 'gagal','message'=>'Invalid Token'), 502);
			 return;
		}
		
		$tglpengaduan = date('Y-m-d');
		
		$jenis_layanan = $this->post('jenislayanan');
		if(empty($jenis_layanan)) $jenis_layanan = "I";
		
		$sla = 17;
		
		if($jenis_layanan == 'I') $sla = 17;
		elseif($jenis_layanan == 'P') $sla = 30;
		
		$data_layanan = array(
			//'id'        => 0,
			'iden_nama'    => $this->post('cust_name'),
			'iden_telp'    => $this->post('cust_telp'),
			'tglpengaduan' => $tglpengaduan,
			'info'			=> $jenis_layanan,
			'jenis'		=> 'PPID',
			'kota'		=> 'PUSAT',
			'owner'		=> 1,
			'owner_dir'	=> 1,
			'dt' => date('Y-m-d H:i:s'),
			'submited_via' => 'Aplikasi Lain',
			'sla' => $sla
		);
		
		$data_ppid = array(
			'rincian' => $this->post('rincian'),
			'tujuan' => $this->post('tujuan'),
		);
		
		
		
		$data_layanan['trackid'] =  $this->Ppid_model->generate_ticketid('PUSAT', 'PST', $tglpengaduan);
		
		
		$this->Ppid_model->insert_layanan($data_layanan);
		$data_ppid['id'] = $data_layanan['id'];
		$insert = $this->Ppid_model->insert_ppid($data_ppid);
		
        if ($insert) {
            $this->response(array('status' => 'sukses'), 200);
        } else {
            $this->response(array('status' => 'gagal'), 502);
        }
	}
	
	
	
	public function permohonan_get()
	{
		
		$t1 = $this->get("t1");
		$t2 = $this->get("t2");
		
		$array = array();
		$raw_data = $this->Ppid_model->get_jml_ppid($t1, $t2);
		$rows = $raw_data->result();
		
		$jumlah = $rows[0]->cnt;
		$hk = $rows[0]->hk;
		
		$array['jml'] = $jumlah;
		$array['hk'] = $hk;
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	
	public function keberatan_get()
	{
		$t1 = $this->get("t1");
		$t2 = $this->get("t2");
		
		$array = array();
		$raw_data = $this->Ppid_model->get_jml_ppid_keberatan($t1, $t2);
		$rows = $raw_data->result();
		
		$jumlah = $rows[0]->cnt;
		$hk = $rows[0]->hk;
		
		$array['jml'] = $jumlah;
		$array['hk'] = $hk;
		
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	public function tanggapan_get()
	{
		$t1 = $this->get("t1");
		$t2 = $this->get("t2");
		
		$array = array();
		$raw_data = $this->Ppid_model->get_jml_ppid_tanggapan($t1, $t2);
		$rows = $raw_data->result();
		
		$jumlah = $rows[0]->cnt;
		$hk = $rows[0]->hk;
		
		$array['jml'] = $jumlah;
		$array['hk'] = $hk;
		
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	public function keputusan_get()
	{
		$t1 = $this->get("t1");
		$t2 = $this->get("t2");
		
		$array = array();
		$raw_data = $this->Ppid_model->get_jml_ppid_keputusan($t1, $t2);
		$array['DIKABULKAN SEPENUHNYA'] = 0;
		$array['DIKABULKAN SEBAGIAN'] = 0;
		$array['DITOLAK'] = 0;
		
		foreach($raw_data->result() as $row)
		{
			$array[strtoupper($row->info)] = $row->cnt;
		}
		
		
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	public function hk_get()
	{
		$t1 = $this->get("t1");
		$t2 = $this->get("t2");
		
		if(empty($t1) || empty($t2))
		{
			$response['status'] = 200;
			$response['error'] = true;
			$response['message'] = array();
			$this->response( $response, 200 );
			return;
		}
		
		$array = array();
		$raw_data = $this->Ppid_model->get_hk_ppid($t1, $t2);
		$rows = $raw_data->result();
		
		$jumlah = $rows[0]->cnt;
		
		$array['hk'] = $jumlah;
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
}
