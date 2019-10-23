<script>
ymaps.ready(function () {
    var myMap = new ymaps.Map('map_open', {
            center: [{{$cat->geo_lat}},{{$cat->geo_lon}}],
            zoom: 15,
            controls: []
        }, {
            searchControlProvider: 'yandex#search',
            restrictMapArea:[[55.378330586933195,36.33221029101568],[56.10958820847263,38.903011072265684]],
        }),

        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {

        }, {
            iconLayout: 'default#imageWithContent',
            iconImageHref: "{{ asset('assets/images/svg/map_open.svg') }}",
            iconImageSize: [48, 48],
            iconImageOffset: [-24, -40],
        });


    myMap.geoObjects.add(myPlacemark);
});    
</script>