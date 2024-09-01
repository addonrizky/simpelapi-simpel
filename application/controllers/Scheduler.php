<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('Scheduler_model');
	}

    public function reminderSLA() {
        
        /*
          {
            "user_id": "1",
            "message": "test",
            "phone": "6285717595719"
          } 
         */
        $messages = "[SIMPEL-BPOM-AUTOMATIC] Kepada Yth. Bpk Iman Akbar Ramadhan Layanan dengan ticket PST-16072024-001 Sudah mendekati SLA, Harap segera ditindaklanjuti pada aplikasi SIMPEL. \nTerima Kasih";
        $noHP = "6285717595719";
        $params = [
            "user_id" 			=> 1,
            "message"			=> $messages,
            "phone"			    => $noHP,
        ];
        return $this->Scheduler_model->sendNotif($params);
    }

}