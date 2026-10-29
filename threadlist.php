<?php
require_once 'partials/_helpers.php';
start_app_session();
require 'partials/_redirect.php';
require 'partials/database/_connect.php';
$cat_id = positive_int($_GET['cat_id'] ?? null);
if ($cat_id === null) {
    http_response_code(404);
    exit('Category not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_SESSION['role'] ?? '') !== 'user' || !isset($_SESSION['sno'])) {
        http_response_code(403);
        exit('Sign in with a user account to start a discussion.');
    }
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid form token.');
    }

    $th_title = $_POST['concern_title'] ?? '';
    $th_desc = $_POST['concern_desc'] ?? '';
    if (!is_string($th_title) || !is_string($th_desc) || trim($th_title) === '') {
        http_response_code(400);
        exit('A discussion title is required.');
    }

    $user_id = (int) $_SESSION['sno'];
    $insert = mysqli_prepare($conn, 'INSERT INTO `threads` (`th_name`, `th_desc`, `th_ct_id`, `th_user_id`, `th_dt`) VALUES (?, ?, ?, ?, current_timestamp())');
    mysqli_stmt_bind_param($insert, 'ssii', $th_title, $th_desc, $cat_id, $user_id);
    mysqli_stmt_execute($insert);
    header('Location: threadlist.php?cat_id=' . $cat_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="SparkCircuitLabs" />
  <meta name="generator" content="Hugo 0.122.0" />
  <title>Threadlist - brainoverflow</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/offcanvas-navbar/" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/style.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="assets/offcanvas-navbar.css" rel="stylesheet" />
  <link href="assets/headers.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <div
        class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button
            class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul
            class="dropdown-menu dropdown-menu-end shadow"
            aria-labelledby="bd-theme-text">
            <li>
                <button
                    type="button"
                    class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="light"
                    aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button
                    type="button"
                    class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="dark"
                    aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button
                    type="button"
                    class="dropdown-item d-flex align-items-center active"
                    data-bs-theme-value="auto"
                    aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>

    <nav
    class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark"
    aria-label="Main navigation">
    <?php require 'partials/_header.php'; ?>
  </nav>


    <main class="container">

        <?php
        require 'partials/_threadlist.php';
        ?>

        <hr>

        <?php 
        if (($_SESSION['role'] ?? '') === 'user'){
            echo '<form action="threadlist.php?cat_id=' . $cat_id . '" method="POST">
            ' . csrf_field() . '
            <div class="mb-3">
                <label for="concern_title" class="form-label">Concern</label>
                <input type="text" class="form-control" id="concern_title" name="concern_title" placeholder="keep your concern short and crisp as possible">
            </div>
            <div class="mb-3">
                <label for="concern_desc" class="form-label">Elaborate your concern</label>
                <textarea class="form-control" id="concern_desc" name="concern_desc" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Success</button>
        </form>';
          } else {
            echo 'login to start a discussion';
          }
        ?>
        

        <hr>
        <?php

        $threadsStatement = mysqli_prepare($conn, 'SELECT * FROM `threads` WHERE th_ct_id = ? ORDER BY th_dt DESC');
        mysqli_stmt_bind_param($threadsStatement, 'i', $cat_id);
        mysqli_stmt_execute($threadsStatement);
        $results = mysqli_stmt_get_result($threadsStatement);
        $no_result = true;

        while ($row = mysqli_fetch_assoc($results)) {
            $no_result = false;
            $th_id = $row['th_id'];
            $th_name = $row['th_name'];
            $th_desc = $row['th_desc'];
            $th_user_id = (int) $row['th_user_id'];
        
            $userStatement = mysqli_prepare($conn, 'SELECT username FROM `users` WHERE sno = ?');
            mysqli_stmt_bind_param($userStatement, 'i', $th_user_id);
            mysqli_stmt_execute($userStatement);
            $result = mysqli_stmt_get_result($userStatement);
            $row2 = mysqli_fetch_assoc($result);
        
            if ($row2) { // Check if the query returned a result
                $username = $row2['username'];
            } else {
                $username = "Unknown User"; // Default value if user not found
            }
        
            echo '
            <div class="d-flex align-items-center border-primary ">
                <div class="flex-shrink-0 ">
                    <img src="..." alt="...">
                </div>
                <a class="text-body text-decoration-none" href="thread.php?th_id=' . (int) $th_id . '">
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mt-0">' . h($th_name) . ' by '. h($username). '</h5>
                        ' . h($th_desc) . '
                    </div>
                </div>
            </a>
            <hr>';
        }
        

        if ($no_result) {

            echo '<div class="container my-5">
            <div class="p-5 text-center  bg-body-tertiary rounded-3">
                <div class="container"></div>
                <h1 class="text-body-emphasis">No discussions yet</h1>
                <p class="lead">
                    Be the <code>first person</code>, to start a discussion...
                </p>
            </div>
        </div>';
        }
        ?>

    </main>

    <?php
    include 'partials/_footer.php'
    ?>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/offcanvas-navbar.js"></script>
</body>

</html>