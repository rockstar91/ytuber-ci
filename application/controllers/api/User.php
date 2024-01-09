<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class User extends Api {

    function getDoneDay() {
        $this->output->json($this->user->done_day);
    }
	
 	function getBalance() {
		$this->output->json($this->user->balance);
 	}

    function ban($user_id, $tasksDisable = true)
    {
        if(!$this->user->admin) {
            die('No have permissions');
        }

        if($user_id <= 0) {
            die('Unknown user');
        }

        $reason = $this->input->get('reason');
        $banDays = $this->input->get('banDays');

        $data = array(
            'banned' => time() + ($banDays * 86400),
            'ban_reason' => $reason
        );
        $result = $this->User->updateItem((int)$user_id, $data);

        if ($tasksDisable) {
            $this->db->where('user_id', (int)$user_id);
            $this->db->update('task', array('disabled' => 1));
        }

        $this->output->json($result);
    }

    function getClientStat() 
    {
        if($this->user->admin) {
            $min5 = date('Y-m-d H:i:s', time() - 5*60);
            $query = $this->db->query("SELECT COUNT(DISTINCT lastip) as total FROM user WHERE lastseen > '{$min5}'")->row();
            if($query) {
                $client_online = $query->total;
            }
        } 
        else {
            // Онлайн
            $this->load->driver('cache');
            $client_online = $this->cache->file->get('client_online');

            if(!$client_online) {
                $min60 = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:00')) - 60*60);
                $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE lastseen > '{$min60}'")->row();
                
                if($query) {
                    $client_online = $query->total + 237;
                }
                
                $this->cache->file->save('client_online', $client_online, 60);
            }
        }

        $data = array(
                'online'	=> $client_online,
                'credits'	=> $this->user->balance,
                'watched'	=> $this->user->done,
                'id'		=> $this->user->id,
                'time'		=> time()
        );

        $this->output->json($data);
    }


}