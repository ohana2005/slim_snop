<h2>Thank you for your booking</h2>

<table class="table">

    <tbody>
        <tr>
            <th><?php echo __('Full name'); ?></th>
            <td><?php echo $booking['guest_name']; ?></td>
        </tr>
        <tr>
            <th><?php echo __('Email'); ?></th>
            <td><?php echo $booking['guest_email']; ?></td>
        </tr>
        <tr>
            <th><?php echo __('Telephone'); ?></th>
            <td><?php echo $booking['guest_telephone']; ?></td>
        </tr>
        <tr>
            <th><?php echo __('Arrival'); ?></th>
            <td><?php echo _date($booking['date_arrival']); ?></td>
        </tr>
        <tr>
            <th><?php echo __('Departure'); ?></th>
            <td><?php echo _date($booking['date_departure']); ?></td>
        </tr>
        <tr>
            <th><?php echo __('Adults/children'); ?></th>
            <td><?php echo $booking['adults']; ?>/<?php echo $booking['children']; ?></td>
        </tr>
        <tr>
            <th><?php echo __('Room'); ?></th>
            <td><?php echo $booking['room_category_name']; ?>/<?php echo $booking['room_number']; ?></td>
        </tr>
        <tr>
            <th><?php echo __('Package'); ?></th>
            <td><?php echo $booking['package_name']; ?></td>
        </tr>
        <tr>
            <th><?php echo __('Total price'); ?></th>
            <td><?php echo price($booking['price']); ?></td>
        </tr>

    </tbody>
</table>