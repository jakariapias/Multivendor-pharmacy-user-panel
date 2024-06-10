<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="navArea position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section style="min-height:458px">
        <div class="container">
            <div class="row p-3 pt-4 ">
                <div class="col-md-12">
                    <div class="mb-2">
                        <input type="text" class="d-none"
                            value='<?= isset($_SESSION['userLatitude']) ? $_SESSION['userLatitude'] : null ?>'
                            id="userLat">
                        <input type="text" class="d-none"
                            value='<?= isset($_SESSION['userLongitude']) ? $_SESSION['userLongitude'] : null ?>'
                            id="userLong">

                        <button type="button" class="btn btn-primary" data-mdb-ripple-init
                            onclick="handleClickSearchNearestPharmacy()" style="font-size:18px"><i
                                class="fa-brands fa-searchengin me-1"></i>Nearest Pharmacy</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row input-group g-0">
                        <div class="col-md-2 mb-2">
                            <select class="form-select" aria-label="Default select example" id="searchOption">
                                <option selected>Select Option</option>
                                <option value="type_medicine">Search by Medicine</option>
                                <option value="type_pharmacy">Search Pharmacy</option>

                            </select>
                        </div>
                        <div class="col-md-9 mb-2"><input type="search" class="form-control rounded"
                                placeholder="Search" aria-label="Search" aria-describedby="search-addon"
                                id="searchInput" /></div>
                        <div class="col-md-1 mb-2">
                            <button type="button" class="btn btn-outline-primary w-100" data-mdb-ripple-init
                                onclick="handleClickSearch()">search</button>
                        </div>
                    </div>
                </div>
                <div id="map" class="d-none"></div>
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center align-items-center mt-1">
                                <div style="display: none; text-align:center " id="loadingSpinner">
                                    <!-- Add this wherever you want the spinner to appear -->
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>

                                    </div>
                                    <p>Loading...</p>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="row" id="searchResult">

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <!-- leaflet routing machine js file link -->
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

        <script>
            const userLat = parseFloat($('#userLat').val());
            const userLong = parseFloat($('#userLong').val());

            // Assuming you have a Leaflet map instance
            var map = L.map('map');



            const showLoadingMessage = () => {
                const loadingSpinner = document.getElementById('loadingSpinner');
                loadingSpinner.style.display = 'block';
            };

            const hideLoadingMessage = () => {
                const loadingSpinner = document.getElementById('loadingSpinner');
                loadingSpinner.style.display = 'none';
            };

            const handleClickSearchNearestPharmacy = async () => {
                try {
                    showLoadingMessage();
                    const data = await $.ajax({
                        url: "php_backend/search/search-nearest-pharmacy.php",
                        method: "POST",
                        data: {
                            userLat: userLat,
                            userLong: userLong,
                        },
                    });

                    const resultData = JSON.parse(data);

                    if (resultData.isSuccess) {
                        const resultedPharmacyList = resultData.data.resultData;
                        console.log(resultedPharmacyList);

                        // Wait for distance calculations to complete
                        const newPharmacyList = await getRouteDistance(resultedPharmacyList);
                        showNearestPharmacy(resultedPharmacyList);
                    }
                    else {
                        if (resultData.data.hasOwnProperty("error")) {

                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        }
                        else {

                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No pharmacy has been found!",
                            });
                        }
                    }



                } catch (error) {
                    showLoadingMessage();
                    console.error("Error fetching data:", error);
                }
            };

            const handleClickSearch = async (customSearchOpt, customSearchData) => {
                const searchOption = customSearchOpt ? customSearchOpt : $('#searchOption').val();
                const searchData = customSearchData ? customSearchData : $('#searchInput').val();
                const isLoggedIn = localStorage.getItem('loggedInData');
                console.log(isLoggedIn);

                const postData = {
                    searchData: searchData,
                    searchOption: searchOption
                };
                try {
                    showLoadingMessage();
                    if (isLoggedIn) {
                        if (userLat != 0 && userLong != 0) {
                            const data = await $.ajax({
                                url: "php_backend/search/searchCode.php",
                                method: "POST",
                                data: postData,
                            });

                            const resultData = JSON.parse(data);


                            if (resultData.isSuccess) {
                                const resultedPharmacyList = resultData.data.resultData;

                                // Wait for distance calculations to complete
                                const newPharmacyList = await getRouteDistance(resultedPharmacyList);
                                showNearestPharmacy(resultedPharmacyList, searchData, searchOption);
                            }
                            else {
                                hideLoadingMessage();
                                if (searchOption == "type_medicine") {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "No pharmacy has been found that sells this " + searchData + " !",
                                    });
                                }
                                else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: resultData.message,
                                    });
                                }


                            }
                        }
                        else {
                            Swal.fire({
                                icon: "error",
                                title: "Location error!",
                                text: "User location has not given yet!",
                                footer: 'Please set your location in your profile.'
                            });
                        }

                    }
                    else {
                        // Redirect to another PHP page
                        window.location.href = 'http://localhost/medicinesystem/online-medicine-system/login.php';
                    }


                } catch (error) {
                    console.log(error)

                    hideLoadingMessage();
                    Swal.fire({
                        icon: "error",
                        title: "Check your profile!",
                        text: "Set your location if it is not set yet!",
                    });



                }
            };

            const showNearestPharmacy = (newPharmacyList, searchData, searchOption) => {

                // Sorting the array based on the 'distance' property
                newPharmacyList.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));

                const cardParent = document.getElementById('searchResult');
                clearDiv(cardParent);
                // Create a new div element
                const cardContainer = document.createElement('div');
                cardContainer.className = 'col-md-12 pt-1';
                // Create the card structure
                cardContainer.innerHTML = searchOption == "type_medicine" ? `<h5>Showing pharmacy list which sell ${searchData} </h5>` : searchData ? `<h5>Showing pharmacy search result for: ${searchData} </h5>` : `<h5>Nearest pharmacy list </h5>`
                // Append the new card to the container
                cardParent.appendChild(cardContainer);


                newPharmacyList.forEach(element => {
                    createShopCard(element, cardParent, searchData, searchOption);
                });
                hideLoadingMessage();
            }

            const getRouteDistance = async (objectArray) => {
                // Use Promise.all to await all distance calculations in parallel
                await Promise.all(objectArray.map(async function (element) {
                    if (userLat != 0 && userLong != 0 && element.latitude != 0 && element.longitude != 0) {
                        var start = L.latLng(userLat, userLong);
                        var end = L.latLng(parseFloat(element.latitude), parseFloat(element.longitude));

                        var control = L.Routing.control({
                            waypoints: [start, end],
                        });

                        // Promisify the routing control event
                        const routeSelectedPromise = new Promise((resolve) => {
                            control.on('routeselected', function (event) {
                                var route = event.route;
                                var distance = route.summary.totalDistance;
                                element.distance = (distance / 1000).toFixed(2);
                                resolve();
                            });
                        });

                        control.addTo(map);

                        // Wait for the routeSelectedPromise to complete
                        await routeSelectedPromise;

                    }


                }));

                return objectArray;
            };

            const createShopCard = (cardData, cardParent, searchData, searchOption) => {

                // Sample data
                const imgSrc = "../pipharm-admin-panel/assets/images/store/banner/" + cardData.shopImage;
                const shopName = cardData.shopName;
                const address = cardData.address;
                const distance = cardData.distance;
                const shopId = cardData.id;
                let href;
                if (searchData) {
                    if (searchOption == 'type_medicine') {
                        href = `shop.php?id=${shopId}&medicine_name=${searchData}`;
                    }
                    else {
                        href = `shop.php?id=${shopId}`;
                    }

                }
                else {
                    href = `shop.php?id=${shopId}`;
                }

                // Create a new div element
                const cardContainer = document.createElement('div');
                cardContainer.className = 'col-md-3 pt-3';

                // Create the card structure
                cardContainer.innerHTML = `
                        <div class="card shadow rounded-4" style="width:100%;">
                            <div class="p-3" style="background-color:#f2f2f2;">
                                <img src="${imgSrc}" class="card-img-top" style="height:180px;" alt="..." onerror="this.src='assets/img/default.jpg'">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center">${shopName}</h5>
                                <div>
                                    <div class="my-1">
                                        <p class="text-center">
                                            ${Array.from({ length: 5 }, (_, i) => `<i class="fa-regular fa-star"></i>`).join('')}
                                        </p>
                                        <div class="d-flex align-items-center" style="height:50px">
                                            <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i></div>
                                            <small>${address && address != " " ? address : "N/A"}</small>
                                        </div>
                                        <div class="d-flex align-items-center" style="height:50px">
                                            <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i></div>
                                            <small>Distance: ${distance ? distance + "km" : "location is not added"}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center border-top">
                                    <a href=${href} style="color:#022314">Visit <i class="fa-solid fa-arrow-right ps-1"></i></a>
                                </div>
                            </div>
                        </div>
                    `;

                // Append the new card to the container
                cardParent.appendChild(cardContainer);
            }
            const clearDiv = (div) => {
                div.innerHTML = '';
            }

            $(document).ready(function () {
                const urlParams = new URLSearchParams(window.location.search);
                const searchedMedicine = urlParams.get('medicine_name'); // Gets the value of param1

                if (searchedMedicine) {
                    $('#searchOption').val("type_medicine");
                    $('#searchInput').val(searchedMedicine)
                    handleClickSearch("type_medicine", searchedMedicine)
                }

            });



        </script>



    </section>




    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>


</body>

</html>