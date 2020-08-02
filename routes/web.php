<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	return view('welcome');
});

Route::get('login/facebook', 'SocialiteController@redirectToProvider');
Route::get('login/facebook/callback', 'SocialiteController@handleProviderCallback');

//AccountPlans
Route::resource('/accountPlan', 'AccountPlanController');
Route::get('/accountPlan/{id}', 'AccountPlanController@show');

//Balances
Route::resource('/balance', 'BalanceController');
Route::get('/balance/{id}', 'BalanceController@show');

//Banks
Route::resource('/bank', 'BankController');
Route::get('/bank/{id}', 'BankController@show');

//Boxes
Route::resource('/box', 'BoxController');
Route::get('/box/{id}', 'BoxController@show');

//Cards
Route::resource('/card', 'CardController');
Route::get('/card/{id}', 'CardController@show');

//Costs
Route::resource('/cost', 'CostController');
Route::get('/cost/{id}', 'CostController@show');

//Customers
Route::resource('/customer', 'CustomerController');
Route::get('/customer/{id}', 'CustomerController@show');

//DocumentTypes
Route::resource('/documentType', 'DocumentTypeController');
Route::get('/documentType/{id}', 'DocumentTypeController@show');

//EventTypes
Route::resource('/eventType', 'EventTypeController');
Route::get('/eventType/{id}', 'EventTypeController@show');

//Knowledge
Route::resource('/knowledge', 'KnowledgeController');
Route::get('/knowledge/{id}', 'KnowledgeController@show');

//MovementBanks
Route::resource('/movementBank', 'MovementBankController');
Route::get('/movementBank/{id}', 'MovementBankController@show');

//MovementBoxes
Route::resource('/movementBox', 'MovementBoxController');
Route::get('/movementBox/{id}', 'MovementBoxController@show');

//MovementCards
Route::resource('/movementCard', 'MovementCardController');
Route::get('/movementCard/{id}', 'MovementCardController@show');

//MovementChecks
Route::resource('/movementCheck', 'MovementCheckController');
Route::get('/movementCheck/{id}', 'MovementCheckController@show');

//Movements
Route::resource('/movement', 'MovementController');
Route::get('/movement/{id}', 'MovementController@show');

//Parameters
Route::resource('/parameter', 'ParameterController');
Route::get('/parameter/{id}', 'ParameterController@show');

//Plannings
Route::resource('/planning', 'PlanningController');
Route::get('/planning/{id}', 'PlanningController@show');

//Plans
Route::resource('/plan', 'PlanController');
Route::get('/plan/{id}', 'PlanController@show');

//Providers
Route::resource('/provider', 'ProviderController');
Route::get('/provider/{id}', 'ProviderController@show');

//Regs
Route::resource('/reg', 'RegController');
Route::get('/reg/{id}', 'RegController@show');

//Roles
Route::resource('/role', 'RoleController');
Route::get('/role/{id}', 'RoleController@show');

//Transfers
Route::resource('/transfer', 'TransferController');
Route::get('/transfer/{id}', 'TransferController@show');

//Users
Route::resource('/user', 'UserController');
Route::get('/user/{id}', 'UserController@show');

//UsersParameters
Route::resource('/usersParameter', 'UsersParameterController');
Route::get('/usersParameter/{id}', 'UsersParameterController@show');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
