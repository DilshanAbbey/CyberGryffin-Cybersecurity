<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $inquiry = $_POST['inquiry'];
    $msg = $_POST['message'];

    file_put_contents('/var/www/html/submissions.txt', "$name|$email|$phone|$inquiry|$msg\n", FILE_APPEND);
    echo "<p>Thank you for contacting us!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberGryffin Hotels - Luxury Redefined</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            background: #0a0a0a;
            color: #fff;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #d4af37;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: #d4af37;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.7);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #d4af37, #ffd700);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Page Container */
        .page {
            min-height: 100vh;
            display: none;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease;
        }

        .page.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Home Page */
        .hero {
            height: 100vh;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(212, 175, 55, 0.3)), 
                        url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiB2aWV3Qm94PSIwIDAgMTkyMCAxMDgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8ZGVmcz4KPGZ1bGwgaWQ9ImdyYWRpZW50IiB4MT0iMCUiIHkxPSIwJSIgeDI9IjEwMCUiIHkyPSIxMDAlIj4KPHN0b3Agb2Zmc2V0PSIwJSIgc3R5bGU9InN0b3AtY29sb3I6IzFhMWExYSIvPgo8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiMzMzMiLz4KPC9ncmFkaWVudD4KPC9kZWZzPgo8cmVjdCB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiBmaWxsPSJ1cmwoI2dyYWRpZW50KSIvPgo8L3N2Zz4K');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at center, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            animation: fadeInUp 1s ease-out;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #d4af37, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            color: #e0e0e0;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #d4af37, #ffd700);
            color: #000;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.5);
        }

        /* Section Styles */
        .section {
            padding: 100px 50px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section h2 {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 50px;
            color: #d4af37;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        /* Rooms Grid */
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .room-card {
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .room-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.2);
            border-color: #d4af37;
        }

        .room-image {
            height: 250px;
            background: linear-gradient(135deg, #333, #555);
            position: relative;
            overflow: hidden;
        }

        .room-image::before {
            content: '🏨';
            font-size: 4rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.3;
        }

        .room-info {
            padding: 25px;
        }

        .room-info h3 {
            color: #d4af37;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .room-price {
            font-size: 1.8rem;
            color: #fff;
            font-weight: bold;
            margin-top: 15px;
        }

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .service-item {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.2);
            border-color: #d4af37;
        }

        .service-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #d4af37;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        }

        /* Contact Form */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            padding: 40px;
            border-radius: 15px;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #d4af37;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #d4af37, #ffd700);
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.4);
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }

        .gallery-item {
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, #333, #555);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        }

        .gallery-item::before {
            content: '📸';
            font-size: 3rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.5;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }
            
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .section {
                padding: 50px 20px;
            }
            
            .section h2 {
                font-size: 2rem;
            }
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #0a0a0a, #1a1a1a);
            padding: 50px;
            text-align: center;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .footer-section h3 {
            color: #d4af37;
            margin-bottom: 20px;
        }

        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: #d4af37;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
        }

        /* Rating Stars */
        .stars {
            color: #d4af37;
            font-size: 1.2rem;
            margin: 10px 0;
        }

        /* Special Effects */
        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: #d4af37;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div class="floating-particles" id="particles"></div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">CyberGryffin Hotels</div>
            <ul class="nav-links">
                <li><a href="#" onclick="showPage('home')">Home</a></li>
                <li><a href="#" onclick="showPage('rooms')">Rooms</a></li>
                <li><a href="#" onclick="showPage('services')">Services</a></li>
                <li><a href="#" onclick="showPage('gallery')">Gallery</a></li>
                <li><a href="#" onclick="showPage('about')">About</a></li>
                <li><a href="#" onclick="showPage('contact')">Contact</a></li>
                <li><a href="#" onclick="showPage('feedback')">Feedback</a></li>
            </ul>
            <button class="mobile-menu-btn">☰</button>
        </div>
    </nav>

    <!-- Home Page -->
    <div id="home" class="page active">
        <div class="hero">
            <div class="hero-content">
                <h1>CyberGryffin Hotels</h1>
                <p>Experience luxury redefined in the digital age. Where cutting-edge technology meets timeless elegance.</p>
                <a href="#" class="cta-button" onclick="showPage('rooms')">Explore Our Suites</a>
            </div>
        </div>
    </div>

    <!-- Rooms Page -->
    <div id="rooms" class="page">
        <div class="section">
            <h2>Luxury Accommodations</h2>
            <div class="rooms-grid">
                <div class="room-card">
                    <div class="room-image"></div>
                    <div class="room-info">
                        <h3>Cyber Executive Suite</h3>
                        <p>Our flagship suite featuring holographic displays, AI concierge, and panoramic city views.</p>
                        <div class="stars">★★★★★</div>
                        <div class="room-price">$899/night</div>
                    </div>
                </div>
                <div class="room-card">
                    <div class="room-image"></div>
                    <div class="room-info">
                        <h3>Gryffin Luxury Room</h3>
                        <p>Premium accommodations with smart home integration and luxury amenities.</p>
                        <div class="stars">★★★★★</div>
                        <div class="room-price">$599/night</div>
                    </div>
                </div>
                <div class="room-card">
                    <div class="room-image"></div>
                    <div class="room-info">
                        <h3>Digital Deluxe</h3>
                        <p>Modern comfort meets digital convenience in our signature rooms.</p>
                        <div class="stars">★★★★☆</div>
                        <div class="room-price">$399/night</div>
                    </div>
                </div>
                <div class="room-card">
                    <div class="room-image"></div>
                    <div class="room-info">
                        <h3>Presidential Penthouse</h3>
                        <p>The ultimate in luxury living with private terrace and butler service.</p>
                        <div class="stars">★★★★★</div>
                        <div class="room-price">$1,299/night</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Page -->
    <div id="services" class="page">
        <div class="section">
            <h2>Premium Services</h2>
            <div class="services-grid">
                <div class="service-item">
                    <div class="service-icon">🍽️</div>
                    <h3>Gourmet Dining</h3>
                    <p>World-class cuisine crafted by renowned chefs using molecular gastronomy and traditional techniques.</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">🧘</div>
                    <h3>Cyber Spa</h3>
                    <p>Rejuvenate with our high-tech spa featuring cryotherapy, light therapy, and AI-guided wellness programs.</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">🏋️</div>
                    <h3>Quantum Fitness</h3>
                    <p>State-of-the-art fitness center with virtual reality workouts and personal AI trainers.</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">🚗</div>
                    <h3>Elite Transport</h3>
                    <p>Luxury vehicle service featuring autonomous cars and helicopter transfers.</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">🎯</div>
                    <h3>Concierge AI</h3>
                    <p>24/7 AI-powered concierge service for personalized recommendations and bookings.</p>
                </div>
                <div class="service-item">
                    <div class="service-icon">🏛️</div>
                    <h3>Business Center</h3>
                    <p>High-tech business facilities with holographic meeting rooms and global connectivity.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Page -->
    <div id="gallery" class="page">
        <div class="section">
            <h2>Gallery</h2>
            <p style="text-align: center; margin-bottom: 30px; color: #ccc;">Discover the beauty and elegance of CyberGryffin Hotels</p>
            <div class="gallery-grid">
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
                <div class="gallery-item"></div>
            </div>
        </div>
    </div>

    <!-- About Page -->
    <div id="about" class="page">
        <div class="section">
            <h2>About CyberGryffin Hotels</h2>
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <p style="font-size: 1.2rem; line-height: 1.8; color: #e0e0e0; margin-bottom: 30px;">
                    CyberGryffin Hotels represents the pinnacle of luxury hospitality in the digital age. Founded in 2020, we have revolutionized the hotel industry by seamlessly blending cutting-edge technology with timeless elegance and exceptional service.
                </p>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #ccc; margin-bottom: 30px;">
                    Our name draws inspiration from the mythical griffin, a symbol of strength and vigilance, combined with our cyber-forward approach to hospitality. We believe that technology should enhance, not replace, the human touch that makes a stay truly memorable.
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 50px;">
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #d4af37; font-weight: bold;">50+</div>
                        <div style="color: #ccc;">Luxury Properties</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #d4af37; font-weight: bold;">98%</div>
                        <div style="color: #ccc;">Guest Satisfaction</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #d4af37; font-weight: bold;">25</div>
                        <div style="color: #ccc;">Countries</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; color: #d4af37; font-weight: bold;">5★</div>
                        <div style="color: #ccc;">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Page -->
    <div id="contact" class="page">
        <div class="section">
            <h2>Contact Us</h2>
            <div class="contact-form">
                <form id="contactForm" method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="inquiry">Inquiry Type</label>
                        <select id="inquiry" name="inquiry" required>
                            <option value="">Select an option</option>
                            <option value="reservation">Reservation</option>
                            <option value="events">Events & Meetings</option>
                            <option value="general">General Information</option>
                            <option value="support">Customer Support</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn" value="Submit">Send Message</button>
                </form>
            </div>
            <div style="text-align: center; margin-top: 50px; color: #ccc;">
                <p><strong>Global Reservations:</strong> +1 (555) 123-LUXURY</p>
                <p><strong>Email:</strong> reservations@cybergryffin.com</p>
                <p><strong>Address:</strong> 1 Luxury Boulevard, Metropolitan District</p>
            </div>
        </div>
    </div>

    <!-- Feedback Page -->
    <div id="feedback" class="page">
        <div class="section">
            <h2>Guest Feedback</h2>
            <div class="contact-form">
                <form id="feedbackForm">
                    <div class="form-group">
                        <label for="guestName">Guest Name</label>
                        <input type="text" id="guestName" name="guestName" required>
                    </div>
                    <div class="form-group">
                        <label for="guestEmail">Email Address</label>
                        <input type="email" id="guestEmail" name="guestEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="stayDate">Date of Stay</label>
                        <input type="date" id="stayDate" name="stayDate" required>
                    </div>
                    <div class="form-group">
                        <label for="roomType">Room Type</label>
                        <select id="roomType" name="roomType" required>
                            <option value="">Select room type</option>
                            <option value="cyber-executive">Cyber Executive Suite</option>
                            <option value="gryffin-luxury">Gryffin Luxury Room</option>
                            <option value="digital-deluxe">Digital Deluxe</option>
                            <option value="presidential">Presidential Penthouse</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="overallRating">Overall Rating</label>
                        <select id="overallRating" name="overallRating" required>
                            <option value="">Select rating</option>
                            <option value="5">★★★★★ Excellent</option>
                            <option value="4">★★★★☆ Very Good</option>
                            <option value="3">★★★☆☆ Good</option>
                            <option value="2">★★☆☆☆ Fair</option>
                            <option value="1">★☆☆☆☆ Poor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="serviceRating">Service Quality</label>
                        <select id="serviceRating" name="serviceRating" required>
                            <option value="">Rate our service</option>
                            <option value="5">★★★★★ Outstanding</option>
                            <option value="4">★★★★☆ Excellent</option>
                            <option value="3">★★★☆☆ Good</option>
                            <option value="2">★★☆☆☆ Needs Improvement</option>
                            <option value="1">★☆☆☆☆ Poor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recommendations">Would you recommend us?</label>
                        <select id="recommendations" name="recommendations" required>
                            <option value="">Select an option</option>
                            <option value="definitely">Definitely</option>
                            <option value="probably">Probably</option>
                            <option value="maybe">Maybe</option>
                            <option value="probably-not">Probably Not</option>
                            <option value="definitely-not">Definitely Not</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="feedbackMessage">Your Feedback</label>
                        <textarea id="feedbackMessage" name="feedbackMessage" rows="5" placeholder="Please share your experience, suggestions, or any specific comments..." required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Submit Feedback</button>
                </form>
            </div>
            
            <!-- Sample Reviews -->
            <div style="margin-top: 60px;">
                <h3 style="text-align: center; color: #d4af37; margin-bottom: 40px;">Recent Guest Reviews</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    <div style="background: linear-gradient(135deg, #1a1a1a, #2a2a2a); padding: 25px; border-radius: 15px; border: 1px solid rgba(212, 175, 55, 0.2);">
                        <div class="stars">★★★★★</div>
                        <p style="color: #e0e0e0; margin: 15px 0; font-style: italic;">"Absolutely phenomenal experience! The AI concierge was incredibly helpful, and the cyber spa was unlike anything I've experienced before."</p>
                        <div style="color: #d4af37; font-weight: bold;">- Sarah M., Business Executive</div>
                    </div>
                    <div style="background: linear-gradient(135deg, #1a1a1a, #2a2a2a); padding: 25px; border-radius: 15px; border: 1px solid rgba(212, 175, 55, 0.2);">
                        <div class="stars">★★★★★</div>
                        <p style="color: #e0e0e0; margin: 15px 0; font-style: italic;">"The perfect blend of luxury and technology. The holographic displays in our suite were mind-blowing, and the service was impeccable."</p>
                        <div style="color: #d4af37; font-weight: bold;">- Michael R., Tech Entrepreneur</div>
                    </div>
                    <div style="background: linear-gradient(135deg, #1a1a1a, #2a2a2a); padding: 25px; border-radius: 15px; border: 1px solid rgba(212, 175, 55, 0.2);">
                        <div class="stars">★★★★☆</div>
                        <p style="color: #e0e0e0; margin: 15px 0; font-style: italic;">"CyberGryffin Hotels set a new standard for luxury hospitality. Every detail was thoughtfully designed for the modern traveler."</p>
                        <div style="color: #d4af37; font-weight: bold;">- Emily L., Travel Blogger</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>CyberGryffin Hotels</h3>
                <p>Luxury redefined in the digital age. Experience the future of hospitality with cutting-edge technology and timeless elegance.</p>
                <div style="margin-top: 20px;">
                    <span style="font-size: 1.5rem;">🌐 📱 💎</span>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="#" onclick="showPage('rooms')">Luxury Rooms</a></p>
                <p><a href="#" onclick="showPage('services')">Premium Services</a></p>
                <p><a href="#" onclick="showPage('gallery')">Gallery</a></p>
                <p><a href="#" onclick="showPage('about')">About Us</a></p>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>📞 +1 (555) 123-LUXURY</p>
                <p>✉️ reservations@cybergryffin.com</p>
                <p>📍 1 Luxury Boulevard<br>Metropolitan District</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <p>Stay connected for exclusive offers and updates</p>
                <p>Instagram | Twitter | LinkedIn</p>
                <p style="margin-top: 15px; color: #d4af37;">★★★★★ Rated Excellence</p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(212, 175, 55, 0.2); color: #888;">
            <p>&copy; 2025 CyberGryffin Hotels. All rights reserved. | Privacy Policy | Terms of Service</p>
        </div>
    </footer>

    <script>
        // Page Navigation
        function showPage(pageId) {
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => {
                page.classList.remove('active');
            });
            
            setTimeout(() => {
                document.getElementById(pageId).classList.add('active');
            }, 100);
        }

        // Form Submissions
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Show success message
            alert('Thank you for your message! Our team will respond within 24 hours.');
            this.reset();
        });

        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Show success message
            alert('Thank you for your valuable feedback! We appreciate your time and will use your input to improve our services.');
            this.reset();
        });

        // Floating Particles Animation
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 15;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                const size = Math.random() * 4 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 4) + 's';
                
                particlesContainer.appendChild(particle);
            }
        }

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(0, 0, 0, 0.95)';
                navbar.style.backdropFilter = 'blur(15px)';
            } else {
                navbar.style.background = 'rgba(0, 0, 0, 0.9)';
                navbar.style.backdropFilter = 'blur(10px)';
            }
        });

        // Animate elements on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.room-card, .service-item, .gallery-item');
            
            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                
                if (isVisible && !element.classList.contains('fade-in')) {
                    element.classList.add('fade-in');
                }
            });
        }

        // Mobile menu toggle (basic implementation)
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            const navLinks = document.querySelector('.nav-links');
            if (navLinks.style.display === 'flex') {
                navLinks.style.display = 'none';
            } else {
                navLinks.style.display = 'flex';
                navLinks.style.flexDirection = 'column';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '100%';
                navLinks.style.left = '0';
                navLinks.style.right = '0';
                navLinks.style.background = 'rgba(0, 0, 0, 0.95)';
                navLinks.style.padding = '20px';
            }
        });

        // Smooth hover effects for interactive elements
        function addHoverEffects() {
            const interactiveElements = document.querySelectorAll('.room-card, .service-item, .gallery-item');
            
            interactiveElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                    this.style.transition = 'all 0.3s ease';
                });
                
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        }

        // Initialize animations and effects
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            addHoverEffects();
            
            // Add scroll listener for animations
            window.addEventListener('scroll', animateOnScroll);
            
            // Initial animation check
            setTimeout(animateOnScroll, 500);
        });

        // Add typing effect to hero text
        function typeWriter(element, text, speed = 50) {
            let i = 0;
            element.innerHTML = '';
            
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            
            type();
        }

        // Enhanced page transitions
        function enhancedShowPage(pageId) {
            const currentPage = document.querySelector('.page.active');
            const targetPage = document.getElementById(pageId);
            
            if (currentPage) {
                currentPage.style.opacity = '0';
                currentPage.style.transform = 'translateX(-30px)';
                
                setTimeout(() => {
                    currentPage.classList.remove('active');
                    targetPage.classList.add('active');
                    targetPage.style.opacity = '1';
                    targetPage.style.transform = 'translateX(0)';
                }, 300);
            }
        }

        // Add dynamic gradient backgrounds
        function createDynamicBackground() {
            const hero = document.querySelector('.hero');
            let angle = 0;
            
            setInterval(() => {
                angle += 1;
                hero.style.background = `linear-gradient(${angle}deg, rgba(0, 0, 0, 0.8), rgba(212, 175, 55, 0.3)), 
                                       url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiB2aWV3Qm94PSIwIDAgMTkyMCAxMDgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8ZGVmcz4KPGZ1bGwgaWQ9ImdyYWRpZW50IiB4MT0iMCUiIHkxPSIwJSIgeDI9IjEwMCUiIHkyPSIxMDAlIj4KPHN0b3Agb2Zmc2V0PSIwJSIgc3R5bGU9InN0b3AtY29sb3I6IzFhMWExYSIvPgo8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0eWxlPSJzdG9wLWNvbG9yOiMzMzMiLz4KPC9ncmFkaWVudD4KPC9kZWZzPgo8cmVjdCB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiBmaWxsPSJ1cmwoI2dyYWRpZW50KSIvPgo8L3N2Zz4K')`;
                hero.style.backgroundSize = 'cover';
                hero.style.backgroundPosition = 'center';
            }, 100);
        }

        // Initialize dynamic effects
        setTimeout(() => {
            createDynamicBackground();
        }, 2000);
    </script>
</body>
</html>
