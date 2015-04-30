<?php
/**
 * Plugin Name: ActOn for CCF
 * Description: Integrate Custom Contact Forms with ActOn forms
 * Author: Vit Brunner
 * Version: 0.1
 * Author URI: http://inviqa.com
 */

require 'acton-connection.php';

add_action('init', 'acton_submit_listen', 5);
add_action('admin_menu', 'acton_menu');

function acton_menu() {
    add_options_page('ActOn Configuration', 'ActOn', 'manage_options', basename(__FILE__), 'acton_options');
}

function acton_options() {
    if (isset($_POST['acton_url'])) {
        update_option('acton_url', $_POST['acton_url']);
        echo '<div class="updated">Updated the ActOn url!</div>';
    }
    ?>
    <div class=wrap>
        <h2>ActOn integration</h2>
        <ul>
            <li>The URL can be found/created in the ActOn administration interface under Content &gt; Form Post URLs.</li>
            <li>Make sure that for each field, the "Form Field Name" in ActOn (Content &gt; Forms &gt; Edit form &gt; 3. Finish) corresponds to
            the "Internal Unique Slug" of the form in Custom Contact Forms (Forms &gt; Manage form &gt; Drag the field &amp; click on it),
            <strong>otherwise your fields will not appear</strong>!</li>
        </ul>

        <form method="post">
            <h2>Settings</h2>
            <p><label for="acton_url">ActOn Form Post URL:</label><br/>
            <input class="large-text" type="text" id="acton_url" name="acton_url" value="<?php echo get_option('acton_url'); ?>"/></p>
            <p><input class="button button-primary" type="submit" value="Update"/></p>
        </form>
    </div>
    <?php
}

function acton_submit_listen() {
    if (empty($_POST['ccf_form']) || empty($_POST['form_id'])) {
        return;
    }

    if (! empty($_POST['my_information'])) {
        return;
    }
    if (empty($_POST['form_nonce']) || ! wp_verify_nonce($_POST['form_nonce'], 'ccf_form')) {
        return;
    }

    $form_id = (int) $_POST['form_id'];
    $form = get_post($form_id);
    $fields = get_post_meta($form->ID, 'ccf_attached_fields', true);

    $data = array('url' => $_SERVER['HTTP_REFERER']);

    foreach ($fields as $field_id) {
        $field_id = (int) $field_id;
        $slug = get_post_meta($field_id, 'ccf_field_slug', true);
        $value = (isset($_POST['ccf_field_' . $slug])) ? $_POST['ccf_field_' . $slug] : '';
        $data[$slug] = $value;
    }

    send_to_acton($data);
}

function send_to_acton(array $data) {
    $formUrl = get_option('acton_url');
    if (! $formUrl) {
        return;
    }

    $actOn = new ActOnConnection;
    foreach ($data as $key => $val) {
        $actOn->setPostItems($key, $val);
    }

    $actOn->processConnection($formUrl);
}
