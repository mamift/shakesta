API: 
Accessible via www.shakesta.com/api/v1.1/
Protected via HTTP basic authentication.

Default API User account:s

API routes:



User guide to the web app 

==== ADMIN USERS ====
login with default admin account:
username: "admin"
password: "gizmoe99"

Can create new retailers,
Can create new users for retailers (users without a retailer asisnged are admin users)
Can create new products for retailers
Can create new deals for products

Can change passwords for all users
Can change user types from admin to retailer and vice versa

Can view all retailers, users, products, and deals for everyone


==== RETAIL USERS ====
Can create new products for themselves
Can create new deals for their own products

Can only view their own deals 
Can only view their own products

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
]

Every single command is a POST route, that returns JSON data; the only piece of data that must be POST'ed is the API key. Every request must have a valid API key, using the 'apikey=' prefix. Using GET requests will not work and return an error.
For example, using the 'curl' command on linux: 

	curl -d 'apikey=key5386ea461f9568.70167308' shakesta.com/api/v1.1/deals/all/expired

API keys are bound to user accounts. An API key is made everytime a new user is made. Go to the user page to see your API key.

The API can be interfaced using the following URL endpoints:

1. www.shakesta.com/api/v1.2/deals/apikey={apikey}						
2. www.shakesta.com/api/v1.2/deals/apikey={apikey}/all 				
	- www.shakesta.com/api/v1.2/deals/apikey={apikey}/all/current 		
	- www.shakesta.com/api/v1.2/deals/apikey={apikey}/all/expired 		
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
