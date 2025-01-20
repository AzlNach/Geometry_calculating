<?php 
require_once 'layouts/head.php';
require_once 'controller.php';

$message = '';
$luas = null;

if (isset($_GET['id'])) {
    $luas = getLuasById($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $alas = $_POST['alas'];
    $tinggi = $_POST['tinggi'];
    $message = updateLuas($id, $alas, $tinggi);
    $luas = getLuasById($_GET['id']);
}
?>

<section>
<link rel="stylesheet" href="css/content.css">
<div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Detail Luas Segitiga</h1>
        <a href="luasindex.php" class="btn btn-info">Kembali</a>
    
</div>

<?php if ($message): ?>
<div class="alert alert-info" role="alert">
    <?php echo $message; ?>
</div>
<?php endif; ?>

<form action="luasshow.php?id=<?php echo $luas['id']; ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $luas['id']; ?>">
    <label for="alas">Alas:</label>
    <input type="number" id="alas" name="alas" min="2" max="300" value="<?php echo $luas['alas']; ?>" required>
    <label for="tinggi">Tinggi:</label>
    <input type="number" id="tinggi" name="tinggi" min="2" max="300" value="<?php echo $luas['tinggi']; ?>" required>
    <label for="luas-submit">Hasil Luas:</label>
    <input type="number" id="luas-submit" name="luas-submit" value="<?php echo $luas['result']; ?>" readonly>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
</form>

<svg id="segitiga-luas" width="300" height="300" style="border: 1px solid black; display: block; margin: 0 auto;">
    <polygon id="polygon" points="150,10 100,250 200,250" fill="lightblue" stroke="black" />
    <line id="line-tinggi" x1="150" y1="10" x2="150" y2="250" stroke="red" stroke-width="2" />
    <line id="line-alas" x1="100" y1="250" x2="200" y2="250" stroke="red" stroke-width="2" />
    <text id="label-alas" x="150" y="265" fill="black" font-size="14" text-anchor="middle">Alas: <?php echo $luas['alas']; ?></text>
    <text id="label-tinggi" x="160" y="130" fill="black" font-size="14" text-anchor="middle">Tinggi: <?php echo $luas['tinggi']; ?></text>
</svg>
</section>

<link rel="stylesheet" href="css/popup.css">
<script src="js/script.js"></script>

<?php require_once 'layouts/foot.php'; ?>
