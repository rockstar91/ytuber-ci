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

/**
 * Description of Cron
 *
 * @author User
 */

ini_set("memory_limit","256M");

class Service extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();

        $this->load->model('Penalty_Model', 'Penalty');
    }


    public function setGoogleConfig($domain)
    {
        // исправляем 0 на DOMAIN_YTUBER
        $domain = $domain <= 0 ? DOMAIN_YTUBER : $domain;
        // выбираем конфиг
        $config = $this->config->item('google_api');
        $this->config->set_item('google', $config[$domain]);

    }

    /*
     * @param $complete_id, $result
     * @return void
     * 
     */
    public function transfer($complete_id, $result = false)
    {
        if($result) 
        {
            // Перечисляем средства пользователю
            $this->Transfer->completeToUser($complete_id);

            // Меняем статус выполнения    
            $this->Complete->setStatus($complete_id, COMPLETE_FINISHED);
        }
        else 
        {
            // Возвращаем средства на баланс задачи
            $this->Transfer->completeToTask($complete_id);

            // Меняем статус выполнения    
            $this->Complete->setStatus($complete_id, COMPLETE_FAILED);
        }
    }
}
