# Magento 2 Installment

A simple Magento 2 module that displays installment values and discounts on the storefront.

## Installation
- composer require backendorf/module-installment
- bin/magento setup:upgrade && bin/magento setup:di:compile
- Stores > Configuration > Backendorf > Installment — configure options
- Clear the cache (bin/magento cache:flush)

## Compatibility
- Magento 2.x

## Dependency
- Magento_Catalog

## Features
- Show installment options and first installment
- Configure maximum installments and minimum installment value
- Choose interest calculation (simple or compound)
- Set interest per installment (up to 12)
- Show the lowest installment in the cart
- Multiple discounts
- Price templates for main catalog pages
