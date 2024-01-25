let addressData;

// Load JSON Data
fetch('nepal_location.json')
    .then(response => response.json())
    .then(data => {
        addressData = data;
        console.log('JSON Data loaded:', addressData); // Add this line to log the loaded JSON data
        populateProvinces();
    })
    .catch(error => console.error('Error loading JSON:', error));

// Populate Provinces
function populateProvinces() {
    const provinceSelect = document.getElementById('province');
    addressData.provinceList.forEach(province => {
        provinceSelect.options[provinceSelect.options.length] = new Option(province.name, province.id);
    });
    console.log('Provinces populated:', provinceSelect.options); // Add this line to log populated provinces
}
// Populate Districts
function populateDistricts() {
    const selectedProvinceId = document.getElementById('province').value;
    console.log('Selected Province ID:', selectedProvinceId); // Add this line to log the selected province ID
    const districtSelect = document.getElementById('district');
    districtSelect.innerHTML = '';

    const selectedProvince = addressData.provinceList.find(province => province.id.toString() === selectedProvinceId);
    console.log('Selected Province:', selectedProvince); // Add this line to log the selected province
    selectedProvince.districtList.forEach(district => {
        districtSelect.options[districtSelect.options.length] = new Option(district.name, district.id);
    });
    console.log('Districts populated:', districtSelect.options); // Add this line to log populated districts
}

// Populate Municipalities
function populateMunicipalities() {
    const selectedDistrictId = document.getElementById('district').value;
    console.log('Selected District ID:', selectedDistrictId); // Add this line to log the selected district ID
    const municipalitySelect = document.getElementById('municipality');
    municipalitySelect.innerHTML = '';

    const selectedProvince = addressData.provinceList.find(province => province.districtList.some(district => district.id.toString() === selectedDistrictId));
    console.log('Selected Province:', selectedProvince); // Add this line to log the selected province
    const selectedDistrict = selectedProvince.districtList.find(district => district.id.toString() === selectedDistrictId);
    console.log('Selected District:', selectedDistrict); // Add this line to log the selected district
    selectedDistrict.municipalityList.forEach(municipality => {
        municipalitySelect.options[municipalitySelect.options.length] = new Option(municipality.name, municipality.id);
    });
    console.log('Municipalities populated:', municipalitySelect.options); // Add this line to log populated municipalities
}
