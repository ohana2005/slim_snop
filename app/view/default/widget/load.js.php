document.write("<div id='snop_widget_top_border'></div><div id='snop_widget'><div id='snop_loading' style='text-align: center;'><img src='<?php echo host(); ?>snop/img/loading.gif' style='width: 100px' alt='' ></div></div>");


SnopWidget.run({
    lang: "<?php echo $lang; ?>",
    hotel: "<?php echo $hotel; ?>",
    sessid: "<?php echo session_id(); ?>",
    host: "<?php echo host(); ?>"
});