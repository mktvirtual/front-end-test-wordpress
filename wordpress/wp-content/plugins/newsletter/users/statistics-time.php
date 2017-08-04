<?php
if (!defined('ABSPATH'))
    exit;
?>

<div class="row">
    <div class="col-md-6">
        <h3>Subscriptions by month (max 12 months)</h3>
        <?php
        $months = $wpdb->get_results("select count(*) as c, concat(year(created), '-', date_format(created, '%m')) as d from " . NEWSLETTER_USERS_TABLE . " where status='C' group by concat(year(created), '-', date_format(created, '%m')) order by d desc limit 12");
        ?>

        <table class="widefat" style="width: auto">
            <thead>
                <tr valign="top">
                    <th>Date</th>
                    <th>Subscribers</th>
                </tr>
            </thead>
            <?php foreach ($months as &$day) { ?>
                <tr valign="top">
                    <td><?php echo $day->d; ?></td>
                    <td><?php echo $day->c; ?></td>
                </tr>
            <?php } ?>
        </table>

    </div>
    <div class="col-md-6">
     
        <h3>Subscriptions by day (max 90 days)</h3>
        <?php
        $list = $wpdb->get_results("select count(*) as c, date(created) as d from " . NEWSLETTER_USERS_TABLE . " where status='C' group by date(created) order by d desc limit 90");
        ?>
        <table class="widefat" style="width: auto">
            <thead>
                <tr valign="top">
                    <th>Date</th>
                    <th>Subscribers</th>
                </tr>
            </thead>
            <?php foreach ($list as $day) { ?>
                <tr valign="top">
                    <td><?php echo $day->d; ?></td>
                    <td><?php echo $day->c; ?></td>
                </tr>
            <?php } ?>
        </table>
   
    </div>

</div>

