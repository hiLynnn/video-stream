@extends('site_app')

@section('head_title', trans('words.login_text').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')

@if(getcong('recaptcha_on_login'))
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
function submitForm() {
    var response = grecaptcha.getResponse();
    if(response.length == 0) {
        document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">This field is required.</span>';
        return false;
    }
   
    return true;
}
 
function verifyCaptcha() {
    document.getElementById('g-recaptcha-error').innerHTML = '';
}
</script>
@endif
   
 
<!-- Login Main Wrapper Start -->
<div id="main-wrapper">
  <div class="container-fluid px-0 m-0 h-100 mx-auto">
    <div class="row g-0 min-vh-100 overflow-hidden"> 
      <!-- Welcome Text -->
      <div class="col-md-12">
        <div class="hero-wrap d-flex align-items-center h-100">
          <div class="hero-mask"></div>
          <div class="hero-bg hero-bg-scroll" style="background-image:url('{{ URL::asset('site_assets/images/login-signup-bg-img.jpg') }}');"></div>
          <div class="hero-content mx-auto w-100 h-100 d-flex flex-column justify-content-center">
            <div class="row">
              <div class="col-12 col-lg-5 col-xl-5 mx-auto">
                <div class="logo mt-40 mb-20 mb-md-0 justify-content-center d-flex text-center">
               
                  @if(getcong('site_logo'))                 
                    <a href="{{ URL::to('/') }}" title="logo"><img src="{{ URL::asset('/'.getcong('site_logo')) }}" alt="logo" title="logo" class="login-signup-logo"></a>
                  @else
                    <a href="{{ URL::to('/') }}" title="logo"><img src="{{ URL::asset('site_assets/images/logo.png') }}" alt="logo" title="logo" class="login-signup-logo"></a>                          
                  @endif

                </div>
              </div>
            </div>
            <!-- Login Form -->
        <div class="col-lg-4 col-md-6 col-sm-6 mx-auto d-flex align-items-center login-item-block">
        <div class="container login-part">
          <div class="row">
          <div class="col-12 col-lg-12 col-xl-12 mx-auto">
            <h2 class="form-title-item mb-4">{{trans('words.login_text')}}</h2>
             {!! Form::open(array('url' => 'login','class'=>'','id'=>'loginform','role'=>'form','onsubmit'=>'return submitForm();')) !!}  

             

            <div class="form-group">
              <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control" placeholder="{{trans('words.email')}}" >
            </div>
            <div class="form-group">
              <input type="password" name="password" id="password" value="" class="form-control" placeholder="{{trans('words.password')}}" >
            </div>
            
            @if(getcong('recaptcha_on_login'))
            <div class="form-group">
               <div class="g-recaptcha" data-sitekey="{{getcong('recaptcha_site_key')}}" data-callback="verifyCaptcha"></div>
               <div id="g-recaptcha-error"></div>
            </div>     
            @endif

              <div class="row mt-4">
              <div class="col">
              <div class="form-check custom-control custom-checkbox">
                <input id="remember-me" name="remember" class="form-check-input" type="checkbox">
                <label class="custom-control-label" for="remember-me">{{trans('words.remember_me')}}</label>                
              </div>
              </div>
              <div class="col text-end"><a href="{{ URL::to('password/email') }}" class="btn-link" title="forgot password"> {{trans('words.forgot_password')}}?</a></div>
            </div>
            <button class="btn-submit btn-block my-4 mb-4" type="submit">{{trans('words.login_text')}}</button>
            {!! Form::close() !!}
            <p class="text-3 text-center mb-3">{{trans('words.dont_have_account')}} <a href="{{ url('signup') }}" class="btn-link" title="signup">{{trans('words.sign_up')}}</a></p>
            <div class="socail-login-item mx-auto w-100 text-center">

            @if(getcong('facebook_login'))
            <label>
              <a href="{{ url('auth/facebook') }}" class="btn btn-lg btn-success btn-block btn-facebook-item" title="facebook"><i class="ion-social-facebook"></i> Facebook</a>     
            </label>
            @endif
            @if(getcong('google_login'))
            <label>
              <a href="{{ url('auth/google') }}" class="btn btn-lg btn-success btn-block btn-g-plus-item" title="google"><i class="ion-social-google"></i> Google</a>     
            </label>
            @endif  
             
            </div>
          </div>
          </div>
        </div>
        </div>
        <!-- Login Form End --> 
          </div>
        </div>
      </div>
      <!-- Welcome Text End -->       
    </div>
  </div>
</div>
<!-- End Login Main Wrapper --> 


<script type="text/javascript">
    
    @if(Session::has('flash_message'))     
 
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
        /*didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }*/
      })

      Toast.fire({
        icon: 'success',
        title: '{{ Session::get('flash_message') }}'
      })     
     
  @endif

  @if(Session::has('error_flash_message'))     
 
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
        /*didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }*/
      })

      Toast.fire({
        icon: 'error',
        title: '{{ Session::get('error_flash_message') }}'
      })     
     
  @endif
  
  @if(Session::has('login_flash_error')) 
  @if (count($errors) > 0)
                  
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<p>@foreach ($errors->all() as $error) {{$error}}<br/> @endforeach</p>',
            showConfirmButton: true,
            confirmButtonColor: '#10c469',
            background:"#1a2234",
            color:"#fff"
           }) 
  @endif
  @endif

  </script>

 
@endsection