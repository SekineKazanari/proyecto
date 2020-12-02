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
					      	<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#detailsBook">
				    			Details
				    		</button>

				    		<button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#loanBook">
				    			Loan
				    		</button>

				    		@if (Auth::user()->hasPermissionTo('crud categories'))
						      	<button onclick="editBook({{ $book->id }}, '{{ $book->title }}', '{{ $book->description }}', '{{ $book->year }}', '{{ $book->pages }}', '{{ $book->isbn }}', '{{ $book->editorial }}', '{{ $book->edition }}', '{{ $book->autor }}', '{{ $book->cover }}', '{{ $book->category_id }}')" class="btn btn-warning" data-toggle="modal" data-target="#editBookModal">
						      		Edit Book
						      	</button>

						      	<button onclick="removeBook({{ $book->id }},this)" class="btn btn-danger">
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
					@method('PUT')

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

						{{--COVER--}}
						<div class="form-group">
						    <label for="exampleInputEmail1">
						    	Cover
						    </label>

						    <div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="basic-addon1">@</span>
							  </div>
							  <input type="file" class="form-control" name="cover" id="cover">
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

	<x-slot name="script">
		<script type="text/javascript">
			
			function editBook(id,title,description,year,pages,isbn,editorial,edition,autor,cover,category_id){

				$("#title").val(title)
				$("#description").val(description)
				$("#year").val(year)
				$("#pages").val(pages)
				$("#isbn").val(isbn)
				$("#editorial").val(editorial)
				$("#edition").val(edition)
				$("#autor").val(autor)
				$("#cover").val(cover)
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

		</script>
    </x-slot>

</x-app-layout>
