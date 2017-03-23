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
    $cpb = new ClassCustomPagebuilder($custom_pagebuilder);
    $cpb->custom_pagebuilder_load_shortcodes(true);
    
    $page = array(
      '#attached' => array( 
        'library' => array( 'custom_pagebuilder/custom_pagebuilder.assets.admin' ) ,
        'drupalSettings' => array('custom_pagebuilder'=> array('saveConfigURL' => $abs_url_config))
      ),
      '#type' => 'page',
      '#cache' => array('max-age' => 0),
      '#theme' => 'custom_pagebuilder_admin_builder', 
      '#pid' => $cpb->get_ID(),
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

    $result = array(
      'pid' => $pid,
      'data' => $data
    );
    
    \Drupal::database()->merge('custom_pagebuilder_content')
    ->key(array('id' => $pid))
    ->insertFields(array(
  		'id' => $pid,  
  		'params' => $params,  
  	))
    ->updateFields(array(
  		'params' => $params,
	   ))->execute();
    
    print json_encode($result);
    exit(0);
  }
  
  public function custom_pagebuilder_save_element($data) {
    $gbb_els = array();
    //$data['gbb-items'] = $data['gbb-items'];
    
    // row
    if( isset($data['gbb-row-id']) && is_array($data['gbb-row-id'])){
      foreach( $data['gbb-row-id'] as $rowID_k => $rowID ){
        $row = array();
        if( isset($data['gbb-rows']) && is_array($data['gbb-rows'])){
          foreach ( $data['gbb-rows'] as $row_attr_k => $row_attr ){
            $row['attr'][$row_attr_k] = $row_attr[$rowID_k];
          }
        }
        $row['columns'] = '';
        $gbb_els[] = $row;
      }
    
      $array_rows_id = array_flip( $data['gbb-row-id'] );

    } 
  //print_r($gbb_els);die();
    $col_row_id = array();
   // print_r($data['gbb-column-id']);die();
    if( isset($data['gbb-column-id']) && is_array($data['gbb-column-id'])){
      foreach( $data['gbb-column-id'] as $column_id_key => $column_id ){
        if($column_id){
          $column = array();
          if( isset($data['gbb-columns']) && is_array($data['gbb-columns'])){
            foreach ( $data['gbb-columns'] as $col_attr_k => $col_attr ){
              $column['attr'][$col_attr_k] = $col_attr[$column_id_key];
            }
          }
          $column['items'] = '';

          $parent_row_id = $data['column-parent'][$column_id_key];
          $new_parent_row_id = $array_rows_id[$parent_row_id];
          if(isset($gbb_els[$new_parent_row_id])){
            $gbb_els[$new_parent_row_id]['columns'][$column_id] = $column;
          }
          $col_row_id[$column_id] = $new_parent_row_id;
        }
      }  
    } 

    // items 
    if( key_exists('element-type', $data) && is_array($data['element-type'])){
      $count = array();
      $count_tabs = array();
      
      foreach( $data['element-type'] as $type_k => $type ){ 
        $item = array();
        $item['type'] = $type;
        $item['size'] = 12;
        if(isset($data['element-size'][$type_k]) && $data['element-size'][$type_k]){
          $item['size'] = $data['element-size'][$type_k];
        }

        if( ! key_exists($type, $count) ) $count[$type] = 0;
        if( ! key_exists($type, $count_tabs) ) $count_tabs[$type] = 0;

        if( key_exists($type, $data['gbb-items']) ){ 
          foreach(  $data['gbb-items'][$type] as $attr_k => $attr ){

            if( $attr_k == 'tabs'){
              // field tabs fields
              $item['fields']['count'] = $attr['count'][$count[$type]];
              if( $item['fields']['count'] ){
                for ($i = 0; $i < $item['fields']['count']; $i++) {
                  $tab = array();
                  $tab['icon'] = stripslashes($attr['icon'][$count_tabs[$type]]);
                  $tab['title'] = stripslashes($attr['title'][$count_tabs[$type]]);
                  $tab['content'] = stripslashes($attr['content'][$count_tabs[$type]]);
                  $item['fields']['tabs'][] = $tab;
                  $count_tabs[$type]++;
                }
              }
            } else {
              $item['fields'][$attr_k] = stripslashes($attr[$count[$type]]);            
            }
          }
        }
        $count[$type] ++;
        $column_id = $data['element-parent'][$type_k];
        $parent_row_id = $data['element-row-parent'][$type_k];

        $new_parent_row_id = $array_rows_id[$parent_row_id];
        $new_column_id = $column_id;
        $gbb_els[$new_parent_row_id]['columns'][$new_column_id]['items'][] = $item;
      }
    }

    // save
    if( $gbb_els ){
      $new = base64_encode(json_encode($gbb_els));    
    }
    return $new;
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