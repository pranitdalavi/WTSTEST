<?php
require __DIR__.'/includes/config.php';
require('header.php');
?>

    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <div class="container mb-0 mt-30" style="margin-bottom: 100px;margin-top: 100px;">
        <h1 class="text-center">The payment gateway has been deactivated, but the order has been created in a "pending" status.</h1>
    </div>

    <script type="text/javascript">
        var stripe = Stripe("");
        var checkoutButton = document.getElementById("checkout-button");

        window.addEventListener('load', function () {
            fetch("create-checkout-session.php", {
                method: "POST",
            })
                .then(function (response) {

                    return response.json();
                })
                .then(function (session) {
                    console.log(session)
                    return stripe.redirectToCheckout({ sessionId: session.id });
                })
                .then(function (result) {
                    // If redirectToCheckout fails due to a browser or network
                    // error, you should display the localized error message to your
                    // customer using error.message.
                    if (result.error) {
                        alert(result.error.message);
                    }
                })
                .catch(function (error) {
                    console.error("Error:", error);
                });
        });
    </script>


<?php require('footer.php'); ?>