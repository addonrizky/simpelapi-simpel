<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler_model extends CI_Model
{
    public function sendNotif($params){
        $param_set = json_encode($params);
        $link = curl_init(LINK_API."/message/send");
        curl_setopt($link, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($link, CURLOPT_POSTFIELDS, $param_set);
        curl_setopt($link, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($link, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        
        $contents = curl_exec($link);
        $result = json_decode($contents, true);
        return $result;
    }
}