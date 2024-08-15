<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Ppid extends RestController {

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
	
	public function ticket_get()
	{
		$response['status']=200;
		$response['error']=false;
		$response['message']='Hello';
		$this->response( $response, 200 );
	}

	public function master_get()
	{	
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
		
		$array['kota'] = $city_data;
		$array['kabupaten'] = $kabupaten_data;
		$array['provinsi'] = $provinsi_data;
		$array['profesi'] = $profesi_data;
		$array['cara_oleh_info'] = $cara_oleh_info;
		$array['cara_dapat_info'] = $cara_dapat_info;
		$array['direktorat_data'] = $direktorat_data;
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}

	public function draftppid_post(){
		print_r($this->post());

		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = json_encode($this->post());
		$this->response( $response, 200 );
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
