# Symfony 5 + Stripe

This is a simple Symfony 5 app that test shows how to integrate a website with Stripe payments Gateway.

It has a simple product listing/detail page, a shopping cart, and a checkout form integrated with Stripe.

It requires Stripe test key/secret to access the Stripe API.
Setup the values on the `stripe_demo/.env` file in order to be able to use the API:
```
STRIPE_TEST_KEY=...
STRIPE_TEST_SECRET=...
```

## Docker

This app uses Docker to setup the development environment, specifically it uses a Bitnami image.
See docs for the Docker image here:
https://hub.docker.com/r/bitnami/symfony
