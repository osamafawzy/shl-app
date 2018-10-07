<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use DB;

Route::get('/', function () {
    return view('login.login');
});
Route::post('sotreservices', 'AdminPanel\ServicesAdminController@StoreServices');
Route::put('changeactivaity/{id}', 'AdminPanel\ServicesAdminController@ChangeActivaity');
Route::put('updated_services/{id}', 'AdminPanel\ServicesAdminController@UpdateServices');
Route::put('changeservicezoneprice/{id}', 'AdminPanel\ServicesAdminController@ChangeServiceZonePrice');
Route::post('createservicescity', 'AdminPanel\ServicesAdminController@CreateServicesCity')->middleware('apilang');
Route::post('createserviceszone', 'AdminPanel\ServicesAdminController@CreateServicesZone')->middleware('apilang');
Route::get('services', 'AdminPanel\ServicesAdminController@index');
Route::get('services_prices', 'AdminPanel\ServicesAdminController@services_price_index');
Route::get('services_zone/{id}', 'AdminPanel\ServicesAdminController@services_zone_index');
Route::get('addservices', 'AdminPanel\ServicesAdminController@addservicesindex');
Route::get('updateservice/{id}', 'AdminPanel\ServicesAdminController@updateserviceindex');
Route::get('allservices', 'AdminPanel\ServicesAdminController@GetServices')->middleware('apilang');
Route::get('allserviceswithcityandzones', 'AdminPanel\ServicesAdminController@GetServicesZones')->middleware('apilang');
Route::get('getservicestoupdated/{id}', 'AdminPanel\ServicesAdminController@GetServicesForUpdated')->middleware('apilang');
Route::get('getServicesCity/{id}', 'AdminPanel\ServicesAdminController@GetServicesCity')->middleware('apilang');
Route::get('serviceszone/{id}', 'AdminPanel\ServicesAdminController@ServicesZone')->middleware('apilang');
Route::get('getServicesZone/{id}', 'AdminPanel\ServicesAdminController@getServicesZone')->middleware('apilang');


/* clients*/
Route::get('clients', 'AdminPanel\ClientsAdminController@index');
Route::get('allclients', 'AdminPanel\ClientsAdminController@GetClients')->middleware('apilang');
Route::put('updateclient/{id}', 'AdminPanel\ClientsAdminController@changeactivate')->middleware('apilang');
Route::get('clientProfile/{id}', 'AdminPanel\ClientsAdminController@profilepage')->middleware('apilang');
Route::get('clientData/{id}', 'AdminPanel\ClientsAdminController@clientdata');





/* reports */
Route::get('reports', 'AdminPanel\ReportsAdminController@index');
Route::get('providerReports', 'AdminPanel\ReportsAdminController@indexForProvider');
Route::get('followProviders', 'AdminPanel\ReportsAdminController@indexForFollowProvider');

//realtime reports
//Route::get('reports/orders', 'AdminPanel\ReportsAdminController@GetOrdersWithoutListner');
//Route::get('reports/order', 'AdminPanel\ReportsAdminController@GetOrdersWithListner');
Route::get('mainServices', 'AdminPanel\ReportsAdminController@allServices')->middleware('apilang');
Route::get('subServices/{service_id}', 'AdminPanel\ReportsAdminController@subServices')->middleware('apilang');
Route::post('sendRequestReport', 'AdminPanel\ReportsAdminController@sendRequestReportForOrders');
Route::post('sendProviderReport', 'AdminPanel\ReportsAdminController@sendRequestReportForProviders');
Route::get('allServicesReport', 'AdminPanel\ReportsAdminController@allServicesReport')->middleware('apilang');
Route::post('tableReport', 'AdminPanel\ReportsAdminController@tableReportForOrders')->middleware('apilang');
Route::post('ProviderReport', 'AdminPanel\ReportsAdminController@tableReportForProviders')->middleware('apilang');
Route::post('sendFollowProviderReport', 'AdminPanel\ReportsAdminController@sendFollowProviderReport')->middleware('apilang');


