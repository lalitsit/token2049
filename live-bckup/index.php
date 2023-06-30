<?php

$data = json_decode(file_get_contents('https://data.prgblockweek.com/23/index.json'));

//sort array events 
$dataArray = json_decode(json_encode($data), true);
foreach ($dataArray['events'] as $key => $part) {
    $sort[$key] = $part['attendees'];
}
array_multisort($sort, SORT_DESC, $dataArray['events']);
// echo "<pre>";
// print_r($sort);
// echo "</pre>";

$data = json_decode(json_encode($dataArray), false);




//calculate date
function date_range($first, $last, $output_format = 'Y-m-d', $step = '+1 day')
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
$lowest_date = "";
$highest_date = "";
$sliderMainDataArr = [];

foreach ($data->events as $key => $value) {
    if ($value->date < $lowest_date || empty($lowest_date)) {
        $lowest_date = $value->date;
    }
    if ($value->date > $highest_date || empty($highest_date)) {
        $highest_date = $value->date;
    }
}

//dates,weeks,fulldates array 
$original_dates = date_range($lowest_date, $highest_date);
$all_dates = date_range($lowest_date, $highest_date, 'j');
$all_week = date_range($lowest_date, $highest_date, 'D');


//making array strutcture without event name array
for ($i = 0; $i < count($all_dates); $i++) {
    $title = $all_week[$i] . " " . $all_dates[$i];
    $sliderMainDataArr[$original_dates[$i]] = ['title' => $title, 'details' => []];

    for ($z = 0; $z < 24; $z++) {
        $a = $z;
        $start_time_length = strlen((string) $a);
        $b = $z + 1;
        if ($b === 24) {
            $b = 0;
        }
        $end_time_length = strlen((string) $b);

        if ($start_time_length < 2) {
            $a = "0" . $a;
        }

        if ($end_time_length < 2) {
            $b = "0" . $b;
        }

        $sliderMainDataArr[$original_dates[$i]]['details'][$a . ':00-' . ($b) . ':00'] = [];
    }
}

// echo "<pre>";



//calculating range of time with date
function timerange($date, $time = "", $format = 'H:i', $step = '')
{
    if (!isset($time) || empty($time)) {

        return;
    }
    $position = strpos($time, '-');
    $first = substr($time, 0, $position);
    $last = substr($time, $position + 1, strlen($time));
    $start_time = DateTime::createFromFormat($format, $first)->format($format);
    $end_time = DateTime::createFromFormat($format, $last)->format($format);

    // modify endtime if endtime is in minutes
    if (DateTime::createFromFormat($format, $last)->format('i') != 0) {
        $end_time = date("H:i", strtotime(DateTime::createFromFormat($format, $last)->format('H') . ":00") + 60 * 60);
    }
    // modify starttime if endtime is in minutes

    if (DateTime::createFromFormat($format, $first)->format('i') != 0) {
        $start_time = date("H:i", strtotime(DateTime::createFromFormat($format, $first)->format('H') . ":00"));
    }
    // echo $start_time.$end_time;
    $start_time_modified = "";
    $timerang = [];
    while ($start_time != $end_time) {
        $timestamp = strtotime($start_time) + 60 * 60;
        $new_time = date('H:i', $timestamp);
        if ($start_time_modified == '00:00') {
            $inc = strtotime("1 day", strtotime($date));
            $date = date("Y-m-d", $inc);

        }

        $timerang[] = ['timerange' => $start_time . '-' . $new_time, 'date' => $date];
        $start_time = $new_time;
        $start_time_modified = $start_time;
    }
    return $timerang;
    //  print_r($timerang);

}


// // //  print_r($sliderMainDataArr);
//  timerange('2023-02-05',"22:10-02:00");


