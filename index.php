<?php
include 'config.php';




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f1e6b711f2.js" crossorigin="anonymous"></script>
    <title>काठमाडौँ महानगरपालिका - निशुल्क उपचार सहजिकरण सेवा</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

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
    background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png'); /* Add your image URL here */

    color: black;
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
    font-weight: 600;
    text-size: 2.3em;
}
.header-title h2 {
    font-weight: 600;
    text-size: 1.8em;

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
    margin-left: 100px;
    margin-right: 100px;
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
        .header-title h1 {
            text-align: center;
            font-size: 2.1em;
            font-weight:600;
        }
        
        .header-title h2 {
            font-size: 1.6em;
            font-weight:600;
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
/* Table Styles */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.table th {
    background: var(--primary-color);
    color: white;
    padding: 10px;
    text-align: left;
}

.table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    transition: color 0.3s ease, transform 0.3s ease;
}

/* Multi-colored rows */
.table tr:nth-child(4n+1) {
    background-color: #ffadad; /* Light Red */
}

.table tr:nth-child(4n+2) {
    background-color: #ffd6a5; /* Light Orange */
}

.table tr:nth-child(4n+3) {
    background-color: #fdffb6; /* Light Yellow */
}

.table tr:nth-child(4n) {
    background-color: #caffbf; /* Light Green */
}

/* Hover effect */
.table tr:hover {
    background-color: #000000; /* Black background on hover */
    color: black; /* White text on hover */
    transform: scale(1.02);
    cursor: pointer;
}

.table tr:hover td {
    transform: translateY(-2px); /* Text animation on hover */
    transition: transform 0.3s ease;
}

.table caption {
    padding: 10px;
    font-size: 1.0em;
    font-weight: bold;
    text-align: left;
    background: var(--primary-color);
    color: white;
}

</style>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo-container">
            <img src="cropped-logo.png" alt="Logo" width="150px" height="150px">
        </div>
        <div class="header-title">
            <h1>काठमाडौँ महानगरपालिका</h1>
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
            <li><a href="#">Home</a></li>
            <li><a href="files.php"><i class="fas fa-download"></i> Download</a></li>
            <li><a href="login.php"><i class="fas fa-sign-in"></i> Hospital Login</a></li>
            <li><a href="kmc/login.php"><i class="fas fa-sign-in"></i> KMC Login</a></li>
        </ul>
    </nav>
    <br>
    <!-- Main Content -->
    <main>
        <section class="info-cards">
            <!-- Card 1 -->
            <div class="card">
                <p>नेपालको संविधान २०७२ को धारा ३५ ले व्यवस्था गरेको प्रत्येक नागरिकलाई राज्यबाट आधारभूत स्वास्थ्य सेवा निःशुल्क प्राप्त गर्ने हक हुने, कसैलाई पनि आकस्मिक स्वास्थ्य सेवाबाट बन्चित नगरिने र प्रत्येक नागरिकलाई स्वास्थ्य सेवामा समान पहुँचको हक हुने भन्ने संवैधानिक व्यवस्था रहेको छ। काठमाडौं महानगरपालिका जनस्वास्थ्य ऐन २०८० को दफा २८ अनुसार काठमाडौं महानगरपालिका क्षेत्र भित्र रहेका अस्पतालहरुले विपन्न, असहाय र ब्यवारिसे नागरिकहरुलाई कुल शैयाको १० प्रतिशत विरामिलाई लाग्ने सम्पुर्ण उपचार खर्च निःशुल्क गर्नुपर्ने कानूनि व्यवस्था गरेको छ।  नेपाल सरकारको स्वास्थ्य संस्था संचालन मापदण्ड २०७७ को दफा ७० घ मा समेत सो सम्बन्धि व्यवस्था गरेकाले नेपाल भरका उक्त वर्गमा पर्ने नागरिकहरुलाई काठमाण्डौ माहानगरपालिका क्षेत्र भित्रका अस्पतालहरुमा निःशुल्क उपचार सेवा प्रभावकारी, पहूच योग्य र पारदर्शी बनाउने उद्देश्यले यो अनलाइन प्रणालिको विकास गरिएको हो ।</p>
            </div>
            <!-- Card 2 -->
            <div class="card info">
                <h3>विपन्न र असाहय बिरामीले निशुल्क उपचार सेवा लिनका लागि चाहिने आवश्यक कागजातः <a class="fas fa-download" href="/files/Downloads.pdf"></a></h3><p>१.	नेपाल सरकार / प्रदेश सरकार/ स्थानिय सरकारले लक्षित वर्ग हो भनी जारि गरेको कागजात/ परिचय पत्र वा,<br>
२.	राष्ट्रिय परिचयपत्र / नेपाली नागरिकता प्रमाण पत्र/ जन्मदर्ता प्रमाणपत्र प्रतिलिपी र हालसालै खिचिएको फोटो र,<br>
३.	रोग पहिचान भए सोको कागजपत्र र,<br>
४.	अनुसूची-५ को आधारमा सम्बन्धीत  स्थानिय तहको वडाले लक्षित वर्ग हो भनी अनुसूची- ४ अनुसारको सर्जमिन गरेको कागज र,<br>
५.	सम्बन्धीत स्थानिय तहको वडा कार्यलयले उपचारको लागी अनुसूची- ३ अनुसारको सिफारिस गरेको पत्र, <br>
</br>  
<b>
बेवारिसे बिरामीले निशुल्क उपचार सेवा लिनका लागि चाहिने आवश्यक कागजातः
</b>
</br>
१. आकस्मिक कक्षमा आएका बखत उपचार खर्च नभएका गरिव, बिपन्न तथा वेवारिसे विरामिलाई प्रारम्भिक स्वास्थ्य उपचार निशुल्क प्रदान गर्नु पर्नेछ ।</p>            </div>
        </section>
<br>
        <!-- Hospital Data Table -->
        <?php
// Retrieve hospital data from the database
$sql_select = "SELECT h.*, COUNT(p.p_id) AS active_patients, ROUND(0.1 * h.total_bed) AS allocated_beds
               FROM hospital h
               LEFT JOIN patient p ON h.hospital_id = p.hospital_id AND p.status = 'Active'
               GROUP BY h.hospital_id";
$result = $conn->query($sql_select);

// Retrieve the number of rows from the "hospital" table
$sql_count = "SELECT COUNT(*) AS row_count FROM hospital";
$result_count = $conn->query($sql_count);

// Check if the query was successful
if ($result_count) {
    // Fetch the row count value
    $row_count = $result_count->fetch_assoc()['row_count'];
} else {
    // Handle the error if the query fails
    $row_count = 0;
}

    // Check if there are hospitals in the database
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table class='container table table-bordered'>
        <caption><p>काठमाडौँ महानगरपालिका क्षेत्रभित्रका सबै प्रकारका अस्पतालहरुमा लक्षित वर्गलाई निशुल्क उपचार सेवा उपलब्ध गराउन छुट्याइएको कुल शैया तथा उपलब्ध शैया संख्या ।</caption>
                <tr>
                    <th>Hospital ID</th>
                    <th>Hospital Name</th>
                    <th>Total/
                    Allocated Beds (10%)</th>
                    <th>Patients</th>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row["hospital_id"]}</td>
                    <td>{$row["hospital_name"]}</td>
                    <td>{$row["total_bed"]}/
                    {$row["allocated_beds"]}</td>
                    <td>{$row["active_patients"]}</td>
                    <td>{$row["hospital_type"]}</td>
                    <td>{$row["contact_person"]}</td>
                    <td>{$row["contact_email"]}</td>
                    <td>{$row["contact_number"]}</td>
                    <td>{$row["address"]}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No hospitals found in the database.";
    }

    // Close the database connection
    $conn->close();
    ?>

    </main>
