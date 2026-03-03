# Magento 2 Installment & Discounts

[![Magento 2.4.x](https://img.shields.io/badge/Magento-2.4.x-brightgreen.svg)](https://magento.com/)
[![Hyvä Compatible](https://img.shields.io/badge/Hyv%C3%A4-Compatible-yellow.svg)](https://hyva.io/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A powerful and flexible Magento 2 module designed to display installment values and strategic discounts directly on your storefront catalog and product pages. Now fully compatible with **Hyvä Themes** while maintaining support for **Luma/Standard** themes.

## 🚀 Features

- **Multi-Theme Support**: Native support for **Hyvä Themes** (Alpine.js) and **Luma/Standard** themes (jQuery).
- **Installment Display**: Show installment options across Product, Category, and Search pages.
- **Strategic Discounts**: Display custom discounts (e.g., PIX, Bank Transfer) with automatic calculation and deduplication.
- **Configurable Logic**: 
  - Define maximum installments and minimum installment value.
  - Support for **Simple** and **Compound** interest calculations.
- **Customizable Interest**: Set specific interest rates for each installment level.
- **Flexible Templates**: Specific price templates for `catalog_category_view`, `catalogsearch_result_index`, and `catalog_product_view`.
- **Custom Styling**: Control primary colors, highlight text colors, and font weights directly from the admin panel.

## ⚡ Hyvä Integration

This module is built to leverage Hyvä's performance:
- **Alpine.js Components**: Lightweight and reactive installment calculations.
- **Tailwind CSS**: Automatically registers module templates for the Tailwind CSS build process.
- **CSP Compatible**: All JavaScript components are built to comply with Content Security Policy.

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

### For Hyvä Themes

To ensure Tailwind classes are generated correctly for your theme:
```bash
bin/magento hyva:config:generate
```

## ⚙️ Configuration

Navigate to **Stores > Configuration > Backendorf > Installment** to configure:

1.  **General Settings**: Enable/Disable the module, set installment limits, and display behavior.
2.  **Interest Rates**: Configure calculation types and specific rates per installment.
3.  **Discounts**: Add dynamic discount rules based on percentages.
4.  **Price Templates**: Customize the HTML output for different page types.
5.  **Styles**: Personalize the look and feel (colors and typography) to match your brand.

## 📋 Requirements

- **Magento** 2.4.x
- **PHP** 8.1+
- **Hyvä Themes** (Optional, but fully supported)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
