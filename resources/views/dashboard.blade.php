@if (Auth::user()->hasPermissionTo('crud categories'))
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <h1>Usted claramente es admin xd</h1>
                    <p></p>
                    <h4>Ya sabe qué hacer :v</h4>

                   
                </div>
            </div>
        </div>
    </x-app-layout> 
@endif


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1>Pasele a lo barrido</h1>
                <p></p>
                <div align="center" style="margin-bottom: 20px">
                    <img src="{{ asset('img/dashboard/xd.jpg') }}">
                </div>
                <p></p>
                <h4>Para poder comenzar seleccione la categoría a la que desee entrar desde el menú despegable que se mostrará dando click en su nombre de usuario.</h4>
            </div>
        </div>
    </div>
</x-app-layout> 


