<?php

$app->post('/logs/list', function ($request, $response, $args) {     
	$res = array();
	$userRecord = User::verifyToken($request->getParsedBody()['token']); 
	if ($userRecord['isValid']) {
		$conditions = array('conditions' => array("user_id = ?", $userRecord['result']->id));
		$logRecord = Log::all($conditions); 
		foreach ($logRecord as $result) {
		    $res[] = $result->to_array();
		}
		if ($res) {
			$object = array('result'=>$res, 'message'=>'List Successfully Retrieved');
		}else{
			$object = array('result'=>array(), 'message'=>'No Record found');
		}
	}else{
		$object = array('result'=>array(), 'message'=>'access token not valid');
	}
	
	return json_encode($object); 
});

$app->post('/logs/time_in', function ($request, $response, $args) {     
	$userRecord = User::verifyToken($request->getParsedBody()['token']); 
	if ($userRecord['isValid']) { 
		$conditions = array('conditions' => array("user_id = ? and date = ?", $userRecord['result']->id, $request->getParsedBody()['date']));
		$temp = Log::all($conditions);
		if ($temp) {
			$temp[0]->time_in = $request->getParsedBody()['time_in'];
			$temp[0]->save();
			$object = array('result'=>array(),'message' => 'Time In Ok');
		}else{
			$logRecord = new Log();
			$logRecord->time_in = $request->getParsedBody()['time_in'];
			$logRecord->date = $request->getParsedBody()['date']; 
			$logRecord->user_id = $userRecord['result']->id;	
			if($logRecord->save()){
				$object = array('message'=>'Time In Ok','status'=>200);
			}else{
				$object = array('message'=>'failed','status'=>403);
			}
		}
	}else{
		$object = array('result'=>array(), 'message'=>'access token not valid');
	}  
	 return json_encode($object);
});

$app->post('/logs/time_out', function ($request, $response, $args) {     
	$userRecord = User::verifyToken($request->getParsedBody()['token']); 
	if ($userRecord['isValid']) {
		$conditions = array('conditions' => array("user_id = ? and date = ?", $userRecord['result']->id, $request->getParsedBody()['date']));
		$logRecord = Log::all($conditions);
		$logRecord[0]->time_out = $request->getParsedBody()['time_out'];
		$logRecord[0]->save();
		$object = array('result'=>array(),'message' => 'Time Out Ok');
	}else{
		$object = array('result'=>array(), 'message'=>'access token not valid');
	}  
	  return json_encode($object);
});