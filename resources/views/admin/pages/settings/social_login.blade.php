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
                 
                  
                 {!! Form::open(array('url' => array('admin/social_login_settings'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
   
                 <h5 class="mb-4" style="color:#f9f9f9"><i class="fa fa-google pr-2"></i> <b>Google Settings</b></h5>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.google_login')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="google_login">                               
                                 
                                <option value="1" @if($settings->google_login=="1") selected @endif>ON</option>
                                <option value="0" @if($settings->google_login=="0") selected @endif>OFF</option>
                                              
                            </select>
                      </div>
                  </div>
                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.google_client_id')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="google_client_id" value="{{ isset($settings->google_client_id) ? $settings->google_client_id : null }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.google_secret')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="google_client_secret" value="{{ isset($settings->google_client_secret) ? $settings->google_client_secret : null }}" class="form-control">
                    </div>
                  </div> 
                  <hr class="mt-4 mb-4">
                  <h5 class="mb-4" style="color:#f9f9f9"><i class="fa fa-facebook pr-2"></i> <b>Facebook Settings</b></h5>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.facebook_login')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="facebook_login">                               
                                 
                                <option value="1" @if($settings->facebook_login=="1") selected @endif>ON</option>
                                <option value="0" @if($settings->facebook_login=="0") selected @endif>OFF</option>
                                              
                            </select>
                      </div>
                  </div>
                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.facebook_app_id')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="facebook_app_id" value="{{ isset($settings->facebook_app_id) ? $settings->facebook_app_id : null }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.facebook_secret')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="facebook_client_secret" value="{{ isset($settings->facebook_client_secret) ? $settings->facebook_client_secret : null }}" class="form-control">
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