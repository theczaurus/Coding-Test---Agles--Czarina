<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form id="login-form" action="login.php" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />
            </div>
            <button type="submit">Login</button>
            <p style="margin-top: 10px">
                Don't have an account yet?
                <a href="#" id="register-link"> Register here. </a>
            </p>
        </form>
        <footer>
            <p>&copy; Coding Test 2024</p>
        </footer>
    </div>
    <div
        class="modal fade"
        id="registerModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="registerModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">
                        Register
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="register-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reg-name">Name </label>
                            <input
                                type="text"
                                id="reg-name"
                                name="name"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="reg-username"> Username </label>
                            <input
                                type="text"
                                id="reg-username"
                                name="username"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="reg-password"> Password </label>
                            <input
                                type="password"
                                id="reg-password"
                                name="password"
                                required
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#register-link').click(function(e) {
                e.preventDefault();
                $('#registerModal').modal('show');
            });
            $('#register-form').submit(function(e) {
                e.preventDefault();
                var name = $('#reg-name').val();
                var username = $('#reg-username').val();
                var password = $('#reg-password').val();
                $.ajax({
                    url: 'register.php',
                    method: 'POST',
                    data: { name: name, username: username, password: password },
                    success: function(response,error) {
                        // Handle success
                        if(response == 0){
                            alert('Registered successfully!');
                            $('#registerModal').modal('hide');
                        } else if(response > 1) {
                            alert('Username already exists. Please choose another username.')
                        } else {
                            alert('Registration failed: '+ error);
                        }

                    },
                    error: function(xhr,status,error) {
                        alert('Registration failed: ' +error);
                    }
                });
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php
            if (isset($_GET['error'])) {
                $errorMessage = htmlspecialchars($_GET['error']);
                echo "showErrorDialog('$errorMessage');";
            }
            ?>

            function showErrorDialog(message) {
                var dialog =
                    `<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $('body').append(dialog);
                $('#errorModal').modal('show');
                $('#errorModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            }
        });
    </script>
</body>
