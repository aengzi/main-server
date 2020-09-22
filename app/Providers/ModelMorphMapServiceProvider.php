<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class ModelMorphMapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'aftv_bcast'
                => 'App\Models\AftvBcast',
            'aftv_bj'
                => 'App\Models\AftvBj',
            'aftv_chat_file'
                => 'App\Models\AftvChatFile',
            'aftv_file'
                => 'App\Models\AftvFile',
            'aftv_ip'
                => 'App\Models\AftvIp',
            'aftv_log'
                => 'App\Models\AftvLog',
            'aftv_m3u8'
                => 'App\Models\AftvM3u8',
            'aftv_review'
                => 'App\Models\AftvReview',
            'clip'
                => 'App\Models\Clip',
            'device'
                => 'App\Models\Device',
            'dislike'
                => 'App\Models\Dislike',
            'comment_reply'
                => 'App\Models\CommentReply',
            'comment_thread'
                => 'App\Models\CommentThread',
            'lol_champion'
                => 'App\Models\LolChampion',
            'lol_game'
                => 'App\Models\LolGame',
            'lol_meta'
                => 'App\Models\LolMeta',
            'lol_timeline'
                => 'App\Models\LolTimeline',
            'like'
                => 'App\Models\Like',
            'notification'
                => 'App\Models\Notification',
            'post'
                => 'App\Models\Post',
            'pubg_game'
                => 'App\Models\PubgGame',
            'pubg_meta'
                => 'App\Models\PubgMeta',
            'pubg_timeline'
                => 'App\Models\PubgTimeline',
            'pwd_reset'
                => 'App\Models\PwdReset',
            'user'
                => 'App\Models\User',
            'vod'
                => 'App\Models\Vod',
            'ytb_comment'
                => 'App\Models\YtbComment',
            'ytb_comment_thread'
                => 'App\Models\YtbCommentThread',
            'ytb_video'
                => 'App\Models\YtbVideo',
        ]);
    }
}
