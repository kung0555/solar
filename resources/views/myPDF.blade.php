<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
 
        body {
            font-family: "THSarabunNew";
        }
    </style>
</head>

<body>
    <h1>Document</h1>
    {{-- <p>{{ $date }}</p> --}}
    <p>ทดสอบrem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua.</p>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        @foreach ($Contract as $Contract)
        <tr>
            <td>1ทดสอบ</td>
            <td>21ทดสอบ</td>
            <td>{{$Contract->contract_companyTH }}</td>
        </tr>
        @endforeach
    </table>

</body>

</html>
<!DOCTYPE html>
