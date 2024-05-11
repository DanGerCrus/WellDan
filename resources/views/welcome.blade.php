<x-app-layout>
    <x-slot name="header">
        <ul class="flex flex-wrap text-sm font-medium text-center" id="tabs">
            <li class="me-2 border-b-2">
                <a class="tab inline-block p-4 rounded-t-lg" @if(!isset($_GET['orders'])) id="default-tab" @endif href="#products">Товары</a>
            </li>
            @auth
            <li class="me-2 border-b-2">
                <a class="tab inline-block p-4 rounded-t-lg" @if(isset($_GET['orders'])) id="default-tab" @endif href="#orders">Заказы</a>
            </li>
            @endauth
        </ul>
    </x-slot>
    <div class="py-12">
        <div id="tab-contents">
            <div class="hidden max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" id="products">
                <form method="GET" action="{{route('welcome')}}"
                      class="rounded-xl shadow bg-gray-100 p-4">
                    <input type="hidden" name="products" value="1">
                    @include('products.datatable-filters')
                </form>
                @include('products.datatable')
            </div>
            @auth
            <div class="hidden max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" id="orders">
                <x-btn
                    body="success"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'order-create-modal')"
                >{{ __('Создать заказ') }}</x-btn>
                <form method="GET" action="{{route('welcome')}}"
                      class="rounded-xl shadow bg-gray-100 p-4">
                    <input type="hidden" name="orders" value="1">
                    @include('orders.datatable-filters')
                </form>
                @include('orders.datatable')
                <x-modal name="order-create-modal" focusable>
                    <x-order-product-form key="0" clone="1" :products="$products_select"
                                          :ingredients="$ingredients_select"></x-order-product-form>
                    <x-product-ingredient-card productKey="0" key="0" clone="1"
                                               :ingredients="$ingredients_select"></x-product-ingredient-card>
                    <section
                        class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md"
                    >
                        <form method="post" action="{{ route('orders.store') }}">
                            @csrf
                            <input type="hidden" name="client_id" value="{{Auth::id()}}">
                            <input type="hidden" name="welcome" value="1">
                            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Товары</h1>
                            <div class="container-line-ProductOrder">
                                <x-order-product-form key="0" :products="$products_select"
                                                      :ingredients="$ingredients_select"></x-order-product-form>
                            </div>
                            <div
                                class="flex items-center gap-4"
                            >
                                <x-primary-button>
                                    {{ __('Сохранить') }}
                                </x-primary-button>
                                <span id="order_price" class="pl-5">0</span><span class="pl-5">руб.</span>
                            </div>
                        </form>
                    </section>
                </x-modal>
            </div>
            @endauth
        </div>
    </div>
</x-app-layout>
<script src="{{asset('/js/OrderForm.js')}}"></script>
<script src="{{asset('/js/ProductIngredientForm.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let tabsContainer = document.querySelector("#tabs");
        let tabTogglers = tabsContainer.querySelectorAll("a.tab");
        tabTogglers.forEach(function(toggler) {
            toggler.addEventListener("click", function(e) {
                e.preventDefault();

                let tabName = this.getAttribute("href");

                let tabContents = document.querySelector("#tab-contents");

                for (let i = 0; i < tabContents.children.length; i++) {

                    tabTogglers[i].parentElement.classList.remove("border-blue-400", "border-b", "opacity-100");  tabContents.children[i].classList.remove("hidden");
                    if ("#" + tabContents.children[i].id === tabName) {
                        continue;
                    }
                    tabContents.children[i].classList.add("hidden");

                }
                e.target.parentElement.classList.add("border-blue-400", "border-b-2", "opacity-100");
            });
        });
        document.getElementById("default-tab").click();
        new OrderForm();
        new ProductIngredientForm();
    })
</script>
