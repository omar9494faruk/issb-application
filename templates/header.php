<div class="header-part">
        <div class="logo-area">
            <img src="images/logo.png" alt="Logo" srcset="">
        </div>
        <div class="menu-area">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">ISSB</a></li>
                <li><a href="">Preliminary</a></li>
                <li><a href="">Blogs</a></li>
            </ul>
        </div>
        <div class="profile-area">
            <?php
                if(isset($_SESSION['loggedIn']) != true){ ?>
                    <a href="goTo.php" class="uk-icon-link" uk-icon="icon: sign-in; ratio:2"></a>
            <?php }else { ?>
                    <a href="profile.php" class="uk-icon-link" uk-icon="icon: user; ratio: 2"></a>
            <?php }
            ?>

        </div>
    </div>