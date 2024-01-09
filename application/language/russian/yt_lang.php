<?php 
$lang['penalty_title'] 		= 'Штрафы';
$lang['yt_view_title'] 		= 'YT Просмотры';
$lang['yt_later_title'] 	= 'YT Посмотреть позже';
$lang['yt_like_title'] 		= 'YT Лайки';
$lang['yt_comment_title'] 	= 'YT Комментарии';
$lang['yt_comment_like_title'] 	= 'YT Лайки к комментариям';
$lang['yt_reply_title'] 	= 'YT Ответы к комментариям';
$lang['yt_subscribe_title']     = 'YT Подписчики';
$lang['yt_gpshare_title'] 	= 'G+ Поделиться';
$lang['yt_vkshare_title'] 	= 'VK Поделиться';
$lang['yt_twittershare_title']  = 'Твитнуть';
$lang['yt_fbshare_title']	= 'FB Поделиться';
$lang['yt_site_title']	 	= 'Просмотр сайтов';
$lang['client_title']		= 'Клиент (v2.3.8)';
$lang['captcha_perform']		= 'Разгадайте капчу';
$lang['captcha_solved']		= 'Капча решена, вы можете работать.';
$lang['captcha_submit'] = 'Отправить';
$lang['limit_penalty'] = 'Лимит штрафов';
$lang['error_quotas'] = '(403) Нашим сервисом. Превышен дневной лимит API запросов. Квота будет сброшена в полночь по тихоокеанскому времени (PT) 12-00.';
//Errors 
$lang['error_browser_autoplay'] = 'В вашем браузере отключено автовоспроизведение видео, работа клиента невозможна.';

$lang['error_comments_num']	= '<p class="red">Вы должны выполнить не менее 5 задач по комментариям за последние 3 дня, чтобы иметь возможность использовать клиент.</p> <p>Сейчас выполнено: <span>%1$s / 5</span></p>';
$lang['suspicious_activity']	= '<p class="red">Подозрительная активность. Выполните несколько лайков или 1 коммент. Либо сможете продолжить завтра.</p>';
$lang['suspicious_activity_subsribe']	= '<p class="red">Подозрительная активность. Выполните 3 лайка 1 коммент 3 просмотра. Либо сможете продолжить завтра.</p>';
$lang['suspicious_activity_view']	= '<p class="red">Подозрительная активность. Выполните 3 лайка 1 коммент, либо сможете продолжить завтра.</p>';
$lang['suspicious_activity_vk']	= '<p class="red">Подозрительная активность. Выполните 5 просмотров, 3 лайка 1 коммент, либо сможете продолжить завтра.</p>';
$lang['error_banned']			= 'Ваш аккаунт временно забанен (до %1$s) за нарушение правил (%2$s), вы не можете выполнять задачи.';
$lang['error_task_not_found']	 	= 'Задача не найдена';
$lang['error_hour_limit']	 	= 'Вы привысили лимит выполнений этого типа задач за последний час, попробуйте позже.';
$lang['error_task_hour_limit']	 	= 'У этой задачи закончился лимит выполнений в час.';
$lang['error_task_done']		= 'Задача уже выполнена';
$lang['error_google_auth']	 	= 'Вам нужно войти c помощью <a href="%1$s">google-аккаунта</a>.';
$lang['error_end_task_budget']	 	= 'У этой задачи закончился бюджет.';
$lang['error_like']	 		= 'Не удалось поставить лайк.';
$lang['error_icrease_user_balance']	= 'Не удалось зачислить баллы пользователю.';
$lang['error_comment_enabled']	 	= 'У этой задачи включена модерация комментариев, она будет удалена в ближайшее время.';
$lang['error_comment_disable']		= 'У этой задачи отключены комментарии, в ближайшее время она будет удалена.';
$lang['error_comment_not_found']	= 'Комментарий не найден.';
$lang['error_channel_not_found']        = 'Канал недоступен, эта задача будет в ближайшее время отключена.';
$lang['error_task_perm_unavailable']    = 'Эта задача временнно недоступна.';
$lang['error_window_close_early']	= 'Окно закрыто раньше времени.';
$lang['error_disabled_view_history']    = 'Проверьте, включена ли у вас история просмотров на YouTube.';
$lang['error_view_rec_not_found']	= 'Запись о просмотре не найдена в вашем списке "Просмотренные", попробуйте проверить позже.';
$lang['error_view_later_not_found']	= 'Запись не найдена в вашем списке "Посмотреть позже", попробуйте проверить позже.';
$lang['error_gpshare_not_found']	= 'Запись не найдена в вашей ленте G+.';
$lang['error_not_subscribed']           = 'Вы не подписались на канал, либо слишком быстро закрыли окно.';
$lang['error_dislike_not_found']	= 'Не найден ваш дизлайк к видео.';
$lang['error_like_not_found']	 	= 'Не найден ваш лайк к видео.';
$lang['error_comment_len']		= 'Комментарий должен быть длинее 10 символов.';
$lang['error_subscribe_limit']		= 'Вы привысили лимит подписок (%1$s).';
$lang['error_notmain_channel']			= 'Этот тип задачи можно выполнять только с основного канала.';
$lang['error_like_age']	= 'Возраст вашего канала менее 90 дней, выполнение лайков недоступно.';
$lang['error_activities']	= 'Не обнаружено никакой активности на вашем канале - например: добавьте ролик, плейлист или описание канала.';
$lang['error_no_avatar_ban'] = 'Нету изображения, аватарки';

