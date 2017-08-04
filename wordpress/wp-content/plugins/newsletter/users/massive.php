<?php
if (!defined('ABSPATH')) exit;

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

$controls = new NewsletterControls();
$module = NewsletterUsers::instance();

$options_profile = get_option('newsletter_profile');

$lists = array();
for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
    if (!isset($options_profile['list_' . $i])) $options_profile['list_' . $i] = '';
  $lists['' . $i] = '(' . $i . ') ' . $options_profile['list_' . $i];
}

if ($controls->is_action('remove_unconfirmed')) {
  $r = $wpdb->query("delete from " . NEWSLETTER_USERS_TABLE . " where status='S'");
  $controls->messages = __('Subscribers not confirmed deleted: ', 'newsletter') . $r . '.';
}

if ($controls->is_action('remove_unsubscribed')) {
  $r = $wpdb->query("delete from " . NEWSLETTER_USERS_TABLE . " where status='U'");
  $controls->messages = __('Subscribers unsubscribed deleted: ', 'newsletter') . $r . '.';
}

if ($controls->is_action('remove_bounced')) {
  $r = $wpdb->query("delete from " . NEWSLETTER_USERS_TABLE . " where status='B'");
  $controls->messages = __('Subscribers bounced deleted: ', 'newsletter') . $r . '.';
}

if ($controls->is_action('unconfirm_all')) {
  $r = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set status='S' where status='C'");
  $controls->messages = __('Subscribers changed to not confirmed: ', 'newsletter') . $r . '.';
}

if ($controls->is_action('confirm_all')) {
  $r = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set status='C' where status='S'");
  $controls->messages = __('Subscribers changed to confirmed: ', 'newsletter') . $r . '.';
}

if ($controls->is_action('remove_all')) {
  $r = $wpdb->query("delete from " . NEWSLETTER_USERS_TABLE);
  $controls->messages = __('Subscribers deleted: ', 'newsletter') . $r . '.';
}

if ($controls->is_action('list_add')) {
  $r = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int)$controls->data['list']) . "=1");
  $controls->messages = $r . ' ' . __('added to the list/preference', 'newsletter') . ' ' . $controls->data['list'];
}

if ($controls->is_action('list_remove')) {
  $r = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int)$controls->data['list']) . "=0");
  $controls->messages = $r . ' ' . __('removed to the list/preference', 'newsletter') . ' ' . $controls->data['list'];
}

if ($controls->is_action('list_delete')) {
  $wpdb->query("delete from " . NEWSLETTER_USERS_TABLE . " where list_" . ((int)$controls->data['list']) . "<>0");
}

if ($controls->is_action('list_manage')) {
  if ($controls->data['list_action'] == 'move') {
    $wpdb->query("update " . NEWSLETTER_USERS_TABLE . ' set list_' . ((int)$controls->data['list_1']) . '=0, list_' . ((int)$controls->data['list_2']) . '=1' .
            ' where list_' . $controls->data['list_1'] . '=1');
  }

  if ($controls->data['list_action'] == 'add') {
    $wpdb->query("update " . NEWSLETTER_USERS_TABLE . ' set list_' . ((int)$controls->data['list_2']) . '=1' .
            ' where list_' . $controls->data['list_1'] . '=1');
  }
}

if ($controls->is_action('resend_all')) {
    $list = $wpdb->get_results("select * from " . NEWSLETTER_USERS_TABLE . " where status='S'");
    $opts = get_option('newsletter');

    if ($list) {
        $controls->messages = __('Confirmation email sent to:', 'newsletter');
        foreach ($list as &$user) {
            $controls->messages .= $user->email . ' ';
            $newsletter->mail($user->email, $newsletter->replace($opts['confirmation_subject'], $user), $newsletter->replace($opts['confirmation_message'], $user));
        }
    } else {
        $controls->errors = 'No subscribers to which rensend the confirmation email';
    }

}

