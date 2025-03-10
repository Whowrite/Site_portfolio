<?php
include 'connection.php';
$sql = "SELECT * FROM `lastproject` INNER JOIN images ON `ID_images` = images.ID";
$result = $conn->query($sql);

$project_info = "";
$images = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $project_info = $row['info'];
    $images[0] = base64_encode($row['photo1']); // Конвертуємо BLOB у base64
    $images[1] = base64_encode($row['photo2']); // Конвертуємо BLOB у base64
    $images[2] = base64_encode($row['photo3']); // Конвертуємо BLOB у base64
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="EN">
<head>
	<title>Портфоліо</title>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelector(".admin-login-button").addEventListener("click", function() {
                    window.location.href = "login.php";
                });
            });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #1F3C70;
        }
        .logo span {
            color: #FECF51; /* червоний для частини "Cv" */
        }
        .nav-links {
            list-style-type: none;
        }
        .nav-links li {
            display: inline;
            margin-right: 20px;
        }
        .nav-links a {
            text-decoration: none;
            color: #1F3C70;
            font-size: 1em;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
        .container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        .left-section img {
            width: 100%;
            border-radius: 10px;
            max-width: 500px;
        }
        .right-section {
            max-width: 500px;
            margin-left: 50px;
        }
        h1 {
            color: #FECF51;
            font-size: 2.5em;
        }
        h2 {
            color: #1F3C70;
            font-size: 1.8em;
        }
        h3 {
            color: #FECF51;
            font-size: 1.8em;
            margin-left: 24%;
        }
        h3::after {
            content: "";
            display: block;
            width: 70%;
            height: 2px; /* Висота лінії */
            background-color: #ccc; /* Колір лінії */
            margin-top: 8px;
        }
        p {
            color: #555;
            font-size: 1.1em;
            line-height: 1.6em;
        }
        .contact-info {
            margin-top: 20px;
            font-size: 1em;
        }
        .contact-info a {
            color: #1F3C70;
            text-decoration: none;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            color: #1F3C70;
            margin-right: 15px;
            text-decoration: none;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .icon {
            background-color: #FECF51; /* Жовтий колір фону */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            color: #1F3C70; /* Синій колір іконок */
            text-decoration: none;
        }
        .icon:hover {
            opacity: 0.8;
        }
        .icon i {
            font-size: 20px;
        }
        .image-slider {
            position: relative;
            max-width: 500px;
            height: 500px;
            margin: auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide {
            min-width: 100%;
            transition: opacity 0.5s ease;
        }

        .slide img {
            width: 100%;
            border-radius: 10px;
        }

        .nav-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .nav-button {
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 1.5em;
            border-radius: 50%;
        }

        .nav-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .admin-login-button {
    background-color: #1F3C70;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .admin-login-button:hover {
        background-color: #FECF51;
    }
    .review-button {
        background-color: #1F3C70;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 1.2em;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .review-button:hover {
        background-color: #FECF51;
        color: #1F3C70;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="header">
        <div class="logo">
            Anton.<span>Cv</span>
        </div>
        <ul class="nav-links">
            <li><a href="#personal-info">Personal info</a></li>
            <li><a href="#experience">Experience</a></li>
            <li><a href="#project">Last Project</a></li>
        </ul>
    </div>
    
    <h3 id="personal-info">Personal info</h3>
	<div class="container">
        <div class="left-section">
            <img src="MePhoto2.jpg" alt="Here my photo"> <!-- Here my photo -->
        </div>
        <div class="right-section">
            <h1>Hi, I'm Anton</h1>
            <h2>Student and junior programmer.</h2>
            <p>Programming is the process of creating and modifying computer programs. In the words of Niklaus Wirth, one of the founders of programming languages, "Programs = algorithms + data structures". I know about programming and its techniques, and I will be happy to help you promote your project.</p>
            <div class="contact-info">
                <p>I'm open for new job opportunities – if you would like to discuss your project, I'm available at:</p>
                <p>Email: Anton@gmail.com</a></p>
            </div>
            <div class="social-links">
                <a href="https://www.facebook.com/profile.php?id=100044926147445">Facebook</a> · <a href="https://www.linkedin.com/in/%D0%B0%D0%BD%D1%82%D0%BE%D0%BD-%D1%81%D0%B0%D0%BF%D1%80%D0%B8%D0%BA%D1%96%D0%BD-75a523333/">LinkedIn</a> · <a href="https://www.instagram.com/saprykinanton21/">Instagram</a>· <a href="https://github.com/Whowrite">GitHub</a>
            </div>
        </div>
    </div>
    <h3 id="experience">Experience</h3>
    <div class="container">
        <div class="left-section">
            <img src="https://cdn-media-1.freecodecamp.org/images/1*RNkyx-Zq7w61eR74nMYgnA.jpeg" alt="Here my photo">
        </div>
        <div class="right-section">
            <h2>I really love programming and always looking for code time!</h2>
            <p>I wrote my first project when I was on 1 year of studing in college.</p>
            <p>I'm proud of the following main skills:</p>
            <p style="margin-left: 17px;">- Pozitive and Helpful;</p>
            <p style="margin-left: 17px;">- Command Work;</p>
            <p style="margin-left: 17px;">- Know such code language as: Python, C++, C#, so-so Java, JavaScript and React-Native.</p>
        </div>
    </div>
    <h3 id="project">Last Project</h3>
    <div style="margin-left: 24%; padding: 30px;">
        <p><?php echo htmlspecialchars($project_info); ?></p>
    </div>
    <div class="container" >
        <div class="image-slider">
            <div class="slides">
                <?php foreach ($images as $img): ?>
                    <div class="slide">
                        <img src="data:image/jpeg;base64,<?php echo $img; ?>" alt="Project Image">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="nav-buttons">
                <button class="nav-button" onclick="prevSlide()">&#10094;</button>
                <button class="nav-button" onclick="nextSlide()">&#10095;</button>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="reviews.php">
            <button class="review-button">Переглянути відгуки</button>
        </a>
    </div>

    <div class="header">
        <div class="logo">
            Anton.<span>Cv</span>
            <p style="font-size: small;" >©Created by</p>
            <p style="font-size: small;" >Saprykin Anton student of</p>
            <p style="font-size: small;" >Dniprovsʹkyy College Zvaryuvannya Ta Elektroniky Imeni Patona:)</p>
        </div>
        <ul class="nav-links">
            <li><a href="#personal-info"">Personal info</a></li>
            <li><a href="#experience">Experience</a></li>
            <li><a href="#project">Last Project</a></li>
            <div class="social-icons">
                <button class="admin-login-button">Admin Login</button>
                <a href="https://www.linkedin.com/in/%D0%B0%D0%BD%D1%82%D0%BE%D0%BD-%D1%81%D0%B0%D0%BF%D1%80%D0%B8%D0%BA%D1%96%D0%BD-75a523333/" class="icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.facebook.com/profile.php?id=100044926147445" class="icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://github.com/Whowrite" class="icon"><i class="fab fa-github"></i></a>
                <a href="https://www.instagram.com/saprykinanton21/" class="icon"><i class="fab fa-instagram"></i></a>
            </div>
        </ul>
    </div>
</body>
</html>