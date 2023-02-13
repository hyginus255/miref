<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miref - Open up your business to thousands of freelance marketers</title>
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <nav class="flex flex-jc-sb flex-ai-c">
            <a href="/" class="header__logo">
                <img src="assets/Images/Logo.svg" alt="Miref Logo">
            </a>
            <a href="#" id="btn_menu" class="header__menu hide-for-desktop">
                <span></span>
                <span></span>
                <span></span>
            </a>

            <div class="background hide-for-mobile">
                <div class="header__links">
                    <!-- <a href="#">Home</a> -->
                    <a href="about.html">About Us</a>
                    <a href="business.html">For Business</a>
                    <a href="Refferers.html">For Refferers</a>
                    <a class="active" href="faq.php">FAQ</a>
                    <a href="contact.html">Contact</a>
                </div>
            </div>

            <a href="#newsletter_section" class="btn-primary hide-for-mobile">Stay Informed</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero section">
        <div class="hero__content container flex">
            <div class="hero__text">
                <h1 id="text_width_about">Frequently asked questions</h1>
                <p id="faq_sub_text">Have any questions? We are here to help you.</p>
                <div class="search_input" id="faq_search_input">
                    <input type="text" placeholder="Search" class="input">
                    <img src="assets/Images/search_icon.svg" alt="Search Icon">
                </div>
                
            </div>
        </div>
        <img src="assets/Images/hero layer blur.png" alt="" class="hero__blur hide-for-mobile">
    </section>


    <div class="faq section">
        <div class="faq__container container flex flex-fd-c">
            <?php
            $qfaq = mysqli_query($conn, "select * from faq where status1 = 1");
            while($getfaq==mysqli_fetch_array($qfaq)){
            ?>
            <div class="faq__item">
                <div class="faq__header flex">
                    <h6><?php echo $getfaq['question']?></h6>
                    <img src="assets/Images/featured_icon_close.svg" class="faq__close" alt="Feature Icon">
                    <img src="assets/Images/featured_icon_open.svg" class="faq__open" alt="Feature Icon">
                </div>
                <p class="faq__text"><?php echo $getfaq['answer']?></p>
            </div>
            <?php } ?>
            
        </div>
    </div>






    <!-- Newsletter Section -->
    <section class="newsletter section" id="newsletter_section">
        <div class="container">
            <div class="newsletter__card">
                <div>
                    <h5>Subscribe to stay informed</h5>
                    <p>Be the first to know when it’s launched</p>
                    <form action="#" class="flex">
                        <input type="text" placeholder="Name" class="input">
                        <input type="text" placeholder="Email" class="input">
                        <input type="submit" value="submit" class="btn-secondary newsletter__submit">
                    </form>
                    <p class="newsletter__help_text">We care about your data in our privacy policy</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer section">
        <div class="container">
            <div class="flex footer__top flex-fd-c">
                <div class="footer__brand flex flex-fd-c">
                    <img src="assets/Images/Logo.svg" alt="Logo">
                    <p>We win together.</p>
                    <p>Address : Plot 1141, Cadastral Zone B07, Katampe, Abuja</p>
                </div>
                <div class="flex footer__links_container flex-fd-c">
                    <div class="flex footer__links_content">
                        <div class="flex footer__links_column flex-fd-c">
                            <p>Features</p>
                            <div class="flex flex-fd-c footer__links">
                                <a href="#">Miref Business</a>
                                <a href="#">Miref Personal</a>
                            </div>
                        </div>
                        <div class="flex footer__links_column flex-fd-c">
                            <p>Company</p>
                            <div class="flex flex-fd-c footer__links">
                                <a href="#">About us</a>
                                <a href="#">Careers</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex footer__links_content">
                        <div class="flex footer__links_column flex-fd-c">
                            <p>Help</p>
                            <div class="flex flex-fd-c footer__links">
                                <a href="#">FAQ</a>
                                <a href="#">Help centre</a>
                            </div>
                        </div>
                        <div class="flex footer__links_column flex-fd-c">
                            <p>Legal</p>
                            <div class="flex flex-fd-c footer__links">
                                <a href="#">Terms</a>
                                <a href="#">Privacy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="footer__bottom flex flex-fd-c">
                <p>© 2023 Miref. All rights reserved.</p>
                <div class="flex">
                    <a target="_blank" href="https://twitter.com/mirefApp"><img src="assets/Images/Twitter icon.svg" alt=""></a>
                    <a target="_blank" href="https://www.instagram.com/miref.app/"><img src="assets/Images/instagram.svg" alt=""></a>
                    <a target="_blank" href="https://web.facebook.com/mirefapp"><img src="assets/Images/Facebook icon.svg" alt=""></a>
                </div>
            </div>
        </div>
    </footer>

<script src="app/js/script.js"></script>
</body>
</html>