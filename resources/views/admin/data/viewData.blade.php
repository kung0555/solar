@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-2">
                    {{-- <h1 class="m-0 text-dark">Data</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-8">
                    {{-- @if (isset($_GET['ts_kv_dictionary']))
                    {{ print_r($_GET['ts_kv_dictionary']) }}
                    @endif --}}


                    <h2 class="text-center display-4">Search </h2>
                </div><!-- /.col -->
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">View Data</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">

        <div class="wrapper">

            <div class="container-fluid">
                <form action="{{ route('viewData') }}">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Result Type:</label>
                                <select name="ts_kv_dictionary[]" class="select2" multiple="multiple"
                                    data-placeholder="Select" style="width: 100%;" required>
                                    @foreach ($ts_kv_dictionary as $ts_kv_dictionary)
                                        @if (isset($_GET['ts_kv_dictionary']) && in_array($ts_kv_dictionary->key_id, $_GET['ts_kv_dictionary']))
                                            <option selected value="{{ $ts_kv_dictionary->key_id }}">
                                                {{ $ts_kv_dictionary->key }}
                                            </option>
                                        @else
                                            <option value="{{ $ts_kv_dictionary->key_id }}">{{ $ts_kv_dictionary->key }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Sort Order:</label>
                                <select name="sort" id="sort" class="select2" style="width: 100%;">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Order By:</label>
                                <select name="order" id="order" class="select2" style="width: 100%;">

                                    <option value="key">Parameter</option>
                                    <option value="ts">Datetime</option>
                                    <option value="long_v">Value</option>
                                    {{-- @foreach ($tables as $tables)
                                        <option value="{{ $tables }}">{{ $tables }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Date Start</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" name="date_start" class="form-control datetimepicker-input"
                                        @if (isset($_GET['date_start'])) value="{{ $_GET['date_start'] }}" @endif
                                        required>

                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Date End</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" name="date_end" class="form-control datetimepicker-input"
                                        @if (isset($_GET['date_end'])) value="{{ $_GET['date_end'] }}" @endif required>

                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default" style="width:70px;">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                            <th>Parameter</th>
                                            {{-- <th>ts</th> --}}
                                            <th>Datetime</th>
                                            <th>Value</th>
                                            <th>Gain</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($ts_kv != '')
                                            
                                            @foreach ($ts_kv as $ts_kv)
                                                <tr>
                                                    <td>{{ $ts_kv->key_name }}</td>
                                                    {{-- <td>{{ $ts_kv->ts }}</td> --}}
                                                    <td>{{ date('Y-m-d H:i:s', $ts_kv->ts / 1000) }}</td>
                                                    <td>{{ $ts_kv->long_v / $ts_kv->gain ." ". $ts_kv->unit }}</td>
                                                    <td>{{ $ts_kv->gain }}</td>


                                                </tr>
                                            @endforeach
                                            
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Parameter</th>
                                            {{-- <th>ts</th> --}}
                                            <th>Datetime</th>
                                            <th>Value</th>
                                            <th>Gain</th>
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
    </div>
@endsection
