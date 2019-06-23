<?php
$currPage = "auth_Login";
include 'app/require_once/page_controller.php';
?>

<?php if(isset($_GET['key']) && !empty($_GET['key'])){ $key = $_GET['key']; ?>
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
        <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">

            <?php include 'app/functions/auth/forgot_password.php'; ?>

            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <h4>Passwort vergessen</h4>
                    </div>
                    <form method="post">

                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="password" class="form-control" id="new_password" name="new_password" />
                            <label class="floating-label">Neues Passwort</label>
                        </div>
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="password" class="form-control" id="new_password_repeat" name="new_password_repeat" />
                            <label class="floating-label">Neues Passwort wiederholen</label>
                        </div>
						<input value="<?= $key; ?>" hidden name="key">

                        <button type="submit" name="resetPW" class="btn btn-primary btn-block btn-lg mt-40">Passwort ändern</button>
                    </form>
                    <p>Du weißt dein Passwort doch? <a href="<?php echo $url; ?>login">Zum Login</a></p>
                </div>
            </div>

            <footer class="page-copyright page-copyright-inverse">
                <p>© 2019 NXTByte, alle rechte vorbehalten.</p>
                <div class="social">
                    <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                        <i class="icon bd-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                        <i class="icon bd-facebook" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                        <i class="icon bd-google-plus" aria-hidden="true"></i>
                    </a>
                </div>
            </footer>
        </div>
    </div>
<?php } else { ?>
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
        <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">

            <?php include 'app/functions/auth/forgot_password.php'; ?>

            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <h4>Passwort vergessen</h4>
                    </div>
                    <form method="post">

                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" id="user_info" name="user_info" />
                            <label class="floating-label">Benutzername / E-Mail</label>
                        </div>

                        <button type="submit" name="requestReset" class="btn btn-primary btn-block btn-lg mt-40">Passwort reset anfordern</button>
                    </form>
                    <p>Du weißt dein Passwort doch? <a href="<?php echo $url; ?>login">Zum Login</a></p>
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
<?php } ?>