<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$databases['default']['default'] = array (
  'database' => 'd8dev',
  'username' => 'root',
  'password' => '',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);
$settings['install_profile'] = 'standard';
$config_directories['sync'] = 'sites/default/files/config_4Fln7YliMws1V2TZU2S3jmtwkzu0bb2wtWS0FqbTnz5iic_q_Lh5nE99iM02ls5jrC19evDWjQ/sync';
if (file_exists(__DIR__ . '/settings.local.php')) {
  include __DIR__ . '/settings.local.php';
}
$settings['hash_salt'] = '3hmTeXA0RSiC-bIwsety2VyMhZ6dVIeNv9JoMu66bGbol9ah1YTHoU97easZB3T9KeRIVRjHJA';