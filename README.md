# Magento2 Module ECInternet Paytelligence
``ecinternet/paytelligence - 1.3.3.0``

- [Requirements](#requirements-header)
- [Overview](#overview-header)
- [Installation](#installation-header)
- [Configuration](#configuration-header)
- [Specifications](#specifications-header)
- [Attributes](#attributes-header)
- [Notes](#notes-header)
- [Version History](#version-history-header)

## Requirements

## Overview

## Installation
- Extract the zip to your Magento 2 root directory to create the following folder structure: `app/code/ECInternet/Paytelligence`
- Enable the module by running `php bin/magento module:enable ECInternet_Paytelligence`
- Apply database updates by running `php bin/magento setup:upgrade`
- Recompile code by running `php -f bin/magento setup:di:compile`
- Flush the cache by running `php bin/magento cache:flush`

## Configuration

## Specifications
### Custom NNCARD Columns
- `last_order_id`
### Custom NNTRANS Columns
| Column                  | Description                    | Definition    | When Set                              | When Read                         |
|-------------------------|--------------------------------|---------------|---------------------------------------|-----------------------------------|
| `parent_card_id`        | The parent card ID             | `int(11)`     | When a new card is added to a profile | When a card is added to a profile |
| `increment_id`          | The Magento order increment ID | `varchar(32)` | When a new card is added to a profile | When a card is added to a profile |
| `order_id`              | The Magento order ID           | `int`         | When a new card is added to a profile | When a card is added to a profile |
| `customer_id`           | The Magento customer ID        | `int(11)`     | When a new card is added to a profile | When a card is added to a profile |
| `parent_transaction_id` | The parent transaction ID      | `int(11)`     | When a new card is added to a profile | When a card is added to a profile |
| `area_code`             | The Magento area code          | `varchar(20)` | When a new card is added to a profile | When a card is added to a profile |
| `sage_idcust`           | The Sage customer ID           | `varchar(12)` | When a new card is added to a profile | When a card is added to a profile |
| `sage_nntrans_id`       | The Sage transaction ID        | `int(11)`     | When a new card is added to a profile | When a card is added to a profile |

## Attributes

## Notes

## Version History
- 1.2.1.0 - "Delete Card" will remove all cards by profileId, not just first.
