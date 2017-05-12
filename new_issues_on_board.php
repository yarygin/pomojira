<html>
	<head>
		<title>Жира-поможира: новые задачи на доске</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
    <?php

    require_once 'vendor/autoload.php';
    require_once 'lib/NewIssuesFinder.class.php';

    $newIssuesFinder = new NewIssuesFinder();
	$latestDate = $newIssuesFinder->getLatestDate();
	$newIssues = $newIssuesFinder->findNewIssues();
	echo "Новые задачи " . (!is_null($latestDate) ? "после $latestDate" : '') . ':<br>';
    foreach ($newIssues as $i)
        echo $i . '<br>';
    ?>
	</body>
</html>
