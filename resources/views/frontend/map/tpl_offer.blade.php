<table class="">
    <thead>
        <tr>
            <th>Тип</th>
            <th>Площадь, м²</th>
            <th>Комнат</th>
            <th>Цена, руб.</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$object->type_name}}</td>
            <td>{{$object->area}}</td>
            <td>{{$object->rooms}}</td>
            <td>{{$object->price_in_rub}}</td>
        </tr>
</tbody>

@if(!is_null($image))

    <img src="{{ $image }}" alt="">

@endif