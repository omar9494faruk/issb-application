<div class="header-part">
            <div class="logo-area">
            <a href="index.php"><img src="../images/logo.png" alt="Logo" srcset=""></a>
                <div class="text-area">
                    <p style="color:#fff">Lighting Your Way To Success</p>
                </div>
            </div>
            <div class="menu-area">
                <ul>
                    <li><a href="../index.php" style="color:#fff">Home</a></li>
                    <li><a href="" style="color:#fff">Blogs</a></li>
                </ul>
            </div>
            <div class="profile-area">
                <?php
                    if(isset($_SESSION['loggedIn']) != true){ ?>
                        <a href="goTo.php" class="uk-icon-link" uk-icon="icon: sign-in; ratio:2" style="color:#c4f1ff;"></a>
                <?php }else { ?>
                        <a href="profile.php" class="uk-icon-link" uk-icon="icon: user; ratio: 2" style="color:#c4f1ff;"></a>
                <?php }
                ?>

            </div>
        </div>