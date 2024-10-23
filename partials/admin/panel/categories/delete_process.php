<?php
require '../../../../partials/database/_connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "GET" && isset($_GET["cat_id"])) {
    $cat_id = intval($_GET["cat_id"]); // Ensure that the ID is an integer

    if ($cat_id > 0) {
        // Prepare the SQL statement
        $sql = "DELETE FROM `categories` WHERE `ct_id` = $cat_id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <i class="bi bi-check-circle me-1"></i>
                  Category Deleted Successfully!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            header('Location: ../categories.php');
            exit(); // Ensure you exit after redirecting
        } else {
            die('<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-x-circle me-1"></i>
                  Problem Deleting Category! ' . mysqli_error($conn) . '
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-x-circle me-1"></i>
              Invalid Category ID!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
} else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-x-circle me-1"></i>
          Invalid Request Method!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>
