<!-- //main file -->
<?php

$today_date = '2023-06-03';
// if (strtotime($today_date) > strtotime('2023-07-03')) {
//     echo 'true';

// }else{
//     echo "false";
// }
$cat = isset($_GET['cat']) ? $_GET['cat'] : "";
$cat_arr = explode(",", $cat);

$cat_params = isset($_GET['cat']) ? $_GET['cat'] : "";
$cat_params_arr = explode(",", $cat_params);


$date_params = isset($_GET['date']) ? $_GET['date'] : "";
$date_params_arr = explode(",", $date_params);

$type_params = isset($_GET['type']) ? $_GET['type'] : "";
$type_params_arr = explode(",", $type_params);



$data = json_decode(file_get_contents('data.json'));

//sort array events 
$dataArray = json_decode(json_encode($data), true);
foreach ($dataArray['events'] as $key => $part) {
    $sort[$key] = $part['attendees'];
}
array_multisort($sort, SORT_DESC, $dataArray['events']);

$data = json_decode(json_encode($dataArray), false);




// $catstr = "";
// foreach ($cat_arr as $key => $value) {
//     $catstr .= $value . ',';
// }

// $catstr = substr($catstr, 0, strlen($catstr) - 1);


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

//dates,weeks,full dates array 
$original_dates = date_range($lowest_date, $highest_date);
$all_dates = date_range($lowest_date, $highest_date, 'j');

$all_week = date_range($lowest_date, $highest_date, 'D');


//making array structure without event name array
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


// echo "<pre>";
// print_r($sliderMainDataArr);
// echo "</pre>";

//calculating total attendees
$total_attendees = 0;
foreach ($data->events as $key => $events) {
    if ($total_attendees < $events->attendees) {
        $total_attendees = $events->attendees;
    }
}



// print_r($all_event_acc_to_date);
// echo "</pre>";
?>




<?php
require('header.php');

?>

<div class="ban-ner">
    <div class="inner-img">
        <!-- <img src="<? php // echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/banner.png"
        alt="token2049" /> -->
        <div class="inner-text">
            <h1>TOKEN2049 WEEK</h1>
            <p>
                <?php

                $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                //startdate
                $lowestadet_withoutyear = substr($lowest_date, strpos($lowest_date, "-") + 1);
                $start_day_day = (int) substr($lowestadet_withoutyear, strpos($lowestadet_withoutyear, "-") + 1);

                //enddate.
                $enddate_withoutyear = substr($highest_date, strpos($highest_date, "-") + 1);
                $end_date_day = (int) substr($enddate_withoutyear, strpos($enddate_withoutyear, "-") + 1);
                $enddate_month = (int) strstr($enddate_withoutyear, "-", true) - 1;
                $enddate_year = (int) substr($highest_date, 0, 4);
                echo $start_day_day . ' - ' . $end_date_day . " " . $months[$enddate_month] . "  " . $enddate_year . " . SINGAPORE";
                ?>
            </p>
        </div>
    </div>

</div>
<div class="t-events">
    <div class="container c-hack">
        <div class="slider-container">
            <div class="slider-header">
                <?php $sn = 0;

                foreach ($sliderMainDataArr as $current_date => $dates) {
                    //                 echo "<pre>";
                    // print_r($current_date);
                    // echo "</pre>";
                    // $today_date_obj = date('y/m/d')
                    $active = "";


                    if (strtotime($today_date) > strtotime($current_date)) {
                        continue;
                    }

                    $last_date = date('Y-m-d', strtotime("+7 day", strtotime($today_date)));
                    // echo $last_date.'curr = '.$current_date;
                    if (strtotime($last_date) <= strtotime($current_date)) {
                        break;
                    }
                    // echo $last_date;
                    if ($current_date == $date_params) {
                        $active = 'active';
                    }
                    $sn += 1; ?>
                    <!-- <a href=" <?php //echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/?date=<?php //echo $current_date;
                         //echo empty($cat_params) ? '' : '&cat=' . $cat_params;
                         // echo empty($type_params) ? '' : '&type=' . $type_params ?> "> -->


                    <button class="but-<?= $sn . ' ' . $active ?> filterbtn datebtn" data-but_id="<?= $current_date ?>">

                        <?php
                        $date = $current_date;
                        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        $withoutyear = substr($date, strpos($date, "-") + 1);
                        $starting_date = (int) substr($withoutyear, strpos($withoutyear, "-") + 1);
                        $month = (int) strstr($withoutyear, "-", true) - 1;

                        //result
                        echo $starting_date . " " . $months[$month];
                        ?>

                    </button>
                    <!-- </a> -->
                <?php } ?>
            </div>
        </div>
        <!-- //banner -->
        <?php require('filter.php');
        ?>
        <!-- <div class="filter">
            <h3>Date :</h3>
            <p class="date">none</p>

            <h3>Category :</h3>
            <p class="category">none</p>

            <h3>Type :</h3>
            <p class="type-para">none</p>

        </div> -->
        <div class="alldata">

        </div>

    </div>
</div>

<?php require('footer.php') ?>


<script>
    $.ajax({
        url: "<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/listajax?",
    }).done(function (data) {
        // console.log(data);
        $(".alldata").append(data);

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

    }).fail(function () {
        alert("failed to connect");
    })
</script>