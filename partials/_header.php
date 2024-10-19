<?php

echo '<div class="container-fluid">
      <a class="navbar-brand" href="#">brainoverflow</a>
      <button
        class="navbar-toggler p-0 border-0"
        type="button"
        id="navbarSideCollapse"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div
        class="navbar-collapse offcanvas-collapse"
        id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="discussion.php">Discussion</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="threadlist.php">Threads</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="partials/user/signup.php">Signup</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="partials/user/login.php">Signin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="partials/user/logout.php">Logo ut</a>
          </li>';

          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            echo 'Welcome Jonas';
          }

          echo '
        </ul>

        <form class="d-flex" role="search" action="search.php" method="GET">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search"
            name="search"
            aria-label="Search" />
          <button class="btn btn-outline-success" type="submit">
            Search
          </button>
          

        </form>

      </div>
    </div>';

?>

