<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>{{$pageTitle}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="{{route('docs')}}/img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{route('docs')}}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{route('docs')}}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{route('docs')}}/css/style.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('pageCss')
</head>
<body>
<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                <a class="text-body mr-3" href="">About</a>
                <a class="text-body mr-3" href="">Contact</a>
                <a class="text-body mr-3" href="">Help</a>
                <a class="text-body mr-3" href="">FAQs</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                        @if(session('name') && session('surname'))
                            {{session('name')}} {{session('surname')}}
                        @else
                            Hesabım
                        @endif

                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                    @if(session('name') && session('surname'))
                            <a href="{{route('user.logout')}}" class="dropdown-item" type="button">Çıkış Yap</a>
                    @else
                            <a href="{{route('user.register')}}" class="dropdown-item" type="button">Kayıt Ol</a>
                            <a href="{{route('user.login')}}" class="dropdown-item" type="button">Giriş</a>
                    @endif

                    </div>

                </div>
                </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none">

                <a href="{{route('shoppingBag')}}" class=" px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="{{route('homePage')}}" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Turan</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shoes</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0"> Service</p>
            <h5 class="m-0">+012 345 6789</h5>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Kategoriler</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    @foreach($categories as $category)
                        @if(isset($category['sub_categories']))
                        <div class="nav-item dropdown dropright">
                            <a href="{{route('categoryDetail', ['slug' => $category['slug']])}}" class="nav-link " data-toggle="dropdown">{{$category['name']}} <i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0" style="height: 200px !important; overflow: auto;">
                               @foreach($category['sub_categories'] as $sub)
                                    <a href="{{route('subCategoryDetail', ['slug' => $sub['slug']])}}" class="dropdown-item">{{$sub['name']}}</a>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <a href="{{route('categoryDetail', ['slug' => $category['slug']])}}" class="nav-item nav-link">{{$category['name']}}</a>
                        @endif
                    @endforeach
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Turan</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shoes</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{route('homePage')}}" class="nav-item nav-link active">Anasayfa</a>
                        @foreach($categories as $category)
                            <a href="{{route('categoryDetail', ['slug' => $category['slug']])}}" class="nav-item nav-link">{{$category['name']}}</a>
                        @endforeach

                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="{{route('shoppingBag')}}" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
