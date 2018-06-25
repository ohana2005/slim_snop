<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online booking</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap-4.1.1/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="/gijgo-combined-1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="/snop/css/snop.css" rel="stylesheet" type="text/css" />


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
<script src="//code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<script src="/bootstrap-4.1.1/js/bootstrap.min.js"></script>
<script src="/gijgo-combined-1.9.6/js/gijgo.min.js" type="text/javascript"></script>

<script>
    var today, tomorrow;
    today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    tomorrow = new Date(new Date().getFullYear() + 1, new Date().getMonth(), new Date().getDate());
    var format = 'dd.mm.yyyy';
    $('#snop_arrival_date').datepicker({
        uiLibrary: 'bootstrap4',
        minDate: today,
        maxDate: tomorrow,
        format: format
    });
    $('#snop_departure_date').datepicker({
        uiLibrary: 'bootstrap4',
        minDate: today,
        maxDate: tomorrow,
        format: format
    });
</script>
</body>
</html>
