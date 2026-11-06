// CPIT-405 - Lab 7: XMLHttpRequest, fetch with promises, and async/await.
// Unsplash search API: https://api.unsplash.com/search/photos

const searchInput = document.getElementById("search-input");
const gallery = document.getElementById("gallery");
const message = document.getElementById("message");
let accessKey = "";

// These Unsplash pictures reproduce the example's initial Makkah photo grid.
// A search replaces them with live results returned by the Unsplash API.
const examplePhotos = [
    { urls: { small: "https://images.unsplash.com/photo-1722450679078-42a608312c2f?auto=format&fit=crop&w=480&q=75" }, alt_description: "Makkah Clock Tower" },
    { urls: { small: "https://images.unsplash.com/photo-1578897626389-6fae2c54c21e?auto=format&fit=crop&w=480&q=75" }, alt_description: "Masjid al-Haram interior" },
    { urls: { small: "https://images.unsplash.com/photo-1704104501136-8f35402af395?auto=format&fit=crop&w=480&q=75" }, alt_description: "Makkah Clock Tower and Kaaba" },
    { urls: { small: "https://images.unsplash.com/photo-1565552645632-d725f8bfc19a?auto=format&fit=crop&w=480&q=75" }, alt_description: "Makkah skyline" },
    { urls: { small: "https://images.unsplash.com/photo-1721912489841-765be5c3c7e3?auto=format&fit=crop&w=480&q=75" }, alt_description: "Clock tower in Makkah" },
    { urls: { small: "https://images.unsplash.com/photo-1574659671082-9173440e9f88?auto=format&fit=crop&w=480&q=75" }, alt_description: "Pilgrims in Makkah" },
    { urls: { small: "https://images.unsplash.com/photo-1565828480412-f95f33fe9e70?auto=format&fit=crop&w=480&q=75" }, alt_description: "Makkah Clock Tower under the sky" },
    { urls: { small: "https://images.unsplash.com/photo-1720549973451-018d3623b55a?auto=format&fit=crop&w=480&q=75" }, alt_description: "Kaaba and Makkah Clock Tower" }
];

// DOM API: build an image element for each item in the API's results array.
function showPhotos(photos) {
    gallery.innerHTML = "";

    for (let i = 0; i < photos.length; i++) {
        const image = document.createElement("img");
        image.src = photos[i].urls.small;
        image.alt = photos[i].alt_description || "Unsplash photo";
        gallery.appendChild(image);
    }
}

function showMessage(text) {
    message.innerText = text;
    message.hidden = false;
}

function clearMessage() {
    message.innerText = "";
    message.hidden = true;
}

// Ask for a key at search time; never commit an Access Key to a public repo.
function getAccessKey() {
    if (!accessKey) {
        const enteredKey = prompt("Enter your Unsplash Access Key to search photos:");
        if (enteredKey) {
            accessKey = enteredKey.trim();
        }
    }

    if (!accessKey) {
        showMessage("An Unsplash Access Key is required to search photos.");
        return "";
    }

    return accessKey;
}

function getSearchDetails() {
    const keyword = searchInput.value.trim();

    if (keyword === "") {
        showMessage("Please enter a word to search for photos.");
        return null;
    }

    const key = getAccessKey();
    if (!key) {
        return null;
    }

    clearMessage();
    return {
        url: "https://api.unsplash.com/search/photos?query=" + encodeURIComponent(keyword) + "&per_page=8",
        key: key
    };
}

function showResults(data) {
    if (data.results) {
        showPhotos(data.results);
        if (data.results.length === 0) {
            showMessage("No images found.");
        }
    } else {
        showMessage("The API did not return photo results.");
    }
}

function showRequestError(status) {
    if (status === 401 || status === 403) {
        accessKey = "";
        showMessage("Unsplash rejected the Access Key. Try searching again with a valid key.");
    } else {
        showMessage("Unable to fetch photos. Error: " + status);
    }
}

// Method 1: XMLHttpRequest (XHR)
function searchUsingXHR() {
    const details = getSearchDetails();
    if (!details) return;

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                showResults(JSON.parse(xhr.responseText));
            } else {
                showRequestError(xhr.status);
            }
        }
    };
    xhr.open("GET", details.url, true);
    xhr.setRequestHeader("Authorization", "Client-ID " + details.key);
    xhr.send();
}

// Method 2: fetch with promises (.then and .catch)
function searchUsingPromises() {
    const details = getSearchDetails();
    if (!details) return;

    fetch(details.url, {
        headers: { Authorization: "Client-ID " + details.key }
    })
        .then(function (response) {
            if (!response.ok) {
                throw new Error(response.status);
            }
            return response.json();
        })
        .then(function (data) {
            showResults(data);
        })
        .catch(function (error) {
            showRequestError(Number(error.message) || 0);
        });
}

// Method 3: fetch with async/await
async function searchUsingAsyncAwait() {
    const details = getSearchDetails();
    if (!details) return;

    try {
        const response = await fetch(details.url, {
            headers: { Authorization: "Client-ID " + details.key }
        });
        if (!response.ok) {
            throw new Error(response.status);
        }
        const data = await response.json();
        showResults(data);
    } catch (error) {
        showRequestError(Number(error.message) || 0);
    }
}

// Mouse click events for the three buttons.
document.getElementById("xhr-button").addEventListener("click", searchUsingXHR);
document.getElementById("promises-button").addEventListener("click", searchUsingPromises);
document.getElementById("async-button").addEventListener("click", searchUsingAsyncAwait);

// Keyboard event: press Enter in the search field.
document.getElementById("search-form").addEventListener("submit", function (event) {
    event.preventDefault();
    searchUsingAsyncAwait();
});

// Initial display follows the screenshot; API searches use live Unsplash results.
showPhotos(examplePhotos);
