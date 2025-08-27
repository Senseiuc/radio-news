<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Articles | Homeland News Network</title>
    <meta name="description" content="Latest articles from Homeland News Network">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        header {
            background-color: #1a365d;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .date-display {
            font-size: 14px;
            opacity: 0.9;
        }

        nav ul {
            display: flex;
            list-style: none;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 10px;
        }

        nav li {
            margin-right: 25px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: opacity 0.3s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        /* Main Content */
        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin: 30px 0;
        }

        /* Article Cards */
        .article-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            transition: transform 0.3s;
        }

        .article-card:hover {
            transform: translateY(-5px);
        }

        .article-content {
            padding: 20px;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
        }

        .article-author {
            font-weight: 500;
            color: #2c5282;
        }

        .article-date {
            color: #718096;
        }

        .article-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            margin-bottom: 10px;
            color: #2d3748;
        }

        .article-excerpt {
            color: #4a5568;
            margin-bottom: 15px;
        }

        .read-more {
            display: inline-block;
            color: #2c5282;
            font-weight: 500;
            text-decoration: none;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        /* Section Headers */
        .section-header {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin: 40px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            color: #2d3748;
        }

        /* Breaking News */
        .breaking-news {
            background: linear-gradient(to right, #c53030, #e53e3e);
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            margin: 20px 0;
            display: flex;
            align-items: center;
        }

        .breaking-label {
            background: white;
            color: #c53030;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 700;
            margin-right: 15px;
            font-size: 14px;
        }

        /* Sidebar */
        .sidebar-widget {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .widget-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 18px;
            margin-bottom: 15px;
            color: #2d3748;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .trending-list {
            list-style: none;
        }

        .trending-item {
            padding: 10px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .trending-item:last-child {
            border-bottom: none;
        }

        .trending-link {
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            display: block;
        }

        .trending-link:hover {
            color: #2c5282;
        }

        /* Footer */
        footer {
            background: #1a202c;
            color: white;
            padding: 40px 0;
            margin-top: 50px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .footer-column h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 18px;
            margin-bottom: 20px;
            color: #e2e8f0;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #a0aec0;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: white;
        }

        .copyright {
            text-align: center;
            margin-top: 40px;
            color: #718096;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            nav ul {
                flex-wrap: wrap;
            }

            nav li {
                margin-bottom: 10px;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="header-top">
            <a href="#" class="logo">HOMELAND NEWS</a>
            <div class="date-display">Tuesday, August 26, 2025</div>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">World</a></li>
                <li><a href="#">Politics</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#">Africa</a></li>
                <li><a href="#">Sports</a></li>
                <li><a href="#">Entertainment</a></li>
                <li><a href="#">Health</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <div class="breaking-news">
        <span class="breaking-label">BREAKING</span>
        <span>Four Journalists Missing After Clashes in Eastern DR Congo</span>
    </div>

    <div class="main-content">
        <div class="content-primary">
            <h2 class="section-header">TRENDING NOW</h2>

            <div class="article-card">
                <div class="article-content">
                    <div class="article-meta">
                        <span class="article-author">by Olawunmi Sola-Otegbade</span>
                        <span class="article-date">August 26, 2025</span>
                    </div>
                    <h3 class="article-title">DR Congo: M23 Rebels Resume Peace Talks in Qatar Amid Renewed Violence</h3>
                    <p class="article-excerpt">Peace talks between the Congolese government and M23 rebels have resumed in Doha despite ongoing violence in the eastern regions of the country. International mediators are pushing for a ceasefire.</p>
                    <a href="#" class="read-more">Read more →</a>
                </div>
            </div>

            <div class="article-card">
                <div class="article-content">
                    <div class="article-meta">
                        <span class="article-author">by Olawunmi Sola-Otegbade</span>
                        <span class="article-date">August 26, 2025</span>
                    </div>
                    <h3 class="article-title">Lili Nats X Faces Felony Charges After Naked Confrontation With Los Angeles Police</h3>
                    <p class="article-excerpt">Controversial musician Lili Nats X could face felony charges following a bizarre incident where she confronted LAPD officers while completely nude, allegedly obstructing justice.</p>
                    <a href="#" class="read-more">Read more →</a>
                </div>
            </div>

            <div class="article-card">
                <div class="article-content">
                    <div class="article-meta">
                        <span class="article-author">by Olawunmi Sola-Otegbade</span>
                        <span class="article-date">August 26, 2025</span>
                    </div>
                    <h3 class="article-title">Likely Source of Legionnaires' Disease Identified in London, Ontario as Outbreak Redeclared</h3>
                    <p class="article-excerpt">Health officials in London, Ontario have identified the likely source of a Legionnaires' disease outbreak that has sickened multiple residents. The outbreak has been officially redeclared as cases continue to emerge.</p>
                    <a href="#" class="read-more">Read more →</a>
                </div>
            </div>

            <h2 class="section-header">BUSINESS</h2>

            <div class="article-card">
                <div class="article-content">
                    <div class="article-meta">
                        <span class="article-author">by Olawunmi Sola-Otegbade</span>
                        <span class="article-date">August 26, 2025</span>
                    </div>
                    <h3 class="article-title">Bank of Canada Targets Flexibility in Rate-Setting Framework Review, Says Macklem</h3>
                    <p class="article-excerpt">Bank of Canada Governor Tiff Macklem emphasized the need for flexibility as the central bank reviews its monetary policy framework. The review comes amid changing economic conditions.</p>
                    <a href="#" class="read-more">Read more →</a>
                </div>
            </div>

            <h2 class="section-header">AFRICA</h2>

            <div class="article-card">
                <div class="article-content">
                    <div class="article-meta">
                        <span class="article-author">by Nesta Sami</span>
                        <span class="article-date">August 26, 2025</span>
                    </div>
                    <h3 class="article-title">(VIDEO) Former Kwara First Lady Fights Cancer With New Movie</h3>
                    <p class="article-excerpt">The former First Lady of Kwara State is using film as a medium to raise awareness about cancer prevention and treatment, drawing from her personal experience with the disease.</p>
                    <a href="#" class="read-more">Read more →</a>
                </div>
            </div>

            <div class="article-card">
                <div class="article-content">
                    <div class="article-meta">
                        <span class="article-author">by Chukwudi Ogama</span>
                        <span class="article-date">August 26, 2025</span>
                    </div>
                    <h3 class="article-title">Five Killed, Parliament Set Ablaze In Kenya Tax Protests</h3>
                    <p class="article-excerpt">Violent protests against proposed tax increases have rocked Kenya, resulting in five fatalities and parts of the parliament building being set on fire by demonstrators.</p>
                    <a href="#" class="read-more">Read more →</a>
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">TRENDING</h3>
                <ul class="trending-list">
                    <li class="trending-item"><a href="#" class="trending-link">Spotify Revives Messaging Feature to Boost User Growth</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Trump's Flag Burning Order Could Push Case to Supreme Court</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Canadian Athletes Frustrated Over SRY Gene Testing Chaos</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Tropical Storm Strikes Vietnam, Leaves 3 Dead and Soaks Region</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Australia Expels Iranian Ambassador Over Alleged Antisemitic Remarks</a></li>
                </ul>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">RECENT</h3>
                <ul class="trending-list">
                    <li class="trending-item"><a href="#" class="trending-link">Norway's Prime Minister Visits Ukraine as President Seeks Support</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Canada Strengthens Energy Partnership with Germany</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Trump Honors Fallen U.S. Service Members, Criticizes Biden</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">LeBlanc and Lunick to Meet as Canada Seeks Border Solutions</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">President Trump Announces U.S. Deal for 10% Tariff Reduction</a></li>
                </ul>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">EVENTS</h3>
                <ul class="trending-list">
                    <li class="trending-item"><a href="#" class="trending-link">Winnipeg's African Communities Gather for 6th Annual Festival</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Kara Magazine Launched to Empower Young African-Canadians</a></li>
                    <li class="trending-item"><a href="#" class="trending-link">Ascot Racecourse Sees Unprecedented Demand for Summer Packages</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>About Us</h3>
                <ul class="footer-links">
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Editorial Team</a></li>
                    <li><a href="#">Ethics Policy</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Sections</h3>
                <ul class="footer-links">
                    <li><a href="#">World News</a></li>
                    <li><a href="#">Politics</a></li>
                    <li><a href="#">Business</a></li>
                    <li><a href="#">Africa</a></li>
                    <li><a href="#">Entertainment</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Connect</h3>
                <ul class="footer-links">
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Subscribe</a></li>
                    <li><a href="#">Newsletter</a></li>
                    <li><a href="#">Social Media</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Legal</h3>
                <ul class="footer-links">
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">GDPR</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            &copy; 2025 Homeland News Network. All rights reserved.
        </div>
    </div>
</footer>

<script>
    // Update date display with current date
    document.addEventListener('DOMContentLoaded', function() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const today = new Date().toLocaleDateString('en-US', options);
        document.querySelector('.date-display').textContent = today;
    });
</script>
</body>
</html>
