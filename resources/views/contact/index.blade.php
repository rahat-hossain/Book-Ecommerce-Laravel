@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Get In Touch</div>

                <div class="card-body">
                    <table class="table table-bordered table-hover" id="contact_table">
                        <thead>
                          <tr>
                            <th>SL No</th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Subject</th>
                            <th>Uploaded File</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($contacts as $contact)
                          <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $contact->firstname }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->website }}</td>
                            <td>{{ $contact->subject }}</td> 
                            <td>
                                @if ($contact->upload_file == 'No File')
                                    {{ 'No File' }}
                                @else
                                    <a href="{{ asset('storage/contact_uploads') }}/{{ $contact->upload_file }}" target="_blank">View</a>
                                    <br>
                                    <a href="{{ url('contact/upload/download') }}/{{ $contact->upload_file }}">Download</a>
                                @endif
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#contact_table').DataTable({
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
