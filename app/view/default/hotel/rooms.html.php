<h2>Rooms</h2>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class=" col">
            <span><?php echo __('Arrival'); ?></span>:
            <span class="snop-bold-value"><?php echo $search['dateArrival']; ?></span>
        </div>
        <div class=" col">
            <span><?php echo __('Departure'); ?></span>:
            <span class="snop-bold-value"><?php echo $search['dateDeparture']; ?></span>
        </div>
        <div class=" col">
            <span><?php echo __('Nights'); ?></span>:
            <span class="snop-bold-value"><?php echo $search['nights']; ?></span>
        </div>
        <div class=" col">
            <span><?php echo __('Adults'); ?></span>:
            <span class="snop-bold-value"><?php echo $search['adultsCount']; ?></span>
        </div>
        <div class=" col">
            <span><?php echo __('Children'); ?></span>:
            <span class="snop-bold-value"><?php echo $search['childrenCount']; ?></span>
        </div>
        <div class=" col">
            <a href="<?php echo snop_url('search'); ?>"><?php echo __('Change'); ?></a>
        </div>
    </nav>


    <?php foreach($Rooms as $key => $Item): ?>

        <div class="card text-center room-card">
            <div class="card-header">
                <h4><?php echo $Item['room']['name']; ?></h4>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $Item['package']['name']; ?></h5>
                <p class="card-text"><?php echo $Item['room']['description']; ?></p>
                <p class="card-text">
                    <?php echo price($Item['price']['price']); ?>
                </p>
            </div>
            <div class="card-footer">
                <a href="<?php echo snop_url('roombook', ['key' => $key]); ?>" class="btn btn-primary">Book now!</a>
            </div>
        </div>

    <?php endforeach; ?>
</div>