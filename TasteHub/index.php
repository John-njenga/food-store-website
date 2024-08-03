<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TASTELOGIC</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Include Google Maps API with your API key -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" width="150px" height="150px" async defer></script>
  <style>
    /* Basic styling for the map and sections */
    #map {
      height: 300px; /* Adjust map height as needed */
    }
    .address-section {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .search-bar input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 10px;
    }
    .location-button a,
    .map-link a {
      text-decoration: none;
      color: #1a73e8;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <section class="bg-gradient-to-r from-yellow-400 to-orange-400 min-h-screen">
    <header class="flex items-center justify-between py-4 bg-gradient-to-r from-yellow-400 to-orange-400">
      <div class="flex items-center">
        <div class="text-3xl font-bold text-teal-600 mr-4">TASTELOGIC</div>
        <img src="https://static.vecteezy.com/system/resources/previews/006/487/588/non_2x/hand-drawn-yummy-face-tongue-smile-delicious-icon-logo-vector.jpg" class="h-10">
      </div>
      <a href="home.php" class="bg-teal-600 text-white px-4 py-2 rounded-lg">Get started</a>
    </header>

    <section class="text-center py-20 bg-gradient-to-r from-yellow-400 to-orange-400">
      <div class="container mx-auto grid grid-cols-2 gap-8">
        <img src="https://cdn.pixabay.com/animation/2022/08/05/15/04/15-04-27-391_512.gif" alt="Hero Image" class="col-start-1 row-start-1 row-span-2">
        <div class="address-section col-start-2 row-start-1">
          <h2 class="text-lg font-bold">Add a delivery address</h2>

          <div class="search-bar relative mt-4">
            <input id="addressInput" type="text" placeholder="Search for streets, cities, districts..." class="w-full p-1 border-b border-zinc-300 dark:border-zinc-600 focus:outline-none focus:border-zinc-500 dark:focus:border-zinc-400">
          </div>

          <div class="location-button mt-2 flex items-center">
            <img src="https://cdn-icons-png.flaticon.com/512/684/684809.png" alt="location" class="w-4 h-4 mr-1">
            <a href="#" class="text-teal-600 dark:text-teal-400 text-sm" onclick="useCurrentLocation()">Use current location</a>
          </div>

          <div class="map-link mt-2">
            <a href="#" class="text-teal-600 dark:text-teal-400 text-sm" onclick="openMap()">Or set your location on the map</a>
          </div>
        </div>
        <div class="w-full h-36 col-start-2 row-start-2">
          <div id="map"></div>
        </div>
      </div>
    </section>

    <section class="bg-white py-20">
      <h2 class="text-3xl font-bold text-center mb-10">Top restaurants and more in TasteLogic</h2>
      <div class="flex justify-center space-x-6">
        <div class="flex flex-col items-center">
          <div class="rounded-full h-32 w-32 flex items-center justify-center bg-white-200 text-white-600 text-lg font-bold">NAIVAS</div>
          <img src="https://th.bing.com/th/id/OIP.xKDDSGHncQOQlwoXdHgNaQHaLH?pid=ImgDet&w=161&h=241&c=7" alt="Food" class="rounded-full h-20">
        </div>
        <div class="flex flex-col items-center">
          <div class="rounded-full h-32 w-32 flex items-center justify-center bg-white-200 text-white-600 text-lg font-bold">GAUCHO</div>
          <img src="https://2.bp.blogspot.com/-U27UrTwfm3Y/VFZ0YP2k1TI/AAAAAAAAcs8/XpkDQEdLUw8/s1600/1371226286-ribs-05.jpg" alt="" class="rounded-full h-20">
        </div>
        <div class="flex flex-col items-center">
          <div class="rounded-full h-32 w-32 flex items-center justify-center bg-white-200 text-white-600 text-lg font-bold">KFC</div> 
          <img src="https://st.depositphotos.com/12411398/60558/i/450/depositphotos_605581022-stock-photo-pruszcz-gdanski-poland-june-2022.jpg" alt="" class="rounded-full h-20">
        </div>
        <div class="flex flex-col items-center">
          <div class="rounded-full h-32 w-32 flex items-center justify-center bg-white-200 text-white-600 text-lg font-bold">ARTCAFE</div>
          <img src="https://media-cdn.tripadvisor.com/media/photo-s/18/22/c1/79/photo0jpg.jpg" alt="Groceries" class="rounded-full h-20">
        </div>
      </div>
    </section>

    <section class="bg-blue-400 py-20 text-center">
      <h2 class="text-3xl font-bold mb-10">Anything delivered</h2>
      <div class="flex justify-center space-x-10">
        <div class="w-1/3">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtIHuhnToJ805KLMvFl5CPc4wHqSGoaZdpdA&s" alt="Top restaurants" class="mx-auto mb-4">
          <h3 class="text-xl font-bold mb-2">Your city's top restaurants</h3>
          <p>Order from your favorite local restaurants.</p>
        </div>
        <div class="w-1/3">
          <img src="https://static.vecteezy.com/system/resources/thumbnails/005/261/209/small/fast-delivery-icon-free-vector.jpg" alt="Fast delivery" class="mx-auto mb-4">
          <h3 class="text-xl font-bold mb-2">Fast delivery</h3>
          <p>Get your orders delivered in minutes.</p>
        </div>
        <div class="w-1/3">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTU7KaCY2rovmQpwxyzPUmJUHpIU_bE-Pa7lwP3hZI3YGYfd8l1a4n36KAz6yJPmFW5Qo&usqp=CAU" alt="Groceries delivery & more" class="mx-auto mb-4">
          <h3 class="text-xl font-bold mb-2">Groceries delivery & more</h3>
          <p>Find anything you need from groceries to household items.</p>
        </div>
      </div>
      <button class="bg-teal-500 text-white px-6 py-3 rounded-lg mt-10" onclick="exploreStores()">Explore stores around you</button>
    </section>

    <section class="bg-yellow-400 py-20 text-center">
      <h2 class="text-3xl font-bold mb-10">Countries where we deliver</h2>
      <div class="flex flex-wrap justify-center space-x-4">
        <span class="bg-black px-4 py-2 rounded-lg mb-4">KENYA</span>
        <span class="bg-white px-4 py-2 rounded-lg mb-4">UGANDA</span>
        <span class="bg-white px-4 py-2 rounded-lg mb-4">TANZANIA</span>
        <span class="bg-white px-4 py-2 rounded-lg mb-4">SOUTH AFRICA</span>
        <span class="bg-white px-4 py-2 rounded-lg mb-4">SEYCHELLES</span>
      </div>
    </section>

    <section class="bg-teal-100 py-20 text-center">
      <h2 class="text-3xl font-bold mb-10">Let's do it together</h2>
      <div class="flex justify-center space-x-10">

        <div class="w-1/3">
          <img src="https://placehold.co" alt="Become a partner" class="mx-auto mb-4 rounded-full">
          <h3 class="text-xl font-bold mb-2">Become a partner</h3>
          <p>Grow with TasteLogic's technology and user base.</p>
          <button class="bg-teal-500 text-white px-6 py-3 rounded-lg mt-4">Register here</button>
        </div>
        <div class="w-1/3">
          <img src="https://placehold.co" alt="Careers" class="mx-auto mb-4 rounded-full">
          <h3 class="text-xl font-bold mb-2">Careers</h3>
          <p>Join our team and help us build the future of food delivery.</p>
          <button class="bg-teal-500 text-white px-6 py-3 rounded-lg mt-4">Register here</button>
        </div>
      </div>
    </section>

    <footer class="bg-black text-white py-10">
      <div class="container mx-auto flex justify-between">
        <div>
          <h3 class="text-xl font-bold mb-4">Let's do it together</h3>
          <ul>
            <li class="mb-2"><a href="about.php" class="hover:underline">About Us</a></li>
            <li class="mb-2"><a href="home.php" class="hover:underline">HOME</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">Links of interest</h3>
          <ul>
            <li class="mb-2"><a href="privacy.php" class="hover:underline">Privacy Policy</a></li>
            <li class="mb-2"><a href="terms.php" class="hover:underline">Terms & Conditions</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">Follow us</h3>
          <ul class="flex space-x-4">
            <li><a href="https://www.facebook.com/tastelogic" target="_blank"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYfRZOfRyyDskFIvBevwSIXv7vDjxMRl7_Jg&s" alt="Instagram"></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </section>

  <script>
    let map;
    let marker;

    function initMap() {
      const mapOptions = {
        center: { lat: -1.2921, lng: 36.8219 }, // Default to Nairobi, Kenya
        zoom: 12,
      };

      map = new google.maps.Map(document.getElementById('map'), mapOptions);

      marker = new google.maps.Marker({
        position: { lat: -1.2921, lng: 36.8219 }, // Default to Nairobi, Kenya
        map: map,
        draggable: true,
      });

      marker.addListener('dragend', function() {
        const lat = marker.getPosition().lat();
        const lng = marker.getPosition().lng();
        console.log(`Marker dragged to: Lat ${lat}, Lng ${lng}`);
      });
    }

    function useCurrentLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          const userLatLng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          map.setCenter(userLatLng);
          marker.setPosition(userLatLng);
        }, function() {
          alert('Error: The Geolocation service failed.');
        });
      } else {
        alert('Error: Your browser doesn\'t support geolocation.');
      }
    }

    function openMap() {
      // Implement logic to open a full-screen map or integrate with a mapping service
      alert('Open map functionality goes here.');
    }
  </script>

</body>
</html>
