<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

    <!-- User info -->
    <!--div class="login-info">
        <span> 
            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
    <?php
    session_start();
    $login = $_SESSION['login'];
    if (strlen($login) > 2) {
        echo '<span style="font-size:small">' . $login . '</span>';
    } else {
        echo '<span style="font-size:small"></span>';
    }
    ?>                                        
            </a>
        </span>
    </div-->
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive

    To make this navigation dynamic please make sure to link the node
    (the reference to the nav > ul) after page load. Or the navigation
    will not initialize.
    -->
    <nav>
        <!-- NOTE: Notice the gaps after each icon usage <i></i>..
            Please note that these links work a bit different than
            traditional hre="" links. See documentation for details.
        -->
        <?php
        $ui = new SmartUI();
        $ui->create_nav($page_nav)->print_html();
        ?>

    </nav>
    <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

</aside>
<!-- END NAVIGATION -->