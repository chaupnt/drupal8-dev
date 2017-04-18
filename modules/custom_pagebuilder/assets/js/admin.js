 /**
  * $Desc
  *
  * @author     Chau Phan (truongchau007@gmail.com)
  * @copyright  Copyright (C) 2017. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  * @addition this license does not allow theme provider using in themes to sell on marketplaces.
  * 
  */
!function(e){function t(t,i){this.element=t,this.options=e.extend({},n,i),this._defaults=n,this._name=r}var r="serializeObject",n={requiredFormat:{}};t.prototype.toJsonObject=function(){var t=this,r=t.replaceEmptyBracketWithNumericBracket(e(t.element).serializeArray()),n=t.options.requiredFormat;return e.each(r,function(r,i){var a=i.name.replace(/]/g,"").split("["),o=t.stringArrayKeyToVariable(a,i.value);n=e.extend(!0,{},n,o)}),n},t.prototype.replaceEmptyBracketWithNumericBracket=function(t){var r={},n=t;return e.each(n,function(e,t){var i=t.name,a=i.indexOf("[]");a>-1&&(r[i]="undefined"==typeof r[i]?0:++r[i],n[e].name=t.name.replace("[]","["+r[i]+"]"))}),n},t.prototype.stringArrayKeyToVariable=function(e,t){var r,n=this;if(e.length>0){var i=e.shift().trim();r=isNaN(i)&&""!=i?{}:[],r[i]=e.length>0?n.stringArrayKeyToVariable(e,t):t}return r},e.fn[r]=function(e){return new t(this,e).toJsonObject()}}(jQuery,window,document);

function notify(style) {
        $.notify({
            title: 'Email Notification',
            text: 'You received an e-mail from your boss. You should read it right now!',
            image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: false,
            clickToHide: true
        });
    }

var keyString="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
base64Encode = function(c) {
  var a = "";
  var k, h, f, j, g, e, d;
  var b = 0;
  c = UTF8Encode(c);
  while (b < c.length) {
    k = c.charCodeAt(b++); 
    h = c.charCodeAt(b++);
    f = c.charCodeAt(b++);
    j = k >> 2;
    g = ((k & 3) << 4) | (h >> 4);
    e = ((h & 15) << 2) | (f >> 6);
    d = f & 63;
    if (isNaN(h)) {
      e = d = 64
    } else {
      if (isNaN(f)) {
        d = 64
      }
    }
    a = a + keyString.charAt(j)
    + keyString.charAt(g)
    + keyString.charAt(e)
    + keyString.charAt(d)
  }
  return a
};

UTF8Encode = function(b) {
  b = b.replace(/\x0d\x0a/g, "\x0a");
  var a = "";
  for ( var e = 0; e < b.length; e++) {
    var d = b.charCodeAt(e);
    if (d < 128) {
      a += String.fromCharCode(d)
    } else {
      if ((d > 127) && (d < 2048)) {
        a += String.fromCharCode((d >> 6) | 192);
        a += String.fromCharCode((d & 63) | 128)
      } else {
        a += String.fromCharCode((d >> 12) | 224);
        a += String.fromCharCode(((d >> 6) & 63) | 128);
        a += String.fromCharCode((d & 63) | 128)
      }
    }
  }
  return a
};

GaviasCompare = function(a, b){
   if (a.index < b.index)
     return -1;
   if (a.index > b.index)
     return 1;
   return 0;
};

