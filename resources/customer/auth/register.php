<?php
$currPage = "auth_Register";
include 'app/require_once/page_controller.php';
?>

<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">

        <?php
        include 'app/functions/auth/register.php';
        if(isset($_POST["register"]) && !empty($erro_msg)) { echo sendError($erro_msg); }
        ?>

        <div class="panel">
            <div class="panel-body">
                <div class="brand">
                    <img src="<?php echo $picUrl; ?>logo/auth-logo.png" height="100px">
                </div>
                <form method="post">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" id="username" name="user_name" />
                        <label class="floating-label">Benutzername</label>
                    </div>

                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" id="email" name="user_email" />
                        <label class="floating-label">E-Mail</label>
                    </div>

                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="password" class="form-control" id="password" name="user_password" />
                        <label class="floating-label">Passwort</label>
                    </div>

                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="password" class="form-control" id="password" name="user_password_confirm" />
                        <label class="floating-label">Passwort wiederholen</label>
                    </div>

<!--                    <div class="form-group clearfix text-xs-center">-->
<!--                        <div class="g-recaptcha" data-sitekey="null"></div>-->
<!--                    </div>-->

                    <button type="submit" name="register" class="btn btn-primary btn-block btn-lg mt-40">Account erstellen</button>
                </form>
                <p>Du hast schon einen Account? <a href="<?php echo $url; ?>login">Zum Login</a></p>
            </div>
        </div>

        <footer class="page-copyright page-copyright-inverse">
            <p>© 2019 NXTByte, alle rechte vorbehalten.</p>
            <div class="social">
                <a class="btn btn-icon btn-pure" href="https://twitter.com/NXTByteNET">
                    <i class="icon bd-twitter" aria-hidden="true"></i>
                </a>
                <a class="btn btn-icon btn-pure" href="https://www.youtube.com/channel/UCUn2mF1_mZ4iPVn1T6WgSCQ">
                    <i class="icon bd-youtube" aria-hidden="true"></i>
                </a>
            </div>
        </footer>
    </div>
</div>