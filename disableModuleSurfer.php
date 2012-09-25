<?php
/**
 * This simple script makes it easy to disable Module Surfer on all list views by default.  (The default behavior is to have it enabled by default).
 * 
 * INSTRUCTIONS
 * ------------
 * See https://github.com/blak3r/dispage-module-surfer-disable-by-default 
 * 
 * @author Blake Robertson, http://www.blakerobertson.com
 * @license GPLv3
 */

if(!defined('sugarEntry'))define('sugarEntry', true);

require_once('include/entryPoint.php');
require_once('include/utils.php');
require_once('custom/include/ModuleSurfer/ModuleSurferManager.php');

$selectQry = "select id, user_name from users where status='Active' and is_group='0'";
$results = $GLOBALS['db']->query($selectQry);

print "<h2>Disable Module Surfer For Module List Views Script</h2>";
print "<form method='POST'  >";
print "<div>User ID: <select name='user_id'>";
    
	while($row = $GLOBALS['db']->fetchByAssoc($results) ) {
		print "<option value='{$row['id']}'>{$row['user_name']}</option>";
	}

print "</select></div><DIV> ALL USERS: <input type='checkbox' name='all_users'></div><div>Module List:<textarea type='text' name='module_list' size='60' rows='8' cols='80' wrap='soft'/>Accounts,Contacts,Leads,Quotes,Opportunities,Contracts,Reports,Documents,Projects,ProjectTask,Forecasts,Notes,Tasks,Emails,Cases,Calls,Products,Users,Targets,Markers,Maps,Campaigns,Bugs,KBDocuments,weban_WebVisits</textarea></div>";

print "<input type='submit'/>";
print "</form>";

if ($_POST) {
	$original_session_id = $_SESSION['authenticated_user_id'];

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
	
	$_SESSION['authenticated_user_id'] = $original_session_id;	
}

function setFalseForUserId( $module_list,$user_id) {	
	print "Updating preferences for USERID: " . $user_id . "<BR>";
    $_SESSION['authenticated_user_id'] = $user_id;
    foreach (preg_split('/\s*,\s*/', $module_list) as $module) {

        ModuleSurferManager::saveSettings($module, '', '1');
    }

}
