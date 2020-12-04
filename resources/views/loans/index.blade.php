<x-app-layout>
    <x-slot name="header">
    	<div class="row">
    		<div class="col-md-8 col-12">
    			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
		            {{ __('Loans') }}
		        </h2>
    		</div>
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
				      <th scope="col">User</th>
				      <th scope="col">Book</th>
				      <th scope="col">Date loan</th>
				      <th scope="col">Date return</th>
				      <th scope="col">Status</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@if (isset($loans) && count($loans)>0 && isset($users))
				  	@foreach ($loans as $loan)
				  	
				    <tr>
				      <th scope="row">
				      	{{ $loan->id }}
				      </th>
				      <td>
				      	{{-- {{ $loan->user->name }} --}}
				      </td>
				      <td>
				      	{{-- {{ $loan->book->title }} --}}
				      </td>
				      <td>
				      	{{ $loan->date_loan }}
				      </td>
				      <td>
				      	{{ $loan->date_return }}
				      </td>
				      <td>
				      	{{ $loan->status }}
				      </td>
				      <td>
				      	@if (Auth::user()->hasPermissionTo('add loans') && isset($loans->status) == 1)
				      		<button type="submit" class="btn btn-warning" style="margin-bottom: 5px">
			    				Give back
			    			</button>
				      	@endif

				      	@if (Auth::user()->hasPermissionTo('crud categories'))
					      	<button onclick="editLoan({{ $loan->id }}, '{{ $loan->date_loan }}', '{{ $loan->date_return }}')" style="margin-bottom: 5px" class="btn btn-warning" data-toggle="modal" data-target="#editLoanModal">
					      		Edit Loan
					      	</button>

					      	<button onclick="removeLoan({{ $loan->id }},this)" style="margin-bottom: 5px" class="btn btn-danger">
					      		Remove Loan
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


    <!-- MODAL EDIT LOAN -->

	<div class="modal fade" id="editLoanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit loan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form method="POST" action="{{ url('books') }}" enctype="multipart/form-data">
					@csrf
					@method('PUT');

					<div class="modal-body">

						{{--loan--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Date loan
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" aria-describedby="basic-addon1" id="date_loan">
							</div>
						</div>

						{{--return--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Date return
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" aria-describedby="basic-addon1" id="date_return">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							Save loan
						</button>
						<input type="hidden" name="id" id="id">
					</div>
				</form>
				
			</div>
		</div>
	</div>

	<x-slot name="script">
		<script type="text/javascript">
			function viewLoans(){

				$("#title").val(title)
			}
			
			function editLoan(id,date_loan,date_return){
				$("#id")val(id)
				$("#date_loan")val(date_loan)
				$("#date_return")val(date_return)

			}

			function removeLoan(id,target){
				swal({
				  title: "Are you sure?",
				  text: "Once deleted, you will not be able to recover this user!",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {

				  	axios.delete('{{ url('loans') }}/'+id, {
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

		</script>
    </x-slot>

</x-app-layout>