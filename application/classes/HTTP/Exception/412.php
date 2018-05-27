<?php defined('SYSPATH') or die('No direct script access.');

class HTTP_Exception_412 extends Kohana_HTTP_Exception_404 {
 
    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     * 
     * @return Response
     */
    public function get_response()
    {
        $view = View::factory('errors/412');
//Log::instance()->add(Log::NOTICE, Debug::vras('err')); 
        // Remembering that `$this` is an instance of HTTP_Exception_404
        $view->message = $this->getMessage();
 
        $response = Response::factory()
//	    ->send_file(TRUE,'media/adr.zip')
	    ->headers(array('Content-Type' => 'application/json', 'Cache-Control' => 'no-cache'))
            ->status(412)
            ->body($view->render());
 
        return $response;
    }
}