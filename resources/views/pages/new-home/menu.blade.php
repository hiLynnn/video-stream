<div class="side-nav-container">
    <div class="scroll-container">
        <div class="scroll-wrapper">
            <div class="nav-wrapper">
                <nav class="nav-main-container">
                    <ul class="main-nav">
                        <li>
                            <div>
                                <a class="nav-link" href="{{route("public.index")}}">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/home.svg')}}" alt="">
                                    </div>
                                    <span class="main-nav-text">Trang chủ</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a class="nav-link" href="/">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/category.svg')}}" alt="">
                                    </div>
                                    <span class="main-nav-text">Danh mục</span>
                                </a>
                            </div>
                        </li>
                        <li class="mobile">
                            <div>
                                <a class="nav-link" href="">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/play-fill.svg')}}" alt="">
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a class="nav-link" href="{{route("public.user.index")}}">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/user.svg')}}" alt="">
                                    </div>
                                    <span class="main-nav-text">Tài Khoản</span>
                                </a>
                            </div>
                        </li>
                        <li  class="desktop">
                            <div>
                                <a class="nav-link" href="{{route("public-payment-index")}}">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/payment.svg')}}" alt="">
                                    </div>
                                    <span class="main-nav-text">Gói dịch vụ</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
