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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Gain</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Gain : {{ $ts_kv_dictionary->key }}</h3>
        </div>

        {{-- <form method="post" action="{{ route('gainChk', $ts_kv_dictionary->key_id) }}">
            @csrf --}}
        <form method="post" action="{{ route('gainChk', $ts_kv_dictionary->key_id) }}">
            @csrf
            {{-- @method('PUT') --}}
            <div class="card-body">
                <!-- /.card-header -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <input class="form-control" type="text" name="key_id" value="{{ $ts_kv_dictionary->key_id }}"
                                placeholder="gain" hidden> --}}
                            <label>Gain</label>
                            <input class="form-control" type="text" name="gain" value="{{ $ts_kv_dictionary->gain }}"
                                placeholder="gain" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <input class="form-control" type="text" name="key_id" value="{{ $ts_kv_dictionary->key_id }}"
                                placeholder="gain" hidden> --}}
                            <label>Unit</label>
                            <input class="form-control" type="text" name="unit" value="{{ $ts_kv_dictionary->unit }}"
                                placeholder="unit" required>
                        </div>
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
