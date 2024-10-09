<?php
include 'config.php';

if (isset($_POST['add_to_checkout'])) {
    $package_name = $_POST['package_name'];
    $domain_choice = $_POST['domain_choice'];
    $price = (int)$_POST['price']; // mengkonversi menjadi integer 
    $domain_name = $_POST['domain_name'];
    $domain_price = (int)$_POST['domain_price']; // mengkonversi menjadi integer 

    // Pastikan nilai price dan domain_price adalah angka
    if (is_numeric($price) && is_numeric($domain_price)) {
        $total_price = $price + $domain_price;

        $sql = "INSERT INTO checkout_table (package_name, domain_choice, price, domain_name, domain_price, total_price) VALUES (:package_name, :domain_choice, :price, :domain_name, :domain_price, :total_price)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['package_name' => $package_name, 'domain_choice' => $domain_choice, 'price' => $price, 'domain_name' => $domain_name, 'domain_price' => $domain_price, 'total_price' => $total_price]);

        header("Location: index.php");
        exit();
    } else {
        echo "Invalid price or domain price.";
    }
}

// cod untuk meng hapus dan pabila di hapus akan kembali ke halaman index.php 

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM checkout_table WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    header("Location: index.php");
    exit();
}

$rows = [];
$sql = "SELECT * FROM tabel_cekout";
$stmt = $pdo->query($sql);

