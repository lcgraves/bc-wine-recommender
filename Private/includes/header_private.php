<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($page_title) ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/bc-wine-recommender/Public/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-wine-bg">

    <!-- Header  -->
    <header class="header">
        <div class="container header-content">
            <a href="/bc-wine-recommender/Public/index.php" class="logo">The BC Pour</a>
            <nav class="nav">
                <!-- The Logout link -->
                <a href="/bc-wine-recommender/Private/logout.php" class="button button-third">Log Out</a>
            </nav>
        </div>
    </header>