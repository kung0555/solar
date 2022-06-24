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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Parameter</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Parameter : {{$parameter->id}}</h3>
        </div>
        
        <form method="post" action="{{ route('parameterEditChk',$parameter->id) }}">
            @csrf
            {{-- @method('PUT') --}}
            <div class="card-body">
                <!-- /.card-header -->
                <div class="row">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ft</label>
                                <input class="form-control" type="number" name="ft" placeholder="Ft" value="{{$parameter->ft}}" step="0.0001" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cp อัตราค่าพลังงานไฟฟ้าสำหรับช่วงเวลา peak</label>
                                <input class="form-control" type="number" name="cp" placeholder="Cp" value="{{$parameter->cp}}" step="0.0001" required>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cop อัตราค่าพลังงานไฟฟ้สำหรับช่วงเวลา off-peak</label>
                                <input class="form-control" type="number" name="cop" placeholder="Cop" value="{{$parameter->cop}}" step="0.0001" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ch อัตราค่าพลังงานไฟฟ้สำหรับช่วงเวลา off-peak (holiday)</label>
                                <input class="form-control" type="number" name="ch" placeholder="Ch" value="{{$parameter->ch}}" step="0.0001" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>มีผลบังคับใช้</label>
                                <input class="form-control" type="date" name="effective_start" value="{{$parameter->effective_start}}" placeholder="Effective" required>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ถึงวันที่</label>
                                <input class="form-control" type="date" name="effective_end" value="{{$parameter->effective_end}}" placeholder="Effective" required>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    
                    <!-- /.row -->
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
                <a class="btn btn-primary" onclick="history.back();">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
