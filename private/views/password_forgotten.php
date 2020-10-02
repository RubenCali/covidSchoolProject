<?php $this->layout("layout")?>
<?php $this->start("title")?>
Forgot Password
<?php $this->stop()?>
    <header class="v-header container">
<?php $this->insert("_vid.header")?>
        </div>
        <div class="header-overlay"></div>
        <div class="header-content">
            <div class="back">
                <div class="form">
                    <img src="<?php echo site_url("/img/logo.PNG")?>"><br>
                    <?php if(!$mail_sent):?>
                    <span class="login">We send you a email to reset your password</span>
                    <form action="<?php echo url("password.change")?>" method="post" name="login">
                        <input type="email" name="email" placeholder="&#xF0E0; Email" required style="font-family:'Montserrat', sans-serif, FontAwesome" /> 
                        <?php if(isset($errors['email'])): ?>
                        <?php echo $errors['email'] ?>
                        <?php endif;?>
                        <input name="submit" type="submit" value="Resest Password" />
                    </form>
                        <?php else: ?>
                        <h4>The mail has been sended too your email</h4>
                        <?php endif;?>
                </div>
            </div>
        </div>
    </header>
