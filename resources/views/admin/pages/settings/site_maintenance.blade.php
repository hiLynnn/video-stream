@extends("admin.admin_app")

@section("content")
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                 
                  
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">
 
                    @if($settings->maintenance_mode=="down")

                    <a href="#" class="btn btn-danger btn-md waves-effect waves-light m-b-20 mt-2 pull-right maintenance_on" data-toggle="tooltip" title="{{trans('words.maintenance_mode_on')}}" data-id="down">
                        <i class="fa fa-wrench"></i> 
                        {{trans('words.maintenance_mode_on')}}
                    </a>

                    @else
                    <a href="#" class="btn btn-success btn-md waves-effect waves-light m-b-20 mt-2 pull-right maintenance_on_off" data-toggle="tooltip" title="{{trans('words.maintenance_mode_off')}}" data-id="up">
                                <i class="fa fa-bullseye"></i>
                                {{trans('words.maintenance_mode_off')}}
                    </a>

                    @endif
                     
                    </div>

                    
                   
                </div>

                 {!! Form::open(array('url' => array('admin/site_maintenance'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
  
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.title')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="maintenance_title" value="{{ isset($settings->maintenance_title	) ? $settings->maintenance_title : null }}" class="form-control" placeholder="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.description')}}</label>
                    <div class="col-sm-8">
                      <textarea id="elm1" name="maintenance_description" class="form-control">{{ isset($settings->maintenance_description) ? stripslashes($settings->maintenance_description) : null }}</textarea>
                       
                    </div>
                  </div>   
                  <hr/>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.maintenance_secret')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="maintenance_secret" value="{{ isset($settings->maintenance_secret) ? $settings->maintenance_secret : null }}" class="form-control" placeholder="">
                       
                      <small class="form-text text-muted" style="font-size: 14px;">
                      <br/>
                      After placing the site in maintenance mode, you may navigate to the site URL matching this secret token and script will issue a maintenance mode bypass cookie to your browser.<br/><br/>

                      To get access to your site when it's maintenance mode please copy this link to access: <a href="{{ URL::to('/'.$settings->maintenance_secret) }}" target="_blank">{{ URL::to('/'.$settings->maintenance_secret) }}</a>
                      <br/><br/>
                      Once the cookie has been issued to your browser, you will be able to browse the application normally as if it was not in maintenance mode.
                      </small>
                    </div>
                  </div>    
                  <div class="form-group">
                    <div class="offset-sm-2 col-sm-9 pl-1">
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

    <script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}"></script>
 
<script type="text/javascript">

$(".maintenance_on_off").click(function () {  
  
  var mode = $(this).data("id");
  
  Swal.fire({
  title: '{{trans('words.dlt_warning')}}',  
  text: '{{trans('words.maintenance_enable_msg')}}',   
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: '{{trans('words.enable_it')}}',
  cancelButtonText: '{{trans('words.btn_cancel')}}',
  background:"#1a2234",
  color:"#fff"

}) 
.then((result) => {

  //alert(post_id);

  //alert(JSON.stringify(result));

    if(result.isConfirmed) { 

        $.ajax({
            type: 'post',
            url: "{{ URL::to('admin/site_maintenance_on_off') }}",
            dataType: 'json',
            data: {"_token": "{{ csrf_token() }}",mode: mode},
            success: function(res) {

              if(res.status=='down')
              {  
  
                  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{trans('words.maintenance_mode_on')}}!',                     
                    showConfirmButton: true,
                    confirmButtonColor: '#10c469',
                    background:"#1a2234",
                    color:"#fff"
                  }).then(function() {
                          window.location = "{{ URL::to('admin/site_maintenance') }}";
                      });
                  
                
              } 
              else
              { 
                Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Something went wrong!',
                        showConfirmButton: true,
                        confirmButtonColor: '#10c469',
                        background:"#1a2234",
                        color:"#fff"
                       }).then(function() {
                          window.location = "{{ URL::to('admin/site_maintenance') }}";
                      });
              }

               
            }
        });
    }
 
})

});

$(".maintenance_on").click(function () {  
  
  var mode = $(this).data("id");
  
  Swal.fire({
  title: '{{trans('words.dlt_warning')}}',  
  text: "{{trans('words.maintenance_disable_msg')}}",   
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: '{{trans('words.disable_it')}}',
  cancelButtonText: "{{trans('words.btn_cancel')}}",
  background:"#1a2234",
  color:"#fff"

}) 
.then((result) => {

  //alert(post_id);

  //alert(JSON.stringify(result));

    if(result.isConfirmed) { 

        $.ajax({
            type: 'post',
            url: "{{ URL::to('admin/site_maintenance_on_off') }}",
            dataType: 'json',
            data: {"_token": "{{ csrf_token() }}",mode: mode},
            success: function(res) {

              if(res.status=='up')
              {  
  
                  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{trans('words.maintenance_mode_off')}}!',
                    showConfirmButton: true,
                    confirmButtonColor: '#10c469',
                    background:"#1a2234",
                    color:"#fff"
                  }).then(function() {
                          window.location = "{{ URL::to('admin/site_maintenance') }}";
                      });
                
              }              
              else
              { 
                Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Something went wrong!',
                        showConfirmButton: true,
                        confirmButtonColor: '#10c469',
                        background:"#1a2234",
                        color:"#fff"
                       }).then(function() {
                          window.location = "{{ URL::to('admin/site_maintenance') }}";
                      });
              }
              
            }
        });
    }
 
})

});

</script>

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