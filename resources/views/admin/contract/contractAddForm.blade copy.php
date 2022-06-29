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
                            <input class="form-control" type="date" name="date_start17">
                        </div>

                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>วันที่สิ้นสุด 1-5 ปี</label>
                            <input class="form-control" type="date" name="date_end17">
                        </div>
                    </div> --}}
                    <!-- /.row -->
                </div>
                {{-- <h5>ระยะเวลา</h5> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ระยะที่ 1 (ตัวอย่าง ปีที่ 1-5 ให้กรอก 5)</label>
                            <input class="form-control" type="number" name="" placeholder="กรอกเฉพาะระยะปีที่สิ้นสุด">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ระยะที่ 1 ส่วนลด %</label>
                            <input class="form-control" type="number" name="" placeholder="กรอกเฉพาะระยะปีที่สิ้นสุด">
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                {{-- <h5>ปีที่ 10-15 ปี ลด 25%</h5> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ระยะที่ 2 ปีที่ 6-10 ให้กรอก 10</label>
                            <input class="form-control" type="number" name="" placeholder="กรอกเฉพาะระยะปีที่สิ้นสุด">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ระยะที่ 2 ส่วนลด %</label>
                            <input class="form-control" type="number" name="" placeholder="กรอกเฉพาะระยะปีที่สิ้นสุด">
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ระยะที่ 3</label>
                            <input class="form-control" type="number" name="" placeholder="กรอกเฉพาะระยะปีที่สิ้นสุด">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ระยะที่ 3 ส่วนลด %</label>
                            <input class="form-control" type="number" name="" placeholder="กรอกเฉพาะระยะปีที่สิ้นสุด">
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                {{-- @error('ft')//
                    <span class="text-danger">{{ $message }}</span>
                @enderror --}}
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
