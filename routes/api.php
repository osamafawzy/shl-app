<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*user start*/
Route::get('cities', 'UsersController@GetCity')->middleware('apilang');
Route::get('zones/{id}', 'UsersController@GetZones')->middleware('apilang');
Route::get('testcode/{phone}', 'UsersController@GetVCode');
Route::get('getuserdata/{id}', 'UsersController@GetUserData')->middleware('apilang');
Route::post('login', 'UsersController@Login');
Route::post('activate', 'UsersController@Activate');
Route::put('updateusertoken/{id}', 'UsersController@UpdateUserToken');
Route::put('updateaccount/{id}', 'UsersController@UpdateUserAccount')->middleware('apilang');
/*user end*/

/*services start*/
Route::post('storefavlocation', 'ServicesController@StoreFavLocation');
Route::get('deleteformfavlist/{id}', 'ServicesController@DeleteFavLocation');
Route::get('allserivces/{area}', 'ServicesController@GetALlServicesAndSupservices')->middleware('apilang');
Route::get('favlocationlist/{id}', 'ServicesController@getFavLocationList');
Route::get('servicesprice', 'ServicesController@ServicesPrice')->middleware('apilang');
Route::get('getservicescondtions', 'ServicesController@GetSubServicesCondtions')->middleware('apilang');
Route::get('getsubservicesrelatedmainservices/{id}', 'ServicesController@GetSubServicesRealtedMainSerbives')->middleware('apilang');
/*end*/

/* Order*/


Route::put('providercancel/{id}', 'OrderContreoller@ProviderCancelOrder');
Route::put('clintcancel/{id}', 'OrderContreoller@ClintCancelOrder');
Route::put('ordersuccess/{id}', 'OrderContreoller@FinishOrderSuccess');
Route::put('clintcancelorder/{id}', 'OrderContreoller@ClintCacelOrder');
Route::post('orderschedul', 'OrderContreoller@SechudelOrder');
Route::get('getprovidercancelreasone', 'OrderContreoller@GetCancelOrderReasons')->middleware('apilang');
Route::get('getclintcancelreasone', 'OrderContreoller@GetClintCancelOrderReasons')->middleware('apilang');
Route::get('clintordershoistry/{id}', 'OrderContreoller@GetClintOrderHistory')->middleware('apilang');
Route::get('providerordershoistry/{id}', 'OrderContreoller@GetProviderOrderHistory')->middleware('apilang');
Route::post('createorder', 'OrderContreoller@CreateOrder');
Route::post('refusedorder', 'OrderContreoller@RefusedOrder');

/*order end */


/*providor*/

Route::post('registerprovider', 'UsersController@CreateProvidor');
Route::put('updateprovidertoken/{id}', 'UsersController@UpdateProviderToken');
Route::put('updateprovidorlocation/{id}', 'UsersController@UpdateProviderLocations');
Route::put('updateprovideractive/{id}', 'UsersController@ChangActive');
Route::put('aceeptedorder/{id}', 'OrderContreoller@AcceptedOrder');
Route::put('editproviderdata/{id}', 'UsersController@UpdateProivderData');
Route::get('getservices', 'ServicesController@GetServicesForProvidor')->middleware('apilang');
Route::get('getsubservices/{id}', 'ServicesController@GetSupServicesForProvidor')->middleware('apilang');

/*probidor end*/


/*content with mangagment start*/
Route::get('contactwithmanagment', 'ContentMangamentController@GetAllContentWithMangmentPage')->middleware('apilang');
Route::get('termsandconditions', 'ContentMangamentController@GetTermsAndCondition')->middleware('apilang');
Route::get('aboutapp', 'ContentMangamentController@GetAboutApp')->middleware('apilang');
Route::post('testnotification', 'NotificationController@HandlePushToClintWhenRecivieMessages');
/*end*/

/*notification */
Route::get('proivdernotification/{id}', 'NotificationController@GetProviderNotification')->middleware('apilang');
Route::get('clintnotification/{id}', 'NotificationController@GetClintNotification')->middleware('apilang');
/*notification end*/
/*ads*/
Route::get('getalladss', 'AdsController@GetAllAds');
/*ads end*/
/* poll */
Route::get('getpoll', 'PollController@GettPoll')->middleware('apilang');
Route::post('vote', 'PollController@StoreVoted');
/*poll end*/

