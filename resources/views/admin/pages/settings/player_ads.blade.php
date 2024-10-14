@extends("admin.admin_app")

@section("content")

  
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                  
                 {!! Form::open(array('url' => array('admin/player_ad_settings'),'class'=>'form-horizontal','name'=>'player_ad_settings','id'=>'player_ad_settings','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
                  <div class="row">

                  <div class="col-md-6">
                  <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.vast_vmap')}}</h4>

                  <br/>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-8">
                    <p>Currently support inline linear (pre-roll, mid-roll, post-roll, pods) and nonlinear ads. To add an VAST, VMAP or Google IMA URL path to the player to be played.<p>

                    
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.source_type')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="vast_type" id="vast_type">                               
                                <option value="Local" @if(isset($settings->vast_type) AND $settings->vast_type=="Local") selected @endif>Local</option>
                                <option value="URL" @if(isset($settings->vast_type) AND $settings->vast_type=="URL") selected @endif>URL</option>
                                                             
                            </select>
                      </div>
                  </div>
                  <div class="form-group row" id="vast_local_id" @if($settings->vast_type!="Local") style="display:none;" @endif>

                    
                    <label class="col-sm-3 col-form-label">{{trans('words.vast_file')}} <small id="emailHelp" class="form-text text-muted"></small></label>
                    <div class="col-sm-8">
                      <div class="input-group">

                        <input type="text" name="ad_video_local" id="ad_video_local" value="{{ isset($settings->vast_url) ? $settings->vast_url : null }}" class="form-control" readonly>
                        <div class="input-group-append">                           
                            <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="ad_video_local" data-inputid="ad_video_local">Select</button>
                        
                          </div>
                      </div>
                     
                    </div>
                     
                    </div>
                   

                  <div class="form-group row" id="vast_url_id" @if($settings->vast_type!="URL" AND $settings->vast_type!="") style="display:none;" @endif>
 
                    <label class="col-sm-3 col-form-label">{{trans('words.vast_url')}} <small id="emailHelp" class="form-text text-muted"></small></label>
                     <div class="col-sm-8">
                      <input type="text" name="ad_video_url" value="{{ isset($settings->vast_url) ? $settings->vast_url : null }}" class="form-control" placeholder="http://example.com/demo.mp4">
                    </div>
 
                  </div>
                   
  

                  </div>
                  <div class="col-md-6">
                  <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.built_in_ads')}}</h4>
                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-8">
                    <p><b>Source:</b> The ad source, it can be a mp4 video path, an image path, webpage URL or a youtube video url.<p>

                    <p><b>Timestart :</b> The ad start time when it will appear in hours:minutes:seconds format.<p>

                    <p><b>Link:</b> The link to open when the ad is clicked.<p>
                    </div>
                  </div>
                   
                  <div class="form-group row">
 
                    <label class="col-sm-3 col-form-label">Ad1 Source <small id="emailHelp" class="form-text text-muted"></small></label>
                    <div class="col-sm-8">
                      <div class="input-group">

                        <input type="text" name="custom_ad1_source" id="custom_ad1_source" value="{{ isset($settings->custom_ad1_source) ? $settings->custom_ad1_source : null }}" class="form-control">
                        
                      </div>
                     
                    </div>
                     
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ad1 Timestart </label>
                    <div class="col-sm-8">
                      <input type="text" name="custom_ad1_timestart" value="{{ isset($settings->custom_ad1_timestart) ? $settings->custom_ad1_timestart : null }}" class="form-control" placeholder="00:00:10">
                       
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ad1 Link </label>
                    <div class="col-sm-8">
                      <input type="text" name="custom_ad1_link" value="{{ isset($settings->custom_ad1_link) ? $settings->custom_ad1_link : null }}" class="form-control" placeholder="">
                       
                    </div>
                  </div>
                  <hr/> 

                  <div class="form-group row">
 
                    <label class="col-sm-3 col-form-label">Ad2 Source <small id="emailHelp" class="form-text text-muted"></small></label>
                    <div class="col-sm-8">
                      <div class="input-group">

                        <input type="text" name="custom_ad2_source" id="custom_ad2_source" value="{{ isset($settings->custom_ad2_source) ? $settings->custom_ad2_source : null }}" class="form-control">
                         
                      </div>
                     
                    </div>
                     
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ad2 Timestart </label>
                    <div class="col-sm-8">
                      <input type="text" name="custom_ad2_timestart" value="{{ isset($settings->custom_ad2_timestart) ? $settings->custom_ad2_timestart : null }}" class="form-control" placeholder="00:30:00">
                       
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ad2 Link </label>
                    <div class="col-sm-8">
                      <input type="text" name="custom_ad2_link" value="{{ isset($settings->custom_ad2_link) ? $settings->custom_ad2_link : null }}" class="form-control" placeholder="">
                       
                    </div>
                  </div>
                  <hr/> 

                  <div class="form-group row">
 
                    <label class="col-sm-3 col-form-label">Ad3 Source <small id="emailHelp" class="form-text text-muted"></small></label>
                    <div class="col-sm-8">
                      <div class="input-group">

                        <input type="text" name="custom_ad3_source" id="custom_ad3_source" value="{{ isset($settings->custom_ad3_source) ? $settings->custom_ad3_source : null }}" class="form-control">
                         
                      </div>
                     
                    </div>
                     
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ad3 Timestart </label>
                    <div class="col-sm-8">
                      <input type="text" name="custom_ad3_timestart" value="{{ isset($settings->custom_ad3_timestart) ? $settings->custom_ad3_timestart : null }}" class="form-control" placeholder="01:30:00">
                       
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ad3 Link </label>
                    <div class="col-sm-8">
                      <input type="text" name="custom_ad3_link" value="{{ isset($settings->custom_ad3_link) ? $settings->custom_ad3_link : null }}" class="form-control" placeholder="">
                       
                    </div>
                  </div>

                   
                  <div class="form-group">
                    <div class="offset-sm-8 col-sm-9">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save_settings')}} </button>                      
                    </div>
                  </div>

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
    $("#vast_type").change(function(){         
   var type=$("#vast_type").val();

       if(type=="Local")
       {
          $("#vast_local_id").show();
          $("#vast_url_id").hide();
       }
       else
       {
          $("#vast_local_id").hide();
          $("#vast_url_id").show();
       }

 });
</script>

<script type="text/javascript">
 
 
     
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) {

    //alert(requestingField);

    var elfinderUrl = "{{ URL::to('/') }}/";
 
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