<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Birdbird</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <ul>
        @forelse($projects as $project)
            <li>{{ $project->title }}</li>
        @empty
            <h2>No projetcs created yet</h2>
        @endforelse
    </ul>
</body>
</html>
