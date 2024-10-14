@extends('site_app')

@section('head_title', trans('words.account_delete_form').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')
  
  
<!-- Start Breadcrumb -->
<div class="breadcrumb-section bg-xs" style="background-image: url({{ URL::asset('site_assets/images/breadcrum-bg.jpg') }})">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12"> 
          <h2>{{trans('words.account_delete_form')}}</h2>
          <nav id="breadcrumbs">
            <ul>
              <li><a href="{{ URL::to('/') }}" title="{{trans('words.home')}}">{{trans('words.home')}}</a></li>
              <li>{{trans('words.account_delete_form')}}</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
<!-- End Breadcrumb --> 

<!-- Banner -->
@if(get_web_banner('other_page_top')!="")      
      <div class="vid-item-ptb banner_ads_item pb-1" style="padding: 15px 0;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
             {!!stripslashes(get_web_banner('other_page_top'))!!}
          </div>
        </div>  
        </div>
      </div>
  @endif

<!-- Start Details Info Page -->
<div class="contact-page-area vfx-item-ptb vfx-item-info">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 offset-lg-2 offset-md-0">
        <div class="contact-form">
        <p>{{trans('words.account_delete_info')}}</p> 

        {!! Form::open(array('url' => 'delete_account_verify','class'=>'row','id'=>'delete_form','role'=>'form')) !!}  
            
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
				        <label>{{trans('words.email')}}</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="{{trans('words.email')}}" require>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group mb-3">
                <label>{{trans('words.password')}}</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{trans('words.password')}}" require>
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <button type="button" id="dlt-btn-ok" class="vfx-item-btn-danger text-uppercase">{{trans('words.submit')}}</button>
              </div>
            </div>
          {!! Form::close() !!} 

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Details Info Page -->  

<!-- Banner -->
@if(get_web_banner('other_page_bottom')!="")      
      <div class="vid-item-ptb banner_ads_item pb-1" style="padding: 15px 0;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
             {!!stripslashes(get_web_banner('other_page_bottom'))!!}
          </div>
        </div>  
        </div>
      </div>
  @endif

  <script src="{{ URL::asset('site_assets/js/jquery-3.3.1.min.js') }}"></script> 

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

  @if(Session::has('flash_error'))     
 
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
        title: '{{ Session::get('flash_error') }}'
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
  
  $(document).ready(function() {

    $("form #dlt-btn-ok").click(function () {  
   
      let $form = $(this).closest('form');

      var email = document.getElementById("email").value;
      var password = document.getElementById("password").value;

      //alert(email);

      if(email=="" || password=="")
      { 
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '{{trans('words.email_password_required')}}',
            showConfirmButton: true,
            confirmButtonColor: '#10c469',
            background:"#1a2234",
            color:"#fff"
           })
      }
      else
      {
          
          Swal.fire({
          title: '{{trans('words.dlt_warning')}}',
          text: "{{trans('words.dlt_warning_text')}}",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '{{trans('words.dlt_confirm')}}',
          cancelButtonText: "{{trans('words.btn_cancel')}}",
          background:"#1a2234",
          color:"#fff"
        
          }).then((result) => {          
              if(result.isConfirmed) {  
                  $form.submit();
              }          
          })
      }
 
      });

});
 
  </script>  
 
@endsection