if ($controls->is_action('bounces')) {
    $lines = explode("\n", $controls->data['bounced_emails']);
    $total = 0;
    $marked = 0;
    $error = 0;
    $not_found = 0;
    $already_bounced = 0;
    $results = '';
    foreach ($lines as &$email) {
        $email = trim($email);
        if (empty($email)) continue;

        $total++;

        $email = NewsletterModule::normalize_email($email);
        if (empty($email)) {
              $results .= '[INVALID] ' . $email . "\n";
          $error++;
            continue;
        }

        $user = NewsletterUsers::instance()->get_user($email);

        if ($user == null) {
          $results .= '[NOT FOUND] ' . $email . "\n";
          $not_found++;
          continue;
        }

        if ($user->status == 'B') {
          $results .= '[ALREADY BOUNCED] ' . $email . "\n";
          $already_bounced++;
          continue;
        }

        $r = NewsletterUsers::instance()->set_user_status($email, 'B');
        if ($r === 0) {
          $results .= '[BOUNCED] ' . $email . "\n";
        $marked++;
          continue;
        }
    }

    $controls->messages .= 'Total: ' . $total . '<br>';
    $controls->messages .= 'Bounce: ' . $marked . '<br>';
    $controls->messages .= 'Errors: ' . $error . '<br>';
    $controls->messages .= 'Not found: ' . $not_found . '<br>';
    $controls->messages .= 'Already bounced: ' . $already_bounced . '<br>';
}
?>

