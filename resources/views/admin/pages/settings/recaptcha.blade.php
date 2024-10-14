@extends("admin.admin_app")

@section("content")

<style type="text/css">
  .iframe-container {
  overflow: hidden;
  padding-top: 56.25% !important;
  position: relative;
}
 
.iframe-container iframe {
   border: 0;
   height: 100%;
   left: 0;
   position: absolute;
   top: 0;
   width: 100%;
}
</style>
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                  

                 {!! Form::open(array('url' => array('admin/recaptcha_settings'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
   
                 <h5 class="mb-4" style="color:#f9f9f9"><i class="fa fa-refresh pr-2"></i> <b>{{trans('words.recaptcha_settings')}}</b></h5>
 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.site_key')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="recaptcha_site_key" value="{{ isset($settings->recaptcha_site_key) ? $settings->recaptcha_site_key : null }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.secret_key')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="recaptcha_secret_key" value="{{ isset($settings->recaptcha_secret_key) ? $settings->recaptcha_secret_key : null }}" class="form-control">
                    </div>
                  </div> 
                  <hr/>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.display_on_login')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="recaptcha_on_login">                               
                                 
                                <option value="1" @if($settings->recaptcha_on_login=="1") selected @endif>{{trans('words.on')}}</option>
                                <option value="0" @if($settings->recaptcha_on_login=="0") selected @endif>{{trans('words.off')}}</option>
                                              
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.display_on_signup')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="recaptcha_on_signup">                               
                                 
                                <option value="1" @if($settings->recaptcha_on_signup=="1") selected @endif>{{trans('words.on')}}</option>
                                <option value="0" @if($settings->recaptcha_on_signup=="0") selected @endif>{{trans('words.off')}}</option>
                                              
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.recaptcha_on_forgot_pass')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="recaptcha_on_forgot_pass">                               
                                 
                                <option value="1" @if($settings->recaptcha_on_forgot_pass=="1") selected @endif>{{trans('words.on')}}</option>
                                <option value="0" @if($settings->recaptcha_on_forgot_pass=="0") selected @endif>{{trans('words.off')}}</option>
                                              
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.recaptcha_on_contact_us')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="recaptcha_on_contact_us">                               
                                 
                                <option value="1" @if($settings->recaptcha_on_contact_us=="1") selected @endif>{{trans('words.on')}}</option>
                                <option value="0" @if($settings->recaptcha_on_contact_us=="0") selected @endif>{{trans('words.off')}}</option>
                                              
                            </select>
                      </div>
                  </div>
                   
                  <div class="form-group">
                    <div class="offset-sm-3 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save_settings')}} </button>                      
                    </div>
                  </div>
                {!! Form::close() !!} 
              </div>
            </div>            
          </div>              
        </div>
      </div>
      @include("admin.copyright") 
    </div> 
 
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