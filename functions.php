// Function to get the top-level category of a product
function get_product_top_level_category( $product_id ) {

    // Get the terms (categories) associated with the product
    $product_terms            = get_the_terms( $product_id, 'course_category' );
    $product_category_term    = $product_terms[0];
    $product_category_parent  = $product_terms[0]->parent;

    // Traverse up the category hierarchy to find the top-level category
    while ( $product_category_parent != 0 ) {
        $product_category_term    = get_term( $product_category_parent, 'course_category' );
        $product_category_parent  = $product_category_term->parent;
    }

    return $product_category_term;
}

// Hooked function to restrict the cart to a single category
add_filter( 'woocommerce_before_cart', 'restrict_cart_to_single_category' );
function restrict_cart_to_single_category() {
    global $woocommerce;
    
    // Get cart contents
    $cart_contents    = $woocommerce->cart->get_cart();
    $cart_item_keys   = array_keys( $cart_contents );
    $cart_item_count  = count( $cart_item_keys );

    // Do nothing if the cart is empty or has only one item
    if ( ! $cart_contents || $cart_item_count == 1 ) {
        return null;
    }

    // Multiple items in the cart
    $first_item                    = $cart_item_keys[0];
    $first_item_id                 = $cart_contents[$first_item]['product_id'];
    $first_item_top_category       = get_product_top_level_category( $first_item_id );
    $first_item_top_category_term  = get_term( $first_item_top_category, 'course_category' );
    $first_item_top_category_name  = $first_item_top_category_term->name;

    // Check each subsequent item's top-level parent category
    foreach ( $cart_item_keys as $key ) {
        if ( $key == $first_item ) {
            continue;
        } else {
            $product_id            = $cart_contents[$key]['product_id'];
            $product_top_category  = get_product_top_level_category( $product_id );

            // If the top-level category of the current item doesn't match the first item, set quantity to zero
            if ( $product_top_category != $first_item_top_category ) {
                $woocommerce->cart->set_quantity( $key, 0, true );
                $mismatched_categories  = 1;
            }
        }
    }

    // Display an error message for mismatched categories
    // Show the message only once for anyone, including those with prefilled carts
    if ( isset( $mismatched_categories ) ) {
        echo '<p class="woocommerce-error">يُسمح بوجود فقط فئة واحدة في السلة في وقت واحد.<br />حاليًا يُسمح لك فقط بـ <strong>'.$first_item_top_category_name.'</strong> منتج في سلتك.<br />لطلب فئة مختلفة، يرجى تفريغ سلتك أولاً.</p>';
    }
}
