<?php
$data = json_decode(file_get_contents('../data.json'));

//sort array events 
$dataArray = json_decode(json_encode($data), true);
foreach ($dataArray['events'] as $key => $part) {
    $sort[$key] = $part['attendees'];
}
array_multisort($sort, SORT_DESC, $dataArray['events']);

$data = json_decode(json_encode($dataArray), false);


// print_r($data);
$cat = isset($_GET['cat']) ? $_GET['cat'] : "";
$cat_arr = explode(",", $cat);

$cat_params = isset($_GET['cat']) ? $_GET['cat'] : "";
$cat_params_arr = explode(",", $cat_params);


$date_params = isset($_GET['date']) ? $_GET['date'] : "";
$date_params_arr = explode(",", $date_params);

$type_params = isset($_GET['type']) ? $_GET['type'] : "";
$type_params_arr = explode(",", $type_params);


// $categoryGet = isset($_GET['c']) ? $_GET['c'] : "";
// $typeGet = isset($_GET['t']) ? $_GET['t'] : "";

// $displayNone = isset($_GET['c']) ? "display:none" : "";
// $filterNone = isset($_GET['c']) ? "" : "display:none";


// $all_event_acc_to_date = [];
// foreach ($data->events as $eventa) {
//     if ($eventa->hidden != true) {


//         $name = $eventa->name;

//         $shortname = $eventa->shortname;

//         // $start_date = $eventa->date;
//         // $end_date = date("Y-m-d", strtotime("+" . $eventa->days - 1 . " day", strtotime($start_date)));
//         // $all_events_dates = date_range($start_date, $end_date);
//         //     echo $start_date;
//         // echo $end_date;
//         // echo "<br/>";
//         //     echo $name;
//         //     print_r($all_events_dates);
//         $logo = $eventa->logo;
//         $types = $eventa->types;
//         $attendees = $eventa->attendees;
//         $venues = $eventa->venues;
//         $venueName = $eventa->venueName;
//         foreach ($eventa->segments as $seg) {
//             if (!isset($seg->remote) || empty($seg->remote)) {
//                 $eventa->times = $seg->times;
//                 $date = $seg->date;
//                 $title = $seg->title;
//                 $eventa->speakers = "";
//                 $json = json_encode($eventa);
//                 $copy = json_decode($json,false);
//                 $all_event_acc_to_date[$date][] = $copy;
//             }
//         }
//     }
// }
//filtering
// $dataFilter = [];



// echo "<pre>";
// if (!empty($cat) && empty($date_params)) {
//     foreach ($data->events as $key => $value) {
//         if ($value->hidden != true) {
//             foreach ($value->types as $event_cat) {
//                 if (in_array("Free", $cat_arr) && in_array("Paid", $cat_arr)) {
//                     //free and paid showing all events acc to rest of the filter  except of payment filter 
//                     if (in_array($event_cat, $cat_arr)) {
//                         array_push($dataFilter, $value);
//                         break;
//                     }

//                 } else if (in_array("Free", $cat_arr)) {
//                     //free filter case
//                     if (in_array($event_cat, $cat_arr)) {
//                         //event cat exist in query
//                         if ($value->registration->type != "tickets") {
//                             //is event free
//                             array_push($dataFilter, $value);
//                             break;
//                         }

//                     }

//                 } else if (in_array("Paid", $cat_arr)) {
//                     //paid  filter case
//                     if (in_array($event_cat, $cat_arr)) {
//                         //event cat exist in query
//                         if ($value->registration->type == "tickets") {
//                             //is event paid
//                             array_push($dataFilter, $value);
//                             break;
//                         }

//                     }
//                 } else {
//                     if (in_array($event_cat, $cat_arr)) {
//                         array_push($dataFilter, $value);
//                         break;
//                     }

//                 }
//             }
//         }
//     }
// } else if (!empty($cat) && !empty($date_params)) {
//     //if both values rae provided 
//     foreach ($all_event_acc_to_date as $dates => $events_in_that_date) {
//         //all events in that day
//         if ($dates === $date_params) {

//             foreach ($events_in_that_date as $key => $curr_event) {
//                 // print_r($curr_event);
//                 //current event
//                 foreach ($cat_arr as $key => $curr_cat) {
//                     //check each category with event category
//                     if (in_array($curr_cat, $curr_event->types)) {

//                         //if category exist  then push and dont check remianing catgeoryies
//                         array_push($dataFilter, $curr_event);
//                         break;
//                     }
//                 }

//             }
//             // print_r($events_in_that_date);
//         }
//     }

// } else if (empty($cat) && !empty($date_params)) {
//     foreach ($all_event_acc_to_date as $dates => $events_in_that_date) {
//         //all events in that day
//         if ($dates === $date_params) {

