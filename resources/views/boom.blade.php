<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] ?? 'Boom' }}</title>
</head>
<body>
    <h1>{{ $data['title'] ?? 'Boom!' }}</h1>
    
    <p>{{ $data['description'] ?? 'View boom.blade.php berhasil dipanggil dari MencobaController@boomesport.' }}</p>

    @if(isset($data['players']) && count($data['players']) > 0)
        <h2>Daftar Pemain</h2>
        <ul>
            @foreach($data['players'] as $player)
                <li>{{ $player }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
