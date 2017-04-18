<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\custom_pagebuilder\Controller;
/**
 * Description of CustomPagebuilderViewController
 *
 * @author Chau Phan
 */
class CustomPagebuilderViewController {
  //put your code here
  
  private $pid;
  private $params = '';
  
  
  function __construct($pid = null) {
    //kint($pid);
    
    if(empty($pid)) {
      $pid = \Drupal::routeMatch()->getParameter('custom_pagebuilder');
    }
    
    if($pid) {
      $this->pid = $pid;
      $this->params = $this->get_json_content_page();
    }
  }
  
  public function get_pageid() {
    return $this->pid;
  }


  public function get_params() {
    return $this->params;
  }
  
  public function pageview() {
    //return array('#markup' => 'dasdasda');
    $params = $this->get_params();
    $pages = array();
    
    if(!empty($params)) {
       foreach( $params as $row ){
          $row_attr = $this->get_attr_row_content($row);
          if(isset($row['columns']) && is_array($row['columns'])){
            $cols = array();
            
            foreach( $row['columns'] as $column ) {
              $fields = array();
              $cols_attr = $this->get_attr_column_content($column);
              $column_id = '';
              if(isset($col_attr['column_id']) && $col_attr['column_id']){
                $column_id = $col_attr['column_id'];
              }

              if (is_array($column['items'])) {
                foreach ($column['items'] as $key_i=>$item) {
                  
                  $shortcode = '\\Drupal\custom_pagebuilder\Shortcodes\\' . $item['type'];
                  if (class_exists($shortcode)) {
                    $sc = new $shortcode;
                    if (method_exists($sc, 'render_content')) {
                      $fields[] = array(
                        '#type' => 'html',
                        '#theme' => 'cpb_frontend_field',
                        '#field_item' => $sc->render_content($item),
                        '#field_type' => $item['type']
                      );
                    }
                  }
                }
              }
              $cols[] = array(
                '#type' => 'html',
                '#attached' => array( 
                  'library' => array( 
                    'custom_pagebuilder/custom_pagebuilder.font-awesome',
                    'custom_pagebuilder/custom_pagebuilder.assets.frontend'
                  )
                ),
                '#cache' => array('max-age' => 0),
                '#theme' => 'cpb_frontend_col', 
                '#column_id' => $cols_attr['col_id'],
                '#col_class' => $cols_attr['col_class'],
                '#col_style' => $cols_attr['col_style'],
                '#col_animate' => ($cols_attr['col_animate']) ? $cols_attr['col_animate']:'',
                '#field_items' => $fields,
              );
            }  
            $col_style = '';
            $pages[] = array(
              '#type' => 'html',
              '#cache' => array('max-age' => 0),
              '#theme' => 'cpb_frontend', 
              '#row' => $row,
              '#row_class' => $row_attr['row_class'],
              '#row_style' => $row_attr['row_style'],
              '#row_animate' => $row_attr['row_animate'],
              '#columns' => $cols
            );
          }
        }
    }
    
    return $pages;
  }
  
  public function view(EntityInterface $_entity, $view_mode = 'full') {
    $build = parent::view($_entity, $view_mode);
    return $build;
  }
  
  public function get_json_content_page() {
    $params = '';
    $pid = $this->get_pageid();
    $query = \Drupal::database()->select('custom_pagebuilder', 'cp');
    $query->fields('cp');
    $query->leftjoin('custom_pagebuilder_content', 'cpc', 'cp.id = cpc.id');
    $query->fields('cpc');
    $query->condition('cp.id', $pid);
    $result = $query->execute()->fetchObject();
    if($result) {
      $params = base64_decode($result->params);
      $params = json_decode($params, true);
    }
    
    return $params;
  }
  
