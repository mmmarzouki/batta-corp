<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Custom\Response\JsonResponseContent;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Response::macro('api',function($message = 'Status Ok', $data = null) {
            $to_return = ['code' => 200];
            return response()->json($to_return);           
        });

        \Response::macro('ok',function($message = 'Status Ok', $data = null) {
            $to_return = ['code' => 200];
            return response()->json($to_return);           
        });        
        
        \Response::macro('created',function($message = 'Ressource Created', $data = null) {
            
            $to_return = ['code' => 200];
            return response()->json($to_return);
        });
        
        \Response::macro('deleted',function($message = 'Ressource Deleted', $data = null) {
            
            $to_return = ['code' => 200];
            return response()->json($to_return);          
        });

        \Response::macro('updated',function($message = 'Ressource Updated', $data = null) {
            
            $to_return = ['code' => 200];
            return response()->json($to_return);
        });

         \Response::macro('bad_request_exception',function($message = 'You may have some data missing', $data = null) {
            $to_return = ['code' => 400];
            return response()->json($to_return);        
        });
        
        \Response::macro('unautherized_exception',function($message = 'Unautherized.', $data = null) {
            $to_return = ['code' => 401];
            return response()->json($to_return);          
        });
        
        \Response::macro('internal_server_error',function($message = 'Oops, An Error Occured', $data = null) {
            
            $to_return = ['code' => 500];
            return response()->json($to_return);
        });

        \Response::macro('not_found_exception',function($message = 'Page Not Found', $data = null) {
            
            $to_return = ['code' => 404];
            return response()->json($to_return);
        });
        
        \Response::macro('access_denied_exception',function($message = 'Page Not Found', $data = null) {
            
            $to_return = ['code' => 403];
            return response()->json($to_return);
        });         
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
