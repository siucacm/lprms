<?php
class Blob_GoogleMap {
    public static function render($id = 0)
    {
            if ($id == 0) return;
            $eventlist = Datastore::getInstance()->event;
            $event = $eventlist[$id];

            ?>
<html>
    <head>
        <title><?php echo LPRMS::name(); ?> - <?php echo $event->name; ?> Map</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(37.0625,-95.677068);
    var myOptions = {
      zoom: 4,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    geocoder.geocode( { 'address': '<?php echo $event->address; ?>'}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
          map.setZoom(16);
          var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
          });
        }
      });
  }
        </script>
    </head>
    <body onload="initialize()">
        <div id="map_canvas" style="width:100%; height:100%"></div>
    </body>
</html>
            <?php
    }
}
?>
