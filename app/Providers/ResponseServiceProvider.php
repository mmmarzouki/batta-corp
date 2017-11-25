<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Response::macro('api',function($code = 200, $message = '', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode($code);
            return $resp;            
        });
        
        \Response::macro('created',function($message = 'Ressource Created', $data = null) {
                return response()->api(200,$message,$data);
        });
        
        \Response::macro('deleted',function($message = 'Ressource Deleted', $data = null) {
            return response()->api(200,$message,$data);          
        });

        \Response::macro('updated',function($message = 'Ressource Updated', $data = null) {
            return response()->api(200,$message,$data);           
        });

         \Response::macro('bad_request_exception',function($message = 'You may have some data missing', $data = null) {
            return response()->api(400,$message,$data);           
        });
        
        \Response::macro('unautherized_exception',function($message = 'Unautherized.', $data = null) {
            return response()->api(401,$message,$data);           
        });
        
        \Response::macro('internal_server_error',function($message = 'Oops, An Error Occured', $data = null) {
            return response()->api(500,$message,$data);           
        });         
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
