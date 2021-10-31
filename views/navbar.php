<nav id="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="index.php">
            <img class="logo" src="img/blog.png" alt="logo">
        </a>
        <a class="navbar-brand" href="index.php">The Blog Point</a>
        <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
            <?php if (isset($_SESSION['currentUser']) && !empty($_SESSION['currentUser'])) { ?>
                <a class="text-decoration-none" href="profile.php">
                <h5 class="currentuser"><?php echo ucfirst($_SESSION['currentUser']); ?></h5>
                </a>
                <a class="bloglink" href="blog.php">Blogs</a>
                <a class="bloglink" href="myblogs.php">My Blogs</a>
                <button type="button" class="btn btn-dark" id="createblog" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Create Blog
                </button>
                <?php include './views/createblog.php' ?>
                <button type="button" name="log-out" id="log-out" class="btn btn-dark">Log-out</button>
            <?php } else { ?>
                <button type="button" class="btn btn-dark mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                    Log-In
                </button>
                <button type="button" class="btn btn-dark mx-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Sign-Up
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog frmwidth">
                        <form method="POST" id="register" class="modal-content modal-body px-2 position bg-dark" aria-labelledby="dropdownMenuButton2">
                            <div class="text-center">
                                <img src="img/new-user.png" class="w-50 my-1 invert" alt="user">
                            </div>
                            <input class="frminputs" type="text" name="name" placeholder="Name" required>
                            <input class="frminputs" type="email" name="email" placeholder="E-mail" required>
                            <input class="frminputs" type="password" name="password" placeholder="Password" required>
                            <input class="frminputs" type="password" name="password2" placeholder="Confirm-password" required>
                            <div class="checkgender my-1">
                                <input type="radio" name="Gender" value="male" required><label for="male">Male</label>
                                <input type="radio" name="Gender" value="female" required><label for="female">Female</label>
                            </div>
                            <div>
                                <p class="signmsg" id="regmsg"></p>
                            </div>
                            <div class="text-center">
                                <button type="submit" id="signup" name="sign-up" class="btn btn-outline-success py-1">Sign-Up</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog frmwidth">
                        <form method="POST" id="login" class="modal-content modal-body px-2 bg-dark" aria-labelledby="dropdownMenuButton1">
                            <div class="text-center">
                                <img src="img/userblack.png" class="w-50 my-1 invert" alt="user">
                            </div>
                            <input class="frminputs" type="email" name="username" placeholder="E-mail" required>
                            <input class="frminputs" type="password" name="password" placeholder="Password" required>
                            <a id="forgotcode" class="text-center" type="button">forgot password</a>
                            <div>
                                <p id="login_error" class="logmsg"></p>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="log-in" class="btn btn-outline-success py-1">Log-In</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>