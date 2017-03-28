<?php

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

$autoloader = require_once 'autoload.php';

$kernel = new DrupalKernel('prod', $autoloader);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);

// ID of the user.
//$uid = 1; //Do not use 1 because it is the super admin
//$user = Drupal\user\Entity\User::load($uid);
//user_login_finalize($user);

$query = \Drupal::database()->select('custom_pagebuilder', 'cp');
      $query->fields('cp');
      $query->leftjoin('custom_pagebuilder_content', 'cpc', 'cp.id = cpc.id');
      $query->fields('cpc');
      $query->condition('cp.id', 1);
      $result = $query->execute()->fetchObject();
      if($result){
        //$this->id = $result->id;
        //$this->title =  $result->title;
        //$this->params = $result->params;  
      }
      
print_r(json_decode(base64_decode($result->params)));

$result = db_select('{gavias_blockbuilder}', 'd')
          ->fields('d')
          ->condition('id', 1, '=')
          ->execute()
          ->fetchObject();

print_r(json_decode(base64_decode($result->params)));

?>
