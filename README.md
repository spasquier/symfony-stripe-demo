# Symfony 5 + Stripe

This is a simple Symfony 5 app that test shows how to integrate a website with Stripe payments Gateway.

It has a simple product listing/detail page, a shopping cart, and a checkout form integrated with Stripe.

## Configuration

This app requires a test key and secret to access the Stripe API.
Setup the values on the `stripe_demo/.env.local` file in order to be able to use the API:
```
STRIPE_TEST_KEY=...
STRIPE_TEST_SECRET=...
```

## Docker

This app uses Docker to setup the development environment,
specifically it uses a Bitnami image. See docs for the Docker image here:
https://hub.docker.com/r/bitnami/symfony

To start the app just execute the following command on the repo root:
```
cd symfony-stripe-demo
docker-compose up
```

You can acess it from your browser here:
https://localhost:8000/

To copy assets (images) to public folder execute the following commands
(install yarn before executing this if you don't have it on your system):
```
yarn install
yarn encore dev
```` 

To fill the database with dummy product data for demo purposes execute:
```
docker-compose run myapp php stripe_demo/bin/console hautelook:fixtures:load
```