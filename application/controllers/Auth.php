<?php

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'User');

        $this->load->helper('user');
        $this->user = get_user();

        $this->lang->load('auth');
    }

    function google_new() 
    {
        $this->google();
    }

    function google()
    {
        require_once(APPPATH . '/libraries/Google/autoload.php');

        $config = $this->config->item('google');

        $client = new Google_Client();

        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setRedirectUri($config['redirect_uri']);
        $client->setDeveloperKey($config['developer_key']);

        $client->setAccessType('offline');

        //$client->addScope('https://www.googleapis.com/auth/youtube');
        //$client->addScope("https://www.googleapis.com/auth/youtube.force-ssl");
        //$client->addScope('https://www.googleapis.com/auth/youtube.readonly');

        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");

        //$yt_service = new Google_Service_YouTube($client);
        $google_oauth = new Google_Service_Oauth2($client);

        // callback
        if ($this->input->get('code')) {
            $client->authenticate($this->input->get('code'));
            $this->session->set_userdata('google_token', $client->getAccessToken());


//            // проверяем квоту
//            if (strpos($client, 'limit') !== false) {
//                echo 'Try again later, (403) Daily Limit Exceeded. The quota will be reset at midnight Pacific Time (PT).';
//            }

            //redirect('auth/google');
        }
		
        $token_json = $this->session->userdata('google_token');

        try {
            $client->setAccessToken($token_json);
            $google_oauth->userinfo->get()->name;

            //$userChannel = $yt_service->channels->listChannels('snippet', array(
            //    'mine' => true
            //));

            //$avatar = $userChannel->getItems()[0]->getSnippet()->getThumbnails()->getDefault()->getUrl();
        } catch (Exception $e) {
            //print_r($e); exit;
            $authUrl = $client->createAuthUrl();
        }

        // выводим кнопку входа
        if (isset($authUrl)) {
            redirect($authUrl);
        } else {
            $name = $google_oauth->userinfo->get()->name;
            $mail = $google_oauth->userinfo->get()->email;
            $id = $google_oauth->userinfo->get()->id;

            $redirect = $this->session->userdata('auth_google_redirect');
            $this->session->unset_userdata('auth_google_redirect');

            if ($id > 0 && !empty($mail)) {

                // если пользователь уже заходил через google
                if ($user = $this->User->getItemBy('gid', $id)) {
                    //
                } // если пользователь зашел, обновляем gid
                else if (isset($this->user->id)) {
                    $this->User->updateItem($this->user->id, array('gid' => $id));

                    if ($user = $this->User->getItemBy('gid', $id)) {
                        //
                    }
                } // если есть совпадающий mail в базе
                else if ($user = $this->User->getItemBy('mail', $mail)) {
                    //
                } // регистрируем пользователя
                else {
                    $this->load->helper('strgen');

                    $password = strgen(8);
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    $userData = array(
                        'gid' => $id,
                        'mail' => $mail,
                        'password' => $password,
                        'password_hash' => $password_hash,
                        'name' => $name,
                        'confirm' => strgen(),
                        'referrer_id' => (int)$this->session->userdata('referrer_id'),
                        'domain' => CURRENT_DOMAIN,
                        'ip' => $this->input->ip_address(),
                        'lastip' => $this->input->ip_address(),
                        'time' => date('Y-m-d H:i:s')
                    );

                    if ($this->User->addItem($userData)) {
                        $user = $this->User->loginHash($userData['mail'], $userData['password']);

                        if ($user) {
                            // отправляем письмо пользователю
                            $this->_user_singup_mail($user);
                        }
                    }
                }


                if (isset($user) && $user) {
                    // обновляем аватар
                    //$this->User->updateItem($user->id, array('avatar' => $avatar));
                    // обновляем refresh_token
                    $refresh_token = $client->getRefreshToken();
					
                    if (!empty($refresh_token)) 
					{
                        $user->refresh_token = $refresh_token;
                        $this->User->updateItem($user->id, array('refresh_token' => $refresh_token));
                    }
					
                    $this->session->set_userdata('logged_in', $user->id);
                    
					if ($redirect) 
					{
                        redirect($redirect);
                    } else 
					{
                        redirect('dashboard');
                    }
                }

            }
        }
    }

    /* Login */

    function _user_singup_mail($user)
    {
        $this->load->helper('mail');
        mail_send_tpl($user->mail, $this->lang->line('subject_singup'), 'auth_singup.php', $user);
        //$body = $this->load->view('emails/english/user_singup.php', $user, true);
        //mail_send($user->mail, 'Регистрация', $body);
    }

    function login()
    {
        //sleep(1.5);
        $this->load->model('Loginfail_Model', 'Loginfail');

        $data = array();
        $data['pageTitle'] = $this->lang->line('login_title');

        // If user already loggedin
        if ($this->session->userdata('logged_in')) {
            redirect('');
        }

        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('mail', $this->lang->line('mail'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');

        // recaptcha
        $this->load->helper('recaptcha');
        if (count($_POST) > 0 && !recaptcha_verify()) {
            $data['error'] = $this->lang->line('error_captcha');
        } else if ($this->Loginfail->count() > 3) {
            $data['error'] = $this->lang->line('error_auth');
        } else if ($this->form_validation->run()) {
            $mail = $this->input->post('mail');
            $password = $this->input->post('password');
            $result = $this->User->loginHash($mail, $password);

            if (!is_null($result) && $result != false) {
                $this->session->set_userdata('logged_in', $result->id);
                //Go to private area
                redirect('dashboard');
            } else {
                $data['error'] = $this->lang->line('error_auth');
                $this->Loginfail->add($mail, $password);
            }
        }

        //Field validation failed.  User redirected to login page
        $this->load->helper(array('form'));
        $this->tpl->load('auth/login', $data, false, 'layout_auth');
        //$this->load->view('auth/login', $data);
    }

    function referrer()
    {
        $referrer_id = (int)$this->uri->segment(1);
        if ($user = $this->User->getItem($referrer_id)) {
            $this->session->set_userdata('referrer_id', $referrer_id);
        }
        redirect();
    }

    /* Singup */

    function generate_hashes()
    {

        ini_set('memory_limit', '1G');

        $this->db->select('id, password');
        $this->db->where('password_hash', '');
        //$this->db->limit(20000);
        $query = $this->db->get('user');
        $users = $query->result();

        foreach ($users as $user) {
            $password_hash = password_hash($user->password, PASSWORD_BCRYPT);
            $this->User->updateItem($user->id, array('password_hash' => $password_hash));
        }
    }

    function singup()
    {
        $data['pageTitle'] = $this->lang->line('singup_title');


        // If user already loggedin
        if ($this->session->userdata('logged_in')) {
            redirect('');
        }

        $this->load->library('form_validation');

        // recaptcha
        /*
        $this->load->helper('recaptcha');
        $data['error'] = null;
        $config = $this->config->item('google');

        if (isset($_POST["recaptcha_response_field"])) {
            $resp = recaptcha_check_answer (
                $config['recaptcha_pri'],
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]
            );

            if (!$resp->is_valid) {
                $data['error'] = $this->lang->line('error_captcha');
            }
        }*/


        //$this->session->set_userdata('captcha_keystring', null);

        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('mail', $this->lang->line('mail'), 'trim|required|valid_email|callback__mail');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[5]|max_length[16]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('password_confirm'), 'trim|required|min_length[5]|max_length[16]|callback__password_confirm');


        // recaptcha
        $this->load->helper('recaptcha');
        if (count($_POST) > 0 && !recaptcha_verify()) {
            $data['error'] = $this->lang->line('error_captcha');
        } else if ($this->form_validation->run()) {
            $this->load->helper('strgen');

            $password = $this->input->post('password');
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $userData = array(
                'mail' => $this->input->post('mail'),
                'password' => $password,
                'password_hash' => $password_hash,
                'name' => $this->input->post('name', true),
                'confirm' => strgen(),
                'referrer_id' => (int)$this->session->userdata('referrer_id'),
                'domain' => CURRENT_DOMAIN,
                'ip' => $this->input->ip_address(),
                'time' => date('Y-m-d H:i:s')
            );

            if ($this->User->addItem($userData)) {
                $user = $this->User->loginHash($userData['mail'], $userData['password']);

                if ($user) {
                    // отправляем письмо пользователю
                    $this->_user_singup_mail($user);

                    $this->session->set_userdata('logged_in', $user->id);
                    $this->session->set_flashdata('error', $this->lang->line('error_mail_confirm'));
                    //Go to private area
                    redirect('dashboard');
                }
            }
        }

        //$data['recaptcha'] = recaptcha_get_html($config['recaptcha_pub'], $data['error'], true);

        //Field validation failed.  User redirected to login page
        $this->load->helper(array('form'));
        $this->tpl->load('auth/singup', $data, false, 'layout_auth');
    }

    /* Forgot */

    function forgot()
    {
        $this->load->helper('strgen');

        $data = array();
        $data['pageTitle'] = $this->lang->line('forgot_title');

        // If user already loggedin
        if ($this->session->userdata('logged_in')) {
            redirect('');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('mail', 'E-mail', 'trim|required|valid_email');

        if ($this->form_validation->run()) {
            // получаем пользователя
            $user = $this->_getUser($this->input->post('mail'));

            if ($user) {
                $data['success'] = $this->lang->line('success_forgot');

                // генерируем токен
                $user->forgot_token = strgen(16);

                // Обновляем токен в бд
                $this->User->updateItem($user->id, array(
                    'forgot_token' => $user->forgot_token
                ));

                // отправляем письмо
                $this->load->helper('mail');

                mail_send_tpl($user->mail, $this->lang->line('subject_forgot'), 'auth_forgot.php', $user);

            } else {
                $data['error'] = $this->lang->line('error_mail_not_found');
            }
        }

        //Field validation failed.  User redirected to login page
        $this->load->helper(array('form'));
        $this->tpl->load('auth/forgot', $data, false, 'layout_auth');
    }

    function forgot_channel()
    {
        $this->load->helper('strgen');

        $data = array();
        $data['pageTitle'] = $this->lang->line('forgot_title');

        // If user already loggedin
        if ($this->session->userdata('logged_in')) {
            redirect('');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('channel', 'channel', 'trim|required');

        if ($this->form_validation->run()) {
            // получаем пользователя
            $user = $this->User->getItemBy('channel', $this->input->post('channel'));
            //$user = $this->_getUser($this->input->post('mail'));

            if ($user) {
                //$data['success'] = $this->lang->line('success_forgot');

                // генерируем токен
                $data['forgot_channel_token'] = $user->forgot_channel_token = strgen(16);

                // Обновляем токен в бд
                $this->User->updateItem($user->id, array(
                    'forgot_channel_token' => $user->forgot_channel_token
                ));

                // отправляем письмо
                //$this->load->helper('mail');

                //mail_send_tpl($user->mail, $this->lang->line('subject_forgot'), 'auth_forgot.php', $user);

            } else {
                $data['error'] = $this->lang->line('error_mail_not_found');
            }
        }

        //Field validation failed.  User redirected to login page
        $this->load->helper(array('form'));
        $this->tpl->load('auth/forgot_channel', $data, false, 'layout_auth');
    }

    function _getUser($mail)
    {
        $this->db->where('mail', $mail);
        $this->db->limit(1);
        $query = $this->db->get('user');
        return $query->row();
    }

    function reset($id, $forgot_token)
    {
        if ($id < 0 OR strlen($forgot_token) != 16) {
            exit;
        }

        $user = $this->User->getItem((int)$id);

        if ($user AND $user->forgot_token == $forgot_token) {

            $this->load->helper('strgen');

            $password = strgen(8);
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Обновляем данные пользователя
            $this->User->updateItem($user->id, array(
                'password' => $password,
                'password_hash' => $password_hash,
                'forgot_token' => ''
            ));

            $data = array(
                'mail' => $user->mail,
                'password' => $password
            );

            // отправляем письмо
            $this->load->helper('mail');

            mail_send_tpl($user->mail, $this->lang->line('subject_reset'), 'auth_reset.php', $data);


            $this->session->set_flashdata('success', $this->lang->line('success_reset'));
            redirect('auth/login');
        } else {
            redirect('/');
        }
    }

    /* Logout */

    function confirm()
    {
        $id = (int)$this->input->get('id');
        $code = trim($this->input->get('code'));

        if ($id <= 0 OR strlen($code) != 8) {
            exit;
        }

        $this->db->where('id', $id);
        $this->db->where('confirm', $code);
        $this->db->limit(1);
        $query = $this->db->get('user');
        $user = $query->row();

        if ($user) {
            $user->confirm = null;
            $data = array('confirm' => $user->confirm);
            $this->db->where('id', $id);
            $this->db->update('user', $data);

            $this->session->set_userdata('logged_in', $user->id);
            $this->session->set_flashdata('success', $this->lang->line('success_confirm'));
            redirect('dashboard');
        }
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('google_token');
        $this->session->unset_userdata('google_redirect');
        $this->session->unset_userdata('recaptcha_pass');
        $this->session->unset_userdata('recaptcha_redirect');
        redirect('');
    }

    function _mail($mail)
    {
        $user = $this->_getUser($mail);
        if ($user) {
            $this->form_validation->set_message('_mail', $this->lang->line('valid_mail'));
            return false;
        }

        return true;
    }

    /* _password_confirm */
    function _password_confirm($password_confirm)
    {
        $password = $this->input->post('password');
        if ($password_confirm === $password) {
            return true;
        } else if (empty($password_confirm) && empty($password)) {
            return true;
        } else {
            $this->form_validation->set_message('_password_confirm', $this->lang->line('valid_password_confirm'));
            return false;
        }
    }

}