$lang['task_done']          = 'Задача выполнена, вы получили %1$s.';
$lang['task_moderate_done'] = 'Вы получите %1$s сразу после проверки выполнения (до 10 мин).';

$lang['tpl_soc_tip']	= 'Этот раздел работает в тестовом режиме, убедитесь чтобы у вашей страницы соц. сети был включен публичный доступ. Пожалуйста, сообщайте о любых проблемах через форму на главной странице.';

$lang['tpl_reply_tip'] = 'Этот раздел работает в тестовом режиме. Для выполнения задачи оставьте ответ на прикрепленный комментарий.';

// Template
$lang['tpl_name'] = 'Название';
$lang['tpl_action_cost'] = 'Цена';
$lang['tpl_actions']  = 'Действия';
$lang['tpl_time'] = 'Время';
$lang['tpl_remove_task'] = 'Удалить задание';
$lang['tpl_check_done'] = 'Проверить выполнение';

$lang['tpl_report'] = 'Сообщить о нарушении';

$lang['tpl_type'] = 'Тип';
$lang['tpl_like_type'] = 'Тип лайка';
$lang['tpl_yt_comment'] = 'Комментарий';
$lang['tpl_like_like'] = '<span style="color: green;">Лайк</span>';
$lang['tpl_like_dislike'] = '<span style="color: red;">Дизлайк</span>';
$lang['tpl_comment_positive'] = '<span style="color: green;">Позитивный</span>';
$lang['tpl_comment_negative'] = '<span style="color: red;">Негативный</span>';
$lang['tpl_comment_custom'] = 'Произвольный';
$lang['tpl_comment_copy'] = 'Копировать';

$lang['tpl_no_task'] = 'Нет заданий.';

$lang['tpl_users_online'] = 'онлайн';
$lang['tpl_main_info'] = 'Общая информация';
$lang['tpl_settings'] = 'Настройки';
$lang['tpl_viewing'] = 'Просмотры';
$lang['tpl_liking'] = 'Лайки';
$lang['tpl_subscribing'] = 'Подписки';
$lang['tpl_commenting'] = 'Комменты';
$lang['tpl_settings_tip'] = 'Выключение любой из этих опций уменьшит количество зарабатываемых баллов.';
$lang['tpl_start_btn'] = 'Запустить';
$lang['tpl_stop_btn']	= 'Остановить';
$lang['tpl_watching_video'] = 'Просмотр:';
$lang['tpl_seconds_left'] = 'сек. осталось';
$lang['tpl_please_keep_tab'] = 'Пожалуйста не закрывайте вкладку с видео.';
$lang['tpl_please_disable_adblock'] = 'Отключите adblock, чтобы получать полную цену, сейчас вы получаете половину цены.';

$lang['tpl_waiting'] = 'Ожидайте...';
$lang['tpl_search_videos_available'] = 'Идет поиск видео доступного для просмотра'; //Search videos available for viewing
$lang['tpl_restart_client'] = 'Пожалуйста, перезапустите клиент, если вы застряли на этой странице более чем на несколько минут.'; //Please, restart the client, if you are stuck on this page more than a few minutes.