/*
    jQuery Masked Input Plugin
    Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
    Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
    Version: 1.4.1
*/
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});

/*
 Sticky-kit v1.1.2 | WTFPL | Leaf Corcoran 2015 | http://leafo.net
*/
(function(){var b,f;b=this.jQuery||window.jQuery;f=b(window);b.fn.stick_in_parent=function(d){var A,w,J,n,B,K,p,q,k,E,t;null==d&&(d={});t=d.sticky_class;B=d.inner_scrolling;E=d.recalc_every;k=d.parent;q=d.offset_top;p=d.spacer;w=d.bottoming;null==q&&(q=0);null==k&&(k=void 0);null==B&&(B=!0);null==t&&(t="is_stuck");A=b(document);null==w&&(w=!0);J=function(a,d,n,C,F,u,r,G){var v,H,m,D,I,c,g,x,y,z,h,l;if(!a.data("sticky_kit")){a.data("sticky_kit",!0);I=A.height();g=a.parent();null!=k&&(g=g.closest(k));
if(!g.length)throw"failed to find stick parent";v=m=!1;(h=null!=p?p&&a.closest(p):b("<div />"))&&h.css("position",a.css("position"));x=function(){var c,f,e;if(!G&&(I=A.height(),c=parseInt(g.css("border-top-width"),10),f=parseInt(g.css("padding-top"),10),d=parseInt(g.css("padding-bottom"),10),n=g.offset().top+c+f,C=g.height(),m&&(v=m=!1,null==p&&(a.insertAfter(h),h.detach()),a.css({position:"",top:"",width:"",bottom:""}).removeClass(t),e=!0),F=a.offset().top-(parseInt(a.css("margin-top"),10)||0)-q,
u=a.outerHeight(!0),r=a.css("float"),h&&h.css({width:a.outerWidth(!0),height:u,display:a.css("display"),"vertical-align":a.css("vertical-align"),"float":r}),e))return l()};x();if(u!==C)return D=void 0,c=q,z=E,l=function(){var b,l,e,k;if(!G&&(e=!1,null!=z&&(--z,0>=z&&(z=E,x(),e=!0)),e||A.height()===I||x(),e=f.scrollTop(),null!=D&&(l=e-D),D=e,m?(w&&(k=e+u+c>C+n,v&&!k&&(v=!1,a.css({position:"fixed",bottom:"",top:c}).trigger("sticky_kit:unbottom"))),e<F&&(m=!1,c=q,null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),
h.detach()),b={position:"",width:"",top:""},a.css(b).removeClass(t).trigger("sticky_kit:unstick")),B&&(b=f.height(),u+q>b&&!v&&(c-=l,c=Math.max(b-u,c),c=Math.min(q,c),m&&a.css({top:c+"px"})))):e>F&&(m=!0,b={position:"fixed",top:c},b.width="border-box"===a.css("box-sizing")?a.outerWidth()+"px":a.width()+"px",a.css(b).addClass(t),null==p&&(a.after(h),"left"!==r&&"right"!==r||h.append(a)),a.trigger("sticky_kit:stick")),m&&w&&(null==k&&(k=e+u+c>C+n),!v&&k)))return v=!0,"static"===g.css("position")&&g.css({position:"relative"}),
a.css({position:"absolute",bottom:d,top:"auto"}).trigger("sticky_kit:bottom")},y=function(){x();return l()},H=function(){G=!0;f.off("touchmove",l);f.off("scroll",l);f.off("resize",y);b(document.body).off("sticky_kit:recalc",y);a.off("sticky_kit:detach",H);a.removeData("sticky_kit");a.css({position:"",bottom:"",top:"",width:""});g.position("position","");if(m)return null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.remove()),a.removeClass(t)},f.on("touchmove",l),f.on("scroll",l),f.on("resize",
y),b(document.body).on("sticky_kit:recalc",y),a.on("sticky_kit:detach",H),setTimeout(l,0)}};n=0;for(K=this.length;n<K;n++)d=this[n],J(b(d));return this}}).call(this);

//плагин для разбития списка на группы с сохранением индекса
(function($) {
    var defaults = {
        columns: 4,
        classname: 'district-list__items_item',
        min: 1
    };
    $.fn.autocolumnlist = function(params){
        var options = $.extend({}, defaults, params);
        return this.each(function() {
            var data_parameters = $(this).data();
            if ( data_parameters ) {
                $.each(data_parameters, function (key, value) {
                    options[key] = value;
                });
            }
            var els = $(this).find('> li');
            var dimension = els.length;
            if (dimension > 0) {
                var elCol = Math.ceil(dimension/options.columns);
                if (elCol < options.min) {
                    elCol = options.min;
                }
                var start = 0;
                var end = elCol;
                
                for (i=0; i<options.columns; i++) {
                    if ((i + 1) == options.columns) {
                        els.slice(start, end).wrapAll('<div class="'+options.classname+' last" />');
                    } else {
                            els.slice(start, end).wrapAll('<div class="'+options.classname+'" />');
                    }
                    start = start+elCol;
                    end = end+elCol;
                }
            }
        });
    };
})(jQuery);
//END

