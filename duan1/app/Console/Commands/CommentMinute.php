<?php

namespace App\Console\Commands;

use App\Comment;
use App\Access_token;
use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Console\Command;


class CommentMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fb = new Facebook([
            'app_id' => '742424103072704',
            'app_secret' => '64ae2ae8307d8afb10478200a5d97a99',
            'default_graph_version' => 'v2.3',
        ]);
        $comment_token = Access_token::where('access_tokens.deleted_at', null)
            ->get();

        $com = Comment::all();
        $t = [];
        foreach ($com  as $value) {
            $t[] = $value->id_comment;
        }
        foreach ($comment_token as $value) {
            try {
                $event = $fb->get(
                    "me?fields=posts{comments}&access_token=$value->token"
                );
            } catch (FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $graphNode = $event->getGraphNode();
            if ($t == []) {
                for ($i = 0; $i < count($graphNode['posts']); $i++) {
                    for ($j = 0; $j < count($graphNode['posts'][$i]['comments']); $j++) {
                        $comment = new Comment();
                        $comment->name = $graphNode['posts'][$i]['comments'][$j]['from']['name'];
                        $comment->id_access_token = $value->id;
                        $comment->status = 0;
                        $comment->comment = $graphNode['posts'][$i]['comments'][$j]['message'];
                        $comment->id_comment = $graphNode['posts'][$i]['comments'][$j]['id'];
                        $comment->id_user = $graphNode['posts'][$i]['comments'][$j]['from']['id'];
                        $comment->save();
                    }
                }
            } else {
                for ($i = 0; $i < count($graphNode['posts']); $i++) {
                    for ($j = 0; $j < count($graphNode['posts'][$i]['comments']); $j++) {
                        $commen = Comment::where('id_comment', $graphNode['posts'][$i]['comments'][$j]['id'])->first();
                        if ($graphNode['posts'][$i]['comments'][$j]['id'] != $commen['id_comment']) {
                            $comment = new Comment();
                            $comment->name = $graphNode['posts'][$i]['comments'][$j]['from']['name'];
                            $comment->id_access_token = $value->id;
                            $comment->status = 0;
                            $comment->comment = $graphNode['posts'][$i]['comments'][$j]['message'];
                            $comment->id_comment = $graphNode['posts'][$i]['comments'][$j]['id'];
                            $comment->id_user = $graphNode['posts'][$i]['comments'][$j]['from']['id'];
                            $comment->save();
                        }
                    }
                }
            }
            $comment_rep = Comment::where('status', 0)
                ->where('access_tokens.deleted_at', null)
                ->where('comments.deleted_at', null)
                ->join('access_tokens', 'comments.id_access_token', '=', 'access_tokens.id')
                ->select('comments.id_comment', 'access_tokens.token', 'comments.id')
                ->get();
            foreach ($comment_rep as $value) {
                try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fb->post(
                        "/$value->id_comment/comments",
                        array(
                            'message' => 'chào bạn, hãy nhắn tin cho page để được biết thêm chi tiết',
                        ),
                        "$value->token"
                    );
                } catch (FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                $graphNode = $response->getGraphNode();
            }
            for ($i = 0; $i < count($comment_rep); $i++) {
                $status = Comment::find($comment_rep[$i]->id);
                $status->status = 1;
                $status->save();
            }
        }
    }
}
