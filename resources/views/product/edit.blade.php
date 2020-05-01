@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 m-auto">
            <div class="card">
                <div class="card-header">
                    Edit Products -{{ $product_info->product_name }}
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

                    <form method="post" action="{{ url('product/edit') }}" enctype="multipart/form-data">
                        @csrf    
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="hidden" class="form-control" name="product_id" value="{{ $product_info->id }}">
                            <input type="text" class="form-control" placeholder="Enter product name" name="product_name" value="{{ $product_info->product_name }}">
                            @error('product_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Category Name</label>
                            <select class="form-control" name="category_id">
                                <option value="">- select one -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($product_info->category_id == $category->id) ? "selected":"" }} >{{ $category->category_name }}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group">
                            <label>Product Price</label>
                            <input type="text" class="form-control" placeholder="Enter product Price" name="product_price" value="{{ $product_info->product_price }}">
                            @error('product_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter product Quantity" name="product_quantity" value="{{ $product_info->product_quantity }}">
                            @error('product_quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alert Quantity</label>
                            <input type="text" class="form-control" placeholder="Enter Alert Quantity" name="alert_quantity" value="{{ $product_info->alert_quantity }}">
                            @error('alert_quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Current Photo</label><br>
                            <img src="{{ asset('uploads/products_photos') }}/{{ $product_info->product_photo }}" alt="not found" height="50" width="50">
                        </div>
                        <div class="form-group">
                            <label>New Photo</label>
                            <input type="file" class="form-control" name="new_image" onchange="readURL(this);">
                            <img class="hidden" id="tenant_photo_viewer" src="#" alt="your image" height="80" width="100"/><br>
                                <script>
                                    function readURL(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) {
                                        $('#tenant_photo_viewer').attr('src', e.target.result).width(150).height(195);
                                        };
                                        $('#tenant_photo_viewer').removeClass('hidden');
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                    }
                                </script>
                        </div>
                            
                        <button type="submit" class="btn btn-info">Edit</button>
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
