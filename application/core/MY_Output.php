<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Output extends CI_Output
{
    /**
     * Выводит данные в формате JSON
     * @param $data массив данных, который нужно возвратить в JSON
     */
    function json($data)
    {
        $this->set_content_type('application/json');
        $this->final_output = json_encode($data);
        $this->_display();
        exit;
    }
}