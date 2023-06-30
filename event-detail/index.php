<?php
$data = json_decode(file_get_contents('../data.json'));
// echo "<pre>";
// var_dump($_SERVER);
// echo "</pre>";

function namefromstr($str, $starting_index = null, $ending_index = null)
{
    if ($starting_index === null) {
        $starting_index = strpos($str, "[");
    }
    ;
    if ($ending_index === null) {
        $ending_index = strpos($str, "]");
    }
    ;
    return substr($str, $starting_index + 1, $ending_index - $starting_index - 1);
}

function urlfromstr($str, $starting_index = null, $ending_index = null)
{
    if ($starting_index === null) {
        $starting_index = strpos($str, "(");
    }

    if ($ending_index === null) {
        $ending_index = strpos($str, ")");
    }
    if ($starting_index == null && $ending_index == null) {

        return null;
    }
    return substr($str, $starting_index + 1, $ending_index - $starting_index - 1);
}
function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d')
{

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while ($current <= $last) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}
$segmentsArray = [];
$segmentsDatesArray = [];
foreach ($data->events as $key => $value) {
    if ($value->id === $_SERVER["QUERY_STRING"]) {
        $seagMEnt = $value->segments;

        foreach ($seagMEnt as $seg) {

            if (isset($seg->remote)) {
                foreach ($data->events as $skey => $svalue) {
                    if ($svalue->id == $seg->remote) {

                        foreach ($svalue->segments as $segM) {
                            $segMArray = json_decode(json_encode($segM), true);
                            $startDate = substr($segM->startTime, 0, 10);
                            $endDate = substr($segM->endTime, 0, 10);

                            $dateArr = date_range($startDate, $endDate);

                            foreach ($dateArr as $key => $dateArrVal) {
                                $segmentsDatesArray[$dateArrVal] = array();

                                $segMArray['date'] = $dateArrVal;
                                $segMArray['link'] = $svalue->id;
                                $segMArray['logo'] = $svalue->logo;
                                $segMArray['shortname'] = $svalue->shortname;
                                $segMArray['name'] = $svalue->name;
                                $segMArray['venues'] = $svalue->venues;
                                $segMArray['venueName'] = $svalue->venueName;
                                $segMArray['attendees'] = $svalue->attendees;


                                $segmentsArray[] = json_decode(json_encode($segMArray), false);
                            }
                        }
                    }
                }
            } else {
                if ($seg->hidden != true) {
                    $segmentsDatesArray[$seg->date] = array();

                    $seg->logo = $value->logo;
                    $seg->shortname = $value->shortname;
                    $seg->name = $value->name;
                    $seg->venues = $value->venues;
                    $seg->venueName = $value->venueName;
                    $seg->attendees = $value->attendees;

                    $segmentsArray[] = $seg;
                }
            }
        }
    }
}



foreach ($segmentsDatesArray as $segmentsDatesArraykey => $segmentsDatesArrayvalue) {
    foreach ($segmentsArray as $segmentsArraykey => $segmentsArrayvalue) {
        if ($segmentsDatesArraykey == $segmentsArrayvalue->date) {
            $segmentsDatesArray[$segmentsDatesArraykey][] = $segmentsArrayvalue;
        }
    }
}
// echo "<pre>";
// print_r($segmentsArray);
// print_r($segmentsDatesArray); 
// echo "</pre>";
?>


<?php require('../header.php') ?>

