<?php
if (!defined('ABSPATH'))
    exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

wp_enqueue_script('tnp-chart');

$all_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE);
$options_profile = get_option('newsletter_profile');

$module = NewsletterUsers::instance();
$controls = new NewsletterControls();
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    google.charts.load("current", {packages: ['corechart', 'geochart', 'geomap']});

</script>

<div class="wrap" id="tnp-wrap">

<?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Subscriber statistics', 'newsletter') ?></h2>

    </div>

    <div id="tnp-body" class="tnp-users-statistics">

<?php $controls->init(); ?>

        <div id="tabs">

            <ul>
                <li><a href="#tab-overview">Overview</a></li>
                <li><a href="#tabs-preferences">Lists</a></li>
                <li><a href="#tabs-countries">World Map</a></li>
                <li><a href="#tabs-referrers">Referrers</a></li>
                <li><a href="#tabs-sources">Sources</a></li>
                <li><a href="#tabs-gender">Gender</a></li>
                <li><a href="#tabs-time">By time</a></li>
            </ul>

            <div id="tab-overview">

                <table class="widefat" style="width: auto">
                    <thead><tr><th>Status</th><th>Total</th></thead>
                    <tr valign="top">
                        <td>Any</td>
                        <td>
<?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirmed</td>
                        <td>
<?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C'"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Not confirmed</td>
                        <td>
<?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='S'"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Subscribed to feed by mail</td>
                        <td>
<?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C' and feed=1"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Unsubscribed</td>
                        <td>
<?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='U'"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bounced</td>
                        <td>
<?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='B'"); ?>
                        </td>
                    </tr>
                </table>

            </div>


            <div id="tabs-preferences">

                <div class="tab-preamble">
                    <p>
                        Subscriber count per list.
                        <a href="https://www.thenewsletterplugin.com/plugins/newsletter/newsletter-preferences" target="_blank">Read more about lists</a> and/or
                        configure them from te "Lists" panel.
                    <p>
                </div>

                <table class="widefat" style="width: auto">
                    <thead>
                        <tr>
                            <th>List</th>
                            <th>Total</th>
                    </thead>
                    <?php for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) { ?>
    <?php if (empty($options_profile['list_' . $i])) continue; ?>
                        <tr>
                            <td><?php echo '(' . $i . ') ' . esc_html($options_profile['list_' . $i]) ?></td>
                            <td>
    <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where list_" . $i . "=1 and status='C'"); ?>
                            </td>
                        </tr>
<?php } ?>
                </table>

            </div>


            <div id="tabs-countries">
                <?php
                if (!has_action('newsletter_users_statistics_countries')) {
                    include __DIR__ . '/statistics-countries.php';
                } else {
                    do_action('newsletter_users_statistics_countries', $controls);
                }
                ?>
            </div>


            <div id="tabs-referrers">
                <div class="tab-preamble">
                    <p>The referrer is a special (hidden) fields collected during the subscription. For example the widget
                        adds the "widget" referrer to his generated form. With custom forms you can add
                        your own referrer using an hidden field named "nr".
                    </p>
                </div>
                <?php
                $list = $wpdb->get_results("select referrer, count(*) as total from " . NEWSLETTER_USERS_TABLE . " where status='C' group by referrer order by total desc");
                ?>
                <table class="widefat" style="width: auto">
                    <thead>
                        <tr><th>Referrer</th><th>Total</th>
                    </thead>
<?php foreach ($list as $row) { ?>
                        <tr>
                            <td><?php echo empty($row->referrer) ? '[undefined]' : esc_html($row->referrer) ?></td>
                            <td><?php echo $row->total; ?></td>
                        </tr>
<?php } ?>
                </table>

            </div>


            <div id="tabs-sources">

                <div class="tab-preamble">
                    <p>
                        URLs from which the subscription started. For example, if you use the widget on your blog sidebar
                        you can discover which page is converting more.
                    </p>
                </div>

                <?php
                $list = $wpdb->get_results("select http_referer, count(*) as total from " . NEWSLETTER_USERS_TABLE . " where status='C' group by http_referer order by count(*) desc limit 100");
                ?>
                <table class="widefat" style="width: auto">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Total</th>
                    </thead>
                    <tbody>
<?php foreach ($list as $row) { ?>
                            <tr>
                                <td><?php echo empty($row->http_referer) ? '[undefined]' : esc_html($row->http_referer) ?></td>
                                <td><?php echo $row->total; ?></td>
                            </tr>
<?php } ?>
                    <tbody>
                </table>

            </div>


            <div id="tabs-gender">

                    
                <?php
                $male_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where sex='m' and status='C'");
                $female_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where sex='f' and status='C'");
                $other_count = ($all_count - $male_count - $female_count);
                $gender_data = array($female_count, $male_count, $other_count);
                ?>

                <div class="row">
                    <div class="col-md-6">
                        <canvas id="tnp-gender-chart" style="width: 300px!important; height: 300px!important"></canvas>
                    </div>
                    
                    <div class="col-md-6">
                        <table class="widefat" style="width: auto">
                            <thead>
                                <tr>
                                    <th>Gender</th>
                                    <th>Total</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Male</td>
                                <td><?php echo $male_count; ?></td>
                            </tr>
                            <tr>
                                <td>Female</td>
                                <td><?php echo $female_count; ?></td>
                            </tr>
                            <tr>
                                <td>Other</td>
                                <td><?php echo $other_count; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <script>
                    var gender_data = {
                        labels: [
                            "Female",
                            "Male",
                            "Other"
                        ],
                        datasets: [
                            {
                                data: <?php echo json_encode($gender_data) ?>,
                                backgroundColor: [
                                    "#2980B9",
                                    "#27AE60",
                                    "#555555"
                                ],
                                hoverBackgroundColor: [
                                    "#2980B9",
                                    "#27AE60",
                                    "#555555"
                                ]
                            }]};

                    jQuery(document).ready(function ($) {
                        gender_ctx = $('#tnp-gender-chart').get(0).getContext("2d");
                        new Chart(gender_ctx, {type: 'doughnut', data: gender_data, options: {responsive: false, legend: {labels: {boxWidth: 10}}}});
                    });
                </script>


            </div>


            <div id="tabs-time">

                <?php
                if (!has_action('newsletter_users_statistics_time')) {
                    include __DIR__ . '/statistics-time.php';
                } else {
                    do_action('newsletter_users_statistics_time', $controls);
                }
                ?>

            </div>

            <?php
            if (isset($panels['user_statistics'])) {
                foreach ($panels['user_statistics'] as $panel) {
                    call_user_func($panel['callback'], $id, $controls);
                }
            }
            ?>
        </div>

    </div>

<?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>



