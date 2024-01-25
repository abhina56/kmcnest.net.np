<?php
// Include the database connection file
include '../config.php';

// Initialize error variable
$error = '';
// Include your database connection file here
// include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Assuming the password is plaintext. In a real application, it should be hashed.

    $sql = "SELECT user_id, username, password, email FROM users WHERE username = ?";
    
    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);

        // Execute the query
        $stmt->execute();

        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_username, $db_password, $email);
            $stmt->fetch();

            // Verify the password (consider using password hashing in your database and using password_verify)
            if ($password == $db_password) {
                // Password is correct, set the cookies
                setcookie("user_id", $user_id, time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie("email", $email, time() + (86400 * 30), "/");

                // Redirect to your desired page
                header("Location: index.php");
                exit;
            } else {
                // Password is not correct
                echo "The password you entered was not valid.";
            }
        } else {
            // Username doesn't exist
            echo "No account found with that username.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kathmandu Metropolitan City</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    
/* Color Palette */
:root {
    --primary-color: #3498db; /* Blue */
    --secondary-color: #e74c3c; /* Red */
    --accent-color: #f1c40f; /* Yellow */
    --background-color: #ecf0f1; /* Light Gray */
    --text-color: #2c3e50; /* Dark Blue */
}

/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: var(--background-color);
    color: var(--text-color);
    line-height: 1.6;
}

/* Header */
header {
    background: var(--primary-color);
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

.logo-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10%;
}

.header-title h1 {
    text-align: center;
}

/* Sidebar Navigation */
aside {
    width: 200px;
    background-color: var(--secondary-color);
    height: 100vh;
    position: fixed;
}

aside nav ul {
    list-style: none;
    padding: 20px;
}

aside nav ul li a {
    color: white;
    text-decoration: none;
    display: block;
    padding: 10px;
    transition: background 0.3s;
}

aside nav ul li a:hover {
    background-color: var(--accent-color);
}

/* Main Content */
main {
    margin-left: 200px;
    margin-right: 200px;
    flex-grow: 1;
    padding: 20px;
}

/* Info Cards */
.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border-left: 5px solid var(--primary-color);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    border-left: 5px solid var(--secondary-color);
}

/* Footer */
footer {
    text-align: center;
    padding: 20px 0;
    background: var(--text-color);
    color: white;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10%;
}

/* Responsive Design */
@media (max-width: 768px) {
    aside {
        width: 100px;
    }

    aside nav ul li a {
        padding: 5px;
    }

    main {
        margin-left: 100px;
    }

.header-container {
        flex-direction: column;
        text-align: center;
    }
    
    .logo-container {
        margin-bottom: 10px;
    }
    
    .header-title {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    height: 100%;
}

.header-title h1, .header-title h2 {
    font-size: smaller;
    margin-top: 0; /* Adjust as needed */
}

}

        /* Updated Navigation Styles */
        nav {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 10px 0;
        }

        nav ul {
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 4px;
            transition: transform 0.3s ease, background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            
        }

        .header {
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
            height: 200px;
            color: black;
            text-align: center;
        }
        .table-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table-custom th {
            background-color: #007bff;
            color: white;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            margin-top: 20px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>

</head>
<body>
    <!-- Header with Image Background -->
  <header>
    <div class="header-container">
        <div class="logo-container">
            <img src="cropped-logo.png" alt="Logo" width="150px" height="150px">
        </div>
        <div class="header-title">
            <br><h1>काठमाडौँ महानगरपालिका</h1>
            <h2>निशुल्क उपचार सहजिकरण सेवा</h2>
        </div>
        <div class="logo-container">
            <img src="kmc-logo.png" alt="KMC Logo" width="150px" height="150px">
        </div>
    </div>
</header>


    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <!--<li><a href="files.php"><i class="fas fa-download"></i> Download</a></li>-->
            <!--<li class="nav-item">-->
                    <!-- Toggle between Logout and Login based on session status -->
            <!--        <?php if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])): ?>-->
            <!--            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>-->
            <!--        <?php else: ?>-->
            <!--            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>-->
            <!--        <?php endif; ?>-->
            <!--    </li>-->
            </ul>
        </div>
    </nav>
    
    <br>
    <br>

    <div class="container">
        <div class="login-container">
            <b><h2 class="text-center">KMC Login</h2></b>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="hospitalName" class="form-label">Hospital Name:</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter Hospital Name" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                </div>
<br>
                <button type="submit" class="btn btn-primary btn-block" style=" width: auto; margin-left:530px">Login</button>

                <?php
                if ($error) {
                    echo "<div class='alert alert-danger mt-3'>$error</div>";
                }
                ?>
            </form>
        </div>
    </div>
    <!--<a href="index.php">-->
    <!--<button class="btn btn-primary">Home</button>-->
    <!--</a>-->
         <style>
                header {
            background: var(--primary-color);
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png'); /* Add your image URL here */
            color: black;
            padding: 20px 0;
            text-align: center;
            text-size: 2.3em;
line-height: 1.6;
            
        }
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
            
        }
        
   .header-title h1 {
            text-align: center;
            font-size: 2.1em;
            font-weight:600;
        }
        
        .header-title h2 {
            font-size: 1.6em;
            font-weight:600;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
}
h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight:bold;
        }


@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        text-align: center;
    }
    
    .logo-container {
        margin-bottom: 10px;
    }
    
    .header-title {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    height: 100%;
}

.header-title h1, .header-title h2 {
    font-size: smaller;
    margin-top: 0; /* Adjust as needed */
}

}
    </style>
</body>
</html>

