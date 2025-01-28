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

## Attributes

## Notes

## Version History
- 1.2.1.0 - "Delete Card" will remove all cards by profileId, not just first.
