<?php

function google_random_dev_key() 
{
	//echo dirname(__FILE__) . '/apiKeys.txt';
	$file = file(dirname(__FILE__) . '/apiKeys.txt');

	//print_r($file);
	$key = array_rand($file);

	return $file[$key];
}

function google_youtube_developer() 
{

	// echo google_random_dev_key();
	//$CI =& get_instance();

	require_once(APPPATH.'/libraries/Google/autoload.php');

	//$config = $CI->config->item('google');

	$client = new Google_Client();

	//$client->setClientId($config['client_id']);
	//$client->setClientSecret($config['client_secret']);
	//$client->setRedirectUri($config['redirect_uri']);
	$client->setDeveloperKey( google_random_dev_key() );

	return new Google_Service_YouTube($client);
}

function google_auth_youtube($user=null, $use_auth_token=true) 
{
	return false; 
	
	$CI =& get_instance();

	// если пользователь не передан, берем из сессии
	if(!$user) {
		$CI->load->helper('user');
		$user = get_user();
	}

	if($use_auth_token) {
		$token_json = $CI->session->userdata('google_token');
	}

	require_once(APPPATH.'/libraries/Google/autoload.php');

	$config = $CI->config->item('google');

	$client = new Google_Client();

	$client->setClientId($config['client_id']);
	$client->setClientSecret($config['client_secret']);
	$client->setRedirectUri($config['redirect_uri']);
	$client->setDeveloperKey($config['developer_key']);

	$client->setAccessType('offline');

	$client->addScope('https://www.googleapis.com/auth/youtube');
	$client->addScope("https://www.googleapis.com/auth/youtube.force-ssl");
	$client->addScope('https://www.googleapis.com/auth/youtube.readonly');
	$client->addScope('https://www.googleapis.com/auth/youtubepartner');
	$client->addScope('https://www.googleapis.com/auth/youtubepartner-channel-audit');
	$client->addScope('https://www.googleapis.com/auth/plus.login');

	$refresh_token = $user->refresh_token;

	if(empty($token_json) && empty($refresh_token)) {
		return false;
	}

	try {
		// если есть auth_token, пробуем авторизоваться по нему
		if(!empty($token_json)) {
			$client->setAccessToken($token_json);
		}
		
		// если у пользователя отсутствует refresh_token, отменяем авторизацию
		if(empty($refresh_token)) {
			$client->revokeToken(); // отменяем
			return false;
		}

		// если auth_token просрочен, обновляем по refresh_token
		else if($client->isAccessTokenExpired()) {
			$client->refreshToken($refresh_token);

			// сохраняем auth_token в сессию
			if(!empty($token_json)){
				$CI->session->set_userdata('google_token', $client->getAccessToken());
			}
		}
	}
	catch (Exception $e) {
		return false;
	}

	return new Google_Service_YouTube($client);
}

function google_youtube_check_channel(&$user, $yt=null) {
	$cache_time = 3600;

	$CI =& get_instance();
    $CI->load->model('User_Model', 'User');


    // Если есть кеш (сессия), возвращаем значение
	$channel_available = $CI->session->userdata('channel_available'); 
	if($channel_available && $channel_available > time()) {
		//return true;
	}

	// Если канал или дата регистрации неизвестны, узнаем их и обновляем в бд
	if(empty($user->channel) OR empty($user->channel_published)) { //
		// Получаем авторизацию от пользователя
		$yt = $yt ? $yt : google_auth_youtube($user, false);
		if(!$yt) {
			return false;
		}
		// Узнаем канал
		try {
		    $listChannels = $yt->channels->listChannels('snippet', array(
				'mine' => true
		    ));

		    foreach($listChannels->getItems() as $item) {
		    	$update = array(
		    		'channel' 			=> $item->getId(),
		    		'channel_published' => $item->getSnippet()->getPublishedAt()
		    	);

		    	// обновляем данные в бд
	    		$CI->User->updateItem($user->id, $update);
	    		// обновляем пользователя
		    	$user = $CI->User->getItem($user->id);
			    break;
		    }

		}
		catch(Exception $e) {print_r($e);}
	}

	return true;

	/*

	$dev = google_youtube_developer();

	// Проверяем доступность канала пользователя по dev-ключу
	try {
		$listChannels = $dev->channels->listChannels('id', array('id' => $user->channel));
		if($listChannels->getPageInfo()->getTotalResults() > 0) {
			$CI->session->set_userdata('channel_available', time() + $cache_time);
	    	$CI->User->updateItem($user->id, array('channel_available' => true));

			return true;
		} 
		else {
	    	$CI->User->updateItem($user->id, array('channel_available' => false));
		}
		
		//$listChannels = $dev->channels->listChannels('id', array('snippet' => $user->channel));
	}
	catch(Exception $e) {}

	return false;
	*/
}

function google_youtube_get_videoinfo($vid) {
    $dev = google_youtube_developer();
    try {
        $listVideos = $dev->videos->listVideos('snippet,statistics', array('id' => $vid));

        $items = $listVideos->getItems();
        if(count($items) > 0 && $item = $items[0])
        {
            $snippet 	= $item->getSnippet();
            $statistics	= $item->getStatistics();

            return array(
                'thumbnail'	=> $snippet->getThumbnails()->medium->url,
                'title'		=> $snippet->getTitle(),
                'channelId'	=> $snippet->getChannelId(),
                'viewCount'	=> $statistics->viewCount,
                'commentCount'	=> $statistics->commentCount,
                'likeCount'	=> $statistics->likeCount,
                'dislikeCount'	=> $statistics->dislikeCount,
                'favoriteCount'	=> $statistics->favoriteCount,
            );
        }
    }
    catch(Exception $e) {}

    return false;
}

function google_youtube_get_channelinfo($channel) {
    // Проверяем доступность канала пользователя по dev-ключу
    $dev = google_youtube_developer();

    try {
        $listChannels = $dev->channels->listChannels('statistics,snippet', array('id' => $channel));
        
        $items = $listChannels->getItems();
        if(count($items) > 0 && $item = $items[0])
        {
            $snippet 	= $item->getSnippet();
            $statistics	= $item->getStatistics();

            return array(
                    'thumbnail'             => $snippet->getThumbnails()->medium->url,
                    'title'                 => $snippet->getTitle(),
                    'publishedAt'           => $snippet->getPublishedAt(),
                    'subscriberCount'       => $statistics->subscriberCount,
                    'hiddenSubscriberCount' => $statistics->hiddenSubscriberCount
            );
        }
    }
    catch(Exception $e) {}

    return false;
}