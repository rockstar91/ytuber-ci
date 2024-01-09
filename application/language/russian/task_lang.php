<?php 
$lang['task_list_title'] 		= 'Список задач';
$lang['task_add_title'] 		= 'Добавить задачу';
$lang['task_edit_title'] 		= 'Редактировать задачу';

// form 
$lang['view_time']			= 'Время просмотра';
$lang['like_type']			= 'Тип лайка';
$lang['comment_type']		= 'Тип комментария';
$lang['comment_text']		= 'Текст комментария';


// errors
$lang['error_report_exists'] 		= 'Вы уже оставили жалобу к этой задаче.';
$lang['error_task_not_found'] 		= 'Задача не найдена.';
$lang['error_permission_denied'] 	= 'Вы не можете редактировать эту задачу.';
$lang['error_edit_time_limit']		= 'Вы не можете редактировать задачу чаще чем раз в 10 минут.';
$lang['error_remove']				= 'Невозможно удалить задачу #%1$s.';
$lang['error_banned']				= 'Ваш аккаунт временно забанен (до %1$s) за нарушение правил (%2$s), вы не можете редактировать и добавлять задачи.';
$lang['error_remove_time']			= 'Вы не можете удалять задачу, раньше чем через час после ее создания.';
$lang['error_channel_unavailable']  = 'Вы не можете добавлять и редактировать задачи, т.к. мы обнаружили что ваш канал не существует. Для выяснения ситуации напишите в поддержку через форму на главной странице, либо на support@ytuber.ru';
$lang['limit_penalty'] = 'Вы не можете выполнять этот тип задачи, у вас больше 30 штрафов за последние 30 дней.';
$lang['list_info'] = 'Количество просмотров на ютубе обновляется в течении 24-72 часов.';

$lang['category'] 			= 'Категория';
$lang['type'] 				= 'Тип задания';
$lang['url'] 				= 'Ссылка';
$lang['name'] 				= 'Название';
$lang['name_placeholder']	= 'Мой самый лучший ролик';
$lang['total_cost'] 		= 'Бюджет';
$lang['action_cost'] 		= 'Цена';
$lang['action_target']		= 'Кол-во выполнений';
$lang['position'] 			= 'Позиция в списке 	&ndash; ';
$lang['hour_limit'] 		= 'Ограничение выполнений (в час)';
$lang['hour_limit_tip'] 	= '0 - без лимита';
$lang['complete_penalty']   = 'Выполнено';
$lang['manage']  			= 'Управление';
$lang['edit']  				= 'Редактировать';
$lang['remove']  			= 'Удалить';
$lang['no_task']  			= 'Нет заданий.';
$lang['add_task']  			= 'Добавить задачу';
$lang['save_task']  		= 'Сохранить задачу';
$lang['penalty_tip']		= 'Не засчитано выполнений: %1$s, возвращено баллов: %2$s';

// additional fields
$lang['viewing_time']	= 'Время просмотра';
$lang['like_type']		= 'Тип лайка';
$lang['like_positive']	= 'Положительный (лайк)';
$lang['like_negative']	= 'Отрицательный (дизлайк)';

$lang['comment_type']		= 'Тип комментария';
$lang['comment_positive']	= 'Позитивный';
$lang['comment_negative']	= 'Негативный';
$lang['comment_neutral']	= 'Произвольный';
$lang['comment_custom']		= 'Заданный';
$lang['comment_text']		= 'Текст комментария';
$lang['comment_text_tip']	= 'Один комментарий на строку. Длина каждого комментария должна быть не менее 10 символов, количество коментариев должно соответствовать значению поля "Кол-во выполнений".';


// geo
$lang['geo']			= 'Геотаргетинг';
$lang['country']		= 'Страна';
$lang['state']			= 'Регион (область)';
$lang['city']			= 'Город';
$lang['select_country']	= '- Выберите страну -';
$lang['any_state']		= '- Любой регион -';
$lang['any_city']		= '- Любой город -';
$lang['geo_tip']		= 'Для включения геотаргетинга добавьте одну или более записей. Геотаргетинг работает от большего к меньшему – выберите только страну; страну и регион; либо страну, регион и город. Для каждой задачи можно добавить не более 20 записей геотаргетинга. Регионы и города на данный момент доступны только для России.';

// Success
$lang['success_add'] 		= 'Задача добавлена.';
$lang['success_edit'] 		= 'Задача обновлена.';
$lang['success_remove']		= 'Задача #%1$s была удалена.';
$lang['success_report']		= 'Спасибо, ваше сообщение отправлено.';

// Validations 
$lang['valid_url']			= 'Должна быть введена корректная ссылка на ролик с YouTube.';
$lang['valid_url_channel']  = 'Должна быть введена корректная ссылка на канал YouTube.';
$lang['valid_url_unique']	= 'Данная ссылка уже есть в базе.';
$lang['valid_url_format']	= 'The URL you entered is not correctly formatted.';
$lang['valid_url_exists']	= 'The URL you entered is not accessible.';
$lang['valid_total_cost'] 	= 'У вас недостаточно средств для создания задачи с указанным бюджетом.';
$lang['valid_action_cost']	= 'Бюджет не может быть меньше цены за действие.';
$lang['valid_extra_time']	= 'Выберите время просмотра.';
$lang['valid_comment_text']	= 'Укажите не менее %1$s вариантов по %2$s символов, либо уменьшите бюджет.';
$lang['valid_extra_type']	= 'Выберите тип лайка.';