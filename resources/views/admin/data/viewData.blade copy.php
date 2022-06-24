@extends('layouts.admin_template')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">View Data</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">


                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DataTable with features</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>ts</th>
                                    <th>date time</th>
                                    <th>long_v</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ts_kv as $ts_kv)
                                <tr>
                                    <td>{{ $ts_kv->key }}</td>
                                    <td>{{ $ts_kv->ts }}</td>
                                    {{-- <td>{{ date('d-m-Y', strtotime($ts_kv->ts/1000)) }}</td> --}}
                                    <td>{{ date("Y-m-d H:i:s", $ts_kv->ts / 1000) }}</td>
                                    <td>{{ $ts_kv->long_v }}</td>


                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Key</th>
                                    <th>ts</th>
                                    <th>date time</th>
                                    <th>long_v</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

        </div>
    </div>
    <!-- ./wrapper -->
</div>

@endsection