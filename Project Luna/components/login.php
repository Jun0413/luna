<div id='login-modal'>

    <form class="login-modal-content" action="" method="POST">
        <span onclick="document.getElementById('login-modal').style.display='none';document.body.style.overflow='auto'" class="close">&times;</span> 

        <div class="login-tab">
            <input type="radio" hidden id="signup" name="action">
            <label for="signup" onclick="displaySignup()">Sign-up</label>
            <input type="radio" hidden id="signin" name="action" checked>
            <label for="signin" onclick="displaySignin()">Sign-in</label>

            <!-- add this input so that multipurpose page can tell which form is submitted -->
            <input type="hidden" name="byLoginForm" value="yes">
        </div>

        <section class="login-input">   
        </section>

    </form>

    <div id="login-input-signin" style="display:none">
        <label><b>Email</b></label>
        <input type="email" placeholder="Enter email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <div style="text-align:center">
            <button type="button" onclick="signin_handler()">Login</button>
        </div>
    </div>

    <div id="login-input-signup" style="display:none">
        <label><b>Username</b></label>
        <input type="text" placeholder="Enter your name" name="name" required>

        <label><b>Email</b></label>
        <input type="email" placeholder="Enter email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <div style="text-align:center">
            <button type="button" onclick="signup_handler()">Register</button>
        </div>
    </div>

</div>