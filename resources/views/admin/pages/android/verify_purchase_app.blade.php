@extends("admin.admin_app")

@section("content")

  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-12">
              <div class="card-box">
                 
                {!! Form::open(array('url' => 'admin/verify_purchase_app','class'=>'form-horizontal','name'=>'profile_form','id'=>'profile_form','role'=>'form','enctype' => 'multipart/form-data')) !!}
                  
                    
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Envato Username *</label>
                    <div class="col-sm-8">
                       <input type="text" name="buyer_name" value="{{env('BUYER_NAME')}}" class="form-control">
                    </div>
                  </div>                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Buyer Purchase Code *</label>
                    <div class="col-sm-8">
                       <input type="text" name="purchase_code" value="{{env('BUYER_PURCHASE_CODE')}}" class="form-control" value="">
                       <small id="emailHelp" class="form-text text-muted">If you don't know <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">click here</a></small>
                    </div>
                  </div>                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">App Package Name *</label>
                    <div class="col-sm-8">
                       <input type="text" name="app_package_name" value="{{env('BUYER_APP_PACKAGE_NAME')}}" class="form-control">
                    </div>
                  </div> 
                  <div class="form-group">
                    <div class="offset-sm-3 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save')}} </button>                      
                    </div>
                  </div>
                {!! Form::close() !!} 

                <div class="alert alert-info">
                       
                        <b>Note:</b>  Use app purchase code only, not work with script purchase code.
                </div>

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

  @if(Session::has('flash_error_message'))     
 
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
        title: '{{ Session::get('flash_error_message') }}'
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