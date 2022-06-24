<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-2">
        <table class="table table-bordered">
            <tr>
                <th>entity_id</th>
                <th>key</th>
                <th>ts</th>
                <th>bool_v</th>
                <th>str_v</th>
                <th>long_v</th>
                <th>dbl_v</th>
                <th>json_v</th>
                <th>NewDate</th>
                <th>device</th>
            </tr>
            @foreach ($thingsboard as $ts_kv)
                <tr>
                    <td>{{ $ts_kv->entity_id }}</td>
                    <td>{{ $ts_kv->key }}</td>
                    <td>{{ $ts_kv->ts }}</td>
                    <td>{{ $ts_kv->bool_v }}</td>
                    <td>{{ $ts_kv->str_v }}</td>
                    <td>{{ $ts_kv->long_v }}</td>
                    <td>{{ $ts_kv->dbl_v }}</td>
                    <td>{{ $ts_kv->json_v }}</td>
                    <td>{{ $ts_kv->newdate }}</td>
                    <td>{{ $ts_kv->device_name }}</td>
                </tr>
            @endforeach
        </table>
        <a href="{{ url('/dashboard') }}" class="button">dashboard</a>
        {{-- <table class="table table-bordered">
            <tr>
                <th>id</th>
            </tr>
            @foreach ($thingsboard1 as $thingsboard12)
                <tr>
                    <td>{{ $thingsboard12->id }}</td>
                </tr>
            @endforeach
        </table> --}}
    </div>

</body>

</html>
