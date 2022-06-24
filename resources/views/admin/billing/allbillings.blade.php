@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Billing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">View All Billing</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with features</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>

                                        {{-- <th>kWhp first</th> --}}
                                        {{-- <th>kWhp last</th> --}}
                                        <th>kWhp</th>

                                        {{-- <th>kWhop first</th> --}}
                                        {{-- <th>kWhop last</th> --}}
                                        <th>kWhop</th>

                                        {{-- <th>kWhh first</th> --}}
                                        {{-- <th>kWhh last</th> --}}
                                        <th>kWhh</th>
                                        <th>Total Energy Power</th>


                                        <th>รวมเงินที่ต้องชำระ (บาท)</th>
                                        <th>type</th>
                                        <th>Status</th>
                                        <th>Manage</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allbillings as $allbilling)
                                        <tr>
                                            <td>{{ $allbilling->id }}</td>
                                            {{-- <td>{{ number_format($allbilling->kwhp_first, 3, ".", "") }}</td> --}}
                                            {{-- <td>{{ number_format($allbilling->kwhp_last, 3, ".", "") }}</td> --}}
                                            <td>{{ number_format($allbilling->kwhp, 3, ".", "") }}</td>

                                            {{-- <td>{{ number_format($allbilling->kwhop_first, 3, ".", "") }}</td> --}}
                                            {{-- <td>{{ number_format($allbilling->kwhop_last, 3, ".", "") }}</td> --}}
                                            <td>{{ number_format($allbilling->kwhop, 3, ".", "") }}</td>

                                            {{-- <td>{{ number_format($allbilling->kwhh_first, 3, ".", "") }}</td> --}}
                                            {{-- <td>{{ number_format($allbilling->kwhh_last, 3, ".", "") }}</td> --}}
                                            <td>{{ number_format($allbilling->kwhh, 3, ".", "") }}</td>
                                            <td>{{ number_format($allbilling->sum_kwh, 3, ".", "") }}</td>
                                            <td>{{ number_format($allbilling->total_amount, 2, ".", ",") }}</td>
                                            <td>{{ $allbilling->type }}</td>
                                            <td>{{ $allbilling->status }}</td>
                                            <td>
                                                {{-- <a href="#" class="btn btn-warning">Veiw</a> --}}
                                                {{-- <a class="btn btn-info btn-sm" href="{{ public_path($allbilling->pdf) }}"> --}}

                                                <a class="btn btn-info btn-sm" href="{{ url($allbilling->pdf) }}" target="_blank">
                                                    <i class="fas fa-folder">
                                                    </i>
                                                    View
                                                </a>
                                                <a class="btn btn-primary btn-sm" href="{{ route('billingSendEmail', $allbilling->id)}}">
                                                    <i class="fas fa-paper-plane"></i>
                                                    </i>
                                                    Send mail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>

                                        {{-- <th>kWhp first</th> --}}
                                        {{-- <th>kWhp last</th> --}}
                                        <th>kWhp</th>

                                        {{-- <th>kWhop first</th> --}}
                                        {{-- <th>kWhop last</th> --}}
                                        <th>kWhop</th>

                                        {{-- <th>kWhh first</th> --}}
                                        {{-- <th>kWhh last</th> --}}
                                        <th>kWhh</th>
                                        <th>Total Energy Power</th>

                                        <th>รวมเงินที่ต้องชำระ (บาท)</th>
                                        <th>type</th>
                                        <th>Status</th>
                                        <th>Manage</th>


                                    </tr>
                                </tfoot>
                                {{-- <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ft</th>
                                        <th>Cp</th>
                                        <th>Cop</th>
                                        <th>Ch</th>
                                        <th>Effective Start</th>
                                        <th>Effective End</th>
                                        <th>EC</th>
                                        <th>FC</th>
                                        <th>EPP</th>
                                        <th>kWhp</th>
                                        <th>kWhp_first_ts</th>
                                        <th>kWhp_first</th>
                                        <th>kWhp_last_st</th>
                                        <th>kWhp_last</th>
                                        <th>kWhop</th>
                                        <th>kWhop_first_ts</th>
                                        <th>kWhop_first</th>
                                        <th>kWhop_last_ts</th>
                                        <th>kWhop_last</th>
                                        <th>kWhh</th>
                                        <th>kWhh_first_ts</th>
                                        <th>kWhh_first</th>
                                        <th>kWhh_last_ts</th>
                                        <th>kWhh_last</th>
                                        <th>Created_at</th>
                                        <th>Updated_at</th>
                                        <th>Month</th>
                                        <th>Type</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allbillings as $allbilling)
                                        <tr>
                                            <td>{{ $allbilling->id }}</td>
                                            <td>{{ $allbilling->ft }}</td>
                                            <td>{{ $allbilling->cp }}</td>
                                            <td>{{ $allbilling->cop }}</td>
                                            <td>{{ $allbilling->ch }}</td>
                                            <td>{{date('d-m-Y', strtotime($allbilling->effective_start))}}</td>
                                            <td>{{date('d-m-Y', strtotime($allbilling->effective_end))}}</td>
                                            <td>{{ $allbilling->ec }}</td>
                                            <td>{{ $allbilling->fc }}</td>
                                            <td>{{ $allbilling->epp }}</td>
                                            <td>{{ $allbilling->kwhp }}</td>
                                            <td>{{ $allbilling->kwhp_first_ts }}</td>
                                            <td>{{ $allbilling->kwhp_first_long_v }}</td>
                                            <td>{{ $allbilling->kwhp_last_ts }}</td>
                                            <td>{{ $allbilling->kwhp_last_long_v }}</td>
                                            <td>{{ $allbilling->kwhop }}</td>
                                            <td>{{ $allbilling->kwhop_first_ts }}</td>
                                            <td>{{ $allbilling->kwhop_first_long_v }}</td>
                                            <td>{{ $allbilling->kwhop_last_ts }}</td>
                                            <td>{{ $allbilling->kwhop_last_long_v }}</td>
                                            <td>{{ $allbilling->kwhh }}</td>
                                            <td>{{ $allbilling->kwhh_first_ts }}</td>
                                            <td>{{ $allbilling->kwhh_first_long_v }}</td>
                                            <td>{{ $allbilling->kwhh_last_ts }}</td>
                                            <td>{{ $allbilling->kwhh_last_long_v }}</td>
                                            
                                            <td>{{ $allbilling->created_at->format('d-m-Y H:i:s') }}</td>
                                            <td>{{ $allbilling->updated_at->format('d-m-Y H:i:s') }}</td>
                                            <td>{{date('m-Y', strtotime($allbilling->month_billing ))}}</td>

                                            <td>{{ $allbilling->type }}</td>


                                            <td>
                                                <a href="{{ route('billingEditID', $allbilling->id) }}"
                                                    class="btn btn-warning">Edit</a>&nbsp;
                                                <a class="btn btn-danger" id="del"
                                                    onclick="deleteConfirmation({{ $allbilling->id }})">Delete</a>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ft</th>
                                        <th>Cp</th>
                                        <th>Cop</th>
                                        <th>Ch</th>
                                        <th>Effective Start</th>
                                        <th>Effective End</th>
                                        <th>EC</th>
                                        <th>FC</th>
                                        <th>EPP</th>
                                        <th>kWhp</th>
                                        <th>kWhp_first_ts</th>
                                        <th>kWhp_first</th>
                                        <th>kWhp_last_st</th>
                                        <th>kWhp_last</th>
                                        <th>kWhop</th>
                                        <th>kWhop_first_ts</th>
                                        <th>kWhop_first</th>
                                        <th>kWhop_last_ts</th>
                                        <th>kWhop_last</th>
                                        <th>kWhh</th>
                                        <th>kWhh_first_ts</th>
                                        <th>kWhh_first</th>
                                        <th>kWhh_last_ts</th>
                                        <th>kWhh_last</th>
                                        <th>Created_at</th>
                                        <th>Updated_at</th>
                                        <th>Month</th>
                                        <th>Type</th>
                                        <th>Manage</th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

            </div>
        </div>
        <!-- ./wrapper -->
    </div>
    <script type="text/javascript">
        function deleteConfirmation(id) {
            swal.fire({
                title: "Delete?",
                icon: 'question',
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ route('parameterDelete', '') }}/" + id,

                        dataType: 'JSON',
                        success: function(results) {
                            if (results.success === true) {
                                swal.fire("Done!", results.message, "success").then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                // refresh page after 2 seconds
                                // setTimeout(function() {
                                // location.reload();
                                // }, 2000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }
    </script>
@endsection
