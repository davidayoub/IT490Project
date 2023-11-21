<?php
require(__DIR__."/../partials/nav.php");
//require(__DIR__."/server_functions/auth_server.php")
?>

<!-- RD Mailform--->
<div class="same_font">
    <h2>Contact us!</h2>
    <div class="wrapper">
        <form class="rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php" onsubmit="return validateForm()" name="myForm">
            <input type="hidden" id="page" name="page" value="login.php">
            <input type="hidden" id="form-type" name="form-type" value="contact">
            <div class="row">
                <div class="form-group col-lg-6">
                    <label class="form-label mb-1 text-2">Full Name</label>
                    <input class="form-control" id="name" name="name" type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control text-3 h-auto py-2" required="">
                </div>
                <div class="form-group col-lg-6">
                    <label class="form-label mb-1 text-2">Email Address</label>
                    <input type="email" id="email" type="email" name="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control text-3 h-auto py-2" required="">
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label class="form-label mb-1 text-2">Message</label>
                    <textarea maxlength="5000" class="form-control" id="message" name="message" data-msg-required="Please enter your message." rows="8" class="form-control text-3 h-auto py-2" required=""></textarea>
                </div>
            </div>
            <br>
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptcha_PUBLICKEY); ?>" name="g-recaptcha-response"></div>
            <br>
            <div class="row">
                <div class="form-group col">
                    <input type="submit" class="button button-block btn btn-light" data-loading-text="Loading...">
                </div>
            </div>
        </form>
    </div>
</div>

<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="js/core.min.js"></script>


<?php
require(__DIR__ . "/../partials/footer.php");
?>
