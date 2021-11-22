# Shopify App Development - Vanilla PHP, GraphQL, & REST API

This repo are essentially notes from the Udemy Course listed above


## Initial Set ups

course utilizes xampp server and ngrok to tunnel it to shopify

### Setting up ngrok

1. create an account at - https://shopify.dev/docs/admin-api/rest/reference/online-store/scripttag
2. download ngrok and move ngrok.exe into your project folder located in xampp web root (localhost/some_project_folder or xampp/htodcs/some_project_folder)
3. ngrok will give a token to run locally in xampp's web root


### starting up the dev environment

Need to start up xampp and ngrok

#### On xampp

open up XAMPP Control Panel and start Apache & MySQL

#### ngrok

in your project folder run the following...

```
ngrok http 80 
# or 443, whatever XAMPP ports show for Apache
```