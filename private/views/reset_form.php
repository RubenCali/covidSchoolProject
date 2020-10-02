<?php $this->layout("layout")?>
<?php $this->start("title")?>
reset Password
<?php $this->stop()?>
    <header class="v-header container">
<?php $this->insert("_vid.header")?>
        </div>
        <div class="header-overlay"></div>
        <div class="header-content">
            <div class="back">
                <div class="form">
                    <img src="<?php echo site_url("/img/logo.PNG")?>"><br>
                    <span class="login">Reset password</span>
                    <form action="<?php echo url("password.reset", ['reset_code' => $reset_code])?>" method="post" name="login">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="&#xF084; Password" required style="font-family:'Montserrat', sans-serif, FontAwesome" /><br>
                        <?php if (isset ($errors['password'])):?>
                        <?php echo $errors['password']?>
                        <?php endif;?><br>
                        <label for="password_confirm">Password Confirm</label>
                        <input type="password" name="password_confirm" class="form-control" placeholder="&#xF084; Password" required style="font-family:'Montserrat', sans-serif, FontAwesome">
                        <input name="submit" type="submit" value="Confrim Reset" />
                    </form>
                </div>
            </div>
        </div>
    </header>
