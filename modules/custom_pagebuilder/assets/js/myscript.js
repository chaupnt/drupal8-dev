jQuery(document).ready(function($){ 
    
    $('.field-color').colorPicker({
        customBG: '#222',
	margin: '4px -2px 0',
        doRender: 'div div',
        buildCallback: function ($elm) {
            var colorInstance = this.color,
                    colorPicker = this;

            $elm.prepend('<div class="cp-panel">' +
                    'R <input type="text" class="cp-r" /><br>' +
                    'G <input type="text" class="cp-g" /><br>' +
                    'B <input type="text" class="cp-b" /><hr>' +
                    'H <input type="text" class="cp-h" /><br>' +
                    'S <input type="text" class="cp-s" /><br>' +
                    'B <input type="text" class="cp-v" /><hr>' +
                    '<input type="text" class="cp-HEX" />' +
                    '</div>').on('change', 'input', function (e) {
                var value = this.value,
                        className = this.className,
                        type = className.split('-')[1],
                        color = {};

                color[type] = value;
                colorInstance.setColor(type === 'HEX' ? value : color,
                        type === 'HEX' ? 'HEX' : /(?:r|g|b)/.test(type) ? 'rgb' : 'hsv');
                colorPicker.render();
                this.blur();
            });
        },

        cssAddon: // could also be in a css file instead
                '.cp-color-picker{box-sizing:border-box; width:226px;}' +
                '.cp-color-picker .cp-panel {line-height: 21px; float:right;' +
                'padding:0 1px 0 8px; margin-top:-1px; overflow:visible}' +
                '.cp-xy-slider:active {cursor:none;}' +
                '.cp-panel, .cp-panel input {color:#bbb; font-family:monospace,' +
                '"Courier New",Courier,mono; font-size:12px; font-weight:bold;}' +
                '.cp-panel input {width:28px; height:12px; padding:2px 3px 1px;' +
                'text-align:right; line-height:12px; background:transparent;' +
                'border:1px solid; border-color:#222 #666 #666 #222;}' +
                '.cp-panel hr {margin:0 -2px 2px; height:1px; border:0;' +
                'background:#666; border-top:1px solid #222;}' +
                '.cp-panel .cp-HEX {width:44px; position:absolute; margin:1px -3px 0 -2px;}' +
                '.cp-alpha {width:155px;}',

        renderCallback: function ($elm, toggled) {
            var colors = this.color.colors.RND,
                    modes = {
                        r: colors.rgb.r, g: colors.rgb.g, b: colors.rgb.b,
                        h: colors.hsv.h, s: colors.hsv.s, v: colors.hsv.v,
                        HEX: this.color.colors.HEX
                    };

            $('input', '.cp-panel').each(function () {
                this.value = modes[this.className.substr(3)];
            });
        }
		
    });
    
                // Live binding of buttons
    $(document).on('click', '.action-placement', function(e) {
        $('.action-placement').removeClass('active');
        $(this).addClass('active');
        $('.icp-opts').data('iconpicker').updatePlacement($(this).text());
        e.preventDefault();
        return false;
    });
    
    $('.icp-dd').iconpicker({});
    
    $(".iconpicker-item").on('click', function() {
        var $option = $(this).closest('.wrapper-custom-icon-fa');
        var class_name = $(this).attr('title').replace(".", "");
        $option.find('.iconpicker-component').html('<i class="fa '+ class_name +'"></i>');
        $option.next().val('fa ' + class_name);
    })
  
})