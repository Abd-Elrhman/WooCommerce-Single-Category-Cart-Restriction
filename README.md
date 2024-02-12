# WooCommerce Single Category Cart Restriction


# Overview
This WooCommerce customization provides a solution to restrict the cart to a single category. It ensures that only products from a specific top-level category can be added to the cart at a time. If users attempt to add items from different categories, the cart will be automatically adjusted to contain only products from the first added category.

# Features
Function to Get Top-Level Category: get_product_top_level_category retrieves the top-level category of a product based on a specified taxonomy ('course_category' in this example).

Cart Restriction Hook: The restrict_cart_to_single_category function is hooked to 'woocommerce_before_cart' to enforce the restriction.

Error Message Display: An error message is displayed on the cart page if users try to mix products from different top-level categories. The message informs users of the restriction and guides them on how to proceed.

# Installation
Copy the provided PHP code into your theme's functions.php file or use a custom plugin.
Save the changes and ensure the code is properly integrated.

# Usage
Upon implementation, the cart will be restricted to products from a single top-level category.
If users attempt to mix products from different categories, the cart will be adjusted, and an error message will be displayed.

# Notes
Ensure your theme or site is compatible with WooCommerce.
Customize the taxonomy ('course_category') and error message to fit your specific use case.
