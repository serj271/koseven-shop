<?php defined('SYSPATH') or die('No direct script access.');

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {
 
    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     * 
     * @return Response
     */
    public function get_response()
    {
        $view = View::factory('errors/404');
//Log::instance()->add(Log::NOTICE, Debug::vars('err',$this->getMessage())); 
        // Remembering that `$this` is an instance of HTTP_Exception_404
        $view->message = $this->getMessage();
 
        $response = Response::factory()
//	    ->send_file(TRUE,'media/adr.zip')
//            ->status(404)
            ->body($view->render());
 
        return $response;
    }
}