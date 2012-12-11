## General

  This simple script makes it easy to disable Module Surfer on all list views by default.  (The default behavior is to have it enabled by default).
  
  Author: Blake Robertson, <http://www.blakerobertson.com>

## Instructions
  
1. To make this work, place this php file in the /custom directory.
2. Then, paste this code in \custom\include\MVC\Controller\entry_point_registry.php (create it if it doesn't exist).
 
 ``` 
  $entry_point_registry['disableModuleSurfer'] = array (
  'file' => 'custom/disableModuleSurfer.php',
  'auth' => true,
 );
 ```
3. Then, point your browser at http://yourcrm/sugarcrm/index.php?entryPoint=disableModuleSurfer and fill out the form.

Note: If you're a CE user, you probably don't need to create the entryPoint and can just call it directly.

## Potential Improvements

1. Retrieve the list of all modules programatically from the database.  Probably an easy way to do this that I don't know about.
2. Create a logic hook to run this script automatically when a user is added to SugarCRM.

If you tackle them, please share.


## Troubleshooting

### Error: ERROR: Query Limit of 1000 reached for Home Module

When updating ALL Users, after about 20 users you might encounter the error above.  The fix to this is to temporarily increase the default_limit in config.php.
Look for the block below and edit default_limit.  Or Alternatively... just do each user one at a time.

```
  'resource_management' => 
  array (
    'special_query_limit' => 50000,
    'special_query_modules' => 
    array (
      0 => 'Reports',
      1 => 'Export',
      2 => 'Import',
      3 => 'Administration',
      4 => 'Sync',
    ),
    'default_limit' => 2500,  // This is the line to bump up... increase by 1000 for every 20 users.
  ),
```

![gitimg](https://gitimg.com/blak3r/dispage-module-surfer/README.md/track)
