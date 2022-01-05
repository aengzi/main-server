<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

$addRoutes = function () use ($router) {

    $prefix = str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR);
    $prefix = str_replace($prefix, '', __FILE__);
    $prefix = str_replace('routes'.DIRECTORY_SEPARATOR.'web.php', '', $prefix);
    $prefix = rtrim($prefix, DIRECTORY_SEPARATOR);
    $prefix = str_replace(DIRECTORY_SEPARATOR, '/', $prefix);
    $prefix = $_SERVER['DOCUMENT_ROOT'] && Str::startsWith(__FILE__, str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR)) ? $prefix : '';

    $router->group([
        'prefix' => $prefix,
    ], function () use ($router) {

        foreach ( ['get', 'post', 'patch', 'delete'] as $method )
        {
            $router->{$method}('1.0/{path:.+}', function ($path) use ($method) {

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'http://34.64.94.163/1.0/'.$path.'?'.$_SERVER['QUERY_STRING']);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));

                if ( !empty(Request::all()) )
                {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(Request::all()));
                }

                if ( !empty(Request::header()) )
                {
                    $headers = [];
                    foreach ( array_keys(Request::header()) as $key )
                    {
                        array_push($headers, $key.':'.Request::header($key));
                    }
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                }

                return htmlspecialchars(curl_exec($curl), ENT_NOQUOTES);
            });
        }
    });

    $router->group([
        'prefix' => $prefix,
        'middleware' => [
            App\Http\Middleware\ApiMiddleware::class,
            App\Http\Middleware\AuthTokenMiddleware::class
        ],
    ], function () use ($router, $prefix) {
        $router->get('/', function () use ($router, $prefix) {
            return collect($router->getRoutes())->keys()->map(function ($info) use ($prefix) {
                return str_replace('/'.$prefix, ': ', $info);
            });
        });
        $router->get('auth/user', 'AuthUserController@index');
        $router->get('aftv-bcasts', 'AftvBcastController@index');
        $router->get('aftv-bcasts/{id}', 'AftvBcastController@show');
        $router->get('aftv-reviews/{id}', 'AftvReviewController@show');
        $router->get('clips', 'ClipController@index');
        $router->delete('clips/{id}', 'ClipController@destroy');
        $router->get('clips/{id}', 'ClipController@show');
        $router->get('comment-replies', 'CommentReplyController@index');
        $router->post('comment-replies', 'CommentReplyController@store');
        $router->patch('comment-replies/{id}', 'CommentReplyController@update');
        $router->delete('comment-replies/{id}', 'CommentReplyController@destroy');
        $router->get('comment-threads', 'CommentThreadController@index');
        $router->post('comment-threads', 'CommentThreadController@store');
        $router->patch('comment-threads/{id}', 'CommentThreadController@update');
        $router->delete('comment-threads/{id}', 'CommentThreadController@destroy');
        $router->get('dislikes', 'DislikeController@index');
        $router->post('dislikes', 'DislikeController@store');
        $router->delete('dislikes/{id}', 'DislikeController@destroy');
        $router->post('email/sign-up', 'SignUpEmailController@store');
        $router->post('email/change-email', 'ChangeEmailEmailController@store');
        $router->get('likes', 'LikeController@index');
        $router->post('likes', 'LikeController@store');
        $router->delete('likes/{id}', 'LikeController@destroy');
        $router->get('lol-champions', 'LolChampionController@index');
        $router->get('lol-games', 'LolGameController@index');
        $router->get('lol-games/{id}', 'LolGameController@show');
        $router->get('posts', 'PostController@index');
        $router->post('posts', 'PostController@store');
        $router->get('posts/{id}', 'PostController@show');
        $router->delete('posts/{id}', 'PostController@destroy');
        $router->patch('posts/{id}', 'PostController@update');
        $router->get('pubg-games', 'PubgGameController@index');
        $router->get('pubg-games/{id}', 'PubgGameController@show');
        $router->post('pwd-resets', 'PwdResetController@store');
        $router->patch('pwd-resets/{id}', 'PwdResetController@update');
        $router->post('sign-in', 'SignInController@store');
        $router->post('sign-up', 'SignUpController@store');
        $router->post('temp/clips', 'TempClipController@store');
        $router->get('users', 'UserController@index');
        $router->patch('users/{id}', 'UserController@update');
        $router->get('users/{id}', 'UserController@show');
        $router->post('user/clips', 'UserClipController@store');
        $router->get('vods/{id}', 'VodController@show');
        $router->get('watchable/lol-champions', 'WatchableLolChampionController@index');
        $router->get('youtube/videos', 'YtbVideoController@index');
        $router->get('youtube/videos/{id}', 'YtbVideoController@show');
        $router->get('youtube/comment/threads', 'YtbCommentThreadController@index');
        $router->get('youtube/comment/replies', 'YtbCommentReplyController@index');
    });
};

$router->group(array('domain' => '//aengzi.{region}.r.appspot.com', 'prefix' => 'api'), function () use ($addRoutes)
{
    $addRoutes();
});

$addRoutes();