if ($stmt !== false) {
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Error executing query.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Greenscreen - Web Hosting</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    
    <link href="img/favicon.ico" rel="icon">

   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">  

   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
     

.checkout-table {
    width: 100%;
    max-width: 1000px;
    margin: 2 auto;
    border-collapse: collapse;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.checkout-table th, .checkout-table td {
    padding: 15px;
    text-align: left;
}

.checkout-table th {
    background-color: #4caf50;
    color: white;

}

.checkout-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.checkout-table tr:nth-child(odd) {
    background-color: #e6f7e6;
}

.checkout-table tr:hover {
    background-color: #d0f0c0;
}


</style>
<body>
    <div class="container-xxl bg-white p-0">
       
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        
       
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="m-0"><i class="fa fa-server me-3"></i>Greenscreen</h1>
                    
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="#" class="nav-item nav-link">Home</a>
                        <a href="#footer" class="nav-item nav-link">About</a>
                    </div>
                    <butaton type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-cart"></i></butaton>
                  
                </div>
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5">
                        <div class="col-lg-6 pt-5 text-center text-lg-start">
                            <h1 class="display-4 text-white mb-4 animated slideInLeft">Selamat Datang</h1>
                            <p class="text-white animated slideInLeft">Di Greenscreen penyedia web host dengan harga terjangkau.</p>
                            <h1 class="text-white mb-4 animated slideInLeft">
                                <small class="align-top fw-normal" style="font-size: 15px; line-height: 25px;">Mulai Dari:</small>
                                <span>20.000</span>
                                <small class="align-bottom fw-normal" style="font-size: 15px; line-height: 33px;">/ Bln</small>
                            </h1>
                            <a href="#prdk" class="btn btn-secondary py-sm-3 px-sm-5 me-3 animated slideInLeft">Mulai Sekarang</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid animated zoomIn" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
       


        

        <div class="modal fade" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(29, 40, 51, 0.8);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                    <table class="checkout-table">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Hosting </th>
                        <th>Harga Paket</th>
                        <th>Nama Domain</th>
                        <th>Harga Domain</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['domain_choice']); ?></td>
                        <td>Rp. <?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['domain_name']); ?></td>
                        <td>Rp. <?php echo htmlspecialchars($row['domain_price']); ?></td>
                        <td>Rp. <?php echo htmlspecialchars($row['total_price']); ?></td>
                        <td>
                            <form action="index.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                    </div>
 
                    </div>
                </div>
            </div>
        </div>
        


        
        <div class="container-xxl domain mb-5" style="margin-top: 90px;" id="prdk">
            <div class="container px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="section-title position-relative text-center mx-auto mb-4 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                            <h1 class="mb-3">Pilih Domainmu</h1>
                            <p class="mb-1">Memulai untuk membangun web anda agar dikenal banyak orang.</p>
                        </div>
                        <div class="position-relative w-100 my-3 wow fadeInUp" data-wow-delay="0.3s">
                            <input id="domain_input" class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Tambahkan domain mu">
                            <button id="add_domain" type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Pilih</button>
                        </div>
                        <div class="row g-3 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                                <h5 class="fw-bold text-primary mb-1">.com</h5>
                                <p class="mb-0">Rp.600.000/Thn</p>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                                <h5 class="fw-bold text-primary mb-1">.net</h5>
                                <p class="mb-0">Rp.500.000/Thn</p>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                                <h5 class="fw-bold text-primary mb-1">.org</h5>
                                <p class="mb-0">Rp.400.000/Thn</p>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                                <h5 class="fw-bold text-primary mb-1">.io</h5>
                                <p class="mb-0">Rp.400.000/Thn</p>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                                <h5 class="fw-bold text-primary mb-1">.info</h5>
                                <p class="mb-0">Rp.350.000/Thn</p>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                                <h5 class="fw-bold text-primary mb-1">.co.uk</h5>
                                <p class="mb-0">Rp.150.000/Thn</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-4">
                            <h1 class="mb-2">Hosting dengan fitur untuk website terlengkap</h1>
                        </div>
                        <p class="mb-4">Mari bergbung dengan kami dari web hosting Greenscreen, web anda aman besama kami!</p>
                        <div class="row g-3">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-users-cog fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                    <p class="mb-0">Experts</p>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                    <p class="mb-0">Clients</p>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-check fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                    <p class="mb-0">Projects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="img/about.png">
                    </div>
                </div>
            </div>
        </div>
       


      
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Pilih Hosting</h1>
                    <p class="mb-1">Memilih paket hosting lebih tenang dengan garansi 30 hari.</p>
                </div>
                
                <div class="row gy-5 gx-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="position-relative shadow rounded border-top border-5 border-primary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-share-alt text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <h4 class="fw-bold">Premium</h4>
                                <p class="mb-0">Untuk blog dan web sederhana </p>
                            </div>
                            <div class="text-center border-bottom p-4">
                                <p class="text-primary mb-1">Penawaran Terbaru - <strong>Hemat 30%</strong></p>
                                <h1 class="mb-3">
                                    <small class="align-top" style="font-size: 22px; line-height: 45px;">Rp.</small>25.000<small
                                        class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Bulan</small>
                                </h1>
                                <form action="index.php" method="post">
                                <input type="hidden" name="package_name" value="Premium">
                                <input type="hidden" name="domain_choice" value="Website">
                                <input type="hidden" name="price" value="25000">
                                <input type="hidden" name="domain_name" id="domain_name">
                                <input type="hidden" name="domain_price" id="domain_price">
                                <button type="submit" name="add_to_checkout" class="btn btn-primary px-4 py-2">Beli Sekarang</button>
                            </form>
                            </div>
                            <div class="p-4">
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>100 Website</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Backup Mingguan</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Managed WordPress</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Penghapusan Malware Otomatis</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>SSL Gratis Unlimited</p>
                                <p class="mb-0"><i class="fa fa-check text-primary me-4"></i>Garansi Uang Kembali 30 Hari</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="position-relative shadow rounded border-top border-5 border-secondary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-secondary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-server text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <h4 class="fw-bold">Bussines</h4>
                                <p class="mb-0">Untuk web bisnis dan toko online</p>
                            </div>
                            <div class="text-center border-bottom p-4">
                                <p class="text-primary mb-1">Penawran Terbaru - <strong>Hemat 30%</strong></p>
                                <h1 class="mb-3">
                                    <small class="align-top" style="font-size: 22px; line-height: 45px;">Rp.</small>45.000<small
                                        class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Bulan</small>
                                </h1>
                                <form action="index.php" method="post">
                                <input type="hidden" name="package_name" value="Bussines">
                                <input type="hidden" name="domain_choice" value="Website">
                                <input type="hidden" name="price" value="45000">
                                <input type="hidden" name="domain_name" id="domain_na">
                                <input type="hidden" name="domain_price" id="domain_pr">
                                <button type="submit" name="add_to_checkout" class="btn btn-primary px-4 py-2">Beli Sekarang</button>
                            </form>
                            </form>
                            </div>
                            <div class="p-4">
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>100 Website</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Backup Mingguan</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Gratis 1 Domain</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>CDN Gratis</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Email Gratis</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Basic WooCommerce</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Managed WordPress</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>SSL Gratis Unlimited</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Penghapusan Malware Otomatis</p>
                                <p class="mb-0"><i class="fa fa-check text-primary me-3"></i>Garansi Uang Kembali 30 Hari</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="position-relative shadow rounded border-top border-5 border-primary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-cog text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <h4 class="fw-bold">Cloud Startup</h4>
                                <p class="mb-0">Dapatkan Power Full Resouce & Peforma Web yang Optimal</p>
                            </div>
                            <div class="text-center border-bottom p-4">
                                <p class="text-primary mb-1">Penawarn Baru - <strong>Hemat 30%</strong></p>
                                <h1 class="mb-3">
                                    <small class="align-top" style="font-size: 22px; line-height: 45px;">Rp.</small>150.000<small
                                        class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Bulan</small>
                                </h1>
                                <form action="index.php" method="post">
                                <input type="hidden" name="package_name" value="Cloud Stratup">
                                <input type="hidden" name="domain_choice" value="Website">
                                <input type="hidden" name="price" value="150000">
                                <input type="hidden" name="domain_name" id="domain_nam">
                                <input type="hidden" name="domain_price" id="domain_pric">
                                <button type="submit" name="add_to_checkout" class="btn btn-primary px-4 py-2">Beli Sekarang</button>
                            </form>
                            </div>
                            <div class="p-4">
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>300 Website</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Backup Mingguan</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Gratis 3 Domain</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>CDN Gratis</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Email Gratis</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Basic WooCommerce</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Managed WordPress</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>SSL Gratis Unlimited</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Penghapusan Malware Otomatis</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Bantuan Prioritas</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>200 GB NVMe Storage</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>Alamat IP Dedicated</p>
                                <p class="mb-0"><i class="fa fa-check text-primary me-3"></i>Garansi Uang Kembali 30 Hari</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      


       
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">server bersama vs server khusus</h1>
                    <p class="mb-1">Tentukan pilihanmu dengan perbandingan kebebasan yang ada.</p>
                </div>
                <div class="row g-5 comparison position-relative">
                    <div class="col-lg-6 pe-lg-5">
                        <div class="section-title position-relative mx-auto mb-4 pb-4">
                            <h3 class="fw-bold mb-0">server bersama</h3>
                        </div>
                        <div class="row gy-3 gx-5">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-server fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">99.99% waktu aktif</h5>
                               
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">100% Keamanan</h5>
                               
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <i class="fa fa-cog fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">Control Panel</h5>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <i class="fa fa-headset fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">24/7 Support</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <div class="section-title position-relative mx-auto mb-4 pb-4">
                            <h3 class="fw-bold mb-0">server pribadi</h3>
                        </div>
                        <div class="row gy-3 gx-5">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-server fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">100% waktu akif</h5>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-shield-alt fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">100% keamanan</h5>
                                
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <i class="fa fa-cog fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">Control Panel</h5>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <i class="fa fa-headset fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">24/7 Support</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Pembuat</h1>
                    <p class="mb-1">Anda yakin dengan Greenscreen, kami juga yakin dengan anda.</p>
                </div>
                <div class="row g-4 justify-content-center" >
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item border-top border-5 border-primary rounded shadow overflow-hidden">
                            <div class="text-center p-4">
                                <img class="img-fluid rounded-circle mb-4" src="img/team-1.jpeg" alt="">
                                <h5 class="fw-bold mb-1">Aditya Rizky</h5>
                                <small>membuat sebuah web hosting harga terjangkau untuk semua orang adalah impian saya</small>
                            </div>
                            <div class="d-flex justify-content-center bg-primary p-3">
                                <a class="btn btn-square text-primary bg-white m-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square text-primary bg-white m-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square text-primary bg-white m-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        

      
        <div class="container-fluid bg-primary text-white footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s" id="footer">
            <div class="container py-5 px-lg-5">
                <div class="row gy-5 gx-4 pt-5">
                    <div class="col-12">
                        <h5 class="fw-bold text-white mb-4">Subscribe </h5>
                        <div class="position-relative" style="max-width: 400px;">
                            <input class="form-control bg-white border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                            <button type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Submit</button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold text-white mb-4">About Us</h5>
                                <a class="btn btn-link" href="">About Us</a>
                                <a class="btn btn-link" href="">Contact Us</a>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-white mb-4">Our Services</h5>
                                <a class="btn btn-link" href="">Domain</a>
                                <a class="btn btn-link" href="">Shared Hosting</a>
                                <a class="btn btn-link" href="">VPS Hosting</a>
                                <a class="btn btn-link" href="">Dedicated Hosting</a>
                                <a class="btn btn-link" href="">Reseller Hosting</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="fw-bold text-white mb-4">Contact Us</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Manajemen Informatika</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+62 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>Greenscreen@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mt-lg-n5">
                        <div class="bg-light rounded" style="padding: 30px;">
                            <input type="text" class="form-control border-0 py-2 mb-2" placeholder="Name">
                            <input type="email" class="form-control border-0 py-2 mb-2" placeholder="Email">
                            <textarea class="form-control border-0 mb-2" rows="2" placeholder="Message"></textarea>
                            <button class="btn btn-primary w-100 py-2">Send Message</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Greenscreen</a>, All Right Reserved. 
							
						
							Designed By <a class="border-bottom" >Aditya Rizky</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="3">Home</a>
                                <a href="">Help</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       



        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script>
        document.getElementById('add_domain').addEventListener('click', function() {
            const domainInput = document.getElementById('domain_input').value;
            const packageForm = document.querySelector('form[action="index.php"]');
            const domainNameInput = document.getElementById('domain_name');
            const domainPriceInput = document.getElementById('domain_price');

            if (domainInput.endsWith('.com')) {
                domainPriceInput.value = 600000;
            } else if (domainInput.endsWith('.net')) {
                domainPriceInput.value = 500000;
            } else if (domainInput.endsWith('.org')) {
                domainPriceInput.value = 400000;
            } else if (domainInput.endsWith('.io')) {
                domainPriceInput.value = 400000;
            } else if (domainInput.endsWith('.info')) {
                domainPriceInput.value = 350000;
            } else if (domainInput.endsWith('.co.uk')) {
                domainPriceInput.value = 150000;
            } else {
                domainPriceInput.value = 0;
            }

            domainNameInput.value = domainInput;
        });

    </script>


