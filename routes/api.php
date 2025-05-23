<?php

use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\AffectationController;
use App\Http\Controllers\API\ValidationController;
use App\Http\Controllers\API\RouteurController;
use App\Http\Controllers\API\DeblocageController;
use App\Http\Controllers\API\FeedBackController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\SavTicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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




/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
|
|*/


Route::post('/loginApi', 'App\Http\Controllers\API\AuthController@loginApi');
Route::get('/getCurrentUser/{id}', 'App\Http\Controllers\API\AuthController@getCurrentUser');

Route::get('/gettest', function () {
    return 'test';
});
Route::post('/registerApi', 'App\Http\Controllers\API\AuthController@registerpi');

/*
|
*/
/*
|--------------------------------------------------------------------------
| User routes
|--------------------------------------------------------------------------
|
|*/


Route::post('/updateDeviseKey', 'App\Http\Controllers\API\UserController@updateDeviseKey');
Route::post('/updatePlayerId', 'App\Http\Controllers\API\UserController@updatePlayerId');
Route::post('/deconnectUser', 'App\Http\Controllers\API\UserController@deconnectUser');
Route::get('/chectechnicienIsBlocked/{userId}', 'App\Http\Controllers\API\UserController@chectechnicienIsBlocked');

/*
|
*/
/*
|
*/
/*
|--------------------------------------------------------------------------
| Client client
|--------------------------------------------------------------------------
|
|*/


Route::get('/getClients/{id}/{nbBuild}', 'App\Http\Controllers\API\ClientController@getClients');
Route::get('/getClients/{id}', 'App\Http\Controllers\API\ClientController@getClients');
// Route::get('/getClientThecnicien/{id}', 'App\Http\Controllers\API\ClientController@getClientThecnicien');
Route::get('/getClientsThecnicien/{id}', [ClientController::class, 'getClientsThecnicien']);
Route::get('/getSavTickets/{id}', [SavTicketController::class, 'getAllTicket']);
Route::get('/getSavTicketSavBlocage/{id}', [SavTicketController::class, 'getSavTicketSavBlocage']);
Route::get('/getPlanifiedTicket/{id}', [SavTicketController::class, 'getPlanifiedTicket']);
Route::get('/getFeedbackSav/{id}', [SavTicketController::class, 'getFeedbackSav']);
Route::post('/planifierAffectationSav', [SavTicketController::class, 'planifierAffectationSav']);
Route::post('/declarationBlocageSav', [SavTicketController::class, 'declarationBlocageSav']);
Route::post('/updateBlocageSav', [SavTicketController::class, 'updateBlocageSav']);
Route::post('/feedbackSav', [SavTicketController::class, 'feedbackSav']);
Route::post('/updateFeedbackSav', [SavTicketController::class, 'updateFeedbackSav']);
Route::post('/storeImageBlocageSav', [SavTicketController::class, 'storeImageBlocageSav']);
Route::post('/updateImageBlocageSav', [SavTicketController::class, 'updateImageBlocageSav']);
/*
|
*/
/*
|--------------------------------------------------------------------------
| Client blocage
|--------------------------------------------------------------------------
|
|*/



Route::post('/declarationBlocage', 'App\Http\Controllers\API\BlocageController@declarationBlocage');
Route::post('/storeImageBlocage', 'App\Http\Controllers\API\BlocagePictureController@storeImageBlocage');
// Route::get('/getClientThecnicien/{id}', 'App\Http\Controllers\API\ClientController@getClientThecnicien');
Route::post('/addFeedback', 'App\Http\Controllers\API\FeedbackController@addFeedback');
Route::post('/addFeedbackBlockage', 'App\Http\Controllers\API\FeedbackController@addFeedbackBlocakge');
Route::post('/addPlanned', 'App\Http\Controllers\API\FeedbackController@addPlanned');


/*
|
*/
/*
|--------------------------------------------------------------------------
| Client validation
|--------------------------------------------------------------------------
|
|*/


Route::post('/validationAffectation', [ValidationController::class, 'validation']);
Route::post('/updateValidation/{id}', [ValidationController::class, 'updateValidation']);
// Route::get('/getClientThecnicien/{id}', 'App\Http\Controllers\API\ClientController@getClientThecnicien');

Route::get('/validation/{id}', [ValidationController::class, 'getValidation']);



/*
|
*/

/*
|--------------------------------------------------------------------------
| Client validation
|--------------------------------------------------------------------------
|
|*/


Route::post('/deblocage', [DeblocageController::class, 'deblocage']);
// Route::get('/getClientThecnicien/{id}', 'App\Http\Controllers\API\ClientController@getClientThecnicien');




/*
|
*/
/*
|--------------------------------------------------------------------------
| Notification
|--------------------------------------------------------------------------
|
|*/



Route::get('/notifications/{id}', [NotificationController::class, 'index']);
/*
|
*/

/*
|--------------------------------------------------------------------------
| Router
|--------------------------------------------------------------------------
|
|*/


Route::get('/getRouteurs', [RouteurController::class, 'getRouteurs']);

Route::post('/addRouteur', [RouteurController::class, 'addRouteurs']);





/*
|
*/

//test
Route::middleware('auth:sanctum')->group(
    function () {


        Route::get('/getAffectation/{id}', 'App\Http\Controllers\API\AffectationController@getAffectation');
        Route::get('/getAffectationPromoteurApi/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationPromoteurApi');
        Route::get('/getAffectationPromoteurPlanifierApi/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationPromoteurPlanifierApi');
        Route::get('/getAffectationPromoteurBlocageApi/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationPromoteurBlocageApi');
        Route::get('/getAffectationPlanifier/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationPlanifier');
        Route::get('/getAffectationValider/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationValider');
        Route::get('/getAffectationDeclarer/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationDeclarer');
        Route::get('/getAffectationBlocage/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationBlocage');
        Route::get('/getAffectationBlocageAfterDeclared/{id}', 'App\Http\Controllers\API\AffectationController@getAffectationBlocageAfterDeclared');
        Route::post('/createAffectation', 'App\Http\Controllers\API\AffectationController@createAffectation');
        Route::post('/createLogTechnicien', 'App\Http\Controllers\API\AffectationController@createLogTechnicien');
        Route::post('/uploadImages', 'App\Http\Controllers\API\AffectationController@uploadImages');
        Route::post('/planifierAffectation', 'App\Http\Controllers\API\AffectationController@planifierAffectation');
        Route::post('/updateDeclaration', 'App\Http\Controllers\API\DeclartionController@updateDeclaration');
        Route::post('/declarationAffectation', 'App\Http\Controllers\API\DeclartionController@declarationAffectation');
        Route::post('/updateDeclarationAffectation/{id}', 'App\Http\Controllers\API\DeclartionController@updateDeclarationAffectation');


        Route::get('/declaration/{id}', 'App\Http\Controllers\API\DeclartionController@getDeclaration');

        Route::post('/setAffectationAuto', [AffectationController::class, 'setAffectationAuto']);
    }
);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = cache()->remember('user_' . auth()->id(), 60, function () {
        return auth()->user();
    });
    return response()->json($user);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    // Delete the currently authenticated user's token
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Successfully logged out.'], 200);
});
