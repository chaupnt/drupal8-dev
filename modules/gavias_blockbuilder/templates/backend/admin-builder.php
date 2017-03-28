<?php //print_r($gbb_els_ops); die(); ?>
<div id="gbb-builder">
   <div class="gbb-block-title">
   </div>

   <input type="hidden" id="gbb-row-id" value="<?php echo $gbb_rows_count; ?>" />
   <input type="hidden" id="gbb-column-id" value="0" />

   <div id="gbb-content">
      <div id="gbb-admin-wrap" class="clearfix">
         <?php
            for( $i = 0; $i < $gbb_rows_count; $i++ ) {
               gavias_admin_row( $gbb_els_ops, $gbb_rows_opts, $gbb_columns_opts, $gbb_els[$i], $i+1 );
            }
         ?>
      </div>
      
      <div id="gbb-rows" class="clearfix">
         <?php gavias_admin_row( $gbb_els_ops, $gbb_rows_opts, $gbb_columns_opts ); ?>
      </div>
      
      <div id="gbb-columns" class="clearfix">
        <?php gavias_admin_column( $gbb_els_ops, $gbb_columns_opts ); ?>
      </div>

      <div id="gbb-items" class="clearfix">
         <?php
           foreach( $gbb_els_ops as $item ){
               gavias_admin_element( $item );
           }
         ?>        
      </div>

      <div class="gbb-row-add">
         <a class="bb-btn-row-add" title="Add row" ><i class="fa fa-plus-square-o"></i></a>    
      </div>
  </div>
  <div>
    <div class="gavias-overlay"></div>
    <div id="gbb-form-setting">
      <div class="action">
        <a class="bb-btn-close gbb-form-setting-cancel">Cancel</a> 
        <a class="gbb-form-setting-save">Save changes</a> 
      </div>  
    </div>
  </div>  
</div>