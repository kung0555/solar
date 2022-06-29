@extends('layouts.admin_template')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manual Billing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manual Billing</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Manual Billing</h3>
        </div>

        {{-- <form method="post" action="{{ route('contractAddChk') }}"> --}}
        <form method="post" action="#">
            @csrf
            <div class="card-body">
                <!-- /.card-header -->
                {{-- <h5>วันที่เริ่มสัญญา</h5> --}}
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เลือกค่า Ft</label>
                            <select class="form-control select2" style="width: 100%;">
                                @foreach ($allparameters as $parameter)
                                    <option value="{{ $parameter->id }}">ID = {{ $parameter->id }} , Ft = {{ $parameter->ft }} , effective_start =
                                        {{ date('d-m-Y', strtotime($parameter->effective_start)) }} , effective_end =
                                        {{ date('d-m-Y', strtotime($parameter->effective_end)) }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เลือกเดือน</label>
                            <input class="form-control" type="month" id="start" name="start" min="2022-01">

                        </div>
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


            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
    {{-- <script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }}"></script> --}}


@endsection
