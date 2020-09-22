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
use Illuminate\Support\Str;

$addRoutes = function () use ($router) {

    $prefix = str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR);
    $prefix = str_replace($prefix, '', __FILE__);
    $prefix = str_replace('routes'.DIRECTORY_SEPARATOR.'web.php', '', $prefix);
    $prefix = rtrim($prefix, DIRECTORY_SEPARATOR);

    $router->group([
        'prefix' => $_SERVER['DOCUMENT_ROOT'] && Str::startsWith(__FILE__, str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR)) ? $prefix : '',
        'middleware' => [
            App\Http\Middleware\ApiMiddleware::class,
            App\Http\Middleware\AuthTokenMiddleware::class
        ]
    ], function () use ($router) {

        $router->get('auth-user', 'AuthUserController@index');
        $router->patch('auth-user', 'AuthUserController@update');
        $router->post('auth-user/emails', 'AuthUserEmailTokenController@store');
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
        $router->post('devices', 'DeviceController@store');
        $router->patch('devices/{id}', 'DeviceController@update');
        $router->get('dislikes', 'DislikeController@index');
        $router->post('dislikes', 'DislikeController@store');
        $router->delete('dislikes/{id}', 'DislikeController@destroy');
        $router->patch('email-tokens', 'EmailTokenController@update');
        $router->get('likes', 'LikeController@index');
        $router->post('likes', 'LikeController@store');
        $router->delete('likes/{id}', 'LikeController@destroy');
        $router->get('lol-champions', 'LolChampionController@index');
        $router->get('lol-games', 'LolGameController@index');
        $router->get('lol-games/{id}', 'LolGameController@show');
        $router->get('notifications', 'NotificationController@index');
        $router->get('posts', 'PostController@index');
        $router->post('posts', 'PostController@store');
        $router->get('posts/{id}', 'PostController@show');
        $router->delete('posts/{id}', 'PostController@destroy');
        $router->patch('posts/{id}', 'PostController@update');
        $router->get('pubg-games', 'PubgGameController@index');
        $router->get('pubg-games/{id}', 'PubgGameController@show');
        $router->post('password-reset/emails', 'PasswordResetEmailTokenController@store');
        $router->post('sign-in', 'SignInController@store');
        $router->post('sign-up', 'SignUpController@store');
        $router->post('sign-up/emails', 'SignUpEmailTokenController@store');
        $router->post('temp-clips', 'TempClipController@store');
        $router->get('users', 'UserController@index');
        $router->get('users/{id}', 'UserController@show');
        $router->post('user-clips', 'UserClipController@store');
        $router->get('vods/{id}', 'VodController@show');
        $router->get('watchable-lol-champions', 'WatchableLolChampionController@index');
        $router->get('youtube-videos', 'YtbVideoController@index');
        $router->get('youtube-videos/{id}', 'YtbVideoController@show');
        $router->get('youtube-comment-threads', 'YtbCommentThreadController@index');
        $router->get('youtube-comment-replies', 'YtbCommentReplyController@index');
    });
};

$router->group(array('domain' => '//aengzi.{region}.r.appspot.com', 'prefix' => 'api'), function () use ($addRoutes)
{
    $addRoutes();
});

$addRoutes();
