<?php
require_once __DIR__ . '/_helpers.php';
require 'database/_connect.php';

// Fetch categories
$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $cat_name = $row['ct_name'];
    $cat_desc = $row['ct_desc'];
    $cat_id = (int) $row['ct_id'];

    echo '
    <div class="col-sm-6">
        <div class="card my-2">
            <div class="card-body">
                <h5 class="card-title">' . h($cat_name) . '</h5>
                <p class="card-text">' . h($cat_desc) . '</p>
                <a href="threadlist.php?cat_id=' . $cat_id . '" class="btn btn-primary">Go</a>
            </div>';

    // Fetch threads for this category
    // Load recent threads once per category.
    $threadStatement = mysqli_prepare($conn, 'SELECT * FROM `threads` WHERE th_ct_id = ? ORDER BY th_dt DESC LIMIT 3');
    mysqli_stmt_bind_param($threadStatement, 'i', $cat_id);
    mysqli_stmt_execute($threadStatement);
    $thread_result = mysqli_stmt_get_result($threadStatement);
    $thread_count = mysqli_num_rows($thread_result); // Count the number of threads

    if ($thread_count > 0) {
        // Display "Recent Threads" section header
        echo '
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Recent Threads</h6>';

        // Loop through threads and display them
        while ($thread_row = mysqli_fetch_assoc($thread_result)) {
            $th_id = (int) $thread_row['th_id'];
            $th_name = $thread_row['th_name'];
            $th_user_id = $thread_row['th_user_id'];

            // Fetch username from users table
            $userStatement = mysqli_prepare($conn, 'SELECT username FROM `users` WHERE sno = ?');
            mysqli_stmt_bind_param($userStatement, 'i', $th_user_id);
            mysqli_stmt_execute($userStatement);
            $result_user = mysqli_stmt_get_result($userStatement);
            $user_row = mysqli_fetch_assoc($result_user);

            $username = isset($user_row['username']) ? $user_row['username'] : 'Unknown User'; // Avoid null access

            echo '
        <div class="d-flex text-body-secondary pt-3">
            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="#007bff"/>
                <text x="50%" y="50%" fill="#fff" dy=".3em">32x32</text>
            </svg>
            <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                <div class="d-flex justify-content-between">
                    <strong class="text-gray-dark">' . h($th_name) . '</strong>
                    <a href="thread.php?th_id=' . $th_id . '">View</a>
                </div>
                <span class="d-block">@' . h($username) . '</span>
            </div>
        </div>';
        }

        echo '
        <small class="d-block text-end mt-3">
            <a href="threadlist.php?cat_id=' . $cat_id . '">All Threads</a>
        </small>
    </div>'; // Close the "Recent Threads" section
    } else {
        // Handle the case where no threads exist
        echo '
    <a class="text-decoration-none" href="threadlist.php?cat_id=' . $cat_id . '">
    <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <h1 class="text-body-emphasis">No discussions yet</h1>
            <p class="lead">
                Be the <code>first person</code> to start a discussion...
            </p>
        </div>
    </div>
    </a>';
    }

    echo '</div></div>'; // Closing divs for category card
}
