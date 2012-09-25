<?php
/**
 * This simple script makes it easy to disable Module Surfer on all list views by default.  (The default behavior is to have it enabled by default).
 * 
 * INSTRUCTIONS
 * ------------
 * 
 * 1) To make this work, place this php file in the /custom directory.
 * 2) Then, paste this code in \custom\include\MVC\Controller\entry_point_registry.php (create it if it doesn't exist).
 * 
 * $entry_point_registry['disableModuleSurfer'] = array (
 *  'file' => 'custom/disableModuleSurfer.php',
 *  'auth' => false,
 * );
 *
 * Then, point your browser at http://yourcrm/sugarcrm/index.php?entryPoint=disableModuleSurfer
 *
 * Note: If you're a CE user, you probably don't need to create the entryPoint and can just call it directly.
 * 
 * @author Blake Robertson, http://www.blakerobertson.com
 * @license GPLv3
 */

if(!defined('sugarEntry'))define('sugarEntry', true);

require_once('include/entryPoint.php');
require_once('include/utils.php');
require_once('custom/include/ModuleSurfer/ModuleSurferManager.php');

$selectQry = "select id, user_name from users";
$results = $GLOBALS['db']->query($selectQry);

print "<form method='POST'  >";
print "<div>User ID: <select name='user_id'>";
    
	while($row = $GLOBALS['db']->fetchByAssoc($results) ) {
		print "<option value='{$row['id']}'>{$row['user_name']}</option>";
	}

print "</select></div><DIV> ALL USERS: <input type='checkbox' name='all_users'></div><div>Module List:<textarea type='text' name='module_list' size='60' row='8' cols='80'/>Accounts,Contacts,Leads,Quotes,Opportunities,Contracts,Reports,Documents,Projects,ProjectTask,Forecasts,Notes,Tasks,Emails,Cases,Calls,Products,Users,Targets,Markers,Maps,Campaigns,Bugs,KBDocuments,weban_WebVisits</textarea></div>";

print "<input type='submit'/>";
print "</form>";

if ($_POST) {

    session_start();
	
	if($_POST['all_users']) {
		print "ALL_USERS are being updated!<BR>";
		$results = $GLOBALS['db']->query($selectQry);
		while($row = $GLOBALS['db']->fetchByAssoc($results) ) {
			setFalseForUserId($_POST['module_list'], $row['id']);
		}

		
	}
	else {
		setFalseForUserId($_POST['module_list'],$_POST['user_id']);
	}
	
}

function setFalseForUserId( $module_list,$user_id) {	
	print "Updating preferences for USERID: " . $user_id . "<BR>";
    $_SESSION['authenticated_user_id'] = $user_id;
    foreach (preg_split('/\s*,\s*/', $module_list) as $module) {

        ModuleSurferManager::saveSettings($module, '', '1');
    }

}
