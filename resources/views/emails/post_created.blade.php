<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post Created</title>
</head>
<body>
    <h1>New Post Created</h1>
    <p>A new post titled <strong>{{ $postTitle }}</strong> has been created in the forum.</p>
    <p>Content: {{ $postContent }}</p>
    
    <p>You can view the post by clicking the link below:</p>
    <p><a href="{{ $postUrl }}">{{ $postTitle }}</a></p>
</body>
</html>
