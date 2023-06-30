<?php
$data = json_decode(file_get_contents('data.json'));

$type = ["Free", "Paid"];
$cat = isset($_GET['cat']) ? $_GET['cat'] : "ALL";
$type_params = isset($_GET['cat']) ? $_GET['type'] : "";

$active = isset($_GET['active']) ? $_GET['active'] : "";


$cat_arr_from_url = explode(",", $cat);
$type_arr_from_url = explode(",", $type_params);


$category = ['ALL'];
foreach ($data->events as $key => $curr_event) {
  foreach ($curr_event->types as $key => $curr_type) {
    if (!in_array($curr_type,$category)) {
     array_push($category,$curr_type);
    }
  }
}
?>

<div class="fillers">
  <div class="row">
    <div class="col-lg-12 filter-btb d-flex">
      <label for="c" class="form-label"><img src="img/filter.png" > Filters: </label>
     <div class="ma-in">
        <div id="all-buttons">
          <?php 
            foreach ($category as  $value) {
              $active = '';
              if (in_array($value,$cat_arr_from_url)) {
                $active = 'active';
              }
              ?>
              <button id="<?= $value ?>" data-but_id ='<?= $value ?>' class="filterbtn catbtn <?= $active ?>"  ><?= $value ?></buttton>
              <?php
            }
          ?>

        </div>
        <div id="payment-buttons">
          <?php
           foreach ($type as  $value) {
            $active = '';
            if (in_array($value,$type_arr_from_url)) {
              $active = 'active';
            }
            ?>
            <button id="<?= $value ?>" data-but_id ='<?= $value ?>' class="filterbtn typebtn <?= $active ?>"  ><?= $value ?></buttton>
            <?php
          }
          ?>
          
        </div>
     </div>


    </div>
  </div>
</div>

<script>
  // function filterFun() {
  //   document.getElementById("buttonFilter").click();
  // }

  // $.ajax({

  //   url: 'data.json',
  //   method: "post",
  //   dataType: "json",
  //   data: {
  //     fetch: "RECORD"
  //   },
    // success: function (result) {
    //   let categoryAll = [];
    //   let output = `<option value="">--select category--</option>`;
    //   for (const key in result.places) {
    //     if (result.places.hasOwnProperty.call(result.places, key)) {
    //       const element = result.places[key];
    //       if (element.eventTypes.length > 0) {
    //         for (const key2 in element.eventTypes) {
    //           if (element.eventTypes.hasOwnProperty.call(element.eventTypes, key2)) {
    //             const data = element.eventTypes[key2];
    //             if (categoryAll.includes(data) == false) {
    //               categoryAll.push(data);
    //               let selected = '<?php //$categoryGet ?>' == data ? 'selected' : "";
    //               output += `<option value="${data}" ${selected} >${data}</option>`
    //             } else { }
    //           }
    //         }
    //       }
    //     }
    //   }
    //   categoryAll.sort();
    //   document.querySelector("#category").innerHTML = output;


    // }
  //   success: function (result) {
  //     const category = [];
  //     for (const singleevent in result.events) {
  //       for (const curr_type in result.events[singleevent]['types']) {


  //         if (!category.includes(result.events[singleevent]['types'][curr_type])) {
  //           category.unshift(result.events[singleevent]['types'][curr_type]);
  //         }

  //       }

  //     }
  //     category.unshift('ALL');
  //     var element = "";
  //     var payment_element = "";
  //     // console.log(category);s
  //     for (let i = 0; i < category.length; i++) {
  //       element += `<button id="${category[i]}" data-but_id ='${category[i]}' class="catbtn"  >${category[i]}</buttton>`;

  //     }
  //     document.querySelector("#all-buttons").innerHTML = element;
  //     var payment =['Paid', 'Free'];
  //     for (let i = 0; i < payment.length; i++) {
  //       payment_element += `<button id="${payment[i]}" data-but_id ='${payment[i]}'  class="catbtn"  >${payment[i]}</buttton>`;

  //     }
  //     document.querySelector("#payment-buttons").innerHTML = payment_element;


  //   }
  // })


  // function urlchange(z) {
  //   main = z.dataset.but_id;

  //   if (main == "ALL") {
  //     window.location.href = "<?php // echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/";

  //   } else {
  //     const urlParams = new URLSearchParams(window.location.search);
  //     var cat = urlParams.get('cat');


  //     if (cat == null) {
  //       cat = main;
  //     } else {
  //       cat += ',' + main;
  //     }

     


  //     if (cat.length == 0) {
  //       window.location.href += `?cat=${cat}`;

  //     } else {
  //       let url = window.location.href.split('?')[0];
  //       window.location.href = url + `?cat=${cat}`;

  //     }
  //   }
  // }




</script>