<form action="{{route('basket.store', $id)}}" method="POST">
    @csrf
    <input type="hidden" name="route" value="{{$route}}">
    <x-btn body="info" type="submit">В корзину</x-btn>
</form>
