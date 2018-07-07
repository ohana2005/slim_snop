<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo __('Online booking'); ?></title>

    <!-- Bootstrap core CSS -->
    <?php include_css(); ?>


</head>

<body class="snop-booking-body">

<main role="main" class="container">
    <div class="row header">
        <div class="col-2">
            <img class="logo" src="<?php echo cnfg('hotel_logo') ?>" >
        </div>
        <div class="col text-muted"><h2><?php echo cnfg('hotel_name') ?></h2></div>
    </div>
    <?php echo $content; ?>


</main><!-- /.container -->
<footer class="footer">
    <div class="container">
        <span class="text-muted"><?php echo cnfg('email'); ?></span>
        |
        <span class="text-muted"><?php echo cnfg('telephone'); ?></span>
        |
        <span class="text-muted"><?php echo cnfg('address'); ?></span>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<?php include_js(); ?>

</body>
</html>
