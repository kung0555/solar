@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Parameter</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">View Parameter</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with features</h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ft</th>
                                        <th>Cp</th>
                                        <th>Cop</th>
                                        <th>Ch</th>
                                        <th>Effective Start</th>
                                        <th>Effective End</th>
                                        <th>Created_at</th>
                                        <th>Updated_at</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allparameters as $parameter)
                                        <tr>
                                            <td>{{ $parameter->id }}</td>
                                            <td>{{ $parameter->ft }}</td>
                                            <td>{{ $parameter->cp }}</td>
                                            <td>{{ $parameter->cop }}</td>
                                            <td>{{ $parameter->ch }}</td>
                                            <td>{{ date('d-m-Y', strtotime($parameter->effective_start)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($parameter->effective_end)) }}</td>
                                            {{-- <td>{{ $parameter->effective->format('d-m-Y H:i:s') }}</td> --}}
                                            <td>{{ $parameter->created_at->format('d-m-Y H:i:s') }}</td>
                                            <td>{{ $parameter->updated_at->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                <a href="{{ route('parameterEditID', $parameter->id) }}"
                                                    class="btn btn-warning">Edit</a>&nbsp;
                                                {{-- <a href="{{ route('parameterDelete', $parameter->id) }}"
                                                    class="btn btn-danger" id="del">Delete</a> --}}
                                                <a class="btn btn-danger" id="del"
                                                    onclick="deleteConfirmation({{ $parameter->id }})">Delete</a>
                                                {{-- <a href="{{route('')}}" class="btn btn-success"><i class="fas fa-edit"></i></a> --}}
                                                {{-- &nbsp;&nbsp;<a href="" class="btn btn-danger"><i class="fas fa-trash"></i></a> --}}

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ft</th>
                                        <th>Cp</th>
                                        <th>Cop</th>
                                        <th>Ch</th>
                                        <th>Effective Start</th>
                                        <th>Effective End</th>
                                        <th>Created_at</th>
                                        <th>Updated_at</th>
                                        <th>Manage</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('parameterAddForm') }}" class="btn btn-primary">Add Parameter</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

            </div>
        </div>
        <!-- ./wrapper -->
    </div>
    <script type="text/javascript">
        function deleteConfirmation(id) {
            swal.fire({
                title: "Delete?",
                icon: 'question',
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ route('parameterDelete', '') }}/" + id,

                        dataType: 'JSON',
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Done!", results.message, "success").then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                // refresh page after 2 seconds
                                // setTimeout(function() {
                                // location.reload();
                                // }, 2000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }
    </script>
@endsection
