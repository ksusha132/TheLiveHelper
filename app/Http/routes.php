<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'roles', 'roles' => 'Admin'], function () {
    Route::post('/admin/save_roles', [
        'uses' => 'AdminController@Save_Roles',
        'as' => 'admin.SaveRoles'
    ]);
    Route::get('/admin/show_users', [
        'uses' => 'AdminController@Show_Users',
        'as' => 'admin.Show_Users'

    ]);
});

//Api
Route::post('api/login', 'ApiController@authenticate');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('api/info', 'ApiController@getAuthenticatedUser');
});


Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');

Route::get('/social_login/{provider}', 'SocialController@login');
Route::get('/social_login/callback/{provider}', 'SocialController@callback');

Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/activate', 'Auth\AuthController@activate');
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('user/edit', 'User\UserController@getEdit');
Route::post('user/edit', 'User\UserController@postEdit');
Route::get('user/delete', 'User\UserController@delete');
Route::get('user/show/{id_user}', 'User\UserController@show');

Route::get('user/add_to_friends/{id_user}', 'User\UserController@add_to_friends');
Route::get('user/accept_to_friends/{id_user}', 'User\UserController@accept_to_friends');
Route::get('user/remove_from_friends/{id_user}', 'User\UserController@remove_from_friends');
Route::get('user/add_to_blacklist/{id_user}', 'User\UserController@add_to_blacklist');
Route::get('user/remove_from_blacklist/{id_user}', 'User\UserController@remove_from_blacklist');
Route::get('user/deny_request/{id_user}', 'User\UserController@deny_request');
Route::get('user/friends', 'User\UserController@show_friends');
Route::get('user/requests', 'User\UserController@show_requests');


Route::post('user/upload_photo', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@upload_photo', // controller
]);
Route::get('user/delete_photo/{id_photo}', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@delete_photo', // controller
]);

Route::get('user/recommendations', [ // как выглядит роут в браузере
    'uses' => 'TrainController@get_recommendations', // controller
]);
Route::post('user/recommendations', [ // как выглядит роут в браузере
    'uses' => 'TrainController@post_recommendations', // controller
]);

Route::get('user/recommendations/approve/{id_recommendation}', [ // как выглядит роут в браузере
    'uses' => 'TrainController@approve', // controller
]);

Route::get('user/succesful_recommendations', [ // как выглядит роут в браузере
    'uses' => 'TrainController@show_succesful_recommendations', // controller
]);

Route::post('user/search_person', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@search_person', // controller
]);

Route::get('user/sport_calculations', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@sport_calculations', // controller
]);

Route::post('user/create_review', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@create_review', // controller
]);

Route::post('user/delete_review', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@delete_review', // controller
]);


Route::get('calculations', 'FoodController@vitamins_calculation');

Route::get('/user/calendar/{year}/{month}/{id_user}', [
    'uses' => 'User\UserController@calendar',
    'middleware' => ['auth', 'roles'],
    'as' => 'Calendar',
    'roles' => ['Trainer', 'Admin', 'User']
]);

Route::get('/conversations/send_message', [
    'uses' => 'ConversationController@get_send_message',
]);
Route::post('/conversations/send_message', [
    'uses' => 'ConversationController@post_send_message',
    'as' => 'message.Send',
]);
Route::get('/conversations', [
    'uses' => 'ConversationController@show_conversations',
]);

Route::get('/conversations/{id_conversation}', [ // как выглядит роут в браузере
    'uses' => 'ConversationController@show_conversation', // controller
]);

Route::post('/conversations/delete_message', [ // как выглядит роут в браузере
    'uses' => 'ConversationController@delete_message', // controller
]);

Route::post('/conversations/get_messages', [ // как выглядит роут в браузере
    'uses' => 'ConversationController@get_messages', // controller
]);

Route::post('/conversations/read_message', [ // как выглядит роут в браузере
    'uses' => 'ConversationController@read_message', // controller
]);

Route::get('user/delete_analis/{id_results}', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@delete_analis', // controller
]);
Route::get('user/create_analis', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@get_create_analis', // controller
]);
Route::post('user/create_analis', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@post_create_analis', // controller
]);
Route::get('user/edit_analis/{id_results}', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@get_edit_analis', // controller
]);
Route::post('user/edit_analis/{id_results}', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@post_edit_analis', // controller
]);
Route::get('user/show_analis', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@get_show_analis', // controller
]);
Route::post('user/show_analis', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@post_show_analis', // controller
]);

