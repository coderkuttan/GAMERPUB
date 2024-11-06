<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMERPUB - Account Management</title>
    <style>
        body {
            background: #0a0a0a;
            font-family: 'Press Start 2P', cursive;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        #container {
            background-color: #1a1a1a;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.8);
            text-align: center;
            width: 80%;
            max-width: 500px;
            animation: slideIn 1s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateY(50px); }
            to { transform: translateY(0); }
        }
        h1 {
            font-size: 36px;
            color: #ffcc00;
            margin-bottom: 20px;
            letter-spacing: 3px;
        }
        form {
            margin: 20px 0;
            padding: 20px;
            border: 2px solid #ffcc00;
            border-radius: 10px;
            background-color: #333;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: #ffffff;
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
            outline: none;
        }
        input[type="text"]::placeholder, input[type="password"]::placeholder {
            color: #888;
            font-family: 'Montserrat', sans-serif;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            background-color: #555;
            border: 1px solid #ffcc00;
        }
        input[type="submit"] {
            background-color: #ffcc00;
            color: #000;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #e6b800;
        }
        .btn-ele {
            background-color: #333;
            color: #ffcc00;
            border: 2px solid #ffcc00;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-ele:hover {
            background-color: #555;
        }
        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container">
        <h1>Account Management</h1>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db1";
        $con = mysqli_connect($host, $username, $password, $dbname);
        if (!$con) {
            die("Connection failed!" . mysqli_connect_error());
        }
        function createAccount($con, $username, $password) {
            $sql = "INSERT INTO accounts (username, password) VALUES ('$username', '$password')";
            return mysqli_query($con, $sql);
        }
        function viewAccounts($con) {
            $sql = "SELECT * FROM accounts";
            return mysqli_query($con, $sql);
        }
        function updateAccount($con, $id, $username, $password) {
            $sql = "UPDATE accounts SET username='$username', password='$password' WHERE id='$id'";
            return mysqli_query($con, $sql);
        }
        function deleteAccount($con, $id) {
            $sql = "DELETE FROM accounts WHERE id='$id'";
            return mysqli_query($con, $sql);
        }
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (createAccount($con, $username, $password)) {
                echo "<h2>Account created successfully!</h2>";
            } else {
                echo "<h2>Error creating account: " . mysqli_error($con) . "</h2>";
            }
        }
        if (isset($_GET['action']) && $_GET['action'] == 'view') {
            $result = viewAccounts($con);
            echo "<h2>Accounts:</h2><ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>ID: " . $row['id'] . ", Username: " . $row['username'] . "</li>";
            }
            echo "</ul>";
        }
        if (isset($_GET['action']) && $_GET['action'] == 'update') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $username = $_POST['username'];
                $password = $_POST['password'];

                if (updateAccount($con, $id, $username, $password)) {
                    echo "<h2>Account updated successfully!</h2>";
                } else {
                    echo "<h2>Error updating account: " . mysqli_error($con) . "</h2>";
                }
            } else {
                echo '<form action="phpgame.php?action=update" method="POST">
                        <input type="text" name="id" placeholder="Enter Account ID" required /><br/>
                        <input type="text" name="username" placeholder="Enter new username" required /><br/>
                        <input type="password" name="password" placeholder="Enter new password" required /><br/>
                        <input type="submit" value="Update Account" />
                      </form>';
            }
        }
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];

                if (deleteAccount($con, $id)) {
                    echo "<h2>Account deleted successfully!</h2>";
                } else {
                    echo "<h2>Error deleting account: " . mysqli_error($con) . "</h2>";
                }
            } else {
                echo '<form action="phpgame.php?action=delete" method="POST">
                        <input type="text" name="id" placeholder="Enter Account ID to delete" required /><br/>
                        <input type="submit" value="Delete Account" />
                      </form>';
            }
        }
        mysqli_close($con);
        ?>
        
        <!-- New Button to Navigate to ele.html -->
        <a href="ele.html" class="btn-ele">Go to GamerPUB</a>

        <footer>
            <p>&copy; 2024 GAMERPUB</p>
        </footer>
    </div>
</body>
</html>
