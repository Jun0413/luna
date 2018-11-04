<?php
session_start();
$config = array(
    'navLink' => 'contact',
    'styles' => array('./libs/css/pages/contact.css'),
    'scripts' => array()
);

require_once './components/layout_header.php';
?>

    <main>
    <section class='top'>
        <div>
            <h1>Contact Us</h1>
            <div id="contact_outer">
                <img src="./images/building.jpg">
                <div id="contact_inner">
                    <p data-icon-before="location" class="icon">Napaj, Otoykihsiju, Singapore 611-0002</p>
                    <p data-icon-before="phone" class="icon">+65 8888 8888</p>
                    <a href="mailto:contact@luna.com"><p data-icon-before="mail" class="icon">contact@luna.com</p></a>
                </div>
            </div>
        </div>
    </section>

    <div id="feedback">
        <div>
            <h1>We Value your Feedback</h1>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="alert('Thank you for your feedback!')">
                <input type="text" name="name" placeholder="Your Name" required value='<?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } else { echo ""; } ?>'><br>
                <input type="email" name="email" placeholder="Your Email" required value='<?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } else { echo ""; } ?>'><br>
                <textarea rows="10" name="feedback" placeholder="What you want us to know..." required></textarea>
                <button class="primary raised-button" type="submit">Submit</button>
            </form>
        </div>
    </div>
</main>

<?php
require_once './components/layout_footer.php';
?>