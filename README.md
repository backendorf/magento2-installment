## Description
 Basically, this module makes it possible to display the installment values and discounts on the frontend.

## Installation
> - `composer require backendorf/module-installment`
> - `bin/magento setup:upgrade && bin/magento setup:di:compile`
> - Navigate to "Shop->Configuration->Backendorf->Installment" and configure the options.
> - Clear the cache.

## Prerequisites
> - The module is compatible with Magento 2.x.x

## Dependencies
> - Magento_Catalog

# Features
> - Maximum number of installments;
> - Minimum installment value;
> - Show all installment options on the product page;
> - Show first installment;
> - Interest calculation type (simple or compound);
> - Percentage of interest on each installment (up to 12th);
> - Show the lowest parcel in the cart;
> - Multiple discounts;
> - Configure price templates for the main catalog pages;
