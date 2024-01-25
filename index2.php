<?php
include 'config.php';




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f1e6b711f2.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        :root{
            --p_color: rgba(0,123,255,0.8);
        }
        * {
            margin: 0;
            padding: 0;

        }

        body {
            width: 100%;
        }

        blockquote {
            font-size: .9rem;
            text-align: center;
        }

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
            font-size: 2.3em;
            font-weight:600;
        }
        
        .header-title h2 {
            font-size: 1.8em;
            font-weight:600;
        }
        
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
}


        /* Header End */
        /* Navbar Start */
        nav {
            background-color: var(--p_color);
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: space-between;
            color: rgb(255, 255, 255);
        }

        nav ul .links {
            display: flex;
        }

        nav ul li {
            /* background-color: red; */
            padding: 20px;
            font-size: 1em;
            ;
        }

        nav ul li a {
            text-align: center;
            text-decoration: none;
            color: rgb(255, 255, 255);
        }

        nav ul li a:hover {
            color: #cdcdcd;
        }

        /* Navbar End */

        /* Cards Start */

        .card-container {
            display: grid;
            padding: 0 20px;
            grid-template-columns: 2fr 2fr;
            /* grid-template-rows: repeat(2,1fr); */
            grid-gap: 20px;
            /* width: 80%; */
        }

        .card {
            display: flex;
            justify-content: space-evenly;
            margin-top: 30px;
            flex-direction: column;
            align-items: center;
            /* width: 50%; */
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            background-color: var(--p_color);
            color: rgb(255, 255, 255);
            overflow: auto;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            margin-bottom: 5px;
        }

        .card p {
            margin: 5px;
            font-size: 1.4em;
            text-align: justify;
        }
        .card.info{
            flex: 1;
            text-align: left !important;        }
        /* Cards End */

        /* Table Starts */
        table {
            margin-right: 10px;
            border-collapse: collapse;
            text-align: left;
            margin-top: 50px;
            width: 100%;
        }

        table th {
            width: auto;
            background-color: var(--p_color);
            color: white;
        }

        table td {
        
            height: 25px;
            font-size: 1.1em;
            text-align: left;
        }

        table tr:nth-child(even) {
            background-color: rgba(38, 57, 87, 0.4);
        }
        th, td {
    text-align: left; /* Align text to the left */
    padding: 8px; /* Add some padding for better readability */
}

        #truncate {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            height: 10vh;
            overflow-y: scroll;
            overflow-x: hidden;
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
    <nav>
        <ul>
            <li>Home</li>
            <div class="links">
                <li><a href="files.php">
                        <span><i class="fas fa-download"></i></span>
                        <span>Download</span>
                    </a>
                </li>
                <li>
                    <a href="login.php">
                        <span><i class="fas fa-sign-in"></i></span>
                        <span>Hospital Login</span>
                    </a>
                </li>
                <li>
                    <a href="kmc/login.php">
                        <span><i class="fas fa-sign-in"></i></span>
                        <span>KMC Login</span>
                    </a>
                </li>
            </div>
        </ul>
    </nav>
    <blockquote>
        <div class="card-container">
            <div class="card">
                <!-- <h1>Card 1 Title</h1> -->
                <p>नेपालको संविधान २०७२ को धारा ३५ ले व्यवस्था गरेको प्रत्येक नागरिकलाई राज्यबाट आधारभूत स्वास्थ्य सेवा निःशुल्क प्राप्त गर्ने हक हुने, कसैलाई पनि आकस्मिक स्वास्थ्य सेवाबाट बन्चित नगरिने र प्रत्येक नागरिकलाई स्वास्थ्य सेवामा समान पहुँचको हक हुने भन्ने संवैधानिक व्यवस्था रहेको छ। काठमाडौं महानगरपालिका जनस्वास्थ्य ऐन २०८० को दफा २८ अनुसार काठमाडौं महानगरपालिका क्षेत्र भित्र रहेका अस्पतालहरुले विपन्न, असहाय र ब्यवारिसे नागरिकहरुलाई कुल शैयाको १० प्रतिशत विरामिलाई लाग्ने सम्पुर्ण उपचार खर्च निःशुल्क गर्नुपर्ने कानूनि व्यवस्था गरेको छ।  नेपाल सरकारको स्वास्थ्य संस्था संचालन मापदण्ड २०७७ को दफा ७० घ मा समेत सो सम्बन्धि व्यवस्था गरेकाले नेपाल भरका उक्त वर्गमा पर्ने नागरिकहरुलाई काठमाण्डौ माहानगरपालिका क्षेत्र भित्रका अस्पतालहरुमा निःशुल्क उपचार सेवा प्रभावकारी, पहूच योग्य र पारदर्शी बनाउने उद्देश्यले यो अनलाइन प्रणालिको विकास गरिएको हो ।
                </p>
            </div>
            <div class="card info">
                <p><h3>विपन्न र असाहय बिरामीले निशुल्क उपचार सेवा लिनका लागि चाहिने आवश्यक कागजातः                 <a class="fas fa-download" href="/files/Downloads.pdf"></a>
</h3>
नेपाल सरकार / प्रदेश सरकार/ स्थानिय सरकारले लक्षित वर्ग हो भनी जारि गरेको कागजात/ परिचय पत्र वा,<br>
सम्बन्धीत स्थानिय तहको वडाले लक्षित वर्ग हो भनी सर्जमिन सहित प्रमाणित गरेको कागज र  नेपाली नागरिकता/ जन्मदर्ता सहित अनुसूची ३ अनुसारको विवरण भरी पेश गर्ने

<br>

बेवारिसे बिरामीले निशुल्क उपचार सेवा लिनका लागि चाहिने आवश्यक कागजातः
<br>
१. आकस्मिक कक्षमा आएका बखत उपचार खर्च नभएका गरिव, बिपन्न तथा वेवारिसे विरामिलाई प्रारम्भिक स्वास्थ्य उपचार निशुल्क प्रदान गर्नु पर्नेछ ।
                </p>
            </div>
        </div>
        
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
        echo "<table class='table table-bordered'>
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

    </blockquote>
</body>

</html>