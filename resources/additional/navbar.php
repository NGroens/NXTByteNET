<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse" role="navigation" style="background-color: #1e88e5;">

    <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>

        <a href="<?php echo $url; ?>logout" class="navbar-toggler collapsed">
            <i class="icon fa-power-off" aria-hidden="true"></i>
        </a>

        <div class="navbar-brand navbar-brand-center">
            <img src="<?php echo $picUrl; ?>logo/website-logo.png" title="Remark" height="50">
        </div>

    </div>

    <div class="navbar-container container-fluid">

        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar" href="<?php echo $url; ?>logout" role="button">
                        <i class="fa fa-power-off fa-2x" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>