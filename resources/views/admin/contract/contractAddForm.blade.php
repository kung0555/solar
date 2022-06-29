@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Contract</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add Contract</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add Contract</h3>
        </div>

        {{-- <form method="post" action="{{ route('contractAddChk') }}"> --}}
        <form method="post" action="#">
            @csrf
            <div class="card-body">
                <!-- /.card-header -->
                <h5>วันที่เริ่มสัญญา</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>วันที่เริ่ม</label>
                            <input class="form-control" type="date" name="date_contract">
                        </div>

                    </div>

                </div>

                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><span class="text-danger">{{ $error }}</span></li>
                        @endforeach
                    </ul>
                @endif

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
