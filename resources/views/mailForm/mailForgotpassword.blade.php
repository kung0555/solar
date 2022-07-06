<!DOCTYPE html>

<head>

    <title>Document</title>
</head>

<body>
    <h1>Forget Password Email</h1>

    You can reset password from bellow link:
    {{-- <a href="{{ route('recover_password', [$token, $urlemail]) }}">Reset Password</a> --}}
    <a href="{{ route('recover_password', [$token, $email]) }}">Reset Password</a>

</body>

</html>
