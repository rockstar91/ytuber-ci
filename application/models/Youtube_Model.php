<?php

Class Youtube_Model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->helper('yt');
        $this->load->helper('google');
        $this->load->driver('cache');
    }

    // ссылка на getRelevantCounter
    public function open($task)
    {
        return $this->getRelevantCounter($task);
    }

    public function getRelevantCounter($task, $disableTask=false)
    {
        $youtube = 0;

        // Данные из кеша
        $cache = $this->cache->get('task_youtube_'.$task->id);

        if($cache) {
            return $cache;
        }

        // узнаем количество просмотров перед открытием
        if (in_array($task->type_id, array(TASK_VIEW, TASK_LIKE, TASK_COMMENT))) {
            $vid = yt_vid($task->url);

            $dev = google_youtube_developer();

            try {
                $listVideos = $dev->videos->listVideos('statistics', array('id' => $vid));

                if (isset($listVideos->getItems()[0]) && $stat = $listVideos->getItems()[0]->getStatistics()) {
                    // кол-во просмотров
                    if ($task->type_id == TASK_VIEW) {
                        $youtube = $stat->viewCount;
                    }

                    // кол-во лайков, дизлайков
                    if ($task->type_id == TASK_LIKE) {
                        if (isset($task->extend['type']) && $task->extend['type'] == 1) {
                            $youtube = $stat->likeCount;
                        } else {
                            $youtube = $stat->dislikeCount;
                        }
                    }

                    // кол-во комментов
                    if ($task->type_id == TASK_COMMENT) {
                        $youtube = $stat->commentCount;
                    }
                }
            } catch (Exception $e) {
            }

            $this->cache->save('task_youtube_'.$task->id, $youtube, 3600);
        }

        // узнаем количество подписчиков перед открытием
        if ($task->type_id == TASK_SUBSCRIBE) {
            $channel = yt_channel($task->url);

            $dev = google_youtube_developer();
            try {
                $listChannels = $dev->channels->listChannels('statistics', array('id' => $channel));
                // если нет канала
                if ($listChannels->getPageInfo()->getTotalResults() === 0) {
                    // отключаем задачу
                    $this->Task->updateItem($task->user_id, $task->id, array('disabled' => 1));
                    $this->output->json(array('error' => $this->lang->line('error_channel_not_found')));
                }

                foreach ($listChannels->getItems() as $k => $item) {
                    if ($item->getStatistics()->subscriberCount > 0) {
                        $youtube = $item->getStatistics()->subscriberCount;
                        break;
                    }
                }
            } catch (Exception $e) {
            }
        }

        // количество лайков у комментария
        if ($task->type_id == TASK_COMMENT_LIKE) {
            $dev = google_youtube_developer();
            try {
                // получаем тред комментариев по channelId
                $videoCommentThreads = $dev->commentThreads->listCommentThreads('snippet', array(
                    //'allThreadsRelatedToChannelId' => $channelId,
                    //'textFormat'            => 'plainText',
                    'maxResults' => 25,
                    //'moderationStatus'      => 'published',
                    //'videoId'               => $vid,
                    'id' => $task->extend['comment_id']
                ));


                if($disableTask) {
                    $total = $videoCommentThreads->getPageInfo()->getTotalResults();
                    if($total === 0) {
                        $this->Task->updateItem($task->user_id, $task->id, array('disabled' => 1));
                        return -1;
                    }
                }


                foreach ($videoCommentThreads->getItems() as $item) {
                    //print_r($item->getSnippet()->getTopLevelComment()->getSnippet());
                    $youtube = $item->getSnippet()->getTopLevelComment()->getSnippet()->getLikeCount();
                    break;
                }
            } catch (Exception $e) {
            }
        }

        return $youtube;
    }
}