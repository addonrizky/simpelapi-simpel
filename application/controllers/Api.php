<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

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
	
	public function message_get()
	{
		$array = array();
		$message_data = $this->Api_model->get_messages();
		foreach($message_data->result() as $row)
		{
			
			$no = $row->no_hp;
			$no = preg_replace("/\([0-9]+?\)/", "", $no);
			$no = preg_replace("/[^0-9]/", "", $no);
			$no = ltrim($no, '0');
			$pfx = '62';
			if ( !preg_match('/^'.$pfx.'/', $no)  ) {
				$no = $pfx.$no;
			}
			
			//$no = "6281295391726";
			
			$array[] = array(
				'no_hp' => $no,
				'message' => $row->message
			);
			
			$this->Api_model->update(array('is_sent'=>1), $row->id);
			
		}
		
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	public function message2_get()
	{
		
		//81295391726	
		$no = "0895341436132";
		$no = preg_replace("/\([0-9]+?\)/", "", $no);
		$no = preg_replace("/[^0-9]/", "", $no);
		$no = ltrim($no, '0');
		$pfx = '62';
		if ( !preg_match('/^'.$pfx.'/', $no)  ) {
			$no = $pfx.$no;
		}
		
		//$no = "6281295391726";
		
		$array[] = array(
			'no_hp' => $no,
			'message' => "Hello World!"
		);
		
		//$this->Api_model->update(array('is_sent'=>1), $row->id);
			
		
		
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	public function layanan_per_komoditi_get()
	{
		$array = array();
		$raw_data = $this->Api_model->get_layanan_by_kategori_p();
		foreach($raw_data->result() as $row)
		{
			/*$array[] = array(
				'komoditi' => $row->komoditi,
				'jml' => $row->cnt
			);*/
			$array[$row->komoditi]['P'] = $row->cnt;
		}
		
		$raw_data = $this->Api_model->get_layanan_by_kategori_i();
		foreach($raw_data->result() as $row)
		{
			/*$array[] = array(
				'komoditi' => $row->komoditi,
				'jml' => $row->cnt
			);*/
			$array[$row->komoditi]['I'] = $row->cnt;
		}
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	public function layanan_per_media_get()
	{
		$array = array();
		$raw_data = $this->Api_model->get_layanan_by_media_p();
		foreach($raw_data->result() as $row)
		{
			/*$array[] = array(
				'media' => $row->submited_via,
				'jml' => $row->cnt
			);*/
			$array[$row->submited_via]['P'] = $row->cnt;
		}
		
		$raw_data = $this->Api_model->get_layanan_by_media_i();
		foreach($raw_data->result() as $row)
		{
			/*$array[] = array(
				'media' => $row->submited_via,
				'jml' => $row->cnt
			);*/
			$array[$row->submited_via]['I'] = $row->cnt;
		}
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array;
		$this->response( $response, 200 );
	}
	
	
	
	public function layanan_per_jenis_get()
	{
		$array = array();
		$raw_data = $this->Api_model->get_layanan_by_jenis();
		$total = 0;
		$data['P'] = 0;
		$data['I'] = 0;
		foreach($raw_data->result() as $row)
		{
			
			$data[$row->info] = $row->cnt;
			$total = $total + $row->cnt;
		}
		
		//$array['Pengaduan'] = number_format($data['P'] *100 / $total,2);
		//$array['Permintaan Informasi'] = number_format($data['I'] *100 / $total,2);
		//$array['Pengaduan'] = $data['P'];
		//$array['Permintaan Informasi'] = $data['I'];
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $data;
		$this->response( $response, 200 );
	}
	
	public function layanan_per_tl_get()
	{
		$array = array();
		$raw_data = $this->Api_model->get_layanan_by_tl_p();
		foreach($raw_data->result() as $row)
		{
			/*$array[] = array(
				'media' => $row->submited_via,
				'jml' => $row->cnt
			);*/
			$array[$row->tl]['P'] = $row->cnt;
		}
		
		$raw_data = $this->Api_model->get_layanan_by_tl_i();
		foreach($raw_data->result() as $row)
		{
			/*$array[] = array(
				'media' => $row->submited_via,
				'jml' => $row->cnt
			);*/
			$array[$row->tl]['I'] = $row->cnt;
		}
		
		$array2 = array(
			'Selesai TL' => $array[1],
			'Proses TL' => $array[0],
		);
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array2;
		$this->response( $response, 200 );
	}
	
	public function layanan_per_sla_get()
	{
		$array = array();
		$raw_data = $this->Api_model->get_layanan_by_sla_sesuai();
		
		$data['P'] = 0;
		$data['I'] = 0;
		foreach($raw_data->result() as $row)
		{
			
			$data[$row->info] = $row->cnt;
		}
		
		$raw_data = $this->Api_model->get_layanan_by_sla_tdksesuai();
		
		$data2['P'] = 0;
		$data2['I'] = 0;
		foreach($raw_data->result() as $row)
		{
			
			$data2[$row->info] = $row->cnt;
		}
		
		$array2 = array(
			'Sesuai SLA' => $data,
			'Tidak Sesuai SLA' => $data2
		
		);
		
		$response['status'] = 200;
		$response['error'] = false;
		$response['message'] = $array2;
		$this->response( $response, 200 );
	}
}