  public function get_attr_row_content($row) {
    
    $animate_opt = array();
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
					$array_style[] 	= 'background-image:url('. $row_attr['bg_image'] .')';
					$array_style[] 	= 'background-repeat:' . $row_attr['bg_repeat'];
					$array_style[]    = 'background-attachment:' . $row_attr['bg_attachment']; 
          $bg_size = ($row_attr['bg_size']) ? $row_attr['bg_size'] : 'auto';
          $array_style[] = 'background-size:' . $bg_size;
					if(isset($row_attr['bg_attachment']) && $row_attr['bg_attachment']=='fixed'){
						$array_style[] 	= 'background-position: 50% 0';
						$array_class[] = 'custom-pagebuilder-parallax-background ';
						
					}else{
						$array_style[] 	= 'background-position:' . $row_attr['bg_position'];
					}
				}
        if( isset($row_attr['animate']) && $row_attr['animate'] ){
          $array_class[] = ' wow '.$row_attr['animate'];
          if($row_attr['duration']) {
            $animate_opt['duration'] = 'data-wow-duration="'. $row_attr['duration'] .'s"';
          }
          if($row_attr['delay']) {
            $animate_opt['delay'] = 'data-wow-delay="'. $row_attr['delay'] .'s"';
          }
        }
				$row_class = implode($array_class, ' ');
				$row_style 	= implode('; ', $array_style );
        return array('row_class' => $row_class,'row_style' => $row_style, 'row_animate' => $animate_opt);
			}	
      return array();
  }
  
  public function get_attr_column_content($column) {
    $col_style = '';
    $animate_opt = array();
    $classes = array(
      '1' => 'col-lg-1 col-md-1 col-sm-2 col-xs-12',
      '2' => 'col-lg-2 col-md-2 col-sm-4 col-xs-12',
      '3' => 'col-lg-3 col-md-3 col-sm-6 col-xs-12',
      '4' => 'col-lg-4 col-md-4 col-sm-12 col-xs-12',
      '5' => 'col-lg-5 col-md-5 col-sm-12 col-xs-12',
      '6' => 'col-lg-6 col-md-6 col-sm-12 col-xs-12',
      '7' => 'col-lg-7 col-md-7 col-sm-12 col-xs-12',
      '8' => 'col-lg-8 col-md-8 col-sm-12 col-xs-12',
      '9' => 'col-lg-9 col-md-9 col-sm-12 col-xs-12',
      '10' => 'col-lg-10 col-md-10 col-sm-12 col-xs-12',
      '11' => 'col-lg-11 col-md-11 col-sm-12 col-xs-12',
      '12' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12',
    );
    
    if(!empty($column['attr'])) {
      $col_attr = $column['attr'];
    }else{
      $col_attr = null;
    }
    
    $class = '';
    if($col_attr && isset($classes[$col_attr['size']]) && $classes[$col_attr['size']]){
      $class = $classes[$col_attr['size']];
    }
    
    if(isset($col_attr['class']) && $col_attr['class']){
      $class .= ' ' . $col_attr['class'];
    }
    
    if(isset($col_attr['hidden_lg']) && $col_attr['hidden_lg'] == 'hidden'){
      $class .= ' hidden-lg';
    }
    
    if(isset($col_attr['hidden_md']) &&!$col_attr['hidden_md'] == 'hidden'){
      $class .= ' hidden-md';
    }
    
    if(isset($col_attr['hidden_sm']) &&!$col_attr['hidden_sm'] == 'hidden'){
      $class .= ' hidden-sm';
    }
    
    if(isset($col_attr['hidden_xs']) &&!$col_attr['hidden_xs'] == 'hidden'){
      $class .= ' hidden-xs';
    }

    $column_id = '';
    if(isset($col_attr['column_id']) && $col_attr['column_id']){
      $column_id = $col_attr['column_id'];
    }

    $col_style_array = array();

    // Background for row
    if(isset($col_attr['bg_color']) && $col_attr['bg_color']){
      $col_style_array[] = 'background-color:'. $col_attr['bg_color'];
    }
    if( isset($col_attr['bg_image']) && $col_attr['bg_image'] ){
      $col_style_array[] = 'background-image:url('. $base_url . '/' . $col_attr['bg_image'] .')';
      $col_style_array[] = 'background-repeat:' . $col_attr['bg_repeat'];
      $col_style_array[] = 'background-attachment:' . $col_attr['bg_attachment'];
      $bg_size = ($col_attr['bg_size']) ? $col_attr['bg_size'] : 'auto';
      $col_style_array[] = 'background-size:' . $bg_size;
      if(isset($col_attr['bg_attachment']) && $col_attr['bg_attachment'] == 'fixed'){
        $col_style_array[] = 'background-position: 50% 0';
        $col_style_array[] = 'custom-pagebuilder-parallax';
      }else{
        $col_style_array[] = 'background-position:' . $col_attr['bg_position'];
      }
    }
    
    if( isset($col_attr['animate']) && $col_attr['animate'] ){
      $class .= ' wow '.$col_attr['animate'];
      if($col_attr['duration']) {
        $animate_opt['duration'] = 'data-wow-duration="'. $col_attr['duration'] .'s"';
      }
      if($col_attr['delay']) {
        $animate_opt['delay'] = 'data-wow-delay="'. $col_attr['delay'] .'s"';
      }
    }
    
    $col_style = implode('; ', $col_style_array );
    $class_col = array('col_id' => $column_id,'col_class' => $class, 'col_style' => $col_style, 'col_animate' => $animate_opt);
    return $class_col;
    
  }
}
