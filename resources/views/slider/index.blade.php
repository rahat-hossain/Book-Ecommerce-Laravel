@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Slider
                </div>
                <div class="card-body table-responsive">
                        
                    <table class="table table-bordered table-hover" id="slider_table">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Slider Title</th>
                                <th>Slider Photo</th>
                                <th>Created Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse ($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $slider->slider_title }}</td>
                                    <td>
                                        <img width="50" height="50" src="{{ asset('uploads/sliders_photos') }}/{{ $slider->slider_photo }}" alt="not found">
                                    </td>
                                    <td>{{ $slider->created_at->format('d-M-y  -  H:i:s') }}</td>
                                    <td>-</td>
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
                    Add Slider
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form method="post" action="{{ route('sliderinsert') }}" enctype='multipart/form-data'>
                        @csrf
                        <div class="form-group">
                            <label>Slider Title</label>
                            <input type="text" class="form-control" name="slider_title" placeholder="enter slider title">
                            @error('slider_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Slider Image</label>
                            <input type="file" class="form-control" name="slider_photo">
                            @error('slider_photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                            
                        <button type="submit" class="btn btn-success">Add New Slider</button>
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
            $('#slider_table').DataTable({
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
