<?php
/**
 * @author Seleznyov Artyom seleznev@tutu.ru
 */

require_once 'vendor/autoload.php';
require_once 'lib/NewIssuesFinder.class.php';

$if = new NewIssuesFinder();
$api = $if->_getApi();
$result = $api->getIssue('CF-2435')->getResult();

$issueData = [
	'taskNumber' => $result['key'],
	'ownerId' => $result['fields']['assignee']['name'],
	'avatarLink' => $result['fields']['assignee']['avatarUrls']['48x48'],
	'summary' => $result['fields']['summary'],
	'component' => $result['fields']['components'][0]['name'],
	'codeReviewer' => $result['fields']['customfield_10011']['displayName']
];

var_dump($issueData);