<br>
    <!-- Footer (Optional) -->
    <footer>
        <p>&copy; 2024 काठमाडौँ महानगरपालिका. All rights reserved.</p>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Navigation Menu Animation
        const navItems = document.querySelectorAll('nav ul li a');
        navItems.forEach(item => {
            item.addEventListener('mouseover', () => item.style.transform = 'scale(1.1)');
            item.addEventListener('mouseout', () => item.style.transform = 'scale(1)');
        });

        // Card Animation
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseover', () => card.style.transform = 'scale(1.05)');
            card.addEventListener('mouseout', () => card.style.transform = 'scale(1)');
        });

        // Table Row Highlight
        const tableRows = document.querySelectorAll('table tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseover', () => row.style.backgroundColor = '#f0f0f0');
            row.addEventListener('mouseout', () => row.style.backgroundColor = '');
        });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
    // Add your existing animation code here
    // Example: Navigation Menu Animation
    const navItems = document.querySelectorAll('nav ul li a');
    navItems.forEach(item => {
        item.addEventListener('mouseover', () => item.style.transform = 'scale(1.1)');
        item.addEventListener('mouseout', () => item.style.transform = 'scale(1)');
    });

    // Additional animations can be added as needed
});

</script>
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
            
        }
        
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
}
.header-title h1, .header-title h2 {
font-weight:600;
    
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
