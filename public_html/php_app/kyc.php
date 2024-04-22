<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/main.css">
	<script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
	<title>Customer KYC</title>
</head>

<body class="min-h-screen flex justify-center items-baseline mx-auto mt-16 bg-custom-gradient">
	<div class="flex flex-col justify-center w-1/2 bg-slate-200 box-border shadow-2xl p-4">

		<h1 class="text-center text-pink-700 text-3xl p-4">KYC</h1>

		<form class="flex flex-col space-y-4" method="post" action="">

			<div class="flex flex-col">
				<label class="">National Idententification Number (NIN)</label>
				<input type="text" inputmode="numeric" name="nin" required class=""/>
			</div>	

			<div class="flex flex-col">
				<label class="">Date of Birth</label>
				<input type="date" name="dob" required class=""/>
			</div>

			<div class="flex flex-col">
				<h2>Gender</h2>
				<div class="flex flex-row">
					<div class="">
						<label class="">Male</label>
						<input type="radio" name="gender" value="male" class="">
					</div>
					<div class="">
						<label class="">Female</label>
						<input type="radio" name="gender" value="female" class="">
					</div>
				</div>
			</div>
			<div class="flex flex-col">
				<label class="">Image</label>
				<input type="file" name="avatar" accept="image/png, image/jpeg" />
			</div>

			<div class="flex flex-col">
				<label class="">Address</label>
				<div class="flex flex-wrap">
					<input type="text" name="street" placeholder="Street" class=""/>
					<div class="flex">
						<input type="text" name="city" placeholder="City" class=""/>
						<input type="text" name="zip" placeholder="Postal Code" class=""/>
					</div>
					<div class="flex">
						<select id="countries" name="country">
							<option value="" disabled selected>Country</option>
							<?php
							$countriesData = json_decode(file_get_contents('config/countries.json'), true);

							foreach ($countriesData as $countryCode => $country)
							{
								echo '<option value="' . $countryCode . '">' . $country['name'] . '</option>';
							}
							?>
						</select>
						<select id="states" name="state">
							<option value="" disabled selected>State</option>
						</select>
					</div>
				</div>
			</div>

			<!-- Include the alerts.php file to display alerts -->
			<p> <?php include('alerts.php'); ?> </p>

			<div class="flex justify-center">
				<input style="font-family: FontAwesome" value="&#xf090;" type="submit" class="w-36 bg-purple-900 text-white font-bold py-2 px-4 w-full rounded-lg transition duration-300 hover:bg-pink-500 cursor-pointer">
			</div>
		</form>
	</div>

	<script>
		var countrySelect = document.getElementById('countries');
		var stateSelect = document.getElementById('states');

		var countriesData = <?php echo json_encode($countriesData); ?>;

    		// Event listener to update states based on selected country
    		countrySelect.addEventListener('change', function () {
      			var selectedCountry = countrySelect.value;
      			var states = countriesData[selectedCountry].states;

			// Clear existing options
			stateSelect.innerHTML = '';

			// Populate states dropdown
			for (var i = 0; i < states.length; i++) {
				var option = document.createElement('option');
				option.value = states[i];
				option.text = states[i];
				stateSelect.appendChild(option);
			}
    		});
  	</script>

</body>
</html>