<?php foreach ($data->events as $key => $value) {

    if ($value->id === $_SERVER["QUERY_STRING"]) {
        ?>
        <div class="t-events t-events_in">

            <div class="container e-hack">
                <div class="row e-divs" id="events-div">

                    <div class="col-3 l-side" id="img-div">
                        <div class="img-div-inner"><img src="<?php echo $value->logo; ?>"></img></div>
                    </div>

                    <div class="col-7" id="name-div">
                        <h2 class="name">
                            <?php echo $value->name; ?>
                        </h2>
                        <div>
                            <ul>
                                <li>

                                    <?php
                                    //                                            echo "<pre>";
                                    // print_r($value);
                                    // echo "</pre>";
                                    foreach ($value->types as $key => $value1) {
                                        ?><span id="<?= $value1 ?>"> <?= $value1 . " " ?></span>
                                        <?php

                                    }

                                    ?>
                                </li>
                                <li class="date">
                                    <?php
                                    $date = $value->date;
                                    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    $withoutyear = substr($date, strpos($date, "-") + 1);
                                    $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    if ($value->days == 0 || $value->days == null || $value->days == 1) {
                                        $ending_date = null;
                                    } else {
                                        $ending_date = $starting_date + $value->days - 1;
                                    }

                                    //monthF
                                    $month = (int) strstr($withoutyear, "-", true) - 1;
                                    $year = (int) strstr($date, "-", true);
                                    echo ($ending_date == null) ? $months[$month] . " " . $starting_date . ', ' . $year : $months[$month] . " " . $starting_date . '-' . $ending_date . ', ' . $year;
                                    ?>
                                </li>
                                <li class="venues">📍
                                    <?php
                                    if (isset($value->venues)) {

                                        foreach ($value->venues as $key => $val) {
                                            ?>
                                            <a
                                                href=" <?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<?php echo $val ?> ">
                                                <?php
                                                echo ($key != 0) ? ', ' . $val : $val;
                                                ?>
                                            </a>
                                            <?php
                                        }
                                    } else {
                                        // foreach ($value->venueName as $key => $val) {
                                        //     echo ($key != 0) ? ', ' . $val : $val;
                                        // }
                                        echo $value->venueName;
                                    }


                                    ?>
                                </li>
                                <!-- <li class="attendence">👥
                                    <?php //echo $value->attendees; ?>
                                </li> -->
                            </ul>

                        </div>

                        <div>
                            <ul>
                                <?php
                               // if ($value->chains != null && $value->chains != []) {
                                    ?>
                                    <!-- <li class="chains">
                                        <div>chains:</div>
                                        <div><img src="https://data.prgblockweek.com/23/assets/chains/ethereum/logo.webp"
                                                class="chain-img" alt="Ethereum">
                                            <?php //echo $value->chains[0]; ?>
                                        </div>
                                    </li> -->
                                <?php //}
                                if ($value->tags != null && $value->tags != []) {
                                    ?>

                                    <li class="tags">
                                        <div>tags:</div>
                                        <div>
                                            <?php foreach ($value->tags as $key => $val) {
                                                echo ($key != 0) ? ' ' . '#' . $val : '#' . $val;
                                            }
                                            ; ?>
                                        </div>
                                    </li>
                                <?php } ?>

                                <li class="languages">
                                    <div>languages</div>
                                    <div>🇬🇧
                                        <?php foreach ($value->languages as $key => $val) {
                                            echo ($key != 0) ? ' ' . $val : $val;
                                        }
                                        ;
                                        ?>
                                    </div>
                                </li>

                                <?php
                                if ($value->org != null && $value->org != "") {
                                    ?>
                                    <li class="organizator">
                                        <div>ORGANIZATOR:</div>
                                        <div>

                                            <?php if (urlfromstr($value->org) === null) {
                                                echo $value->org;
                                            } else { ?>
                                                <a target="blank" href="<?php echo urlfromstr($value->org); ?>"><?php echo namefromstr($value->org); ?></a>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </li>
                                <?php }

                               // if ($value->poc != null && $value->poc != "") {
                                    ?>
                                    <!-- <li class="Poc">
                                        <div>Point Of Contact:</div>
                                        <?php// if (urlfromstr($value->poc) === null) {
                                           // echo $value->poc;
                                       // } else { ?>
                                            <div><a target="blank" href="<?php //echo urlfromstr($value->poc); ?>"><?php// echo namefromstr($value->poc); ?></a></div>
                                        <?php //} ?>


                                    </li> -->
                                <?php// } ?>


                            </ul>
                        </div>


                        <div>
                            <ul>
                                <?php
                                if ($value->links->web != null && $value->links->web != "") {
                                    ?>
                                    <li class="Poc">

                                        <?php $string_firstpos = strpos($value->links->web, "://") + 3;
                                        $string_ending_pos = strpos($value->links->web, ".");
                                        ?>
                                        <span>Web:</span>
                                        <span><a target="blank" href="<?php echo $value->links->web; ?>">
                                                <?php
                                                echo substr($value->links->web, $string_firstpos, $string_ending_pos - $string_firstpos)
                                                    ?></a></span>
                                    </li>
                                <?php }
                                if ($value->links->twitter != null && $value->links->twitter != "") {
                                    ?>
                                    <?php $string_firstpos = strpos($value->links->twitter, ".com/") + 5; ?>
                                    <li class="Poc">
                                        <span>Twitter:</span>
                                        <span><a target="blank" href="<?php echo $value->links->twitter; ?>">
                                                <?php
                                                echo substr($value->links->twitter, $string_firstpos)
                                                    ?></a><span>
                                    </li>
                                <?php }
                                if ($value->links->telegram != null && $value->links->telegram != "") {
                                    ?>

                                    <li class="Poc">
                                        <?php $string_firstpos = strpos($value->links->telegram, ".me/") + 4; ?>
                                    <li class="Poc">
                                        <span>Telegram:</span>
                                        <span><a target="blank" href="<?php echo $value->links->telegram; ?>">
                                                <?php
                                                echo substr($value->links->telegram, $string_firstpos) ?></a></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div>
                            <ul>
                                <?php
                                if ($value->links->discord != null && $value->links->discord != "") {
                                    ?>
                                    <li class="Poc">
                                        <?php $string_firstpos = strpos($value->links->discord, "://") + 3;
                                        ?>
                                        <span>discord:</span>
                                        <span>
                                            <a target="blank" href="<?php echo $value->links->discord; ?>">
                                                <?php echo substr($value->links->discord, $string_firstpos) ?>
                                            </a>
                                        </span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>


                    <div class="col-2" id="button-div">
                        <?php if ($value->registration->type === "tickets") { ?>
                            <a target="blank" href="<?php echo $value->registration->link; ?>">
                            <button>
                                <?php
                                if (isset($value->registration->button) && !empty($value->registration->button)) {
                                   echo $value->registration->button; 
                                   
                                } else {
                                    ?>
                                  Buy Tickets
                                    <?php

                                }
                                ?>
                            </button>

                            </a>
                            <ul>
                                <li class="status">status:
                                    <span>
                                        <?php echo $value->registration->status; ?>
                                    </span>
                                </li>

                                <li class="price">price:<span>
                                        <?php echo $value->registration->price ?>
                                    </span></li>
                            </ul>

                        <?php } else if ($value->registration->type === "signup") { ?>

                                <a target="blank" href="<?php echo $value->registration->link; ?>">
                                    <button>
                                    <?php echo $value->registration->button; ?>
                                    </button>
                                </a>
                                <ul>
                                    <li class="status">status:<span>
                                        <?php echo $value->registration->status; ?>
                                        </span></li>
                                    <li class="price">price:<span>Free!</span></li>

                                </ul>


                            <?php } else if ($value->registration->type === "invites") { ?>
                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                        <button>
                                        <?php echo $value->registration->button; ?>
                                        </button>
                                    </a>
                                    <ul>
                                        <li class="status">status:<span>
                                            <?php echo $value->registration->status; ?>
                                            </span></li>
                                        <li class="price">price:<span>Free!</span></li>

                                    </ul>
                                <?php } ?>
                    </div>

                    <!-- <div class="col-sm-6 col-md-4 col-6">
                </div> -->

                </div>

                <div class="evnt-content">
                    <p>
                        <?php
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
                        function url_strpos_all($string, $start, $end)
                        {
                            $offset = 0;
                            $allpos = array();
                            while (($pos = strpos($string, $start, $offset)) !== FALSE) {

                                $endpos = strpos($string, $end, $pos + 1);



                                $offset = $pos + 1;
                                $allpos[] = ['start' => $pos, 'end' => $endpos];
                            }
                            ;
                            return $allpos;
                        }
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
                        // $second_main_str = $main_replacestr;
                        // $https_index = url_strpos_all($main_replacestr, "https"," ");
                        // print_r($https_starting_index);
                
                        // foreach ($https_index as $curr_bothpos) {
                        //     $data_to_replace = substr($main_replacestr,$curr_bothpos['start'],$curr_bothpos['end']);
                        //     $data_to_inserted = "<a href='".$data_to_replace."' href = '" . $url . "' >" . $data_to_replace . "</a>";
                        //     $main_replacestr = str_replace($data_to_replace, $data_to_inserted, $main_replacestr);
                
                        // }
                        echo $main_replacestr;

                        ?>
                    </p>
                    <?php
                    if ($value->segments != "" || $value->segments != null) {

                        ?>
                        <h2>Schedule</h2>
                        <?php
                        $all_dates = [];
                        foreach ($segmentsDatesArray as $dates) {
                            // echo "<pre>";
                            // print_r($dates);
                            // echo "</pre>";
                            foreach ($dates as $segment_key => $segment_value) {

                                // echo "<pre>";
                                // print_r($segment_value);
                                // echo "</pre>";
            
                                ?>
                                <!-- date -->
                                <h3>
                                    <?php
                                    if (array_search($segment_value->date, $all_dates) > 0 || array_search($segment_value->date, $all_dates) === 0) {
                                    } else {

                                        array_push($all_dates, $segment_value->date);
                                        $date = $segment_value->date;

                                        $timestamp = strtotime($segment_value->date);
                                        //echo $timestamp;
                                        $day = date('l', $timestamp);
                                        echo $day . "-";
                                        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                        $withoutyear = substr($date, strpos($date, "-") + 1);
                                        $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                        // if ($value->days == 0 || $value->days == null || $value->days == 1) {
                                        //     $ending_date = null;
                                        // } else {
                                        //     $ending_date = $starting_date + $value->days - 1;
                                        // }
                
                                        //month
                                        $month = (int) strstr($withoutyear, "-", true) - 1;
                                        $year = (int) strstr($date, "-", true);

                                        //echo ($ending_date == null) ? $months[$month] . " " . $starting_date . ', ' . $year : $months[$month] . " " . $starting_date . '-' . $ending_date . ', ' . $year;
                
                                        // echo ($ending_date == null) ? $months[$month] . " " . $starting_date . ', ' . $year : $months[$month] . " " . $starting_date . ', ' . $year;
                                        echo $months[$month] . " " . $starting_date . ', ' . $year;
                                    }



                                    ?>
                                </h3>
                                <h4>
                                    <!-- time -->
                                    <span>
                                        <?php
                                        echo $segment_value->times;

                                        ?>
                                    </span>
                                    <img src="<?php echo $segment_value->logo ?>" />
                                    <!-- //name -->
                                    <span>

                                        <?php
                                        if (isset($segment_value->link)) { ?>
                                            <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php echo $segment_value->link; ?>"
                                                class="a-style">

                                                <?php
                                                echo ($segment_value->shortname != '') ? (($segment_value->title != '') ? $segment_value->shortname . '-' . $segment_value->title : $segment_value->shortname) : $segment_value->name;

                                                ?></a><?php
                                        } else {
                                            echo ($segment_value->shortname != '') ? (($segment_value->title != '') ? $segment_value->shortname . '-' . $segment_value->title : $segment_value->shortname) : $segment_value->name;
                                        }
                                        ?>
                                    </span>
                                    <!-- location -->
                                    <span>

                                        📍
                                        <?php
                                        if (!empty($segment_value->venues)) {
                                            foreach ($value->venues as $key => $val) {
                                                ?>
                                                <a
                                                    href=" <?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<?php echo $val ?> ">
                                                    <?php
                                                    echo ($key != 0) ? ', ' . $val : $val;
                                                    ?>
                                                </a>
                                                <?php
                                            }
                                        } else {
                                            // foreach ($segment_value->'venueName as $key => $val) {
                                            //     echo ($key != 0) ? ', ' . $val : $val;
                                            // }
                                            echo $segment_value->venueName;
                                        }
                                        ;
                                        ?>
                                    </span>
                                    <!-- attendees -->
                                    <span>

                                        👥

                                        <?php
                                        //echo empty($segment_value->ecap']);
                                        if (!empty($segment_value->ecap)) {
                                            echo $segment_value->ecap;
                                        } else {
                                            echo $segment_value->attendees;
                                        }
                                        ?>
                                    </span>
                                </h4>
                            <?php }
                        } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php
    }
}
?>
<?php require('../footer.php') ?>