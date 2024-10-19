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
                                    <span class="main-nav-text">Home</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a class="nav-link" href="{{route("public.category.index")}}">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/category.svg')}}" alt="">
                                    </div>
                                    <span class="main-nav-text">Category</span>
                                </a>
                            </div>
                        </li>
                        <li class="mobile">
                            <div>
                                <a class="nav-link" href="{{route("public.play.view",'')}}">
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
                                    <span class="main-nav-text">My Account</span>
                                </a>
                            </div>
                        </li>
                        <li  class="desktop">
                            <div>
                                <a class="nav-link" href="/en">
                                    <div class="icon-md">
                                        <img src="{{asset('site_assets/icon/payment.svg')}}" alt="">
                                    </div>
                                    <span class="main-nav-text">Payment</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
