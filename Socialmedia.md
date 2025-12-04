To get a Page Access Token:
Go to Facebook Graph API Explorer https://developers.facebook.com/tools/explorer/
Select your app
Get a User Access Token with pages_manage_posts permission
Exchange it for a Page Access Token by calling:
   GET /me/accounts
Copy the access_token from the response for your page
Add it to FACEBOOK_PAGE_ACCESS_TOKEN in your .env file


Alternatively, you can:
Go to Admin Settings → Settings → Facebook Page Integration
Enter the Page Access Token there
Click "Test Connection" to verify it works


//////////////////////////////////////////////////////////

