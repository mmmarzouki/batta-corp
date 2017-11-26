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
        \Response::macro('api',function($message = 'Status Ok', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(200,$message);
            return $resp;            
        });
        
        \Response::macro('created',function($message = 'Ressource Created', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(200,$message);
            return $resp;  
        });
        
        \Response::macro('deleted',function($message = 'Ressource Deleted', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(200,$message);
            return $resp;            
        });

        \Response::macro('updated',function($message = 'Ressource Updated', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(200,$message);
            return $resp;             
        });

         \Response::macro('bad_request_exception',function($message = 'You may have some data missing', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(400,$message);
            return $resp;             
        });
        
        \Response::macro('unautherized_exception',function($message = 'Unautherized.', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(401,$message);
            return $resp;            
        });
        
        \Response::macro('internal_server_error',function($message = 'Oops, An Error Occured', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(500,$message);
            return $resp;            
        });

        \Response::macro('not_found_exception',function($message = 'Page Not Found', $data = null) {
            $resp = \Response::make();
            $content = new JsonResponseContent($_code = $code, $_message = $message, $_data = $data );
            $resp->setContent($content);
            $resp->setStatusCode(404,$message);
            return $resp;            
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
