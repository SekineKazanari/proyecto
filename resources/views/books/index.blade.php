<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class = "col-md-8 col-12">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Libros') }}
                </h2>
            </div>
            @if(Auth::user()->role_id == 1)
              <div class="col-md-4 col-12">
                  <button  type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookModal"> 
                      Añadir libro
                  </button>
              </div>  
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                @if (Auth::user()->role_id == 1)
                    @if (isset($books) && count($books)>0)
                        <table class="table">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Caregoria</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($books as $book)
                              <tr>
                                <th scope="row">{{$book->id}}</th>
                                <td>{{$book->title}}</td>
                                <td>{{$book->autor}}</td>
                                <td>{{$book->category->name}}</td>
                                <td>
                                    @if ($book->status == 1)
                                        Prestado
                                    @else
                                        Disponible
                                    @endif
                                </td>
                                <td class="d-inline-flex p-2 bd-highlight">
                                  @if ($book->status == 0)
                                    <form action="{{url('loans')}}" method = "POST" >
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{$book->id}}">
                                        <button type="submit" class="btn btn-primary mr-1">Obtener</button>
                                    </form>
                                    @endif
                                    <a href="{{url('books/'.$book->id)}}" class="btn btn-primary mr-1">Detalles</a>
                                    <button type="button" class="btn btn-warning mr-1" data-toggle="modal" data-target="#editBookModal" onclick="editar({{$book}})">
                                        Editar</button>
                                    <button type="button" class="btn btn-danger mr-1" onclick="eliminarLibro({{$book->id}},this)">Eliminar</button>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                
                    @endif
                    
                @else
                <div class="d-flex flex-row">
                @if (isset($books) && count($books)>0)
                 @foreach ($books as $book)
                  <div class="card" style="width: 18rem; margin-right: 10px">
                    <img class="card-img-top" src="{{url('img/books/'.$book->cover)}}" alt="Card image cap">
                    <div class="card-body">
                      <h5 class="card-title">{{$book->title}}</h5>
                      <p class="card-text">{{$book->description}}</p>
                      @if ($book->status == 0)
                        <form action="{{url('loans')}}" method = "POST" >
                            @csrf
                            <input type="hidden" name="book_id" value="{{$book->id}}">
                            <button type="submit" class="btn btn-primary">Obtener</button>
                        </form>
                        @else
                        <button type="button" class="btn btn-secondary btn-lg" disabled>No disponible</button>
                     @endif
                     <button type="button" onclick="info({{$book}})" class="btn btn-warning" data-toggle="modal" data-target="#infoModal">Detalles</button>
                    </div>
                  </div>
                 @endforeach
                @endif
                </div>

                @endif
                   
            </div>
        </div>
    </div>
 

<div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBook" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Añadir un nuevo libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{url('books')}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" name="title" class="form-control" placeholder="Naruto" aria-label="Title" aria-describedby="basic-addon1">
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <textarea class="form-control" name="description" aria-label="With textarea" cols="5" ></textarea>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Year</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="number" name="year" class="form-control" placeholder="2007" aria-label="year" aria-describedby="basic-addon1">
                      </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Pages</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="number"  name="pages" class="form-control" placeholder="600" aria-label="Pages" aria-describedby="basic-addon1">
                      </div>                          
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">ISBN</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" name="isbn"  class="form-control" placeholder="3468512" aria-label="ISBN" aria-describedby="basic-addon1">
                      </div>                          
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Editorial</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text"  name="editorial" class="form-control" placeholder="Panini" aria-label="Editorial" aria-describedby="basic-addon1">
                      </div>                          
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Edition</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="number"  name="edition" class="form-control" placeholder="1" aria-label="Edition" aria-describedby="basic-addon1">
                      </div>                          
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Autor</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text"  name="autor" class="form-control" placeholder="Masashi Kishimoto" aria-label="Autor" aria-describedby="basic-addon1">
                      </div>                          
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <select class="from-control" name="category_id" id="">
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach

                            @endif
                        </select>
                        
                      </div>                          
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Cover</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="file"  name="cover" class="form-control" name="cover">
                      </div>                          
                  </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
          </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="editBook" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{url('books')}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Adventure III" aria-label="Title" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book title.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <textarea class="form-control" id="description" name="description" aria-label="With textarea" cols="5" ></textarea>
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book title.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Year</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="number" name="year" id="year" class="form-control" placeholder="1970" aria-label="year" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="bookYear" class="form-text text-muted">Book year.</small>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Pages</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="number"  name="pages" id="pages" class="form-control" placeholder="600" aria-label="Pages" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book pages.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">ISBN</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" name="isbn" id="isbn" class="form-control" placeholder="AB-125AC-55" aria-label="ISBN" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book ISBN.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Editorial</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text"  name="editorial" id="editorial" class="form-control" placeholder="Cometa" aria-label="Editorial" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book Editorial.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Edition</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="number"  name="edition" id="edition" class="form-control" placeholder="II" aria-label="Edition" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book Edition.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Autor</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text"  name="autor" id="autor" class="form-control" placeholder="Robert James" aria-label="Autor" aria-describedby="basic-addon1">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book Autor.</small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <select class="from-control" name="category_id" id="category_id">
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>

                                @endforeach

                            @endif
                        </select>
                        
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book Category.</small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Cover</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="file"  name="cover" class="form-control" name="cover">
                      </div>                          
                    <small id="emailHelp" class="form-text text-muted">Book Cover Image.</small>
                  </div>
                  <input type="hidden" id="id" name="id" value="">
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
          </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title" id="ititle"></h5>
              <p class="card-text" id="idescription"></p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item" id="iautor"></li>
              <li class="list-group-item" id="ipages"></li>
              <li class="list-group-item" id="ieditorial"></li>
              <li class="list-group-item" id="iyear"></li>
              <li class="list-group-item" id="iisbn"></li>
              <li class="list-group-item" id="iedition"></li>
              <li class="list-group-item" id="icategory"></li>
            </ul>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function info(book){
        $('#ititle').text("Titulo: " + book['title'])
        $('#idescription').text("Descripcion: "+ book['description'])
        $('#iyear').text("Año: "+ book['year'])
        $('#ipages').text("Paginas: "+ book['pages'])
        $('#iisbn').text("ISBN: "+ book['isbn'])
        $('#ieditorial').text("Editorial: "+ book['editorial'])
        $('#iedition').text("Edicion: "+ book['edition'])
        $('#iautor').text("Autor "+ book['autor'])
        $('#icategory').text("Categoria: "+ book['category'].name)
    }
    function editar(book){
        $('#id').val(book['id'])
        $('#title').val(book['title'])
        $('#description').val(book['description'])
        $('#year').val(book['year'])
        $('#pages').val(book['pages'])
        $('#isbn').val(book['isbn'])
        $('#editorial').val(book['editorial'])
        $('#edition').val(book['edition'])
        $('#autor').val(book['autor'])
      } 

      function eliminarLibro(id,target){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this book!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            axios.delete('{{ url('books')}}/'+id, {
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
                            swal("Your book file is safe!");
                        }
                    });
                }
</script>
</x-app-layout>
