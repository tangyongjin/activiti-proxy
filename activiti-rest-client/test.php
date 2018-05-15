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
    请求URL:http://119.254.119.57:8111/activiti-rest/service/runtime/tasks/3477    （3477是上一步返回的ID）
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



 

$processDefinitionId = 'order:4:58';
$businessKey = null;
$message = null;
$tenantId = null;

$processDefinitionKey =null ;

$variables = array();

// $endPoint = new ActivitiStartProcessInstanceRequestVariable();
// $endPoint->setName('task_serial_no');
// $endPoint->setValue('7L7663WPX8QMN');
// $variables[] = $endPoint;

// $partnerId = new ActivitiStartProcessInstanceRequestVariable();
// $partnerId->setName('auto');
// $partnerId->setValue('y');
// $variables[] = $partnerId;
        
// $adminSecret = new ActivitiStartProcessInstanceRequestVariable();
// $adminSecret->setName('money');
// $adminSecret->setValue(11);
// $variables[] = $adminSecret;
        
 
        
// $entryName = new ActivitiStartProcessInstanceRequestVariable();
// $entryName->setName('groupId');
// $entryName->setValue('1');
// $variables[] = $entryName;





$response = $activiti->processInstances->startProcessInstance($processDefinitionId, $businessKey,$variables,$processDefinitionKey,$tenantId,
	$message);



// echo "<pre>Return:";

// print_r($response);
echo "得到 instacne_id:" ;

$instacne_id = $response->getId() ;



$resp=$activiti->tasks->listOfTasksByProcessInstanceId($instacne_id);

print_r($resp);

// print_r(  $instacne_id );



// echo "</pre>";




// echo "查询? instacne_id ";
// $task_ret= $activiti->runtime->getTask( $instacne_id); 



// $png=  $activiti->processInstances->getDiagramForProcessInstance(3528);

// print_r($task_ret ) ;


