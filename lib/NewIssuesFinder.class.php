<?php
/**
 * @author Seleznyov Artyom seleznev@tutu.ru
 */

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Issues\Walker;

class NewIssuesFinder
{
	const TABLE_NAME = 'cf_board_issues';

	public function getLatestDate()
	{
		$result = $this->_getPDO()->query('select max(`date`) as date from '.self::TABLE_NAME)->fetch();
		return isset($result['date']) ? $result['date'] : null;
	}

	public function findNewIssues()
	{
		$issuesList = $this->_getIssuesFromBoard();
		$savedIssuesList = $this->_getSavedIssues();
		$newIssues = [];
		foreach ($issuesList as $i)
		{
			if (!in_array($i, $savedIssuesList))
			{
				$sth = $this->_getPDO()->prepare('INSERT INTO '.self::TABLE_NAME.' (issue_key, `date`) VALUES(:issueKey, NOW())');
				$sth->execute(['issueKey' => $i]);
				$newIssues[] = $i;
			}
			else
			{
				$sth = $this->_getPDO()->prepare('UPDATE '.self::TABLE_NAME.' SET `date` = NOW() WHERE issue_key = :issueKey');
				$sth->execute(['issueKey' => $i]);
			}
		}

		return $newIssues;
	}

	private function _getIssuesFromBoard()
	{
		$walker = new Walker($this->_getApi());
		$walker->push(
			"project = 'CF' 
			AND (status != closed OR resolution = Fixed) 
			AND issuetype not in (epic, QA-Dev, QA-Task)
			AND status != Open
			AND (fixVersion in unreleasedVersions() OR fixVersion is EMPTY) and 
			(
				issuetype not in subTaskIssueTypes() or 
				(
					status not in (resolved, closed, 'To Do')
				)
			)"
		);
		$issueList = [];
		foreach ($walker as $issue) {
			$issueList[] = $issue->getKey();
		}

		return $issueList;
	}

	private function _getSavedIssues()
	{
		$res = [];
		foreach ($this->_getPDO()->query('select * from ' . self::TABLE_NAME)->fetchAll() as $item)
		{
			$res[] = $item['issue_key'];
		}
		return $res;
	}

	private function _getPDO()
	{
		return new PDO('mysql:dbname=pomojira;host=localhost', 'root', '');
	}


	private function _getApi()
	{
		$credentials = explode(';', file_get_contents('credentials'));
		list($login, $password) = $credentials;

		return new Api(
			'https://hq.tutu.ru',
			new Basic($login, $password)
		);
	}
}