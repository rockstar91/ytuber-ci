<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Router extends CI_Router
{
    /**
     * Set class name
     *
     * @param   string  $class  Class name
     * @return  void
     */
    public function set_class($class)
    {
        $class = str_replace(array('/', '.'), '', $class);
        $class = strtolower($class); 

        // Отключение контроллеров 
        $disable = $this->config->item('disable_controllers');

        if(is_array($disable) && in_array($class, $disable)) {
            $class = null;
        }

        $this->class = $class;
    }
}