function randomString(length) {
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

//========= Main script ====================
 
(function ($) {
  $.fn.extend({insertcaret:function(t){return this.each(function(){if(document.selection){this.focus();var e=document.selection.createRange();e.text=t,this.focus()}else if(this.selectionStart||"0"==this.selectionStart){var s=this.selectionStart,i=this.selectionEnd,n=this.scrollTop;this.value=this.value.substring(0,s)+t+this.value.substring(i,this.value.length),this.focus(),this.selectionStart=s+t.length,this.selectionEnd=s+t.length,this.scrollTop=n}else this.value+=t,this.focus()})}});

   $(document).ready(function () {
       
      $('#cpb-form-setting').delegate(".input_datetime", 'click', function(e){
          e.preventDefault();
          $(this).datepicker({
               defaultDate: "",
               dateFormat: "yy-mm-dd",
               numberOfMonths: 1,
               showButtonPanel: true,
          });
           $(this).datepicker('show');
     });


      $('#save').removeAttr('disabled');
      
      /*
      $('#wrapper-custom-pagebuilder-setting-content').delegate('#save', 'click', function(){
        $(this).attr('disabled', 'true');
         custom_pagebuilder_save_content();
         return false;
      })
       */

      $('#cpb-form-setting').delegate('.gsc_display_view', 'change', function(){
        var $label = $(this).find(':selected').text();
        $(this).parents('#cpb-form-setting').find('.display-admin').val($label);
      });

   });
   
   /*
   function custom_pagebuilder_save_content(){
      var result = $('#wrapper-custom-pagebuilder-setting-content input:not(.input-file-upload), #wrapper-custom-pagebuilder-setting-content select, #wrapper-custom-pagebuilder-setting-content textarea').serializeObject();
      result = $.extend({}, result);
      result =base64Encode(JSON.stringify(result));
        //console.log(result);
      var pid = $("input[name=gavias_blockbuilder_id]").val();
      var data = {
         data: result,
         pid: pid
      };
      notify('info', 'Please waiting Block Builder process !');
      $.ajax({
         url: drupalSettings.gavias_blockbuilder.saveConfigURL,
         type: 'POST',
         data: data,
         dataType: 'json',
         success: function (data) {
          $('#save').val('Save');
          notify('success', 'Block Builder setting updated');
          window.location = drupalSettings.gavias_blockbuilder.url_redirect;
         },
         error: function (jqXHR, textStatus, errorThrown) {
           alert(textStatus + ":" + jqXHR.responseText);
           notify('black', 'Block Builder setting not updated');
         }
      });
   }
   */

   function init_sortable_find(wrap, find, items){
      wrap.find(find).sortable({ 
         start: function(e, ui){
           ui.placeholder.width(ui.item.find('.custom-pagebuilder-content-page').first().width() - 20);
           ui.placeholder.height(ui.item.height() - 20);
         },
         connectWith          : find,
         cursor               : 'move',
         forcePlaceholderSize : true, 
         placeholder          : 'cpb-placeholder',
         items                : items,
         opacity              : 1,
         handle               : '.bb-drap',
          receive              : function(event, ui){ 
            cpb_sort_rows();
         },
      }); 
      return wrap;  
   }

  function cpb_sortable_elements(){
    var wrap = $('#cpb-admin-wrap');
    wrap.find('.cpb-droppable-column').sortable({ 
      start: function(e, ui){
           ui.placeholder.width(150);
           ui.item.width(150);
           ui.placeholder.height(ui.item.height() - 20);
        },
        connectWith           : '.cpb-droppable-column',
        cursor                : 'move',
        forcePlaceholderSize  : true, 
        placeholder           : 'cpb-placeholder',
        items                 : '.cpb-item',
        opacity               : 0.9 ,  
        handle                : '.bb-el-drap',
        receive              : function(event, ui){ 
            var target_sid = jQuery(this).siblings('.cpb-column-id').val(); 
            var target_rid = jQuery(this).parents('.cpb-row').find('.cpb-row-id').val(); 
            ui.item.find('.element-parent').val(target_sid);
            ui.item.find('.element-row-parent').val(target_rid);
         }
    });
   }

   function cpb_sort_columns(){
    var wrap = $('#cpb-admin-wrap');
    return wrap.find('.cpb-row').each(function(){
      id = 0;
      $(this).find('.cpb-columns').each(function(){
        id++;
        $(this).find('input.cpb-column-id').val(id);
        $(this).find('input.element-parent').val(id);
      })
    })
   }

   function cpb_sort_rows(){
    var wrap = $('#cpb-admin-wrap');
    row_id = 0;
    wrap.find('.cpb-row').each(function(){
      row_id++;
      col_id = 0;
      $(this).find('input.cpb-row-id').val(row_id);
      $(this).find('.cpb-columns').each(function(){
        col_id++;
        $(this).find('input.column-parent').val(row_id);
        $(this).find('input.element-row-parent').val(row_id);
      })
    })
    $('input#cpb-row-id').val(row_id);
    return wrap;
   }

   function cpb_sortable_columns(){
     var wrap = $('#cpb-admin-wrap');
     var id=0;
      wrap.find('.cpb-droppable-row').sortable({ 
      start: function(e, ui){
           ui.placeholder.width(ui.item.find('.custom-pagebuilder-content-page').first().width() - 20);
           ui.placeholder.height(ui.item.height() - 20);
        },
        connectWith           : '.cpb-droppable-row',
        cursor                : 'move',
        forcePlaceholderSize  : true, 
        placeholder           : 'cpb-placeholder',
        items                 : '.cpb-columns',
        opacity               : 0.9 ,
        handle                : '.bb-drap',
        receive              : function(event, ui){ 
            var target_rid = jQuery(this).siblings('.cpb-row-id').val(); 
            ui.item.find('.column-parent').val(target_rid);
            ui.item.find('.element-row-parent').val(target_rid);
         },
         update: function(){
          cpb_sort_columns();
         }
      });
   }

   function add_column(el, width, type){
    var custompagebuilder_admin = $('#cpb-admin-wrap');
      var clone = $('#cpb-columns .cpb-columns').clone(true);
      clone.hide();
      var row_id = el.parents('.cpb-row').find('.cpb-row-id').val(); 
      var col_id = -1;
      var col_width = width;
      clone.removeClass('wb-4').addClass('wb-' + col_width);
      clone.find('input.column-size').val(col_width);
      clone.find('item-w-label').html(col_width);
      //Set value max column id
      el.parents('.cpb-row').find('input.cpb-column-id').each(function(){
        if( $(this).val() > col_id){
          col_id = $(this).val();
        }
      });
      if(col_id==-1) col_id = 0;

      $('#cpb-column-id').val($('#cpb-column-id').val()*1 + 1);
      clone.addClass('type-' + type);
      clone.find('.item-w-label').html(col_width);
      clone.find('.cpb-column-id').val(col_id*1 + 1);
      clone.find('input.column-parent').val(row_id);
      clone.find('input.column-type').val(type);
      el.parents('.cpb-row').find('.cpb-droppable-row').append(clone).find(".cpb-columns").fadeIn(500);
      cpb_sortable_elements();
      cpb_sortable_columns();
   }


   function _mod_custom_pages_builder(){
      var custompagebuilder_admin = $('#cpb-admin-wrap');
      var _cpb_sortable = '.cpb-sortable';
      var _cpb_item = '.cpb-item';
      var _cpb_items = '#cpb-items';
      var _cpb_row = '.cpb-row';
      var _cpb_column = '.cpb-columns';

   	if( ! custompagebuilder_admin.length ) return false;	
   	
    custompagebuilder_admin.sortable({ 
      start: function(e, ui){
           ui.placeholder.width(ui.item.find('.custom-pagebuilder-content-page').first().width() - 20);
           ui.placeholder.height(ui.item.height() - 20);
        },
        cursor          : 'move',
        forcePlaceholderSize  : true, 
        placeholder       : 'cpb-placeholder',
        items           : '.cpb-row',
        opacity         : 0.9,
        handle               : '.bb-drap',
        update              : function(event, ui){ 
            cpb_sort_rows();
         },
    });
   	
    cpb_sortable_columns();
    cpb_sortable_elements();

      //Size element
      $('.cpb-plus').click(function(){
         var item = $(this).closest('.cpb-columns');
         var _isize = [ '1', '2', '3', '4', '5', '6', '7','8','9','10','11', '12' ];
         for( var i = 0; i < _isize.length-1; i++ ){
            var classes = 'wb-' + _isize[i].replace('/', '-');  //classes width bootstrap eg. wb-6
            var classes_new = 'wb-' + _isize[i+1].replace('/', '-'); //classes width bootstrap eg. wb-6
            if( ! item.hasClass( classes ) ) continue;
            item.removeClass( classes ).addClass( classes_new ).find('.column-size').val( _isize[i+1] );
            item.find('.item-w-label').text( _isize[i+1] );
            break;
         }  
      });
      
      $('.cpb-minus').click(function(){
         var item = $(this).closest('.cpb-columns');
          var _isize = [ '1', '2', '3', '4', '5', '6', '7','8','9','10','11', '12' ];
         
         for( var i = 1; i < _isize.length; i++ ){
            var classes = 'wb-' + _isize[i].replace('/', '-'); //classes width bootstrap eg. wb-6
            var classes_new = 'wb-' + _isize[i-1].replace('/', '-'); //classes width bootstrap eg. w-6
            if( ! item.hasClass( classes ) ) continue;
            
            item.removeClass( classes )
               .addClass( classes_new )
               .find('.column-size').val( _isize[i-1]);
            
            item.find('.item-w-label').text( _isize[i-1] );
            
            break;
         }     
      });

    // add row 
    var rowid = $('#cpb-row-id');
   	$('.bb-btn-row-add').click(function(){
        var clone = $('#cpb-rows .cpb-row').clone(true);
        init_sortable_find(clone, _cpb_sortable, _cpb_item);

   		clone.hide().find('.custom-pagebuilder-content-page > input').each(function() {
   				$(this).attr('name',$(this).attr('class')+'[]');
   			});
   		
   		rowid.val(rowid.val()*1+1);
   		clone.find('.cpb-row-id').val(rowid.val());
   		
   		custompagebuilder_admin.append(clone).find(".cpb-row").fadeIn(500);
      cpb_sort_rows();
   	});

    // add column
    $('.cpb-add-column').click(function(){
      var col_width = $(this).attr('data-width');
      add_column($(this), col_width, '');
    });
    
    // add clear
    $('.cpb-add-clear').click(function(){
      add_column($(this), '12', 'column-clearfix');
    });

   	// clone row
   	$('.cpb-row .cpb-row-clone').click(function(){
   		var element = $(this).closest('.cpb-element');
   		element.find(_cpb_sortable).sortable('destroy');
   		var clone = element.clone(true);
   		element.after(clone);
      cpb_sort_rows();
      cpb_sortable_columns();
      cpb_sortable_elements();
   	});

    // clone columns
    $('.cpb-columns .cpb-column-clone').click(function(){
      var wrap = $('#cpb-admin-wrap');
      var element = $(this).closest('.cpb-element');
      element.find(_cpb_sortable).sortable('destroy');
      row_id = $(this).parents('cpb-row').find('input.cpb-row-id').val();
      var clone = element.clone(true);
      clone.find('input.element-parent').val(row_id);
      element.after(clone);
      cpb_sort_columns();
      cpb_sortable_columns();
      cpb_sortable_elements();
    }); 

    
   	// add item list toggle
   	$('.cpb-add').click(function(){
   		var parent = $(this).parent();
   		
   		if( parent.hasClass('focus') ){
   			parent.removeClass('focus');
        $(this).parents('.cpb-columns').css('z-index', '');
   		} else {
   			$('.cpb-add-element').removeClass('focus');
   			parent.addClass('focus');
        $(this).parents('.cpb-columns').css('z-index', 9);
   		}
   	});
   	
   	// add item 
   	$('.cpb-items a').click(function(){
   		$(this).closest('.cpb-add-element').removeClass('focus');
       $(this).parents('.cpb-columns').css('z-index', 9);
   		var parent = $(this).parents('.cpb-columns').find('.cpb-droppable');
   		var column_id = $(this).parents('.cpb-columns').find('.cpb-column-id').val(); 
      var row_id = $(this).parents('.cpb-row').find('.cpb-row-id').val(); 
      
   		var item = $(this).attr('class');
   		var clone = $(_cpb_items).find('div.cpb-type-'+ item ).clone(true);
      
   		clone.hide().find('.custom-pagebuilder-content-page input').each(function() {
                    $(this).attr('name',$(this).attr('class')+'[]');
   		});

   		clone.find('.element-parent').val(column_id);
                clone.find('.element-row-parent').val(row_id);
   		parent.append(clone).find(".cpb-item").fadeIn(500);
                cpb_sortable_elements();
                cpb_sortable_columns();
   	});
   	

      // delete el 
      $('.cpb-el-delete').click(function(){
         var item = $(this).closest('.cpb-element');
         if( confirm( "You are sure delete this element ! Continue?" ) ){
            item.fadeOut(500, function(){$(this).remove()});
          } else {
            return false;
          }
      });

      // delete column 
      $('.cpb-column-delete').click(function(){
         var item = $(this).closest('.cpb-columns');
         if( confirm( "You are sure delete this column ! Continue?" ) ){
            item.fadeOut(500, function(){
              $(this).remove()
              cpb_sort_columns();
            });
          } else {
            return false;
          }
      });

      //Delete row
      $('.cpb-row-delete').click(function(){
         var item = $(this).closest('.cpb-row');
         if( confirm( "You are sure delete this row ! Continue?" ) ){
            item.fadeOut(500, function(){
              $(this).remove();
              cpb_sort_rows();
            });
          } else {
            return false;
          }
      });

   	// clone el
   	$('.cpb-item .cpb-item-clone').click(function(){
   		var element = $(this).closest('.cpb-element');
   		var _clone = element.clone(true);
   		element.after(_clone);
   	});

    // form
   	var iresult = ''; var oresult = '';
   
   	$('.cpb-edit').click(function(){
            oresult = '';
            //$('#cpb-form-setting').parent().find('.custom-pagebuilder-overlay').first().addClass('active').parents('body').addClass('gavias-overflow-hidden');
            iresult = $(this).closest('.cpb-element'); 
            
            var $title_lable = iresult.find('.cpb-item-title').html();
            //iresult.append('<h2>asdasdasdas</h2>');
            var _clone = iresult.children('.cpb-el-meta').clone(true);
            //_clone.before('<div class="hedding"><span>'+ $title_lable +' Setting</span></div>');
            oresult = iresult.children('.cpb-el-meta').clone(true);
            _clone.find('.CodeMirror').remove();
            $('#cpb-form-setting').prepend(_clone).fadeIn(350, function(){});
        $('#cpb-form-setting').find('.hedding').remove();
        if(iresult.hasClass('cpb-item')) {
            $('#cpb-form-setting .cpb-el-meta').before('<div class="hedding"><span>'+ $title_lable +' Setting</span></div>');
        }  
            $('#cpb-form-setting .cpb-el-meta').animate({scrollTop: 0}, 500);
            iresult.children('.cpb-el-meta').remove();
            //runRender('html');
            return;
   	});

    $('#cpb-form-setting .cpb-form-setting-save').click(function(){
        $('.tabs-ul.ui-sortable').sortable('destroy');
        var popup = $('#cpb-form-setting');
        var _clone = popup.find('.cpb-el-meta').clone(true);
        iresult.append(_clone);
        iresult.find('>.custom-pagebuilder-content-page>.cpb-item-content>.item-bb-title').html(iresult.find('.display-admin').first().val());
        popup.fadeOut(50, function(){
           $(this).parent().find('.custom-pagebuilder-overlay').first().removeClass('active').parents('body').removeClass('custom-pagebuilder-overflow-hidden');
        })
        setTimeout(function(){
          popup.find('.cpb-el-meta').remove();
        },50);
        iresult = ''; oresult = '';
        return;
    });  

    $('#cpb-form-setting .cpb-form-setting-cancel').click(function(){
      $('.tabs-ul.ui-sortable').sortable('destroy');
      var popup = $('#cpb-form-setting');
      iresult.append(oresult);
      popup.fadeOut(50).parent().find('.custom-pagebuilder-overlay').first().removeClass('active').parents('body').removeClass('gavias-overflow-hidden');
      setTimeout(function(){
        popup.find('.cpb-el-meta').remove();
      },50);
      iresult = ''; oresult = '';
    });

  }

  (function (o) {
      jQuery.fn.clone = function () {
          var result = o.apply (this, arguments),
          old_input = this.find('textarea, select'),
          new_input = result.find('textarea, select');

          //set random id upload field
          result.find('.gva-upload-image').each(function(){
            var random = randomString(10)
            $(this).attr('id', 'gva-upload-' + random);
            $(this).find('form.upload').attr('id', 'upload-' + random);
          });
          for (var i = 0, l = old_input.length; i < l; ++i)
            jQuery(new_input[i]).val( jQuery(old_input[i]).val() );
          return result;

      };
  }) (jQuery.fn.clone);

  $(document).ready(function(){
    _mod_custom_pages_builder();
  });

  $(document).mouseup(function(e){
   	if ($(".cpb-add-element").has(e.target).length === 0){
   		$(".cpb-add-element").removeClass('focus');
      $('.cpb-columns').css('z-index', '');
   	} 
   	if ($(".cpb-sc-add").has(e.target).length === 0){
   		$(".cpb-sc-add").removeClass('focus');
      $('.cpb-columns').css('z-index', '');
   	}
  });

  $(document).ready(function(e){
    $(".close-cpb-items").click(function(){
      $(".cpb-add-element").removeClass('focus');
      $('.cpb-columns').css('z-index', '');
    });
  });

  

    function getByClass(sClass){
      var aResult=[];
      var aEle=document.getElementsByTagName('*');
      for(var i=0;i<aEle.length;i++){
        /*foreach className*/
        var arr=aEle[i].className.split(/\s+/);
        for(var j=0;j<arr.length;j++){
          /*check class*/
          if(arr[j]==sClass){
            aResult.push(aEle[i]);
          }
        }
      }
      return aResult;
    };

    /*
    function runRender(type){
      var aBox=getByClass("code_"+type);
      for(var i=0;i < aBox.length; i++){
        var editor = false;
        if(!editor){
          editor = CodeMirror.fromTextArea(aBox[i], {
            lineNumbers: true,
            mode: "text/html",
          });
        }
        editor.on("blur", function() {editor.save()});
      }
    };
    */
   
    
    //console.log(drupalSettings);
    function notify(style, text) {
            $.notify({
                title: 'Notification',
                text: text,
                image: '<i class="fa fa-floppy-o" style="font-size: 30px; color: #fff;"></i>',

            }, {
                style: 'metro',
                className: style,
                autoHide: true,
                clickToHide: true,
            });
         } 
    
    var url_save = drupalSettings.custom_pagebuilder.saveConfigURL;
    $('#cpb-form-setting--2 .cpb-form-setting-save').click(function(){
        var result = $('#wrapper-custom-pagebuilder-setting-content input:not(.input-file-upload), #wrapper-custom-pagebuilder-setting-content select, #wrapper-custom-pagebuilder-setting-content textarea').serializeObject();
        result = $.extend({}, result);
        result = base64Encode(JSON.stringify(result));

        var pid = $("#custom_pagebuilder_page_id").val();
        var data = {
           data: result,
           pid: pid
        };
        $.ajax({
             url: url_save,
             type: 'POST',
             data: data,
             dataType: 'json',
             success: function (data) {
                 notify('success', 'Page Builder setting updated');
             },
             error: function (jqXHR, textStatus, errorThrown) {
               //alert(textStatus + ":" + jqXHR.responseText);
               //notify('black', 'Block Builder setting not updated');
             }
          });
     }) 

})(jQuery);