<footer class="bg">
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-12 footerimg foot-left-section">
                <div class="foot-logo">
                    <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/">
                        <img
                            src="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/img/TOKEN_Transparent.webp" />
                    </a>
                </div>

            </div>
            <div class="col-sm-3 col-md-3 col-3 footer-lft foot-cnt-left">
                <ul>
                    <li><a href="https://www.asia.token2049.com/speakers" target="blank">Speakers</a></li>
                    <li><a href="https://www.asia.token2049.com/partners" target="blank">Sponsors</a></li>
                    <li><a href="https://www.asia.token2049.com/partners" target="blank">Media</a></li>
                    <li> <a href="https://www.asia.token2049.com" target="blank">Newsletter</a></li>
                    <li><a href="https://www.asia.token2049.com" target="blank">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-sm-3 col-md-3 col-3 footer-ryt foot-cnt-right">
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
            <div class="copyright"><p>© 2023 TOKEN2049. All Rights Reserved.</p></div>

        </div>
    </div>
</footer>


<script>



    <?php
    $cat = isset($_GET['cat']) ? $_GET['cat'] : "";

    $date_params = isset($_GET['date']) ? $_GET['date'] : "";
    $type_params = isset($_GET['type']) ? $_GET['type'] : "";





    ?>


    $('body').on('click', '.filterbtn', function () {
        var cat_params = "";
        var date_params = "";
        var type_params = "";

        if ($(this).hasClass('catbtn')) {
            //date string
            $('.datebtn').each(function () {

                if ($(this).hasClass('active')) {
                    date_params = $(this).attr('data-but_id');

                }


            })

            //value of typestring
            var typeStr = '';
            $('.typebtn').each(function () {
                var type = $(this).attr('data-but_id');

                if ($(this).hasClass('active')) {
                    typeStr += type + ',';
                }

            })
            typeStr = typeStr.substring(0, typeStr.length - 1);
            type_params = typeStr;



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


            if (attr == 'ALL' || catStr.length == 0) {
                cat_params = "none";
                $.ajax({
                    url: '<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/listajax?' + `date=${date_params}&type=${type_params}`,
                }).done(function (data) {
                    
                    // $('.category').empty();
                    // $('.category').append(cat_params);
                    $('.catbtn').each(function () {
                        if ($(this).attr('data-but_id') != 'ALL') {
                            $(this).removeClass('active')
                        } else {
                            $(this).addClass('active')
                        }
                    })

                    $(".alldata").empty();

                    $(".alldata").append(data);

              

                    

                }).fail(function () {
                    alert("failed to connect");
                })
            } else if (catStr) {
                cat_params = catStr;

                $.ajax({
                    url: '<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/listajax' + `?cat=${catStr}&date=${date_params}&type=${type_params}`,
                }).done(function (data) {
                    // $('.category').empty();
                    // $('.category').append(cat_params);

                    $('#ALL').removeClass('active');
                    $(".alldata").empty();
                    $(".alldata").append(data);

                }).fail(function () {
                    alert("failed to connect");
                })
            }


        } else if ($(this).hasClass('typebtn')) {
            //date string
            $('.datebtn').each(function () {

                if ($(this).hasClass('active')) {
                    date_params = $(this).attr('data-but_id');

                }


            })

            //cat string 
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
            cat_params = catStr;


            $(this).toggleClass("active");

            var typeStr = '';
            $('.typebtn').each(function () {
                var type = $(this).attr('data-but_id');

                if ($(this).hasClass('active')) {
                    typeStr += type + ',';
                }

            })
            typeStr = typeStr.substring(0, typeStr.length - 1);
            if (typeStr.length == 0) {
                type_params = "none";

            } else {
                type_params = typeStr;
            }
            $.ajax({
                url: "<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/listajax" + `?cat=${cat_params}&date=${date_params}&type=${typeStr}`,
            }).done(function (data) {
                // $('.type-para').empty();
                // $('.type-para').append(type_params);

                $(".alldata").empty();

                $(".alldata").append(data);

            }).fail(function () {
                alert("failed to connect");
            })

        } else if ($(this).hasClass('datebtn')) {
            var current_date = $(this).attr('data-but_id');
            if (current_date.length === 0) {
                date_params = "none";
            } else {
                date_params = current_date;

            }

            $('.datebtn').each(function () {

                if ($(this).attr('data-but_id') === current_date) {
                    $(this).addClass("active");

                } else {
                    $(this).removeClass("active");

                }

            })

            //cat string 
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
            cat_params = catStr;

            //type str
            var typeStr = '';
            $('.typebtn').each(function () {
                var type = $(this).attr('data-but_id');

                if ($(this).hasClass('active')) {
                    typeStr += type + ',';
                }

            })
            typeStr = typeStr.substring(0, typeStr.length - 1);
            type_params = typeStr;


            $.ajax({
                url: "<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/listajax?" + `date=${current_date}&cat=${cat_params}&type=${type_params}`,
            }).done(function (data) {
                // $('.date').empty();
                // $('.date').append(date_params);
                $(".alldata").empty();

                $(".alldata").append(data);

            }).fail(function () {
                alert("failed to connect");
            })


        }


    });


    $(window).scroll(function () {
        if ($(this).scrollTop() > 180) {
            $('.header').addClass('fixed-top')

        } else {
            $('.header').removeClass('fixed-top');
        }
    });






</script>



</body>

</html>