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
                          <a href="{{ URL::to('admin/coupons') }}"><h4 class="header-title m-t-0 m-b-30 text-primary pull-left" style="font-size: 20px;"><i class="fa fa-arrow-left"></i> {{trans('words.back')}}</h4></a>
                     </div>
                     
                   </div>
                   
                 {!! Form::open(array('url' => array('admin/coupons/addcoupon'),'class'=>'','name'=>'category_form','id'=>'category_form','role'=>'form','enctype' => 'multipart/form-data')) !!}

                  <input type="hidden" name="id" value="{{ isset($coupon_obj->id) ? $coupon_obj->id : null }}">
  
                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.coupon_code')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" id="coupon_code" name="coupon_code" value="{{ isset($coupon_obj->coupon_code) ? $coupon_obj->coupon_code : null }}" class="form-control"> <br/><button type="button" onclick="getcouponcode()"  class="btn btn-success">{{trans('words.generate')}}</button>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.coupon_percentage')}}*</label>
                    <div class="col-sm-8">
                      <input type="number" id="coupon_percentage" name="coupon_percentage" value="{{ isset($coupon_obj->coupon_percentage) ? $coupon_obj->coupon_percentage : null }}" class="form-control" min="1" max="100">
                    </div>
                  </div>  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.number_of_users')}}*</label>
                    <div class="col-sm-8">
                      <input type="number" id="coupon_user_limit" name="coupon_user_limit" value="{{ isset($coupon_obj->coupon_user_limit) ? $coupon_obj->coupon_user_limit : null }}" class="form-control">  
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.expiry_date')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" id="datepicker-autoclose" name="coupon_exp_date" value="{{ isset($coupon_obj->coupon_exp_date) ? date('m/d/Y',$coupon_obj->coupon_exp_date) : null }}" class="form-control">  
                    </div>
                  </div>
                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.status')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="status">                               
                                <option value="1" @if(isset($coupon_obj->status) AND $coupon_obj->status==1) selected @endif>{{trans('words.active')}}</option>
                                <option value="0" @if(isset($coupon_obj->status) AND $coupon_obj->status==0) selected @endif>{{trans('words.inactive')}}</option>                            
                            </select>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="offset-sm-3 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> Save</button>                      
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
  function getcouponcode() {

    var length = 10;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      
      for(var i = 0; i < length; i++) {
      
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      
      }

      $('#coupon_code').val(text);
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