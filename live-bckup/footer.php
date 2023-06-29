<footer class="bg">
        <div class="container-lg">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-12">
                    <div>
                        <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/">
                            <img
                                src="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/TOKEN_Transparent-1.webp" />
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
                        <li><a href="https://www.asiacryptoweek.com" target="_blank" >Asia Crypto Week</a><li>

                        <li><a href="https://www.asia.token2049.com/terms-conditions" target="_blank" >Terms & Conditions</a><li>
                        <li><a href="https://www.asia.token2049.com/privacy-policy" target="_blank" >Privacy Policy</a><li>
                    </ul>
                </div>
                <div class="social_icn">
                    <h4>stay connected</h4>
                    <ul>
                        <li><a href="https://twitter.com/token2049" target="blank"><img alt="Twitter"
                                    src="https://static.wixstatic.com/media/c7d035ba85f6486680c2facedecdcf4d.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/c7d035ba85f6486680c2facedecdcf4d.png"></a>
                        </li>
                        <li><a href="https://www.linkedin.com/company/" target="blank"><img alt="LinkedIn"
                                    src="https://static.wixstatic.com/media/6ea5b4a88f0b4f91945b40499aa0af00.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/6ea5b4a88f0b4f91945b40499aa0af00.png"></a>
                        </li>
                        <li><a href="https://t.me/token2049official" target="blank"><img alt="Telegram"
                                    src="https://static.wixstatic.com/media/d5a6c7_fa663c5fff9d4d5b821ba5bd04b699e2~mv2.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/d5a6c7_fa663c5fff9d4d5b821ba5bd04b699e2~mv2.png"></a>
                        </li>
                        <li><a href="https://www.youtube.com/c/TOKEN2049" target="blank"><img alt="YouTube"
                                    src="https://static.wixstatic.com/media/78aa2057f0cb42fbbaffcbc36280a64a.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/78aa2057f0cb42fbbaffcbc36280a64a.png"></a>
                        </li>
                        <li><a href="https://www.flickr.com/photos/" target="blank"><img
                                    src="https://static.wixstatic.com/media/9257da_523429f2f8774fa492191a821dce2344~mv2.png/v1/fill/w_28,h_28,al_c,q_95,enc_auto/flickr%20logo.png"
                                    alt="flickr logo.png"></a></li>
                    </ul>

                </div>
                <p>© 2023 TOKEN2049. All Rights Reserved.</p>

            </div>
        </div>
    </footer>

    <script>
        var events = null;
        var other_eventLength = 0;
        var confernce_eventlength = 0;
        var othersCount = document.getElementById("others-count");
        var confernceCount = document.getElementById("confernce-count");


        fetch("https://data.prgblockweek.com/23/index.json").then(res => res.json()).then(res => {
            events = res.events;
            if (events != null ) {
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
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>

</html>