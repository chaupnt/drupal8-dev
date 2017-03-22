<?php 
namespace Drupal\custom_pagebuilder\Controller;
use  Drupal\Core\Cache\Cache;
use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\custom_pagebuilder\Core\ClassCustomPagebuilder;

class CustomPagebuilderAdminController extends ControllerBase {
  
  public function custom_pagebuilder_config_page($custom_pagebuilder){
    
    $page;
    $abs_url_config = \Drupal::url('custom_pagebuilder.admin.save', array(), array('absolute' => FALSE)); 
    
    $cpb = new ClassCustomPagebuilder(1);
    $cpb->custom_pagebuilder_load_shortcodes(true);
    
    $page = array(
      '#attached' => array( 
        'library' => array( 'custom_pagebuilder/custom_pagebuilder.assets.admin' ) ,
        'drupalSettings' => array('drupalSettings' => array('custom_pagebuilder'=> array('saveConfigURL' => $abs_url_config)))
      ),
      '#type' => 'page',
      '#cache' => array('max-age' => 0),
      '#theme' => 'custom_pagebuilder_admin_builder', 
      '#cpb_title' => $cpb->get_title(),
      '#cbp_rows_count' => $cpb->get_rows_count(),
      '#cpb_els_ops' => $cpb->custom_pagebuilder_shortcodes_forms(), 
      '#cpb_rows_opts' => $cpb->row_opts(),
      '#cpb_columns_opts' => $cpb->column_opts(),
      '#cpb_gbb_els' => $cpb->get_json_decode(),
    );
    return $page;
  }
  
  
  public function custom_pagebuilder_save(){
    header('Content-type: application/json');
    $data = $_REQUEST['data'];
    $pid = $_REQUEST['pid'];
    $params = '';
    if($data){
      $data = base64_decode($data);
      $data = json_decode($data, true);
      $params = $this->custom_pagebuilder_save_element($data);
      //print_r($params);die();
    } 
    if($params==null) $params = '';

    db_update("custom_pagebuilder")
          ->fields(array(
              'params' => $params,
          ))
          ->condition('id', $pid)
          ->execute();
    
    \Drupal::service('plugin.manager.block')->clearCachedDefinitions();     
    foreach (Cache::getBins() as $service_id => $cache_backend) {
      if($service_id=='render'){
        $cache_backend->deleteAll();
      }
    }

    $result = array(
      'data' => 'update saved'
    );
    print json_encode($result);
    exit(0);
  }

  public function custom_pagebuilder_export($bid){
    $pbd_single = custom_pagebuilder_load($bid);
    $data = $pbd_single->params;
    $title = date('Y_m_d_h_i_s') . '_bb_export'; 
    header("Content-Type: text/txt");
    header("Content-Disposition: attachment; filename={$title}.txt");
    print $data;
    exit;
  }

  public function gavias_upload_file(){
    // A list of permitted file extensions
    global $base_url;
    $allowed = array('png', 'jpg', 'gif','zip');
    $_id = custom_pagebuilder_makeid(6);
    if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

      $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

      if(!in_array(strtolower($extension), $allowed)){
        echo '{"status":"error extension"}';
        exit;
      }  
      $path_folder = \Drupal::service('file_system')->realpath(file_default_scheme(). "://gbb-uploads");

      $ext = end(explode('.', $_FILES['upl']['name']));
      $image_name =  basename($_FILES['upl']['name'], ".{$ext}");

      //$file_path = $path_folder . '/' . $_id . '-' . $_FILES['upl']['name'];
      $file_path = $path_folder . '/' . $image_name . "-{$_id}" . ".{$ext}";

      $file_url = str_replace($base_url, '',file_create_url(file_default_scheme(). "://gbb-uploads"). '/' .  $image_name . "-{$_id}" . ".{$ext}"); 
      if (!is_dir($path_folder)) {
        @mkdir($path_folder); 
      }
      if(move_uploaded_file($_FILES['upl']['tmp_name'], $file_path)){
        $result = array(
          'file_url' => $file_url,
          'file_url_full' => $base_url . $file_url
        );
        print json_encode($result);
        exit;
        }
    }

    echo '{"status":"error"}';
    exit;
  }

  public function get_images_upload(){
    header('Content-type: application/json');
    global $base_url; 

    $file_path = \Drupal::service('file_system')->realpath(file_default_scheme(). "://gbb-uploads");

    $file_url = file_create_url(file_default_scheme(). "://gbb-uploads"). '/';
    $list_file = glob($file_path . '/*.{jpg,png,gif}', GLOB_BRACE);
    usort( $list_file, function( $a, $b ) { return filemtime($b) - filemtime($a); } );
    $files = array();
    $data = '';
    foreach ($list_file as $key => $file) {
      if(basename($file)){
        $file_url = str_replace($base_url, '', file_create_url(file_default_scheme(). "://gbb-uploads"). '/' .  basename($file)); 
        $files[$key]['file_url'] = $file_url;
        $files[$key]['file_url_full'] = $base_url . $file_url;
      }  
    }
    $result = array(
      'data' => $files
    );
    print json_encode($result);
    exit(0);
  }
}
?>