<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gráficos</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}</style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <h1>Gráficos</h1>

    <div style="max-width:700px;margin-bottom:40px;">
        {!! $pie->container() !!}
    </div>

    <div style="max-width:900px;">
        {!! $line->container() !!}
    </div>

    {!! $pie->script() !!}
    {!! $line->script() !!}
</body>
</html>
