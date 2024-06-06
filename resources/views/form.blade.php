<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Optimistic lock example</h1>

    @isset($message)
        <h2>{{ $message }}</h2>
    @endif

    <form action="/" method="post">
        @csrf

        <input type="hidden" name="version" id="version" value="{{ $version }}">
        <textarea name="content" id="content" rows="30" cols="80">{{ $content }}</textarea>
        <input type="submit">
    </form>

    @isset($contentLocked)
        <h2>Here is content that was locked out:</h2>
        <textarea name="content" id="content" rows="30" cols="80" readonly>{{ $contentLocked }}</textarea>
    @endif
</body>
</html>