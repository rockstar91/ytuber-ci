<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller 
{
	public function index()
	{
        $this->load->model('User_Model', 'User');

        $this->db->select('id, time, user_id, status, sum');
        $this->db->where('id <', 83967);
        $this->db->where('time >', time() - 86400*30);
        $this->db->where('status', 1);
        $this->db->order_by("time", "desc");
        //$this->db->limit(100);
        $query = $this->db->get('payments');

        foreach($query->result() as $payment)
        {
        	$increaseSum = $payment->sum * 2;

        	echo $payment->user_id . ' - ' . $increaseSum . '<br/>' . PHP_EOL;
        	//$this->User->increaseBalance($payment->user_id, $increaseSum);
        }
	}
}