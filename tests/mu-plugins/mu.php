<?php

// Color palette
add_filter('login_color_palette', function() {
    return [
        'brand' => '#0073aa',
        'trim' => '#181818',
        'trim-alt' => '#282828',
    ];
});

add_filter('pre_option_users_can_register', '__return_true');

// Add ACF fields
add_action('init', function() {
    if( !function_exists('acf_add_local_field_group') ) {
        return;
    }
    acf_add_local_field_group([
        'key' => 'group_1',
        'title' => 'My Group',
        'fields' => [
            [
                'key' => 'field_1',
                'label' => 'First name',
                'name' => 'first_name',
                'type' => 'text',
                'placeholder' => 'John',
                'instructions' => 'Fill in your first name',
            ],
            [
                'key' => 'field_2',
                'label' => 'Last name',
                'name' => 'last_name',
                'type' => 'text',
                'placeholder' => 'Deer',
                'instructions' => 'Fill in your last name',
            ],
            [
                'key' => 'field_3',
                'label' => 'Address',
                'name' => 'address',
                'type' => 'textarea',
                'instructions' => 'Fill in your address',
            ],
            [
                'key' => 'field_4',
                'label' => 'Radios',
                'name' => 'radio',
                'type' => 'radio',
                'choices' => [
                    'Yes',
                    'No',
                ],
                'instructions' => 'Select an option',
            ],
            [
                'key' => 'field_5',
                'label' => 'Checkboxes',
                'name' => 'Checkboxes',
                'type' => 'checkbox',
                'choices' => [
                    'Yes',
                    'No',
                    'Maybe',
                ],
                'instructions' => 'Select an option',
            ],
            [
                'key' => 'field_6',
                'label' => 'Subscribe to our newsletter',
                'name' => 'newsletter',
                'type' => 'select',
                'choices' => [
                    'Yes',
                    'No',
                ],
                'instructions' => 'Receive weekly news from us?',
            ],
            [
                'key' => 'field_7',
                'label' => 'I agree terms',
                'message' => 'I agree terms',
                'name' => 'newsletter',
                'type' => 'true_false',
                'choices' => [
                    'Yes',
                    'No',
                ],
                'instructions' => 'This is required',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'user_form',
                    'operator' => '==',
                    'value' => 'all',
                ],
            ],
        ],
    ]);
});

