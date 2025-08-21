<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Subscribe</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #1a2b3c;
            color: #fff;
        }

        /* Header styling */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #273043;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #fbd600;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .search-btn {
            background-color: #fbd600;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }

        /* Main section styling */
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 100px 50px;
        }

        .container .content {
            max-width: 50%;
        }

        .container h1 {
            color: #fbd600;
            font-size: 48px;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #ccc;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input[type="submit"] {
            background-color: #fbd600;
            color: #1a2b3c;
            cursor: pointer;
            font-weight: bold;
            width: 40%;
            transition: 0.3s;
        }

        .form-group input[type="submit"]:hover {
            background-color: #f1b400;
        }

        /* Image container styling */
        .image-container {
            position: relative;
        }

        .image-container img {
            max-width: 500px;
            border-radius: 20px;
        }

        /* Decorative shapes */
        .decorative-shape {
            position: absolute;
            background-color: #fbd600;
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }

        .decorative-shape.one {
            top: 0;
            right: -50px;
        }

        .decorative-shape.two {
            bottom: 0;
            left: -50px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">Creative Marketing</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </nav>
        <div class="search-btn">🔍</div>
    </header>

    <!-- Main container -->
    <section class="container">
        <!-- Left content -->
        <div class="content">
            <h1>Subscribe Now to Our Newsletter</h1>
            <p>Stay updated with our latest news and exclusive offers by subscribing to our newsletter.</p>
            <form>
                <div class="form-group">
                    <input type="text" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Send">
                </div>
            </form>
        </div>

        <!-- Image container -->
        <div class="image-container">
            <img src="https://via.placeholder.com/500x500" alt="Image of a person working on a laptop">
            
        </div>
    </section>
</body>
</html>
