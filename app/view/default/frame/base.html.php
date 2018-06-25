<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online booking</title>

    <!-- Bootstrap core CSS -->
    <?php include_css(); ?>


</head>

<body>

<main role="main" class="container">
    <h1><?php echo $hotel['name']; ?></h1>
    <?php echo $content; ?>


</main><!-- /.container -->
<footer class="container">
    <?php echo cnfg('email'); ?>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<?php include_js(); ?>

</body>
</html>
