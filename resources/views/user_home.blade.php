@extends('layouts.user_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">User Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        {{-- <li class="breadcrumb-item active">Starter Page</li> --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="error-page">
                <h2 class="headline text-warning"> <i class="fas fa-exclamation-triangle text-warning"></i></h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i>You are not administrator</h3>

                    <p>
                        Please contact your system administrator.
                        <br><a href="mailto:ebilling@acnis.co">Email : ebilling@acnis.co</a>
                    </p>

                    {{-- <form class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.input-group -->
                    </form> --}}
                </div>
                <!-- /.error-content -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
