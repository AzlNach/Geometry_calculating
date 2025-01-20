<?php 
require_once('layouts/head.php');
require_once 'controller.php';

$message = '';
$luasHistory = getLuasHistory(); // Fungsi untuk mengambil data history dari database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'store') {
        $alas = $_POST['alas'];
        $tinggi = $_POST['tinggi'];

        $message = storeLuas($alas, $tinggi);
    } else if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $message = destroyLuas($id);
    }
    $luasHistory = getLuasHistory();
}
?>

<section>
<?php if ($message): ?>
<div class="alert alert-info" role="alert">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<link rel="stylesheet" href="css/content.css">

    <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Hitung Luas Segitiga</h1>
            <button id="history-button" class="btn btn-info">History</button>
        
    </div>
    <form id="luas-form" action="luasindex.php" method="POST">
        <input type="hidden" name="action" value="store">
        <label for="alas">Alas:</label>
        <input type="number" id="alas" name="alas" min="2" max="300" required>
        <label for="tinggi">Tinggi:</label>
        <input type="number" id="tinggi" name="tinggi" min="2" max="300" required>
        <button type="submit" id="luas-submit">Hitung Luas</button>
    </form>
    <p id="luas-result"></p>
    <svg id="segitiga-luas" width="300" height="300" style="border: 1px solid black; display: block; margin: 0 auto;">
        <polygon id="polygon" points="150,10 100,250 200,250" fill="lightblue" stroke="black" />
        <line id="line-tinggi" stroke="red" stroke-width="2" />
        <line id="line-alas" stroke="red" stroke-width="2" />
        <text id="label-alas" fill="black" font-size="14" text-anchor="middle" />
        <text id="label-tinggi" fill="black" font-size="14" text-anchor="middle" />
        <text id="label-tinggi-value" fill="black" font-size="14" text-anchor="middle" />
    </svg>
</section>
    
<link rel="stylesheet" href="css/popup.css">


<div class="modal fade" id="editluasModal" tabindex="-1" aria-labelledby="editluasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editluasModalLabel">History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Alas</th>
                        <th>Tinggi</th>
                        <th>Result</th>
                        <th>Ditambah Pada</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($luasHistory)): ?>
                        <?php foreach ($luasHistory as $luas): ?>
                        <tr>
                            <td><?php echo $luas['alas']; ?></td>
                            <td><?php echo $luas['tinggi']; ?></td>
                            <td><?php echo $luas['result']; ?></td>
                            <td><?php echo $luas['created_at']; ?></td>
                            <td>
                                <a href="luasshow.php?id=<?php echo $luas['id']; ?>" class="btn btn-warning">Pilih</a>
                                <form action="luasindex.php" method="POST" class="delete-form d-inline">
                                    <input type="hidden" name="id" value="<?php echo $luas['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const luasForm = document.getElementById("luas-form");
    const luasResult = document.getElementById("luas-result");

    // Event listener untuk menghitung luas
    if (luasForm) {
        luasForm.addEventListener("submit", function(event) {
            const alas = parseFloat(document.getElementById("alas").value);
            const tinggi = parseFloat(document.getElementById("tinggi").value);

            // Validasi rentang input
            if (alas < 2 || alas > 300 || tinggi < 2 || tinggi > 300) {
                alert("Alas dan tinggi harus berada dalam rentang 2 hingga 300.");
                event.preventDefault(); // Mencegah pengiriman formulir
                return;
            }

            // Menentukan skala berdasarkan rentang input
            let scale;
            if (alas >= 2 && alas <= 50) {
                scale = 5.4;
            } else if (alas >= 51 && alas <= 100) {
                scale = 2.8;
            } else {
                scale = 1.2;
            }
            const luas = alas * tinggi / 2;

            // Menghitung luas segitiga

            luasResult.textContent = `Luas: ${luas}`;
            // Menggambar segitiga sama sisi berdasarkan panjang sisi
            const segitigaLuas = document.getElementById("segitiga-luas");
            const s = alas * scale; // Mengatur skala untuk visualisasi
            const height = (Math.sqrt(3) / 2) * s; // Tinggi segitiga sama sisi

            // Menghitung titik-titik segitiga
            const centerX = 150; // Pusat horizontal dari SVG
            const centerY = 150; // Pusat vertikal dari SVG
            const points = `${centerX},${centerY - (height / 2)} ${centerX - (s / 2)},${centerY + (height / 2)} ${centerX + (s / 2)},${centerY + (height / 2)}`;
            segitigaLuas.querySelector("#polygon").setAttribute("points", points);

            // Menambahkan garis tinggi
            const lineTinggi = segitigaLuas.querySelector("#line-tinggi");
            lineTinggi.setAttribute("x1", centerX); // Titik atas segitiga
            lineTinggi.setAttribute("y1", centerY - (height / 2)); // Titik atas segitiga
            lineTinggi.setAttribute("x2", centerX); // Titik bawah segitiga
            lineTinggi.setAttribute("y2", centerY + (height / 2)); // Titik bawah segitiga
            lineTinggi.setAttribute("stroke", "red"); // Warna garis tinggi
            lineTinggi.setAttribute("stroke-width", "2");

            // Menambahkan garis alas
            const lineAlas = segitigaLuas.querySelector("#line-alas");
            lineAlas.setAttribute("x1", centerX - (s / 2)); // Titik kiri alas
            lineAlas.setAttribute("y1", centerY + (height / 2)); // Titik kiri alas
            lineAlas.setAttribute("x2", centerX + (s / 2)); // Titik kanan alas
            lineAlas.setAttribute("y2", centerY + (height /  2)); // Titik kanan alas
            lineAlas.setAttribute("stroke", "red"); // Warna garis alas
            lineAlas.setAttribute("stroke-width", "2");

            // Menambahkan label alas
            const labelAlas = segitigaLuas.querySelector("#label-alas");
            labelAlas.setAttribute("x", centerX); // Posisi horizontal
            labelAlas.setAttribute("y", centerY + (height / 2) + 20); // Posisi vertikal
            labelAlas.textContent = "Alas: " + alas;

            // Menambahkan label pada garis tinggi
            const labelTinggiValue = segitigaLuas.querySelector("#label-tinggi-value");
            labelTinggiValue.setAttribute("x", centerX + 35); // Posisi horizontal
            labelTinggiValue.setAttribute("y", centerY - (height / 3.5) +55); // Posisi vertikal
            labelTinggiValue.textContent ="Tinggi: " + tinggi; // Menampilkan nilai tinggi
        
        });
    }

});
</script>
<script src="js/script.js"></script>
<script>
$(document).ready(function() {
    $('#history-button').on('click', function() {
        $('#editluasModal').modal('show');
    });
    $('.btn-close, .btn-secondary').on('click', function() {
        $('#editluasModal').modal('hide');
    });
});
</script>
<?php 
require_once('layouts/foot.php');
?>
