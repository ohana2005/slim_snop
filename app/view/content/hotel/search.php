<h2>Searching the hotel</h2>

<form method="get" action="<?php echo snop_url('rooms'); ?>">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="snop_arrival_date"><?php echo __('Arrival date'); ?></label>
                    <input type="text" name="arr" class="form-control snop-datepicker" id="snop_arrival_date"
                           placeholder="" value="<?php echo date('d.m.Y'); ?>">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="snop_departure_date"><?php echo __('Departure date'); ?></label>
                    <input type="text" name="dep" class="form-control snop-datepicker" id="snop_departure_date"
                           placeholder="" value="<?php echo date('d.m.Y', time() + 60 * 60 * 24); ?>">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="snop_adults"><?php echo __('Adults'); ?></label>
                    <select name="a" class="form-control snop-select-small" id="snop_adults">
                        <?php echo form_adults(); ?>
                    </select>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="snop_children"><?php echo __('Children'); ?></label>
                    <select name="c" class="form-control snop-select-small" id="snop_children">
                        <?php echo form_children(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><?php echo __('Search'); ?></button>
</form>