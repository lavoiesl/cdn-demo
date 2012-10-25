<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>CDN Demo</title>
    <?php if (!empty($_GET['cdn'])): ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.0.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.0.4/css/bootstrap-combined.min.css">

    <?php elseif (!empty($_GET['half'])): ?>

    <script src="compiled/half.js"></script>
    <link rel="stylesheet" href="compiled/half.css">

    <?php else: ?>

    <script src="compiled/full.js"></script>
    <link rel="stylesheet" href="compiled/full.css">

    <?php endif ?>
<body>
    <ul>
        <li>
            <a href="?cdn=&amp;half=1">No CDN (half)</a>
        </li>
        <li>
            <a href="?cdn=">No CDN (full)</a>
        </li>
        <li>
            <a href="?cdn=1">Use CDN (full)</a>
        </li>
    </ul>
</body>
</html>