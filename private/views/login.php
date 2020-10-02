<?php $this->layout("layout")?>
<?php $this->start("title")?>
login
<?php $this->stop()?>
    <header class="v-header container">
<?php $this->insert("_vid.header")?>
        </div>
        <div class="header-overlay"></div>
        <div class="header-content">
            <div class="back">
                <div class="form">
                    <img src="<?php echo site_url("/img/logo.PNG")?>"><br>
                    <span class="login">Login</span>
                    <form action="<?php echo url("login.handle")?>" method="post" name="login">
                        <input type="email" name="email" placeholder="&#xF0E0; Email" required style="font-family:'Montserrat', sans-serif, FontAwesome" /> 
                        <?php if(isset($errors['email'])): ?>
                        <?php echo $errors['email'] ?>
                        <?php endif;?>
                        <input type="password" name="password" placeholder="&#xF084; Password" required style="font-family:'Montserrat', sans-serif, FontAwesome" /><br>
                        <?php if (isset ($errors['password'])):?>
                        <?php echo $errors['password']?>
                        <?php endif;?><br>
                        <p>
                            <a href="<?php echo url("password.change")?>">Forgot password ?</a>
                        </p>
                        <input name="submit" type="submit" value="Login" />
                    </form>
                    <p class="member">Not a StayActive member yet?<br>
                        <a href='<?php echo url("register")?>'>Register Here</a></p>
                </div>
            </div>
        </div>
    </header>
