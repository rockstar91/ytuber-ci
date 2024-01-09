<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class Comment extends Api {

    function __construct()
    {
        parent::__construct();

        if(!$this->user->admin) {
            die('No have permissions');
        }

        $this->load->model('Comment_Model', 'Comment');
    }

    function getOpen($task_id)
    {
        $comments = $this->Comment->getItemsBy(array('task_id' => (int) $task_id, 'status' => COMMENT_OPEN));
        $this->output->json($comments);
    }

    function setComplete($comment_id)
    {
        $this->Comment->updateItem((int)$comment_id, array('status' => COMMENT_COMPLETE));
    }

    function setCompleteByText($task_id)
    {
        if(!$this->user->admin)
        {
            die('No have permissions');
        }

        $comment_text = urldecode($this->input->get('comment_text'));


        $comments = $this->Comment->getItemsBy(array('task_id' => (int) $task_id, 'status' => COMMENT_OPEN));

        foreach($comments as $comment)
        {
            similar_text($comment_text, $comment->comment_text, $prc);

            if($prc >= 90)
            {
                $this->Comment->updateItem($comment->id, array('status' => COMMENT_COMPLETE));
                $this->output->json('success');
                die();
            }
        }
    }
}