//             foreach ($events_in_that_date as $key => $curr_event) {
//                 // print_r($curr_event);
//                 //current event



//                         //push current event which is present in that date 
//                         array_push($dataFilter, $curr_event);


//             }
//         }
//     }

// }

// if ($cat = "" && $typeGet != "") {
//     foreach ($data->events as $key => $value) {
//         if ($value->hidden != true) {
//             if ($typeGet == "Free") {
//                 $cond = $value->registration->type !== "tickets";
//             } else {
//                 $cond = $value->registration->type === "tickets";
//             }
//             if (in_array($categoryGet, $value->types) && ($cond)) {
//                 array_push($dataFilter, $value);
//             }
//         }
//     }
// } else if ($categoryGet != "" && $typeGet == "") {
//     foreach ($data->events as $key => $value) {
//         if ($value->hidden != true) {
//             if (in_array($categoryGet, $value->types)) {
//                 array_push($dataFilter, $value);
//             }
//         }
//     }
// } else if ($categoryGet == "" && $typeGet != "") {
//     foreach ($data->events as $key => $value) {
//         if ($typeGet == "Free") {
//             $cond = $value->registration->type !== "tickets";
//         } else {
//             $cond = $value->registration->type === "tickets";
//         }
//         if ($value->hidden != true) {
//             if ($cond) {
//                 array_push($dataFilter, $value);
//             }
//         }
//     }
// } else {

// }



//filtering data
$dataFilter = [];

foreach ($data->events as $key => $cur_event) {
    $date = false;
    $cat = false;
    $type = false;

    if ($cur_event->hidden != true) {

        //type stasify ore not
        $type = true;
        if (!empty($type_params)) {
            $type = false;
            if (in_array('Paid', $type_params_arr) && in_array('Free', $type_params_arr)) {
                $type = true;

            } else if (in_array('Paid', $type_params_arr)) {
                if ($cur_event->registration->type == "tickets") {
                    $type = true;
                }

            } else if (in_array('Free', $type_params_arr)) {
                if ($cur_event->registration->type != "tickets") {
                    $type = true;
                }
            }


        }


        //cat staisfy or not
        $cat = true;
        if (!empty($cat_params)) {
            $cat = false;
            foreach ($cat_params_arr as $key => $catfromurl) {
                if (in_array($catfromurl, $cur_event->types)) {
                    $cat = true;
                    break;
                }
            }

        }


        //date stasify or not
        $date = true;
        if (!empty($date_params)) {
            $date = false;
            $no_of_days = 0;
            $times_arr = [];
            foreach ($cur_event->segments as $key => $seg) {
                if ($seg->date === $date_params) {

                    $no_of_days += 1;


                    array_push($times_arr, $seg->times);
                    $date = true;
                }
            }
        }


        // print_r($times_arr);


        if ($no_of_days > 1) {
            foreach ($times_arr as $key => $time_needtouse) {
                $cur_event->times = $time_needtouse;
                if ($type && $cat && $date) {
                    $cur_event->speakers=[];
                    $json = json_encode($cur_event);
                    $copy = json_decode($json, false);
                    array_push($dataFilter, $copy);

                }
            }
        } else {
            if ($type && $cat && $date) {
                $cur_event->speakers=[];

                array_push($dataFilter, $cur_event);

            }
        }

    }
}



$all_categroies = [];

foreach ($dataFilter as $key => $event) {
    foreach ($event->types as $key => $value) {
        if (!in_array($value, $all_categroies)) {
            array_push($all_categroies, $value);
        }
    }

}



$events_acc_to_type = [];


foreach ($all_categroies as $key => $all_categroies_of_events) {
    if (in_array($all_categroies_of_events, $cat_params_arr)) {
        $events_acc_to_type[$all_categroies_of_events] = [];
        foreach ($dataFilter as $key => $events) {
            if (in_array($all_categroies_of_events, $events->types)) {
                $events->speakers = [];
                $events_acc_to_type[$all_categroies_of_events][] = $events;
            }
        }


    }
}

// echo "<pre>";
// print_r($dataFilter);
// echo "</pre>";


?>



<?php



