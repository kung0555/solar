@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">View Users</li>
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
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Admin</th>
                                        <th>Receive mail billing</th>
                                        {{-- <th>Create_at</th> --}}
                                        <th>Update_at</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allusers as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->is_admin == true)
                                                    {{ 'Admin' }}
                                                @else
                                                    {{ 'User' }}
                                                @endif
                                            </td>
                                            <td>{{ $user->receive_mail_billing }}</td>
                                            {{-- <td>{{ $user->created_at->format('d-m-Y H:i:s') }}</td> --}}
                                            <td>{{ $user->updated_at->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                <a href="{{ route('userEdit', $user->id) }}"
                                                    class="btn btn-warning">Edit</a>&nbsp;

                                                {{-- <a class="btn btn-danger" id="del"
                                                    onclick="deleteConfirmation({{ $user->id }})">Delete</a> --}}

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Admin</th>
                                        <th>Receive mail billing</th>
                                        {{-- <th>Create_at</th> --}}
                                        <th>Update_at</th>
                                        <th>Manage</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        {{-- <div class="card-footer">
                            <a href="{{ route('parameterAddForm') }}" class="btn btn-primary">Add Parameter</a>
                        </div> --}}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

            </div>
        </div>
        <!-- ./wrapper -->
    </div>
@endsection
