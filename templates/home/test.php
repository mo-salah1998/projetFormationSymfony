<!-- Partie des evenements -->


<div class="brand" id="evenement">
    <h2> NOS ÉVÈNEMENTS </h2>
    <h4 > ici vous pouvez découvrir nos évènements </h4>
</div>

<div class="container">
    <div class="filters filter-button-group">
        <ul><h4>
                <li class="active" data-filter="*">Tous</li>
                <!-- <li data-filter=".vtt">VTT</li>
                <li data-filter=".marche">Marche</li>
                <li data-filter=".escale">Escale</li>
                <li data-filter=".cours">Course d'oriantation</li>
                <li data-filter=".accro">Accrobranche tyrolienne</li>
                <li data-filter=".soiree">Soirée trappeur</li>-->
                <?php if(isset($row_categs) && !empty($row_categs)){
                    foreach($row_categs as $row_categ){  ?>
                        <li data-filter=".categorie_<?php echo $row_categ['id_categorie']; ?>"><?php echo $row_categ['name']; ?></li>
                    <?php } } ?>
            </h4></ul>
    </div>
</div>


<div class="container">

    <div class="content grid">

        <?php if(isset($row_events) && !empty($row_events)){
            foreach($row_events as $row_event){?>

                <div class="col-sm-4 categorie_<?php echo $row_event['id_categorie']; ?> grid-item">
                    <figure class="snip1218 zoom">
                        <div class="image">
                            <a class="fancybox" href="#text1" > <img src="images/<?php echo $row_event['photo']; ?> "  title="cliquer ici"  alt="sample70">
                                <div id="text1" >

                                    <h4><?php echo $row_event['description']; ?></h4>
                                    <h4>Localiser en <?php echo $row_event['location']; ?></h4>
                                </div>
                                <p class="symbole">🏞️</p>

                            </a>


                        </div>
                        <p> DATE : <?php echo $row_event['date_event']; ?>

                        </p>
                    </figure>

                </div>

            <?php }} ?>


    </div>
</div>