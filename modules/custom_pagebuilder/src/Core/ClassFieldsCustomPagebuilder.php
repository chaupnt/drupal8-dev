<?php 
namespace Drupal\custom_pagebuilder\Core;
/**
 * 
 */
class ClassFieldsCustomPagebuilder 
{
  
  function __construct()
  {
  }
  
  public function render_field_text($field = array(), $value = ''){
		$output = '';
		$class = ( isset( $field['class']) ) ? $field['class'] : '';
		$output .= '<input autocomplete="off" type="text" name="'. $field['id'] .'" value="'.($value).'" class=" form-control '.$class.'" />';
		$output .= (isset($field['desc']) && !empty($field['desc']))?' <span class="description '.$class.'">'.$field['desc'].'</span>':'';	
		return $output;
	}
  
  public function render_field_color($field = array(), $value = '#000000'){
		$output = '';
		$class = ( isset( $field['class']) ) ? $field['class'] : '';
		$output .= '<input name="'. $field['id'] .'" value="'.($value).'" class="form-control field-color no-alpha" />';
		$output .= (isset($field['desc']) && !empty($field['desc']))?' <span class="description '.$class.'">'.$field['desc'].'</span>':'';	
		return $output;
	}
  
  public function render_field_urllink($field = array(), $value = ''){
		$output = '';
		$class = ( isset( $field['class']) ) ? $field['class'] : '';
		$output .= '<input autocomplete="off" type="text" name="'. $field['id'] .'" value="'.($value).'" class="form-control '.$class.' custom-link-button " />';
		$output .= (isset($field['desc']) && !empty($field['desc']))?' <span class="description '.$class.'">'.$field['desc'].'</span>':'';	
		return $output;
	}
  
  public function render_field_icon_font($field = array(), $value = ''){
    if(empty($value)) {
      $value = 'fa fa-address-book';
    }
		$output = '';
		$class = ( isset( $field['class']) ) ? $field['class'] : '';
    ob_start();
    ?>
      <div class="form-group wrapper-custom-icon-fa">
        <div class="btn-group">
          <button class="btn btn-primary iconpicker-component" type="button">
              <i class="<?php print $value ?>"></i></button> 
          <button class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-car" data-toggle="dropdown" type="button"><span class="caret"></span> <span class="sr-only">Toggle Dropdown</span></button>
          <div class="dropdown-menu"></div>
        </div>
      </div>
      <input autocomplete="off" type="hidden" name="<?php print $field['id'] ?>" value="<?php print $value ?>" class="<?php print $class ?>" />
    <?php
    $output = ob_get_clean();
		return $output;
	}
  
	
	public function render_field_select($field = array(), $value = ''){
		$output = '';
		$class = ( isset( $field['class']) ) ? 'class="form-control '.$field['class'].'" ' : '';
		$output .= '<select autocomplete="off" name="'. $field['id'] .'" '.$class.'rows="6" >';
			if( is_array( $field['options'] ) ){
				foreach( $field['options'] as $k => $v ){
					$output .= '<option ' . (($value && $value == $k) ? 'selected="selected"' : '') . ' value="'.$k.'" '.'>'.$v.'</option>';
				}
			}
		$output .= '</select>';
		$output .= (isset($field['desc']) && !empty($field['desc']))?' <span class="description">'.$field['desc'].'</span>':'';
		return $output;
	}
  
  public function render_field_checkboxs($field = array(), $value = ''){
		$output = '';
    $class = ( isset( $field['class']) ) ? 'class="'.$field['class'].'" ' : '';
    $output = '<div class="wrapper-field-checkboxs '. $class .'">';
      if( is_array( $field['options'] ) ){
				foreach( $field['options'] as $k => $v ){
          if( $value == $v ) {
            $checked = 'checked';
          } else {
            $checked = '';
          }
					$output .= '<input type="checkbox" name="'. $field['id'] .'" value="'.$v.'" '. $checked .' />';
				}
			}
		$output .= (isset($field['desc']) && !empty($field['desc']))?' <span class="description">'.$field['desc'].'</span>':'';
    $output .= '</div>';
		return $output;
	}
	
	public function render_field_textarea($field = array(), $value = ''){
		$output = '';
		$class 	= isset( $field['class'] ) ? $field['class'] : '';
		if(isset( $field['shortcodes'] ) && $field['shortcodes']) $class .= 'gerenal_sc';
		$param 	= isset( $field['param'] ) ? $field['param'] : '';
		ob_start();
		?>
		<div class="textarea-wrapper <?php print $class ?>">
			<textarea class="code_html" name="<?php print $field['id'] ?>" class="form-control <?php print $param ?>" rows="8"><?php print($value) ?></textarea>
			<?php if( isset($field['desc']) && !empty($field['desc']) ){ ?>
				<br/><span class="description"><?php print $field['desc'] ?></span> 
			<?php } ?>	
		</div>
		<?php
		$content = ob_get_clean(); 
		return $content;
	}

