<?php
include "../connection/konek.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$currentPage = basename($_SERVER["PHP_SELF"]);

if ($currentPage == "index-psikolog.php") {
    $currentPage = "all-session.php";
}

$userName = null;
if (!empty($_SESSION['user']['nama'])) {
    $userName = $_SESSION['user']['nama'];
} elseif (!empty($_SESSION['psikolog']['nama_psikolog'])) {
    $userName = $_SESSION['psikolog']['nama_psikolog'];
} else {
    $userName = 'Guest';
}
?>
<style>

    .Sidebar{
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }
    li,
    a {
        color: black;
    }

    .nav-link i,
    .nav-item i {
        font-style: normal !important;
    }

    .submenu .nav-link {
        color: black;
        font-size: 0.9rem;
        padding-left: 1.5rem;
        /* biar lebih masuk ke dalam */
        border-radius: 6px;
    }

    .submenu .nav-link:hover {
        background-color: #e9ecef;
        /* efek hover */
    }

    /* Highlight active submenu */
    .submenu .nav-link.active {
        background-color: #0d6efd;
        color: #fff !important;
        font-weight: 500;
    }
</style>


<div class="Sidebar">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="height: 100vh;"
        bis_skin_checked="1"> <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <use xlink:href="#bootstrap"></use></svg> <img class="mb-4" src="../assets/2.png" alt="" width="200"
                height="90">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link link-body-emphasis d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2"></i> Session
                </a>
                <ul class="nav flex-column ms-4 submenu">
                    <li>
                        <a href="../index-psikolog.php" 
                        class="nav-link d-flex align-items-center
                        
                        <?php if ($currentPage == 'all-session.php') echo 'active';?>
                        ">
                            All Session
                        </a>
                    </li>
                    <li>
                        <a href="../session/cleared-session.php" 
                        class="nav-link d-flex align-items-center
                        <?php if ($currentPage == 'cleared-session.php') echo 'active'; ?>
                        ">
                            Cleared Session
                        </a>
                    </li>
                    <li>
                        <a href="../session/remain-session.php"
                         class="nav-link d-flex align-items-center
                         <?php if ($currentPage == 'remain-session.php') echo 'active';?>
                         ">
                            Remain Session
                        </a>
                    </li>

                    <li>
                        <a href="../session/add-session.php"
                         class="nav-link d-flex align-items-center
                         <?php if ($currentPage == 'add-session.php') echo 'active';?>
                         ">
                            Add Session
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="nav-link link-body-emphasis d-flex align-items-center">
                    <i class="bi bi-clock-history me-2"></i> Histories
                </a>
            </li>


            </a> </li>
        </ul>
        <hr>
        <div class="dropdown" bis_skin_checked="1"> <a href="#"
                class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false"> <img src="https://github.com/mdo.png" alt="" width="32"
                    height="32" class="rounded-circle me-2"> 
                <strong><?= htmlspecialchars($userName)?></strong> </a>
            <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="psikolog-logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>