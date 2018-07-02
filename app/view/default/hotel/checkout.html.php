<h2><?php __('Your personal data'); ?></h2>
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
            <a href="<?php echo snop_url('rooms'); ?>"><?php echo __('Back to rooms'); ?></a>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class=" col">
            <i class="fa fa-building"></i>
            <?php echo $order['room']['name']; ?>
        </div>
        <div class=" col">
            <i class="fa fa-beer"></i>
            <?php echo $order['package']['name']; ?>
        </div>
        <div class=" col">
            <span class="badge badge-warning price-badge"><?php echo price($order['price']['price']); ?></span>
        </div>
    </nav>

    <form method="post" action="<?php echo snop_url('checkout'); ?>">
        <div class="form-group">
            <label for="exampleName"><?php echo __('Your name'); ?></label>
            <input type="text" name="order[name]" class="form-control" id="exampleName" placeholder="<?php echo __('Your name') ?>" required >
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo __('Email address') ?></label>
            <input type="email"  name="order[email]" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo __('Enter email') ?>">
            <small id="emailHelp" class="form-text text-muted"><?php echo __("We'll never share your email with anyone else.") ?></small>
        </div>
        <div class="form-group">
            <label for="exampleInputTelephone"><?php echo __('Telephone') ?></label>
            <input type="text"  name="order[telephone]" class="form-control" id="exampleInputTelephone" placeholder="<?php echo __('Telephone') ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputTelephone"><?php echo __('Special wish' ) ?></label>
            <textarea class="form-control" name="order[wish]" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success btn-lg"><?php echo __('Book now'); ?></button>
    </form>


</div>