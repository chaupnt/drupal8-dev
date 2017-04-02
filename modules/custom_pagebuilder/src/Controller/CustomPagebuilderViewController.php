<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Controller;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Controller\EntityViewController;
use Drupal\custom_pagebuilder\Core\ClassCustomPagebuilder;
/**
 * Description of CustomPagebuilderViewController
 *
 * @author Chau Phan
 */
class CustomPagebuilderViewController extends EntityViewController{
  //put your code here
  
  public function pageview($custom_pagebuilder) {
    $params = $this->get_json_content_page($custom_pagebuilder);
    //kint($params);
    $contents = array();
    foreach( $params as $row ){
      $row_attr = $this->get_attr_row_content($row);
      $contents[] = array(
        '#type' => 'page',
        '#cache' => array('max-age' => 0),
        '#theme' => 'cpb_frontend', 
        '#row' => $row,
        '#row_class' => $row_attr['row_class'],
        '#row_style' => $row_attr['row_style'],
      );
    }
    //$_entity = \Drupal::entityTypeManager()->getStorage('custom_pagebuilder')->load($custom_pagebuilder);
    //return $this->view($_entity);
    return $contents;
  }
  
  public function view(EntityInterface $_entity, $view_mode = 'full') {
    $build = parent::view($_entity, $view_mode);
    return $build;
  }
  
  public function get_json_content_page($pid) {
    $query = \Drupal::database()->select('custom_pagebuilder', 'cp');
    $query->fields('cp');
    $query->leftjoin('custom_pagebuilder_content', 'cpc', 'cp.id = cpc.id');
    $query->fields('cpc');
    $query->condition('cp.id', $pid);
    $result = $query->execute()->fetchObject();
    $params = base64_decode($result->params);
    $params = json_decode($params, true);
    return $params;
  }
  
  public function get_attr_row_content($row) {
    if(isset($row['attr'])){
				$row_attr = $row['attr'];
				$array_class 		= array();
				$array_class[]	= $row_attr['class'];
				$array_class[]   = 'cbp-row';
				
				$array_style = array();
				
				//Padding for row
				if(isset($row_attr['padding_top']) && $row_attr['padding_top']){
					$array_style[] 	= 'padding-top:'. intval( $row_attr['padding_top'] ) .'px';
				}
				if(isset($row_attr['padding_bottom']) && $row_attr['padding_bottom']){
					$array_style[] 	= 'padding-bottom:'. intval( $row_attr['padding_bottom'] ) .'px';
				}	

				//Margin for row
				if(isset($row_attr['margin_top']) && $row_attr['margin_top']){
					$array_style[] 	= 'margin-top:'. intval( $row_attr['margin_top'] ) .'px';
				}
				if(isset($row_attr['margin_bottom']) && $row_attr['margin_bottom']){
					$array_style[] 	= 'margin-bottom:'. intval( $row_attr['margin_bottom'] ) .'px';
				}	

				// Background for row
				if(isset($row_attr['bg_color']) && $row_attr['bg_color']){
					$array_style[] 	= 'background-color:'. $row_attr['bg_color'];
				}
				 $attr_parallax = "";
				if( $row_attr['bg_image'] ){
					$array_style[] 	= 'background-image:url(\''. substr($base_path, 0, -1) . $row_attr['bg_image'] .'\')';
					$array_style[] 	= 'background-repeat:' . $row_attr['bg_repeat'];
					$array_style[]    = 'background-attachment:' . $row_attr['bg_attachment']; 
					if(isset($row_attr['bg_attachment']) && $row_attr['bg_attachment']=='fixed'){
						$array_style[] 	= 'background-position: 50% 0';
						$array_class[] = 'gva-parallax-background ';
						
					}else{
						$array_style[] 	= 'background-position:' . $row_attr['bg_position'];
					}
				}
				$row_class = implode($array_class, ' ');
				$row_style 	= implode('; ', $array_style );
        return array('row_class' => $row_class,'row_style' => $row_style);
			}	
      return array();
  }
  
}
