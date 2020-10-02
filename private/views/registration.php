<?php $this->layout("layout")?>
<?php $this->start("title")?>
register
<?php $this->stop()?>
    <header class="v-header container">
    <?php $this->insert("_vid.header")?>
        <div class="header-overlay"></div>
        <div class="header-content">
        <div class="form"><img src="<?php echo site_url("/img/logo.PNG")?>"><br>
            <span class="login">Register</span>
            <form action="<?php echo url("register.handle")?>" method="POST">
                <input type="email" name="email" placeholder="&#xF0E0; Email" value="<?php echo input('email')?>" style="font-family:'Montserrat', sans-serif, FontAwesome" />
                <?php if(isset($errors['email'])): ?>
                <?php echo $errors['email'] ?>
                <?php endif;?>
                <input type="password" name="password" placeholder="&#xF084; Password"  style="font-family:'Montserrat', sans-serif, FontAwesome" />
                <?php if (isset ($errors['password'])):?>
                <?php echo $errors['password']?>
                <?php endif;?>
                <br>
                <input type="submit" name="submit" value="Register" />
            </form>
            <p><a href='<?php echo url("login")?>' class="darkColor">Go back to the login</a></p>
        </div>
        </div>
    </header>
