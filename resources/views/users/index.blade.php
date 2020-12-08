<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class = "col-md-8 col-12">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Usuarios') }}
                </h2>
            </div>
            <div class="col-md-4 col-12">
                <button  type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addUserModal"> 
                    Añadir usuario
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($users) && count($users)>0)
                        @foreach ($users as $user)
                            <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>@if($user->role_id == 1) Administrador @else Cliente @endif</td>
                            <td>
                                <a href="{{url('users/details/'.$user->id)}}" class="btn btn-primary mr-1">Detalles</a>
                                <button type="button" onclick="editar({{$user}})" class="btn btn-warning" data-toggle="modal" data-target="#editUserModal">Editar</button>
                                @if(Auth::user()->id != $user->id)
                                <button type="button" class="btn btn-danger" onclick="eliminarUsuario({{$user->id}},this)">Eliminar</button>   
                                @endif
                            </td>
                            </tr>                       
                        @endforeach
                          @endif
                        </tbody>
                      </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Añadir usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('users')}}">
                    @csrf
                    <div>
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="rol" value="{{ __('Seleccione un rol') }}" />

                        <select name="role_id" id="roles">
                            <option value="1">Administrador</option>
                            <option value="2">Cliente</option>
                          </select>
                    </div>
                       
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('users')}}">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="ename" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="eemail" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>
                    <input type="hidden" name="id" id="userid" value="">
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>


      <script>
        function editar(user){
            $("#userid").val(user['id'])
            $("#ename").val(user['name'])
            $("#eemail").val(user['email'])

        }
    function eliminarUsuario(id,target){
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                axios.delete('{{ url('users')}}/'+id, {
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
                swal("Your user  is safe!");
            }
        });
        }
      </script>
</x-app-layout>