<div class="wrap" id="tnp-wrap">
    
    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>
    
    <div id="tnp-heading">

        <h2><?php _e('Subscribers Maintenance', 'newsletter')?></h2>
        <p><?php _e('Please, backup before run a massive action.', 'newsletter')?></p>
    
    </div>
    
    <div id="tnp-body" class="tnp-users tnp-users-massive">

    <?php if (!empty($results)) { ?>

    <h3>Results</h3>

    <textarea wrap="off" style="width: 100%; height: 150px; font-size: 11px; font-family: monospace"><?php echo htmlspecialchars($results) ?></textarea>

    <?php } ?>


  <form method="post" action="">
  <?php $controls->init(); ?>

    <div id="tabs">
      <ul>
        <li><a href="#tabs-1"><?php _e('Massive actions', 'newsletter')?></a></li>
        <li><a href="#tabs-2"><?php _e('Preferences/lists management', 'newsletter')?></a></li>
        <li><a href="#tabs-3"><?php _e('Other', 'newsletter')?></a></li>
        <li><a href="#tabs-4">Bounces</a></li>
      </ul>

      <div id="tabs-1">
        <table class="widefat">
          <thead>
              <tr>
                  <th><?php _e('Status', 'newsletter')?></th>
                  <th><?php _e('Total', 'newsletter')?></th>
                  <th><?php _e('Actions', 'newsletter')?></th>
              </tr>
          </thead>
          <tr>
            <td><?php _e('Total collected emails', 'newsletter')?></td>
            <td>
              <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE); ?>
            </td>
            <td nowrap>
              <?php $controls->button_confirm('remove_all', __('Delete all', 'newsletter'), __('Are you sure you want to remove ALL subscribers?', 'newsletter')); ?>
            </td>
          </tr>
          <tr>
            <td><?php _e('Confirmed', 'newsletter')?></td>
            <td>
              <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C'"); ?>
            </td>
            <td nowrap>
              <?php $controls->button_confirm('unconfirm_all', __('Unconfirm all', 'newsletter'), __('Are you sure?', 'newsletter')); ?>
            </td>
          </tr>
          <tr>
            <td>Not confirmed</td>
            <td>
              <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='S'"); ?>
            </td>
            <td nowrap>
              <?php $controls->button_confirm('remove_unconfirmed', __('Delete all not confirmed', 'newsletter'), __('Are you sure you want to delete ALL not confirmed subscribers?', 'newsletter')); ?>
              <?php $controls->button_confirm('confirm_all', __('Confirm all', 'newsletter'), __('Are you sure you want to mark ALL subscribers as confirmed?', 'newsletter')); ?>
                <p class="description">
                    <a href="https://www.thenewsletterplugin.com/plugins/newsletter/subscribers-module#resend-confirm" target="_blank"><?php _e('We have some tips about global actions, read more.', 'newsletter')?></a>
                </p>
            </td>
          </tr>
          <tr>
            <td><?php _e('Unsubscribed', 'newsletter')?></td>
            <td>
              <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='U'"); ?>
            </td>
            <td>
              <?php $controls->button_confirm('remove_unsubscribed', __('Delete all unsubscribed', 'newsletter'), __('Are you sure?', 'newsletter')); ?>
            </td>
          </tr>

          <tr>
            <td><?php _e('Bounced', 'newsletter')?></td>
            <td>
              <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='B'"); ?>
            </td>
            <td>
              <?php $controls->button_confirm('remove_bounced', __('Delete all bounced', 'newsletter'), __('Are you sure?', 'newsletter')); ?>
            </td>
          </tr>
        </table>
        <p>Bounce are not detected by Newsletter plugin.</p>

        <h3><?php _e('Gender', 'newsletter')?></h3>
        <?php
            // TODO: do them with a single query
            $all_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where status='C'");
            $male_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where sex='m' and status='C'");
            $female_count = $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where sex='f' and status='C'");
            $other_count = ($all_count-$male_count-$female_count)
        ?>
        <table class="widefat">
            <thead><tr><th><?php _e('Gender', 'newsletter')?></th><th>Total</th></thead>
            <tr><td>Male</td><td><?php echo $male_count; ?></td></tr>
            <tr><td>Female</td><td><?php echo $female_count; ?></td></tr>
            <tr><td>Not specified</td><td><?php echo $other_count; ?></td></tr>
        </table>
      </div>


      <div id="tabs-2">
        <table class="form-table">
          <tr>
            <th><?php _e('Preferences/lists management', 'newsletter')?></th>
            <td>
              For preference <?php $controls->select('list', $lists); ?>:
              <?php $controls->button_confirm('list_add', 'Add it to every user', __('Are you sure?', 'newsletter')); ?>
              <?php $controls->button_confirm('list_remove', 'Remove it from every user', __('Are you sure?', 'newsletter')); ?>
              <?php $controls->button_confirm('list_delete', 'Delete subscribers of it', __('Are you sure?', 'newsletter')); ?>
              <br /><br />
              <?php $controls->select('list_action', array('move' => 'Change', 'add' => 'Add')); ?>
              all subscribers with preference <?php $controls->select('list_1', $lists); ?>
              to preference <?php $controls->select('list_2', $lists); ?>
              <?php $controls->button_confirm('list_manage', 'Go!', 'Are you sure?'); ?>
              <div class="hints">
                If you choose to <strong>delete</strong> users in a list, they will be
                <strong>physically deleted</strong> from the database (no way back).
              </div>
            </td>
          </tr>
        </table>
      </div>


      <div id="tabs-3">
        <p><?php _e('Totals refer only to confirmed subscribers.', 'newsletter')?></p>
        <table class="widefat">
          <thead>
              <tr>
                  <th><?php _e('Number', 'newsletter')?></th>
                  <th><?php _e('Preference', 'newsletter')?></th>
                  <th><?php _e('Total', 'newsletter')?></th>
              </tr>
          </thead>
          <?php for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo esc_html($options_profile['list_' . $i]); ?></td>
              <td>
                <?php echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where list_" . $i . "=1 and status='C'"); ?>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>

        <div id="tabs-4">
            <p>
                Import a set of bounced email addresses: they will be marked as "bounced" and no more contacted. Sending
                emails to bounced address (many times) can put your server in some black list.
            </p>

            <table class="form-table">
                <tr>
                    <th><?php _e('Bounced addresses', 'newsletter')?></th>
                    <td>
                        <?php $controls->textarea('bounced_emails'); ?>
                        <p class="description">
                            <?php _e('One email address per line.', 'newsletter')?>One email address per line.
                        </p>
                    </td>
                </tr>
            </table>

            <?php $controls->button_confirm('bounces', 'Mark those emails as bounced', __('Are you sure?', 'newsletter')); ?>
        </div>

    </div>

  </form>
  </div>
    
    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>
    
</div>