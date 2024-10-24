<?php
// Define base URL
$base_url = "/php-playground/brainoverflow/";

// Get current script directory to check if it's a subdirectory
$current_directory = basename(dirname($_SERVER['SCRIPT_NAME']));

// If the current directory is not the main one, adjust the base URL accordingly
if ($current_directory != 'brainoverflow') {
    $base_url = "/php-playground/brainoverflow/"; // Adjust this if needed for subdirectories
}
echo '<div class="container-fluid">
      <a class="navbar-brand" href="'.$base_url.'index.php">brainoverflow</a>
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
            <a class="nav-link" href="'.$base_url.'discussion.php">Discussion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="'.$base_url.'about.php">About</a>
          </li>
          <li class="nav-item">
            <a href="'.$base_url.'contact.php" class="nav-link">Contact</a>
          </li>
          <li class="nav-item">
            <a href="'.$base_url.'faqs.php" class="nav-link">FAQs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="'.$base_url.'threadlist.php">Threads</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href=""><--||--></a>
          </li>';

          // Admin and User Logic
          if((isset($_SESSION['admin']) && $_SESSION['logged'] == true)){
            $admin = $_SESSION['name'];
              echo '<li class="nav-item">
              <a class="nav-link active" aria-current="page" href="'.$base_url.'user.php">Welcome <code>'.$name.'</code></a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="'.$base_url.'partials/admin/logout.php">Exit</a>
            </li>';
          } else {
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
              $name = $_SESSION['username'];
              echo '<li class="nav-item">
              <a class="nav-link active" aria-current="page" href="'.$base_url.'user.php">Welcome <code>'.$name.'</code></a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="'.$base_url.'partials/user/logout.php">Exit</a>
            </li>';
            } else {
              echo '<li class="nav-item">
              <a class="nav-link" href="'.$base_url.'partials/user/signup.php">Join</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="'.$base_url.'partials/user/login.php">Enter</a>
            </li>';
            }
          }

          echo '
        </ul>

        <form class="d-flex" role="search" action="'.$base_url.'search.php" method="GET">
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
