<?php
// Market options
add_action( 'rest_api_init', function(){
    $namespace = 'api';

    // маршрут
    $rout = '/general-options';

    // параметры конечной точки (маршрута)
    $rout_params = [
        'methods'  => 'GET',
        'callback' => 'rapi_get_options',
    ];

    register_rest_route( $namespace, $rout, $rout_params );

} );
function rapi_get_options( WP_REST_Request $request ){

    return [
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description')
    ];
}

// All products
add_action( 'rest_api_init', function(){
    $namespace = 'api';

    // маршрут
    $rout = '/products/all';

    // параметры конечной точки (маршрута)
    $rout_params = [
        'methods'  => 'GET',
        'callback' => 'rapi_get_all_products',
    ];

    register_rest_route( $namespace, $rout, $rout_params );

} );
function rapi_get_all_products( WP_REST_Request $request ){

    $posts = get_posts( [
        'post_type' => 'product',
        'posts_per_page' => -1
    ] );

    if ( empty( $posts ) ) {
        return new WP_Error( 'no_author_posts', 'Записей не найдено', [ 'status' => 404 ] );
    }

    return $posts;
}