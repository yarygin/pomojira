<?php
/**
 * @author Seleznyov Artyom seleznev@tutu.ru
 */

require_once 'vendor/autoload.php';

$issueList = explode(',', $_GET['issues']);
$dataToRender = [];
foreach ($issueList as $issueKey)
{
    // TODO: вместо этого можно при получении задач вытянуть всю инфу
    $api = \Pomojira\Helper::getApi();
    $issueData = $api->getIssue($issueKey)->getResult();
    $dataToRender[] = [
		'issueKey' => $issueData['key'],
		'assigneeName' => $issueData['fields']['assignee']['name'],
		'assigneeAvatarLink' => $issueData['fields']['assignee']['avatarUrls']['48x48'],
		'summary' => $issueData['fields']['summary'],
		'component' => $issueData['fields']['components'][0]['name'],
		'codeReviewer' => $issueData['fields']['customfield_10011']['displayName']
    ];
}
?>
<link type="text/css" rel="stylesheet" href="https://hq.tutu.ru/s/f86ae594ebbf179ede10d2eee7b3bd78-CDN/ljarqa/72005/e2b820449dba7db3e64153a92911b4be/28f4022e59967068c4f033a45fdbe612/_/download/contextbatch/css/_super/batch.css?atlassian.aui.raphael.disabled=true" data-wrm-key="_super" data-wrm-batch-type="context" media="all">
<link type="text/css" rel="stylesheet" href="https://hq.tutu.ru/s/12481e7c867955039984da8a455cfb20-CDN/ljarqa/72005/e2b820449dba7db3e64153a92911b4be/785da28a61efbef21cad6163b341edd3/_/download/contextbatch/css/greenhopper-rapid-non-gadget,atl.general,gh-rapid,jira.project.sidebar,com.atlassian.jira.projects.sidebar.init,jira.global,jira.general,-_super/batch.css?agile_global_admin_condition=true&amp;atlassian.aui.raphael.disabled=true&amp;hc-enabled=true&amp;is-server-instance=true&amp;jag=true&amp;jaguser=true&amp;nps-not-opted-out=true&amp;sd_operational=true" data-wrm-key="greenhopper-rapid-non-gadget,atl.general,gh-rapid,jira.project.sidebar,com.atlassian.jira.projects.sidebar.init,jira.global,jira.general,-_super" data-wrm-batch-type="context" media="all">
<link type="text/css" rel="stylesheet" href="https://hq.tutu.ru/s/36f98085b58aa80d794a3b54018eda21-CDN/ljarqa/72005/e2b820449dba7db3e64153a92911b4be/db2d903ac476c291ba8e898fcd04e603/_/download/contextbatch/css/gh-rapid-charts,-_super/batch.css?atlassian.aui.raphael.disabled=true" data-wrm-key="gh-rapid-charts,-_super" data-wrm-batch-type="context" media="all">
<link type="text/css" rel="stylesheet" href="https://hq.tutu.ru/s/2a21883ce1363b7b74a655e959c64c5c-T/ljarqa/72005/e2b820449dba7db3e64153a92911b4be/7.2.3/_/download/batch/com.atlassian.feedback.jira-feedback-plugin:button-resources-init/com.atlassian.feedback.jira-feedback-plugin:button-resources-init.css" data-wrm-key="com.atlassian.feedback.jira-feedback-plugin:button-resources-init" data-wrm-batch-type="resource" media="all">


<button class="pop" onclick="printPage();">Print</button>





<body id="jira" class="ghx-print-card-body">

<?php foreach($dataToRender as $item): ?>
	<div class="ghx-print-content-sizing ghx-print-large">
		<div class="ghx-card ">
			<div class="ghx-card-content">
				<div class="ghx-card-header">
					<div class="ghx-card-icon">
						<img src="https://hq.tutu.ru/secure/viewavatar?size=xsmall&amp;avatarId=14015&amp;avatarType=issuetype">
					</div>
					<div class="ghx-card-icon">
						<img src="https://hq.tutu.ru/images/icons/custom_priorities/equal.png">
					</div>
					<div class="ghx-card-key" style="font-size: 58px; font-weight: bold;">
						<?= $item['issueKey']; ?>
					</div>
					<div class="ghx-row-end">
						<img src="<?=$item['assigneeAvatarLink'];?>" class="ghx-avatar-img" style="border-radius: 25px; height: 100px; line-height: 50px; width: 100px;">
					</div>
				</div>
				<div class="ghx-card-summary" style="font-size: 53px; line-height: 1.3em; max-height: none; margin-top: 22px; font-weight: 100;">
					<?= $item['summary']; ?>
					<span class="ellipsis">…</span>
					<span class="obscurer"> </span>
				</div>
				<div class="ghx-card-extra-fields" style="display: none;">
					<div class="ghx-card-xfield-row">
						<div class="ghx-card-xfield-label">Компоненты</div>
						<div class="ghx-card-xfield-value"><?= $item['component']; ?></div>
					</div>
					<div class="ghx-card-xfield-row">
						<div class="ghx-card-xfield-label">Code reviewer</div>
						<div class="ghx-card-xfield-value"><?= $item['codeReviewer']; ?></div>
					</div>
				</div>
				<div class="ghx-card-footer"></div>
			</div>
			<div class="ghx-card-color" style="border-color:#66cc33;"></div>
		</div>
	</div>
<?php endforeach; ?>

</body>



<script>
    function printPage() {
        console.log(4);
        window.print();

        //workaround for Chrome bug - https://code.google.com/p/chromium/issues/detail?id=141633
        if (window.stop) {
            location.reload(); //triggering unload (e.g. reloading the page) makes the print dialog appear
            window.stop(); //immediately stop reloading
        }
        return false;
    }
</script>