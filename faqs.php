<?php
require __DIR__ . '/includes/config.php';
$meta_title = COMPANY_NAME . ' | Frequently Asked Questions';
require 'header.php';
?>

<style>
    p {
        font-size: 16px;
        font-weight: 400;
    }

    h2 {
        font-weight: 500;
        font-size: 20px;
    }

    li {
        font-weight: 400;
        font-size: 14px;
    }

    h1 {
        font-size: 25px;
        font-weight: 600 !important;
    }

    email {
        text-transform: lowercase;
        word-spacing: -3px;
    }

    .accordion {
        background-color: #3a004a !important;
        color: #fff;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        border: 1px solid #fff;
    }

    .active,
    .accordion:hover {
        background-color: #ccc;
    }

    .panel {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
    }
</style>

<div class="container" style="padding-bottom: 40px;padding-top: 30px; color:black;">

    <h1>Frequently Asked Questions</h1>
    <hr>

    <p class="text-left">
        Here at Comofort Beds we have a great customer service team to answer any questions and offer advice when it comes to buying your new bed or mattress. Use our contact us form to send us any queries or call the customer service line on <a href="tel:0113 418 0408">0113 418 0408</a>. <br /><br />

        To help assist with common questions, please see below:
    </p>


    <button class="accordion">Where are your products made?</button>
    <div class="panel">
        <p><br />
            We are a UK manufacturer with all our beds and mattresses being made in the heart of West Yorkshire.
        </p>
    </div>

    <button class="accordion">Do you have a showroom?</button>
    <div class="panel">
        <p><br />
            Unfortunately, we do not have a showroom and all products are shown online. This is simply to reduce costs and pass the savings onto the buyer. Should you be undecided, our experts will guide you through the selection process to ensure we find you the perfect bed.
        </p>
    </div>

    <button class="accordion">Do I get a guarantee with my products?</button>
    <div class="panel">
        <p><br />
            When you shop with Comofort Beds, you are investing in a product that will stand the test of time. Our beds and mattresses are handcrafted by a highly skilled team in our own UK factory. Our skilled workforce use the very best materials and manufacturing methods to ensure our products are both attractive and versatile. We are proud of our products and offer a 3 year guarantee on everything we sell. Read the full details about this on our warranty & guarantee page.
        </p>
    </div>

    <button class="accordion">How long will my order take once purchased?</button>
    <div class="panel">
        <p><br />
            All our beds and mattresses are made to order and therefore we will indicate a lead time for each product. Generally speaking, you are looking at 3 - 7 days from order date to dispatch. Once dispatched you will receive notification that your goods are in transit to you.
        </p>
    </div>

    <button class="accordion">What if my product is damaged in transit or incorrect?</button>
    <div class="panel">
        <p><br />
            In the unlikely event this should happen please contact us on <a href="tel:0113 418 0408">0113 418 0408</a> or email us at <a href="mailto:info@comfortbedsltd.co.uk">info@comfortbedsltd.co.uk</a> to resolve the issue. In some cases we may have to arrange an uplift of products; however, our customer service team will discuss the options with you.
        </p>
    </div>

    <button class="accordion">Will you install my bed, headboard or mattress and take away my old one?</button>
    <div class="panel">
        <p><br />
            If you need us to install your bed, headboard and mattress in your property, then we are happy to offer an additional service for this, at a fee of £39.99 per delivery. Our trained experts will deliver your new bed to your room, build your new bed, headboard and/or mattress and ensure this is correctly and securely fitted. <br /> <br />

            We will take all rubbish away, leaving you ready to enjoy your new purchase instantly.<br /> <br />

            If you have an existing bed or mattress, then we can take this away for you as an additional service for just £25.00.
        </p>
    </div>

    <button class="accordion">Will your headboards fit my base?</button>
    <div class="panel">
        <p><br />
            All our headboards are made to UK standard bed sizes. If your bed is a standard UK bed size, you can be confident that our headboards will fit.
        </p>
    </div>

</div>


        

    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
            panel.style.display = "none";
                } else {
            panel.style.display = "block";
            }
    });
}
    </script>


<?php require 'footer.php'; ?>