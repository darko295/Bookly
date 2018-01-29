<html>

<head>
</head>
<body>

<div class="mdl-card something-else mdl-cell mdl-cell--8-col mdl-cell--4-col-desktop">

    <div class="mdl-card__media mdl-color--white mdl-color-text--grey-600">
        <div style="font-family:Xiomara-Script; font-size: 30px; padding-bottom: 25px">Bookly</div>
        <img src="images/logo.png">
        <?php
        $review = new review();
        $result = $review->getStats();
        $row = $result->fetch_object();
        ?>

    </div>
        <div class="mdl-card__supporting-text meta meta--fill mdl-color-text--grey-600">
        <div>
            <b>Hvala vam!</b> <i style="font-size:10px">Bookly team.</i>
        </div>

    </div>
</div>


</body>
</html>