<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($page_title) ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/bc-wine-recommender/Public/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-wine-bg">

    <!-- Header  -->
    <header class="header">
        <div class="container header-content">
            <a href="/bc-wine-recommender/Public/index.php" class="logo">The BC Pour</a>
            <nav class="nav">
                <!-- The Logout link -->
                <a href="/Private/logout.php" class="button button-third">Log Out</a>
            </nav>
        </div>
    </header>