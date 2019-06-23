<div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">

        <ul class="site-menu" data-plugin="menu">

            <li class="site-menu-item has-sub <?php if($currPage == 'back_Dashboard'){ echo 'active'; } ?>">
                <a href="<?php echo $url; ?>dashboard">
                    <i class="site-menu-icon wb-home" aria-hidden="true"></i>
                    <span class="site-menu-title">Dashboard</span>
                </a>
            </li>

            <li class="site-menu-item has-sub <?php if($currPage == 'back_Bestellen'){ echo 'active'; } ?>">
                <a href="<?= $url; ?>service/order">
                    <i class="site-menu-icon wb-shopping-cart" aria-hidden="true"></i>
                    <span class="site-menu-title">Bestellen</span>
                </a>
            </li>

            <li class="site-menu-item has-sub <?php if($currPage == 'back_Meine Produkte'){ echo 'active'; } ?>">
                <a href="<?php echo $url; ?>service/list">
                    <i class="site-menu-icon wb-grid-4" aria-hidden="true"></i>
                    <span class="site-menu-title">Produkte</span>
                </a>
            </li>

            <li class="site-menu-item has-sub <?php if($currPage == 'back_Guthaben'){ echo 'active'; } ?>">
                <a href="<?= $url; ?>guthaben/aufladen">
                    <i class="site-menu-icon fa-money" aria-hidden="true"></i>
                    <span class="site-menu-title">Guthaben</span>
                </a>
            </li>

            <li class="site-menu-item has-sub <?php if($currPage == 'back_Buchhaltung'){ echo 'active'; } ?>">
                <a href="<?= $url; ?>account/payments">
                    <i class="site-menu-icon wb-book" aria-hidden="true"></i>
                    <span class="site-menu-title">Buchhaltung</span>
                </a>
            </li>

            <li class="site-menu-item has-sub <?php if($currPage == 'back_Mein Account'){ echo 'active'; } ?>">
                <a href="<?php echo $url; ?>profil">
                    <i class="site-menu-icon wb-user" aria-hidden="true"></i>
                    <span class="site-menu-title">Account</span>
                </a>
            </li>

            <?php if(!$role->isInTeam($odb, $_SESSION['id'])){ ?>
            <li class="site-menu-item has-sub  <?php if($currPage == 'back_Support'){ echo 'active'; } ?>">
                <a href="<?= $url; ?>support">
                    <i class="site-menu-icon wb-help" aria-hidden="true"></i>
                    <span class="site-menu-title">Support</span>
                </a>
            </li>
            <?php } ?>

            <?php if(isset($_COOKIE['support_login'])){ ?>
            <hr>
            <li class="site-menu-item has-sub">
                <a href="<?= $url; ?>team_logout">
                    <i class="site-menu-icon fas fa-undo-alt" aria-hidden="true"></i>
                    <span class="site-menu-title">Zurück zum ACP</span>
                </a>
            </li>
            <?php } ?>

            <?php if($role->isInTeam($odb, $_SESSION['id'])){ ?>
            <hr>
            <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                    <span class="site-menu-title">Administration</span>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item">
                        <a class="animsition-link" href="<?php echo $url; ?>team/tickets">
                            <span class="site-menu-title">Ticketverwaltung</span>
                        </a>
                    </li>
                    <?php if($role->isAdmin($odb, $_SESSION['id'])){ ?>
                        <li class="site-menu-item">
                            <a class="animsition-link" href="<?php echo $url; ?>team/settings">
                                <span class="site-menu-title">Einstellungen</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a class="animsition-link" href="<?php echo $url; ?>team/users">
                                <span class="site-menu-title">Benutzerverwaltung</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a class="animsition-link" href="<?php echo $url; ?>team/transactions">
                                <span class="site-menu-title">Transaktionen</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

        </ul>
    </div>
</div>