<?php
/**
 * @author Seleznyov Artyom seleznev@tutu.ru
 */

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;

class Helper
{
	public static function getApi()
	{
		$credentials = explode(';', file_get_contents('credentials'));
		list($login, $password) = $credentials;

		return new Api(
			'https://hq.tutu.ru',
			new Basic($login, $password)
		);
	}
}