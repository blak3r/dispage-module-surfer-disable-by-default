## General

  This simple script makes it easy to disable Module Surfer on all list views by default.  (The default behavior is to have it enabled by default).

## Instructions
  
  1) To make this work, place this php file in the /custom directory.
  2) Then, paste this code in \custom\include\MVC\Controller\entry_point_registry.php (create it if it doesn't exist).
 
 ``` 
  $entry_point_registry['disableModuleSurfer'] = array (
  'file' => 'custom/disableModuleSurfer.php',
  'auth' => false,
 );
 ```
   3) Then, point your browser at http://yourcrm/sugarcrm/index.php?entryPoint=disableModuleSurfer and fill out the form.

Note: If you're a CE user, you probably don't need to create the entryPoint and can just call it directly.


