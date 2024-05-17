<table class="table-auto w-full my-5">
    <tr>
        <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
        <th class="w-2/12 border-2 border-gray-400 px-4 py-2">Дата</th>
        <th class="w-3/12 border-2 border-gray-400 px-4 py-2">Состав</th>
        <th class="w-2/12 border-2 border-gray-400 px-4 py-2">Статус</th>
        @can('order-list')
        <th class="w-1/12 border-2 border-gray-400 px-4 py-2">Составил</th>
        <th class="w-1/12 border-2 border-gray-400 px-4 py-2">Клиент</th>
        @endcan
        <th class="w-2/12 border-2 border-gray-400 px-4 py-2">Действия</th>
    </tr>
    @if(!empty($orders->items()))
        @foreach($orders as $order)
            <tr>
                <td class="border-2 border-gray-400 px-4 py-2">{{$order->id}}</td>
                <td class="border-2 border-gray-400 px-4 py-2">{{\Illuminate\Support\Carbon::parse($order->date_order)->format('d.m.Y H:i')}}</td>
                <td class="border-2 border-gray-400 px-4 py-2">
                    @foreach($order->products as $product)
                        <div class="text-gray-800">
                                        <span>
                                            {{$product->count}} x {{$product->product->name}} @if($product->ingredients->isNotEmpty()):@endif
                                        </span>
                            @if($product->ingredients->isNotEmpty())
                                @foreach($product->ingredients as $ingredient)
                                    <p class="ml-2">
                                        <span>+ {{$ingredient->count}} x </span>
                                        <label class="rounded px-1 bg-green-500 mr-0.5">
                                            {{ $ingredient->ingredient->name }}
                                        </label>
                                        <span>;</span>
                                    </p>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </td>
                <td class="border-2 border-gray-400 px-4 py-2">{{$order->status->name}}</td>
                @can('order-list')
                <td class="border-2 border-gray-400 px-4 py-2">
                    @can('user-list')
                        <x-a body="gray" href="{{ route('users.show', $order->creator->id) }}">
                            {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}
                        </x-a>
                    @else
                        {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}
                    @endcan
                </td>
                <td class="border-2 border-gray-400 px-4 py-2">
                    @if(!empty($order->client))
                        @can('user-list')
                            <x-a body="gray" href="{{ route('users.show', $order->client->id) }}">
                                {{ $order->client->last_name . ' ' . $order->client->first_name . ' ' . $order->client->father_name}}
                            </x-a>
                        @else
                            {{ $order->client->last_name . ' ' . $order->client->first_name . ' ' . $order->client->father_name}}
                        @endcan
                    @else
                        <x-no-data font="font-normal"></x-no-data>
                    @endif
                </td>
                @endcan
                <td class="border-2 border-gray-400 px-4 py-2">
                    <x-a
                        body="info"
                        href="{{ route('orders.show',$order->id) }}"
                    >Посмотреть
                    </x-a>
                    @can('order-edit')
                    <x-a href="{{ route('orders.edit',$order->id) }}">&#128393;</x-a>
                    @endcan
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7"><x-no-data></x-no-data></td>
        </tr>
    @endif
</table>
<x-paginate :paginator="$orders"></x-paginate>
