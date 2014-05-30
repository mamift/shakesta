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
The API can be interfaced with using this URL:
www.shakesta.com/api/v1/

The API has

www.shakesta.com/api/v1.1/deals
www.shakesta.com/api/v1.1/deals/all
www.shakesta.com/api/v1.1/deals/all/unexpired
www.shakesta.com/api/v1.1/deals/all/expired
www.shakesta.com/api/v1.1/deals/today
www.shakesta.com/api/v1.1/deals/week
www.shakesta.com/api/v1.1/deals/show/{id}