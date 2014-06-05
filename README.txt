API: 
Accessible via www.shakesta.com/api/v1.2/
Protected via API key token authentication

API routes:

User guide to the web app 

==== ADMIN USERS ====
The default admin account:
username: "admin"
password: "gizmoe99"

The admin user, along with other admin users:

Can create new clients.
Can create new users for client (users without a client assigned are admin users).
Can create new products for client.
Can create new deals for products.

Can change passwords for all users.
Can change user types from admin to retailer and vice versa.

Can view all clients, users, products, and campaigns for everyone.

Basically admin users can do everything.

The default "admin" user cannot delete itself, nor be deleted by anyone else. The "admin" user can however, change its password.

==== CLIENT USERS ====
Can create new products for themselves.
Can create new campaigns (deals) for their own products.

Can only view their own campaigns.
Can only view their own products.

Procedure for creating new campaigns (deals):
	- Create a new product (include at least the title, and original price)
	- Create a new campaign (choose the existing product to use, then spefiy a title, discount price, terms, begin time and end time and category)
	- For now only admin users can create new campaign categories; this is a decision intended to stymie the proliferation of duplicate and very similar category names.

==== API ====
The API can be interfaced with using this base URL:
	www.shakesta.com/api/v1.1/

Making a simple get request to www.shakesta.com/api/v1.1 will return a list of commands like so:
"commands": [
	"deals",
	"deals/all",
	"deals/all/unexpired",
	"deals/all/expired",
	"deals/today",
	"deals/week",
	"deals/show/{id}"
	"categories",
	"bycategory/{category}"
]

Every single command is a GET route, that returns JSON data; the only piece of data that must be GET'ed is the API key. Every request must have a valid API key, using the 'apikey=' prefix. 
For example, using the 'curl' command on linux: 

	curl -d 'apikey=key5386ea461f9568.70167308' shakesta.com/api/v1.1/deals/all/expired

API keys are bound to user accounts. An API key is made everytime a new user is made. Go to the user page to see your API key.

The API can be interfaced using the following URL endpoints:

1. www.shakesta.com/api/v1.2/deals/apikey={apikey}				
2. www.shakesta.com/api/v1.2/deals/apikey={apikey}/all 	
-  www.shakesta.com/api/v1.2/deals/apikey={apikey}/all/current		
-  www.shakesta.com/api/v1.2/deals/apikey={apikey}/all/expired
3. www.shakesta.com/api/v1.2/deals/apikey={apikey}/today	 			
4. www.shakesta.com/api/v1.2/deals/apikey={apikey}/week			
5. www.shakesta.com/api/v1.2/deals/apikey={apikey}/show/{id}			
6. www.shakesta.com/api/v1.2/deals/apikey={apikey}/categories
7. www.shakesta.com/api/v1.2/deals/apikey={apikey}/bycategory/{category}

The URL's explained:

1. grabs all current (unexpired) deals, in paginated form, ten at a time (add /?page=n to grab more deals, i.e. (www.shakesta.com/api/v1.1/deals/?page=2 for more data) 
2. grabs all unexpired and expired deals (not paginated)
3. grabs all deals that began today (not paginated)
4. grabs all deals that began at the beginning of this week (a week defined as being Sun to Sat, not paginated)
5. show only one particular deal, by id number (provide the id number after /show/) i.e.
	- www.shakesta.com/api/v1.1/deals/show/29
6. show all deal categories
7. show deals for a single category (paginated, add ?page=2 for more data)