	public function render_field_textarea_no_html($field = array(), $value = ''){
		$output = '';
		$class 	= isset( $field['class'] ) ? $field['class'] : '';
		if(isset( $field['shortcodes'] ) && $field['shortcodes']) $class .= 'gerenal_sc';
		$param 	= isset( $field['param'] ) ? $field['param'] : '';
		ob_start();
		?>
		<div class="textarea-wrapper <?php print $class ?>">
			<textarea name="<?php print $field['id'] ?>" class="form-control <?php print $param ?>" rows="8"><?php print($value) ?></textarea>
			<?php if( isset($field['desc']) && !empty($field['desc']) ){ ?>
				<br/><span class="description"><?php print $field['desc'] ?></span> 
			<?php } ?>	
		</div>
		<?php
		$content = ob_get_clean(); 
		return $content;
	}
	
	public function render_field_upload($field = array(), $value = ''){
		global $base_url;
		$_id = custom_pagebuilder_makeid(10);
		$default_image = base_path() . CUSTOM_PAGEBUILDER_PATH . '/assets/images/default.png';
		if( $value ){
			$path_image_demo = substr(base_path(), 0 , -1) . $value;
		}else{
			$path_image_demo = $default_image;
		} 
		$class = ( isset($field['class']) ) ? $field['class'] : 'image';
		ob_start();
		?> 
		<div class="cpbuilder-upload-image" id="cpbuilder-upload-<?php print $_id; ?>">
			<form class="upload" id="upload-<?php print $_id; ?>" method="post" action="<?php print (base_path() . 'admin/structure/custom_pagebuilder/upload') ?>" enctype="multipart/form-data">
				<div class="drop">
					<input type="file" name="upl" multiple class="input-file-upload"/>
				</div>
			</form>
			<input readonly="true" type="text" name="<?php print $field['id'] ?>" value="<?php print $value ?>" class="<?php print $class ?> file-input" />
			<img class="custompagebuilder-image-demo" src="<?php print $path_image_demo ?>" />
			<a class="custompagebuilder-field-upload-remove btn-delete" data-src="<?php print $default_image ?>" style="<?php print (($value) ? 'display:inline-block;' : 'display:none;') ?>">Remove</a>
			<span class="loading">Loading....</span>
			<a class="btn-delete btn-get-images-upload">Choose image</a>
			<div class="clearfix"></div>
			<?php if(isset($field['desc']) && ! empty($field['desc'])){?>
				<span class="description"><?php print $field['desc'] ?></span>
			<?php } ?>
			<div class="clearfix"></div>
      <a class="btn-delete btn-get-images-upload">Browse images</a>
      <div class="clearfix"></div>
			<div class="custompagebuilder-box-images">
				<div class="custompagebuilder-box-images-inner">
					<div class="header">
						Images Upload
						<a class="close">close</a>
					</div>
					<div class="list-images">

					</div>
				</div>
			</div>
		</div>	
		<?php
		$content = ob_get_clean(); 
		return $content;
	}
  
