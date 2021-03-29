<!-- Backgrounds -->
<div id="nav-bg-sm" class="pt-2" style="background-image: url('images/icing_bar_blue_small.png'); background-repeat: repeat-x; position: absolute; top: 0; left:0; height: 3.5rem; width: 100%;">
</div>
<div id="nav-bg-lg" style="background-image: url('images/icing_bar_blue.png'); background-repeat: repeat-x; position: absolute; top: 0; height: 15rem; width: 100%">
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-fixed-top pt-2">
    <a class="navbar-brand text-center text-white " href="index.php"><img src="images/donut_icon.png" style="width: 2.5rem;" alt="donut icon">&nbsp;<span class="brand">Retro Dough</span></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent" >
        <ul class="navbar-nav m-auto">
            <li class="nav-item active navpad">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active navpad">
                <a data-toggle="modal" data-backdrop="true" data-target="#exampleModalCenter" href="" class="nav-link">Our Products <span class="sr-only">(current)</span></a>
            </li>
            <form class="form-inline my-2 my-lg-0 navpad pr-5">
                <input class="form-control mr-2 search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-sm  text-white searchBtn" type="button" style="background-color: deeppink">Search</button>
            </form>
            <li class="nav-item active navpad d-inline-flex">
                    <?php if (!empty($loggedInUser)) : ?>
                        <span class="nav-link">Hi, <?= $loggedInUser->name ?> &nbsp;|&nbsp; </span>
                        <a class="nav-link" href="logout.php">Logout</a>
                        <a class="nav-link" href="user_page.php">&nbsp;|&nbsp; Account</a>
                    <?php else: ?>
                        <a data-toggle="modal" data-backdrop="true" data-target="#loginModalCenter" href="" class="nav-link">Register/Login <span class="sr-only">(current)</span></a>
                    <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>


