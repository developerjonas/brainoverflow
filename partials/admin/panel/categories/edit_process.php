<?php
            require '../../../../partials/database/_connect.php';
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST" && isset($_POST["id"])) {
                $cat_id = $_POST["id"];
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $desc = mysqli_real_escape_string($conn, $_POST['desc']);

                if ($cat_id > 0) {
                    $sql = "UPDATE `categories` SET `ct_name` = '$name', `ct_desc` = '$desc' WHERE ct_id = $cat_id";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              <i class="bi bi-check-circle me-1"></i>
                              Category Edited Successfully!
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <i class="bi bi-x-circle me-1"></i>
                              Problem Editing Category! ' . mysqli_error($conn) . '
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }
                    header('Location : ../categories.php');
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <i class="bi bi-x-circle me-1"></i>
                          Invalid Category ID!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            }

            ?>