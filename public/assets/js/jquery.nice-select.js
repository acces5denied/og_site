/*  jQuery Nice Select - v1.1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
 
(function($) {

  $.fn.niceSelect = function(method) {
      
        function priceChange() {
          
            if($('select.currency').val() != 'RUB'){
                $('#price').find('li').each(function(i){
                    $(this).text($(this).attr('data-cur-text'));

                })
              
                $('#price').find('.val_from').text($('#price').find('.group_from .selected').text());
                $('#price').find('input[name=price_from]').val($('#price').find('.group_from .selected').attr('data-cur'));
              
                $('#price').find('.val_to').text($('#price').find('.group_to .selected').text());
                $('#price').find('input[name=price_to]').val($('#price').find('.group_to .selected').attr('data-cur'));
                
              
            }else{
                $('#price').find('li').each(function(i){
                    $(this).text($(this).attr('data-text'));
                })
              
                $('#price').find('.val_from').text($('#price').find('.group_from .selected').text());
                $('#price').find('input[name=price_from]').val($('#price').find('.group_from .selected').attr('data-value'));
              
                $('#price').find('.val_to').text($('#price').find('.group_to .selected').text());
                $('#price').find('input[name=price_to]').val($('#price').find('.group_to .selected').attr('data-value'));
            }
      }
      
      priceChange();
      
      $('#currency').change(function(){
          priceChange();
      })
	  
	  function areaChange() {

           $('#area').find('li').each(function(i){
                $(this).text($(this).attr('data-text'));
           })
              
           $('#area').find('.val_from').text($('#area').find('.group_from .selected').text());
           $('#area').find('input[name=area_from]').val($('#area').find('.group_from .selected').attr('data-value'));
              
           $('#area').find('.val_to').text($('#area').find('.group_to .selected').text());
           $('#area').find('input[name=area_to]').val($('#area').find('.group_to .selected').attr('data-value'));

      }
	  areaChange();
    
    // Methods
    if (typeof method == 'string') {      
      if (method == 'update') {
        this.each(function() {
          var $select = $(this);
          var $dropdown = $(this).next('.nice-select');
          var open = $dropdown.hasClass('open');
          
          if ($dropdown.length) {
            $dropdown.remove();
            create_nice_select($select);
            
            if (open) {
              $select.next().trigger('click');
            }
          }
        });
      } else if (method == 'destroy') {
        this.each(function() {
          var $select = $(this);
          var $dropdown = $(this).next('.nice-select');
          
          if ($dropdown.length) {
            $dropdown.remove();
            $select.css('display', '');
          }
        });
        if ($('.nice-select').length == 0) {
          $(document).off('.nice_select');
        }
      } else {
        console.log('Method "' + method + '" does not exist.')
      }
      return this;
    }
      
    // Hide native select
    this.hide();
    
    // Create custom markup
    this.each(function() {
      var $select = $(this);
      
      if (!$select.next().hasClass('nice-select')) {
        create_nice_select($select);
      }
    });
    
    function create_nice_select($select) {
      $select.after($('<div></div>')
        .addClass('nice-select')
        .addClass($select.attr('class') || '')
        .addClass($select.attr('disabled') ? 'disabled' : '')
        .attr('tabindex', $select.attr('disabled') ? null : '0')
        .html('<span class="current"></span><ul class="list"></ul>')
      );
        
      var $dropdown = $select.next();
      var $options = $select.find('option');
      var $selected = $select.find('option:selected');
      
      $dropdown.find('.current').html($selected.data('display') || $selected.attr('data-txt'));
      
      $options.each(function(i) {
        var $option = $(this);
        var display = $option.data('display');

        $dropdown.find('ul').append($('<li></li>')
          .attr('data-value', $option.val())
          .attr('data-display', (display || null))
          .addClass('option' +
            ($option.is(':selected') ? ' selected' : '') +
            ($option.is(':disabled') ? ' disabled' : ''))
          .html($option.attr('data-txt'))
        );
      });
    }
    
    /* Event listeners */
    
    // Unbind existing events in case that the plugin has been initialized before
    $(document).off('.nice_select');
    
    // Open/close
    $(document).on('click.nice_select', '.nice-select', function(event) {
      var $dropdown = $(this);
      
      $('.nice-select').not($dropdown).removeClass('open');
      $dropdown.toggleClass('open');
      
      if ($dropdown.hasClass('open')) {
        $dropdown.find('.option');  
        $dropdown.find('.focus').removeClass('focus');
        $dropdown.find('.selected').addClass('focus');
      } else {
        $dropdown.focus();
      }
    });
    
    // Close when clicking outside
    $(document).on('click.nice_select', function(event) {
      if ($(event.target).closest('.nice-select').length === 0) {
        $('.nice-select').removeClass('open').find('.option');  
      }
    });
    
    // Option click
    $(document).on('click.nice_select', '.nice-select:not(.range) .option:not(.disabled)', function(event) {
      var $option = $(this);
      var $dropdown = $option.closest('.nice-select');
      
      $dropdown.find('.selected').removeClass('selected');
      $option.addClass('selected');
      
      var text = $option.data('display') || $option.html();
      $dropdown.find('.current').html(text);
      
      $dropdown.prev('select').val($option.data('value')).trigger('change');
    });
      
    // Option click range
    $(document).on('click.nice_select', '#price .option:not(.disabled)', function(event) {
        
      var $option = $(this);
      var $dropdown = $option.closest('.nice-select');
      var $group_from = $option.closest('.group_from');
      var $group_to = $option.closest('.group_to');
      
      $group_from.find('.selected').removeClass('selected');
      $group_to.find('.selected').removeClass('selected');
      $option.addClass('selected');
      
      var text = $option.data('display') || $option.text();
      var val = $option.attr('data-value');
      var group = $option.attr('data-group');
      
        
        if($('select.currency').val() != 'RUB'){
            
            text = $option.attr('data-cur-text');
            val = $option.attr('data-cur');

        }

      $dropdown.find('.val_'+group).text(text);
      $dropdown.find('input[name*='+group+']').val(val).trigger('change');
        

        var myArray = $dropdown.find('.group_to li');
        var index = $dropdown.find('.group_from .selected').index();
                
        myArray.each(function(i){
            if(i < index){
                $(this).addClass('disabled');
                $(this).removeClass('selected');
            }else{
                $(this).removeClass('disabled');
            }  
        })
        if ($dropdown.find('.group_to .selected').index() < index) {
            
            var object_text = $dropdown.find('.group_to li:not(.disabled):first').text();
            
            if($('select.currency').val() != 'RUB'){
                var object_val = $dropdown.find('.group_to li:not(.disabled):first').attr('data-cur');

            }else{
                var object_val = $dropdown.find('.group_to li:not(.disabled):first').attr('data-value');
            }
            
            $dropdown.find('.group_to li:not(.disabled):first').addClass('selected');
            $dropdown.find('input[name*=to]').val(object_val);
            $dropdown.find('.val_to').text(object_text);
        }

    });

    // Option click range
    $(document).on('click.nice_select', '.nice-select.range-click .option:not(.disabled)', function(event) {
        
      var $option = $(this);
      var $dropdown = $option.closest('.nice-select');
      var $group_from = $option.closest('.group_from');
      var $group_to = $option.closest('.group_to');
      
      $group_from.find('.selected').removeClass('selected');
      $group_to.find('.selected').removeClass('selected');
      $option.addClass('selected');
      
      var text = $option.data('display') || $option.text();
      var val = $option.attr('data-value');
      var group = $option.attr('data-group');

      $dropdown.find('.val_'+group).text(text);
      $dropdown.find('input[name*='+group+']').val(val).trigger('change');
        

        var myArray = $dropdown.find('.group_to li');
        var index = $dropdown.find('.group_from .selected').index();
                
        myArray.each(function(i){
            if(i < index){
                $(this).addClass('disabled');
                $(this).removeClass('selected');
            }else{
                $(this).removeClass('disabled');
            }  
        })
        if ($dropdown.find('.group_to .selected').index() < index) {
            
            $dropdown.find('.group_to li:not(.disabled):first').addClass('selected');
            var object = $dropdown.find('.group_to li:not(.disabled):first');
            $dropdown.find('input[name*=to]').val(object.attr('data-value'));
            $dropdown.find('.val_to').text(object.text());
        }

    });

    // Keyboard events
    $(document).on('keydown.nice_select', '.nice-select', function(event) {    
      var $dropdown = $(this);
      var $focused_option = $($dropdown.find('.focus') || $dropdown.find('.list .option.selected'));
      
      // Space or Enter
      if (event.keyCode == 32 || event.keyCode == 13) {
        if ($dropdown.hasClass('open')) {
          $focused_option.trigger('click');
        } else {
          $dropdown.trigger('click');
        }
        return false;
      // Down
      } else if (event.keyCode == 40) {
        if (!$dropdown.hasClass('open')) {
          $dropdown.trigger('click');
        } else {
          var $next = $focused_option.nextAll('.option:not(.disabled)').first();
          if ($next.length > 0) {
            $dropdown.find('.focus').removeClass('focus');
            $next.addClass('focus');
          }
        }
        return false;
      // Up
      } else if (event.keyCode == 38) {
        if (!$dropdown.hasClass('open')) {
          $dropdown.trigger('click');
        } else {
          var $prev = $focused_option.prevAll('.option:not(.disabled)').first();
          if ($prev.length > 0) {
            $dropdown.find('.focus').removeClass('focus');
            $prev.addClass('focus');
          }
        }
        return false;
      // Esc
      } else if (event.keyCode == 27) {
        if ($dropdown.hasClass('open')) {
          $dropdown.trigger('click');
        }
      // Tab
      } else if (event.keyCode == 9) {
        if ($dropdown.hasClass('open')) {
          return false;
        }
      }
    });

    // Detect CSS pointer-events support, for IE <= 10. From Modernizr.
    var style = document.createElement('a').style;
    style.cssText = 'pointer-events:auto';
    if (style.pointerEvents !== 'auto') {
      $('html').addClass('no-csspointerevents');
    }
    
    return this;

  };

}(jQuery));