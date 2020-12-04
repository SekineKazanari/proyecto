<x-app-layout>
    <x-slot name="header">
    	<div class="row">
    		<div class="col-md-8 col-12">
    			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
		            {{ __('Books') }}
		        </h2>
    		</div>
    		
    		@if (Auth::user()->hasPermissionTo('crud categories'))
		    	<div class="col-md-4 col-12">
		    		<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookModal">
		    			Add Book
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
				      <th scope="col">Title</th>
				      <th scope="col">Description</th>
				      <th scope="col">Category</th>
				      <th scope="col">Status</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@if (isset($books) && count($books)>0)
				  	@foreach ($books as $book)
				  	
					    <tr>
					      <th scope="row">
					      	{{ $book->id }}
					      </th>
					      <td>
					      	{{ $book->title }}
					      </td>
					      <td>
					      	{{ $book->description }}
					      </td>
					      <td>
					      	{{ $book->category_id }}
					      </td>
					      <td>
					      	@if($book->status == 0)
					      		<p>Disponible</p>
					      	@endif
					      	@if($book->status == 1)
					      		<p>Ocupado</p>
					      	@endif
					      </td>

					      <td>

					      	@if (Auth::user()->hasPermissionTo('add loans') && isset($loans))
					      		@if ($book->status == 0)
					      			<form action="{{url('loan')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" style="margin-bottom: 5px">
						    				Loan
						    			</button>
                                        <input type="hidden" name="id" value="{{$book->id}}">
                                    </form>
					    		@endif
						    @endif

					    	@if (Auth::user()->hasPermissionTo('crud categories'))
					    		<button type="button" class="btn btn-info" style="margin-bottom: 5px" data-toggle="modal" data-target="#loanBookModalAdmin">
					    			Loans
					    		</button>
					    	@endif

					      	<button type="button" onclick="viewBook({{ $book }}, {{ $book->category }})" style="margin-bottom: 5px" class="btn btn-primary" data-toggle="modal" data-target="#viewBookModal">
				    			Details
				    		</button>

				    		

				    		@if (Auth::user()->hasPermissionTo('crud categories'))
						      	<button onclick="editBook({{ $book->id }}, '{{ $book->title }}', '{{ $book->description }}', '{{ $book->year }}', '{{ $book->pages }}', '{{ $book->isbn }}', '{{ $book->editorial }}', '{{ $book->edition }}', '{{ $book->autor }}', '{{ $book->category_id }}')" style="margin-bottom: 5px" class="btn btn-warning" data-toggle="modal" data-target="#editBookModal">
						      		Edit Book
						      	</button>

						      	<button onclick="removeBook({{ $book->id }},this)" style="margin-bottom: 5px" class="btn btn-danger">
						      		Remove Book
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


    <!-- MODAL ADD BOOK-->

	<div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add new book</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form method="POST" action="{{ url('books') }}" enctype="multipart/form-data">
					@csrf

					<div class="modal-body">

						{{--TITLE--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Title
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="Book title" aria-label="book" aria-describedby="basic-addon1" name="title">
							</div>
						</div>

						{{--DESCRIPTION--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Description
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <textarea class="form-control" cols="5" placeholder="Wriye here a description" name="description">
							  </textarea>
							</div>
						</div>

						{{--YEAR--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Year
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="number" class="form-control" placeholder="1999" name="year">
							</div>
						</div>

						{{--PAGES--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Pages
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="number" class="form-control" placeholder="600" name="pages">
							</div>
						</div>

						{{--ISBN--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	ISBN
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="libro2.png" name="isbn">
							</div>
						</div>

						{{--EDITORIAL--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Editorial
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="IVREA" name="editorial">
							</div>
						</div>

						{{--EDITION--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Edition
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="number" class="form-control" placeholder="2" name="edition">
							</div>
						</div>

						{{--AUTOR--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Autor
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="Kagune Maruyama" name="autor">
							</div>
						</div>

						{{--COVER--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Cover
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="file" class="form-control" name="cover">
							</div>
						</div>

						{{--CATEGORY--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Category
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <select class="form-control" name="category_id">
							  	
							  	@if (isset($categories) && count($categories)>0)
							  	@foreach ($categories as $category)

							  		<option value="{{ $category->id }}">
							  			{{ $category->name }}
							  		</option>

							  	@endforeach
							  	@endif

							  </select>
							</div>
						</div>



					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							Save book
						</button>
					</div>
				</form>
				
			</div>
		</div>
	</div>

	<!-- MODAL EDIT BOOK-->

	<div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit book</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form method="POST" action="{{ url('books') }}">
					@csrf
					@method('PUT');

					<div class="modal-body">

						{{--TITLE--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Title
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="Book title" aria-label="book" aria-describedby="basic-addon1" name="title" id="title">
							</div>
						</div>

						{{--DESCRIPTION--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Description
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <textarea class="form-control" cols="5" placeholder="Write here a description" name="description" id="description">
							  </textarea>
							</div>
						</div>

						{{--YEAR--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Year
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="number" class="form-control" placeholder="1999" name="year" id="year">
							</div>
						</div>

						{{--PAGES--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Pages
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="number" class="form-control" placeholder="600" name="pages" id="pages">
							</div>
						</div>

						{{--ISBN--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	ISBN
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="libro2.png" name="isbn" id="isbn">
							</div>
						</div>

						{{--EDITORIAL--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Editorial
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="IVREA" name="editorial" id="editorial">
							</div>
						</div>

						{{--EDITION--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Edition
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="number" class="form-control" placeholder="2" name="edition" id="edition">
							</div>
						</div>

						{{--AUTOR--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Autor
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="text" class="form-control" placeholder="Kagune Maruyama" name="autor" id="autor">
							</div>
						</div>

						{{--CATEGORY--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Category
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <select class="form-control" name="category_id" id="category_id">
							  	
							  	@if (isset($categories) && count($categories)>0)
							  	@foreach ($categories as $category)

							  		<option value="{{ $category->id }}">
							  			{{ $category->name }}
							  		</option>

							  	@endforeach
							  	@endif

							  </select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Cancel
						</button>
						<button type="submit" class="btn btn-primary">
							Save book
						</button>
						<input type="hidden" name="id" id="id">
					</div>
				</form>
				
			</div>
		</div>
	</div>

	<!--MODAL LOAN BOOK-->
	{{-- Es mejor realizar la accion del loan sólo con el botón --}}

	{{-- <div class="modal" id="loanBookModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Prestamo de libro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action="{{ url('loans') }}">
					@csrf
					@method('PUT')
					<div class="modal-body">
						<p>¿Seguro que desea pedir prestado este libro?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" {{-- onclick="loanBook({{$book->book_id}}, {{$book->user_id}},{{$book->date_loan}},{{$bo}},this)"  --}}{{-- class="btn btn-primary">
							Sí
						</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
						<input type="hidden" name="id" id="id">
					</div>
				</form>
			</div>
		</div>
	</div> --}}

	<!--P E N D I E N T E-->
	<!--MODAL DETAILS BOOK-->
	{{-- Especificaciones del libro --}}
	<div class="modal" id="viewBookModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title" id="title">
						{{-- {{ $book->title }} --}}
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div align="center" style="margin-bottom: 20px">
	                    <img id="cover" src="">
	                    <img src="{{ asset('img/book/'.$book->cover.'') }}">
	                </div>

	                <table class="table">
	                	<tbody>
	                		<tr>
	                			<th>Autor:</th>
	                			<td id="autor">
	                			</td>
	                		</tr>
	                		<tr>
	                			<th>Year:</th>
	                			<td id="year">
	                			</td>
	                		</tr>
	                		<tr>
	                			<th>Pages:</th>
	                			<td id="pages">
	                			</td>
	                		</tr>
	                		<tr>
	                			<th>ISBN:</th>
	                			<td id="isbn">
	                			</td>
	                		</tr>
	                		<tr>
	                			<th>Editorial:</th>
	                			<td id="editorial">
	                			</td>
	                		</tr>
	                		<tr>
	                			<th>Edition:</th>
	                			<td id="edition">
	                			</td>
	                		</tr>
	                		<tr>
	                			<th>Category:</th>
	                			<td id="category_id">
	                			</td>
	                		</tr>
	                	</tbody>
	                </table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	{{-- Agregar datos --}}
	<!--INFORMACIÓN DE PRESTAMOS DEL LIBRO ADMIN-->
	{{-- Aqui se muestran los datos sobre la persona que tiene el libro --}}
	<div class="modal fade bd-example-modal-lg" id="loanBookModalAdmin" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title" id="title">
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<table class="table">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">User</th>
				      <th scope="col">Book status</th>
				      <th scope="col">Date loan</th>
				      <th scope="col">Date return</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				  	
					    <tr>
					      <th scope="row">
					      	{{-- {{ $loan->id }} --}}
					      </th>
					      <td>
					      	{{-- {{ $user->id }} --}}
					      </td>
					      <td>
					      	{{ $book->title }}
					      </td>
					      <td>
					      	{{-- {{ $loan->date_loan }} --}}
					      </td>
					      <td>
					      	{{-- {{ $loan->date_return }} --}}
					      </td>
					      <td>
				    		<button type="button" class="btn btn-info" style="margin-bottom: 5px" data-toggle="modal" data-target="#detailsUser">
				    			Details user
				    		</button>
					      </td>
					    </tr>
				  </tbody>
				</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!--Agregar datos-->
	<!--INFORMACIÓN DEL USUARIO EN ADMIN-->
	{{-- Aqui se pueden ver los libros que ha pedido prestado el usuario --}}
	<div class="modal fade bd-example-modal-lg" id="detailsUser" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title" id="title">
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<table class="table">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Name</th>
				      <th scope="col">E-Mail</th>
				      <th scope="col">Date loan</th>
				      <th scope="col">Date return</th>
				    </tr>
				  </thead>
				  <tbody>
				  	
					    <tr>
					      <th scope="row">
					      	{{-- {{ $loan->id }} --}}
					      </th>
					      <td>
					      	{{-- {{ $user->id }} --}}
					      </td>
					      <td>
					      	{{ $book->title }}
					      </td>
					      <td>
					      	{{-- {{ $loan->date_loan }} --}}
					      </td>
					      <td>
					      	{{-- {{ $loan->date_return }} --}}
					      </td>
					    </tr>
				  </tbody>
				</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<x-slot name="script">
		<script type="text/javascript">
			function viewBook(book,category){

				$("#title").text(book.title)
				$("#autor").text(book.autor)
				$("#year").text(book.year)
				$("#pages").text(book.pages)
				$("#isbn").text(book.isbn)
				$("#editorial").text(book.editorial)
				$("#edition").text(book.edition)
				$("#category_id").text(category.name)
			}
			
			function editBook(id,title,description,year,pages,isbn,editorial,edition,autor,category_id){

				$("#title").val(title)
				$("#description").val(description)
				$("#year").val(year)
				$("#pages").val(pages)
				$("#isbn").val(isbn)
				$("#editorial").val(editorial)
				$("#edition").val(edition)
				$("#autor").val(autor)
				$("#category_id").val(category_id)
				$("#id").val(id)

			}

			function removeBook(id,target){
				swal({
				  title: "Are you sure?",
				  text: "Once deleted, you will not be able to recover this book!",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				  	axios.delete('{{ url('books') }}/'+id, {
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

			function loanBook(book_id, user_id, date_loan, cont, target) {
				$("#status") == 1;
    		}

		</script>
    </x-slot>

</x-app-layout>
