var input = document.getElementById("myInput");
input.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("myBtn").click();
    }
});


function openmodal(time, desc, placeid) {
    if (desc == "NONE") {
        $('#event-name').html("Add New Event");
        $('#event-body').html("");

        populateNewEventModal(time);
    } else {
        $.ajax({
            dataType: "json",
            url: "./actions/getData.php?time=" + time + "&placeid=" + placeid + "&desc=" + desc,
        }).done(function(data) {
            console.log(data);

            console.log("TEXT");

            console.log("hello")
            // Show event info
            var openNOW = "NOPE";
            if (data.open_now) {
                openNOW = "We&apos;re now OPEN";
            } else {
                openNOW = "CLOSED";
            }

            var openingHours = data.opening;
            var closingHours = data.closing;
            var weekOpening = [];

            var week;
            for (week = 0; week < 7; week++) {
                if ((openingHours[week] == null) || (closingHours[week] == null)) {
                    weekOpening[week] = "&nbsp;&nbsp;CLOSED&nbsp;&nbsp;";
                } else {
                    weekOpening[week] = openingHours[week] + " - " + closingHours[week];
                }
            }

            $('#event-name').html(data.name);
            $('#event-body').html('<p> <b>Address : </b>' + data.address + '<br>' +
                '<b>Phone : </b>' + data.phone + '<br>' +
                '<b>Open Now : </b>' + openNOW + '</p>' +
                '<p>------------------------------------------</p>' +
                '<p><b>Sunday    : </b>' + weekOpening[0] + '<br>' +
                '<b>Monday    : </b>' + weekOpening[1] + '<br>' +
                '<b>Tuesday   : </b>' + weekOpening[2] + '<br>' +
                '<b>Wednesday : </b>' + weekOpening[3] + '<br>' +
                '<b>Thursday  : </b>' + weekOpening[4] + '<br>' +
                '<b>Friday    : </b>' + weekOpening[5] + '<br>' +
                '<b>Saturday  : </b>' + weekOpening[6] + '</p>' +
                '<p>------------------------------------------</p>' +
                '<p><b>Rating : </b>' + data.price + ' / 5</p>' +
                '<b>Photo:</b><img src="' + data.photo + '" style="width:100%"/>' +
                '<p><b>Website : </b><a href="' + data.website + '" target=_BLANK>' + data.website + '</a></p>'

            );
        });
    }

    $('#eventModal').modal({
        keyboard: false
    })
    $('#eventModal').modal('show')
  }


function populateNewEventModal(time) {
  content = "";
  content += "<h4>Select Category</h4>";
  options = {
    "amusement_park": "Amusement Park",
    "art_gallery": "Art Gallery",
    "aquarium" : "Aquarium",
    "bowling_alley" : "Bowling Alley",
    "casino" : "Casino",
    "department_store" : "Department Store",
    "jewelry_store" : "Jewelry Store",
    "movie_theatre" : "Movie Theatre",
    "museum" : "Museum",
    "night_club" : "Night Club",
    "shopping_mall" : "Shopping Mall",
    "stadium" : "Stadium",
    "spa" : "Spa",
    "park" : "Park",
    "zoo" : "Zoo",
    "bakery" : "Bakery",
    "bar" : "Bar",
    "cafe" : "Coffee Shop",
    "liquor_store" : "Liquor Store",
    "restaurant" : "Restaurant",
    "supermarket" : "Supermarket",
    "meal_takeaway" : "Take-Out"
  }
  content += '<select class="form-control form-control-lg" id="chosenCategory">';

  for (var key in options){
    content += '<option value=' + key + '>' + options[key] + '</option>';
  }

  content += '</select><br><br>';
  content += '<button class="float-right btn btn-primary" onclick=populateEventListModal(' + time + ')>Next</button>';
  $('#event-body').html(content);
}


function populateEventListModal(time) {
    content = "<ul class=\"list-group\">";

    var type = document.getElementById("chosenCategory").value;
    $('#event-body').html("");

    var city = document.getElementById("itineraryHeader").innerHTML;

    $.get({
        dataType: "json",
        url: "https://jackbiggin.lib.id/hackwestern@dev/findNearbyLocations/?location=" + city + "&radius=4000&searchType=" + type,
    }).done(function(data){


      for(var place in data)
      {
        content = content + "<li class=\"list-group-item\" id=\"ChoosenPlace\">" +
                                  "<div class=\"row\">" +
                                        "<div class=\"col-md-3\">" +
                                            "<img src=\"" + data[place].photo + "\" style = \"width:100%\" />" +
                                        "</div>" +
                                        "<div class=\"col-md-9\">" +
                                            "<b>Name    : </b>" + data[place].name + "<br>" +
                                            "<b>Address : </b>" + data[place].address + "<br>" +
                                            "<b>rating : </b>" + data[place].rating + " / 5 <br>" +
                                            "<button class=\"float-right btn btn-primary\" onclick=\"finalizeSelection(" + time + ',\'' + encodeURI(data[place].place_id) + '\',\'' + encodeURI(data[place].name) + "\')\">Choose</button>" +
                                        "</div>" +
                                  "</div>" +
                            "</li>";
      }

      content += "</ul>";
      $('#event-body').html(content);
    });
}

function finalizeSelection(time, placeID, name){
    $('#event-body').html("");
    placeID = decodeURI(placeID);
    name = decodeURI(name);

    var schedule_id = document.getElementById("schedule_id").innerHTML;

    $.get({
        dataType: "json",
        url: "./actions/storeSelection.php/?time=" + time + "&place_id=" + placeID+ "&schedule_id=" + schedule_id + "&name=" + name,
    });

    setTimeout(function(){
      location.reload();
    }, 1000);
}