if (!empty($_GET['date']) && empty($_GET['cat'])) {
    ?>

    <h2 class=" mt-4" id="confernce-count">Conferences & Hackathons </h2>
    <div class="e-divs" id="events-div">
        <?php
        $count1 = 0;
        foreach ($dataFilter as $key => $value) {

            // echo "<pre>";
            // print_r($value);
            // echo "<pre>";
            if ($value->hidden != true) {

                foreach ($value->types as $typekey => $typevalue) {

                    if ($typevalue == "conference" || $typevalue == "hackathon") {
                        $count1 += 1;

                        ?>

                        <div class="col-sm-6 col-6 card-style col-md-2">
                            <!-- <a href="<?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php // echo $value->id; ?>"
                                        class="a-style"> -->
                            <div class="evnt-img">
                                <img class="img" src="<?php echo $value->logo ?>">
                            </div>
                            <h3>
                                <?php
                                if ($value->shortname == "" || $value->shortname == null) {
                                    echo $value->name;
                                } else {
                                    echo $value->shortname;
                                }
                                ; ?>
                            </h3>
                            <!-- </a> -->
                            <h4>
                                <?php
                                //old code
            
                                if (isset($value->times) || !empty($value->times)) {
                                    echo $value->times;
                                } else {
                                    foreach ($value->segments as $seg) {
                                        if (isset($seg->times) || !empty($seg->times)) {
                                            echo $seg->times;
                                            break;
                                        }



                                    }
                                }



                                ?>
                            </h4>
                            <h4>
                                <?php if ($value->registration->type === "tickets") { ?>
                                    <span>
                                        <?= $value->registration->price ?>
                                    </span>
                                <?php } else if ($value->registration->type === "signup") { ?>
                                        <span>Free!</span>
                                    <?php } else if ($value->registration->type === "invites") { ?>
                                            <span>Free!</span>
                                        <?php } ?>
                            </h4>
                            <!-- <h4>
                                        <?php //echo $value->attendees ?>
                                    </h4> -->

                            <!-- <a href="https://gmevents.typeform.com/to/jy3Mufeq" class="btn btn-sm btn-primary"
                                            target="__blank">Register Here</a> -->
                            <?php if ($value->registration->type === "tickets") { ?>
                                <a target="blank" href="<?php echo $value->registration->link; ?>">
                                    <button>
                                        <?php
                                        if (isset($value->registration->button) && !empty($value->registration->button)) {
                                            // echo $value->registration->button;
                                            ?>Register
                                            <?php

                                        } else {
                                            ?>
                                            Register
                                            <?php

                                        }
                                        ?>
                                    </button>

                                </a>


                            <?php } else if ($value->registration->type === "signup") { ?>

                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                        <button>
                                        <?php //echo $value->registration->button; ?>
                                            Register
                                        </button>
                                    </a>



                                <?php } else if ($value->registration->type === "invites") { ?>
                                        <a target="blank" href="<?php echo $value->registration->link; ?>">
                                            <button>
                                            <?php // echo $value->registration->button; ?>
                                                Register
                                            </button>
                                        </a>

                                    <?php } ?>

                        </div>

                        <?php
                    }
                    break;
                }
            }
        } ?>
        <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk">
            <a href="https://tally.so/r/n07G0P" class="a-style" target="__blank">
                <div class="text-6xl">+</div>
                <div class="text-6xl">Host your own
                    event!</div>
            </a>


        </div>
    </div>

    <h2 class="mt-4" id="others-count">Meetups, Parties And Other Events </h2>
    <div class="e-divs" id="events-div">

        <?php
        $count2 = 0;
        foreach ($dataFilter as $key => $value) {
            if ($value->hidden != true) {
                foreach ($value->types as $typekey1 => $typevalue1) {

                    if ($typevalue1 == "party" || $typevalue1 == "meetup" || $typevalue1 == "workshop") {
                        $count2 += 1;
                        ?>
                        <div class="col-sm-6 col-6 card-style col-md-2">
                            <!-- <a href="<?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php //echo $value->id; ?>"
                                        class="a-style"> -->
                            <div class="evnt-img">
                                <img class="img" src="<?php echo $value->logo ?>">
                            </div>
                            <h3>
                                <?php
                                if ($value->shortname == "" || $value->shortname == null) {
                                    echo $value->name;
                                } else {
                                    echo $value->shortname;
                                }
                                ; ?>
                            </h3>
                            <!-- </a> -->
                            <h4>
                                <?php
                                if (isset($value->times) || !empty($value->times)) {
                                    echo $value->times;
                                } else {
                                    foreach ($value->segments as $seg) {
                                        if (isset($seg->times) || !empty($seg->times)) {
                                            echo $seg->times;
                                            break;
                                        }



                                    }
                                }
                                ?>
                            </h4>
                            <h4>
                                <?php if ($value->registration->type === "tickets") { ?>
                                    <span>
                                        <?= $value->registration->price ?>
                                    </span>
                                <?php } else if ($value->registration->type === "signup") { ?>
                                        <span>Free!</span>
                                    <?php } else if ($value->registration->type === "invites") { ?>
                                            <span>Free!</span>
                                        <?php } ?>
                            </h4>

                            <?php if ($value->registration->type === "tickets") { ?>
                                <a target="blank" href="<?php echo $value->registration->link; ?>">
                                    <button>
                                        <?php
                                        if (isset($value->registration->button) && !empty($value->registration->button)) {
                                            // echo $value->registration->button;
                                            ?>Register
                                            <?php

                                        } else {
                                            ?>
                                            Register
                                            <?php

                                        }
                                        ?>
                                    </button>

                                </a>


                            <?php } else if ($value->registration->type === "signup") { ?>

                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                        <button>
                                            Register
                                        <?php //echo $value->registration->button; ?>
                                        </button>
                                    </a>



                                <?php } else if ($value->registration->type === "invites") { ?>
                                        <a target="blank" href="<?php echo $value->registration->link; ?>">
                                            <button>
                                                Register
                                            <?php //echo $value->registration->button; ?>
                                            </button>
                                        </a>

                                    <?php } ?>

                        </div>
                    <?php }
                    break;
                }
            }
        } ?>
        <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk">
            <a href="https://tally.so/r/n07G0P" class="a-style" target="__blank">
                <div class="text-6xl">+</div>
                <div class="text-6xl">Host your own
                    event!</div>
            </a>


        </div>
    </div>


    <script>
        $('#confernce-count').append('( ' + <?= $count1 ?> + ')');
        $('#others-count').append('(' + <?= $count2 ?> + ')');

    </script>
    <?php
    die;
}














