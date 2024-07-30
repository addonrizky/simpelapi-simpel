<?php if (!defined('BASEPATH')) exit('No direct script access allowed');




class Api_model extends CI_Model
{
	
	public function get_messages_()
	{
		$this->db->select('desk_notifikasi.id, title, message');
		$this->db->from('desk_notifikasi');
		$this->db->join('desk_users', 'desk_users.id = desk_notifikasi.user_id');
		$this->db->where('is_sent', 0);
		$this->db->where('created_date >','2021-07-15');
		$this->db->where('LENGTH(no_hp) >', 10, false);
		$this->db->order_by('desk_notifikasi.id','desc');
		$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_messages()
	{
		$this->db->select('id, konten as message, no_tujuan as no_hp');
		$this->db->from('desk_sms');
		$this->db->where('is_sent', 0);
		$this->db->where('created_date >','2024-01-01');
		$this->db->order_by('id','desc');
		$this->db->limit(10);

		return $this->db->get();
	}
	
	public function update($item_array, $id)
	{
		$this->db->where('id', $id);
		return $this->db->update('desk_sms', $item_array);
	}
	
	public function get_layanan_by_kategori_p()
	{
		$this->db->select('desk_categories.desc as komoditi, count(*) as cnt');
		$this->db->from('desk_tickets');
		$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		$this->db->where('info', 'P');
		$this->db->where('tglpengaduan >=','2024-01-01'); /* test*/
		$this->db->group_by('kategori');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_kategori_i()
	{
		$this->db->select('desk_categories.desc as komoditi, count(*) as cnt');
		$this->db->from('desk_tickets');
		$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		$this->db->where('info', 'I');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('kategori');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_jenis()
	{
		$this->db->select('desk_tickets.info, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		//$this->db->where('is_sent', 0);
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('info');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_media_p()
	{
		$this->db->select('desk_tickets.submited_via, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		$this->db->where('info', 'P');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('submited_via');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_media_i()
	{
		$this->db->select('desk_tickets.submited_via, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		$this->db->where('info', 'I');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('submited_via');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_tl_p()
	{
		$this->db->select('desk_tickets.tl, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		$this->db->where('info', 'P');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('tl');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_tl_i()
	{
		$this->db->select('desk_tickets.tl, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		$this->db->where('info', 'I');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('tl');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_sla_sesuai()
	{
		$this->db->select('desk_tickets.info, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		//$this->db->where('info', 'P');
		$this->db->where('hk <=', 'sla');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('info');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_layanan_by_sla_tdksesuai()
	{
		$this->db->select('desk_tickets.info, count(*) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_categories','desk_categories.id=desk_tickets.kategori');
		//$this->db->where('info', 'P');
		$this->db->where('hk >', 'sla');
		$this->db->where('tglpengaduan >=','2024-01-01');
		$this->db->group_by('info');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}


}
?>