<?php
	$c = $app->getContainer();
	$c['errorHandler'] = function ($c) {
	  return function ($request, $response, $exception) use ($c) {
	    $data = [ 
	      'message' => $exception->getMessage()
	    ];
	 
	    return $c->get('response')->withStatus(500)
	             ->withHeader('Content-Type', 'application/json')
	             ->write(json_encode($data));
	  };
	};