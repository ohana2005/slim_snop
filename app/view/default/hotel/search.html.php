<h2>Searching the hotel</h2>

<form method="get" action="<?php echo snop_url('rooms'); ?>" id="snop_search_form">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="snop_arrival_date"><?php echo __('Arrival date'); ?></label>
                    <input type="text" name="arr" class="form-control snop-datepicker" id="snop_arrival_date"
                           placeholder="" value="<?php echo $search['dateArrival']; ?>">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="snop_departure_date"><?php echo __('Departure date'); ?></label>
                    <input type="text" name="dep" class="form-control snop-datepicker" id="snop_departure_date"
                           placeholder="" value="<?php echo $search['dateDeparture']; ?>">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="snop_adults"><?php echo __('Adults'); ?></label>
                    <select name="a" class="form-control snop-select-small" id="snop_adults">
                        <?php echo form_adults($search['adultsCount']); ?>
                    </select>
                </div>
            </div>
            <?php if(cnfg('children_enabled')): ?>
            <div class="col-1">
                <div class="form-group">
                    <label for="snop_children"><?php echo __('Children'); ?></label>
                    <select name="c" class="form-control snop-select-small" id="snop_children">
                        <?php echo form_children($search['childrenCount']); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-1">
                <div class="form-group">
                    <label for="snop_children">&nbsp;</label>
                <button type="submit" class="btn btn-primary" id="snop_search_button"><?php echo __('Search'
                    ); ?></button>
                </div>
            </div>
        </div>
    </div>
</form>