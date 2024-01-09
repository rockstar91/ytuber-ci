<?php 
$lang['task_list_title'] 		= 'Task list';
$lang['task_add_title'] 		= 'Add task';
$lang['task_edit_title'] 		= 'Edit task';

// form 
$lang['view_time']			= 'View time';
$lang['like_type']			= 'Like type';
$lang['comment_type']		= 'Comment type';
$lang['comment_text']		= 'Comment text';


// errors
$lang['error_report_exists'] 		= 'You already report about this task.';
$lang['error_task_not_found'] 		= 'Task not found.';
$lang['error_permission_denied'] 	= 'You can\'t edit this task';
$lang['error_edit_time_limit']		= 'I can\'t edit task more then one time per 10 min.';
$lang['error_remove']				= 'Impossible to remove task #%1$s.';
$lang['error_banned']				= 'Your account has been temporarily blocked (till  %1$s), you can not edit and add tasks.';
$lang['error_remove_time']			= 'You can\'t delete a task earlier than one hour after it is created.';
$lang['error_channel_unavailable']  = 'You can not add or edit tasks, because we found that your channel does not exist. To clarify the situation, write to support through the form on the main page or directly to support@ytuber.ru';

$lang['list_info'] = 'Number of views on YouTube is updated within 24-72 hours.';
$lang['limit_penalty'] = 'You cannot perform this type of task, you have more than 30 penalties in the last 30 days.';
$lang['category'] 			= 'Category';
$lang['type'] 				= 'Task type';
$lang['url'] 				= 'Url';
$lang['name'] 				= 'Name';
$lang['name_placeholder']	= 'My best video';
$lang['total_cost'] 		= 'Total cost';
$lang['action_cost'] 		= 'Action cost';
$lang['action_target']		= 'Number of executions';
$lang['position'] 			= 'Position in list	&ndash; ';
$lang['hour_limit'] 		= 'Limit of completing task (per hour)';
$lang['hour_limit_tip'] 	= '0 - unlimited';
$lang['complete_penalty']   = 'Completed';
$lang['manage']  			= 'Manage';
$lang['edit']  				= 'Edit';
$lang['remove']  			= 'Remove';
$lang['no_task']  			= 'No tasks.';
$lang['add_task']  			= 'Add task';
$lang['save_task']  		= 'Save task';
$lang['penalty_tip']		= 'Не засчитано выполнений: %1$s, возвращено баллов: %2$s';

// additional fields
$lang['viewing_time']	= 'Viewing time';
$lang['like_type']		= 'Like type';
$lang['like_positive']	= 'Like';
$lang['like_negative']	= 'Dislike';

$lang['comment_type']		= 'Comment type';
$lang['comment_positive']	= 'Positive';
$lang['comment_negative']	= 'Negative';
$lang['comment_neutral']	= 'Neutral';
$lang['comment_custom']		= 'Custom';
$lang['comment_text']		= 'Comment text';
$lang['comment_text_tip']	= 'One comment on the line.';

$lang['geo']			= 'Geotargeting';
$lang['country']		= 'Country';
$lang['state']			= 'State';
$lang['city']			= 'City';
$lang['select_country']	= '- Select country -';
$lang['any_state']		= '- Any state -';
$lang['any_city']		= '- Any city -';
$lang['geo_tip']		= 'To enable geo-targeting, add one or more entries. Geo-targeting works from large to small - select only the country; country and region; either country, region and city. For each task, you can add up to 20 geotargeting records. Regions and cities are currently available only for Russia.';

// Success
$lang['success_add'] 		= 'Task added.';
$lang['success_edit'] 		= 'Task updated.';
$lang['success_remove']		= 'Task #%1$s was deleted.';
$lang['success_report']		= 'Your message has been sent successfully. Thank you!.';

// Validations 
$lang['valid_url']			= 'Incorrect link of YouTube video.';
$lang['valid_url_channel']  = 'Incorrect link of YouTube channel.';
$lang['valid_url_unique']	= 'Link already exist in our service, contact administrator to fix it';
$lang['valid_url_format']	= 'The URL you entered is not correctly formatted.';
$lang['valid_url_exists']	= 'The URL you entered is not accessible.';
$lang['valid_total_cost'] 	= 'You have no coins to create a task with the specified budget.';
$lang['valid_action_cost']	= 'The budget can not be less than the cost-per-action.';
$lang['valid_extra_time']	= 'Select viewing time.';
$lang['valid_comment_text']	= 'Specify at least %1$s options for %2$s characters, or reduce the budget.';
$lang['valid_extra_type']	= 'Specify like type';