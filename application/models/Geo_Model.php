<?php

class Geo_Model extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->datetime = date('Y-m-d H:i:s');
    }

    function getCountryList()
    {
        $query = $this->db->get('geo_country');
        $query = parent::_lang($query);
        return $query->result();
    }

    function getRegionList($country_id)
    {
        $this->db->where('country_id', (int)$country_id);
        $query = $this->db->get('geo_region');
        $query = parent::_lang($query);
        return $query->result();
    }

    function getCityList($region_id)
    {
        $this->db->where('region_id', (int)$region_id);
        $query = $this->db->get('geo_city');
        $query = parent::_lang($query);
        return $query->result();
    }

    function getName($id, $table = 'geo_country')
    {
        $this->db->where('id', (int)$id);
        $query = $this->db->get($table);
        $query = parent::_lang($query);
        return isset($query->row()->name) ? $query->row()->name : '-';
    }

    function get($by = null, $table = 'geo_country')
    {
        if (!is_array($by)) {
            return false;
        }

        foreach ($by as $key => $val) {
            if (empty($key) OR empty($val)) {
                return false;
            }
            $this->db->where($key, $val);
        }

        $query = $this->db->get($table);
        return $query->result();
    }

    function getUserGeoData()
    {
        $this->load->helper('geoip');
        $geoip = geoip($this->input->ip_address());

        $result = (object)[
            'geoip' => $geoip,
            'country' => null,
            'region' => null,
            'city' => null
        ];

        // определение страны
        $result->country = $this->getCountryByCountryCode($geoip['country_code']);

        // определение региона (если определена страна и есть country_code)
        if ($result->country && !empty($geoip['region_code'])) {
            $result->region = $this->getRegionByCountryCodeRegionCode($geoip['country_code'], $geoip['region_code']);
        }

        //определение города
        if ($result->country && $result->region && !empty($geoip['city_name'])) {
            $result->city = $this->getCityByCountryCodeRegionCodeCityName($geoip['country_code'], $geoip['region_code'], $geoip['city_name']);
        }

        return $result;
    }

    function getCountryByCountryCode($country_code)
    {
        $by = array(
            'iso_2' => $country_code
        );

        return $this->db->get_where('geo_country', $by, 1)->row();
    }

    function getRegionByCountryCodeRegionCode($country_code, $region_code)
    {
        $by = array(
            'country_code' => $country_code,
            'iso_code' => $region_code
        );

        return $this->db->get_where('geo_region', $by, 1)->row();
    }

    function getCityByCountryCodeRegionCodeCityName($country_code, $region_code, $city_name)
    {
        $by = array(
            'country_code' => $country_code,
            'region_code' => $region_code,
            'name' => $city_name
        );

        return $this->db->get_where('geo_city', $by, 1)->row();
    }

    function getGeoToTask($task_id)
    {
        $this->db->where('task_id', (int)$task_id);
        $query = $this->db->get('geo_to_task');
        foreach ($query->result() as $item) {
            $result['country'][] = $item->country_id;
            $result['region'][] = $item->region_id;
            $result['city'][] = $item->city_id;
        }

        return isset($result) ? $result : false;
    }


    function geoToTaskRemove($task_id)
    {
        $this->db->where('task_id', (int)$task_id);
        $this->db->delete('geo_to_task');
        return $this->db->affected_rows();
    }

    function geoToTaskAdd($task_id, $data = array())
    {
        if (!is_array($data) OR !isset($data['country'])) {
            return false;
        }

        $i = 0;

        foreach ($data['country'] as $key => $country_id) {
            $insert = array(
                'country_id' => (int)$country_id,
                'region_id' => isset($data['region'][$key]) ? (int)$data['region'][$key] : 0,
                'city_id' => isset($data['city'][$key]) ? (int)$data['city'][$key] : 0,
                'task_id' => (int)$task_id
            );
            $this->db->insert('geo_to_task', $insert);

            $i++;
            if ($i >= 20) {
                break;
            }
        }

        if ($i > 0) {
            $this->db->where('id', (int)$task_id);
            $this->db->set('geo', 1);
            $this->db->update('task');
        }

        return $this->db->affected_rows();
    }
}