//populating main slider div
foreach ($data->events as $allevents) {
    if ($allevents->shortname == "" || !isset($allevents->shortname)) {
        $name = $allevents->name;
    } else {
        $name = $allevents->shortname;
    }
    $logo = $allevents->logo;
    $attendees = $allevents->attendees;
    if ($allevents->hidden == true) {
        $star = '*';
    } else {
        $star = null;
    }

    // echo "<br/>";
    foreach ($allevents->segments as $segment) {
        // print_r($segment);
        $date = $segment->date;
        $time = $segment->times;
        $title = $segment->title;
        // echo $time;
        // echo "<br/>";


        $timerange_segment = timerange($date, $time);

        // print_r($timerange_segment);

        foreach ($timerange_segment as $timeinmain) {
            // echo $date.$timeinmain;
            // print_r($sliderMainDataArr[$date]['details'][$timeinmain]);
            $sliderMainDataArr[$timeinmain['date']]['details'][$timeinmain['timerange']][] = ['name' => $name, 'logo' => $logo, 'attendees' => $attendees, 'title' => $title, 'star' => $star];

        }


    }
}


//calculating total attendees
$total_attendees = 0;
foreach ($data->events as $key => $events) {
    if ($total_attendees<$events->attendees) {
        $total_attendees = $events->attendees;
    }
}
?>

<?php require('header.php') ?>


<div class="t-events">

    <div class="container c-hack">
    <div class="slider-container">
            <div class="slider-header">
                <?php $sn = 0;
                foreach ($sliderMainDataArr as $current_date => $dates) {
                    $sn += 1; ?>
                    <a
                        href=" <?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/day?<?php echo $current_date; ?> ">
                        <div class="slider_inner" id="<?php echo $current_date ?>">
                            <div class="title">
                                <?php echo $dates['title'] ?>
                            </div>
                            <div class="events-wrap">
                                <?php $snEv = 0;
                                foreach ($dates['details'] as $time => $all_slider_event) {
                                    //timearray data
                            

                                    $snEv += 1;
                                    // echo "<pre>";
                                    // // echo 1256282;
                                    // print_r($time);
                                    // echo "</pre>";
                                    ?>

                                    <div class="events" id="date<?php echo $sn . $snEv ?>">

                                    </div>
                                    <div style="display:none;">
                                        <div class="events-details" id="eventdate<?php echo $sn . $snEv ?>">
                                            <h3>
                                                <?php
                                                $timestamp = strtotime($current_date);
                                                $week = date('l', $timestamp);
                                                $month = date('F', $timestamp);
                                                $day = date('j', $timestamp);

                                                echo $week . "  " . $month . " " . $day . " | " . $time;
                                                ?>
                                            </h3>

                                            <ul>

                                                <?php if (count($all_slider_event) == 0) {
                                                    ?>
                                                    <li>No Events</li>
                                                <?php }
                                                ;
                                                $total_attendees_in_hour = 0;
                                                $text = 0;
                                                foreach ($all_slider_event as $current_event) {
                                                    if (!empty($current_event['star'])) {
                                                        $text = 1;
                                                    }
                                                    $total_attendees_in_hour += $current_event['attendees'];
                                                    ?>

                                                    <li>
                                                        <img src="<?php echo $current_event['logo'] ?>" alt="event"></img>
                                                        <?php if (!empty($current_event['title'])) {
                                                            echo $current_event['name'] . ' - ' . $current_event['title'] . $current_event['star'];

                                                        } else {
                                                            echo $current_event['name'] . $current_event['star'];

                                                        }
                                                        ?>
                                                    </li>
                                                <?php }
                                                if ($text === 1) {
                                                    echo "<p> *Not a part of #Token2049 </p>";
                                                }

                                                ?>
                                                <?php
                                                ?>
                                                <script>
                                                    var total_attendees_in_hour = <?php echo $total_attendees_in_hour ?>;
                                                    var total_attendees = <?php echo $total_attendees ?>;
                                                    var current_date = '<?= $current_date ?>';
                                                    var percentage = Math.ceil((total_attendees_in_hour / total_attendees) * 100);

                                                 
                                                        $('#date<?php echo $sn . $snEv ?>').attr('style', 'background: rgb(255 22 22 / ' + percentage + '%);');
                                                    

                                                </script>
                                            </ul>

                                        </div>
                                    </div>
                                    <script>
                                        $('#date<?php echo $sn . $snEv ?>').webuiPopover({
                                            url: '#eventdate<?php echo $sn . $snEv ?>',
                                            trigger: 'hover',
                                            container: document.getElementById('showcontent'),
                                            placement: 'bottom'
                                            // style: 'v2',
                                            // animation: 'pop',
                                            // width: '140',
                                            // cache: false
                                        });
                                    </script>

                                <?php } ?>
                            </div>
                        </div>
                    </a>
                <?php } ?>

            </div>
        </div>
        <h2 class=" mt-4" id="confernce-count">CONFERENCES & HACKATHONS </h2>
        <div class="e-divs" id="events-div">
            <?php

            foreach ($data->events as $key => $value) {
                if ($value->hidden != true) {
                    foreach ($value->types as $typekey => $typevalue) {

                        if ($typevalue == "conference" || $typevalue == "hackathon") {

                            ?>

                            <div class="col-sm-6 col-6 card-style col-md-2">
                                <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/event-detail?<?php echo $value->id; ?>"
                                    class="a-style">
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
                                </a>
                                <h4>
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

                                    //month
                                    $month = (int) strstr($withoutyear, "-", true) - 1;


                                    echo ($ending_date == null) ? $months[$month] . " " . $starting_date : $months[$month] . " " . $starting_date . '-' . $ending_date;
                                    ?>
                                </h4>
                                <h4>
                                    <?php echo $value->attendees ?>
                                </h4>
                            </div>

                            <?php
                        }
                        break;
                    }
                }
            } ?>
            <div class="col-sm-6 col-6 card-style col-md-2 host-evnt-lnk" style="
    display: flex;
    align-items: center;
    height: 195px;
    justify-content: center;
    color: #e3e3e3 !important;
    opacity: 1;
    font-size: 1.5rem;
    line-height: 2rem;
