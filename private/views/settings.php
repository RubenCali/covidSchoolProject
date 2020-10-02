<?php $this->layout("layoutSettings")?>
    <div class="grid">
  <section id="logo">
    <div class="logo">
        <a href="<?php echo url("geinlogdepagina")?>">
        <img src="<?php echo site_url("/img/logo.PNG")?>" alt="logo">
        </a>
    </div>
    <div class="back">
        <a href="<?php echo url("geinlogdepagina")?>">
         <i class="fas fa-undo-alt"></i>
        </a>
    </div>
  </section>
  <section>
    <div class="account">
        <div class="person">
             <i class="fas fa-user"></i>
        </div>
        <div class="name">
            <h2>Email:</h2>
            <p type="text" name="emailVeranderen"><?php echo $user['email'];?></p>
        </div>
        <div class="email">
            
        </div>
        <div class="password">
            <h2>Password:</h2>
            <p type="text" name="wachtwoordVeranderen" ><?php echo $user['password'];?></p>
            <!-- <h3 class="text changePword">Change password. Click <a href="changepassword.php">HERE</a></h3> -->
        </div>
    </div>
  </section>

</div>



  <script src="https://kit.fontawesome.com/f28585beb5.js" crossorigin="anonymous"></script>
