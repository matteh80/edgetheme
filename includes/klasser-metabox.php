<?php
$type = 'klasser';
// Add the Meta Box
function add_klasser_meta_box() {
    add_meta_box(
        'klasser_meta_box', // $id
        'klasser Information', // $title 
        'show_klasser_meta_box', // $callback
        'klasser', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_klasser_meta_box');

// Field Array
$prefix = 'klasser_';
$klasser_meta_fields = array(
    array(
        'label'=> 'Aktiv',
        'desc'  => '',
        'id'    => $prefix.'active',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Beskrivning',
        'desc'  => 'En beskrivning av kursen. (Ej obligatorisk)',
        'id'    => $prefix.'description',
        'type'  => 'textarea'
    ),
    array(
        'label' => 'Dansstil',
        'id'    => 'dansstil',
        'type'  => 'tax_select'
    ),
    array (
        'label' => 'Dag',
        'desc'  => 'Veckodag.',
        'id'    => $prefix.'dag',
        'type'  => 'radio',
        'options' => array (
            'mon' => array (
                'label' => 'Måndag',
                'value' => 'monday'
            ),
            'tue' => array (
                'label' => 'Tisdag',
                'value' => 'tuesday'
            ),
            'wed' => array (
                'label' => 'Onsdag',
                'value' => 'wednesday'
            ),
            'thu' => array (
                'label' => 'Torsdag',
                'value' => 'thursday'
            ),
            'fri' => array (
                'label' => 'Fredag',
                'value' => 'friday'
            ),
            'sat' => array (
                'label' => 'Lördag',
                'value' => 'saturday'
            ),
            'sun' => array (
                'label' => 'Söndag',
                'value' => 'sunday'
            )
        )
    ),
    array(
        'label' => 'Starttid',
        'desc'  => 'Starttid',
        'id'    => $prefix.'starttime',
        'type'  => 'time'
    ),
    array(
        'label' => 'Sluttid',
        'desc'  => 'Sluttid',
        'id'    => $prefix.'endtime',
        'type'  => 'time'
    ),
    array (
        'label' => 'Sal',
        'desc'  => 'Välj sal',
        'id'    => $prefix.'sal',
        'type'  => 'radio',
        'options' => array (
            'one' => array (
                'label' => 'Sal 1',
                'value' => 'one'
            ),
            'two' => array (
                'label' => 'Sal 2',
                'value' => 'two'
            ),
            'three' => array (
                'label' => 'Sal 3',
                'value' => 'three'
            )
        )
    ),
    array(
        'label' => 'Pris',
        'desc'  => 'Pris för klassen.',
        'id'    => $prefix.'price',
        'type'  => 'slider',
        'min'   => '500',
        'max'   => '1500',
        'step'  => '5'
    )
);

function show_klasser_meta_box() {
    global $klasser_meta_fields, $post;
// Use nonce for verification
    echo '<input type="hidden" name="klasser_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($klasser_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
                break;
            // textarea
            case 'textarea':
                echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
                break;
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;
            // select
            case 'select':
                echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                }
                echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                break;
            // radio
            case 'radio':
                foreach ( $field['options'] as $option ) {
                    echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                }
                break;
            // checkbox_group
            case 'checkbox_group':
                foreach ($field['options'] as $option) {
                    echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                }
                echo '<span class="description">'.$field['desc'].'</span>';
                break;
            // tax_select
            case 'tax_select':
                echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Välj dansstil</option>'; // Select One
                $terms = get_terms($field['id'], 'get=all');
                $selected = wp_get_object_terms($post->ID, $field['id']);
                foreach ($terms as $term) {
                    $tag_ID = get_tag_ID($term->name);
                    if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug))
                        echo '<option id="'.$tag_ID.'" value="'.$term->slug.'" selected="selected">'.$term->name.'</option>';
                    else
                        echo '<option id="'.$tag_ID.'" value="'.$term->slug.'">'.$term->name.'</option>';
                }
                $taxonomy = get_taxonomy($field['id']);
                echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Redigera '.$taxonomy->label.'ar</a></span>';
                break;
            // post_list
            case 'post_list':
                $items = get_posts( array (
                    'post_type' => $field['post_type'],
                    'posts_per_page' => -1
                ));
                echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
                foreach($items as $item) {
                    echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
                } // end foreach
                echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                break;
            // date
            case 'date':
                echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
                break;
            // time
            case 'time':
                echo '<input type="text" class="timepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
                break;
            // slider
            case 'slider':
                $value = $meta != '' ? $meta : '1095';
                echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
								<br /><span class="description">'.$field['desc'].'</span>';
                break;
            // image
            case 'image':
                $image = get_template_directory_uri().'/images/image.png';
                echo '<span class="klasser_default_image" style="display:none">'.$image.'</span>';
                if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }
                echo    '<input name="'.$field['id'].'" type="hidden" class="klasser_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="klasser_preview_image" alt="" /><br />
										<input class="klasser_upload_image_button button" type="button" value="Choose Image" />
										<small> <a href="#" class="klasser_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'';
                break;
            // repeatable
            case 'repeatable':
                echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="klasser_repeatable">';
                $i = 0;
                if ($meta) {
                    foreach($meta as $row) {
                        echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
                        $i++;
                    }
                } else {
                    echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
                }
                echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_klasser_meta($post_id) {
    global $klasser_meta_fields;

    // verify nonce
    if (!wp_verify_nonce($_POST['klasser_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ($klasser_meta_fields as $field) {
        if($field['type'] == 'tax_select') continue;
        // save taxonomies
        $post = get_post($post_id);
        $category = $_POST['category'];
        wp_set_object_terms( $post_id, $category, 'category' );
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_klasser_meta');

function remove_taxonomy_boxes() {
    remove_meta_box('categorydiv', 'post', 'side');
}
add_action( 'admin_menu' , 'remove_taxonomy_boxes' );

// Enqueue scripts
if(is_admin()) {
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('timepickers_js', get_template_directory_uri().'/includes/js/jquery-ui-timepicker-addon.js', array('jquery-ui-datepicker'));
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('admin-scripts-js', get_template_directory_uri().'/includes/js/admin-scripts.js');
    //wp_enqueue_style('jquery-ui-klasser', get_template_directory_uri().'/css/jquery-ui-klasser.css');
}

add_action('admin_head','add_klasser_scripts');
function add_klasser_scripts() {
    global $klasser_meta_fields, $post;

    $output = '<script type="text/javascript">
                jQuery(function() {';

    foreach ($klasser_meta_fields as $field) { // loop through the fields looking for certain types
        if($field['type'] == 'date')
            $output .= 'jQuery(".datepicker").datepicker();';

        if($field['type'] == 'time')
            $output .= 'jQuery(".timepicker").timepicker({
                stepMinute: 15
            });';

        if ($field['type'] == 'slider') {
            $value = get_post_meta($post->ID, $field['id'], true);
            if ($value == '') $value = $field['min'];
            $output .= '
				jQuery( "#'.$field['id'].'-slider" ).slider({
					value: '.$value.',
					min: '.$field['min'].',
					max: '.$field['max'].',
					step: '.$field['step'].',
					slide: function( event, ui ) {
						jQuery( "#'.$field['id'].'" ).val( ui.value );
					}
				});';
        }
    }



    $output .= '});
        </script>';

    echo $output;
}
?>