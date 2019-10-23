<div style="background:#999">{{ $object->id }}</div>
<div style="background:#999">{{ $object->name }}</div>
<div style="background:#999">{{ $object->address }}</div>
<div style="background:#999">{{ $object->subway->city_district }}</div>


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
    @foreach($object->offers as $k=>$offer)
        @if ($k>2)
            @break
        @endif
        <tr>
            <td>{{$offer->type_name}}</td>
            <td>{{$offer->area}}</td>
            <td>{{$offer->rooms}}</td>
            <td>{{$offer->price_in_rub}}</td>
        </tr>
    @endforeach
</tbody>

@if(!is_null($image))

    <img src="{{ $image }}" alt="">

@endif