<?php

$data = json_decode(file_get_contents('../data.json'));

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
// print_r($sliderMainDataArr);
//  timerange('2023-02-05',"22:10-02:00");


//populating main slider div


// echo "<pre>";

// print_r($sliderMainDataArr);
// echo "</pre>";



//calculating event in days

//calculate date
// echo "<pre>";

$all_event_acc_to_date = [];
foreach ($data->events as $eventa) {
    if ($eventa->hidden != true) {
        $link = $eventa->id;
        $star = null;
    } else {
        $link = null;
        $star = "*";
    }

    if ($eventa->shortname == "" || !isset($eventa->shortname)) {
        $name = $eventa->name;
    } else {
        $name = $eventa->shortname;
    }
    // $start_date = $eventa->date;
    // $end_date = date("Y-m-d", strtotime("+" . $eventa->days - 1 . " day", strtotime($start_date)));
    // $all_events_dates = date_range($start_date, $end_date);
    //     echo $start_date;
    // echo $end_date;
    // echo "<br/>";
    //     echo $name;
    //     print_r($all_events_dates);
    $logo = $eventa->logo;
    $types = $eventa->types;
    $attendees = $eventa->attendees;
    $venues = $eventa->venues;
    $venueName = $eventa->venueName;
    foreach ($eventa->segments as $seg) {
        if (!isset($seg->remote) || empty($seg->remote)) {
            $time = $seg->times;
            $date = $seg->date;
            $title = $seg->title;

            $all_event_acc_to_date[$date][] = ['logo' => $logo, 'name' => $name, 'types' => $types, 'attendees' => $attendees, 'venueName' => $venueName, 'venues' => $venues, 'times' => $time, 'link' => $link, 'title' => $title, 'star' => $star];
        }
    }
}



//sorting all events acc to date

$arr_onlydates = [];
foreach ($all_event_acc_to_date as $dates => $all_events_array) {

    foreach ($all_events_array as $current_event_in_that_date) {
        $start_time = (int) substr($current_event_in_that_date['times'], 0, 2);
        $arr_onlydates[$dates][] = $start_time;
    }
}
// print_r($all_event_acc_to_date);
// print_r($arr_onlydates);


foreach ($arr_onlydates as $dates => $value) {
    // 12 loop acc days
    // print_r($value);

    //curenteventtimeswhichneedtobesorted
    array_multisort($arr_onlydates[$dates], SORT_ASC, SORT_NUMERIC, $all_event_acc_to_date[$dates]);
}
// print_r($all_event_acc_to_date);

//calculating total attendees
$total_attendees = 0;
foreach ($data->events as $key => $events) {
    if ($total_attendees < $events->attendees) {
        $total_attendees = $events->attendees;
    }
}


require('../header.php')
?>


<div class="t-events t-inner">

    <div class="container c-hack">
  
    <div class="slider-container">
            <div class="slider-header">
                <?php $sn = 0;
                foreach ($sliderMainDataArr as $current_date => $dates) {
                    $active='';
                    if ($current_date === $_SERVER['QUERY_STRING']) {
                        $active = "active";
                    }
                    $sn += 1; ?>
                    <a
                        href=" <?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/day?<?php echo $current_date; ?> ">       
                            <button class="but-<?= $sn." ".$active ?>">
                                <div class="title">
                                    <?php echo $dates['title'] ?>
                                </div>
                            </button>                
                    </a>
                <?php } ?>

            </div>
        </div>
  
    <div class="conte-nt">
            <h2>
                <?php
                //dtae

                $timestamp = strtotime($_SERVER["QUERY_STRING"]);
                //echo $timestamp;
                $day = date('l', $timestamp);
                // echo $day
                $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                $withoutyear = substr($_SERVER["QUERY_STRING"], strpos($_SERVER["QUERY_STRING"], "-") + 1);
                $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);

                //month
                $month = (int) strstr($withoutyear, "-", true) - 1;
                $year = (int) strstr($_SERVER["QUERY_STRING"], "-", true);

                echo $months[$month] . " " . $starting_date . ', ' . $year . " - " . $day;
                ?>
            </h2>
            <?php foreach ($all_event_acc_to_date as $current_date => $all_event_inthatday) {
                if ($current_date == $_SERVER["QUERY_STRING"]) {
                    foreach ($all_event_inthatday as $current_event) {

                        //    echo "<pre>";
                        //    print_r($current_event);
                        //    echo "</pre>";
            ?>

                        <h4>
                            <!-- time -->
                            <span class="times">
                                <?php
                                echo $current_event['times'];

                                ?>
                            </span>
                            <img src="<?php echo $current_event['logo'] ?>" />
                            <!-- //name -->
                            <span class="name">

                                <?php
                                if (!empty($current_event['link'])) { ?>
                                    <!-- <a href="<?php// echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/event-detail?<?php //echo $current_event['link']; ?>" class="a-style"> -->

                                        <?php
                                        echo (($current_event['title'] != '') ? $current_event['name'] . '-' . $current_event['title'] : $current_event['name']);

                                        ?>
                                    <!-- </a> -->
                                <?php
                                } else {
                                    echo (($current_event['title'] != '') ? $current_event['name'] . '-' . $current_event['title'] . $current_event['star'] : $current_event['name'] . $current_event['star']);
                                }
                                ?>
                            </span>
                            <?php
                            //  types                           
                            foreach ($current_event['types'] as $key => $value1) {
                            ?>
                                <span class="type" id="<?php echo $value1 ?>">
                                    <?php echo $value1 ?>

                                </span>
                            <?php
                            }
                            ?>
                            <!-- location -->
                            <span class="location">

                                📍
                                <?php
                                if (!empty($current_event['venues'])) {

                                    foreach ($current_event['venues'] as $key => $val) {
                                ?>
                                        <a href=" <?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/place?<?php echo $val ?> ">
                                            <?php
                                            echo ($key != 0) ? ', ' . $val : $val;
                                            ?>
                                        </a>
                                <?php
                                    }
                                } else {
                                    // foreach ($current_event[''venueName as $key => $val) {
                                    //     echo ($key != 0) ? ', ' . $val : $val;
                                    // }
                                    echo $current_event['venueName'];
                                };
                                ?>
                            </span>
                            <!-- attendees -->
                            <span class="attendees">

                                👥

                                <?php
                                //echo empty($segment_value->ecap']);
                                if (!empty($current_event['ecap'])) {
                                    echo $current_event['ecap'];
                                } else {
                                    echo $current_event['attendees'];
                                }
                                ?>
                            </span>
                        </h4>
            <?php


                    }
                }
            }
            ?>
        </div>
    </div>


</div>


<script>
    document.getElementById('<?= $_SERVER["QUERY_STRING"] ?>').classList.add('active');
    document.getElementById('<?= $_SERVER["QUERY_STRING"] ?>').parentElement.previousElementSibling.children[0].classList.add('r-border');
</script>


<?php require('../footer.php') ?>