$(function() { 
	
	//инициализация липкого блока в новостях
	$('aside').stick_in_parent({
		// Отступ сверху
		offset_top: 79,
	});

    //инициализируем плагин разбития списка на группы
    $('#tab2, #tab3').autocolumnlist({columns: 3});
    
    if ($(window).width() < 992){
        $('.li-items').autocolumnlist({columns: 1});   
    }
    else{
        $('.li-items').autocolumnlist({columns: 2});
    }
    
    //owl-slider
        
        $('.home-slider-1').owlCarousel({
            animateOut: 'fadeOut',
            loop:true,
            margin:0,
            onInitialized: counter,
            onTranslated: counter,
            nav:true,
            mouseDrag:false,
            navText: ['<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>'],
            items:1

        })

        $('.home-slider-2').owlCarousel({
            animateOut: 'fadeOut',
            loop:true,
            margin:0,
            dots:false,
            nav:true,
            mouseDrag:false,
            navText: ['<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>'],
            items:1

        })

        $('.owl-new').owlCarousel({
            loop:false,
            margin:15,
            nav:true,
            mouseDrag:false,
            navText: ['<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                667:{
                    items:2
                },
                992:{
                    items:3
                }
            }

        })
    
        $('.owl-plan').owlCarousel({
            loop:false,
            margin: 10,
            dots:false,
            nav:true,
            navText: ['<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:2
                },
                768:{
                    items:3
                }
            }

        })
    
        var owl = $('.owl-open').owlCarousel({
            loop:true,
            center:true,
            margin:0,
            dots:false,
            nav:false,
            navText: ['<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>'],
            items:1,
			onInitialized : addFancy

        })
		//не выводим в fancybox клонированные слайды, чтобы небыло повторов
		function addFancy(event) {
		  var element = event.target;
		  var id = $(element).attr('id');
		  $(element).find(".owl-item.cloned a").each(function(indexCloned) {
			var $clonedElem = $(this);
			var link = $clonedElem.attr('href');
			$clonedElem.attr('data-fancybox-trigger', id);
			$clonedElem.attr('href', 'javascript:;');
			$clonedElem.removeAttr('data-fancybox');
			$(element).find(".owl-item:not(.cloned) a").each(function(indexReal) {
			  if (link === $(this).attr('href')){
				$clonedElem.attr('data-fancybox-index', indexReal);
			  }
			});
		  });
		}
		//END
        owl.on('click', '.item', function (property) {
            var $currentItem = $(property.target).closest('.owl-item');
            var $activeItems = owl.find('.active');
            if ($currentItem.index() - $($activeItems[0]).index() <= $activeItems.length / 2 - 1)
            {
                owl.trigger('prev.owl');
            }
            else if ($($activeItems[$activeItems.length - 1]).index() - $currentItem.index() <= $activeItems.length / 2 - 1)
            {
                owl.trigger('next.owl');
            }
        });
	
	
        
    //END
    
    //счетчик кол-вы слайдов на главной странице
    function counter(event) {
        var element = event.target;
        var items = event.item.count;
        var item = event.page.index + 1;
        if (item == 0) {
            item = 1;
        }
        $('#counter').html("" + item + "/" + items)
    }
    //END
    
    //инициализируем плагин nice select
    $('select').niceSelect();

    //мобильное меню
    $('#checkbox').change(function(){
          if($(this).prop('checked')){
              $('.mob_menu').addClass('active');
          }else{
              $('.mob_menu').removeClass('active');
          }
    })
    //END
    
    //фиксированное меню
    $(window).scroll(function () {
        var scrolled = window.pageYOffset || document.documentElement.scrollTop;
        if (scrolled > 25) $('.nav_fixed').addClass('sticky');
        else $('.nav_fixed').removeClass('sticky');
    });
    //END

    //подменяем значение "не выбрано" названием селекта     
    if($('#finish').val() == ''){
        $('#finish').closest('.change_name').find('.current').addClass('deselect');     
    }
    if($('#type').val() == ''){
        $('#type').closest('.change_name').find('.current').addClass('deselect');     
    }
    $('#finish, #type').change(function(){
        if($(this).val() == ''){
            $(this).closest('.change_name').find('.current').addClass('deselect');
        }else{
            $(this).closest('.change_name').find('.current').removeClass('deselect');
        }
    })
    //END
    
    //Вкладки и аккордион в footer
    tabControl();

    var resizeTimer;
    $(window).on('resize', function(e) {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        tabControl();
      }, 250);
    });

    function tabControl() {
      var tabs = $('.footer-tabs-content').find('.tabs-nav');
      if(tabs.is(':visible')) {
        tabs.find('a').on('click', function(event) {
          event.preventDefault();
          var target = $(this).attr('href'),
              tabs = $(this).parents('.tabs-nav'),
              buttons = tabs.find('a'),
              itemTab = tabs.parents('.footer-tabs-content').find('.itemTab');
          buttons.removeClass('active');
          itemTab.removeClass('active');
          $(this).addClass('active');
          $(target).addClass('active');
        });
      } else {
        $('.itemTab').on('click', function() {
          var container = $(this).parents('.footer-tabs-content'),
              currId = $(this).attr('id'),
              items = container.find('.itemTab');
          container.find('.tabs-nav a').removeClass('active');
          items.removeClass('active');
          $(this).addClass('active');
          container.find('.tabs-nav a[href$="#'+ currId +'"]').addClass('active');
        });
      } 
    }
    //END
    
    //маска ввода телефона
    $(".mask").mask("+7 (999) 999-99-99");
    //END
    
    //Вкладки на странице объекта
    $('.itemTabOpen').on('click', function() {
        var container = $(this).parents('.tabs_content'),
            items = container.find('.itemTabOpen');
        items.removeClass('active');
        $(this).addClass('active');
    });
    //END
    
    //показать еще в footer  
    $('.half').each(function(){
        
        var countLi = $(this).find('li').size();
        
        if(countLi < 21){
            $(this).find('.show-hide-btn').hide();
        }

    });
    
    $('.show-hide-btn').click(function(event){
        $(this).closest('.half').find('.li-items li:nth-child(n+11)').slideToggle('');
    });   
    //END
    
    $('.form-input').focus(function(){
      $(this).parents('.form-group').addClass('focused');
    });

    $('.form-input').blur(function(){
      var inputValue = $(this).val();
      if ( inputValue == "" ) {
        $(this).parents('.form-group').removeClass('focused');  
      } 
    })  
	
	//Вкладки в фильтре district
    $('.tab_content').hide();
    $('.tab_content:first').show();
    $('.tabs li:first').addClass('active');
    $('.tabs li').click(function(event) {
//		$(this).on('click', false);
		
        $('.tabs li').removeClass('active');
        $(this).addClass('active');
        $('.tab_content').hide();
        var selectTab = $(this).attr("data-content");
        $(selectTab).fadeIn();
    });
	// отмечаем только одну группу чекбоксов
	$("#district-list input[name='districts[]']").on("change", function(e) {
		var parentDiv = $(this).parents('.tab_content').attr("id");
		console.log(parentDiv);
		$("#district-list input:checkbox").not("#"+parentDiv+" input:checkbox").prop('checked', false);
		$("#imap .district").not("#"+parentDiv+" .district").removeClass('checked');
	});
    //END
	
	//отмечаем чекбоксы по клику на карту округов
    $('#imap .district').click(function(event){
        var check = $(this).attr('data-for');
        var checkbox = $('.value_data input#'+check);
        
        if (checkbox.is(':checked')){
            checkbox.prop('checked', false).trigger('change');
            $(this).removeClass('checked');
        } else {
            checkbox.prop('checked', true).trigger('change');
            $(this).addClass('checked');
        }
    });
    //END
    
    //снимаем чекбоксы при клике на reset
    $('#district-list .reset').click(function(event){
        $('#district-list input:checkbox').prop('checked', false).trigger('change');
        $('#imap .district').removeClass('checked');
        $('.tabs li').removeClass('active');
        $('.tabs li:first').addClass('active');
        $('.tab_content').hide();
        $('.tab_content:first').show();
        
    });
    //END
	
	//счетчик на кнопке
    var filterEvent = function () {
        if (filterEvent.timeout !== undefined) {
                clearTimeout(filterEvent.timeout);
        }
        filterEvent.timeout = setTimeout(function() {    
            $filter = $('#filter');
            var districts = new Array();
            $('input[name="districts[]"]:checked').each(function() {

                districts.push($(this).val());

            });

            var data = {
                _token: $("input[name='_token']").val(),
                currency: $filter.find('select[name=currency]').val(),
                type: $filter.find('select[name=type]').val(),
                finish: $filter.find('select[name=finish]').val(),
                districts: districts,
                price_from: $filter.find('input[name=price_from]').val(),
                price_to: $filter.find('input[name=price_to]').val(),
                area_from: $filter.find('input[name=area_from]').val(),
                area_to: $filter.find('input[name=area_to]').val(),
            }

            var ajax_url = $filter.find('input[name=ajax]').val();
           
            console.log(data);
            $.ajax({
               url: ajax_url,
               type:'POST',
               data: data,
               success: function(data) {
                   if(data == 0){
                       $filter.find('button').attr('disabled', 'disabled').addClass('disabled');
                   }else{
                       $filter.find('button').removeAttr("disabled").removeClass('disabled');
                   }
                   $filter.find('button span').html(data);
               }
           });

        }, 200);
    };
    
    $( "#filter .count" ).change(function() {
        filterEvent();
    });
	//END
	
	//показать/скрыть текст в карточке объекта
	$('.text .all').click(function(e){
		$(this).toggleClass('open');
		$('.text .hidden').slideToggle(); 
	});
    //END
	
	//отправка формы заявки
    $('.btn-send').click(function(e){
        e.preventDefault();
        var formSend = $(this.form);
		
        var data = {
            _token: $("input[name='_token']").val(),
            subject: formSend.find('input[name=subject]').val(),
            broker: formSend.find('input[name=broker]').val(),
            name: formSend.find('input[name=name]').val(),
            phone: formSend.find('input[name=phone]').val(),
			status: formSend.find('input[name=status]').val(),
            email: formSend.find('input[name=email]').val(),
            text: formSend.find('textarea[name=text]').val(),     
        }
		console.log(data);
        $.ajax({
            url: $(this.form).attr('action'),
            type:'POST',
            data: data,
            success: function(data) { 
                if($.isEmptyObject(data) == false){   
                    if($.isEmptyObject(data['name']) == false){
                        formSend.find('input[name=name]').addClass('error').siblings('span.valid').text(data['name']);
                    }
                    if($.isEmptyObject(data['phone']) == false){
                        formSend.find('input[name=phone]').addClass('error').siblings('span.valid').text(data['phone']);
                    }
                    if($.isEmptyObject(data['email']) == false){
                        formSend.find('input[name=email]').addClass('error').siblings('span.valid').text(data['email']);
                    }
					setTimeout(function () {
						formSend.find('.error').removeClass('error');
						formSend.find('span.valid').text('');
					}, 6000);
					
                }else{
                    formSend.find('input[name=name]').val('');
                    formSend.find('input[name=phone]').val('');
                    formSend.find('input[name=email]').val('');
                    formSend.find('textarea[name=text]').val('');
					formSend.find('.success').addClass('active');
					
					//цели от метрики
					if(formSend.attr('name') == 'callme'){
						yaCounter55078375.reachGoal('callback');
					}else if(formSend.attr('name') == 'subscribe'){
						yaCounter55078375.reachGoal('subscribe');
					}else if(formSend.attr('name') == 'view'){
						yaCounter55078375.reachGoal('view');
					}else if(formSend.attr('name') == 'price_view'){
						yaCounter55078375.reachGoal('price_view');
					}else if(formSend.attr('name') == 'plan'){
						yaCounter55078375.reachGoal('plan');
					}
					
					setTimeout(function () {
                        $.fancybox.close();
						formSend.find('.success').removeClass('active');
					}, 3000);
                }

            }
        });
        
    });
	
    $('input').focus(function() {
        $(this).removeClass('error').siblings('span.valid').text('');
    });
	//end отправка формы заявки
	
	//сортировка
    $('#sort').change(function(e){
		location.href = $(this).val();
    });
	//END
	
	//изменение валюты в карточке товара
    $('#currency_open').change(function(e){
		
		$('#price_open b').removeClass('active');
		$('#price_open .'+$(this).val()).addClass('active');

    });
	//END
	
	//плавный скрол по ссылке
	$('a[href^="#"], *[data-href^="#"]').on('click', function(e){
        e.preventDefault();
        var t = 1000;
        var d = $(this).attr('data-href') ? $(this).attr('data-href') : $(this).attr('href');
        $('html,body').stop().animate({ scrollTop: $(d).offset().top - 178}, t);
    });
	//END
	
	//показать еще 
	$("#all_offers").on("change", function() {
		  	
		if($('#all_offers').prop('checked')){
			$('.open_offers__items.offer:nth-child(n+8)').slideDown({
																	  start: function () {
																		$(this).css({
																		  display: "flex"
																		})
																	  }
																	});
			$('#show_all span').text('Скрыть');
		}else{
			$('.open_offers__items.offer:nth-child(n+8)').slideUp();
			$('#show_all span').text('Показать еще');
		}
	});
	
	if($('.open_offers__items.offer').length <= 5){
		$('.open_offers__items_item.button').hide();
	}else{
		$('.open_offers__items_item.button').show();
	}
	//END
	
	//Подстановка темы в форму при запросе планировки
	$('.plan_send').click(function(e){
		
		$('#planirovka input[name="subject"]').val($(this).attr('data-lot'));
		
	});
    //END
});

