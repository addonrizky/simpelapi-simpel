<?php if (!defined('BASEPATH')) exit('No direct script access allowed');




class PPid_model extends CI_Model
{
	public function generate_ticketid($kota, $prefix, $tglpengaduan)
	{
		$this->db->trans_start();
		
		$this->db->select('*');
		$this->db->from('desk_counter');
		$this->db->where('tgl', $tglpengaduan);
		$this->db->where('prefix', $prefix);
		
		$query = $this->db->get();
		$ticketid = '';
		
		if($query->num_rows() == 1)
		{
			$counter = $query->row()->counter + 1;
			
			$date = explode('-', $tglpengaduan);
			$newdate = $date[2].$date[1].$date[0];
			$ticketid = $prefix.'-'.$newdate.'-'.str_pad($counter,'3','0',STR_PAD_LEFT);
			
			$this->db->where('tgl', $tglpengaduan);
			$this->db->where('prefix', $prefix);
			$this->db->update("desk_counter", array('counter'=>$counter));
		}
		else
		{
			$counter = 1;
			$date = explode('-', $tglpengaduan);
			$newdate = $date[2].$date[1].$date[0];
			$ticketid = $prefix.'-'.$newdate.'-'.str_pad($counter,'3','0',STR_PAD_LEFT);
			$this->db->insert("desk_counter", array('counter'=>$counter, 'prefix' =>  $prefix, 'tgl'=>$tglpengaduan));
		}
		$this->db->trans_complete();
		return $ticketid;
	}
	
	public function insert_layanan(&$item_data, $item_id = FALSE)
	{
		$item_data2 = $item_data;
		//enum data type
		$enum_array = array('id', 'is_rujuk', 'info', 'shift', 'is_sent', 'status');
		foreach($enum_array as $enum)
		{
			if (array_key_exists($enum, $item_data2))
			{
				$this->db->set($enum, "'".$item_data2[$enum]."'", FALSE);
				unset($item_data2[$enum]);
			}
		}
		
		foreach($item_data2 as $k => $v)
		{
			$this->db->set($k, $v);
		}
		
		
		if($this->db->insert('desk_tickets'))
		{
			$item_data['id'] = $this->db->insert_id();

			return TRUE;
		}
		
		return FALSE;
	}
	
	public function insert_ppid(&$item_data)
	{
		return $this->db->insert('desk_ppid', $item_data);
	}
	
	
	
	
	public function get_jml_ppid($t1 = '', $t2 = '')
	{
		$this->db->select('count(*) as cnt, avg(hk) as hk');
		$this->db->from('desk_tickets');
		$this->db->join('desk_ppid', 'desk_ppid.id = desk_tickets.id');
		$this->db->where('jenis', 'PPID');
		//$this->db->where('tglpengaduan >=','2022-01-01');
		$this->db->where('tglpengaduan >=',$t1);
		$this->db->where('tglpengaduan <=',$t2);
		
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_jml_ppid_keberatan($t1 = '', $t2 = '')
	{
		$this->db->select('count(*) as cnt, avg(hk) as hk');
		$this->db->from('desk_tickets');
		$this->db->join('desk_ppid', 'desk_ppid.id = desk_tickets.id');
		$this->db->where('jenis', 'PPID');
		//$this->db->where('tglpengaduan >=','2022-01-01');
		$this->db->where('keberatan_no <>','');
		$this->db->where('tglpengaduan >=',$t1);
		$this->db->where('tglpengaduan <=',$t2);
		
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_jml_ppid_tanggapan($t1 = '', $t2 = '')
	{
		$this->db->select('count(*) as cnt, avg(hk) as hk');
		$this->db->from('desk_tickets');
		$this->db->join('desk_ppid', 'desk_ppid.id = desk_tickets.id');
		$this->db->where('jenis', 'PPID');
		//$this->db->where('tglpengaduan >=','2022-01-01');
		$this->db->where('tglpengaduan >=',$t1);
		$this->db->where('tglpengaduan <=',$t2);
		$this->db->where('tt_nomor <>','');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_jml_ppid_keputusan($t1 = '', $t2 = '')
	{
		$this->db->select('keputusan as info, count(*) as cnt, avg(hk) as hk');
		$this->db->from('desk_tickets');
		$this->db->join('desk_ppid', 'desk_ppid.id = desk_tickets.id');
		$this->db->where('jenis', 'PPID');
		//$this->db->where('tglpengaduan >=','2022-01-01');
		$this->db->where('tglpengaduan >=',$t1);
		$this->db->where('tglpengaduan <=',$t2);
		$this->db->where('keputusan <>','');
		$this->db->group_by('keputusan');
		//$this->db->order_by('id','desc');
		//$this->db->limit(5);

		return $this->db->get();
	}
	
	public function get_hk_ppid($t1 = '', $t2 = '')
	{
		$this->db->select('avg(TOTAL_HK(tglpengaduan, tl_date)) as cnt');
		$this->db->from('desk_tickets');
		//$this->db->join('desk_ppid', 'desk_ppid.id = desk_tickets.id');
		$this->db->where('jenis', 'PPID');
		//$this->db->where('tglpengaduan >=','2022-01-01');
		$this->db->where('tglpengaduan >=',$t1);
		$this->db->where('tglpengaduan <=',$t2);
		
		return $this->db->get();
	}
}
?>