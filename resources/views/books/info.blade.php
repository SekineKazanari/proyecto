<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Libros > Detalles') }}
        </h2>
    </x-slot>

    <div class="modal-body row max-w-7xl mx-auto sm:px-6 lg:px-8"> 
        <div class="col-md-4">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-20" style="padding-top: 5%">
          @if(isset($book))
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{url('img/books/'.$book[0]->cover)}}" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Titulo: {{$book[0]->title}}</h5>
                  <p class="card-text">Descripcion: {{$book[0]->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Autor: {{$book[0]->autor}}</li>
                  <li class="list-group-item">Paginas: {{$book[0]->pages}}</li>
                  <li class="list-group-item">Editorial: {{$book[0]->editorial}}</li>
                  <li class="list-group-item">Año: {{$book[0]->year}}</li>
                  <li class="list-group-item">ISBN: {{$book[0]->isbn}}</li>
                  <li class="list-group-item">Edicion: {{$book[0]->edition}}</li>
                  <li class="list-group-item">Categoria: {{$book[0]->category->name}}</li>
                </ul>
              </div>
            @endif
          </div>
        </div>

        <div class="col-md-6">
          <div style="padding-top: 5%">
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
  </div>
</x-app-layout>
