@extends('layouts.admin_template')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row justify-content-center">
                <div class="col-md-7 ">

                    <form method="post" action="{{ route('updateUserChk', $user->id) }}">
                        @csrf
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    {{-- <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                                alt="User profile picture"> --}}
                                    <i class="fas fa-user fa-4x"></i>
                                </div>

                                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                <p class="text-muted text-center">
                                    @if ($user->is_admin == true)
                                        {{ 'Admin' }}
                                    @else
                                        {{ 'User' }}
                                    @endif

                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>E-mail</b> <a class="float-right">{{ $user->email }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Date create</b> <a
                                            class="float-right">{{ $user->created_at->format('d-m-Y H:i:s') }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Date Update</b> <a
                                            class="float-right">{{ $user->updated_at->format('d-m-Y H:i:s') }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Manage Permission</b>
                                        <a class="float-right"><select name="is_admin" class="select2"
                                                data-placeholder="Pleace Select Permission" style="width: 100%;" required>
                                                @if ($user->is_admin == true)
                                                    <option value="">
                                                        Pleace Select
                                                    </option>
                                                    <option selected value="true">
                                                        Admin
                                                    </option>
                                                    <option value="false">
                                                        User
                                                    </option>
                                                @else
                                                    <option value="true">
                                                        Admin
                                                    </option>
                                                    <option selected value="false">
                                                        User
                                                    </option>
                                                @endif

                                            </select>
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Receive mail billing</b>
                                        <a class="float-right"><select name="receive_mail_billing" class="select2"
                                                data-placeholder="Pleace Select Permission" style="width: 100%;" required>
                                                @if ($user->receive_mail_billing == 'Yes')
                                                    <option selected value="Yes">
                                                        Yes
                                                    </option>
                                                    <option value="No">
                                                        No
                                                    </option>
                                                @else
                                                    <option value="Yes">
                                                        Yes
                                                    </option>
                                                    <option selected value="No">
                                                        No
                                                    </option>
                                                @endif

                                            </select>
                                        </a>
                                    </li>
                                </ul>

                                <button type="submit" class="btn btn-primary btn-block">Save</button>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </form>


                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
