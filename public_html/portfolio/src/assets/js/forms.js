setTimeout(function(){
        var responseMessage = document.getElementById('responseMessage');
        responseMessage.style.display = 'none';
    }, 5000);


document.addEventListener("DOMContentLoaded", function () {
    // Load country codes from JSON file
    fetch("../config/CountryCodes.json")
        .then((response) => response.json())
        .then((countryCodes) => {
            const countryCodeSelect = document.getElementById("country_code");
            const dialCodeInput = document.getElementById("dial_code");
            const phoneInput = document.getElementById("phone");

            // Populate the select element with country codes
            countryCodes.forEach((country) => {
                const option = document.createElement("option");
                option.value = country.dial_code;
                option.text = `${country.name} (${country.dial_code})`;
                countryCodeSelect.appendChild(option);
            });

            // Update the dial_code and placeholder based on the selected country
            countryCodeSelect.addEventListener("change", function () {
                const selectedCountry = countryCodes.find(
                    (country) => country.dial_code === this.value
                );
                dialCodeInput.value = selectedCountry.dial_code;
                phoneInput.placeholder = `e.g. 123456789`;
            });
        })
        .catch((error) => console.error("Error loading country codes:", error));
});
