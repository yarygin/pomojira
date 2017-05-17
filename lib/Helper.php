<?php
/**
 * @author Seleznyov Artyom seleznev@tutu.ru
 */
namespace Pomojira;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;

class Helper
{
	public static function getApi()
	{
		if(is_null($login = env('JIRA_LOGIN'))) {
			throw new \Exception("Login not provided");
		}
		if(is_null($password = env('JIRA_PASSWORD'))) {
			throw new \Exception("Login not provided");
		}
		return new Api(
			'https://hq.tutu.ru',
			new Basic($login, $password)
		);
	}
}