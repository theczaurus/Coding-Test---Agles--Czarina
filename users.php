<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php"); 
    exit;
}

include('config.php');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, name FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="brand">User Management System</div>
        <div class="header-user">
            <span id="username"><?php echo $_SESSION['username']; ?></span>
            <button id="dropdown-toggle" class="btn btn-link text-white p-0">
                <i class="fas fa-caret-down"></i>
            </button>
            <div id="dropdown-menu" class="dropdown-menu">
                <form id="logout-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <button type="submit" name="logout" class="dropdown-item">Logout</button>
                </form>
            </div>
        </div>
    </header>
    <main class="container mt-4">
        <div class="table-box">
            <h2 class="p-3">User List</h2>
            <table id="user-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo '<td class="table-actions">
                                    <a href="#" class="text-primary edit-user" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="text-danger delete-user ml-2" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                  </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-table').DataTable();
            $('#dropdown-toggle').click(function(e) {
                e.stopPropagation(); 
                $('#dropdown-menu').toggleClass('show');
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('.header-user').length) {
                    $('#dropdown-menu').removeClass('show');
                }
            });

            $('.edit-user').click(function(e) {
                e.preventDefault();
                console.log('Edit user clicked');
            });

            $('.delete-user').click(function(e) {
                e.preventDefault();
                console.log('Delete user clicked');
            });
        });
    </script>
</body>
</html>