<script>
        document.getElementById('add_domain').addEventListener('click', function() {
            const domainInput = document.getElementById('domain_input').value;
            const packageForm = document.querySelector('form[action="index.php"]');
            const domainNameInput = document.getElementById('domain_na');
            const domainPriceInput = document.getElementById('domain_pr');

            if (domainInput.endsWith('.com')) {
                domainPriceInput.value = 600000;
            } else if (domainInput.endsWith('.net')) {
                domainPriceInput.value = 500000;
            } else if (domainInput.endsWith('.org')) {
                domainPriceInput.value = 400000;
            } else if (domainInput.endsWith('.io')) {
                domainPriceInput.value = 400000;
            } else if (domainInput.endsWith('.info')) {
                domainPriceInput.value = 350000;
            } else if (domainInput.endsWith('.co.uk')) {
                domainPriceInput.value = 150000;
            } else {
                domainPriceInput.value = 0;
            }

            domainNameInput.value = domainInput;
        });

    </script>

<script>
        document.getElementById('add_domain').addEventListener('click', function() {
            const domainInput = document.getElementById('domain_input').value;
            const packageForm = document.querySelector('form[action="index.php"]');
            const domainNameInput = document.getElementById('domain_nam');
            const domainPriceInput = document.getElementById('domain_pric');

            if (domainInput.endsWith('.com')) {
                domainPriceInput.value = 600000;
            } else if (domainInput.endsWith('.net')) {
                domainPriceInput.value = 500000;
            } else if (domainInput.endsWith('.org')) {
                domainPriceInput.value = 400000;
            } else if (domainInput.endsWith('.io')) {
                domainPriceInput.value = 400000;
            } else if (domainInput.endsWith('.info')) {
                domainPriceInput.value = 350000;
            } else if (domainInput.endsWith('.co.uk')) {
                domainPriceInput.value = 150000;
            } else {
                domainPriceInput.value = 0;
            }

            domainNameInput.value = domainInput;
        });

    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

   
    <script src="js/main.js"></script>
</body>

</html>