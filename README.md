# Symfony 5 + Stripe
This is a simple Symfony 5 app that test shows how to integrate a PHP website with Stripe payments Gateway.

It has a simple product listing page, a shopping cart and a checkout form integrated with Stripe.

The Stripe integration was done following these docs:
https://stripe.com/docs/payments/accept-a-payment

The class that implements the server side logic is here:
stripe_demo/src/Service/StripePaymentService.php

The client side markup that contains Stripe HTML elements is here:
stripe_demo/templates/cart/checkout.html.twig

The client side code that handles Stripe payment submit logic is here:
stripe_demo/assets/js/app.js

## Configuration
This app requires a test key and secret to use the Stripe API.
You can get the keys in this page (you must be logged in on your Stripe account):
https://stripe.com/docs/keys

Setup these values on the `stripe_demo/.env.local` before running the app:
```
STRIPE_API_KEY=...
STRIPE_API_SECRET=...
```

## Docker Setup
This app uses Docker to setup the development environment,
specifically it uses a Bitnami image. See docs for the Docker image here:
https://hub.docker.com/r/bitnami/symfony

To build the app execute the following commands:
```
cd symfony-stripe-demo
docker-compose up
```

To copy dummy product images to public folder and build app js files
execute the following commands (having `yarn` installed on your system is required):
```
cd symfony-stripe-demo/stripe_demo
yarn install
yarn encore dev
````

To fill the database with dummy data execute the following commands:
```
docker-compose run myapp php stripe_demo/bin/console doctrine:schema:update --force
docker-compose run myapp php stripe_demo/bin/console hautelook:fixtures:load
```

## Running the app
*You can access the demo website on your browser here:*
https://localhost:8000/

You can use the following credit cards on the Checkout form:
https://stripe.com/docs/payments/accept-a-payment#web-test-integration

Feel free to test your Stripe integration as much as you want,
this app should have no problem to integrate with your Stripe account as of April, 2020.
