console.log("Hello, World!");
document.addEventListener("DOMContentLoaded", function() {
    const luasForm = document.getElementById("luas-form");
    const kelilingForm = document.getElementById("keliling-form");
    const luasResult = document.getElementById("luas-result");
    const kelilingResult = document.getElementById("keliling-result");


    if (luasForm) {
        luasForm.addEventListener("submit", function(event) {
            const alas = parseFloat(document.getElementById("alas").value);
            const tinggi = parseFloat(document.getElementById("tinggi").value);


            if (alas < 2 || alas > 300 || tinggi < 2 || tinggi > 300) {
                alert("Alas dan tinggi harus berada dalam rentang 2 hingga 300.");
                event.preventDefault();
                return;
            }




            let scale;
            if (alas >= 2 && alas <= 50) {
                scale = 5.4;
            } else if (alas >= 51 && alas <= 100) {
                scale = 2.8;
            } else {
                scale = 1.2;
            }

            fetch('/hitung-luas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ alas, tinggi })
                })
                .then(response => response.json())
                .then(data => {
                    luasResult.textContent = `Luas: ${data.luas}`;

                    const segitigaLuas = document.getElementById("segitiga-luas");
                    const s = alas * scale;
                    const height = (Math.sqrt(3) / 2) * s;


                    const centerX = 150;
                    const centerY = 150;
                    const points = `${centerX},${centerY - (height / 2)} ${centerX - (s / 2)},${centerY + (height / 2)} ${centerX + (s / 2)},${centerY + (height / 2)}`;
                    segitigaLuas.querySelector("#polygon").setAttribute("points", points);


                    const lineTinggi = segitigaLuas.querySelector("#line-tinggi");
                    lineTinggi.setAttribute("x1", centerX);
                    lineTinggi.setAttribute("y1", centerY - (height / 2));
                    lineTinggi.setAttribute("x2", centerX);
                    lineTinggi.setAttribute("y2", centerY + (height / 2));
                    lineTinggi.setAttribute("stroke", "red");
                    lineTinggi.setAttribute("stroke-width", "2");


                    const lineAlas = segitigaLuas.querySelector("#line-alas");
                    lineAlas.setAttribute("x1", centerX - (s / 2));
                    lineAlas.setAttribute("y1", centerY + (height / 2));
                    lineAlas.setAttribute("x2", centerX + (s / 2));
                    lineAlas.setAttribute("y2", centerY + (height / 2));
                    lineAlas.setAttribute("stroke", "red");
                    lineAlas.setAttribute("stroke-width", "2");


                    const labelAlas = segitigaLuas.querySelector("#label-alas");
                    labelAlas.setAttribute("x", centerX);
                    labelAlas.setAttribute("y", centerY + (height / 2) + 20);
                    labelAlas.textContent = "Alas: " + alas;


                    const labelTinggiValue = segitigaLuas.querySelector("#label-tinggi-value");
                    labelTinggiValue.setAttribute("x", centerX + 35);
                    labelTinggiValue.setAttribute("y", centerY - (height / 3.5) + 55);
                    labelTinggiValue.textContent = "Tinggi: " + tinggi;
                })
                .catch(error => console.error('Error:', error));
        });
    }



    if (kelilingForm) {
        kelilingForm.addEventListener("submit", function(event) {
            const sisi1 = parseFloat(document.getElementById("sisi1").value);
            const sisi2 = parseFloat(document.getElementById("sisi2").value);
            const sisi3 = parseFloat(document.getElementById("sisi3").value);


            if (sisi1 < 2 || sisi1 > 300 || sisi2 < 2 || sisi2 > 300 || sisi3 < 2 || sisi3 > 300) {
                alert("Semua sisi harus berada dalam rentang 2 hingga 300.");
                event.preventDefault();
                return;
            }


            fetch('/hitung-keliling', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ sisi1, sisi2, sisi3 })
                })
                .then(response => response.json())
                .then(data => {
                    kelilingResult.textContent = `Keliling: ${data.keliling}`;


                    const segitigaKeliling = document.getElementById("segitiga-keliling");
                    const scale = 3.2;


                    const pointA = { x: 150, y: 100 };


                    const pointB = {
                        x: pointA.x - (sisi2 * scale),
                        y: pointA.y + (sisi3 * scale)
                    };

                    const pointC = {
                        x: pointA.x + (sisi1 * scale),
                        y: pointA.y + (sisi3 * scale)
                    };


                    const points = `${pointA.x},${pointA.y} ${pointB.x},${pointB.y} ${pointC.x},${pointC.y}`;
                    segitigaKeliling.querySelector("#polygon-keliling").setAttribute("points", points);


                    const labelSudutA = segitigaKeliling.querySelector("#label-sudut-a");
                    labelSudutA.setAttribute("x", pointA.x);
                    labelSudutA.setAttribute("y", pointA.y - 10);
                    labelSudutA.textContent = "A";


                    const labelSudutB = segitigaKeliling.querySelector("#label-sudut-b");
                    labelSudutB.setAttribute("x", pointB.x);
                    labelSudutB.setAttribute("y", pointB.y + 15);
                    labelSudutB.textContent = "B";


                    const labelSudutC = segitigaKeliling.querySelector("#label-sudut-c");
                    labelSudutC.setAttribute("x", pointC.x);
                    labelSudutC.setAttribute("y", pointC.y + 15);
                    labelSudutC.textContent = "C";

                })
                .catch(error => console.error('Error:', error));
        });
    }
});

function updateLuasHistoryTable() {
    fetch('/histories?type=luas')
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById("luas-history");
            table.innerHTML = `
                <tr>
                    <th>Alas</th>
                    <th>Tinggi</th>
                    <th>Luas</th>
                    <th>Waktu Ditambahkan</th>
                </tr>`;
            data.forEach(history => {
                const row = table.insertRow();
                row.insertCell(0).innerText = history.alas;
                row.insertCell(1).innerText = history.tinggi;
                row.insertCell(2).innerText = history.result;
                row.insertCell(3).innerText = history.created_at;
            });
        });
}

function updateKelilingHistoryTable() {
    fetch('/histories?type=keliling')
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById("keliling-history");
            table.innerHTML = `
                <tr>
                    <th>Sisi AC</th>
                    <th>Sisi AB</th>
                    <th>Sisi BC</th>
                    <th>Keliling</th>
                    <th>Waktu Ditambahkan</th>
                </tr>`;
            data.forEach(history => {
                const row = table.insertRow();
                row.insertCell(0).innerText = history.sisi_ac;
                row.insertCell(1).innerText = history.sisi_ab;
                row.insertCell(2).innerText = history.sisi_bc;
                row.insertCell(3).innerText = history.result;
                row.insertCell(4).innerText = history.created_at;
            });
        });
}