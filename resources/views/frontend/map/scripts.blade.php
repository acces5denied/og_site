<script>
    ymaps.ready(function () {
        
		var myMap = new ymaps.Map('allPlacemarks', { // ID блока с картой
				center: [55.76, 37.64],
                zoom: 10,
                controls: [],
			},{
                minZoom: 9,
                maxZoom: 17,
            }),
			objectManager = new ymaps.ObjectManager({
				clusterize: true,
                gridSize: 50,

			});
		// Задаём опции кластеров
		objectManager.clusters.options.set({
			// Установим дизайн метки по умолчанию:
//			preset: 'islands#yellowClusterIcons',
            // Макет метки кластера pieChart.
            clusterIconLayout: 'default#pieChart',
            // Радиус диаграммы в пикселях.
            clusterIconPieChartRadius: 23,
            // Радиус центральной части макета.
            clusterIconPieChartCoreRadius: 20,
            // Ширина линий-разделителей секторов и внешней обводки диаграммы.
            clusterIconPieChartStrokeWidth: 0,
            // Цвет метки кластера
            clusterIconColor: '#000',
			// Установим балун кластера в виде карусели 
			balloonContentLayout: 'cluster#balloonCarousel', 
			// Устанавливаем максимальное количество элементов в нижней панели на одной странице
			clusterBalloonPagerSize: 5,
			// Устанавливаем режим открытия балуна. 
			// В данном примере балун никогда не будет открываться в режиме панели.
			clusterBalloonPanelMaxMapArea: 0,
			// Устанавливаем ширину макета контента балуна.
			balloonContentLayoutWidth: 300,
			// Устанавливаем высоту макета контента балуна.
			balloonContentLayoutHeight: 300,
            
            
		});
        
        objectManager.objects.options.set({
            iconLayout: 'default#imageWithContent',
            iconImageHref: "{{ asset('assets/images/svg/map_open.svg') }}",
            iconImageSize: [48, 48],
            iconImageOffset: [-24, -48]
        });
        
        // Подрубаем монитор, 
		// будем отслеживать изменения в кластерах
		var activeObjectMonitor = new ymaps.Monitor(objectManager.clusters.state);
		// При клике на некластеризованные объекты получаем содержимое балуна
		objectManager.objects.events.add('click', function (e) {
			var objectId = e.get('objectId');
			setBalloonData(objectId);
		});
		// В кластеризованных объектах отслеживаем изменение выбранного объекта
		activeObjectMonitor.add('activeObject', function () {
			var objectId = activeObjectMonitor.get('activeObject').id;
			setBalloonData(objectId);
		});
		// Проверяем, есть ли у выбранного объекта содержимое балуна
		function hasBalloonData(objectId) {
			return objectManager.objects.getById(objectId).properties.balloonContent;
		}
		// Получаем данные и устанавливаем содержимое балуна
		function setBalloonData(objectId) {
			if (!hasBalloonData(objectId)) {
				getBalloonData(objectId).done(function (data) {
					var object = objectManager.objects.getById(objectId);
					object.properties.balloonContent = data;
					// Открываем балун на этом элементе
					var objectState = objectManager.getObjectState(objectId);
					if (objectState.isClustered) {
						// Если это кластер
						objectManager.clusters.balloon.open(objectState.cluster.id);
					}
					else {
						// Если обычный объект
						objectManager.objects.balloon.open(objectId);
					}
				});
			}
		}
        
        // Добавляем objectManager на карту
		myMap.geoObjects.add(objectManager);
        

        
       var filterMap = function () {

            $filter = $('#filter_map');
		   
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
            
            console.log(data);
            $.ajax({
                url: '{{route('frontend.map.ajax')}}',
                type:'POST',
                data: data,
                success: function(data) {
                    objectManager.removeAll();
                    objectManager.add(data);   
                }
            });
        };
        
        filterMap(); 
        
        $( "#filter_map .count" ).change(function() {
            
            filterMap();
            
        });

        
        // Функция, осуществляющая запрос за данными балуна на сервер.
		function getBalloonData(objectId) {
			var dataDeferred = ymaps.vow.defer();
			$.ajax({
					url: '{{route('frontend.map.content')}}',
					type: 'POST',
					data: {
						id: objectId, // Обязательная переменная
						_token: $("input[name='_token']").val(),
                        
					},
				})
				.done(function (data) {
                    
					dataDeferred.resolve(data['balloonContent']);
				})
				.fail(function () {
					dataDeferred.resolve('error');
				});
			return dataDeferred.promise();
		}
        

        
	});

</script>
