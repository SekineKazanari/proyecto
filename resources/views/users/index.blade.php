<x-app-layout>
    <x-slot name="header">
    	<div class="row">
    		<div class="col-md-8 col-12">
    			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
		            {{ __('Users') }}
		        </h2>
    		</div>

    		@if (Auth::user()->hasPermissionTo('crud categories'))
		    	<div class="col-md-4 col-12">
		    		<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addUserModal">
		    			Add user
		    		</button>
		    	</div>
	    	@endif
    	</div>
    </x-slot>


	<!-- TABLA -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Name</th>
				      <th scope="col">E-Mail</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@if (isset($usres) && count($users)>0)
				  	@foreach ($users as $user)

				    <tr>
				      <th scope="row">
				      	{{ $user->id }}
				      </th>
				      <td>
				      	{{ $user->name }}
				      </td>
				      <td>
				      	{{ $user->email }}
				      </td>
				      <td>
				      	<button type="button" onclick="viewUser({{ $book }}, {{ $category }})" style="margin-bottom: 5px" class="btn btn-primary" data-toggle="modal" data-target="#viewUserModal">
				    		Details
			    		</button>

			    		@if (Auth::user()->hasPermissionTo('crud categories'))
					      	<button onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->password }}')" style="margin-bottom: 5px" class="btn btn-warning" data-toggle="modal" data-target="#editUser
					      		Modal">
					      		Edit User
					      	</button>

					      	<button onclick="removeUser({{ $user->id }},this)" style="margin-bottom: 5px" class="btn btn-danger">
					      		Remove User
					      	</button>
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


    <!-- MODAL ADD USER-->
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add new admin</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form method="POST" action="{{ url('users') }}" onsubmit="return validarRegistro()" enctype="multipart/form-data">
					@csrf

					<div class="modal-body">

						{{--NAME--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Name
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="Name of user" aria-describedby="basic-addon1" name="name">
							</div>
						</div>

						{{--EMAIL--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	E-Mail
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="E-mail of user" aria-describedby="basic-addon1" name="email">
							</div>
						</div>

						{{--PASSWORD--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Password
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="Password" class="form-control" placeholder="*****" aria-describedby="basic-addon1" name="password">
							</div>
						</div>

						{{--CONFIRM PASSWORD--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Confirm password
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="Password" class="form-control" placeholder="*****" aria-describedby="basic-addon1" name="password2">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Cancel
						</button>
						<button type="submit" onsubmit="return validatePass()" class="btn btn-primary">
							Save user
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- MODAL EDIT USER-->
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add new admin</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form method="POST" action="{{ url('users') }}" enctype="multipart/form-data">
					@csrf
					@method('PUT');

					<div class="modal-body">

						{{--NAME--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Name
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="Name of user" aria-describedby="basic-addon1" name="name" id="name">
							</div>
						</div>

						{{--EMAIL--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	E-Mail
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="E-mail of user" aria-describedby="basic-addon1" name="email" id="email">
							</div>
						</div>

						{{--PASSWORD--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Password
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="Password" class="form-control" placeholder="*****" aria-describedby="basic-addon1" name="password" id="password">
							</div>
						</div>

						{{--CONFIRM PASSWORD--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Confirm password
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="Password" class="form-control" placeholder="*****" aria-describedby="basic-addon1" name="password2">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Cancel
						</button>
						<button type="submit" onsubmit="return validatePass()" class="btn btn-primary">
							Save user
						</button>
						<input type="hidden" name="id" id="id">
					</div>
				</form>
			</div>
		</div>
	</div>

	<x-slot name="script">
		<script type="text/javascript">
			function validarRegistro(){
				if ($("#password").val() == $("#password2").val()) {
					return true;
				}else{
					$("#password").addClass('is-invalid')
					$("#password2").addClass('is-invalid')

					swal("", "Las contraseñas no coinciden", "error");

					return false;
				}
			}

			function viewUser(){

				$("#title").val(title)
			}
			
			function editUser(id,name,email,password){
				$("#id")val(id)
				$("#name")val(name)
				$("#email")val(email)
				$("#password")val(password)

			}

			function removeUser(id,target){
				swal({
				  title: "Are you sure?",
				  text: "Once deleted, you will not be able to recover this user!",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {

				  	axios.delete('{{ url('users') }}/'+id, {
					    id: id,
					    _token: '{{ csrf_token() }}'
					  })
					  .then(function (response) {
					    console.log(response);
					    if (response.data.code==200) {
					    	swal(response.data.message, {
								    icon: "success",
							    });

					    	$(target).parent().parent().remove();

					    }else{
					    	swal(response.data.message, {
								    icon: "error",
							    });
					    }
					  })
					  .catch(function (error) {
					    console.log(error);
					    swal('Error ocurred',{ icon:'error' })
					  });
				  }
				});
			}

			function loanBook(){
				$("#status") == 1;

			}

		</script>
    </x-slot>

</x-app-layout>