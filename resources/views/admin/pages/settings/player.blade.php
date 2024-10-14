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
                  
                 {!! Form::open(array('url' => array('admin/player_settings'),'class'=>'form-horizontal','name'=>'player_settings','id'=>'player_settings','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
                  <div class="row">

                  <div class="col-md-8">
                  <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.player_options')}}</h4>

                  <br/>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.player_style')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="player_style">                               
                                 
                                <option value="classic_skin_dark" @if($settings->player_style=="classic_skin_dark") selected @endif>Clasic Dark</option>
                                <option value="metal_skin_dark" @if($settings->player_style=="metal_skin_dark") selected @endif>Metal Dark</option>
                                <option value="minimal_skin_dark" @if($settings->player_style=="minimal_skin_dark") selected @endif>Minimal Dark</option>
                                <option value="modern_skin_dark" @if($settings->player_style=="modern_skin_dark") selected @endif>Modern Dark</option>
                                  
                            </select>
                      </div>
                  </div> 

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.vector_icons')}}</label>
                    <div class="col-sm-8">
                       <select class="form-control" name="player_vector_icons">
                                <option value="no" @if($settings->player_vector_icons=="no") selected @endif>NO</option>
                                <option value="yes" @if($settings->player_vector_icons=="yes") selected @endif>YES</option>
                                  
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.autoplay')}}</label>
                    <div class="col-sm-8">
                       <select class="form-control" name="autoplay">
                                <option value="yes" @if($settings->autoplay=="yes") selected @endif>YES</option>
                                <option value="no" @if($settings->autoplay=="no") selected @endif>NO</option>
                                  
                        </select>
                    </div>
                  </div>
                    
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.rewind_forward')}}</label>
                    <div class="col-sm-8">
                       <select class="form-control" name="rewind_forward">
                                <option value="no" @if($settings->rewind_forward=="no") selected @endif>NO</option>
                                <option value="yes" @if($settings->rewind_forward=="yes") selected @endif>YES</option>
                                  
                        </select>
                    </div>
                  </div> 
                  <hr>
                  <h4 class="m-t-0 header-title" >{{trans('words.player_watermark')}}</h4>

                  <br/>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.watermark')}}</label>
                    <div class="col-sm-8">
                       <select class="form-control" name="player_watermark">
                                <option value="no" @if($settings->player_watermark=="no") selected @endif>NO</option>
                                <option value="yes" @if($settings->player_watermark=="yes") selected @endif>YES</option>
                                  
                        </select>
                    </div>
                  </div>
 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.player_logo')}}</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" name="player_logo" id="player_logo" value="{{ isset($settings->player_logo) ? $settings->player_logo : null }}" class="form-control" readonly>
                        <div class="input-group-append">                           
                          <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="player_logo" data-preview="holder_thumb" data-inputid="player_logo">Select</button>                        
                        </div>
                      </div>
                      <small id="emailHelp" class="form-text text-muted">({{trans('words.recommended_resolution')}} : 180x50)</small>
                      <div id="player_logo_holder" style="margin-top:5px;max-height:100px;"></div>                     
                    </div>
                  </div>                 

                  @if(isset($settings->player_logo)) 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">                                                                         
                      <img src="{{URL::to('/'.$settings->player_logo)}}" alt="video image" class="img-thumbnail" width="160">                                               
                    </div>
                  </div>
                  @endif
                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.player_logo_position')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="player_logo_position">                               
                                 
                                <option value="topRight" @if($settings->player_logo_position=="topRight") selected @endif>Top Right</option>
                                <option value="topLeft" @if($settings->player_logo_position=="topLeft") selected @endif>Top Left</option>
                                <option value="bottomRight" @if($settings->player_logo_position=="bottomRight") selected @endif>Bottom Right</option>
                                <option value="bottomLeft" @if($settings->player_logo_position=="bottomLeft") selected @endif>Bottom Left</option>
                                  
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.player_url')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="player_url" value="{{ isset($settings->player_url) ? $settings->player_url : null }}" class="form-control">
                    </div>
                  </div>
                  <hr>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.player_default_ads')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="player_default_ads">                               
                                
                                <option value="None" @if($settings->player_default_ads=="None") selected @endif>None (No Ads)</option>
                                <option value="Custom" @if($settings->player_default_ads=="Custom") selected @endif>Built-in Advertisement</option>
                                <option value="Vast" @if($settings->player_default_ads=="Vast") selected @endif>VAST, VMAP and IMA</option>
                                 
                                  
                            </select>

                            <small id="emailHelp" class="form-text text-muted">(Based on you Player Ads settings)</small>
                      </div>
                      
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary waves-effect waves-light pull-right"> {{trans('words.save_settings')}} </button>
                    </div>
                  </div>

                  

                  </div>
                   
                </div> 
                  
                {!! Form::close() !!} 

                <div class="alert alert-danger"><b>Note:</b> This settings only work with web player</div>
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

    if(requestingField=="player_logo")
    {
      var target_preview = $('#player_logo_holder');
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