@extends('site_app')
@section('head_title', $page_info->page_title.' | '.getcong('site_name') )
@section('head_url', Request::url())
@section('content')  

@if(getcong('recaptcha_on_contact_us'))
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

<!-- Start Breadcrumb -->
<div class="breadcrumb-section bg-xs" style="background-image: url({{ URL::asset('site_assets/images/breadcrum-bg.jpg') }})">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12"> 
          <h2>{{stripslashes($page_info->page_title)}}</h2>
          <nav id="breadcrumbs">
            <ul>
              <li><a href="{{ URL::to('/') }}" title="{{trans('words.home')}}">{{trans('words.home')}}</a></li>
              <li>{{stripslashes($page_info->page_title)}}</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
<!-- End Breadcrumb --> 

<!-- Start Contat Page -->
<div class="contact-page-area vfx-item-ptb vfx-item-info">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
		 <div class="contact-form">
              
           {!! Form::open(array('url' => 'contact_send','class'=>'row','id'=>'contact_form','role'=>'form','onsubmit'=>'return submitForm();')) !!}  
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
                <label>{{trans('words.name')}}</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" >
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
				<label>{{trans('words.email')}}</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" >
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
				<label>{{trans('words.phone')}}</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number">
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
				<label>{{trans('words.subject')}}</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" >
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
              <label>{{trans('words.your_message')}}</label>
                <textarea name="message" id="message" class="form-control" cols="30" rows="4" placeholder="Your Message..." ></textarea>
              </div>
            </div>
            @if(getcong('recaptcha_on_contact_us'))
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
                  <div class="g-recaptcha" data-sitekey="{{getcong('recaptcha_site_key')}}" data-callback="verifyCaptcha"></div>
                  <div id="g-recaptcha-error"></div>
              </div>
            </div>
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <button type="submit" class="vfx-item-btn-danger text-uppercase">{{trans('words.submit')}}</button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
	  <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
	    @if($page_info->page_content)
        <div class="contact-form">          
            {!!stripslashes($page_info->page_content)!!}
        </div>  
        @endif
	  </div>	
    </div>
  </div>
</div>
<!-- End Contact Page --> 

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