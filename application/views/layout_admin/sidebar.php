<!--end::Header-->
<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <!--begin::Brand Image-->
        <img
        src="<?= base_url("/")?>assets/img/AdminLTELogo.png"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
        />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">ERP TGM</span>
        <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
    <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
        >
        <li class="nav-item menu-open">
            <a href="<?= base_url('dashboard')?>" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
                Dashboard
            </p>
            </a>
        </li>
        <li class="nav-divider my-1 border-top"></li>
        <?php foreach($menu as $mn): ?>
            <li class="nav-item">
                <a href="<?= base_url($mn->link) ?>" class="nav-link">
                    <i class="nav-icon bi <?= $mn->icon_fa ?>"></i>
                    <p>
                        <?= $mn->alias ?>
                        <!-- <i class="nav-arrow bi bi-chevron-right float-end"></i> -->
                    </p>
                </a>
                
            </li>
        <?php endforeach; ?>
        <li class="nav-divider my-1 border-top"></li>
        <li class="nav-item">
            <a href="<?= base_url('mobile')?>" class="nav-link">
            <i class="nav-icon bi bi-mobile"></i>
            <p>Profile</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('mobile')?>" class="nav-link">
            <i class="nav-icon bi bi-turn-off"></i>
            <p>Logout</p>
            </a>
        </li>

        
        
        </ul>
        <!--end::Sidebar Menu-->
    </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<main class="app-main">
    <!--begin::App Content Top Area-->
    <div class="app-content-top-area">
        <!--begin::Container-->
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-6"><div><?= $title ?></div></div>
            <div class="col-md-6 text-end">
            <!-- <button type="submit" class="btn btn-primary" name="save" value="create">
                Create Admin
            </button> -->
            </div>
        </div>
    </div>
    <hr>