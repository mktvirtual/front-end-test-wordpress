<?php
defined('ABSPATH') || exit;
?>

<table class="form-table">
    <tr><td colspan="2">General options for header, social links and footer sections could also be set in <a href="?page=newsletter_main_main">Blog Info panel</a>.</td></tr>
    <tr>
        <th>Base color</th>
        <td>
            <?php $controls->color('theme_color'); ?>
            <p class="description" style="display: inline">Hex values, e.g. #FF0000</p>
        </td>
    </tr>
    <tr>
        <th>Disable social links</th>
        <td><?php $controls->checkbox('theme_social_disable', ''); ?></td>
    </tr>

</table>

<h3>Posts</h3>
<table class="form-table">
    <tr>
        <th>Posts</th>
        <td>
            <?php $controls->checkbox('theme_posts', 'Add latest posts'); ?>
            <br>
            <?php $controls->checkbox('theme_thumbnails', 'Add post thumbnails'); ?>
            <br>
            <?php $controls->checkbox('theme_excerpts', 'Add post excerpts'); ?>
        </td>
    </tr>
    <tr>
        <th>Categories</th>
        <td>
            <?php $controls->categories_group('theme_categories'); ?>
        </td>
    </tr>
    <tr>
        <th>Tags</th>
        <td>
            <?php $controls->text('theme_tags', 30); ?>
            <p class="description" style="display: inline"> comma separated</p>
        </td>
    </tr>
    <tr>
        <th>Max posts</th>
        <td>
            <?php $controls->text('theme_max_posts', 5); ?>
        </td>
    </tr>
    <tr>
        <th>Post types to include</th>
        <td>
            <?php $controls->post_types('theme_post_types'); ?>
            <div class="hints">Leave all unchecked for default behaviour.</div>
        </td>
    </tr>
</table>