if (!empty($_GET['cat']) || !empty($_GET['date']) || !empty($_GET['type'])) {
    // $val = "";
    // foreach ($cat_arr as $key => $value) {
    //     if ($key == (count($cat_arr) - 1)) {
    //         $val .= $value;

    //     } else {
    //         $val .= $value . ',';

    //     }
    //     ;

    // }
    // echo $val;
    if (count($cat_params_arr) <= 1) {
        echo '<h2 class="mt-4 text-uppercase filter-cate_gory single">' . $cat_params_arr[0] . '</h2> ';
    } else {
        foreach ($all_categroies as $key => $all_categroies_of_events) {
            $count3 = 0;

            if (in_array($all_categroies_of_events, $cat_params_arr)) {
                ?>
                <div class='<?= $all_categroies_of_events ?>'>

                    <h2 class="mt-4 text-uppercase filter-cate_gory " id="id-<?=$all_categroies_of_events ?>">
                        <?php echo $all_categroies_of_events ?>
                    </h2>

                    <!-- data -->


                    <?php if (!empty($events_acc_to_type[$all_categroies_of_events])) { ?>
                        <div class="e-divs" id="events-div">


                            <?php
                            foreach ($events_acc_to_type[$all_categroies_of_events] as $key => $value) {
                                if ($value->hidden != true) {
                                    $count3 += 1;

                                    $price = $value->registration->price;

                                    ?>
                                    <div class="col-sm-6 col-6 card-style col-md-2">

                                        <div class="evnt-img">
                                            <img class="img" src="<?php echo $value->logo ?>">
                                        </div>
                                        <h3>
                                            <?php
                                            if ($value->shortname == "" || $value->shortname == null) {
                                                echo $value->name;
                                            } else {
                                                echo $value->shortname;
                                            }
                                            ; ?>
                                        </h3>

                                        <h4>
                                            <?php
                                            if (isset($value->times) || !empty($value->times)) {
                                                echo $value->times;
                                            } else {
                                                foreach ($value->segments as $seg) {
                                                    if (isset($seg->times) || !empty($seg->times)) {
                                                        echo $seg->times;
                                                        break;
                                                    }

                                                }
                                            }


                                            ?>
                                        </h4>
                                        <h4>
                                            <?php if ($value->registration->type === "tickets") { ?>
                                                <span>
                                                    <?= $value->registration->price ?>
                                                </span>
                                            <?php } else if ($value->registration->type === "signup") { ?>
                                                    <span>Free!</span>
                                                <?php } else if ($value->registration->type === "invites") { ?>
                                                        <span>Free!</span>
                                                    <?php } ?>
                                        </h4>

                                        <?php if ($value->registration->type === "tickets") { ?>
                                            <a target="blank" href="<?php echo $value->registration->link; ?>">
                                                <button>
                                                    <?php
                                                    if (isset($value->registration->button) && !empty($value->registration->button)) {
                                                        //echo $value->registration->button;
                                                        ?>
                                                        Register
                                                        <?php

                                                    } else {
                                                        ?>
                                                        Register
                                                        <?php

                                                    }
                                                    ?>
                                                </button>

                                            </a>


                                        <?php } else if ($value->registration->type === "signup") { ?>

                                                <a target="blank" href="<?php echo $value->registration->link; ?>">
                                                    <button>
                                                    <?php // echo $value->registration->button; ?>
                                                        Register
                                                    </button>
                                                </a>



                                            <?php } else if ($value->registration->type === "invites") { ?>
                                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                                        <button>
                                                        <?php //echo $value->registration->button; ?>
                                                            Register
                                                        </button>
                                                    </a>

                                                <?php } ?>
                                    </div>
                                    <?php

                                }
                            }
                            ?>
                            <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk">
                                <a href="https://tally.so/r/n07G0P" class="a-style" target="__blank">
                                    <div class="text-6xl">+</div>
                                    <div class="text-6xl">Host your own
                                        event!</div>
                                </a>


                            </div>

                            <?php
                    } else { ?>
                            <div class="alert alert-danger text-center p-1" role="alert">
                                No Record Found
                            </div>
                        <?php } ?>


                    </div>
                    <script >
            $('#id-<?= $all_categroies_of_events ?>').append('('+<?=$count3?>+')');
            </script>
                    <?php
            }
            
        }

        ?>
       

        <?php


    }
    ?>





        <?php if (!empty($dataFilter)) { ?>
            <div class="e-divs" id="events-div">


                <?php
                if (count($cat_params_arr) > 1) {

                } else {
$count4 = 0;
                    foreach ($dataFilter as $key => $value) {
                        // echo "<pre>";
                        // print_r($value);
                        // echo "</pre>";
        
                        if ($value->hidden != true) {
$count4 += 1;

                            $price = $value->registration->price;

                            ?>
                            <div class="col-sm-6 col-6 card-style col-md-2">
                                <!-- <a href="<?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php //echo $value->id; ?>"
                                    class="a-style"> -->
                                <div class="evnt-img">
                                    <img class="img" src="<?php echo $value->logo ?>">
                                </div>
                                <h3>
                                    <?php
                                    if ($value->shortname == "" || $value->shortname == null) {
                                        echo $value->name;
                                    } else {
                                        echo $value->shortname;
                                    }
                                    ; ?>
                                </h3>
                                <!-- </a> -->
                                <h4>
                                    <?php
                                    if (isset($value->times) || !empty($value->times)) {
                                        echo $value->times;
                                    } else {
                                        foreach ($value->segments as $seg) {
                                            if (isset($seg->times) || !empty($seg->times)) {
                                                echo $seg->times;
                                                break;
                                            }

                                        }
                                    }
                                    // old code
                                    // $date = $value->date;
                                    // $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    // $withoutyear = substr($date, strpos($date, "-") + 1);
                                    // $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    // if ($value->days == 0 || $value->days == null || $value->days == 1) {
                                    //     $ending_date = null;
                                    // } else {
                                    //     $ending_date = $starting_date + $value->days - 1;
                                    // }
                
                                    // //month
                                    // $month = (int) strstr($withoutyear, "-", true) - 1;
                
                                    // echo ($ending_date == null) ? $months[$month] . " " . $starting_date : $months[$month] . " " . $starting_date . '-' . $ending_date;
                                    //new code with multiple dates
                                    // foreach ($value->segments as $segmentss) {
                                    //     if (empty($segmentss->remote)) {
                                    //         $date = $segmentss->date;
                                    //         $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    //         $withoutyear = substr($date, strpos($date, "-") + 1);
                                    //         $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    //         $month = (int) strstr($withoutyear, "-", true) - 1;
                
                                    //         //result
                                    //         echo $months[$month] . " " . $starting_date . ' - ' . $segmentss->times;
                

                                    //         if (isset($segmentss->venues) && !empty($segmentss->venues)) {
                                    //             foreach ($segmentss->venues as $key => $val) {
                                    //                 ?>
                                    <!-- <a
                                    //                     href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<? php // echo $val ?> "> -->
                                    <?php
                                    //                 echo ($key != 0) ? ', ' . $val : $val;
                                    //                 ?>
                                    <!-- </a> -->
                                    <?php
                                    //             }
                                    //         } else {
                                    //             if (isset($value->venues)) {
                
                                    //                 foreach ($value->venues as $key => $val) {
                                    //                     ?>
                                    <!-- <a
                                    //                         href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<? php // echo $val ?> "> -->
                                    <?php
                                    //                     echo ($key != 0) ? ', ' . $val : $val;
                                    //                     ?>
                                    <!-- </a> -->
                                    <?php
                                    //                 }
                                    //             } else {
                                    //                 // foreach ($value->venueName as $key => $val) {
                                    //                 //     echo ($key != 0) ? ', ' . $val : $val;
                                    //                 // }
                                    //                 echo " " . $value->venueName;
                                    //             }
                                    //         }
                



                                    //         echo "<br/>";
                
                                    //     }
                

                                    // }
                
                                    ?>
                                </h4>
                                <h4>
                                    <?php if ($value->registration->type === "tickets") { ?>
                                        <span>
                                            <?= $value->registration->price ?>
                                        </span>
                                    <?php } else if ($value->registration->type === "signup") { ?>
                                            <span>Free!</span>
                                        <?php } else if ($value->registration->type === "invites") { ?>
                                                <span>Free!</span>
                                            <?php } ?>
                                </h4>
                                <!-- <h4>
                                    <?php //echo $value->attendees ?>
                                </h4> -->
                                <!-- <?php // if ($value->registration->button != "") { ?>
                                    <h4>
                                        <a target="blank" class="btn btn-outline-primary" href="<?php // echo $value->registration->link; ?>">
                                            <?php // echo $value->registration->button; ?>
                                        </a>
                                    </h4>
                                <?php //} ?> -->
                                <?php if ($value->registration->type === "tickets") { ?>
                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                        <button>
                                            <?php
                                            if (isset($value->registration->button) && !empty($value->registration->button)) {
                                                //echo $value->registration->button;
                                                ?>
                                                Register
                                                <?php

                                            } else {
                                                ?>
                                                Register
                                                <?php

                                            }
                                            ?>
                                        </button>

                                    </a>


                                <?php } else if ($value->registration->type === "signup") { ?>

                                        <a target="blank" href="<?php echo $value->registration->link; ?>">
                                            <button>
                                            <?php // echo $value->registration->button; ?>
                                                Register
                                            </button>
                                        </a>



                                    <?php } else if ($value->registration->type === "invites") { ?>
                                            <a target="blank" href="<?php echo $value->registration->link; ?>">
                                                <button>
                                                <?php //echo $value->registration->button; ?>
                                                    Register
                                                </button>
                                            </a>

                                        <?php } ?>
                            </div>
                            <?php

                        }
                    } ?>

                <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk">
                    <a href="https://tally.so/r/n07G0P" class="a-style" target="__blank">
                        <div class="text-6xl">+</div>
                        <div class="text-6xl">Host your own
                            event!</div>
                    </a>


                </div>
                <script >
            $('.single').append('('+<?=$count4?>+')');
            </script>
                <?php

                }
                ?>

                <?php
        } else { ?>
                <div class="alert alert-danger text-center p-1" role="alert">
                    No Record Found
                </div>
            <?php } ?>
        </div>
        <?php
} else { ?>


        <h2 class=" mt-4" id="confernce-count">Conferences & Hackathons </h2>
        <div class="e-divs" id="events-div">
            <?php

            foreach ($data->events as $key => $value) {
                // echo "<pre>";
                // print_r($value);
                // echo "<pre>";
                if ($value->hidden != true) {
                    foreach ($value->types as $typekey => $typevalue) {

                        if ($typevalue == "conference" || $typevalue == "hackathon") {

                            ?>

                            <div class="col-sm-6 col-6 card-style col-md-2">
                                <!-- <a href="<?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php // echo $value->id; ?>"
                                        class="a-style"> -->
                                <div class="evnt-img">
                                    <img class="img" src="<?php echo $value->logo ?>">
                                </div>
                                <h3>
                                    <?php
                                    if ($value->shortname == "" || $value->shortname == null) {
                                        echo $value->name;
                                    } else {
                                        echo $value->shortname;
                                    }
                                    ; ?>
                                </h3>
                                <!-- </a> -->
                                <h4>
                                    <?php
                                    //old code
                
                                    if (isset($value->times) || !empty($value->times)) {
                                        echo $value->times;
                                    } else {
                                        foreach ($value->segments as $seg) {
                                            if (isset($seg->times) || !empty($seg->times)) {
                                                echo $seg->times;
                                                break;
                                            }



                                        }
                                    }

                                    // $date = $value->date;
                                    // $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    // $withoutyear = substr($date, strpos($date, "-") + 1);
                                    // $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    // if ($value->days == 0 || $value->days == null || $value->days == 1) {
                                    //     $ending_date = null;
                                    // } else {
                                    //     $ending_date = $starting_date + $value->days - 1;
                                    // }
                
                                    // //month
                                    // $month = (int) strstr($withoutyear, "-", true) - 1;
                

                                    // echo ($ending_date == null) ? $months[$month] . " " . $starting_date : $months[$month] . " " . $starting_date . '-' . $ending_date;
                
                                    //new code with multiple dates
                                    // foreach ($value->segments as $segmentss) {
                                    //     if (empty($segmentss->remote)) {
                                    //         $date = $segmentss->date;
                                    //         $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    //         $withoutyear = substr($date, strpos($date, "-") + 1);
                                    //         $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    //         $month = (int) strstr($withoutyear, "-", true) - 1;
                
                                    //         //result
                                    //         echo $months[$month] . " " . $starting_date . ' - ' . $segmentss->times;
                

                                    // if (isset($segmentss->venues) && !empty($segmentss->venues)) {
                                    //     foreach ($segmentss->venues as $key => $val) {
                                    //         ?>
                                    <!-- <a
                                                //             href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<? php // echo $val ?> "> -->
                                    <?php
                                    //         echo ($key != 0) ? ', ' . $val : $val;
                                    //         ?>
                                    <!-- </a> -->
                                    <?php
                                    //     }
                                    // } else {
                                    //     if (isset($value->venues)) {
                
                                    //         foreach ($value->venues as $key => $val) {
                                    //             ?>
                                    <!-- <a
                                                //                 href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<? php // echo $val ?> "> -->
                                    <?php
                                    //             echo ($key != 0) ? ', ' . $val : $val;
                                    //             ?>
                                    <!-- </a> -->
                                    <?php
                                    //         }
                                    //     } else {
                                    //         // foreach ($value->venueName as $key => $val) {
                                    //         //     echo ($key != 0) ? ', ' . $val : $val;
                                    //         // }
                                    //         echo " " . $value->venueName;
                                    //     }
                                    // }
                



                                    // echo "<br/>";
                
                                    // }
                

                                    // }
                
                                    ?>
                                </h4>
                                <h4>
                                    <?php if ($value->registration->type === "tickets") { ?>
                                        <span>
                                            <?= $value->registration->price ?>
                                        </span>
                                    <?php } else if ($value->registration->type === "signup") { ?>
                                            <span>Free!</span>
                                        <?php } else if ($value->registration->type === "invites") { ?>
                                                <span>Free!</span>
                                            <?php } ?>
                                </h4>
                                <!-- <h4>
                                        <?php //echo $value->attendees ?>
                                    </h4> -->

                                <!-- <a href="https://gmevents.typeform.com/to/jy3Mufeq" class="btn btn-sm btn-primary"
                                            target="__blank">Register Here</a> -->
                                <?php if ($value->registration->type === "tickets") { ?>
                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                        <button>
                                            <?php
                                            if (isset($value->registration->button) && !empty($value->registration->button)) {
                                                // echo $value->registration->button;
                                                ?>Register
                                                <?php

                                            } else {
                                                ?>
                                                Register
                                                <?php

                                            }
                                            ?>
                                        </button>

                                    </a>


                                <?php } else if ($value->registration->type === "signup") { ?>

                                        <a target="blank" href="<?php echo $value->registration->link; ?>">
                                            <button>
                                            <?php //echo $value->registration->button; ?>
                                                Register
                                            </button>
                                        </a>



                                    <?php } else if ($value->registration->type === "invites") { ?>
                                            <a target="blank" href="<?php echo $value->registration->link; ?>">
                                                <button>
                                                <?php // echo $value->registration->button; ?>
                                                    Register
                                                </button>
                                            </a>

                                        <?php } ?>

                            </div>

                            <?php
                        }
                        break;
                    }
                }
            } ?>
            <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk">
                <a href="https://tally.so/r/n07G0P" class="a-style" target="__blank">
                    <div class="text-6xl">+</div>
                    <div class="text-6xl">Host your own
                        event!</div>
                </a>


            </div>
        </div>

        <h2 class="mt-4" id="others-count">Meetups, Parties And Other Events </h2>
        <div class="e-divs" id="events-div">
            <?php foreach ($data->events as $key => $value) {
                if ($value->hidden != true) {
                    foreach ($value->types as $typekey1 => $typevalue1) {

                        if ($typevalue1 == "party" || $typevalue1 == "meetup" || $typevalue1 == "workshop") {
                            ?>
                            <div class="col-sm-6 col-6 card-style col-md-2">
                                <!-- <a href="<?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php //echo $value->id; ?>"
                                        class="a-style"> -->
                                <div class="evnt-img">
                                    <img class="img" src="<?php echo $value->logo ?>">
                                </div>
                                <h3>
                                    <?php
                                    if ($value->shortname == "" || $value->shortname == null) {
                                        echo $value->name;
                                    } else {
                                        echo $value->shortname;
                                    }
                                    ; ?>
                                </h3>
                                <!-- </a> -->
                                <h4>
                                    <?php
                                    if (isset($value->times) || !empty($value->times)) {
                                        echo $value->times;
                                    } else {
                                        foreach ($value->segments as $seg) {
                                            if (isset($seg->times) || !empty($seg->times)) {
                                                echo $seg->times;
                                                break;
                                            }



                                        }
                                    }
                                    //old code
                                    // $date = $value->date;
                                    // $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    // $withoutyear = substr($date, strpos($date, "-") + 1);
                                    // $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    // if ($value->days == 0 || $value->days == null || $value->days == 1) {
                                    //     $ending_date = null;
                                    // } else {
                                    //     $ending_date = $starting_date + $value->days - 1;
                                    // }
                
                                    // //month
                                    // $month = (int) strstr($withoutyear, "-", true) - 1;
                
                                    // echo ($ending_date == null) ? $months[$month] . " " . $starting_date : $months[$month] . " " . $starting_date . '-' . $ending_date;
                
                                    //new code with multiple dates
                                    // foreach ($value->segments as $segmentss) {
                                    //     if (empty($segmentss->remote)) {
                                    //         $date = $segmentss->date;
                                    //         $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    //         $withoutyear = substr($date, strpos($date, "-") + 1);
                                    //         $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                                    //         $month = (int) strstr($withoutyear, "-", true) - 1;
                
                                    //         //result
                                    //         echo $months[$month] . " " . $starting_date . ' - ' . $segmentss->times;
                

                                    //         if (isset($segmentss->venues) && !empty($segmentss->venues)) {
                                    //             foreach ($segmentss->venues as $key => $val) {
                                    //                 ?>
                                    <!-- <a
                                        //                     href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<? //php // echo $val ?> "> -->
                                    <?php
                                    //                 echo ($key != 0) ? ', ' . $val : $val;
                                    //                 ?>
                                    <!-- </a> -->
                                    <?php
                                    //             }
                                    //         } else {
                                    //             if (isset($value->venues)) {
                
                                    //                 foreach ($value->venues as $key => $val) {
                                    //                     ?>
                                    <!-- <a
                                                             href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<? //php // echo $val ?> "> -->
                                    <?php
                                    //                     echo ($key != 0) ? ', ' . $val : $val;
                                    //                     ?>
                                    <!-- </a> -->
                                    <?php
                                    //                 }
                                    //             } else {
                                    //                 // foreach ($value->venueName as $key => $val) {
                                    //                 //     echo ($key != 0) ? ', ' . $val : $val;
                                    //                 // }
                                    //                 echo " " . $value->venueName;
                                    //             }
                                    //         }
                



                                    //         echo "<br/>";
                
                                    //     }
                

                                    // }
                
                                    ?>
                                </h4>
                                <h4>
                                    <?php if ($value->registration->type === "tickets") { ?>
                                        <span>
                                            <?= $value->registration->price ?>
                                        </span>
                                    <?php } else if ($value->registration->type === "signup") { ?>
                                            <span>Free!</span>
                                        <?php } else if ($value->registration->type === "invites") { ?>
                                                <span>Free!</span>
                                            <?php } ?>
                                </h4>
                                <!-- <h4>
                                        <?php // echo $value->attendees ?>
                                    </h4> -->

                                <!-- <a href="https://gmevents.typeform.com/to/jy3Mufeq" class="btn btn-sm btn-primary"
                                            target="__blank">Register Here</a> -->
                                <?php if ($value->registration->type === "tickets") { ?>
                                    <a target="blank" href="<?php echo $value->registration->link; ?>">
                                        <button>
                                            <?php
                                            if (isset($value->registration->button) && !empty($value->registration->button)) {
                                                // echo $value->registration->button;
                                                ?>Register
                                                <?php

                                            } else {
                                                ?>
                                                Register
                                                <?php

                                            }
                                            ?>
                                        </button>

                                    </a>


                                <?php } else if ($value->registration->type === "signup") { ?>

                                        <a target="blank" href="<?php echo $value->registration->link; ?>">
                                            <button>
                                                Register
                                            <?php //echo $value->registration->button; ?>
                                            </button>
                                        </a>



                                    <?php } else if ($value->registration->type === "invites") { ?>
                                            <a target="blank" href="<?php echo $value->registration->link; ?>">
                                                <button>
                                                    Register
                                                <?php //echo $value->registration->button; ?>
                                                </button>
                                            </a>

                                        <?php } ?>

                            </div>
                        <?php }
                        break;
                    }
                }
            } ?>
            <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk">
                <a href="https://tally.so/r/n07G0P" class="a-style" target="__blank">
                    <div class="text-6xl">+</div>
                    <div class="text-6xl">Host your own
                        event!</div>
                </a>


            </div>
        </div>

        <h2 class=" mt-4" id="confernce-count">Venues </h2>
        <div class="e-divs" id="events-div">
            <?php

            foreach ($data->places as $key => $value) {
                ?>
                <div class="col-sm-6 col-6 card-style col-md-2">
                    <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<?php echo $value->id; ?>"
                        class="a-style">
                        <div class="evnt-img">
                            <img class="img" src="<?php echo $value->photo ?>">
                        </div>
                        <h3>
                            <?php
                            echo $value->name;
                            ?>
                        </h3>
                    </a>

                    <h4>
                        <?php echo $value->capacity ?>
                    </h4>
                    <!-- <h4>
                            <a href="https://gmevents.typeform.com/to/jy3Mufeq" class="btn btn-sm btn-primary"
                                target="__blank">Register Here</a>
                        </h4> -->
                </div>

            <?php } ?>
        </div>
    <?php } ?>