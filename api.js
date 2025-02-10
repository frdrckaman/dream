fetch("https://192.168.100.106/penplus-edc/api.php")
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
        console.log(data); // Use the data
    })
    .catch(error => console.error("Error:", error));
