<?php
/**
 * Class and Function List:
 * Function list:
 * - (()
 * - (()
 * - (()
 * - (()
 * Classes list:
 */
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('fbf_newsletter_signups', 'Subscriber');
Route::model('role', 'Role');
Route::model('cloudAccounts', 'CloudAccount');
Route::model('tickets', 'Ticket');
Route::model('ticket_comments', 'TicketComments');
Route::model('engine_logs', 'EngineLog');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('subscriber', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

Route::pattern('account', '[0-9]+');
Route::pattern('ticket', '[0-9]+');

Route::pattern('enginelog', '[0-9]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array(
    'prefix' => 'admin',
    'before' => 'auth'
) , function () {
    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');
    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');
	
	Route::get('subscribers/{subscriber}/delete', 'AdminSubscribersController@getDelete');
    Route::post('subscribers/{subscriber}/delete', 'AdminSubscribersController@postDelete');
    Route::controller('subscribers', 'AdminSubscribersController');
	
	Route::get('tickets/{ticket}/show', 'AdminTicketsController@getShow');
    Route::get('tickets/{ticket}/edit', 'AdminTicketsController@getEdit');
    Route::post('tickets/{ticket}/edit', 'AdminTicketsController@postEdit');
    Route::get('tickets/{ticket}/delete', 'AdminTicketsController@getDelete');
    Route::post('tickets/{ticket}/delete', 'AdminTicketsController@postDelete');
    Route::controller('tickets', 'AdminTicketsController');
	Route::controller('accounts', 'AdminAccountsController');
	# User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');
    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');
    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});
/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */
// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');
//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

Route::any('user/social/{action?}', array(
    "as" => "hybridauth",
    'uses' => 'UserController@socialLogin'
));
# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');
//:: Application Routes ::

# Filter for detect language
Route::when('contact-us', 'detectLang');
# Contact Us Static Page
Route::get('contact-us', function () {
    // Return about us page
    return View::make('site/contact-us');
});

Route::when('roadmap', 'detectLang');
Route::get('roadmap', function () {
    // Return about us page
    return View::make('site/static/roadmap');
});

Route::when('data-security', 'detectLang');
Route::get('data-security', function () {
    // Return about us page
    return View::make('site/static/data-security');
});

Route::when('cloudExperts', 'detectLang');
Route::get('cloudExperts', function () {
    // Return about us page
    return View::make('site/static/cloudExperts');
});

Route::when('videos', 'detectLang');
Route::get('videos', function () {
    // Return about us page
    return View::make('site/static/videos');
});

/* We don't use the default blog stuff
# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');
*/
/** ------------------------------------------
 *  Authenticated User Routes
 *  ------------------------------------------
 */
