<?php

$app->get('/user/list', function ($request, $response, $args) {   
	foreach (User::all() as $result) {
	    $res[] = $result->to_array();
	}
	echo json_encode(array('result'=>$res));
});

$app->post('/user/save', function ($request, $response, $args) {    
	$newUser = new User($request->getParsedBody()); 
	if($newUser->save()){
		echo json_encode(array('message'=>'success','status'=>200));
	}else{
		echo json_encode(array('message'=>'failed','status'=>403));
	}
});

$app->post('/user/update/{id}', function ($request, $response, $args) {     
	$updateUser = User::find($args['id']);    
	if($updateUser->update_attributes($request->getParsedBody())){
		$returnValue = array('message'=>'success','status'=>200);
	}else{
		$returnValue = array('message'=>'failed','status'=>403);
	}
	return json_encode($returnValue);
});

$app->post('/user/login/{id}', function ($request, $response, $args) {     
	$updateUserToken = User::find($args['id']);  
	$updateUserToken->token = $args['id'].uniqid();
	if ($updateUserToken != null) {
		if ($request->getParsedBody()['username'] == $updateUserToken->username && $request->getParsedBody()['code'] == $updateUserToken->code) {
			if($updateUserToken->save()){
				$returnValue = array('token'=>$updateUserToken->token,'message'=>'success','status'=>200);
			}else{
				$returnValue = array('message'=>'failed','status'=>403);
			}
		}else{
			$returnValue = array('message'=>'failed','status'=>403);
		} 	
	}else{
		$returnValue = array('message'=>'failed','status'=>403);
	}
	
	return json_encode($returnValue);
});

//sample of getting token when making transaction, not being used
$app->get('/user/getToken/{id}', function ($request, $response, $args) {     
	$token = User::getToken($args['id']);
	print_r($token); 
});