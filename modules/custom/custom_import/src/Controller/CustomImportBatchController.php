<?php

/**
 * @file
 * Contains \Drupal\custom_import\Controller\CustomImportBatchController.
 */
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
namespace Drupal\custom_import\Controller;

class CustomImportBatchController {
  public function content() {
    
    $file_svg = $imgLink = drupal_get_path('module', 'custom_import') . '/portfolios.csv';
    $lines = array();
    
    $handle = fopen($file_svg, "r");
    for ($i = 0; $row = fgetcsv($handle ); ++$i) {
        $lines[] = $row;
    }
    fclose($handle);
    
    $batch = array(
      'title' => t('Import'),
      'operations' => array(
        array(
          '\Drupal\custom_import\Controller\CustomImportBatchController::custom_import_migrate',
          array($lines),
        ),
      ),
      'finished' => '\Drupal\custom_import\Controller\CustomImportBatchController::custom_import_migrate_finished_callback',
    );

    batch_set($batch);
    return batch_process('admin/content');
  }
  
  public function custom_import_migrate($lines, $options = array(), &$context) {
    /*
    // Create file object from remote URL.
    $data = file_get_contents('https://www.drupal.org/files/druplicon.small_.png');
    $file = file_save_data($data, 'public://druplicon.png', FILE_EXISTS_REPLACE);

    // Create node object with attached file.
    $node = Node::create([
    'type'        => 'article',
    'title'       => 'Druplicon test',
    'field_image' => [
      'target_id' => $file->id(),
      'alt' => 'Hello world',
      'title' => 'Goodbye world'
    ],
    ]);
    $node->save();
    */$term_name = 'Term Name';

    foreach($lines as $key=>$line) {
      if($key != 0) {
        $cat = explode("|", $line[3]);
        $vid = 'portfolio_category';
        $term_array = array();
        
        
        $portfolio = \Drupal\node\Entity\Node::create(['type' => 'portfolio']);
        $portfolio->set('title', $line[1]);
        $portfolio->set('body', array('value' => $line[2], 'format' => 'full_html'));
        
        
        foreach($cat as $value) {
          $term = \Drupal::entityTypeManager()
                ->getStorage('taxonomy_term')
                ->loadByProperties(['name' => $value, 'vid' => $vid]);
          $term_array = array();
          if(empty($term)) {
            $term_node = \Drupal\taxonomy\Entity\Term::create(array( 'name' => $value, 'vid' => $vid, )); $term_node->save();
            //$portfolio->field_portfolio_category[]['target_id'] = $term_node->id();
            $term_array[] = array('target_id' => $term_node->id());
          } else {
            //$term_array[] = $term->tid->value;
            //$portfolio->field_portfolio_category[]['target_id'] = $term->tid->value;
            $term_array[] = array('target_id' => $term->tid->value);
          }
        }
        $portfolio->set('field_portfolio_category', $term_array[0]);
        $portfolio->save();
      }
    }
    
  }
  
  static function custom_import_migrate_finished_callback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One post processed.', '@count posts processed.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
    //$_SESSION['disc_migrate_batch_results'] = $results;
  }
  
}