Route::group(array(
    'before' => 'auth'
) , function () {
    # Resource route for the cloud account API crendentials
    Route::any('account/', 'AccountController@getIndex'); 
	Route::get('account/create', 'AccountController@getCreate');
    Route::get('account/{account}/edit', 'AccountController@getCreate');
	Route::any('account/{account}/refresh', 'AccountController@checkStatus');
    Route::any('account/Taggedcost', 'AccountController@getTaggedcost');
      
    
    
    Route::get('assets/{account}/SecurityGroups', 'AssetsController@SecurityGroups');
    Route::get('assets/{account}/AwsInfo', 'AssetsController@AwsInfo');
    Route::get('assets/{account}/{regions}/EC2', 'AssetsController@instanceInfo');
    Route::get('assets/{account}/EBS', 'AssetsController@ebsInfo');
    Route::get('assets/{account}/SecurityGroupsInfo', 'AssetsController@sgInfo');
    Route::get('assets/{account}/KeyPairs', 'AssetsController@kpInfo');
    Route::get('assets/{account}/Tags', 'AssetsController@getTagNameValue');
    Route::get('assets/{account}/VPC', 'AssetsController@vpcsInfo');
    Route::get('assets/{account}/Subnets', 'AssetsController@subnetsInfo');
    Route::any('assets/{account}/SecurityGroupsData', 'AssetsController@getSecurityGroupsData');
    Route::any('assets/{account}/Summary', 'AssetsController@getSummary');
    Route::any('assets/Start', 'AssetsController@startInstance');
    Route::any('assets/Stop', 'AssetsController@stopInstance');
    
  	
	Route::any('security/portPreferences/', 'PortPreferencesController@getIndex'); 
	Route::get('security/portPreferences/create', 'PortPreferencesController@getCreate');
    Route::get('security/portPreferences/{portPreference}/edit', 'PortPreferencesController@getCreate');
    Route::any('security/portPreferences/{portPreference}/refresh', 'PortPreferencesController@checkStatus');
	Route::get('security/portPreferences/{portPreference}/portInfo', 'PortPreferencesController@portInfo'); 
	
	
	
	Route::any('security/{account}/AuditReports', 'SecurityReportsController@getAuditReports');
	Route::any('security/AuditReport', 'SecurityReportsController@getAuditReport');
	
	
	Route::any('ticket/', 'TicketController@getIndex'); 
	Route::get('ticket/create', 'TicketController@getCreate');
    Route::get('ticket/{ticket}/edit', 'TicketController@getCreate');
	Route::get('ticket/{ticket}/reply', 'TicketController@getReply');
	Route::any('ticket/{ticket}/close', 'TicketController@closeTicket');
	
	Route::any('enginelog/', 'EnginelogController@getIndex'); 
	Route::get('account/{account}/Cost', 'AccountController@getCost');
    Route::get('account/{account}/ChartsData', 'AccountController@getChartsData');
	Route::get('account/{account}/Log', 'AccountController@getLogs');
	Route::get('account/{account}/Collection', 'AccountController@Collection');
	
	//Route::any('account/{account}/ChartData', 'AccountController@getChartData');
	Route::any('account/{account}/CollectionData', 'AccountController@getCollectionData');
    Route::any('account/{account}/CurrentTagCost', 'AccountController@CurrentTagCostInfo');

    Route::get('account/{account}/cloudTrail', 'AccountController@CloudTrail');
    Route::any('account/{account}/cloudTrailCollection', 'AccountController@getcloudTrailCollection');
	
	Route::any('EC2Products/', 'AWSProductsController@getEC2Products');
	Route::get('ServiceStatus/', 'WebserviceController@getIndex');
	
	
	Route::any('Reserved/', 'AWSPricingController@getReserved'); 
	Route::any('Ondemand/', 'AWSPricingController@getOndemand'); 
	

    Route::any('budget/', 'BudgetController@getIndex');
    Route::get('budget/create', 'BudgetController@getCreate');
    Route::get('budget/{budget}/edit', 'BudgetController@getCreate');
    Route::get('budget/{budget}/budgettype', 'BudgetController@getBudgetType');
    Route::any('budget/{account}/BudgetStatus', 'BudgetController@getBudgetStatus');
    
    Route::any('scheduler/', 'SchedulerController@getIndex');
    Route::get('scheduler/create', 'SchedulerController@getCreate');
    Route::get('scheduler/{account}/{region}/instances', 'SchedulerController@getInstanceInfo');
    Route::get('scheduler/{scheduler}/edit', 'SchedulerController@getCreate');

    //Route::get('deployment/{id}/edit/', 'DeploymentController@getCreate');
    
    Route::group(array(
        'before' => 'csrf'
    ) , function () {
        Route::post('account/create', 'AccountController@postEdit');
        Route::post('account/{account}/edit', 'AccountController@postEdit');
        Route::post('account/{account}/delete', 'AccountController@postDelete');
		
		Route::post('security/portPreferences/create', 'PortPreferencesController@postEdit');
        Route::post('security/portPreferences/{portPreference}/edit', 'PortPreferencesController@postEdit');
        Route::post('security/portPreferences/{portPreference}/delete', 'PortPreferencesController@postDelete');
		
        Route::post('ticket/create', 'TicketController@postEdit');
        Route::post('ticket/{ticket}/edit', 'TicketController@postEdit');
		Route::post('ticket/{ticket}/reply', 'TicketController@postReply');
        Route::post('ticket/{ticket}/delete', 'TicketController@postDelete');

        Route::post('budget/create', 'BudgetController@postEdit');
        Route::post('budget/{budget}/edit', 'BudgetController@postEdit');
        Route::post('budget/{budget}/delete', 'BudgetController@postDelete');

        Route::post('scheduler/create', 'SchedulerController@postEdit');
        Route::post('scheduler/{scheduler}/edit', 'SchedulerController@postEdit');
        Route::post('scheduler/{scheduler}/delete', 'SchedulerController@postDelete');

    });
    
    
});
# Index Page - Last route, no matches
Route::get('/', array(
    'before' => 'detectLang',
    'uses' => 'HomeController@getIndex'
));