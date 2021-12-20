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
    <h1>Create a Project</h1>

    <form action="/projects" method="POST">
        @csrf

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Title">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" placeholder="Add a description"></textarea>
        </div>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