  public function render_field_multiple_upload($field = array(), $values = ''){
		global $base_url;
		$_id = custom_pagebuilder_makeid(10);
		$default_image = base_path() . CUSTOM_PAGEBUILDER_PATH . '/assets/images/default.png';
		$class = ( isset($field['class']) ) ? $field['class'] : 'image';
		ob_start();
		?> 
		<div class="cpbuilder-upload-image" data-id_gen="<?php print $_id; ?>" >
			
      <?php 
        if(empty($values)) $values = array(array('title' => '', 'sub_title' => '' ,'url_image' => '')); 
        $i = 1;
      ?>
      <?php foreach($values as $value): ?>
        <?php 
        
        if( $value['url_image'] ){
          $path_image_demo = substr(base_path(), 0 , -1) . $value['url_image'];
        }else{
          $path_image_demo = $default_image;
        } 
        
        ?>
        <div class="wrapper-fields-images-upload">
            <div class="field-group">
                <div class="wrapper-content-fields" id="cpbuilder-upload-carousel-<?php print $i; ?>-<?php print $_id; ?>">
                  
                    <div class="form-group">
                      <label for="title_slider">Title</label>
                      <input class="title-carousel" type="text" class="form-control" value="<?php print $value['title'] ?>" name="<?php print $field['id'].'[title]' ?>">
                    </div>
                    
                    <div class="form-group">
                      <label for="title_slider">Subtitle</label>
                      <input class="subtitle-carousel" type="text" value="<?php print $value['sub_title'] ?>" class="form-control" name="<?php print $field['id'].'[sub_title]' ?>">
                    </div>
                    
                  <form class="upload" data-count="<?php print $i ?>" id="upload-carousel-<?php print $i; ?>-<?php print $_id; ?>" method="post" action="<?php print (base_path() . 'admin/structure/custom_pagebuilder/upload') ?>" enctype="multipart/form-data">
                    <div class="drop">
                      <input type="file" name="upl" multiple class="input-file-upload"/>
                    </div>
                  </form>
                    <p>
                      <input readonly="true" type="text" name="<?php print $field['id'].'[url_image]' ?>" value="<?php print $value['url_image'] ?>" class="<?php print $class ?> file-input" />
                    </p>
                  <img class="custompagebuilder-image-demo" src="<?php print $path_image_demo ?>" />
                  <a class="custompagebuilder-field-upload-remove btn-delete" data-src="<?php print $default_image ?>" style="<?php print (($value) ? 'display:inline-block;' : 'display:none;') ?>">Remove</a>
                  <span class="loading">Loading....</span>
                  <a class="btn-delete btn-get-images-upload">Choose image</a>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
      <?php $i++; ?>  
      <?php endforeach; ?>
      <div class="multiple-image-uploads-default custompagebuilder-hidden">
          <div class="field-group">
              <div class="wrapper-content-fields">
                  
                  <div class="form-group">
                      <label for="title_slider">Title</label>
                      <input class="title-carousel" type="text" class="form-control" value="" name="">
                    </div>
                    
                    <div class="form-group">
                      <label for="title_slider">Subtitle</label>
                      <input class="subtitle-carousel" type="text" value="" class="form-control" name="">
                    </div>
                  
                <form class="upload" method="post" action="<?php print (base_path() . 'admin/structure/custom_pagebuilder/upload') ?>" enctype="multipart/form-data">
                  <div class="drop">
                      <input type="file" name="upl" multiple class="input-file-upload"/>
                  </div>
                </form>
                <input readonly="true" type="text" value="" class="<?php print $class ?> file-input" />
                <img class="custompagebuilder-image-demo" src="<?php print $path_image_demo ?>" />
                <a class="custompagebuilder-field-upload-remove btn-delete" data-src="<?php print $default_image ?>" style="<?php print (($value) ? 'display:inline-block;' : 'display:none;') ?>">Remove</a>
                <span class="loading">Loading....</span>
                <a class="btn-delete btn-get-images-upload">Choose image</a>
                <div class="clearfix"></div>
              </div>
          </div>
      </div>  
      <div class="text-right"><a class="btn-add cpb-add-images-field" rel-name="<?php print $field['id']; ?>">Add Image</a></div>
      <div class="clearfix"></div>
      <a class="btn-delete btn-get-images-upload">Browse images</a>
      <div class="clearfix"></div>
			<div class="custompagebuilder-box-images">
				<div class="custompagebuilder-box-images-inner">
					<div class="header">
						Images Upload
						<a class="close">close</a>
					</div>
					<div class="list-images">

					</div>
				</div>
			</div>  
		</div>	
		<?php
		$content = ob_get_clean(); 
		return $content;
	}
  
  
	
	public function render_field_info($field = array(), $value = '') {
		$output = '';
		if( key_exists('desc', $field) ){
			$output .= '<p class="info-des">'.$field['desc'].'</p>';
		}
		return $output;
	}
	
	public function render_field_tabs($field = array(), $value = '') {
		$class = ( isset($field['class']) ) ? $field['class'] : '';
		$name = $field['id'];
		$count = ($value) ? count($value) : 0;
		ob_start();
		?>
		<a class="btn-add cpb-add-tab" rel-name="<?php print $name ?>">Add tab</a>
		<input type="hidden" name="<?php print $name ?>[count][]" class="cpb-tabs-count" value="<?php print $count ?>" />
		<br style="clear:both;" />
    <div class="clearfix" style="height:20px"></div>
		<ul class="tabs-ul">
			<?php	
				if(isset($value) && is_array($value)){
					foreach($value as $k => $val){
			?>
					<li>
						<label>Title</label>
						<input type="text" class="form-control" name="<?php print $name ?>[title][]" value="<?php print htmlspecialchars(stripslashes($val['title'])) ?>" />
            
            <label>Content</label>
						<textarea class="form-control" name="<?php print $name ?>[content][]" value="" ><?php print $val['content'] ?></textarea>
						<a href="" class="bb-btn-close cpb-remove-tab"><em>delete</em></a>
					</li>
			 <?php
				}
			}
			?>
			<li class="tabs-default custompagebuilder-hidden">
				<label>Title</label>
				<input class="title" type="text" name="" value="" />
				<label>Icon tab</label>
				<input class="icon " type="text" name="" value="" />
				<div class="description">This support display icon from FontAwsome, Please click here to <a href="http://fortawesome.github.io/Font-Awesome/icons/">see the list</a></div>
				<label>Content</label>
				<textarea name="" value="" class="form-control"></textarea>
				<a href="" class="btn-delete bb-btn-close cpb-remove-tab">delete</a>
			</li>
		</ul>

		<?php if(isset($field['desc']) && ! empty($field['desc'])){?>
			<span class="description"><?php print $field['desc'] ?></span>
		<?php } ?>
		
		<?php
		$content = ob_get_clean(); 
		return $content;
	}
  
}
?>