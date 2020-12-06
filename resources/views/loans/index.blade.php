<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Libro</th>
                            <th scope="col">Fecha de prestamo</th>
                            <th scope="col">Fecha de retorno</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                @if (isset($loans) && count($loans)>0)
                    @foreach ($loans as $loan)
                      <tr>
                        <th scope="row">{{$loan->id}}</th>
                        <td>{{$loan->books->title}}</td>
                        <td>{{$loan->date_loan}}</td>
                        <td>{{$loan->date_return}}</td>
                        <td>{{$loan->users->name}}</td>
                        <td>
                            @if ($loan->state == 1)
                                Prestado
                            @else
                                Entregado
                            @endif
                        </td>
                        <td class="d-inline-flex p-2 bd-highlight">
                            @if($loan->state == 1)
                            <form action="{{url('loans')}}" method = "POST" >
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="id" value="{{$loan->id}}">
                                <input type="hidden" name="state" value="0">
                                <button type="submit" class="btn btn-primary">Regresar</button>
                            </form>
                            @endif
                        @if(Auth::user()->hasPermissionTo('delete loans'))
                            <button type="button" class="btn btn-warning" onclick="info({{$loan}})" data-toggle="modal" data-target="#infoModal">Detalles</button>
                            <button type="button" class="btn btn-danger" onclick="eliminarPrestamo({{$loan->id}},this)">Eliminar</button>
                            @endif
                        </td>
                      @endforeach
                    </tbody>
                  </table>          
                  @else
                  <td>
                      <h3>No hay prestamos</h3>      
                  </td>
                @endif
            </div>
        </div>
    </div>
    <script>
        function eliminarPrestamo(id,target){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this loan!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            axios.delete('{{ url('loans')}}/'+id, {
                                id: id,
                                _token:'{{ csrf_token() }}'
                            })
                            .then(function (response) {
                                if(response.data.code == "200"){
                                    swal(response.data.message, {
                                        icon: "success",
                                    });
                                }
                                $(target).parent().parent().remove()
                            })
                            .catch(function (error) {
                                console.log(error);
                                swal("Error ocurred",{icon: "error"})
                            });
                          
                        } else {
                            swal("Your loan file is safe!");
                        }
                    });
                }

        function info(loan){
    
           $("#name").text("Nombre: " + loan['users'].name)
           $("#email").text("Email " + loan['users'].email)
           if(loan['users'].role_id == 1)
                $("#role").text("Rol: Administrador")
            else
                $("#role").text("Rol: Cliente")
            $("#title").text("Libro: " + loan['books'].title)
            $("#category").text("Categoría: " + loan['books']['category'].name)
            $("#date_loan").text("Fecha del prestamo: " + loan['date_loan'])
            $("#date_return").text("Fecha de retorno: " + loan['date_return'])
        }

    </script>
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Detalles del prestamo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{url('img/user.png')}}" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-text" id="">Datos del usuario</p>
                      <h5 class="card-title" id="name"></h5>
                      <p class="card-text" id="email"></p>
                      <p class="card-text" id="role"></p>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item" id="title"></li>
                      <li class="list-group-item" id="category"></li>
                      <li class="list-group-item" id="date_loan"></li>
                      <li class="list-group-item" id="date_return"></li>
                    </ul>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
</x-app-layout>
