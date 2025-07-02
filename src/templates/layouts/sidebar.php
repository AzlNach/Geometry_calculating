<?php 
require_once('function.php');
?>
<nav class="sidebar" >
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-white min-vh-100">
        <a href="index.php" class="d-flex align-items-center pb-3 mb-md-3 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline fw-bold">Geometric Calculate</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item mb-5 <?= isCurrentFile('index.php')? "fw-bold":'' ?>"></li>
                <a href="index.php" class="nav-link px-0 align-middle text-white d-flex">
                    <div class="">
                        <span class="material-symbols-rounded">
                            dashboard
                        </span>
                    </div>
                    <div class="ms-3 d-none d-sm-inline fs-5">
                        <span>Dashboard</span>
                    </div>
                
                    <?if (isCurrentFile('index.php')):?>
                        <div class="ms-3">
                            <span class="material-symbols-rounded fs-6 text-warning shadow">circle</span>
                        </div>
                    <?endif?>
                </a>
            </li>

            <li class="mb-3  <?= isCurrentFile('luasindex.php')||isCurrentFile('luascreate.php') ? "fw-bold ms-3":'' ?> ">
                <a href="#luasSubmenu" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white d-flex">
                    <div>
                        <span class="material-symbols-rounded">
                            change_history
                        </span>
                    </div>
                    <div class="ms-3 d-none d-sm-inline">
                        <span>Segitiga</span>
                    </div>
                    <div class="ms-auto">
                        <span class="material-symbols-rounded">
                            expand_more
                        </span>
                    </div>
                </a>
                <ul class="collapse list-unstyled ps-3" id="luasSubmenu">
                    <li class="mb-3 <?= isCurrentFile('luasindex.php')? "fw-bold ms-3":'' ?>">
                        <a href="luasindex.php" class="nav-link px-0 align-middle text-white d-flex">
                            <div>
                                <span class="material-symbols-rounded">
                                    list
                                </span>
                            </div>
                            <div class="ms-3 d-none d-sm-inline">
                                <span>Hitung Luas</span>
                            </div>
                    <li class="mb-3 <?= isCurrentFile('index.php')? "fw-bold ms-3":'' ?>">
                        <a href="{{ route('luas.create') }}" class="nav-link px-0 align-middle text-white d-flex">
                            <div>
                                <span class="material-symbols-rounded">
                                    add
                                </span>
                            </div>
                            <div class="ms-3 d-none d-sm-inline">
                                <span>Tambah luas</span>
                            </div>
                            <?if (isCurrentFile('luasindex.php')):?>
                                <div class="ms-3">
                                    <span class="material-symbols-rounded fs-6 text-warning shadow">circle</span>
                                </div>
                            <?endif?>
                        </a>
                    </li>
                </ul>
            </li>

          
        </ul>
        <!-- @if (Auth::check())
            <div class="dropdown pb-4">
                <a href="#"
                    class="d-flex align-items-center text-white text-decoration-none dropdown-toggle text-white"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('storage/placeholder/no-avatar.png') }}" alt="hugenerd" width="30"
                        height="30" class="rounded-circle">
                    <span class="d-none d-sm-inline mx-1 ms-3">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="/shop">Sporta Cashier</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif -->
    </div>
</nav>
