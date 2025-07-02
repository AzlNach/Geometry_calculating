// Function to initialize the unit converter
function initUnitConverter() {
    // Get DOM elements
    const conversionType = document.getElementById('conversion-type');
    const fromValue = document.getElementById('from-value');
    const fromUnit = document.getElementById('from-unit');
    const toUnit = document.getElementById('to-unit');
    const result = document.getElementById('conversion-result');

    // Check if all required elements exist
    if (!conversionType || !fromValue || !fromUnit || !toUnit || !result) {
        // Elements not found, likely not on this page
        return;
    }

    // Define unit conversion factors relative to base units
    const conversionFactors = {
        length: {
            m: 1, // meter (base unit)
            cm: 0.01, // centimeter
            mm: 0.001, // millimeter
            km: 1000, // kilometer
            in: 0.0254, // inch
            ft: 0.3048, // foot
            yd: 0.9144, // yard
            mi: 1609.34 // mile
        },
        area: {
            m2: 1, // square meter (base unit)
            cm2: 0.0001, // square centimeter
            mm2: 0.000001, // square millimeter
            km2: 1000000, // square kilometer
            ha: 10000, // hectare
            in2: 0.00064516, // square inch
            ft2: 0.092903, // square foot
            ac: 4046.86 // acre
        },
        volume: {
            m3: 1, // cubic meter (base unit)
            cm3: 0.000001, // cubic centimeter
            mm3: 1e-9, // cubic millimeter
            l: 0.001, // liter
            ml: 0.000001, // milliliter
            gal: 0.003785, // US gallon
            qt: 0.000946, // US quart
            pt: 0.000473 // US pint
        },
        weight: {
            kg: 1, // kilogram (base unit)
            g: 0.001, // gram
            mg: 0.000001, // milligram
            t: 1000, // metric ton
            lb: 0.453592, // pound
            oz: 0.0283495, // ounce
            st: 6.35029 // stone
        }
    };

    // Display names for units
    const unitDisplayNames = {
        length: {
            m: "Meters (m)",
            cm: "Centimeters (cm)",
            mm: "Millimeters (mm)",
            km: "Kilometers (km)",
            in: "Inches (in)",
            ft: "Feet (ft)",
            yd: "Yards (yd)",
            mi: "Miles (mi)"
        },
        area: {
            m2: "Square Meters (m²)",
            cm2: "Square Centimeters (cm²)",
            mm2: "Square Millimeters (mm²)",
            km2: "Square Kilometers (km²)",
            ha: "Hectares (ha)",
            in2: "Square Inches (in²)",
            ft2: "Square Feet (ft²)",
            ac: "Acres (ac)"
        },
        volume: {
            m3: "Cubic Meters (m³)",
            cm3: "Cubic Centimeters (cm³)",
            mm3: "Cubic Millimeters (mm³)",
            l: "Liters (L)",
            ml: "Milliliters (mL)",
            gal: "Gallons (gal)",
            qt: "Quarts (qt)",
            pt: "Pints (pt)"
        },
        weight: {
            kg: "Kilograms (kg)",
            g: "Grams (g)",
            mg: "Milligrams (mg)",
            t: "Metric Tons (t)",
            lb: "Pounds (lb)",
            oz: "Ounces (oz)",
            st: "Stone (st)"
        }
    };

    // Function to update unit select options based on conversion type
    function updateUnitOptions() {
        const type = conversionType.value;
        const units = conversionFactors[type];

        // Clear current options
        fromUnit.innerHTML = '';
        toUnit.innerHTML = '';

        // Add new options
        Object.keys(units).forEach(unit => {
            const displayName = unitDisplayNames[type][unit];

            // From unit options
            const fromOption = document.createElement('option');
            fromOption.value = unit;
            fromOption.textContent = displayName;
            fromUnit.appendChild(fromOption);

            // To unit options
            const toOption = document.createElement('option');
            toOption.value = unit;
            toOption.textContent = displayName;
            toUnit.appendChild(toOption);
        });

        // Set default selections
        const unitKeys = Object.keys(units);
        fromUnit.value = unitKeys[0]; // First unit
        toUnit.value = unitKeys[1] || unitKeys[0]; // Second unit or first if only one

        // Update the conversion
        updateConversion();
    }

    // Function to perform the conversion
    function updateConversion() {
        const type = conversionType.value;
        const value = parseFloat(fromValue.value);
        const from = fromUnit.value;
        const to = toUnit.value;

        if (isNaN(value) || value === '') {
            result.textContent = "Please enter a valid number";
            result.classList.remove('alert-info');
            result.classList.add('alert-warning');
            return;
        }

        // Get conversion factors
        const fromFactor = conversionFactors[type][from];
        const toFactor = conversionFactors[type][to];

        // Convert to base unit, then to target unit
        const valueInBaseUnit = value * fromFactor;
        const convertedValue = valueInBaseUnit / toFactor;

        // Format the result based on magnitude for better readability
        let formattedResult;
        if (convertedValue >= 1000000 || (convertedValue < 0.000001 && convertedValue !== 0)) {
            formattedResult = convertedValue.toExponential(6);
        } else {
            // Use a reasonable number of decimal places based on the value
            const decimalPlaces = convertedValue < 0.1 ? 6 :
                convertedValue < 1 ? 4 :
                convertedValue < 10 ? 3 :
                convertedValue < 100 ? 2 : 1;
            formattedResult = convertedValue.toFixed(decimalPlaces);

            // Remove trailing zeros
            formattedResult = parseFloat(formattedResult).toString();
        }

        // Get the display name for the unit
        const unitDisplay = unitDisplayNames[type][to].match(/\(([^)]+)\)/)[1];

        // Display the result
        result.textContent = `Result: ${formattedResult} ${unitDisplay}`;
        result.classList.remove('alert-warning', 'alert-danger');
        result.classList.add('alert-info');
    }

    // Add event listeners for real-time updates (sama seperti geometry calculator)
    conversionType.addEventListener('change', updateUnitOptions);
    fromValue.addEventListener('input', updateConversion);
    fromUnit.addEventListener('change', updateConversion);
    toUnit.addEventListener('change', updateConversion);

    // Initialize the form
    updateUnitOptions();
}

// Initialize when DOM is loaded (seperti pada geometry calculator)
document.addEventListener('DOMContentLoaded', function() {
    initUnitConverter();
});