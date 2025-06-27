<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard TGM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->


  <link rel="stylesheet" href="<?= base_url('assets/mobile/style.css') ?>" />
  <style>
      @media (max-width: 768px) {
          .table-responsive-mobile {
              display: block;
          }
          .table-wrapper-desktop {
              display: none;
          }
      }
      @media (min-width: 768px) {
          .table-responsive-mobile {
              display: none;
          }
          .table-wrapper-desktop {
              display: block;
          }
      }
      /* .container {
        padding-bottom: 80px !important;
      } */
      
      .profile-card {
          margin-bottom: 2rem;
      }

      @media (max-width: 767.98px) {
          .table-responsive-mobile {
              max-height: calc(100vh - 160px);
              overflow-y: auto;
              padding-bottom: 20px;
          }
      }
      
      .navbar {
        border-bottom: 1px solid #ddd;
      }

      .navbar-brand {
        font-size: 1.1rem;
      }

      @media (max-width: 576px) {
        .navbar .nav-link {
          padding: 0 0.5rem;
          font-size: 1.2rem;
        }

        .navbar-brand {
          font-size: 1rem;
        }
      }
  </style>

  <style>
    h3 {
        font-family: Lato, sans-serif;
        font-size: 32px;
        text-align: center;
        background-color: #000;
        color: #0f0;
        padding: 10px;
        border-radius: 8px;
    }

    .rounded-box {
        width: 70px;
        height: 70px;
        background-color: #000;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
    }

    .rounded-box i {
        color: #fff;
        font-size: 24px;
    }

    h4 {
        text-align: center;
        font-size: 14px;
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .rounded-box {
            width: 60px;
            height: 60px;
        }

        .rounded-box i {
            font-size: 20px;
        }

        h4 {
            font-size: 13px;
        }
    }
    img.img-fluid {
    max-height: 80px;
    object-fit: contain;

    .sponsor-logo {
        filter: grayscale(100%);
        transition: all 0.3s ease;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .sponsor-logo:hover {
        filter: grayscale(0%);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top shadow-sm bg-white">
  <div class="container-fluid d-flex justify-content-between align-items-center px-3 py-2">
    <a class="navbar-brand fw-bold text-dark" href="<?= base_url('mobile') ?>">
      <i class="bi bi-printer-fill me-2"></i> TGM Print
    </a>

    <div class="d-flex align-items-center">
      <a class="nav-link text-dark me-2" href="<?= base_url('mobile') ?>"><i class="bi bi-house-door-fill"></i></a>
      <a class="nav-link text-dark me-2" href="<?= base_url('mobile/profile') ?>"><i class="bi bi-person-fill"></i></a>
      <a class="nav-link text-danger" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
        <i class="bi bi-box-arrow-right"></i>
      </a>
    </div>
  </div>
</nav>
<br>
<br>
<br>




