@extends("admin.admin_app")

@section("content")
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                  
                 {!! Form::open(array('url' => array('admin/web_ads_settings'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
   
                 <h5 class="mb-4" style="color:#f9f9f9"><i class="fa fa-buysellads pr-2"></i> <b>Banner Ads</b></h5>

                  <div class="alert alert-info"><b>Note:</b> Leave empty if not want to display</div>
 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Home Top</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="home_top" class="form-control">{{ isset($settings->home_top) ? stripslashes($settings->home_top) : null }}</textarea>

                    </div>
                  </div>                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Home Bottom</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="home_bottom" class="form-control">{{ isset($settings->home_bottom) ? stripslashes($settings->home_bottom) : null }}</textarea>

                    </div>
                  </div>
                  <hr/> 

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">List Top</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="list_top" class="form-control">{{ isset($settings->list_top) ? stripslashes($settings->list_top) : null }}</textarea>

                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">List Bottom</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="list_bottom" class="form-control">{{ isset($settings->list_bottom) ? stripslashes($settings->list_bottom) : null }}</textarea>

                    </div>
                  </div>
                  <hr/> 

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Details Top</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="details_top" class="form-control">{{ isset($settings->details_top) ? stripslashes($settings->details_top) : null }}</textarea>

                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Details Bottom</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="details_bottom" class="form-control">{{ isset($settings->details_bottom) ? stripslashes($settings->details_bottom) : null }}</textarea>

                    </div>
                  </div>
                  <hr/> 

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Other Pages Top</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="other_page_top" class="form-control">{{ isset($settings->other_page_top) ? stripslashes($settings->other_page_top) : null }}</textarea>

                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Other Pages Bottom</label>
                    <div class="col-sm-8">                       
                      
                    <textarea name="other_page_bottom" class="form-control">{{ isset($settings->other_page_bottom) ? stripslashes($settings->other_page_bottom) : null }}</textarea>

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