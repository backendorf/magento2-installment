# Magento 2 Installment

[![Magento 2.4.x](https://img.shields.io/badge/Magento-2.4.x-brightgreen.svg)](https://magento.com/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A powerful and flexible Magento 2 module designed to display installment values and strategic discounts directly on your storefront catalog pages and cart.

## 🚀 Features

- **Installment Display**: Show installment options across Product, Category, and Search pages.
- **Configurable Logic**: 
  - Define maximum installments and minimum installment value.
  - Support for **Simple** and **Compound** interest calculations.
- **Customizable Interest**: Set specific interest rates for each installment level.
- **Purchase Incentives**:
  - Highlights the best installment option in the cart.
  - Displays strategic discounts to drive conversion.
- **Flexible Templates**: Includes specific price templates for `catalog_category_view`, `catalogsearch_result_index`, and `catalog_product_view`.
- **Custom Styling**: Control primary colors and highlight text weights directly from the admin panel.

## 🛠️ Installation

### Using Composer (Recommended)

```bash
composer require backendorf/module-installment
```

### Enable the Module

```bash
bin/magento module:enable Backendorf_Installment
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
```

## ⚙️ Configuration

Navigate to **Stores > Configuration > Backendorf > Installment** to configure the following:

1.  **General Settings**: Enable/Disable the module, set limits, and display behavior.
2.  **Interest Rates**: Configure calculation types and rates per installment.
3.  **Styles**: Personalize the look and feel to match your theme.

## 📋 Requirements

- **Magento** 2.4.x
- **PHP** 8.1+

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
