<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class = "col-md-8 col-12">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Categories') }}
                </h2>
            </div>
            <div class="col-md-4 col-12">
                <button  type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addCategoryModal"> 
                    Añadir categoria
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-striped">
                    <thead>
                        <tr class="thead-dark">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope ="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(@isset($categories) && count($categories)>0)
                        @foreach ($categories as $category)
                            <tr> 
                                <th scope = "row">
                                    {{$category->id}}
                                </th>
                                <td>
                                    {{$category->name}}
                                </td>
                                <td>
                                    {{$category->description}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning"  onclick="editCategory({{$category}})" data-toggle="modal" data-target="#editCategoryModal" 
                                   >
                                        Edit category
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="deleteCategory({{$category->id}},this)" >Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('categories')}}">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputCategoryName">Name</label>
                      <input type="text" class="form-control" id="c_name" name="name" aria-describedby="caregoryName" placeholder="Category name" required>
                      <small id="categoryName" class="form-text text-muted">Add a name</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCategoryName">Description</label>
                        <textarea class="form-control" id="c_description" name="description" rows="5"></textarea required>
                        <small id="categoryDescription" class="form-text text-muted">Add a description</small>
                      </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('categories')}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="exampleInputCategoryName">Name</label>
                      <input type="text" class="form-control" id="name" name="name" aria-describedby="caregoryName" placeholder="Enter category name" required>
                      <small id="categoryNameEdit" class="form-text text-muted">Add a name</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCategoryName">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5"></textarea required>
                        <small id="categoryDescriptionEdit" class="form-text text-muted">Add a description</small>
                      </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                      <input type="hidden" id="id" name="id">
                    </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
      <script>
        function editCategory(category){
            $('#id').val(category['id'])
            $('#name').val(category['name']) 
            $('#description').val(category['description']) 
        }
        function deleteCategory(id,target){
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this category!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    axios.delete('{{ url('categories')}}/'+id, {
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
                    swal("Your category  is safe!");
                }
            });
        }
  </script>
</x-app-layout>