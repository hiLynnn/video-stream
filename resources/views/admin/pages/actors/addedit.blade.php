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

                    <div class="row">
                     <div class="col-sm-6">
                          <a href="{{ URL::to('admin/actor') }}"><h4 class="header-title m-t-0 m-b-30 text-primary pull-left" style="font-size: 20px;"><i class="fa fa-arrow-left"></i> {{trans('words.back')}}</h4></a>
                     </div>
                     </div> 
                 
                 {!! Form::open(array('url' => array('admin/actor/add_edit'),'class'=>'form-horizontal','name'=>'category_form','id'=>'actor_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($post_info->id) ? $post_info->id : null }}">

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.actor_name')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="actor_name" value="{{ isset($post_info->ad_name) ? stripslashes($post_info->ad_name) : null }}" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.ad_bio')}}</label>
                    <div class="col-sm-8">
                        <textarea id="elm1" name="ad_bio" class="form-control">{{ isset($post_info->ad_bio) ? stripslashes($post_info->ad_bio) : null }}</textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.ad_place_of_birth')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="ad_place_of_birth" value="{{ isset($post_info->ad_place_of_birth) ? stripslashes($post_info->ad_place_of_birth) : null }}" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.ad_birthdate')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="ad_birthdate" id="datepicker-autoclose" value="{{ isset($post_info->ad_birthdate) ? date('m/d/Y',$post_info->ad_birthdate) : old('ad_birthdate') }}" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label class="col-sm-2 col-form-label">{{trans('words.image')}}</label>
                    <div class="col-sm-8">                       
                      <div class="input-group">
                          <input type="text" name="actor_image" id="actor_image" value="{{ isset($post_info->ad_image) ? $post_info->ad_image : null }}" class="form-control" readonly>
                          <div class="input-group-append">                           
                            <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="actor_image" data-preview="holder_thumb" data-inputid="actor_image">Select</button>                        
                          </div>
                      </div>
                      <small id="emailHelp" class="form-text text-muted mb-3">({{trans('words.recommended_resolution')}} : 180x140)</small>
                      <div id="thumb_image_holder" style="margin-top:5px; margin-bottom:10px;max-height:100px;"></div>                     
                    </div>
                  </div>

                  @if(isset($post_info->ad_image)) 
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">                                                                         
                      <img src="{{URL::to('/'.$post_info->ad_image)}}" alt="video image" class="img-thumbnail" width="180">                                               
                    </div>
                  </div>
                  @endif
                   
                  <div class="form-group">
                    <div class="offset-sm-2 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save')}} </button>                      
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
     
     
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) {

    //alert(requestingField);

    var elfinderUrl = "{{ URL::to('/') }}/";

    if(requestingField=="actor_image")
    {
      var target_preview = $('#thumb_image_holder');
      target_preview.html('');
      target_preview.append(
              $('<img>').css('height', '5rem').attr('src', elfinderUrl + filePath.replace(/\\/g,"/"))
            );
      target_preview.trigger('change');
    }
 
    //$('#' + requestingField).val(filePath.split('\\').pop()).trigger('change'); //For only filename
    $('#' + requestingField).val(filePath.replace(/\\/g,"/")).trigger('change');
 
}
 
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