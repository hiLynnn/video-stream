<header id="main-header">
    <nav class="menu-header container-customize">
        <div class="menu-header__logo">
            <a href="/" class="header-logo-wrapper ">
                <img src="{{ URL::asset('site_assets/images/breadcrum-bg.jpg') }}" alt="logo">
            </a>
        </div>
        <div class="menu-header__wrapper">
            <form data-e2e="search-box" class="search-input css-FormElement" action="/search"><input placeholder="Search"
                    name="q" type="search" class="css-InputElement" value="">
                <span class="css-SpanSpliter"></span>
                <button data-e2e="search-box-button" type="submit" aria-label="Search" class="css-ButtonSearch">
                    <div class="css-DivSearchIconContainer">
                        <svg width="24" data-e2e="" height="24" viewBox="0 0 48 48"
                            fill="rgba(255, 255, 255, .34)" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22 10C15.3726 10 10 15.3726 10 22C10 28.6274 15.3726 34 22 34C28.6274 34 34 28.6274 34 22C34 15.3726 28.6274 10 22 10ZM6 22C6 13.1634 13.1634 6 22 6C30.8366 6 38 13.1634 38 22C38 25.6974 36.7458 29.1019 34.6397 31.8113L43.3809 40.5565C43.7712 40.947 43.7712 41.5801 43.3807 41.9705L41.9665 43.3847C41.5759 43.7753 40.9426 43.7752 40.5521 43.3846L31.8113 34.6397C29.1019 36.7458 25.6974 38 22 38C13.1634 38 6 30.8366 6 22Z">
                            </path>
                        </svg>
                    </div>
                </button>
                <div class="css-1bmf8gr-DivInputBorder e14ntknm1"></div>
            </form>
        </div>
        <div class="menu-header__info">
            <div class="menu-header__info-list">
                <button type="button" id="header-login-button" class="css-Button-StyledLoginButton desktop">
                    <a href="{{ URL::to('login') }}" title="login"><span>{{trans('words.login_text')}}</span></a>
                </button>
                <svg class="css-StyledEllipsisVertical e13wiwn64" width="1em" data-e2e="" height="1em"
                    viewBox="0 0 48 48" fill="#ffff" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rdive="evenodd" clip-rule="evenodd"
                        d="M24 4C26.2091 4 28 5.79086 28 8C28 10.2091 26.2091 12 24 12C21.7909 12 20 10.2091 20 8C20 5.79086 21.7909 4 24 4ZM24 20C26.2091 20 28 21.7909 28 24C28 26.2091 26.2091 28 24 28C21.7909 28 20 26.2091 20 24C20 21.7909 21.7909 20 24 20ZM24 36C26.2091 36 28 37.7909 28 40C28 42.2091 26.2091 44 24 44C21.7909 44 20 42.2091 20 40C20 37.7909 21.7909 36 24 36Z">
                    </path>
                </svg>
                </ul>
            </div>

    </nav>
</header>
