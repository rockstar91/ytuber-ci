<?php 
function user_balance() {
	$user = get_user();
	return $user ? $user->balance : false;
}

function user_name() {
	$user = get_user();
	return $user ? $user->name : false;
}

function user_id() {
	$user = get_user();
	return $user ? $user->id : false;
}

function user_avatar() {
	$user = get_user();
	return $user ? $user->avatar : false;
}

function get_user() {

    static $user = null;

    if($user == null)
    {
        $CI =& get_instance();
        $CI->load->model('User_Model', 'User');

        $user_id = $CI->session->userdata('logged_in');

        if(isset($user_id->id)) {
            $user_id = $user_id->id;
            $CI->session->set_userdata('logged_in', $user_id);
        }


        if($user_id !== null) {
            $user = $CI->User->getItem($user_id);


            // Обновление ластсин
            if($user && strtotime($user->lastseen) < (time()-60)) {

                $updateData = array(
                    'lastseen'	=> date('Y-m-d H:i:s'),
                    'lastip'	=> $CI->input->ip_address()
                );
            }

            $CI->load->helper('google');
		if ($user->recaptcha_score >= 0.4){
            // Обновление канала
            if($user && ( empty($user->channel) OR strtotime($user->channel_published) <= 0 ) )
            {
                /*
                $yt = google_auth_youtube($user, false);
                if ($yt)
                {
                    try
                    {
                        $listChannels = $yt->channels->listChannels('id, snippet', array('mine' => true));
                        $user->channel = $listChannels->getItems()[0]->getId();
                        $updateData['channel'] = $user->channel;
                        $updateData['channel_published'] = date('Y:m:d H:i:s', strtotime($listChannels->getItems()[0]['snippet']->getpublishedAt()));
                    }
                    catch (Exception $e)
                    {
                    }
                }
                */
            }

            // обновление активности
            if($user && $user->channel && strtotime($user->activity_updated_at) < (time() - 86400))
            {
                try {

                    //Проверяем активность
                    $dev = google_youtube_developer();
                    $activity = $dev->activities->listActivities('snippet', array('channelId' => $user->channel));

                    if (isset($activity->getpageInfo()->totalResults))
                    {
                        $updateData['activity'] = $activity->getpageInfo()->totalResults;
                    }
                }
                catch (Exception $e)
                {
                    $updateData['activity'] = 0;
                }

                $updateData['activity_updated_at'] = date('Y-m-d H:i:s');
            }
		}
            // обновление данных в бд
            if(isset($updateData))
            {
                $CI->User->updateItem($user->id, $updateData);
            }

            return $user;
        }
    }

	return $user;
}