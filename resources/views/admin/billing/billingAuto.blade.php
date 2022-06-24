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
            <h3 class="card-title">Contract</h3>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <div class="card-body">
            <!-- /.card-header -->
            <h5>วันที่เริ่มสัญญา</h5>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        {{-- <label>วันที่เริ่ม</label> --}}

                        @if ($contractviews == null)
                            <input class="form-control" type="date" name="start_contract" readonly value="">
                        @else
                            @foreach ($contractviews as $contract)
                                {{-- <input class="form-control" type="date" name="date_contract" readonly --}}
                                {{-- value="{{ $contract->start_contract }}"> --}}
                                <input class="form-control" type="date" name="start_contract" readonly
                                    value="{{ date('Y-m-d', strtotime($contract->start_contract)) }}">
                            @endforeach
                        @endif

                        {{-- @foreach ($contractviews as $contract) --}}
                        {{-- <input class="form-control" type="date" name="date_contract" readonly --}}
                        {{-- value="{{ $contract->start_contract }}"> --}}
                        {{-- <input class="form-control" type="date" name="start_contract" readonly value="{{date('Y-m-d',strtotime($contract->start_contract))}}"> --}}

                        {{-- @endforeach --}}

                        {{-- ยังอยู่มั้ย yes ทำไงต่อดี เรา งง คือเราอยากส่งมาค่าเดียว แต่ตอนนี้ดาต้าเบสยังไม่มีข้อมูล มันไม่มีไรส่งมา มันไม่เข้า foreach ไม่ใส่ข้อมูลให้มันก่อนอะ จะได้เทสได้ เราเทสแล้ว ได้อยู่ --}}
                        {{-- @if ($contractviews)
                            <input class="form-control" type="date" name="date_contract" readonly
                            value="">
                        @else
                            @foreach ($contractviews as $contract)
                            <input class="form-control" type="date" name="date_contract" readonly
                            value="{{ $contract->start_contract }}">
                            @endforeach
                        @endif --}}
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
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
            <a href="{{ route('contractEditForm') }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
    <!-- /.card -->

@endsection
