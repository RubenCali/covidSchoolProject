<?php

use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace( 'Website\Controllers' );

SimpleRouter::group( [ 'prefix' => site_url() ], function () {

	// START: Zet hier al eigen routes
	// Lees de docs, daar zie je hoe je routes kunt maken: https://github.com/skipperbent/simple-php-router#routes

	SimpleRouter::get( '/geinlogdepagina', 'WebsiteController@geinlogdepagina' )->name( 'geinlogdepagina' );
	SimpleRouter::get( '/login', 'WebsiteController@login' )->name( 'login' );
	SimpleRouter::post( '/login/handle', 'WebsiteController@loginHandle' )->name( 'login.handle' );
	SimpleRouter::get( '/register', 'WebsiteController@register' )->name( 'register' );
	SimpleRouter::post( '/register/handle', 'WebsiteController@registerHandle' )->name( 'register.handle' );
	SimpleRouter::get( '/', 'WebsiteController@naarLogin' )->name( 'login.redirect' );
	SimpleRouter::get( '/logout', 'WebsiteController@logout' )->name( 'logout' );
	SimpleRouter::get( '/settings', 'WebsiteController@settings' )->name( 'settings' );
	SimpleRouter::get( '/schema/{sport_id}', 'WebsiteController@schema' )->name( 'schema' );
	SimpleRouter::post('/search', 'WebsiteController@search')->name('search');
	SimpleRouter::match(['post', 'get'], '/forgot-password', 'WebsiteController@passwordForgottenForm')->name('password.change');
	SimpleRouter::match(['post', 'get'], '/forgot-password/{reset_code}', 'WebsiteController@passwordResetForm')->name('password.reset');
	// STOP: Tot hier al je eigen URL's zetten

	SimpleRouter::get( '/not-found', function () {
		http_response_code( 404 );

		return '404 Page not Found';
	} );

} );


// Dit zorgt er voor dat bij een niet bestaande route, de 404 pagina wordt getoond
SimpleRouter::error( function ( Request $request, \Exception $exception ) {
	if ( $exception instanceof NotFoundHttpException && $exception->getCode() === 404 ) {
		response()->redirect( site_url() . '/not-found' );
	}

} );