/* providers*/
Route::get('providers', 'AdminPanel\ProvidersAdminController@index');
Route::get('allproviders', 'AdminPanel\ProvidersAdminController@Getproviders')->middleware('apilang');
Route::put('updateprovider/{id}', 'AdminPanel\ProvidersAdminController@changeactivate')->middleware('apilang');
Route::get('providerProfile/{id}', 'AdminPanel\ProvidersAdminController@profilepage')->middleware('apilang');
Route::get('providerData/{id}', 'AdminPanel\ProvidersAdminController@providerdata');

/* requests*/
Route::get('requests', 'AdminPanel\RequestsAdminController@index');
Route::get('allrequests', 'AdminPanel\RequestsAdminController@Getrequests')->middleware('apilang');
Route::get('acceptrequest/{id}', 'AdminPanel\RequestsAdminController@AcceptRequest')->middleware('apilang');
Route::get('rejectrequest/{id}', 'AdminPanel\RequestsAdminController@RejectRequest')->middleware('apilang');
Route::get('rejectedrequests', 'AdminPanel\RequestsAdminController@RejectedRequests');
Route::get('rejectedrequest', 'AdminPanel\RequestsAdminController@RejectedRequest')->middleware('apilang');


/* questionnaire*/
Route::get('addquestionnaire/{id?}', 'AdminPanel\questionnaireAdminController@addquestionnaireindex');
Route::post('storequestions/{id?}', 'AdminPanel\questionnaireAdminController@StoreQuestions');
Route::get('questionspage/{id}', 'AdminPanel\questionnaireAdminController@GetQuestionsPage');
Route::get('allquestions/{id}', 'AdminPanel\questionnaireAdminController@AllQuestions')->middleware('apilang');
Route::put('recieveQuestionnaire/{id}', 'AdminPanel\questionnaireAdminController@RecieveQuestionnaire');





/* polls*/
Route::get('polls', 'AdminPanel\questionnaireAdminController@pollindex');
Route::get('allpolls', 'AdminPanel\questionnaireAdminController@GetPolls')->middleware('apilang');
Route::get('deletepoll/{id}', 'AdminPanel\questionnaireAdminController@DeletePoll');

Route::get('deletequestion/{id}', 'AdminPanel\questionnaireAdminController@deletequestion')->middleware('apilang');
Route::get('showresult/{id}', 'AdminPanel\questionnaireAdminController@showresult')->middleware('apilang');


/* zones */

Route::get('zones', 'AdminPanel\zoneAdminController@index');
Route::post('storezone', 'AdminPanel\zoneAdminController@storezone');



/* contact us*/


Route::get('contact_us', 'AdminPanel\ContactUsController@index');
Route::get('contactus', 'AdminPanel\ContactUsController@GetContacts')->middleware('apilang');
Route::post('createcontact', 'AdminPanel\ContactUsController@CreateNewContacts')->middleware('apilang');
Route::post('updatecontact/{id}', 'AdminPanel\ContactUsController@UpdateContact')->middleware('apilang');
Route::delete('deleteContact/{id}', 'AdminPanel\ContactUsController@DeleteContact');

/*end*/

/*social media*/
Route::get('social_media', 'AdminPanel\SocialMediaController@SocialMeidaIndex');
Route::get('socialmedia', 'AdminPanel\SocialMediaController@GetSocialMedia');
Route::put('updatesoicamedia/{id}', 'AdminPanel\SocialMediaController@UpdateSocialMedia');
/*end*/

/*services tersm condtions*/
Route::get('services_terms', 'AdminPanel\ServicesTermsCondtionsController@ServicesCondtionsIndex');
Route::get('servicesterms', 'AdminPanel\ServicesTermsCondtionsController@GetServicesTermsConditions')->middleware('apilang');
Route::put('updated_services_terms/{id}', 'AdminPanel\ServicesTermsCondtionsController@UpdateTermsCondtions');
/*end*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


// for managers routes
Route::resource('/manager','AdminPanel\managerController');
Route::get('/manager/{id}/delete','AdminPanel\managerController@destroy');

// for role routes
Route::resource('/role','AdminPanel\roleController');
Route::get('/role/{id}/delete','AdminPanel\roleController@destroy');

// for permission routes
Route::resource('/permission','AdminPanel\permissionController');
Route::get('/permission/{id}/delete','AdminPanel\permissionController@destroy');