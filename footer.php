<footer class="bg">
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-12">
                <div>
                    <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/">
                        <img
                            src="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/TOKEN_Transparent-1.webp" />
                    </a>
                </div>

            </div>
            <div class="col-sm-3 col-md-3 col-3">
                <ul>
                    <li><a href="https://www.asia.token2049.com/speakers" target="blank">Speakers</a></li>
                    <li><a href="https://www.asia.token2049.com/partners" target="blank">Sponsors</a></li>
                    <li><a href="https://www.asia.token2049.com/partners" target="blank">Media</a></li>
                    <li> <a href="https://www.asia.token2049.com" target="blank">Newsletter</a></li>
                    <li><a href="https://www.asia.token2049.com" target="blank">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-md-3 col-3">
                <ul>
                    <li><a href="http://www.token2049.com/" target="blank">TOKEN2049 Global</a></li>
                    <li><a href="http://www.asia.token2049.com" target="blank">TOKEN2049 Singapore</a></li>
                    <li><a href="https://www.asiacryptoweek.com" target="_blank">Asia Crypto Week</a>
                    <li>

                    <li><a href="https://www.asia.token2049.com/terms-conditions" target="_blank">Terms & Conditions</a>
                    <li>
                    <li><a href="https://www.asia.token2049.com/privacy-policy" target="_blank">Privacy Policy</a>
                    <li>
                </ul>
            </div>
            <div class="social_icn">
                <h4>stay connected</h4>
                <ul>
                    <li><a href="https://twitter.com/token2049" target="blank"><img alt="Twitter"
                                src="https://static.wixstatic.com/media/c7d035ba85f6486680c2facedecdcf4d.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/c7d035ba85f6486680c2facedecdcf4d.png"></a>
                    </li>
                    <li><a href="https://www.linkedin.com/company/token2049/" target="blank"><img alt="LinkedIn"
                                src="https://static.wixstatic.com/media/6ea5b4a88f0b4f91945b40499aa0af00.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/6ea5b4a88f0b4f91945b40499aa0af00.png"></a>
                    </li>
                    <li><a href="https://t.me/token2049official" target="blank"><img alt="Telegram"
                                src="https://static.wixstatic.com/media/d5a6c7_fa663c5fff9d4d5b821ba5bd04b699e2~mv2.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/d5a6c7_fa663c5fff9d4d5b821ba5bd04b699e2~mv2.png"></a>
                    </li>
                    <li><a href="https://www.youtube.com/c/TOKEN2049" target="blank"><img alt="YouTube"
                                src="https://static.wixstatic.com/media/78aa2057f0cb42fbbaffcbc36280a64a.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/78aa2057f0cb42fbbaffcbc36280a64a.png"></a>
                    </li>
                    <li><a href="https://www.flickr.com/photos/token2049/" target="blank"><img
                                src="https://static.wixstatic.com/media/9257da_523429f2f8774fa492191a821dce2344~mv2.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/flickr%20logo.png"
                                alt="flickr logo.png"></a></li>
                </ul>

            </div>
            <p>© 2023 TOKEN2049. All Rights Reserved.</p>

        </div>
    </div>
</footer>


<script>

    <?php
    $cat = isset($_GET['cat']) ? $_GET['cat'] : "";
    $date_params = isset($_GET['date']) ? $_GET['date'] : "";
    $type_params = isset($_GET['type']) ? $_GET['type'] : "";


    $cat_arr = explode(",", $cat);

    ?>

    <?php
    if (empty($cat) && empty($type_params) && empty($date_params)) {
        ?>
        var events = null;
        var other_eventLength = 0;
        var confernce_eventlength = 0;
        var othersCount = document.getElementById("others-count");
        var confernceCount = document.getElementById("confernce-count");


        fetch("https://data.prgblockweek.com/23/index.json").then(res => res.json()).then(res => {
            events = res.events;
            if (events != null) {
                for (let i = 0; i < events.length; i++) {

                    if (events[i].hidden != true) {
                        event_type = events[i].types;
                        for (let z = 0; z < event_type.length; z++) {

                            if (event_type[z] == "party" || event_type[z] == "meetup" || event_type[z] == "workshop") {
                                other_eventLength += 1;
                                break;

                            } else if (event_type[z] == "conference" || event_type[z] == "hackathon") {
                                confernce_eventlength += 1;
                                break;

                            }

                        }
                    }




                }
            }
            othersCount.append(`(${other_eventLength})`);
            confernceCount.append(`(${confernce_eventlength})`);

        })
        <?php
    }
    ?>

    $('body').on('click', '.catbtn', function () {

        $(this).toggleClass("active");

        var catStr = '';
        $('.catbtn').each(function () {
            var cat = $(this).attr('data-but_id');
            if (cat === 'ALL') {

            } else {
                if ($(this).hasClass('active')) {
                    catStr += cat + ',';
                }
            }


        })
        catStr = catStr.substring(0, catStr.length - 1);

        var attr = $(this).attr('data-but_id');



        setTimeout(function () {
            if (attr == 'ALL' || catStr.length == 0) {
                    window.location.href = "<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/?<?php
                    echo 'date='.$date_params.'&type='.$type_params;?>";
                 

            } else if (catStr) {
                window.location.href = "<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/" + `?cat=${catStr}&date=<?= $date_params.'&type='.$type_params ?>`;

                // 
                // } else if (params.length != 0) {
                //     window.location.href += ',' + catStr;params == null || params.length == 0)

                // }
            }
        }, 200);

    });


   






    $('body').on('click', '.type', function () {

$(this).toggleClass("active");

var typeStr = '';
$('.type').each(function () {
    var type = $(this).attr('data-but_id');
    
        if ($(this).hasClass('active')) {
            typeStr += type + ',';
        }
    


})
typeStr = typeStr.substring(0, typeStr.length - 1);
console.log(typeStr);

setTimeout(function () {
   
        window.location.href = "<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/" + `?cat=<?= $cat ?>&date=<?= $date_params ?>`+ `&type=${typeStr}`;

        
    
}, 200);

});




$(window).scroll(function(){
    if ($(this).scrollTop() > 180) {
       $('.header').addClass('fixed-top') 

    } else {
       $('.header').removeClass('fixed-top');
    }
});

</script>



</body>

</html>