<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <head>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
        var token = {
            _token: '{{ csrf_token() }}'
        };
        
        var estadisticas = []
        var chart = []
          async function obtenerPrestamos() {
                var datos = [];
                 const response = await axios.get('{{url('loans/stats')}}', token);
                 var datos = response.data;
                 var array = []
                 var array2 = []
                 array.push(Object.values(datos));
                    array.forEach(element => {
                        array.forEach(i => {
                            array2.push(i)
                        });
                    });
                    array2.forEach(element => {
                        element.forEach(x => {
                            estadisticas.push(['"'+[x[0]['books'].title]+'"',x.length])
                        });
                    });

                 }     
                 obtenerPrestamos()

                 console.log(estadisticas)
            $(document).ready(function(){
              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback(drawChart);
            })

              function drawChart() {
        
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                data.addRows(estadisticas);
        
                var options = {'title':'% de préstamos por libro',
                               'width':800,
                               'height':600};
        
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
              }
            </script>
          </head>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div id="chart_div"></div>
            </div>
        </div>
    </div>

    <script>
        
    </script>
</x-app-layout>
