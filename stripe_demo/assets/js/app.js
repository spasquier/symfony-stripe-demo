import '../css/app.css';

var card;

jQuery(document).ready(function() {
    // Basic validation for shipping address form elements
    var forms = document.getElementsByClassName('needs-validation')
    Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    });

    // Stripe Payment Setup
    if (typeof stripe != "undefined") {
        // Setup Stripe Card HTML element
        card = elements.create("card", {
            style: {
                base: {
                    color: "#32325d",
                }
            }
        });
        card.mount("#card-element");
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
              displayError.textContent = event.error.message;
            } else {
              displayError.textContent = '';
            }
        });

        // Setup form submit event (this form includes Stripe Card HTML element)
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(ev) {
            document.getElementById('payment-spinner').setAttribute('style', '');
            ev.preventDefault();
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: document.getElementById('firstName').value + ' ' + document.getElementById('lastName').value
                    }
                }
            }).then(function(result) {
                var displayError = document.getElementById('card-errors');
                if (result.error) {
                    displayError.textContent = result.error.message;
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        window.setTimeout(function(){
                            window.location.href = '/cart/checkout/success';
                        }, 3000);
                    } else {
                        displayError.textContent = "Payment did not succeed with status: " + result.paymentIntent.status;
                    }
                }
                document.getElementById('payment-spinner').setAttribute('style', 'display:none;');
            });
        });
    }
});
