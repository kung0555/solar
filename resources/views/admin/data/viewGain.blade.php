@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Gain</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">View Gain</li>
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
                                        <th>Parameter</th>
                                        <th>Gain</th>
                                        <th>Unit</th>
                                        <th>created_at</th>
                                        <th>updated_at</th>
                                        <th>Manage</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ts_kv_dictionary as $ts_kv_dictionary)
                                        <tr>
                                            <td>{{ $ts_kv_dictionary->key }}</td>
                                            <td>{{ $ts_kv_dictionary->gain }}</td>
                                            <td>{{ $ts_kv_dictionary->unit }}</td>
                                            <td>{{ $ts_kv_dictionary->created_at}}</td>
                                            <td>{{ $ts_kv_dictionary->updated_at}}</td>
                                            {{-- @if ($ts_kv_dictionary->created_at)
                                                <td>{{ $ts_kv_dictionary->created_at->format('d-m-Y H:i:s') }}</td>
                                                <td>{{ $ts_kv_dictionary->updated_at->format('d-m-Y H:i:s') }}</td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif --}}

                                            <td>
                                                <a href="{{ route('gainEditID', $ts_kv_dictionary->key_id) }}"
                                                    class="btn btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Gain</th>
                                        <th>Unit</th>
                                        <th>created_at</th>
                                        <th>updated_at</th>
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
