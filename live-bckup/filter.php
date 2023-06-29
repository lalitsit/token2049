<?php
$type = ["Free", "Paid"];
$categoryGet = isset($_GET['c']) ? $_GET['c'] : "";
$typeGet = isset($_GET['t']) ? $_GET['t'] : "";
?>
<form>

  <div class="fillers">
    <div class="row">
      <div class="col-lg-4 col-sm-5 cat d-flex">
        <label for="c" class="form-label">Category</label>
        <select name="c" id="category" onchange="filterFun()" class="form-control text-capitalize">
          <option value=""></option>
        </select>
      </div>
      <div class="col-lg-4 col-sm-5 ty_pe d-flex">
        <label for="c" class="form-label">Type</label>
        <select name="t" id="type" onchange="filterFun()" class="form-control text-capitalize">
          <option value="">--select type--</option>
          <?php
          foreach ($type as $key => $value) {
            $selected = $typeGet == $value ? 'selected' : "";
          ?>
            <option value="<?= $value ?>" <?= $selected ?>><?= $value ?></option>
          <?php }
          ?>
        </select>
      </div>
      <div class="col-lg-4 col-sm-2 b_tn">
        <label for="c" class="form-label"></label>
        <button type="submit" style="display: none;" id="buttonFilter" class="btn btn-primary">Filter</button>
        <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>" class="btn btn-danger">Reset</a>
      </div>
    </div>
  </div>
</form>

<script>
  function filterFun() {
    document.getElementById("buttonFilter").click();
  }

  $.ajax({
    url: 'data.json',
    method: "post",
    dataType: "json",
    data: {
      fetch: "RECORD"
    },
    success: function(result) {
      let categoryAll = [];
      let output = `<option value="">--select type--</option>`;
      for (const key in result.places) {
        if (result.places.hasOwnProperty.call(result.places, key)) {
          const element = result.places[key];
          if (element.eventTypes.length > 0) {
            for (const key2 in element.eventTypes) {
              if (element.eventTypes.hasOwnProperty.call(element.eventTypes, key2)) {
                const data = element.eventTypes[key2];
                if (categoryAll.includes(data) == false) {
                  categoryAll.push(data);
                  let selected = '<?= $categoryGet ?>' == data ? 'selected' : "";
                  output += `<option value="${data}" ${selected} >${data}</option>`
                } else {}
              }
            }
          }
        }
      }
      categoryAll.sort();
      document.querySelector("#category").innerHTML = output;


    }
  })
</script>