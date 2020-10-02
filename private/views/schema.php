<?php $this->layout("layoutSchema");


?>



<div class="background">
   

<section id="popup">

    <h1><?php echo $sport['titel']?></h1>
    <div class="grid">
        <div class="left">
        <h3>Condition training</h3>
            <div class="insidegrid">
            <?php foreach($condition as $row): ?>
                <div class="lefttop"><?php echo $row['instructie'] ?></div>
                
            <?php endforeach; ?>            
            </div>
            </div>
            <div class="right">
                <h3>Strenght training</h3>
                <div class="insidegrid">
                <?php foreach($strength as $row): ?>
                <div class="lefttop"><?php echo $row['instructie'] ?></div>
                
            <?php endforeach; ?>   
                 </div>
        </div>
    </div>
    <div class="back">
        <a href="<?php echo url('geinlogdepagina')?>"><i class="fas fa-undo-alt"></i></a>
    </div>
</section>

</div>


<script src="https://kit.fontawesome.com/f28585beb5.js" crossorigin="anonymous"></script>