Route::get('analis/draw_graph/{id_analis}/{date_from?}/{date_to?}', [ // как выглядит роут в браузере
    'uses' => 'AnalisController@draw_graph', // controller
]);

Route::get('/get_alerts', [ // как выглядит роут в браузере
    'uses' => 'User\UserController@get_alerts', // controller
]);




Route::get('train/delete_train/{id_train}', 'TrainController@delete_train');

Route::get('train/edit_train/{id_train}', 'TrainController@get_edit_train');
Route::post('train/edit_train/{id_train}', 'TrainController@post_edit_train');

Route::get('train/create_train/{year}/{month}/{day}', 'TrainController@get_create_train');
Route::post('train/create_train/{year}/{month}/{day}', 'TrainController@post_create_train');

Route::get('train/create_client_train/{year}/{month}/{day}', 'TrainController@get_create_client_train');
Route::post('train/create_client_train/{year}/{month}/{day}', 'TrainController@post_create_client_train');


Route::get('train/show_sets/{id_train}', 'TrainController@show_sets');

Route::get('train/edit_set/{id_set}', 'TrainController@get_edit_set');
Route::post('train/edit_set/{id_set}', 'TrainController@post_edit_set');

Route::get('train/create_set/{id_train}', 'TrainController@get_create_set');
Route::post('train/create_set/{id_train}', 'TrainController@post_create_set');

Route::get('train/draw_graph/{date}', 'TrainController@draw_graph');
Route::get('food/show_graph/{date}', 'FoodController@show_graph_food');
Route::get('sleep/show_graph/{date}', 'SleepController@show_graph_sleep');
Route::get('weight/show_graph/{date}', 'WeightController@show_graph_weight');

Route::get('train/delete_set/{id_set}', 'TrainController@delete_set');


Route::get('food/create_meal/{year}/{month}/{day}', 'FoodController@get_create_meal');
Route::post('food/create_meal/{year}/{month}/{day}', 'FoodController@post_create_meal');

Route::get('food/edit_meal/{id_meal}', 'FoodController@get_edit_meal');
Route::post('food/edit_meal/{id_meal}', 'FoodController@post_edit_meal');

Route::get('food/delete_meal/{id_meal}', 'FoodController@delete_meal');


Route::get('food/create_eaten/{id_meal}', 'FoodController@get_create_eaten');
Route::post('food/create_eaten/{id_meal}', 'FoodController@post_create_eaten');

Route::get('food/edit_eaten/{id_eaten}', 'FoodController@get_edit_eaten');
Route::post('food/edit_eaten/{id_eaten}', 'FoodController@post_edit_eaten');

Route::get('food/show_eaten/{id_meal}', 'FoodController@show_eaten');

Route::get('food/delete_eaten/{id_eaten}', 'FoodController@delete_eaten');


Route::get('sleep/create_sleep/{year}/{month}/{day}', 'SleepController@get_create_sleep');
Route::post('sleep/create_sleep/{year}/{month}/{day}', 'SleepController@post_create_sleep');
Route::get('sleep/edit_sleep/{id_sleep}', 'SleepController@get_edit_sleep');
Route::post('sleep/edit_sleep/{id_sleep}', 'SleepController@post_edit_sleep');
Route::get('sleep/delete_sleep/{id_sleep}', 'SleepController@delete_sleep');

Route::get('weight/create_weight/{year}/{month}/{day}', 'WeightController@get_create_weight');
Route::post('weight/create_weight/{year}/{month}/{day}', 'WeightController@post_create_weight');
Route::get('weight/edit_weight/{id_weight}', 'WeightController@get_edit_weight');
Route::post('weight/edit_weight/{id_weight}', 'WeightController@post_edit_weight');
Route::get('weight/delete_weight/{id_weight}', 'WeightController@delete_weight');

Route::auth();
Route::get('/user/day/{year}/{month}/{day}', 'User\UserController@show_day');


Route::get('/home', 'HomeController@index');

Route::auth();


Route::get('/home', 'HomeController@index');
