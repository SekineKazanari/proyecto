<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuario > detalles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if(isset($user))
                <div class="card" style="width: 18rem;">
                    <img src="{{url('img/user.png')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Nombre: {{$user[0]->name}}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Email: {{$user[0]->email}}</h6>
                      <p class="card-text">Rol: @if($user[0]->role_id == 1) Administrador @else Cliente @endif</p>
                    </div>
                  </div>
                @endif
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Libro</th>
                            <th scope="col">Fecha de prestamo</th>
                            <th scope="col">Fecha de retorno</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($loans) && count($loans)>0)
                        @foreach ($loans as $loan)
                        <tr>
                          <th scope="row">{{$loan->id}}</th>
                          <td>{{$loan->books->title}}</td>
                          <td>{{$loan->date_loan}}</td>
                          <td>{{$loan->date_return}}</td>
                          <td>
                              @if($loan->state == 1)
                                    Prestado
                              @else
                                    Devuelto
                              @endif
                          </td>
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
                @else
                <h3>No hay prestamos</h3>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
