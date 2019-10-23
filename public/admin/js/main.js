$(document).ready(function () {
    
    $('.general-img').fileuploader({
        extensions: ['jpg', 'jpeg', 'png'],
        limit: 1,
        fileMaxSize: 2,
        changeInput: ' ',
        theme: 'thumbnails',
        enableApi: true,
        addMore: true,
        thumbnails: {
            box: '<div class="fileuploader-items">' +
                '<ul class="fileuploader-items-list">' +
                '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                '</ul>' +
                '</div>',
            item: '<li class="fileuploader-item">' +
                '<div class="fileuploader-item-inner">' +
                '<div class="type-holder">${extension}</div>' +
                '<div class="actions-holder">' +
                '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                '</div>' +
                '<div class="thumbnail-holder">' +
                '${image}' +
                '</div>' +
                '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                '</div>' +
                '</li>',
            item2: '<li class="fileuploader-item">' +
                '<div class="fileuploader-item-inner">' +
                '<div class="type-holder">${extension}</div>' +
                '<div class="actions-holder">' +
                '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                '</div>' +
                '<div class="thumbnail-holder">' +
                '${image}' +
                '</div>' +
                '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                '</div>' +
                '</li>',
            startImageRenderer: true,
            canvasImage: false,
            _selectors: {
                list: '.fileuploader-items-list',
                item: '.fileuploader-item',
                start: '.fileuploader-action-start',
                retry: '.fileuploader-action-retry',
                remove: '.fileuploader-action-remove'
            },
            onItemShow: function (item, listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();

                if (item.format == 'image') {
                    item.html.find('.fileuploader-item-icon').hide();
                }
            },
            onItemRemove: function (html, listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                html.children().animate({
                    'opacity': 0
                }, 200, function () {
                    html.remove();

                    if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                        plusInput.show();
                });
            }
        },
        dragDrop: {
            container: '.fileuploader-thumbnails-input'
        },
        listInput : 'general_photo',
        afterRender: function (listEl, parentEl, newInputEl, inputEl) {
            var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                api = $.fileuploader.getInstance(inputEl.get(0));

            plusInput.on('click', function () {
                api.open();
            });
        },
    });


    $('.multi-img').fileuploader({
        extensions: ['jpg', 'jpeg', 'png'],
        limit: 10,
        fileMaxSize: 2,
        changeInput: ' ',
        theme: 'thumbnails',
        enableApi: true,
        addMore: true,
        thumbnails: {
            box: '<div class="fileuploader-items">' +
                '<ul class="fileuploader-items-list">' +
                '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                '</ul>' +
                '</div>',
            item: '<li class="fileuploader-item">' +
                '<div class="fileuploader-item-inner">' +
                '<div class="type-holder">${extension}</div>' +
                '<div class="actions-holder">' +
                '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                '</div>' +
                '<div class="thumbnail-holder">' +
                '${image}' +
                '</div>' +
                '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                '</div>' +
                '</li>',
            item2: '<li class="fileuploader-item">' +
                '<div class="fileuploader-item-inner">' +
                '<div class="type-holder">${extension}</div>' +
                '<div class="actions-holder">' +
                '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                '</div>' +
                '<div class="thumbnail-holder">' +
                '${image}' +
                '</div>' +
                '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                '</div>' +
                '</li>',
            startImageRenderer: true,
            canvasImage: false,
            _selectors: {
                list: '.fileuploader-items-list',
                item: '.fileuploader-item',
                start: '.fileuploader-action-start',
                retry: '.fileuploader-action-retry',
                remove: '.fileuploader-action-remove'
            },
            onItemShow: function (item, listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();

                if (item.format == 'image') {
                    item.html.find('.fileuploader-item-icon').hide();
                }
            },
            onItemRemove: function (html, listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                html.children().animate({
                    'opacity': 0
                }, 200, function () {
                    html.remove();

                    if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                        plusInput.show();
                });
            }
        },
        dragDrop: {
            container: '.fileuploader-thumbnails-input'
        },
        afterRender: function (listEl, parentEl, newInputEl, inputEl) {
            var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                api = $.fileuploader.getInstance(inputEl.get(0));

            plusInput.on('click', function () {
                api.open();
            });
        },
        onListInput: function(list, item, fileList, listInputEl, listEl, parentEl, newInputEl, inputEl) {


            return list;
        },
    });

});
