@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manual Add Billing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manual Add Billing</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Manual Add Billing</h3>
        </div>
        <form method="post" action="{{ route('billingManualAddChk') }}">
            @csrf
            <div class="card-body">
                <!-- /.card-header -->
                {{-- <h5>วันที่เริ่มสัญญา</h5> --}}
                <div class="row">

                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>เลือกค่า Ft</label>
                            <select class="form-control select2" style="width: 100%;" name="idft">
                                @foreach ($allparameters as $parameter)
                                    <option value="{{ $parameter->id }}">ID = {{ $parameter->id }} , Ft = {{ $parameter->ft }} , effective_start =
                                        {{ date('d-m-Y', strtotime($parameter->effective_start)) }} , effective_end =
                                        {{ date('d-m-Y', strtotime($parameter->effective_end)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ft</label>
                            <input class="form-control" type="number" name="ft" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cp อัตราค่าพลังงานไฟฟ้าสำหรับช่วงเวลา peak</label>
                            <input class="form-control" type="number" name="cp" step="0.0001" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cop อัตราค่าพลังงานไฟฟ้สำหรับช่วงเวลา off-peak</label>
                            <input class="form-control" type="number" name="cop" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ch อัตราค่าพลังงานไฟฟ้สำหรับช่วงเวลา off-peak (holiday)</label>
                            <input class="form-control" type="number" name="ch" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>DF %</label>
                            <input class="form-control" type="number" name="df" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เลือกเดือน</label>
                            <input class="form-control" type="month" name="month_billing" min="2022-01" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWhp อ่านครั้งก่อน</label>
                            <input class="form-control" type="number" name="kwhp_first_long_v" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWhp อ่านครั้งหลัง</label>
                            <input class="form-control" type="number" name="kwhp_last_long_v" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWhop อ่านครั้งก่อน</label>
                            <input class="form-control" type="number" name="kwhop_first_long_v" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWhop อ่านครั้งหลัง</label>
                            <input class="form-control" type="number" name="kwhop_last_long_v" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWhh อ่านครั้งก่อน</label>
                            <input class="form-control" type="number" name="kwhh_first_long_v" step="0.0001" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWhh อ่านครั้งหลัง</label>
                            <input class="form-control" type="number" name="kwhh_last_long_v" step="0.0001" required>
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
@endsection
