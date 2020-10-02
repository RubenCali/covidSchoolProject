<?php $this->layout("layoutGeinlogde")?>
<section id="header">
    <div class="sidenav" id="sidenav">
        <img src="<?php echo site_url("/img/logoNON.PNG")?>" alt="logo">
        <a href="<?php echo url("geinlogdepagina")?>" class="home"><i class="fas fa-home"></i> HOME</a>
        <a href="<?php echo url("settings")?>" class="settings"><i class="fas fa-cog"></i></i>  SETTINGS</a>
        <a href="<?php echo url("logout")?>" class="signOut"><i class="fas fa-sign-out-alt"></i> SIGN-OUT</a>
        <form action="<?php echo url("search")?>" method="POST">
        <input type="text" name="search" placeholder="search...">
        </form>
        <footer>
<div id="demo">
<button type="button" onclick="loadDoc()" class="btn">
Click to see &copy;
</button>
</div>
</footer>
    </div>
</section>
<section id="bar">
    <div class="bars">
        <div class="start opa1 " id="start">
          <i class="fas fa-bars" ></i>
        </div>
        <div class="stop opa0 " id="stop">
          <i class="fas fa-bars" ></i>
        </div>
            </div>
</section>

<section id="sporten">
    <div class="grid">

<?php foreach($sports as $sport): ?> 
    <a href="<?php echo url("schema", ['sport_id' => $sport['id']])?>">
    <div class="layout img<?php echo $sport['id'] ?>">
    <div class="sport1">
          <img src="<?php echo site_url('/img/' . $sport['icon_img'])?>" alt="foto van een bal" class="resize<?php echo $sport['id'] ?>">
          <h2><?php echo $sport['titel']?></h2>
</div>
    </div>
  
    </a>
<?php endforeach; ?>
    
      
    </div>
</section>


    
<script>
function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("demo").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "<?php echo site_url( '/txt/ajax_info.txt' ) ?>", true);
  xhttp.send();
}
</script>

    <script src="https://kit.fontawesome.com/f28585beb5.js" crossorigin="anonymous"></script>
    <script src="<?php echo site_url( '/js/index.js' ) ?>"></script>

