<?php


/*

1.启动
	请求URL:http://119.254.119.57:8111/activiti-rest/service/runtime/process-instances
	参数示例：
		{
			"processDefinitionKey":"order"
		}

2.根据启动返回的流程ID查询任务ID
	请求URL:http://119.254.119.57:8111/activiti-rest/service/runtime/tasks?candidateUser=user1&processInstanceId=3470（其中3470是启动时返回的ID）


3.获取用户待办
    请求URL: http://119.254.119.57:8111/activiti-rest/service/runtime/tasks/3477    （3477是上一步返回的ID）
	参数：
		{
			"action": "claim",
			"assignee": "user1"
		}

4.执行下一步（填写表单+下一步）
    请求URL:http://119.254.119.57:8111/activiti-rest/service/runtime/tasks/3477    （3477是上一步返回的ID）
	参数示例：
		{
			"action": "complete",
			"assignee": "user1"，
			"variables": [
					{
					  "name": "uName",
					  "type": "string",
					  "value": "dsds"
					},
					{
					  "name": "auto",
					  "type": "string",
					  "value": "dsds"
					},
					{
					  "name": "money",
					  "type": "integer",
					  "value": 32
					},
					{
					  "name": "groupId",
					  "type": "string",
					  "value": "2"
					},
					{
					  "name": "isNetWork",
					  "type": "string",
					  "value": "网络"
					}
				  ]
		}

*/

require_once(__DIR__ . '/client/ActivitiClient.php');
require_once(__DIR__ . '/client/objects/ActivitiStartProcessInstanceRequestVariable.php');


$activiti = new ActivitiClient();


/*
        $this->deployment = new ActivitiDeploymentService($this);
		$this->processDefinitions = new ActivitiProcessDefinitionsService($this);
		$this->models = new ActivitiModelsService($this);
		$this->processInstances = new ActivitiProcessInstancesService($this);
		$this->executions = new ActivitiExecutionsService($this);
		$this->tasks = new ActivitiTasksService($this);
		$this->history = new ActivitiHistoryService($this);
		$this->forms = new ActivitiFormsService($this);
		$this->databaseTables = new ActivitiDatabaseTablesService($this);
		$this->engine = new ActivitiEngineService($this);
		$this->runtime = new ActivitiRuntimeService($this);
		$this->jobs = new ActivitiJobsService($this);
		$this->users = new ActivitiUsersService($this);
		$this->groups = new ActivitiGroupsService($this);
*/



$activiti->setUrl('119.254.119.57','8111','http');
$activiti->setCredentials('user1', '000000');

$activiti->setDebug(false);

/*
        $this->deployment = new ActivitiDeploymentService($this);
		$this->processDefinitions = new ActivitiProcessDefinitionsService($this);
		$this->models = new ActivitiModelsService($this);
		$this->processInstances = new ActivitiProcessInstancesService($this);
		$this->executions = new ActivitiExecutionsService($this);
		$this->tasks = new ActivitiTasksService($this);
		$this->history = new ActivitiHistoryService($this);
		$this->forms = new ActivitiFormsService($this);
		$this->databaseTables = new ActivitiDatabaseTablesService($this);
		$this->engine = new ActivitiEngineService($this);
		$this->runtime = new ActivitiRuntimeService($this);
		$this->jobs = new ActivitiJobsService($this);
		$this->users = new ActivitiUsersService($this);
		$this->groups = new ActivitiGroupsService($this);
*/

 

$processDefinitionId = null;
$businessKey = null;
$message = null;
$tenantId = null;

$processDefinitionKey ='order' ;

$variables = array();

 

$response = $activiti->processInstances->startProcessInstance($processDefinitionId, $businessKey,$variables,$processDefinitionKey,$tenantId,
	$message);



$instacne_id = $response->getId() ;

debug("得到 instacne_id:".$instacne_id) ;


$resp=$activiti->tasks->listOfTasksByProcessInstanceId($instacne_id);

$return=$resp->getData();

debug(  $return[0]);

$taskId=$return[0]->getId();

debug(  $taskId);



$action=array("action"=>"claim","assignee"=>"user1");
// {
//   "action" : "claim",
//   "assignee" : "userWhoClaims"
// }

$resp=$activiti->tasks->taskActions($taskId,$action);
debug( $resp);





$formdata=array(
    array('name'=>'uName','type'=>'string','value'=>'89900'),
    array('name'=>'auto','type'=>'string','value'=>'VVV'),
	array('name'=>'isNetWork','type'=>'string','value'=>'网络'),
    array('name'=>'money','type'=>'integer','value'=>199),
	array('name'=>'groupId','type'=>'string','value'=>'3') 
	
);

$action=array("action"=>"complete","assignee"=>"user1",'variables'=>$formdata);


$resp=$activiti->tasks->taskActions($taskId,$action);
debug( $resp);



 $arr=array('candidateUser'=>'crm1');

$resp=$activiti->tasks->listOfTasksByArg($arr);
debug( $resp);





$query=array( 
	array('name'=>'uName','type'=>'string','value'=>'19841989',  "operation" => "equals")
    );



$queryRet=$activiti->processInstances->queryProcessInstances('order',$query);

debug( $queryRet);

//listOfTasksByArg



	// public function queryProcessInstances($processDefinitionKey = null, $variables = null)
	// {
	// 	$data = array();
	// 	if(!is_null($processDefinitionKey))
	// 		$data['processDefinitionKey'] = $processDefinitionKey;
	// 	if(!is_null($variables))
	// 		$data['variables'] = $variables;
		
	// 	return $this->client->request("query/process-instances", 'POST', $data, array(200), array(400 => "Indicates a parameter was passed in the wrong format . The status-message contains additional information."), 'ActivitiQueryProcessInstancesResponse');
	// }



/*

POST query/process-instances


{
  "processDefinitionKey":"order",
  "variables":
  [
    {
        "name" : "myVariable",
        "value" : 1234,
        "operation" : "equals",
        "type" : "long"
    }
  ]
}
*/


?>


