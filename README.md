# Magento 2 - Inventory Log

This extension was originally written by [KiwiCommerce](https://kiwicommerce.co.uk) but has been archived since November 2020. Since we (at [elgentos](https://elgentos.nl)) feel this extension is the best inventory logger extension available, we decided to adopt it.

## Overview
- Keep the log of product inventory for every single transaction. Ex. Product import, Order placed, Insert/Update operation through queries and lot more.
- Admin knows when and why the inventory changed.
- This extension keeps a log of inventory when:
	- Order placed from frontend, admin and API
	- Product import
	- Manually product inventory change by admin
	- Directly inventory insert update in a database
	- Product created using API
	- Credit Memo generation
	- Order fail and Cancel
	
## Installation

This extension has been tested on Magento 2.1.x, 2.2.x, 2.3.x and 2.4.x.
 
```
composer require elgentos/magento2-inventory-log
php bin/magento setup:upgrade
```

## Features

Navigate to Product > Catalog and Click on edit link of the product. Then click 'Inventory Log' under Quantity option.

![image](https://user-images.githubusercontent.com/431360/119259479-cb18f680-bbce-11eb-887c-d828e1ffa6e3.png)


### Configuration

You need to follow this path. Stores > Configuration > Catalog > Inventory > Stock Options > Inventory Log Enabled.


## Constraints
- Database user must have to get the create trigger permission in order to use this extension.
- After enabling disabled extension using the command, admin/user will have to enable the extension again from the store configuration.

## Contribution
Lots of thanks goes to <a href="https://kiwicommerce.co.uk">KiwiCommerce</a> for initially developing this extension. We know open-source maintenance is hard, so we appreciate it!
