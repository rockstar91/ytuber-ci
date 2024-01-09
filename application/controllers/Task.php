<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Controller {

	private $name = 'task';

 	public function __construct() 
 	{
 		parent::__construct();

        $this->load->helper('user');
    	$this->user = get_user();

		if(!$this->user) {
			redirect('auth/login');
		}

        $this->load->model('Task_Model', 'Task');
        $this->load->model('Category_Model', 'Category');
        $this->load->model('Type_Model', 'Type');
        $this->load->model('User_Model', 'User');
        $this->load->model('Comment_Model', 'Comment');
        $this->load->model('Geo_Model', 'Geo');
        $this->load->library("pagination");

		$this->lang->load('task');
 	}

 	public function devkey()
 	{
 		echo google_random_dev_key();
 	}

 	public function _rules() {
 		return array(
			/* Просмотры */ 
			1 => array(
				'rules' => array(
					array(
						'field' => 'extend[time]',
						'name'  => $this->lang->line('view_time'), 
						'rule'  => 'trim|required|integer|greater_than_equal_to[45]|less_than_equal_to[600]|callback__extra_time' //callback__extra_time
					)
				),
				'fields' => array('time'),
				'url' => array(
					'placeholder' => '',
					'callback' => ''
				)
			),
			/* Лайки */ 
			2 => array(
				'rules' => array(
					array(
						'field' => 'extend[type]',
						'name'  => $this->lang->line('like_type'), 
						'rule'  => 'trim|required|integer|callback__extra_type'
					)
				),
				'fields' => array('type'),
				'url' => array(
					'placeholder' => '',
					'callback' => 'callback__url|callback__url_blacklist'
				)
			),
			/* Комментарии */
			3 => array(
				'rules' => array(
					array(
						'field' => 'extend[comment_type]',
						'name'  => $this->lang->line('comment_type'), 
						'rule'  => 'trim|required|integer|greater_than[0]'
					),
					array(
						'field' => 'extend[comment_text]',
						'name'  => $this->lang->line('comment_text'), 
						'rule'  => 'trim|callback__comment_text'
					)
				),
				'fields' => array('comment_type', 'comment_text')
			),
			/* Подписки */
			4 => array(
				'rules' => array(),
				'url' => array(
					'placeholder' => 'https://www.youtube.com/channel/UCnASDJNJHpyO7WUbQ6AAeHA',
					'callback' => 'callback__url_channel|callback__url_exists'
				)
			),
			/* Модерируемое */
			101 => array(
				'rules' => array(),
				'fields' => array(),
				'url' => array(
					'placeholder' => '',
					'callback' => ''
				)
			),
			102 => array(
				'rules' => array(),
				'fields' => array(),
				'url' => array(
					'placeholder' => '',
					'callback' => ''
				)
			),

            /* Ответы на комментарии */
            201 => array(
                'rules' => array(
                    array(
                        'field' => 'extend[comment_id]',
                        'name'  => 'ID-комментария',
                        'rule'  => 'trim|required'
                    ),
                    array(
                        'field' => 'extend[comment_type]',
                        'name'  => $this->lang->line('comment_type'),
                        'rule'  => 'trim|required|integer|greater_than[0]'
                    ),
                    array(
                        'field' => 'extend[comment_text]',
                        'name'  => $this->lang->line('comment_text'),
                        'rule'  => 'trim|callback__comment_text'
                    )
                ),
                'fields' => array('comment_id', 'comment_type', 'comment_text')
            ),

            /* Комментарии */
            TASK_COMMENT_LIKE => array(
                'rules' => array(
                    array(
                        'field' => 'extend[comment_id]',
                        'name'  => 'ID-комментария',
                        'rule'  => 'trim|required'
                    ),
                ),
                'fields' => array('comment_id')
            ),
		);
 	}

	/* Index */
	public function index() 
	{
        $this->load->helper('yt');
        
		$type_id = ((int)$this->input->get('type_id')) ? (int) $this->input->get('type_id') : null;

		$data['pageTitle'] = $this->lang->line('task_list_title');

		// Типы задач 
		$data['types'] = $this->Type->getAllItems(); 

		// pagination
		$config = $this->config->item('pagination');
		$config['base_url']    = base_url($this->name);
		$config['total_rows']  = $this->Task->getTotal($this->user->id, $type_id);
		$config['reuse_query_string'] = true;
		$config['uri_segment'] = 2;

        $this->pagination->initialize($config);

		$page = (int) $this->uri->segment($config['uri_segment']);

		$results = $this->Task->getItems($this->user->id, $config["per_page"], $page, $type_id);
		foreach($results as &$item) {
		    $item = $this->Task->_extendItem($item);
			// категория
			$category = $this->Category->getItem($item->category_id);
			$item->category = isset($category->name) ? $category->name : '-';

			// тип
			$type = $this->Type->getItem($item->type_id);
			$item->type = isset($type->name) ? $type->name : '-';
		}
        $data["results"] = $results;
		$data['pagination'] = $this->pagination->create_links();
		
		if($this->user->admin) {
			$this->tpl->load('task/listnew', $data);
		} 
		else {
			$this->tpl->load('task/listnew', $data);
		}
	}

	public function report() {
		$id     = $this->input->post('id');
		$reason = $this->input->post('reason');

		$task = $this->Task->getItem($id);

		if($task) {
			// Проверка наличия жалоб к задаче, перед добавлением новой
			$this->db->where('user_id', $this->user->id);
			$this->db->where('task_id', $id);
			$amount = $this->db->count_all_results('report');
			if($amount) {
				$this->output->json(array('status' => 'error', 'text' => $this->lang->line('error_report_exists')));
			}

			// Добавление жалобы
			$data = array(
				'user_id'	=> $this->user->id,
				'task_id'	=> $id, 
				'reason'	=> $reason,
				'time'		=> time()
			);

			$this->db->insert('report', $data);

			// Увеличиваем счетчик жалоб
			$this->db->where('id', $id);
			$this->db->set('report', 'report+1', false);
			$this->db->update('task');

			$this->output->json(array('status' => 'success', 'text' => $this->lang->line('success_report')));
		} 
		else {
			$this->output->json(array('status' => 'error', 'text' => $this->lang->line('error_task_not_found')));
		}
	}

	function get_region() {
		$country_id = (int) $this->input->get('country_id');
		$regions = $this->Geo->getRegionList($country_id);
		if(!empty($regions)) {
			$this->output->json(array('status' => 'success', 'regions' => $regions));
		}
		else {
			$this->output->json(array('status' => 'error', 'text' => 'error text'));
		}
	}

	function get_city() {
		$region_id = (int) $this->input->get('region_id');
		$cities = $this->Geo->getCityList($region_id);
		if(!empty($cities)) {
			$this->output->json(array('status' => 'success', 'cities' => $cities));
		}
		else {
			$this->output->json(array('status' => 'error', 'text' => 'error text'));
		}
	}

	function parse_info($return = null) {
		$this->load->helper('yt');
		$this->load->helper('google');

		$type_id = $this->input->post('type_id');
		$url     = $this->input->post('url');

        // исправление ссылки на канал
        if(preg_match('#^http(s){0,1}://www\.youtube\.com/(user/){0,1}([a-zA-Z0-9-_]+)(/){0,1}$#i', $url, $match)) {
            // Проверяем доступность канала пользователя по dev-ключу
            $dev = google_youtube_developer();

            try {
                $listChannels = $dev->channels->listChannels('statistics,snippet,contentDetails', array('forUsername' => $match[3]));


                $items = $listChannels->getItems();
                if(count($items) > 0 && $item = $items[0])
                {
                    print_r($item->id);
                }
            }
            catch(Exception $e) {}
        }

		if(in_array($type_id, array(TASK_VIEW, TASK_LIKE, TASK_COMMENT, TASK_REPLY, TASK_SUBSCRIBE, TASK_VK_SHARE))) {
			$vid = yt_vid($url);
			$channel = yt_channel($url);

			if($vid && $info = google_youtube_get_videoinfo($vid)) {
				if($return) return $info;
				$this->output->json($info);
			}
			else if($channel && $info = google_youtube_get_channelinfo($channel)) {
				if($return) return $info;
				$this->output->json($info);
			}
			else {
				if($return) return false;
				$this->output->json(array('error'));
			}
		}

		return false;
	}
	
	function position_calc() {
		$extend 	 = $this->input->post('extend');
		$action_cost = (double) $this->input->post('action_cost');
		$type_id 	 = (int) $this->input->post('type_id');
		$order_by    = ($type_id == 1 OR $type_id == 10) ? 'order' : 'action_cost';

		$time = isset($extend['time']) ? (int) $extend['time'] : 0;

		if($time < 30) {
			$time = 30;
		}
		else if($time > 600) {
			$time = 600;
		}


		$this->db->select('id, action_cost, order');
		$this->db->where('disabled', 0);
		$this->db->where('type_id', $type_id);
		$this->db->where('total_cost >= action_cost');
		$this->db->limit(100);
		$this->db->order_by($order_by, 'desc');
		$query = $this->db->get('task');

		$order = $time ? $action_cost / $time : false;

		$i=0;
		foreach($query->result() as $item) {
			$i++;

			if($order_by == 'order') {
				if($order > $item->order) {
					$pos = $i;
					break;
				}
			}
			else {
				if($action_cost > $item->action_cost) {
					$pos = $i;
					break;
				}
			}
		}

		echo isset($pos) ? $pos : '&infin;';
	}

	/* Add */
	public function add($param=array()) 
	{
		$data['pageTitle'] = $this->lang->line('task_add_title');

		$this->load->library('form_validation');

		$user = $this->User->getItem($this->user->id);
		if($user->banned > time()) {
			$this->session->set_flashdata('error', sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $user->banned), $user->ban_reason));
			redirect('task/index');
		}
		
		$typeRules = $this->_rules();

		// Дополнительные поля
		$type_id = $this->input->post('type_id') ? (int) $this->input->post('type_id') : 1;
		$typeExtend = isset($typeRules[$type_id]) ? $typeRules[$type_id] : null;
		if($typeExtend) {
			foreach($typeExtend['rules'] as $item) {
				$this->form_validation->set_rules($item['field'], $item['name'], $item['rule']);
			}
		}
		$url_callback = !empty($typeExtend['url']['callback']) ? $typeExtend['url']['callback'] : 'callback__url';
		$data['url_placeholder'] = !empty($typeExtend['url']['placeholder']) ? $typeExtend['url']['placeholder'] : null;
		
		$this->form_validation->set_rules('category_id', $this->lang->line('category'), 'trim|required|integer');
		$this->form_validation->set_rules('type_id', $this->lang->line('type'), 'trim|required|integer');
		$this->form_validation->set_rules('url', $this->lang->line('url'), 'trim|required|callback__url_unique|'.$url_callback);
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|min_length[4]|required');
		$this->form_validation->set_rules('total_cost', $this->lang->line('total_cost'), 'trim|required|numeric|greater_than_equal_to[100]|less_than_equal_to[500000]|callback__total_cost');
		$this->form_validation->set_rules('action_cost', $this->lang->line('action_cost'), 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[500]|callback__action_cost');
		$this->form_validation->set_rules('hour_limit', $this->lang->line('hour_limit'), 'trim|integer');

		if($this->form_validation->run() && !$this->input->post('change_type'))
		{
			// save data
			$addData = array(
				'user_id' 		=> $this->user->id,
				'category_id'	=> $this->input->post('category_id'),
				'type_id'		=> $this->input->post('type_id'),
				'url'			=> $this->input->post('url'),
				'name'			=> $this->input->post('name'),
				'total_cost'	=> $this->input->post('total_cost'),
				'action_cost'	=> $this->input->post('action_cost'),
				'hour_limit'	=> $this->input->post('hour_limit'),
				'geo'			=> 0
			);

			// Информация от ютуб 
			if($youtube = $this->parse_info(true))
			{
				// Определение значения для youtube_initial
				$initial = 0;
				
				if($type_id == TASK_VIEW)
				{
					$initial = $youtube['viewCount'];
				}
				
				if($type_id == TASK_LIKE)
				{
					$extend = $this->input->post('extend');
					if(isset($extend['type']) && $extend['type'] == 1)
					{
						$initial = $youtube['likeCount'];
					} else {
						$initial = $youtube['dislikeCount'];
					}
				}

				if($type_id == TASK_COMMENT)
				{
					$initial = $youtube['commentCount'];
				}

				if($type_id == TASK_SUBSCRIBE)
				{
					$initial = $youtube['subscriberCount'];
				}

				$addData['youtube_initial'] = (int) $initial;
				$addData['youtube_extend']  = serialize($youtube);
			}

			// Сохраняем только разрешенные доп. поля
			$addExtend = array();
			if(isset($typeExtend['fields']) && is_array($this->input->post('extend')))
			{
				foreach($this->input->post('extend') as $key=>$val)
				{
					if(in_array($key, $typeExtend['fields']))
					{
						$addExtend[$key] = $val;
					}
				}
			}
			$addData['extend'] = serialize($addExtend);


			// Сортировка
			if(isset($addExtend['time'])) {
				$addData['order'] = $addData['action_cost'] / $addExtend['time']; 
			}

			// Списываем средства с баланса пользователя
			if($this->User->decreaseBalance($this->user->id, $this->input->post('total_cost'), false)) {
				// Добавляем задание
				if($task_id = $this->Task->addItem($addData)) {


                    // Добавление комментов
                    if(isset($addExtend['comment_text']) && $addExtend['comment_type'] == 4)
                    {
                        $comments = preg_split('#[\r\n]+#', $addExtend['comment_text']);
						//$comments = preg_split('#[\r\n]+#');
						
                        foreach ($comments as $comment)
                        {
                            $this->Comment->addItem(
                                array(
                                    'task_id'       => $task_id,
                                    'comment_text'  => $comment,
                                    'status'        => COMMENT_FREE
                                )
                            );
                        }
                    }

					// геотаргетинг
					$geo = $this->input->post('geo');
					$this->Geo->GeoToTaskRemove($task_id);
					if($geo) {
						$this->Geo->GeoToTaskAdd($task_id, $geo);
					}
					//

					$this->session->set_flashdata('success', $this->lang->line('success_add'));
					redirect('task/index');
				}
			}
		}

		$data['categories'] = $this->Category->getAllItems();
		$data['types'] 		= $this->Type->getAllItems();

		// geoip
		$this->load->helper('geoip');
		$geoip = geoip($this->input->ip_address());

		$data['countries']  = $this->Geo->getCountryList();
		$data['country_code'] = $geoip['country_code'];
		//

		if($this->input->get('light')) {
			$this->load->view('task/add', $data);
		}
		else {
			$this->tpl->load('task/add', $data);
		}
	}

	/* Edit */
	public function edit() 
	{
		$data = array();
		$data['pageTitle'] = $this->lang->line('task_edit_title');

		$id = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
		
		$task = $this->Task->getItemByUser($this->user->id, $id);
		
		$user = $this->User->getItem($this->user->id);
		if($user->banned > time()) {
			$this->session->set_flashdata('error', sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $user->banned), $user->ban_reason));
			redirect('task/index');
		}

		// Проверка принадлежности задачи к пользователю
		if(!$task OR $task->user_id != $this->user->id) {
			$this->session->set_flashdata('error', $this->lang->line('error_permission_denied'));
			redirect('task/index');
		}
		
		if( !$this->user->admin && (time() - strtotime($task->updated)) < (10*60) ) {
			$this->session->set_flashdata('error', $this->lang->line('error_edit_time_limit'));
			redirect('task/index');
		}

		$this->load->library('form_validation');

		$typeRules = $this->_rules();
		// Дополнительные поля
		//$type_id = $this->input->post('type_id') ? $this->input->post('type_id') : 1;
		$typeExtend = isset($typeRules[$task->type_id]) ? $typeRules[$task->type_id] : null;
		if($typeExtend) {
			foreach($typeExtend['rules'] as $item) {
				$this->form_validation->set_rules($item['field'], $item['name'], $item['rule']);
			}
		}
		$url_callback = !empty($typeExtend['url']['callback']) ? $typeExtend['url']['callback'] : 'callback__url';
		$data['url_placeholder'] = !empty($typeExtend['url']['placeholder']) ? $typeExtend['url']['placeholder'] : null;

		$this->form_validation->set_rules('category_id', $this->lang->line('category'), 'trim|required|integer');
		//$this->form_validation->set_rules('type_id', 'Тип задания', 'trim|required|integer');
		//$this->form_validation->set_rules('url', 'Ссылка', 'trim|required|callback__url_unique|'.$url_callback);
		$this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|min_length[4]|required');
		$this->form_validation->set_rules('total_cost', $this->lang->line('total_cost'), 'trim|required|numeric|greater_than_equal_to[100]|less_than_equal_to[500000]|callback__total_cost_edit');
		$this->form_validation->set_rules('action_cost', $this->lang->line('action_cost'), 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[500]|callback__action_cost');
		$this->form_validation->set_rules('hour_limit', $this->lang->line('hour_limit'), 'trim|integer');

		if($this->form_validation->run() && !$this->input->post('change_type')) {
			// save data
			$addData = array(
				'user_id'		=> $this->user->id,
				'category_id'	=> $this->input->post('category_id'),
				//'type_id'		=> $this->input->post('type_id'),
				//'url'			=> $this->input->post('url'),
				'name'			=> $this->input->post('name'),
				'total_cost'	=> $this->input->post('total_cost'),
				'action_cost'	=> $this->input->post('action_cost'),
				'hour_limit'	=> $this->input->post('hour_limit'),
				'geo'			=> 0,
				'disabled'		=> 0
			);

			// Сохраняем только разрешенные доп. поля
			$addExtend = array();
			if(isset($typeExtend['fields']) && is_array($this->input->post('extend'))) {
                            foreach($this->input->post('extend') as $key=>$val) {
                                if(in_array($key, $typeExtend['fields'])) {
                                    $addExtend[$key] = $val;
                                }
                            }
			}
			$addData['extend'] = serialize($addExtend);

			// Сортировка
			if(isset($addExtend['time'])) {
				$addData['order'] = $addData['action_cost'] / $addExtend['time']; 
			}

			if(!$this->_increase OR $this->User->increaseBalance($this->user->id, $this->_increase)) {
				// обновляем задачу
				$this->Task->updateItem($this->user->id, $id, $addData);
				$this->session->set_flashdata('success', $this->lang->line('success_edit'));

                // Добавление комментов
                $this->Comment->removeByTaskId($id);

                if(isset($addExtend['comment_text']) && $addExtend['comment_type'] == 4)
                {
                    $comments = preg_split('#[\r\n]+#', $addExtend['comment_text']);

                    foreach ($comments as $comment)
                    {
                        $this->Comment->addItem(
                            array(
                                'task_id'       => $id,
                                'comment_text'  => $comment,
                                'status'        => COMMENT_FREE
                            )
                        );
                    }
                }

				// геотаргетинг
				$geo = $this->input->post('geo');
				$this->Geo->GeoToTaskRemove($id);
				if($geo) {
					$this->Geo->GeoToTaskAdd($id, $geo);
				}
				//
				redirect('task/index');
			}
			
		}
		
		$task->extend = unserialize($task->extend);
		$data['id']	  = $id;
		$data['edit'] = true;
		$data['task'] = $task;

		// комменты
        $comments = $variants = $this->Comment->getItemsBy(array('task_id' => $task->id, 'status !=' => COMMENT_COMPLETE));
        foreach($comments as $comment)
        {
            $data['comments'][] = $comment->comment_text;
        }


		$data['types'] 		= $this->Type->getAllItems();
		$data['categories'] = $this->Category->getAllItems();

		// geoip
		$this->load->helper('geoip');
		$geoip = geoip($this->input->ip_address());

		$data['countries']  = $this->Geo->getCountryList();
		$data['geo'] = $this->Geo->getGeoToTask($id);
		$data['country_code'] = $geoip['country_code'];
		//

		$this->tpl->load('task/edit', $data);
	}
	
	/* Remove */
	public function remove() 
	{
		$id = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
		if($task = $this->Task->getItem($id)) {
			if($this->user->admin || $this->user->id == $task->user_id) {

				if(!$this->user->admin && strtotime($task->added) > (time() - 3600)) {
					$this->session->set_flashdata('error', $this->lang->line('error_remove_time'));
					redirect('task/index');
				}

				if($this->User->increaseBalance($task->user_id, $task->total_cost)) {
					if($this->Task->removeItem($task->user_id, $id)) {

                        $this->Comment->removeByTaskId($id); // удаляем комменты

						$this->Geo->GeoToTaskRemove($id); // удаляем связи гео

						$this->session->set_flashdata('success', sprintf($this->lang->line('success_remove'), $id));
						redirect($this->user->admin ? $_SERVER['HTTP_REFERER'] : 'task/index');
					}
				}
			}
		}
		$this->session->set_flashdata('error', sprintf($this->lang->line('error_remove'), $id));
		redirect('task/index');
	}

	function csv() {
		$id = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
		$soc = $this->uri->segment(4);

		$data['pageTitle'] = 'Статистика по задаче '.$id;

		if($task = $this->Task->getItem($id)) {
			if($this->user->admin || $this->user->id == $task->user_id) {
				// Получение меток по задаче
				$this->db->select('task_id, user_id, time');
		        $this->db->where('task_id', (int) $id);
		        $this->db->where('status', COMPLETE_FINISHED);
		        $this->db->order_by('time DESC');
		        $query = $this->db->get('done');

		        $csv = '';

		        foreach($query->result() as $row) {
		        	$user = $this->User->getItem($row->user_id, $soc);
		        	if($user) {
		        		$csv .= $row->user_id.';'.$user->$soc.';'.date('Y-m-d H:i:s', $row->time)."\r\n";
		        	}
		        } 
			}
		} 

		if(!empty($csv)) {
			$fname = $id.'-'.date('Y-m-d H:i');
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename={$fname}.csv");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $csv;
		}
		else {
			show_404();
		}

	}

	/* Recalc */
	public function done_recalc() 
	{
		//if(!$this->user->admin)
        //{
        //    $this->output->json(array('error' => 'В данный момент функция не доступна....'));
        //    return false;
		// }

		$this->load->model('Refund_Model', 'Refund');
        $this->load->model('Youtube_Model', 'Youtube');

		$timeOffset = 86400 * 1;

		$id = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;

		$task = $this->Task->getItemByUser($this->user->id, $id);

		//if($this->User->monthPaymentsSum($this->user->id) < 100 && !$this->user->admin && $this->user->id != 349848) {
		//	$this->output->json(array('error' => 'Эта функция доступна только для пользователей, купивших баллы более чем на 100 р. за последний месяц.'));
		//}

		if($this->User->monthCoinsSum($this->user->id) <= $this->User->monthRefundSum($this->user->id) And !$this->user->admin)
		{
			$this->output->json(array('error' => 'Превышен лимит возвратов для вашего аккаунта.'));
		}

		if($task && strtotime($task->added) > (time() - $timeOffset)) {
			$this->output->json(array('error' => 'Задача добавлена менее суток назад, статистика по ней еще недоступна.'));
		}

		$doneStat = $this->Task->getDoneStat($id, $timeOffset);
		if($task && $doneStat && ( $task->type_id == TASK_VIEW OR $task->type_id == TASK_LIKE OR $task->type_id == TASK_SUBSCRIBE OR $task->type_id == TASK_COMMENT) ) {
			/*
			echo '<pre>';
			print_r($doneStat);
			echo '</pre>';
			*/ 

			// Заявленное кол-во выполнений задачи (меньшее)
			//$action_done = $task->action_done > $doneStat['count'] ? $task->action_done : $doneStat['count'];
			$action_done = $task->action_done - $doneStat['count'];
			//$action_done = $task->action_done;

			// Кол-во просмотров согласно ютубу
            $youtube = $this->Youtube->getRelevantCounter($task);

            if(!$youtube) {
                $this->output->json(array('error' => 'Не удалось получить информацию от API Youtube.'));
            }

			// Реальное увеличение кол-ва просмотров
			$youtubeRising = $youtube - $task->youtube_initial;

			// Разница между заявленным и реальным увеличением кол-ва просмотров
			$youtubeRisingDifference = $action_done - $youtubeRising - $task->action_refund;

			/*
			echo 'Заявленное увеличение просмотров (-3 дня): '. $action_done . '</br>';
			echo 'Реальное увеличение просмотров: '.$youtubeRising .'</br>';
			echo 'Кол-во ранее списанных просмотров:' .$task->action_refund . '</br>';
			echo 'Разница между заявленное/реальное: '.$youtubeRisingDifference . '</br>';  
			echo 'Средняя цена: '.$doneStat['average_cost'].'</br>';
			*/

			$text = 'Ytuber:'.($action_done-$task->action_refund).', Youtube: '.$youtubeRising.', Расхождение: '.$youtubeRisingDifference.'. ';

			if($youtubeRisingDifference > 0) {
				$doneStat['average_cost'] = $doneStat['average_cost'] ?: $task->action_cost;
				$refundCost = $youtubeRisingDifference * $doneStat['average_cost']; 

				if($youtubeRisingDifference < ($task->action_done * 0.6) or $this->user->admin) {
					// Списание баллов у системы
					if($this->User->decreaseBalance(ACCOUNT_REFUND, $refundCost, false)) {

						// Обновление задачи
				        $this->db->where('id', $id);
				        $this->db->set('total_cost', 'total_cost+'.$refundCost, false);
				        $this->db->set('action_refund', 'action_refund+'.$youtubeRisingDifference, false);
				        $this->db->set('disabled', 0);
				        $this->db->update('task');

				        $text .= sprintf('На баланс задачи возвращены %1$s.', yt_cost_format($refundCost));


				        // Добавление записи о возврате в БД
						$data = array(
							'user_id' 	=> $this->user->id,
							'task_id'	=> $id,
							'value'		=> $refundCost,
							'created_at'=> date('Y-m-d H:i:s')
						);
						$add = $this->Refund->addItem($data);


					} 
					else {
						$text .= 'Возврат невозможен, задача слишком старая.';
					}
				}
				else {
					$text .= 'Возврат баллов в данный момент невозможен, дождитесь обновления статистики по задаче.';
				}

				//echo 'Возврат баллов: '. $refundCost;
			} 
			else {
				//$text .= 'Расхождение не обнаружено.';
			}

			// сообщаем о выполнении
    		$this->output->json(array('status' => 'success', 'text' => $text));
		}

		$this->output->json(array('error' => 'Статистика еще недоступна, попробуйте позже.'));

	}

	function _url($url) 
	{
		if(preg_match('#^http(s){0,1}://(www|m)\.youtube\.com/watch\?v=([a-z0-9-_]{11})(\&t=[a-z0-9-_]{2,8}){0,1}$#i', $url)) {
			$result = true;
		}
		else if(preg_match('#^http(s){0,1}://youtu\.be/([a-z0-9-_]{11})(\?t=[a-z0-9-_]{2,8}){0,1}$#i', $url)) {
			$result = true;
		}
		else {
			$this->form_validation->set_message('_url', $this->lang->line('valid_url'));
			return false;
		}

		return $result;
	}

	function _url_channel($url) 
	{
		$url = str_replace('?view_as=subscriber', '', $url);

		if(preg_match('#^http(s){0,1}://www\.youtube\.com/channel/([a-z0-9-_]{24})$#i', $url)) {
			return $url;
		}
		else {
			$this->form_validation->set_message('_url_channel', $this->lang->line('valid_url_channel'));
			return false;
		}

		return $url;
	}

	function _url_unique($url) 
	{
		$id = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
		$type_id = $this->input->post('type_id');
		
                //if($type_id == TASK_SUBSCRIBE OR $type_id == TASK_LIKE) {
                    if($this->Task->isItemExist($url, $id, $type_id, $this->user->id)) {
                        $this->form_validation->set_message('_url_unique', $this->lang->line('valid_url_unique'));
                        return false;
                    }
                //}

		return true;
	}

    function _valid_url_format($str){
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str)){
            $this->form_validation->set_message('_valid_url_format', $this->lang->line('valid_url_format'));
            return FALSE;
        }
        return TRUE;
    }       

    function _url_exists($url){                                   
        $url_data = parse_url($url); // scheme, host, port, path, query
        if(!fsockopen($url_data['host'], isset($url_data['port']) ? $url_data['port'] : 80)){
            $this->form_validation->set_message('_url_exists', $this->lang->line('valid_url_exists'));
            return FALSE;
        }
        return TRUE;
    }

    function _url_blacklist($url) {
        $blacklistVids = array(
			'304zZRMZUoQ',
			'v7UXJ5fJ0H0',
			'gXC77Y_QIbc',
			'vCwxplOGtfY',
			'Ie73pQbEXU4',
			'o4KitYl8vpU',
			'n0O47DdhATw',
			'sJ8UZj36TMQ',
			'lKpPa430rcw',
			'Af8nNyn9a_c',
			'8kOUv9EVQTQ',
			'pVMvsuhrwWs',
			'gqc3jHl6YcM',
			'f8IHrJf-v4w',
			'7Y4YsWPYg4s',
			'iRqMhrVT8pM',
			'bLG-v5bLHNs',
			'VHfUDBr0p4Q',
			'cJLZebMtW7A',
			'ANYrUhhlKyw',
			'PO9kd1cqCyA',
			'zAXDi2PvWz4',
			'HE4u2vprC88',
			'VT-zl1Xay4A',
			'k7VUlw8gHZs',
			'hvPddB5Lc1s',
			'XmeoZUiGwBM',
			'ajtv-urp18I',
			'f1KpZOQSZgQ',
			'KFBS2wgOzrs',
			'scOLgA4HPqM',
			'sxUZ_TwgMdQ',
			'ZvyXuUJ__Ag',
			'Duyq7P53pH4',
			'ox7DwsF0YG0',
			'ayQj0W9rd8o',
			'8RIyq8nZ9EQ',
			'C1L06upDI98',
			'_ahC-OK0dp4',
			'jseYAjJkab8',
			'FO9mQWUeSuA',
			'WBaKEl5HIzU',
			'XmtGo4BE1bw',
			'NXwfvUwUKLc',
			'fHdiWCw-EBQ',
			'qC5GNBHceJk',
			'hxPXzLu0P3g',
			'U56YIEA3-U4',
			'TpseuZU8lBY',
			'VXfpDJruyVs',
			'dV0OLE16wzg',
			'OSQeYSXjCfw',
			'GkpOGG_cxM0',
			'lu1LHG7t9vA',
			'CDklNSpLB9g',
			'IbV-DC3z8jI',
			'nFWxi3zbsNo',
			'huvdLUEruBM',
			'9L9xTWQLZZ8',
			'1HGrDmukmvc',
			'oVf6AyxJjd0',
			'D2Qz6s8eNoU',
			'HX2pDdILM7U',
			'iBPJimtw7k0',
			'2hg0mjR-M30',
			'TM-z3NUojII',
			'u28Gqg_V7eE',
			'n-LzQXs3x9o',
			'MIA1tpRglGg',
			'kj503mBQXq8',
			'NfcmzqaQyC0',
			'JHP3Fuf2KyA',
			'frU2mqIMrPs',
			'VgsPDOcPV7c',
			'BPiw6b-Sm_c',
			'cqzGSjx7Gvg',
			'CFWkoe5dsc0',
			'lOMxNoyW_NE',
			'Xh7uwbKVmfA',
			'PwJsksBs4Ek',
			'B7BHeVD-smk',
			'RyHzFDGgqKA',
			'bxy4oLXTcyI',
			'U6vunPg3OGw',
			'1pLziv7Ri_k',
			'oIED8ehn2Is',
			'o1UXfSxosOk',
			'jxrd7pZTkvI',
			'1_IcoSaNKP4',
			'cRRwnezXMcw',
			'JrClDJb8WTM',
			'5a59bBR480M',
			'XllES56exkk',
			'oBP1cYCLARA',
			'-Kh9JZ34zRc',
			'b2rxvzj55Q0',
			'd6xjRRXeOnc',
			'Y-eITaok1Gw',
			'Nj0li7AdsvM',
			'aoKerAFdZwg',
			'NGI3ANOf18U',
			'WjbLMKON_s8',
			'ciXeqvKDKSI',
			'VrfCLF74L50',
			'alnV3DYCDlg',
			'XFrmhhM1ogg',
			'BbtWl3n-GNg',
			'c4b7iyg8v5U',
			'jObP8pTt7FY',
			'x4TlTKt211Q',
			'1YiVgB9jqyU',
			'ludvy76HGSU',
			'ti8J19zY0EM',
			'gjKvdBrJUPk',
			'DQfiBquc-L4',
			'guGybOqTF64',
			'P7_rUkk8clU',
			'AGjYrwqilNA',
			'C3yZJ_1xL-8',
			'DHjZm9lugow',
			'1f8dQOhEADk',
			'0GEBViPVBbo',
			'aABAJy6-kdM',
			'IHmGfrQFc6Y',
			'dvKPBN_kpRI',
			'zaZGEW8sdV4',
			'gjTGr8j6-DA',
			'7MqiSqkO_cE',
			'qwIRfgn1Tog',
			'DxMopz1mTLw',
			'6_cH35u4ouM',
			'3PJJTDkppUg',
			'OR0Vk7V6zeo',
			'0mrBnaOU3I0',
			'fD9JsB2qEmM',
			'nb3L-k69yx8',
			'LCb8ix8Bl64',
			'DZtR54pp68Q',
			'MZqtJ1IrRNI',
			'awsVIxZlskQ',
			'BUfY5YcnN-U',
			'aoKerAFdZwg',
			'NGI3ANOf18U',
			'WjbLMKON_s8',
			'ciXeqvKDKSI',
			'VrfCLF74L50',
			'alnV3DYCDlg',
			'XFrmhhM1ogg',
			'BbtWl3n-GNg',
			'c4b7iyg8v5U',
			'jObP8pTt7FY',
			'x4TlTKt211Q',
			'1YiVgB9jqyU',
			'ludvy76HGSU',
			'ti8J19zY0EM',
			'gjKvdBrJUPk',
			'DQfiBquc-L4',
			'guGybOqTF64',
			'P7_rUkk8clU',
			'AGjYrwqilNA',
			'C3yZJ_1xL-8',
			'DHjZm9lugow',
			'1f8dQOhEADk',
			'0GEBViPVBbo',
			'aABAJy6-kdM',
			'IHmGfrQFc6Y',
			'dvKPBN_kpRI',
			'zaZGEW8sdV4',
			'gjTGr8j6-DA',
			'7MqiSqkO_cE',
			'qwIRfgn1Tog',
			'DxMopz1mTLw',
			'6_cH35u4ouM',
			'3PJJTDkppUg',
			'OR0Vk7V6zeo',
			'0mrBnaOU3I0',
			'fD9JsB2qEmM',
			'nb3L-k69yx8',
			'LCb8ix8Bl64',
			'DZtR54pp68Q',
			'MZqtJ1IrRNI',
			'awsVIxZlskQ',
			'BUfY5YcnN-U',
			'gDkKJnhAaFM',
			'KPS2Dl2qXXI',
			'frt8tQOrjiM',
			'XZsM8cH8tH0',
			'UBrxUXd1ERo',
			'V3UJnY8kdEk',
			'GBkFckLoo4k',
			'6o5gb_jY9jE',
			'F9Ofv2mqMI8',
			'tCEloXovK_0',
			'JLgiI94BX98',
			'94gS_l6lDok',
			'19G3sqCPuyA',
			'slublgaBteM',
			'iD6BNckyBrY',
			'JqH7rxZIhgs',
			'FR3kLafp3G0',
			'GTGUX2ZNWVM',
			'OzYiytuVSjM',
			'KvODHCOvS-4',
			'eh_bSm35mcg',
			'HY2Ev4ocKuA',
			'1BvkeZOD7dk',
			'HJQLYf1BCDQ',
			'WjhXkj-UmPo',
			'Uar5ylJ7Iw4',
			'JHswURWvGEU',
			'ZdCFsB1DSEc',
			'TqGz6ajblpo',
			'gZloer_abBI',
			'EF154Ca7xI8',
			'WSDtdTKzMYU',
			'tAypCO7320s',
			'6cTkpjIJT6E',
			'E6owbf5hCuM',
			'sTIpLHe9V5o',
			'E5UPP3FYS_M',
			'WY6SZOehu5g',
			'aVOW--xVdTE',
			'T5QPMrxu3EQ',
			'h6-ONYbmx-U',
			'WZ65qavlkb8',
			'QvwQmBJwIaE',
			'BHyqWkczFiY',
			'gOHJ7hR3uB8',
			'waRlVCiSVIg',
			'tyQSeE9plfE',
			'MCThBnmrPf0',
			'MBD0fIF9T34',
			'sWtEr5j1ulM',
			'dtWVSrTMb_4',
			'DJEffRnrnak',
			'mIGLcKd9BC8',
			'XGn_9awRnQM',
			'VqR3e5UTUKA',
			'-3lgn11B7sA',
			'sWtEr5j1ulM',
			'dtWVSrTMb_4',
			'DJEffRnrnak',
			'mIGLcKd9BC8',
			'XGn_9awRnQM',
			'VqR3e5UTUKA',
			'-3lgn11B7sA',
			'u1pB2kGKf8o',

        );

        $type_id = $this->input->post('type_id');
        $extend = $this->input->post('extend');

        if($type_id == TASK_LIKE AND $extend['type'] == 2)
        {
            foreach($blacklistVids as $vid)
            {
                if (strpos($url, $vid) !== false)
                {
                    $this->form_validation->set_message('_url_blacklist', 'Этот ролик нельзя добавить');
                    return false;
                }
            }
        }

        return true;
    }

	function _total_cost($total_cost) 
	{
		$user = $this->User->getItem($this->user->id);

		if($user->admin) {
		    return true;
        }

		if(!$user OR $user->balance < $total_cost) {
			$this->form_validation->set_message('_total_cost', $this->lang->line('valid_total_cost'));
			return false;
		}
		return true;
	}

	function _total_cost_edit($total_cost) 
	{
		$id = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
		$task = $this->Task->getItemByUser($this->user->id, $id);
		$user = $this->User->getItem($this->user->id);

		//if($user->admin) {
		//    return true;
        //}

		if(!$user OR !$task OR ($user->balance + $task->total_cost) < $total_cost) {
			$this->form_validation->set_message('_total_cost_edit', $this->lang->line('valid_total_cost'));
			return false;
		}

		$this->_increase = $task->total_cost - $total_cost;
		return true;
	}

	function _action_cost($action_cost) 
	{
		// общая цена не может быть меньше цены за дейсвие
		$total_cost = $this->input->post('total_cost');

		if($total_cost < $action_cost) {
			$this->form_validation->set_message('_action_cost', $this->lang->line('valid_action_cost'));
			return false;
		}
		return true;
	}


	function _extra_time($time) 
	{
		$action_cost = $this->input->post('action_cost');

		$tpl = 'Поле Цена должно содержать значение больше или равно %s.';

		if($time >= 600 && $action_cost < 1.2) {
			$min = 1.2;
		}
		else if($time >= 300 && $action_cost < 1) {
			$min = 1;
		}
		else if($time >= 180 && $action_cost < 0.8) {
			$min = 0.8;
		}
		else if($time >= 90 && $action_cost < 0.65) {
			$min = 0.65;
		}
		else if($time >= 60 && $action_cost < 0.6) {
			$min = 0.6;
		}

		if(isset($min)) {
			$this->form_validation->set_message('_extra_time', sprintf($tpl, $min));
			return false;
		}

		return true;
	}


	function _comment_text($text) 
	{
		$extend = $this->input->post('extend');
		$total_cost = $this->input->post('total_cost');
		$action_cost = $this->input->post('action_cost');
	
		if(isset($extend['comment_type']) && $extend['comment_type'] != 4) {
			return true;
		}
	
		$minComments = @floor($total_cost / $action_cost);
		$minSymbols  = 5;
		
		$error = 0;

		
		$ex = preg_split('#[\r\n]+#', $text);
		//$ex = explode(PHP_EOL, $text);
		
		if(count($ex) < $minComments) {
			$error++;
		}
		
		foreach($ex as $str) {
		    // вырезание ссылок
            $str = preg_replace('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', '', $str);
            // trim
			$str = trim(strip_tags($str));

			if(mb_strlen($str) < $minSymbols) {
				$error++;
			}
		}
		
		if($error > 0) {
			$this->form_validation->set_message('_comment_text', sprintf($this->lang->line('valid_comment_text'), $minComments, $minSymbols));
			return false;
		}
		
		return implode("\r\n", $ex);
	}

	function _extra_type($type) 
	{
		$allow = array(1, 2);
		if(!in_array($type, $allow)) {
			$this->form_validation->set_message('_extra_type', $this->lang->line('valid_extra_type'));
			return false;
		}

		return true;
	}


}

/* End of file task.php */
/* Location: ./application/controllers/task.php */