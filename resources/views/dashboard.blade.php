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

                    <h1>Información sobre los prestamos</h1>
                    <p></p>
                    <h4>Promedio de generos de libros prestados</h4>
                    <h5>Aquí se muestra el genero que los usuarios prefieren</h5>

                    <canvas id="myChart"></canvas>
                    
                </div>
            </div>
        </div>

    </x-app-layout> 
        <x-slot name="script">

        </script>
    </x-slot>
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


