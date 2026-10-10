<?php
require_once 'config/database.php';

// Ambil ID dari parameter URL dan pastikan berupa angka (integer)
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Query untuk mengambil detail berita berdasarkan ID
$stmt = $conn->prepare("SELECT judul, isi, tanggal_publish FROM berita WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Jika berita tidak ditemukan, alihkan kembali ke halaman news.php
if ($result->num_rows === 0) {
    header("Location: news.php");
    exit;
}

$row = $result->fetch_assoc();
$pageTitle = $row['judul'] . ' - Telkom University';

require 'includes/header.php';
?>

<section class="section">
    <div class="container" style="max-width: 800px;">
        <article>
            <p class="meta"><?= date('d M Y', strtotime($row['tanggal_publish'])) ?></p>
            <h1><?= htmlspecialchars($row['judul']) ?></h1>
            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            <div class="content" style="line-height: 1.8;">
                <?= nl2br(htmlspecialchars($row['isi'])) ?>
            </div>
            <div style="margin-top: 40px;">
                <a href="news.php" class="btn btn-outline">&larr; Kembali ke Berita</a>
            </div>
        </article>
    </div>
</section>

<?php require 'includes/footer.php'; ?>