">
                <a href="https://tally.so/r/3Nr4bN" class="a-style" target="__blank">
                    <div class="text-6xl" style="
    color: #9299a5 !important;
    font-size: 3.75rem;
    line-height: 1;
">+</div>
                    <div class="text-6xl" style="
    color: #9299a5 !important;
    text-decoration: underline;
">Host your own event!</div>
                </a>


            </div>
        </div>

        <h2 class="mt-4" id="others-count">MEETUPS, PARTIES AND OTHER EVENTS </h2>
        <div class="e-divs" id="events-div">
            <?php foreach ($data->events as $key => $value) {
                if ($value->hidden != true) {
                    foreach ($value->types as $typekey1 => $typevalue1) {

                        if ($typevalue1 == "party" || $typevalue1 == "meetup" || $typevalue1 == "workshop") {
                            ?>
                            <div class="col-sm-6 col-6 card-style col-md-2">
                                <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/event-detail?<?php echo $value->id; ?>"
                                    class="a-style">
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
                                </a>
                                <h4>
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

                                    //month
                                    $month = (int) strstr($withoutyear, "-", true) - 1;

                                    echo ($ending_date == null) ? $months[$month] . " " . $starting_date : $months[$month] . " " . $starting_date . '-' . $ending_date;
                                    ?>
                                </h4>
                                <h4>
                                    <?php echo $value->attendees ?>
                                </h4>
                            </div>
                        <?php }
                        break;
                    }
                }
            } ?>
        </div>

        <h2 class=" mt-4" id="confernce-count">Venues </h2>
        <div class="e-divs" id="events-div">
            <?php

            foreach ($data->places as $key => $value) {
                ?>

                <div class="col-sm-6 col-6 card-style col-md-2">


                    <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/place?<?php echo $value->id; ?>"
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
                </div>

                <?php

            } ?>
        </div>

    </div>

</div>


<?php require('footer.php') ?>