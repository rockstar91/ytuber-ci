<?php

class Task_Model extends MY_Model
{

    protected $table = 'task';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->datetime = date('Y-m-d H:i:s');
        $this->now = round(time() / 60) * 60;


        $this->load->model('Geo_Model', 'Geo');
    }

    function _extendAll($items)
    {
        if ($items) {
            foreach ($items as $item) {
                $item = $this->_extendItem($item);
            }
        }

        return $items;
    }

    function _extendItem($item)
    {
        if (isset($item->extend)) {
            $item->extend = @unserialize($item->extend);
        }

        if (isset($item->youtube_extend)) {
            $item->youtube_extend = @unserialize($item->youtube_extend);
        }

        return $item;
    }

    // возвращает количество задач по пользователю

    function getTotal($user_id = null, $type_id = null)
    {
        $this->db->where('removed', 0);

        if ($type_id != null) {
            $this->db->where('type_id', (int)$type_id);
        }
        if ($user_id != null) {
            $this->db->where('user_id', (int)$user_id);
        }
        return $this->db->count_all_results($this->table);
    }

    // возвращает количество задач доступных для выполнения пользователю
    function getTotalAvailable($type_id = null)
    {
        // Геотаргетинг
        //$user_geo = $this->Geo->getUserGeoData();
        //$country_id = isset($user_geo->country->id) ? $user_geo->country->id : 0;
        //$region_id = isset($user_geo->region->id) ? $user_geo->region->id : 0;
        //$city_id = isset($user_geo->city->id) ? $user_geo->city->id : 0;

        $where_type = $type_id > 0 ? 't.type_id = ' . (int)$type_id . ' AND ' : '';

        $sql = "
            SELECT COUNT(t.id) as counter FROM task t
            #LEFT JOIN geo_to_task g2t ON(g2t.task_id = t.id)
            WHERE
                {$where_type}
                #t.completion < NOW() - INTERVAL 1 MINUTE AND
                t.removed  = 0 AND
                t.disabled = 0 AND
                t.total_cost >= t.action_cost AND
                (t.hour_limit > t.hour_done OR t.hour_limit = 0) #AND
                #(
                    #t.geo = 0 OR
                    #(
                    #    g2t.country_id = country_id AND
                    #    g2t.region_id IN(region_id, 0) AND
                    #    g2t.city_id IN(city_id, 0)
                    #)
                #)
        ";

        $query = $this->db->query($sql);

        return ($query->num_rows() > 0) ? $query->row()->counter : false;
    }


    // возвращает задачи доступные для выполнения пользователю
    function getItemsAvailableGeoWithOpened($user_id, $type_id, $order_by, $limit=1, $offset=0, $notDone = false)
    {
        $completeDays = $this->Type->getCompleteDays($type_id);
        $completeTime = $completeDays ? $this->now - ($completeDays * 86400) : $this->now - (90 * 86400);

        // Геотаргетинг
        #$user_geo = $this->Geo->getUserGeoData();
        #$country_id = isset($user_geo->country->id) ? $user_geo->country->id : 0;
        #$region_id = isset($user_geo->region->id) ? $user_geo->region->id : 0;
        #$city_id = isset($user_geo->city->id) ? $user_geo->city->id : 0;

        $where = $notDone ? 'd.time is null AND ' : '';

        $now = time();

        $sql = "
            SELECT t.*, d.user_id, d.task_id, d.time as done, d.status as c_status, t.user_id as author_id, (t.total_cost / t.action_cost) as action_remain,
            ( SELECT COUNT(id) FROM done WHERE task_id = t.id AND expires > ". $now ." AND status = ".COMPLETE_OPENED." ) as opened

            FROM task t
            #LEFT JOIN geo_to_task g2t ON(g2t.task_id = t.id)
            LEFT JOIN done d ON(d.user_id = {$user_id} AND d.task_id = t.id AND d.time > {$completeTime})
            WHERE
                t.removed  = 0 AND
                t.disabled = 0 AND
                t.type_id  = {$type_id} AND
                {$where}
                #t.completion < NOW() - INTERVAL 1 MINUTE AND
                t.total_cost >= t.action_cost AND
                (t.total_cost / t.action_cost) > ( SELECT COUNT(id) FROM done WHERE task_id = t.id AND expires > ". $now ." AND status = ".COMPLETE_OPENED." ) AND
                (t.hour_limit > t.hour_done OR t.hour_limit = 0) #AND
                #(
                #    t.geo = 0 OR
                #    (
                #        g2t.country_id = country_id AND
                #        g2t.region_id IN(region_id, 0) AND
                #        g2t.city_id IN(city_id, 0)
                #    )
                #)
            #GROUP BY t.id
            ORDER BY {$order_by} DESC
            LIMIT {$offset}, {$limit}
        ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // возвращает задачи доступные для выполнения пользователю
    function getItemsAvailableGeo($user_id, $type_id, $order_by, $offset, $limit, $notOwner = false, $notDone = false)
    {
        $completeDays = $this->Type->getCompleteDays($type_id);
        $completeTime = $completeDays ? $this->now - ($completeDays * 86400) : $this->now - (90 * 86400);

        // для просмотров -- час
        if($type_id == TASK_VIEW)
        {
            $completeTime = $this->now - 3600 * 12;
        }

        // Геотаргетинг
        $user_geo = $this->Geo->getUserGeoData();
        $country_id = isset($user_geo->country->id) ? $user_geo->country->id : 0;
        $region_id = isset($user_geo->region->id) ? $user_geo->region->id : 0;
        $city_id = isset($user_geo->city->id) ? $user_geo->city->id : 0;

        $where = $notOwner ? "t.user_id <> {$user_id} AND " : '';
        $where .= $notDone ? 'd.time is null AND ' : '';

        $sql = "
            SELECT t.*, d.user_id, d.task_id, d.time as done, d.status as c_status, t.user_id as author_id FROM task t
            LEFT JOIN geo_to_task g2t ON(g2t.task_id = t.id)
            LEFT JOIN done d ON(d.user_id = {$user_id} AND d.task_id = t.id AND d.time > {$completeTime})
            WHERE
                t.removed  = 0 AND
                t.disabled = 0 AND
                t.type_id  = {$type_id} AND
                {$where}
                #t.completion < NOW() - INTERVAL 1 MINUTE AND
                t.total_cost >= t.action_cost AND
                (t.hour_limit > t.hour_done OR t.hour_limit = 0) #AND
                #(
                #    t.geo = 0 OR
                #    (
                #        g2t.country_id = $country_id AND
                #        g2t.region_id IN($region_id, 0) AND
                #        g2t.city_id IN($city_id, 0)
                #    )
                #)
            #GROUP BY t.id
            ORDER BY {$order_by} DESC
            LIMIT {$offset}, {$limit}
        ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function isItemExist($url, $not_id = null, $type_id = null, $user_id = null)
    {
        $this->db->where('removed', 0);
        $this->db->where('url', $url);
        if ($type_id) {
            $this->db->where('type_id', (int)$type_id);
        }
        if ($not_id) {
            $this->db->where('id <>', (int)$not_id);
        }
        if ($user_id) {
            $this->db->where('user_id', (int)$user_id);
        }
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? true : false;
    }


    function getItems($user_id, $limit = 100, $start = 0, $type_id = null)
    {
        $this->db->limit($limit, $start);
        $this->db->where('removed', 0);
        if ($type_id != null) {
            $this->db->where('type_id', $type_id);
        }
        $this->db->where('user_id', $user_id);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getItemByUser($user_id, $id)
    {
        $this->db->where('id', $id);
        $this->db->where('removed', 0);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function getItem($id, $type_id = null, $fields = null)
    {
        if ($fields) {
            $this->db->select($fields);
        }
        $this->db->where('id', $id);
        $this->db->where('removed', 0);

        if ($type_id)
            $this->db->where('type_id', $type_id);

        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $this->_extendItem($query->row()) : false;
    }

    function addItem($data)
    {
        $data['added'] = $this->datetime;
        $data['updated'] = $this->datetime;
        $this->db->insert($this->table, $data);
        //return $this->db->affected_rows();
        return $this->db->insert_id();
    }

    function removeItem($user_id, $id)
    {
        $data = array(
            'removed' => 1,
            'disabled' => 1,
            'total_cost' => 0
        );
        return $this->updateItem($user_id, $id, $data);
        //$this->db->where('id', $id);
        //$this->db->where('user_id', $user_id);
        //$this->db->delete($this->table);
        //return $this->db->affected_rows();
    }

    function updateItem($user_id, $id, $data)
    {
        $data['updated'] = $this->datetime;
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function decrease($id, $sum = 0)
    {
        $this->db->where('id', $id);
        $this->db->where('total_cost >=', $sum);
        $this->db->set('total_cost', 'total_cost-' . $sum, false);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    function getDoneStat($task_id, $timeOffset = 86400)
    {
        $time = $this->now - $timeOffset;

        $data = array();

        $this->db->select('AVG(action_cost) as average_cost');
        $this->db->where('task_id', (int)$task_id);
        $this->db->where('status', COMPLETE_FINISHED);
        $this->db->where('time <', $time);
        $row = $this->db->get('done')->row();

        if ($row) {
            $data['average_cost'] = $row->average_cost;
        }

        //
        $this->db->select('COUNT(id) as count');
        $this->db->where('task_id', (int)$task_id);
        $this->db->where('status', COMPLETE_FINISHED);
        $this->db->where('time >', $time);
        $row = $this->db->get('done')->row();

        if ($row) {
            $data['count'] = $row->count;
        }

        if (count($data) >= 2) {
            return $data;
        }

        return false;
    }

    function isDoneLimitReach($type_id = 0, $interval = 'hour', $user_id = null)
    {

        $config = $this->config->item($interval, 'done_limits');
        if (!$config) {
            return;
        }

        $time = $this->now - $config['time'];

        $this->db->select('COUNT(id) as total');
        $this->db->where('time >', $time);

        if (is_null($user_id)) {
            $ip_bin = inet_pton($this->input->ip_address());
            $this->db->where('ip_bin', $ip_bin);
        } else {
            $this->db->where('user_id', $user_id);
        }

        // фильтр по типу
        if ($type_id > 0) {
            $this->db->where('type_id', $type_id);
        } else {
            $type_id = 'any';
        }

        $query = $this->db->get('done')->row();

        if ($query->total >= $config[$type_id]) {
            return true;
        }

        return false;
    }

    function countPenalty($user_id, $type_id, $offset = 604800)
    {
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('type_id', (int)$type_id);
        $this->db->where('time >', $this->now - $offset);
        $this->db->where('status', COMPLETE_PENALTY);
        return $this->db->count_all_results('done');
    }

    function updateDisabled($id, $disabled = 0)
    {
        $this->db->where('id', $id);
        $this->db->set('disabled', (int)$disabled);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    function updateYoutube($id, $youtube)
    {
        $this->db->where('id', $id);
        $this->db->set('youtube', (int)$youtube);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }
}