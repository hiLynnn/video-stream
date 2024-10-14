@extends('site_app')

@section('head_title', trans('words.forgot_password').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')
  
@if(getcong('recaptcha_on_forgot_pass'))
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
 

 <!-- Forgot Password Wrapper Start -->
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
                    <a href="{{ URL::to('/') }}" title="logo" class="d-flex"><img src="{{ URL::asset('/'.getcong('site_logo')) }}" alt="logo" title="logo" class="login-signup-logo"></a>
                  @else
                    <a href="{{ URL::to('/') }}" title="logo" class="d-flex"><img src="{{ URL::asset('site_assets/images/logo.png') }}" alt="logo" title="logo" class="login-signup-logo"></a>                          
                  @endif
                </div>
              </div>
            </div>
            <!-- Login Form -->
        <div class="col-lg-4 col-md-6 col-sm-6 mx-auto d-flex align-items-center login-item-block">
        <div class="container login-part">
          <div class="row">
          <div class="col-12 col-lg-12 col-xl-12 mx-auto">
            <h2 class="form-title-item mb-4">{{trans('words.forgot_password')}}?</h2>

             
            {!! Form::open(array('url' => 'password/email','class'=>'','id'=>'forget_pass_form','role'=>'form','onsubmit'=>'return submitForm();')) !!}
            <div class="form-group">
              <input type="email" class="form-control" name="email" id="email" required placeholder="{{trans('words.email')}}">
            </div>            
            @if(getcong('recaptcha_on_forgot_pass'))
            <div class="form-group">
               <div class="g-recaptcha" data-sitekey="{{getcong('recaptcha_site_key')}}" data-callback="verifyCaptcha"></div>
               <div id="g-recaptcha-error"></div>
            </div>     
            @endif    
            <button class="btn-submit btn-block my-4 mb-4 mt-1" type="submit">{{trans('words.reset_password')}}</button>
            {!! Form::close() !!} 
            <p class="text-3 text-center mb-0">{{trans('words.dont_have_account')}} <a href="{{ url('signup') }}" class="btn-link" title="signup">{{trans('words.sign_up')}}</a></p>
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
<!-- End Forgot Password Wrapper -->  

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
        icon: 'success',
        title: '{{ Session::get('error_flash_message') }}'
      })     
     
  @endif
  
 
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
 

  </script>
 
@endsection