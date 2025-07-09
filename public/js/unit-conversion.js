function initializeUnitConverter() {

    const conversionType = document.getElementById('conversion-type');
    const fromValue = document.getElementById('from-value');
    const fromUnit = document.getElementById('from-unit');
    const toUnit = document.getElementById('to-unit');
    const result = document.getElementById('conversion-result');


    if (!conversionType || !fromValue || !fromUnit || !toUnit || !result) {
        return;
    }


    const conversionFactors = {
        length: { m: 1, cm: 0.01, mm: 0.001, km: 1000, in: 0.0254, ft: 0.3048, yd: 0.9144, mi: 1609.34 },
        area: { m2: 1, cm2: 0.0001, mm2: 0.000001, km2: 1000000, ha: 10000, in2: 0.00064516, ft2: 0.092903, ac: 4046.86 },
        volume: { m3: 1, cm3: 0.000001, mm3: 1e-9, l: 0.001, ml: 0.000001, gal: 0.003785, qt: 0.000946, pt: 0.000473 },
        weight: { kg: 1, g: 0.001, mg: 0.000001, t: 1000, lb: 0.453592, oz: 0.0283495, st: 6.35029 }
    };


    const unitDisplayNames = {
        length: { m: "Meters (m)", cm: "Centimeters (cm)", mm: "Millimeters (mm)", km: "Kilometers (km)", in: "Inches (in)", ft: "Feet (ft)", yd: "Yards (yd)", mi: "Miles (mi)" },
        area: { m2: "Square Meters (m²)", cm2: "Square Centimeters (cm²)", mm2: "Square Millimeters (mm²)", km2: "Square Kilometers (km²)", ha: "Hectares (ha)", in2: "Square Inches (in²)", ft2: "Square Feet (ft²)", ac: "Acres (ac)" },
        volume: { m3: "Cubic Meters (m³)", cm3: "Cubic Centimeters (cm³)", mm3: "Cubic Millimeters (mm³)", l: "Liters (L)", ml: "Milliliters (mL)", gal: "Gallons (gal)", qt: "Quarts (qt)", pt: "Pints (pt)" },
        weight: { kg: "Kilograms (kg)", g: "Grams (g)", mg: "Milligrams (mg)", t: "Metric Tons (t)", lb: "Pounds (lb)", oz: "Ounces (oz)", st: "Stone (st)" }
    };


    function updateUnitOptions() {
        const type = conversionType.value;
        const units = conversionFactors[type];
        fromUnit.innerHTML = '';
        toUnit.innerHTML = '';
        Object.keys(units).forEach(unit => {
            const displayName = unitDisplayNames[type][unit];
            const fromOption = document.createElement('option');
            fromOption.value = unit;
            fromOption.textContent = displayName;
            fromUnit.appendChild(fromOption);
            const toOption = document.createElement('option');
            toOption.value = unit;
            toOption.textContent = displayName;
            toUnit.appendChild(toOption);
        });
        const unitKeys = Object.keys(units);
        fromUnit.value = unitKeys[0];
        toUnit.value = unitKeys[1] || unitKeys[0];
        updateConversion();
    }


    function updateConversion() {
        const type = conversionType.value;
        const value = parseFloat(fromValue.value);
        const from = fromUnit.value;
        const to = toUnit.value;
        if (isNaN(value) || value === '') {
            result.textContent = "Please enter a valid number";
            return;
        }
        const fromFactor = conversionFactors[type][from];
        const toFactor = conversionFactors[type][to];
        const valueInBaseUnit = value * fromFactor;
        const convertedValue = valueInBaseUnit / toFactor;
        let formattedResult = parseFloat(convertedValue.toPrecision(6)).toString();
        const unitDisplay = unitDisplayNames[type][to].match(/\(([^)]+)\)/)[1];
        result.textContent = `Result: ${formattedResult} ${unitDisplay}`;
    }


    conversionType.addEventListener('change', updateUnitOptions);
    fromValue.addEventListener('input', updateConversion);
    fromUnit.addEventListener('change', updateConversion);
    toUnit.addEventListener('change', updateConversion);


    updateUnitOptions();
}


initializeUnitConverter();