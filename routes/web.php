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

//AccountPlans
Route::resource('/accountPlans', 'AccountPlansController');
Route::get('/accountPlans/{id}', 'AccountPlansController@show');

//Balances
Route::resource('/balances', 'BalancesController');
Route::get('/balances/{id}', 'BalancesController@show');

//Banks
Route::resource('/banks', 'BanksController');
Route::get('/banks/{id}', 'BanksController@show');

//Boxes
Route::resource('/boxes', 'BoxesController');
Route::get('/boxes/{id}', 'BoxesController@show');

//Cards
Route::resource('/cards', 'CardsController');
Route::get('/cards/{id}', 'CardsController@show');

//Costs
Route::resource('/costs', 'CostsController');
Route::get('/costs/{id}', 'CostsController@show');

//Customers
Route::resource('/customers', 'CustomersController');
Route::get('/customers/{id}', 'CustomersController@show');

//DocumentTypes
Route::resource('/documentTypes', 'DocumentTypesController');
Route::get('/documentTypes/{id}', 'DocumentTypesController@show');

//EventTypes
Route::resource('/eventTypes', 'EventTypesController');
Route::get('/eventTypes/{id}', 'EventTypesController@show');

//Knowledge
Route::resource('/knowledge', 'KnowledgeController');
Route::get('/knowledge/{id}', 'KnowledgeController@show');

//MovementBanks
Route::resource('/movementBanks', 'MovementBanksController');
Route::get('/movementBanks/{id}', 'MovementBanksController@show');

//MovementBoxes
Route::resource('/movementBoxes', 'MovementBoxesController');
Route::get('/movementBoxes/{id}', 'MovementBoxesController@show');

//MovementCards
Route::resource('/movementCards', 'MovementCardsController');
Route::get('/movementCards/{id}', 'MovementCardsController@show');

//MovementChecks
Route::resource('/movementChecks', 'MovementChecksController');
Route::get('/movementChecks/{id}', 'MovementChecksController@show');

//Movements
Route::resource('/movements', 'MovementsController');
Route::get('/movements/{id}', 'MovementsController@show');

//Parameters
Route::resource('/parameters', 'ParametersController');
Route::get('/parameters/{id}', 'ParametersController@show');

//Plannings
Route::resource('/plannings', 'PlanningsController');
Route::get('/plannings/{id}', 'PlanningsController@show');

//Plans
Route::resource('/plans', 'PlansController');
Route::get('/plans/{id}', 'PlansController@show');

//Providers
Route::resource('/providers', 'ProvidersController');
Route::get('/providers/{id}', 'ProvidersController@show');

//Regs
Route::resource('/regs', 'RegsController');
Route::get('/regs/{id}', 'RegsController@show');

//Roles
Route::resource('/roles', 'RolesController');
Route::get('/roles/{id}', 'RolesController@show');

//Transfers
Route::resource('/transfers', 'TransfersController');
Route::get('/transfers/{id}', 'TransfersController@show');

//Users
Route::resource('/users', 'UsersController');
Route::get('/users/{id}', 'UsersController@show');

//UsersParameters
Route::resource('/usersParameters', 'UsersParametersController');
Route::get('/usersParameters/{id}', 'UsersParametersController@show');

