# Customer Product Manager (CPM) / SaaS Membership Module v2.3.2 for OpenCart

A multi-seller membership extension for OpenCart v1.5. This membership system gives members the ability to create and sell products on your e-commerce store.

Demo site:
- Member Demo:  http://opencart.garudacrafts.com/1561/ (member@garudacrafts.com, testmember)
- Admin Demo:  http://opencart.garudacrafts.com/1561/admin/ (demo, demo)

Installation instructions and more:
- Installation and Upgrade Instructions:  http://www.garudacrafts.com/opencart/1561/installation-info
- Frequently Asked Questions (FAQ):  http://www.garudacrafts.com/opencart/1561/faq
- Changelog:  http://www.garudacrafts.com/opencart/1561/changelog
- Features:  http://www.garudacrafts.com/opencart/1561/features
- Modified Files: http://www.garudacrafts.com/opencart/1561/modified-files
- Screenshots: http://www.garudacrafts.com/opencart/1561/screenshots

## Requirements
- OpenCart v1.5.3.x - v1.5.6.x
- vQmod (http://code.google.com/p/vqmod/)

## Installation Instructions
1. BACKUP your website (files and database) before making any changes
2. Upload all the files in "upload" folder to your store's site root (NO files should be overwritten!)
3. If your OpenCart version is less than v1.5.6, then:
     - copy to your vQmod directory (/vqmod/xml/) the vQmod XML file in /upload-bonus/vqmod/xml/ that corresponds to your OC version
     - install it by removing the "_" from the end of the file extension or use vQmod Manager extension (recommended).
4. Enable Permissions on module "module/cpm" at Admin->System->Users->User Groups->edit Permissions
5. Install module at Admin->Extensions->Modules->Customer Product Manager (CPM)->Install (you should see a confirmation message that the database tables were updated successfully)
6. Configure and edit module settings following the instructions provided at Admin->Extensions->Modules->Customer Product Manager (CPM)->Edit->Info tab
7. Configure and enable existing Customer Accounts at Admin->Sales->Customers->Customers->Edit->CPM tab; or create new Member accounts through the new front-end Member registration page

*NOTE:* "bonus" files in "/upload-bonus" directory are provided as extra code snippets and DO NOT come with support. Use at your own discretion!

If you have any issues after installation, please check the FAQ (Frequenty Asked Questions) first! http://www.garudacrafts.com/opencart/1561/faq

## Changelog
### v2.3.2
- updated Admin Members and Admin Customers pages
	- moved CPM-Enable/CPM-Disable buttons and column from Admin Customers List pages to Admin Members List page
	- added "Member Account" Yes/No column to Customers List page
	- renamed Admin pages: "CPM-Enabled" -> "Members", "CPM-Disabled" -> "Non-Members", and "Members" -> "Memberships"
	- various misc improvements, small bug fixes, and new features added to Admin Memberships page
- added new Members Module to display a list of Members in multiple front-end module position and layout configurations
- added new Enable/Disable buttons to Member Product Manager
- minor misc improvements to code stucture of Member Product Manager
- included "bonus" zip file of new multiple-file image upload support for Member Image Manager (NOT supported: code adpated from another developer, http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8221, and modified for CPM; use at your own discretion)
- fixed bug in copying over product downloads when Copy button on Member Product Manager is used to create a new product

### v2.3.1
- fixed error message when editing a product using the Member Product Manager for OpenCart versions 1.5.5.x and earlier
- fixed & updated styling on Member Sales Report
- updated size of image on Member profile page to default Category image size from default Product image size
- removed obsolete files

### v2.3.0
- added almost 50 NEW Admin module config settings, including:
	- auto-approve new Products created by Members
	- send alert email to Admin when new Product created by Members
	- enable/disable Members List Page and Member Pages
	- added image, name, description, meta_description, meta_keyword, and SEO keyword for Members List Page
	- enable/disable link to Members List Page on Nav Menu
	- enable/disable Member Product Manager
	- show/hide 20+ data fields on Member Product Manager
	- enable/disable Member Registration Pages
	- auto-generate SEO URL alias keyword for new Member Accounts
	- auto-generate private Image Directory and private Downloads Directory for new Member Accounts
	- enable/disable PayPal data field for Member Accounts
	- require PayPal data field for Member Accounts
	- enable/disable Member Reports
	- restrict Products listed on Member Sales Info Page to only those owned by the Member versus all Products on the Order
	- enable/disable Member access to update Order Status
	- show/hide Commission on Sales Report
	- show/hide Tax on Sales Report
	- add/subtract Tax to Totals on Sales Report
	- set number of products per page on Product Listing Views Report
	- ...and more!
- added new Admin Members page under Admin->Catalog->Members to manage Memberships
- added feature to move Membership from one Customer Account to another
- replaced "CPM" tab with "Membership" tab on Admin Customer form
- updated Member Product Manager
	- added Product Filters
	- added Profiles
	- added 3rd-level Sub-Categories and deeper
	- added field validation on required data fields
	- data fields displayed based on Admin module config settings
- added Members filter to Search page
- added Product Images and Member Names to Order emails
- updated Image Manager file upload error messaging
- updated layout of Admin Module Settings page and added default values for many settings
- consolidated code and files
- misc additional updates
- various minor bug fixes

Author: Derek McKee - Garuda Crafts Web Development - derek@garudacrafts.com
Copyright: Copyright (c) 2013-2014, Derek McKee

