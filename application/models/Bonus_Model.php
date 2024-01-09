<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 20/11/2018
 * Time: 06:29
 */

class Bonus_Model extends MY_Model
{
    // типы задач и значения счетчика по-умолчанию
    private $typeCounters = array(
        TASK_VIEW => 0,
        TASK_LIKE => 0,
        TASK_SUBSCRIBE  => 0,
        TASK_COMMENT    => 0
    );

    private $typeTargetCounters = array(
        TASK_VIEW => 90,
        TASK_LIKE => 15,
        TASK_SUBSCRIBE  => 3,
        TASK_COMMENT    => 5
    );

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->model('Complete_Model', 'Complete');

        // сдвиг по времени
        $offset = time() - strtotime(date('Y-m-d 00:00:00'));

        // подсчет завершенных выполнений по типу задачи
        $finished = $this->Complete->countFinishedByType($this->user->id, $offset);

        foreach ($finished as $item) {
            if(isset($this->typeCounters[$item->type_id])) {
                $this->typeCounters[$item->type_id] = $item->total;
            }
        }
    }

    public function isTargetsReach()
    {
        $reach = 0;
        foreach($this->typeCounters as $id=>$counter) {
            $reach += ($counter >= $this->typeTargetCounters[$id]);
        }

        return ($reach >= count($this->typeTargetCounters));
    }

    public function getData()
    {
        // подсчет процента для прогрессбара
        $result = array();

        foreach($this->typeCounters as $id=>$count) {
            $result[$id] = array(
                'total'     => $count,
                'target'    => $this->typeTargetCounters[$id],
                'percent'   => $count*100 / $this->typeTargetCounters[$id],
            );
        }

        return $result;
    }
}