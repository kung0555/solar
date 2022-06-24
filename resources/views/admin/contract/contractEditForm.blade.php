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
            <h3 class="card-title">Edit Contract</h3>
        </div>

        {{-- <form method="post" action="{{ route('contractAddChk') }}"> --}}
        <form method="post" action="{{ route('contractChk') }}">
            @csrf
            <div class="card-body">
                <!-- /.card-header -->
                <h4>รายละเอียดสัญญา</h4>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>วันที่เริ่มสัญญา</label>
                            <input class="form-control" type="date" name="start_contract"
                                @if ($contractviews != null) {
                                    value="{{ date('Y-m-d', strtotime($contractviews->start_contract)) }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>วันที่สิ้นสุดสัญญา</label>
                            <input class="form-control" type="date" name="end_contract"
                                @if ($contractviews != null) {
                                    value="{{ date('Y-m-d', strtotime($contractviews->end_contract)) }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>สัญญาเลขที่</label>
                            <input class="form-control" type="text" name="contract_no"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->contract_no }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อบริษัท ภาษาไทย</label>
                            <input class="form-control" type="text" name="contract_companyTH"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->contract_companyTH }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ชื่อบริษัท ภาษาอังกฤษ</label>
                            <input class="form-control" type="text" name="contract_companyEN"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->contract_companyEN }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ที่อยู่บริษัท</label>
                            <textarea class="form-control" name="contract_address" id="contract_address" rows="3">
@if ($contractviews != null)
{{ $contractviews->contract_address }}
@endif
</textarea>
                            {{-- <input class="form-control" type="text" name="contract_address" readonly
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->contract_address }}"
                                       } @endif> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h4>รายละเอียด Meter</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>kWh Meter S/N</label>
                            <input class="form-control" type="text" name="kWh_meter_SN"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->kWh_meter_SN }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <input class="form-control" type="text" name="type"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->type }}"
                                       } @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Voltage</label>
                            <input class="form-control" type="text" name="voltage"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->voltage }}"
                                       } @endif>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>CT/VT Factor</label>
                            <input class="form-control" type="text" name="CT_VT_Factor"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->CT_VT_Factor }}"
                                       } @endif>
                        </div>
                    </div> --}}
                    
                </div>
              
            </div>

            <div class="card-body">
                <h4>รายละเอียดการทำ Billing</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ทำ Billing ทุกๆวันที่</label>
                            <select name="date_billing" class="form-control select2" style="width: 100%;">
                                @for ($i = 1; $i <= 28; $i++)
                                    @if ($contractviews != null)
                                        @if ($contractviews->date_billing == $i)
                                            <option selected value="{{ $i }}">{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                            {{-- <input class="form-control" type="text" name="date_billing"
                                @if ($contractviews != null) {
                                    value="{{ $contractviews->date_billing }}"
                                       } @endif> --}}
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
