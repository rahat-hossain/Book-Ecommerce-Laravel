@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Products List
                </div>
                <div class="card-body table-responsive">
                        @if (session('deletestatus'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('deletestatus') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session('restorestatus'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                {{ session('restorestatus') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session('editstatus'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                {{ session('editstatus') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    <h1>Product</h1>    
                    <table class="table table-bordered table-hover" id="product_table">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product Name</th>
                                <th>Category Name</th>
                                <th>Product Image</th>
                                <th>Product Price</th>
                                <th>Product Quantity</th>
                                <th>Alert Quantity</th>
                                <th>Created Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                  <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    {{-- <td>{{ App\Category::find($product->category_id)->category_name }}</td> --}}
                                    <td>{{ $product->relationtocategorytable->category_name }}</td>
                                    <td>
                                        <img width="50" height="50" src="{{ asset('uploads/products_photos') }}/{{ $product->product_photo }}" alt="not found">
                                    </td>
                                    <td>{{ $product->product_price }}</td>
                                    <td>{{ $product->product_quantity }}</td>
                                    <td>{{ $product->alert_quantity }}</td>
                                    <td>{{ $product->created_at->format('d-M-y H:i:s') }}</td>
                                    @if($product->deleted_at)
                                    <td class="table-danger">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('product/restore') }}/{{ $product->id }}" type="button" class="btn btn-info">Restore</a>
                                            <a href="{{ url('product/force/delete') }}/{{ $product->id }}" type="button" class="btn btn-danger">Force</a>
                                        </div>
                                    </td>
                                    @else
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('product/edit') }}/{{ $product->id }}" type="button" class="btn btn-warning">Edit</a>
                                            <button value="{{ url('product/delete') }}/{{ $product->id }}" type="button" class="btn btn-danger deleted_btn">Delete</button>
                                        </div>
                                    </td>
                                    @endif
                                    {{-- <td>
                                        @if($product->deleted_at)
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('product/restore') }}/{{ $product->id }}" type="button" class="btn btn-info">Restore</a>
                                                <a href="{{ url('product/force/delete') }}/{{ $product->id }}" type="button" class="btn btn-danger">Force</a>
                                            </div>
                                        @else  
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('product/edit') }}/{{ $product->id }}" type="button" class="btn btn-warning">Edit</a>
                                                <a href="{{ url('product/delete') }}/{{ $product->id }}" type="button" class="btn btn-danger">Delete</a>
                                            </div>  
                                        @endif    
                                    </td> --}}
                                  </tr>
                                @empty 
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No Data Available</td>    
                                </tr> 
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Add Products
                </div>
                <div class="card-body">
                    {{-- insert hobar pore success alert ar  jonno --}}
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    
                    {{-- error aksathe upore dekhabe --}}
                    {{-- @if ($errors->all())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif --}}

                    <form method="post" action="{{ url('product/insert') }}" enctype='multipart/form-data'>
                        @csrf   
                        <div class="form-group">
                            <label>Product Category</label>
                            <select class="form-control" name="category_id">
                                <option value="">- select one -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>     
                        </div> 
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" placeholder="Enter product name" name="product_name" value="{{ old('product_name') }}">
                            @error('product_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Short Description</label>
                            <textarea class="form-control" name="product_short_description" value="{{ old('product_short_description') }}"></textarea>
                            @error('product_short_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Long Description</label>
                            <textarea class="form-control" name="product_long_description" rows="4" value="{{ old('product_long_description') }}"></textarea>
                            @error('product_long_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Price</label>
                            <input type="text" class="form-control" placeholder="Enter product Price" name="product_price" value="{{ old('product_price') }}">
                            @error('product_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter product Quantity" name="product_quantity" value="{{ old('product_quantity') }}">
                            @error('product_quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alert Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter Alert Quantity" name="alert_quantity" value="{{ old('alert_quantity') }}">
                            @error('alert_quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Image</label>
                            <input type="file" class="form-control" name="product_photo">
                        </div>
                        <div class="form-group">
                            <label>Product Gallary</label>
                            <input type="file" class="form-control" name="product_gallery[]" multiple>
                        </div>
                            
                        <button type="submit" class="btn btn-success">Add Product</button>
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#product_table').DataTable({
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]]
            });
            $('.deleted_btn').click(function(){
                var goto_link = $(this).val();
                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            window.location.href=goto_link;
                        }
                    })
            })
        });
    </script>
@endsection
