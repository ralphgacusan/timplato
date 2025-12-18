let map, marker, autocomplete, selectedPlaceData = null;

function initMap() {
    const defaultLocation = { lat: 14.5995, lng: 120.9842 }; // Manila default

    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 13,
    });

    marker = new google.maps.Marker({
        map,
        position: defaultLocation,
        draggable: true,
    });

    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("searchInput"),
        { componentRestrictions: { country: "ph" } }
    );

    autocomplete.addListener("place_changed", function () {
        let place = autocomplete.getPlace();
        map.setCenter(place.geometry.location);
        marker.setPosition(place.geometry.location);
        selectedPlaceData = place;
    });

    google.maps.event.addListener(marker, "dragend", function () {
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: marker.getPosition() }, (results) => {
            if (results[0]) selectedPlaceData = results[0];
        });
    });
}

document.getElementById("mapPickerModal").addEventListener("shown.bs.modal", initMap);

document.getElementById("applyLocationBtn").addEventListener("click", function () {
    if (!selectedPlaceData) return alert("Please pick a location.");

    let components = selectedPlaceData.address_components;

    const get = (type) =>
        components.find((c) => c.types.includes(type))?.long_name || "";

    document.querySelector("input[name='address']").value = get("route") + " " + get("street_number");
    document.querySelector("input[name='city']").value = get("locality");
    document.querySelector("input[name='state']").value = get("administrative_area_level_1");
    document.querySelector("input[name='country']").value = get("country");
    document.querySelector("input[name='zip_code']").value = get("postal_code");

    document.getElementById("lat").value = selectedPlaceData.geometry.location.lat();
    document.getElementById("lng").value = selectedPlaceData.geometry.location.lng();

    bootstrap.Modal.getInstance(document.getElementById("mapPickerModal")).hide();
});
