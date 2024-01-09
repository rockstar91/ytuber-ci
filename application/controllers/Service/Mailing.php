<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Copyright 2017 User.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('Service.php');

/**
 * Description of Like
 *
 * @author User
 */
class Mailing extends CI_Controller {
    public function __construct() 
    {

        parent::__construct();

        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        ini_set("memory_limit","256M");
        set_time_limit(0);
    }

    private function getMailingList() 
    {
        $query  = $this->db->get('mailing');
        return $query->result();
    }

    private function updateMailingSended($mailing_id, $sended) 
    {
        $this->db->where('id', $mailing_id);
        $this->db->set('sended', 'sended+'.$sended, false);
        return $this->db->update('mailing');
    }

    private function getAffectedUsers($mailing_id, $admin = false)
    {

        $this->db->select('id, mail, name, lastseen');
        $this->db->where('confirm', '');
        if($admin)
        {
            $this->db->where('admin', $admin);
        }
        $this->db->where('sub_news', true);
        $this->db->where('last_mailing_id <', $mailing_id);
        $this->db->order_by('lastseen');
        //$this->db->limit(100);

        $query  = $this->db->get('user');

        return $query->result();

    }
    

    public function run() 
    {
        $this->load->helper('mail');

        $mailingList = $this->getMailingList();

        foreach ($mailingList as $mailing) {

            $sended = 0;

            // get users
            $users = $this->getAffectedUsers($mailing->id, $mailing->admin);

            foreach ($users as $user) {
                // mail send
                $status = mail_send($user->mail, $mailing->subject, $mailing->body);

                if($status) 
                {
                    echo "mail for {$user->mail} has been sent \r\n";
                    $this->User->updateItem($user->id, array('last_mailing_id' => $mailing->id));
                    $sended++;
                }
            }

            // update sended
            $this->updateMailingSended($mailing->id, $sended);

            echo '<h3>'.$mailing->subject.'</h3>';
            echo '<pre>'; print_r($sended); echo '</pre>';
        }

    }
}
