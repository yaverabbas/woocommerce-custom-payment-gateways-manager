# WooCommerce Custom Payment Gateways Manager

[![GitHub issues](https://img.shields.io/github/issues/yaverabbas/woocommerce-custom-payment-gateways-manager)](https://github.com/yaverabbas/woocommerce-custom-payment-gateways-manager/issues)
[![GitHub license](https://img.shields.io/github/license/yaverabbas/woocommerce-custom-payment-gateways-manager)](https://github.com/yaverabbas/woocommerce-custom-payment-gateways-manager/blob/main/LICENSE)
[![GitHub stars](https://img.shields.io/github/stars/yaverabbas/woocommerce-custom-payment-gateways-manager)](https://github.com/yaverabbas/woocommerce-custom-payment-gateways-manager/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/yaverabbas/woocommerce-custom-payment-gateways-manager)](https://github.com/yaverabbas/woocommerce-custom-payment-gateways-manager/network)

## Overview

**WooCommerce Custom Payment Gateways Manager** is a robust and user-friendly plugin designed to help WooCommerce site administrators create and manage custom manual payment methods. With this plugin, you can add multiple payment gateways—each with custom names, detailed instructions, and enable/disable toggles—that appear on the checkout page for manual processing. This solution is perfect for situations where you want to handle payments manually without integrating with external APIs.

## Features

- **Custom Payment Gateway Creation:**  
  Easily create multiple custom payment methods with individual names and detailed descriptions or instructions.

- **Dynamic Admin Interface:**  
  A dedicated wp-admin menu page featuring a dynamic form that allows you to add or remove payment method rows using a simple "+" button.

- **Enable/Disable Toggle:**  
  Each payment method includes an enable/disable checkbox. Enabled methods are shown at checkout, while disabled ones remain in the database and visible in the admin interface.

- **WooCommerce Integration:**  
  Seamlessly integrates with WooCommerce by adding enabled payment methods to the checkout page, order details, and thank-you page.

- **PSR-12 Compliance:**  
  Developed using industry-standard PHP OOP practices and PSR-12 coding standards for a clean, modular, and maintainable codebase.

## Installation

1. **Download the Plugin:**  
   Download the latest release from the [Releases](https://github.com/yaverabbas/woocommerce-custom-payment-gateways-manager/releases) section.

2. **Upload to WordPress:**  
   Upload the `woocommerce-custom-payment-gateways-manager` folder to the `/wp-content/plugins/` directory.

3. **Activate the Plugin:**  
   Activate the plugin through the **Plugins** menu in your WordPress admin area.

4. **Configure Payment Methods:**  
   Navigate to the new **Payment Gateways** menu in wp-admin to add and manage your custom payment methods.

## Usage

1. **Adding Custom Payment Methods:**
    - Go to **Payment Gateways** in the WordPress admin menu.
    - Fill out the **Payment Method Name** and **Payment Method Details** fields.
    - Click the **+** button to add additional rows for new payment methods.
    - Toggle the enable/disable checkbox for each method as needed.

2. **Saving Configuration:**
    - Click the **Save Payment Gateways** button to save your custom payment method configurations.
    - Enabled methods will be integrated into the WooCommerce checkout page, while disabled ones remain stored in the database.

3. **Order Processing:**
    - When a customer selects a custom payment method at checkout, their order will be marked as "on-hold" for manual processing.
    - Administrators can then contact the customer with further payment instructions.

- **woocommerce-custom-payment-gateways-manager.php:** Main plugin file with plugin headers and autoloader.
- **src/Plugin.php:** Initializes the plugin and hooks both admin and frontend functionality.
- **src/Admin/PaymentGatewaysManager.php:** Manages the wp-admin menu, settings page, and saving configurations.
- **src/Frontend/CustomPaymentGateway.php:** Integrates custom payment methods with WooCommerce.
- **assets/js/admin.js & assets/css/admin.css:** Handle dynamic form behavior and basic styling for the admin page.

## Developer Notes

- **Coding Standards:**  
  The plugin adheres to PSR-12 coding standards. Contributions should maintain these standards to ensure consistency and quality.

- **Extensibility:**  
  The codebase is modular and object-oriented, making it easy to extend and customize according to your needs.

- **Support:**  
  If you encounter any issues or have feature requests, please open an issue on the [GitHub Issues](https://github.com/yaverabbas/woocommerce-custom-payment-gateways-manager/issues) page.

## Contributing

Contributions are welcome! Please review our [CONTRIBUTING](CONTRIBUTING.md) guidelines before submitting pull requests or issues.

## License

This project is licensed under the [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html) license.

## Author

**Yaver Abbas**
- GitHub: [@yaverabbas](https://github.com/yaverabbas)
- LinkedIn: [Yaver Abbas](https://www.linkedin.com/in/yawarak/)

---

Feel free to fork this repository and contribute to making WooCommerce Custom Payment Gateways Manager even better!
