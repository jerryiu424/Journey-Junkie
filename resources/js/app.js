var input = document.getElementById("myInput");
input.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("myBtn").click();
    }
});


function openmodal(time, desc, placeid){
  $.ajax({
    dataType: "json",
    url: "./actions/getData.php?time=" + time + "&placeid=" + placeid + "&desc=" + desc,
  }).done(function(data) {
    console.log(data);

    console.log("TEXT");

    var openNOW = "NOPE";
    if(data.open_now){
      openNOW = "We&apos;re now OPEN";
    }
    else {
      openNOW = "CLOSED";
    }

    var openingHours = data.opening;
    var closingHours = data.closing;
    var weekOpening = [];

    var week;
    for(week = 0; week < 7; week++){
      if((openingHours[week] == null) || (closingHours[week] == null)){
        weekOpening[week] = "&nbsp;&nbsp;CLOSED&nbsp;&nbsp;";
      }
      else {
        weekOpening[week] = openingHours[week] + " - " + closingHours[week];
      }
    }

    $('#event-name').html(data.name);
    $('#event-body').html('<p> <b>Address : </b>' + data.address + '<br>'+
                          '<b>Phone : </b>' + data.phone + '<br>' +
                          '<b>Open Now : </b>' + openNOW + '</p>'+
                          '<p>------------------------------------------</p>'+
                          '<p><b>Sunday    : </b>' + weekOpening[0] + '<br>' +
                          '<b>Monday    : </b>' + weekOpening[1] + '<br>' +
                          '<b>Tuesday   : </b>' + weekOpening[2] + '<br>' +
                          '<b>Wednesday : </b>' + weekOpening[3] + '<br>' +
                          '<b>Thursday  : </b>' + weekOpening[4] + '<br>' +
                          '<b>Friday    : </b>' + weekOpening[5] + '<br>' +
                          '<b>Saturday  : </b>' + weekOpening[6] + '</p>' +
                          '<p>------------------------------------------</p>'+
                          '<p><b>Price : </b>' + data.price + ' / 5</p>' +
                          '<b>photo:</b><img src="' + data.photo + '" style="width:100%"/>'+
                          '<p><b>Website : </b><a href="' + data.website + '" target=_BLANK>' + data.website + '</a></p>'

    );

  });
  $('#eventModal').modal({
  keyboard: false
  })
  $('#eventModal').modal('show')
}
