@extends("admin.admin_app")

@section("content")

 
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                  

                 {!! Form::open(array('url' => array('admin/menu_settings'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
   
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.shows_text')}}</label>
                      <div class="col-sm-9">
                            <select class="form-control" name="menu_shows">
                                 
                                <option value="1" @if($settings->menu_shows=="1") selected @endif>ON</option>
                                <option value="0" @if($settings->menu_shows=="0") selected @endif>OFF</option>
                                  
                            </select>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.movies_text')}}</label>
                      <div class="col-sm-9">
                            <select class="form-control" name="menu_movies">
                                 
                                <option value="1" @if($settings->menu_movies=="1") selected @endif>ON</option>
                                <option value="0" @if($settings->menu_movies=="0") selected @endif>OFF</option>
                                  
                            </select>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.sports_text')}}</label>
                      <div class="col-sm-9">
                            <select class="form-control" name="menu_sports">
                                 
                                <option value="1" @if($settings->menu_sports=="1") selected @endif>ON</option>
                                <option value="0" @if($settings->menu_sports=="0") selected @endif>OFF</option>
                                  
                            </select>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.live_tv')}}</label>
                      <div class="col-sm-9">
                            <select class="form-control" name="menu_livetv">
                                 
                                <option value="1" @if($settings->menu_livetv=="1") selected @endif>ON</option>
                                <option value="0" @if($settings->menu_livetv=="0") selected @endif>OFF</option>
                                  
                            </select>
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