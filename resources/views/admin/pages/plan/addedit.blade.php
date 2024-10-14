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
                          <a href="{{ URL::to('admin/subscription_plan') }}"><h4 class="header-title m-t-0 m-b-30 text-primary pull-left" style="font-size: 20px;"><i class="fa fa-arrow-left"></i> {{trans('words.back')}}</h4></a>
                     </div>
                     
                   </div> 

                 {!! Form::open(array('url' => array('admin/subscription_plan/add_edit_plan'),'class'=>'form-horizontal','name'=>'slider_form','id'=>'slider_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($plan_info->id) ? $plan_info->id : null }}">
  
                   
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.plan_name')}} *</label>
                    <div class="col-sm-8">
                      <input type="text" name="plan_name" value="{{ isset($plan_info->plan_name) ? $plan_info->plan_name : null }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.duration')}} *</label>
                    <div class="col-sm-4">
                      <input type="number" name="plan_duration" value="{{ isset($plan_info->plan_duration) ? $plan_info->plan_duration : null }}" class="form-control" placeholder="7">
                    </div>
                    <div class="col-sm-4">
                        <select name="plan_duration_type" class="form-control">
                         <option value="1" @if(isset($plan_info->plan_duration_type) AND $plan_info->plan_duration_type=='1') selected @endif>Day(s)</option>
                         <option value="30" @if(isset($plan_info->plan_duration_type) AND $plan_info->plan_duration_type=='30') selected @endif>Month(s)</option>
                         <option value="365" @if(isset($plan_info->plan_duration_type) AND $plan_info->plan_duration_type=='365') selected @endif>Year(s)</option>
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.price')}} *</label>
                    <div class="col-sm-8">
                      <input type="number" name="plan_price" value="{{ isset($plan_info->plan_price) ? $plan_info->plan_price : null }}" class="form-control" placeholder="9.99" step="0.01" min="0">
                      <small id="emailHelp" class="form-text text-muted mb-2">The minimum amount for processing a transaction through Stripe in USD is $0.50. For more info <a href="https://support.chargebee.com/support/solutions/articles/228511-transaction-amount-limit-in-stripe" target="_blank">click here</a></small>
                    </div>
                  </div>   

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.plan_device_limit')}} *</label>
                    <div class="col-sm-8">
                      <input type="text" name="plan_device_limit" value="{{ isset($plan_info->plan_device_limit) ? $plan_info->plan_device_limit : null }}" class="form-control" placeholder="1" min="1">
                       
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.ads_on_off')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="ads_on_off">                               
                                <option value="1" @if(isset($plan_info->ads_on_off) AND $plan_info->ads_on_off==1) selected @endif>{{trans('words.on')}}</option>
                                <option value="0" @if(isset($plan_info->ads_on_off) AND $plan_info->ads_on_off==0) selected @endif>{{trans('words.off')}}</option>                            
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.status')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="status">                               
                                <option value="1" @if(isset($plan_info->status) AND $plan_info->status==1) selected @endif>{{trans('words.active')}}</option>
                                <option value="0" @if(isset($plan_info->status) AND $plan_info->status==0) selected @endif>{{trans('words.inactive')}}</option>                            
                            </select>
                      </div>
                  </div>

                  <div class="form-group row mb-0">
                     
                  </div>

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