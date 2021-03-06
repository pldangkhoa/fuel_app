<?php

use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\Input;
use Fuel\Core\Validation;
use Model\Mymodel;
use Model\Comments;
use Model\Users;

class Controller_Myapp extends Controller_Mycontroller
{

    function __construct()
    {
        $this->init_auth();
    }

    public function action_index()
    {
        $data = array();
        $data['app_name'] = $this->app_name;
        $data['user_info'] = $this->user_info;

        $data['comments'] = Comments::getComments();
        if (!empty($data['comments'])) {
            $end_comment = end($data['comments']);
            $data['offset'] = $end_comment['id'];
        }

        $data['num'] = !empty($data['comments']) ? count($data['comments']) : 0;
        $data['total'] = Comments::countAllComments();

        $this->template->title = 'myapp';
        $this->template->content = View::forge('myapp/index', $data);
    }

    public function action_addComment()
    {
        $data = array();

        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add_field('comment', 'Comment', 'trim|required');

            if ($val->run()) {
                Comments::addComment($this->user_id, trim($val->validated('comment')));
            } else {
                $data['error'] = $val->error_message();
            }
        }

        $data['comments'] = Comments::getComments();
        if (!empty($data['comments'])) {
            $end_comment = end($data['comments']);
            $data['offset'] = $end_comment['id'];
        }

        $data['num'] = !empty($data['comments']) ? count($data['comments']) : 0;
        $data['total'] = Comments::countAllComments();

        return new Response(View::forge('myapp/comment', $data));
    }

    public function action_loadComment()
    {
        $data = array();
        $total_record = null;

        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add_field('offset', 'Offset', 'required');
            $val->add_field('total_record', 'Total record', 'required');

            if ($val->run()) {
                $data['comments'] = Comments::getComments((int) $val->validated('offset'));
                if (!empty($data['comments'])) {
                    $end_comment = end($data['comments']);
                    $data['offset'] = $end_comment['id'];
                    $total_record = count($data['comments']);
                }

                $total_record += (int) $val->validated('total_record');
            } else {
                $data['error'] = $val->error_message();
            }
        }

        $data['num'] = !empty($total_record) ? $total_record : 0;
        $data['total'] = Comments::countAllComments();

        return new Response(View::forge('myapp/comment', $data));
    }

}
