<?php
$currPage = "auth_Login";
include 'app/require_once/page_controller.php';
include 'app/functions/auth/login.php';
?>

<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">

        <?php if(isset($_POST["login"]) && !empty($erro_msg)) { echo sendError($erro_msg); } ?>
        <?php if(isset($_COOKIE['account_success'])){ echo sendSuccess('Bitte bestätige nun deine E-Mail!'); } ?>
        <?php if(isset($_COOKIE['email_success'])){ echo sendSuccess('Du kannst dich nun einloggen!'); } ?>

        <div class="panel">
            <div class="panel-body">
                <div class="brand">
                    <img src="<?php echo $picUrl; ?>logo/auth-logo.png" height="100px">
                </div>
                <form method="post">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" id="emailaddress" name="user_name" />
                        <label class="floating-label">Benutzername</label>
                    </div>
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="password" class="form-control" id="password" name="user_password" />
                        <label class="floating-label">Passwort</label>
                    </div>
                    <div class="form-group clearfix">
<!--                        <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">-->
<!--                            <input type="checkbox" id="inputCheckbox" name="remember">-->
<!--                            <label for="inputCheckbox">Remember me</label>-->
<!--                        </div>-->
                        <a class="float-right" href="<?php echo $url; ?>passwort_reset">Passwort vergessen?</a>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-block btn-lg mt-40">Login</button>
                </form>
                <p>Du hast noch keinen Account? <a href="<?php echo $url; ?>register">Account erstellen</a></p>
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