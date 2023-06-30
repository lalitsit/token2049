<?php
$data = json_decode(file_get_contents('../data.json'));
require('../header.php');

//show data
foreach ($data->places as $key => $value) {
    // print($value->description);
    if ($value->id === $_SERVER["QUERY_STRING"]) {

        ?>
        <div class="t-events t-events_in">

            <div class="container e-hack">
                <div class="row e-divs" id="events-div">

                    <div class="col-3 l-side" id="img-div">
                        <div class="img-div-inner"><img src="<?php echo $value->photo; ?>"></img></div>
                    </div>

                    <div class="col-7" id="name-div">
                        <h2 class="name">
                            <?php echo $value->name; ?>
                        </h2>


                        <div>
                            <ul>

                                <li class="languages">
                                    <div>Address</div>
                                    <div>
                                        <a href="<?php echo $value->mapUrl?>">
                                            <?php echo $value->address;

                                            ?>
                                        </a>
                                    </div>
                                </li>

                                <li class="organizator">
                                    <div>Capacity:</div>
                                    <div>
                                        <?php echo $value->capacity . " ppl" ?>
                                    </div>
                                </li>

                                <li class="organizator">
                                    <div>Event types:</div>
                                    <div>
                                        <?php
                                        foreach ($value->eventTypes as $event) {
                                            ?><span id = "<?= $event ?>"> <?= $event . " "?></span>
                                            <?php
                                            
                                        }
                                        ?>
                                    </div>
                                </li>


                            </ul>
                        </div>


                        <div>
                            <ul>
                                <?php
                                if ($value->links->web != null && $value->links->web != "") {
                                    ?>
                                    <li class="Poc">

                                        <?php $string_firstpos = strpos($value->links->web, "www.") + 4;
                                        // $string_ending_pos = strpos($value->links->web, ".");
                                        ?>
                                        <span>Web:</span>
                                        <span><a target="blank" href="<?php echo $value->links->web; ?>"><?php
                                           echo substr($value->links->web, $string_firstpos, strlen($value->links->web));
                                               ?></a></span>
                                    </li>
                                <?php } ?>


                            </ul>
                        </div>

                    </div>



                </div>

                <div class="evnt-content">
                    <p>

                        <?php

                        // echo $value->description;
                        $modifyfirststr = str_replace("---", "<hr>", str_replace("\n", "<br>", $value->description));
                        function strpos_all($string, $keywords_to_search)
                        {
                            $offset = 0;
                            $allpos = array();
                            while (($pos = strpos($string, $keywords_to_search, $offset)) !== FALSE) {
                                $offset = $pos + 1;
                                $allpos[] = $pos;
                            }
                            ;
                            return $allpos;
                        }
                        ;
                        $name_starting_index = strpos_all($modifyfirststr, "[");
                        $name_ending_index = strpos_all($modifyfirststr, "]");
                        $url_starting_index = strpos_all($modifyfirststr, "(");
                        $url_ending_index = strpos_all($modifyfirststr, ")");
                        $main_replacestr = $modifyfirststr;

                        for ($i = 0; $i < count($name_ending_index); $i++) {
                            $name = namefromstr($modifyfirststr, $name_starting_index[$i], $name_ending_index[$i]);
                            $url = urlfromstr($modifyfirststr, $url_starting_index[$i], $url_ending_index[$i]);

                            $data_to_inserted = "<a target='blank' href = '" . $url . "' >" . $name . "</a>";

                            $data_to_replace = substr($modifyfirststr, $name_starting_index[$i], $url_ending_index[$i] - $name_starting_index[$i] + 1);


                            $main_replacestr = str_replace($data_to_replace, $data_to_inserted, $main_replacestr);

                        }
                        echo $main_replacestr;

                        ?>
                    </p>


                </div>
            </div>
        </div>

        <?php
    }
}
require('../footer.php') ?>