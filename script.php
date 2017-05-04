<?php

function custom_pagebuilder_save_element($data) {
    $cpb_els = array();
    //$data['cpb-items'] = $data['cpb-items'];
    if( isset($data['cpb-row-id']) && is_array($data['cpb-row-id'])){
      foreach( $data['cpb-row-id'] as $rowID_k => $rowID ){
        $row = array();
        if( isset($data['cpb-rows']) && is_array($data['cpb-rows'])){
          foreach ( $data['cpb-rows'] as $row_attr_k => $row_attr ){
            $row['attr'][$row_attr_k] = $row_attr[$rowID_k];
          }
        }
        $row['columns'] = array();
        $cpb_els[] = $row;
      }
    
      $array_rows_id = array_flip( $data['cpb-row-id'] );
    } 
    $col_row_id = array();
   // print_r($data['cpb-column-id']);die();
    if( isset($data['cpb-column-id']) && is_array($data['cpb-column-id'])){
      foreach( $data['cpb-column-id'] as $column_id_key => $column_id ){
        if($column_id){
          $column = array();
          if( isset($data['cpb-columns']) && is_array($data['cpb-columns'])){
            foreach ( $data['cpb-columns'] as $col_attr_k => $col_attr ){
              $column['attr'][$col_attr_k] = $col_attr[$column_id_key];
            }
          }
          $column['items'] = '';
          $parent_row_id = $data['column-parent'][$column_id_key];
          //print_r($cpb_els);
          $new_parent_row_id = $array_rows_id[$parent_row_id];
          if(isset($cpb_els[$new_parent_row_id])){
            $cpb_els[$new_parent_row_id]['columns'][$column_id] = $column;
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

        if( key_exists($type, $data['cpb-items']) ){ 
          foreach(  $data['cpb-items'][$type] as $attr_k => $attr ){
            print_r("<pre>");
            print_r($attr);
            print_r("</pre>");
            print_r("------------------------------------------------------------------------------------------------");
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
        if(empty($cpb_els[$new_parent_row_id]['columns'][$new_column_id]['items'])) {
          $cpb_els[$new_parent_row_id]['columns'][$new_column_id]['items'] = array();
        }
        //print_r($item);
        $cpb_els[$new_parent_row_id]['columns'][$new_column_id]['items'][] = $item;
      }
      //print_r($cpb_els[$new_parent_row_id]['columns'][$new_column_id]['items']);
    }
    
    
    
    // save
    if( $cpb_els ){
      $new = base64_encode(json_encode($cpb_els));    
    }
    return $new;
  }
  
  
 $data = base64_decode("eyJjcGItcm93LWlkIjpbIjEiLCIyIiwiMyJdLCJjcGItY29sdW1uLWlkIjpbIjEiLCIxIiwiMiIsIjEiLCIiXSwiZWxlbWVudC10eXBlIjpbImNwYl90ZXh0YmxvY2siLCJjcGJfdGV4dGJsb2NrIiwiY3BiX2Nhcm91c2VsIiwiY3BiX2Nhcm91c2VsIiwiY3BiX3RhYnMiLCJjcGJfdGFicyJdLCJlbGVtZW50LXBhcmVudCI6WyIxIiwiMSIsIjEiLCIyIiwiMSIsIjEiXSwiZWxlbWVudC1yb3ctcGFyZW50IjpbIjEiLCIxIiwiMiIsIjIiLCIzIiwiMyJdLCJjcGItaXRlbXMiOnsiY3BiX3RleHRibG9jayI6eyJjb250ZW50IjpbInhjdnhjdiIsInhjdnhjdiIsIiJdLCJlbF9jbGFzcyI6WyJ4Y3Z4Y3Z4Y3YiLCJ4Y3Z4Y3Z4Y3YiLCIiXX0sImNwYl9jYXJvdXNlbCI6eyJpbWFnZXMiOlt7InRpdGxlIjoieHh4Iiwic3ViX3RpdGxlIjoieHh4IiwidXJsX2ltYWdlIjoiL3NpdGVzL2RlZmF1bHQvZmlsZXMvY3BiLXVwbG9hZHMvcGVyZm9ybWFuY2VfaW1nMDAyLXZhcHVwNS5qcGcifSx7InRpdGxlIjoid3d3Iiwic3ViX3RpdGxlIjoid3d3IiwidXJsX2ltYWdlIjoiL3NpdGVzL2RlZmF1bHQvZmlsZXMvY3BiLXVwbG9hZHMvYnVzaW5lc3NfaW1nMDAxLTI0czB0YS5qcGcifSx7InRpdGxlIjoiIiwic3ViX3RpdGxlIjoiIiwidXJsX2ltYWdlIjoiIn0seyJ0aXRsZSI6ImdnZ2ciLCJzdWJfdGl0bGUiOiJnZ2dnZyIsInVybF9pbWFnZSI6Ii9zaXRlcy9kZWZhdWx0L2ZpbGVzL2NwYi11cGxvYWRzL2Jsb2dfaW1nMDItNGM1cXF1LmpwZyJ9LHsidGl0bGUiOiJnZ2dnZmYiLCJzdWJfdGl0bGUiOiJnaGZoZmdoZmdoIiwidXJsX2ltYWdlIjoiL3NpdGVzL2RlZmF1bHQvZmlsZXMvY3BiLXVwbG9hZHMvYnVzaW5lc3NfaW1nMDAxLTI0czB0YS5qcGcifSx7InRpdGxlIjoiZmdoZmdoZmdoZmdoIiwic3ViX3RpdGxlIjoiZmdoZmdoZmdoZmdoIiwidXJsX2ltYWdlIjoiL3NpdGVzL2RlZmF1bHQvZmlsZXMvY3BiLXVwbG9hZHMvcGVyZm9ybWFuY2VfaW1nMDAyLXZhcHVwNS5qcGcifSx7InRpdGxlIjoiIiwic3ViX3RpdGxlIjoiIiwidXJsX2ltYWdlIjoiIn0seyJ0aXRsZSI6IiIsInN1Yl90aXRsZSI6IiIsInVybF9pbWFnZSI6IiJ9LHsidGl0bGUiOiIiLCJzdWJfdGl0bGUiOiIiLCJ1cmxfaW1hZ2UiOiIifV0sImFuaW1hdGUiOlsiZmFkZUluTGVmdCIsIiIsIiJdLCJkdXJhdGlvbiI6WyIiLCIiLCIiXSwiZGVsYXkiOlsiIiwiIiwiIl0sImVsX2NsYXNzIjpbIiIsIiIsIiJdfSwiY3BiX3RhYnMiOnsidGl0bGUiOlsiIiwiYXNkYXNkYXNkYXNkIiwiIl0sInR5cGUiOlsidGFicyIsInRhYnMiLCJ0YWJzIl0sInRhYnMiOnsiY291bnQiOlsiMyIsIjIiLCIwIl0sInRpdGxlIjpbImFzZGFzZCIsImFzZGFzZCIsInBpb3BpbyIsImZkZ2poZ2poZmpoIiwiamhramxrajtsaydrbDtqa2xqa2wiXSwiY29udGVudCI6WyJhc2Rhc2QiLCJhc2Rhc2QiLCJpb3Bpb3Bpb3AiLCJnZmpnaGtqdXlrdXlramoiLCJqa2xrajtvJ3A7dWtsamxramxqa2wiXSwiaWNvbiI6WyJ0eXV0eXUiLCJobGo7a2psdWlvbGd1aWtsIl19LCJhbmltYXRlIjpbImZhZGVJblJpZ2h0TGFyZ2UiLCJmYWRlSW5MZWZ0IiwiIl0sImR1cmF0aW9uIjpbIjIiLCIiLCIiXSwiZGVsYXkiOlsiMiIsIiIsIiJdLCJlbF9jbGFzcyI6WyJhc2Rhc2QiLCIiLCIiXX0sImNwYl9kcnVwYWxfYmxvY2siOnsidGl0bGUiOlsiIl0sImJsb2NrX2RydXBhbCI6WyJ4aW5odm5uX2Jhc2VfYnJlYWRjcnVtYnMiXSwiaGlkZGVuX3RpdGxlIjpbIm9uIl0sImFsaWduX3RpdGxlIjpbInRpdGxlLWFsaWduLWxlZnQiXSwicmVtb3ZlX21hcmdpbiI6WyJvbiJdLCJzdHlsZV90ZXh0IjpbInRleHQtZGFyayJdLCJlbF9jbGFzcyI6WyIiXSwiYW5pbWF0ZSI6WyIiXX0sImNwYl9oZWFkaW5nIjp7InRpdGxlIjpbIiJdLCJlbGVtZW50X3RhZyI6WyJoMSJdLCJhbGlnbiI6WyJ0ZXh0LWxlZnQiXSwiZWxfY2xhc3MiOlsiIl19LCJjcGJfY3VzdG9tYnV0dG9uIjp7InRpdGxlIjpbIiJdLCJ1cmxfbGluayI6WyIiXSwiY2hvc2VfaWNvbiI6WyJmYSBmYS1hZGRyZXNzLWJvb2siXSwiaWNvbl9hbGlnbiI6WyJpY29uLWxlZnQiXSwiYWxpZ24iOlsidGV4dC1sZWZ0Il0sInNoYXBlIjpbInJvdW5kIl0sImNvbG9yIjpbInByaW1hcnkiXSwic2l6ZSI6WyJtZCJdLCJlbF9jbGFzcyI6WyIiXX0sImNwYl9pbWFnZSI6eyJpbWFnZSI6WyIiXSwiYWxpZ24iOlsidGV4dC1sZWZ0Il0sImFsdCI6WyIiXSwibGluayI6WyIiXSwidGFyZ2V0IjpbIm9mZiJdLCJhbmltYXRlIjpbIiJdLCJlbF9jbGFzcyI6WyIiXX0sImNwYl9pY29uX2JveCI6eyJ0aXRsZSI6WyIiXSwiY29udGVudCI6WyIiXSwiY2hvc2VfaWNvbiI6WyJmYSBmYS1hZGRyZXNzLWJvb2siXSwiaWNvbl9zaXplIjpbIiJdLCJpY29uX2NvbG9yIjpbIiJdLCJpbWFnZSI6WyIiXSwiaWNvbl9wb3NpdGlvbiI6WyJ0b3AtY2VudGVyIl0sImxpbmsiOlsiIl0sImJnX2NvbG9yIjpbIiJdLCJza2luX3RleHQiOlsidGV4dC1kYXJrIl0sInRhcmdldCI6WyJvZmYiXSwiYW5pbWF0ZSI6WyIiXSwiZHVyYXRpb24iOlsiIl0sImRlbGF5IjpbIiJdLCJlbF9jbGFzcyI6WyIiXX0sImNwYl9ib3hfaW5mbyI6eyJ0aXRsZSI6WyIiXSwic3VidGl0bGUiOlsiIl0sImltYWdlIjpbIiJdLCJjb250ZW50IjpbIiJdLCJoZWlnaHQiOlsiIl0sImNvbnRlbnRfYWxpZ24iOlsidGV4dC1sZWZ0Il0sImVsX2NsYXNzIjpbIiJdfSwiY3BiX3Byb2dyZXNzX2JhciI6eyJ0aXRsZSI6WyIiXSwicGVyY2VudCI6WyIiXSwiYmFja2dyb3VuZCI6WyIiXSwiYW5pbWF0ZWRfc3RyaXBlZCI6WyJubyJdLCJza2luX3RleHQiOlsidGV4dC1saWdodCJdLCJhbmltYXRlIjpbIiJdLCJkdXJhdGlvbiI6WyIiXSwiZGVsYXkiOlsiIl0sImVsX2NsYXNzIjpbIiJdfSwiY3BiX3ZpZGVvX2JveCI6eyJjb250ZW50IjpbIiJdLCJhdXRvX3BsYXkiOlsieWVzIl0sImFuaW1hdGUiOlsiIl0sImR1cmF0aW9uIjpbIiJdLCJkZWxheSI6WyIiXSwiZWxfY2xhc3MiOlsiIl19LCJjcGJfbm9kZV92aWV3Ijp7Im5vZGVfaWQiOlsiIl0sImFuaW1hdGUiOlsiIl0sImR1cmF0aW9uIjpbIiJdLCJkZWxheSI6WyIiXSwiZWxfY2xhc3MiOlsiIl19fSwiY3BiLWNvbHVtbnMiOnsic2l6ZSI6WyIyIiwiMTIiLCIxMiIsIjEyIiwiNCJdLCJ0eXBlIjpbIiIsIiIsIiIsIiIsIiJdLCJiZ19pbWFnZSI6WyIiLCIiLCIiLCIiLCIiXSwiYmdfY29sb3IiOlsiIiwiIiwiIiwiIiwiIl0sImJnX3Bvc2l0aW9uIjpbImNlbnRlciB0b3AiLCJjZW50ZXIgdG9wIiwiY2VudGVyIHRvcCIsImNlbnRlciB0b3AiLCJjZW50ZXIgdG9wIl0sImJnX3JlcGVhdCI6WyJuby1yZXBlYXQiLCJuby1yZXBlYXQiLCJuby1yZXBlYXQiLCJuby1yZXBlYXQiLCJuby1yZXBlYXQiXSwiYmdfYXR0YWNobWVudCI6WyJzY3JvbGwiLCJzY3JvbGwiLCJzY3JvbGwiLCJzY3JvbGwiLCJzY3JvbGwiXSwiYmdfc2l6ZSI6WyIiLCIiLCIiLCIiLCIiXSwiY2xhc3MiOlsiIiwiIiwiIiwiIiwiIl0sImNvbHVtbl9pZCI6WyIiLCIiLCIiLCIiLCIiXSwiYW5pbWF0ZSI6WyIiLCIiLCIiLCIiLCIiXSwiZHVyYXRpb24iOlsiIiwiIiwiIiwiIiwiIl0sImRlbGF5IjpbIiIsIiIsIiIsIiIsIiJdLCJoaWRkZW5fbGciOlsic2hvdyIsInNob3ciLCJzaG93Iiwic2hvdyIsInNob3ciXSwiaGlkZGVuX21kIjpbInNob3ciLCJzaG93Iiwic2hvdyIsInNob3ciLCJzaG93Il0sImhpZGRlbl9zbSI6WyJzaG93Iiwic2hvdyIsInNob3ciLCJzaG93Iiwic2hvdyJdLCJoaWRkZW5feHMiOlsic2hvdyIsInNob3ciLCJzaG93Iiwic2hvdyIsInNob3ciXX0sImNvbHVtbi1wYXJlbnQiOlsiMSIsIjIiLCIyIiwiMyIsIiJdLCJjcGItcm93cyI6eyJiZ19pbWFnZSI6WyIiLCIiLCIiLCIiXSwiYmdfY29sb3IiOlsiIiwiIiwiIiwiIl0sImJnX3Bvc2l0aW9uIjpbImNlbnRlciB0b3AiLCJjZW50ZXIgdG9wIiwiY2VudGVyIHRvcCIsImNlbnRlciB0b3AiXSwiYmdfcmVwZWF0IjpbIm5vLXJlcGVhdCIsIm5vLXJlcGVhdCIsIm5vLXJlcGVhdCIsIm5vLXJlcGVhdCJdLCJiZ19hdHRhY2htZW50IjpbInNjcm9sbCIsInNjcm9sbCIsInNjcm9sbCIsInNjcm9sbCJdLCJiZ19zaXplIjpbIiIsIiIsIiIsIiJdLCJhbmltYXRlIjpbIiIsIiIsIiIsIiJdLCJkdXJhdGlvbiI6WyIiLCIiLCIiLCIiXSwiZGVsYXkiOlsiIiwiIiwiIiwiIl0sInN0eWxlX3NwYWNlIjpbImRlZmF1bHQiLCJkZWZhdWx0IiwiZGVmYXVsdCIsImRlZmF1bHQiXSwicGFkZGluZ190b3AiOlsiIiwiMCIsIjAiLCIiXSwicGFkZGluZ19ib3R0b20iOlsiIiwiMCIsIjAiLCIiXSwibWFyZ2luX3RvcCI6WyIiLCIwIiwiMCIsIiJdLCJtYXJnaW5fYm90dG9tIjpbIiIsIjAiLCIwIiwiIl0sImxheW91dCI6WyJjb250YWluZXIiLCJjb250YWluZXIiLCJjb250YWluZXIiLCJjb250YWluZXIiXSwiY2xhc3MiOlsiIiwiIiwiIiwiIl0sInJvd19pZCI6WyIiLCIiLCIiLCIiXX19");
 $data = json_decode($data, true);
 $params = custom_pagebuilder_save_element($data);
 print_r("<pre>");
 print_r($params);
 print_r("</pre>");


?>