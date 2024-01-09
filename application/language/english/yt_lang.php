<?php 
$lang['penalty_title'] 		= 'Penalty';
$lang['yt_view_title'] 		= 'YT Views';
$lang['yt_like_title'] 		= 'YT Likes';
$lang['yt_comment_title'] 	= 'YT Comments';
$lang['yt_comment_like_title'] 	= 'YT Comment Likes';
$lang['yt_reply_title'] 	= 'YT Replies';
$lang['yt_subscribe_title'] = 'YT Subscribes';
$lang['yt_gpshare_title'] 	= 'G+ Share';
$lang['yt_vkshare_title'] 	= 'VK Share';
$lang['yt_twittershare_title'] = 'Tweet';
$lang['yt_fbshare_title']	= 'FB Share';
$lang['yt_site_title']	 	= 'Sites';
$lang['client_title']		= 'Client (v2.3.8)';
$lang['captcha_perform']		= 'Solve captcha';
$lang['captcha_solved']		= 'Captcha solved, you can work.';
$lang['captcha_submit'] = 'Submit';
$lang['limit_penalty'] = 'Fines limit';
//Errors 
$lang['error_browser_autoplay'] = 'Autoplay is disabled in your browser, the client cannot work. <p style="font-weight: normal;">If you are a Chrome browser user, to solve this problem, enter "chrome://flags/#autoplay-policy" in the browser line and change the value in the opened settings set the "Autoplay policy" to "No user gesture is required" as shown in the picture <br/> <img src="/static/chrome_autoplay.jpg" width="100%" /></p>';
$lang['error_comments_num']	= '<p class="red">You must complete at least 5 comment tasks, for the last 3 days to be able to run the client.</p> <p>Now completed: <span>%1$s / 5</span></p>';

$lang['error_banned']			= 'Your account has been banned (for %1$s) for breaking the rules (%2$s), вы не можете выполнять задачи.';
$lang['error_task_not_found']	 	= 'Task not found';
$lang['error_hour_limit']	 	= 'You exceeded the limit of this type of task in the last hour, try again later...';
$lang['error_task_hour_limit']	 	= 'This task is ended limit per hour.';
$lang['error_task_done']		= 'The task has already been completed';
$lang['error_google_auth']              = 'You need sign up from your <a href="%1$s">Google account</a>.';
$lang['error_end_task_budget']	 	= 'In this task ended budget.';
$lang['error_like']	 				= 'Could not complete Like.';
$lang['error_icrease_user_balance']	= 'Unable to charge the user points.';
$lang['error_comment_enabled']	 	= 'In this task, comment moderation on, it will be removed in the near future.';
$lang['error_comment_disable']		= 'In this task, comments are disabled, it will be removed in the near future.';
$lang['error_comment_not_found']	= 'Comment not found.';
$lang['suspicious_activity']	= '<p class="red">Suspicious activity. Follow a few likes and comments and views, or continue tomorrow.</p>';
$lang['suspicious_activity_subsribe']	= '<p class="red">Suspicious activity. Perform 3 likes 1 comments 3 views, or continue tomorrow.</p>';
$lang['suspicious_activity_view']	= '<p class="red">Suspicious activity. Follow 3 likes 1 comments.</p>';
$lang['suspicious_activity_vk']	= '<p class="red">Suspicious activity. Follow 5 views, 3 likes 1 comments, or continue tomorrow.</p>';
$lang['error_channel_not_found']    = 'Channel not found, it will be removed in the near future.';
$lang['error_task_perm_unavailable'] = 'This task is temporarily unavailable.';
$lang['error_window_close_early']			= 'The window is closed ahead of time.';
$lang['error_disabled_view_history']                    = 'Check history of views on YouTube must be enabled.';
$lang['error_view_rec_not_found']	 		= 'Our service can\'t find history from your youtube account, try yo check again later.';
$lang['error_view_later_not_found']	 		= 'Record not found in your list of "Watch Later", try to check again later.';
$lang['error_gpshare_not_found']	 		= 'Record not found in your list of G+ news.';
$lang['error_not_subscribed']	 			= 'You are not subsribed to this channel';
$lang['error_dislike_not_found']	 		= 'Your dislike not found for this video.';
$lang['error_like_not_found']	 			= 'Your like not found for this video.';
$lang['error_comment_len']		 		= 'Comments should be longer than 10 characters.';
$lang['error_subscribe_limit']		 		= 'You have exceeded the limit of the total subscriptions.';
$lang['error_notmain_channel']			= 'This type of task can only be performed from the main channel.';
$lang['error_like_age']	= 'Your channel is less than 90 days old, likes are not available.';
$lang['error_activities']	= 'No activity was detected on your channel, complete is impossible';
$lang['error_no_avatar_ban'] = 'No avatar, image';
$lang['error_quotas'] = '(403) Daily Limit Exceeded. The quota will be reset at midnight Pacific Time (PT).';


$lang['task_done'] = 'This task is completed, you got %1$s.';
$lang['task_moderate_done'] = 'You will receive %1$s points after verification (up to 10 min).';


$lang['tpl_soc_tip']	= 'This section works in test mode, make sure that your social page has public access. Please report any problems through the form on the main page.';


$lang['tpl_reply_tip'] = 'Этот раздел работает в тестовом режиме. Для выполнения задачи оставьте ответ на прикрепленный комментарий.';

// Template
$lang['tpl_name'] = 'Name';
$lang['tpl_action_cost'] = 'Сost';
$lang['tpl_actions']  = 'Manage';
$lang['tpl_time'] = 'Time';
$lang['tpl_remove_task'] = 'Remove task';
$lang['tpl_check_done'] = 'Completion check';

$lang['tpl_report'] = 'Report';

$lang['tpl_type'] = 'Type';
$lang['tpl_like_type'] = 'Like type';
$lang['tpl_yt_comment'] = 'Comment';
$lang['tpl_like_like'] = '<span style="color: green;">Like</span>';
$lang['tpl_like_dislike'] = '<span style="color: red;">Dislike</span>';
$lang['tpl_comment_positive'] = '<span style="color: green;">Positive</span>';
$lang['tpl_comment_negative'] = '<span style="color: red;">Negative</span>';
$lang['tpl_comment_custom'] = 'Custom';
$lang['tpl_comment_copy'] = 'Copy';

$lang['tpl_no_task'] = 'No tasks.';

$lang['tpl_users_online'] = 'users online';
$lang['tpl_main_info'] = 'Main';
$lang['tpl_settings'] = 'Settings';
$lang['tpl_viewing'] = 'Viewing';
$lang['tpl_liking'] = 'Liking';
$lang['tpl_subscribing'] = 'Subscribing';
$lang['tpl_commenting'] = 'Commenting';
$lang['tpl_settings_tip'] = 'Disabling any of these options will decrease your credits earnings.';
$lang['tpl_start_btn'] = 'Start';
$lang['tpl_stop_btn']	= 'Stop';
$lang['tpl_watching_video'] = 'Watching video:';
$lang['tpl_seconds_left'] = 'seconds left';
$lang['tpl_please_keep_tab'] = 'Please keep the viewing tab open.';
$lang['tpl_please_disable_adblock'] = 'Disable adblock to get full price, now you get half price.';

$lang['tpl_waiting'] = 'Please waiting...';
$lang['tpl_search_videos_available'] = 'Search videos available for viewing'; //
$lang['tpl_restart_client'] = 'Please, restart the client, if you are stuck on this page more than a few minutes.'; //