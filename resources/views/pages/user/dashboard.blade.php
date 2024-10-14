@extends('site_app')

@section('head_title', trans('words.dashboard_text').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')
  

<!-- Start Breadcrumb -->
<div class="breadcrumb-section bg-xs" style="background-image: url('{{ URL::asset('site_assets/images/breadcrum-bg.jpg') }}')">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12"> 
        <h2>{{trans('words.dashboard_text')}}</h2>
          <nav id="breadcrumbs">
            <ul>
              <li><a href="{{ URL::to('/') }}" title="{{trans('words.home')}}">{{trans('words.home')}}</a></li>
              <li>{{trans('words.dashboard_text')}}</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
<!-- End Breadcrumb --> 

<!-- Start Dashboard Page -->
<div class="vfx-item-ptb vfx-item-info">
  <div class="container-fluid">
     <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 

       <div class="profile-section">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
          <div class="img-profile"> 
            @if(Auth::User()->user_image)
              <img src="{{ URL::asset('upload/'.Auth::User()->user_image) }}" class="img-rounded" alt="profile pic" title="profile pic">
            @else  
              <img src="{{ URL::asset('site_assets/images/user-avatar.png') }}" class="img-rounded" alt="profile_img" title="profile pic">
            @endif
             
          </div>
          <div class="profile_title_item">
            <h5>{{Auth::User()->name}}</h5>
            <p>{{Auth::User()->email}}</p>
            <a href="{{ URL::to('profile') }}" class="vfx-item-btn-danger text-uppercase"><i class="fa fa-edit"></i>{{trans('words.edit')}}</a><br/><br/>
            
            <a href="#" class="vfx-item-btn-danger text-uppercase data_remove"><i class="fa fa-trash"></i>Account Delete</a>
          </div>
          </div>
          <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="member-ship-option">
              
              <h5 class="color-up">{{trans('words.my_subscription')}}</h5>
              
              @if($user->plan_id!=0)
              
                <span class="premuim-memplan-bold-text"><strong>{{trans('words.current_plan')}}:</strong><span>{{\App\SubscriptionPlan::getSubscriptionPlanInfo($user->plan_id,'plan_name')}}</span></span>
                
                @if($user->exp_date)
                <span class="premuim-memplan-bold-text"><strong>{{trans('words.subscription_expires_on')}}:</strong><span>{{date('F,  d, Y',$user->exp_date)}}</span></span>
                @endif
              
                <div class="mt-3"><a href="{{ URL::to('membership_plan') }}" class="vfx-item-btn-danger text-uppercase">{{trans('words.upgrade_plan')}}</a></div>

              @else

                <div class="mt-3"><a href="{{ URL::to('membership_plan') }}" class="vfx-item-btn-danger text-uppercase">{{trans('words.select_plan')}}</a></div>
                
              @endif
              
              </div>
            
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="member-ship-option">
              <h5 class="color-up">{{trans('words.last_invoice')}}</h5>
              <span class="premuim-memplan-bold-text"><strong>{{trans('words.date')}}:</strong>
                @if($user->start_date)
                <span>{{date('F,  d, Y',$user->start_date)}}</span>
                @endif
              </span>
              <span class="premuim-memplan-bold-text"><strong>{{trans('words.plan')}}:</strong>
                @if($user->plan_id)
                <span>{{\App\SubscriptionPlan::getSubscriptionPlanInfo($user->plan_id,'plan_name')}}</span>
                @endif
              </span>
              <span class="premuim-memplan-bold-text"><strong>{{trans('words.amount')}}:</strong>
                @if($user->plan_amount)
                <span>{{number_format($user->plan_amount,2,'.', '') }}</span>
                @endif
              </span> 
                 
              </div>
            </div>
          </div>
          </div>  
        </div>
       </div>
     </div>
  
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      
      <div class="table-wrapper">

       <div class="vfx-item-section">
          <h3>{{trans('words.user_history')}}</h3>           
      </div>
  

      <table class="fl-table">
        <thead>
          <tr>            
            <th>{{trans('words.plan')}}</th>
            <th>{{trans('words.amount')}}</th>
            <th>{{trans('words.payment_gateway')}}</th>
            <th>{{trans('words.payment_id')}}</th>
            <th>{{trans('words.payment_date')}}</th>
          </tr>
        </thead> 
        <tbody>
          @foreach($transactions_list as $i => $transaction_data)
          <tr>                      
            <td><span class="current-plan-item">{{\App\SubscriptionPlan::getSubscriptionPlanInfo($transaction_data->plan_id,'plan_name')}}</span></td>
            <td>{{html_entity_decode(getCurrencySymbols(getcong('currency_code')))}} {{ number_format($transaction_data->payment_amount,2) }}
            @if($transaction_data->coupon_code!="")
              &nbsp;
              (Coupon Used: {{$transaction_data->coupon_code}})
            @endif
            </td>
            <td>{{ $transaction_data->gateway }}</td>
            <td>{{ $transaction_data->payment_id }}</td>    
            <td><span class="expires-plan-item">{{ date('M d Y h:i A',$transaction_data->date) }}</span></td>            
          </tr>
          @endforeach           
        <tbody>
      </table>
        </div>

      <div class="col-xs-12"> 

        @include('_particles.pagination', ['paginator' => $transactions_list])
     
      </div>

     </div>
    </div>
  </div>
</div>
<!-- End Dashboard Page -->   

@include("pages.user.logged_in_device_list")

<script src="{{ URL::asset('site_assets/js/jquery-3.3.1.min.js') }}"></script> 

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

  @if(Session::has('success'))     
 
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
        title: '{{ Session::get('success') }}'
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

 
$(".data_remove").click(function () {  
  
  var post_id = $(this).data("id");
    
  Swal.fire({
    title: '{{trans('words.dlt_warning')}}',
  text: "{{trans('words.user_dlt_confirm')}}",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: '{{trans('words.dlt_confirm')}}',
  cancelButtonText: "{{trans('words.btn_cancel')}}",
  background:"#1a2234",
  color:"#fff"

}).then((result) => {

  //alert(post_id);

  //alert(JSON.stringify(result));

    if(result.isConfirmed) { 

        $.ajax({
            type: 'get',
            url: "{{ URL::to('account_delete') }}",
            dataType: 'json',
            data: {id: ''},
            success: function(res) {

              if(res.status=='1')
              {  
 
                  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{trans('words.deleted')}}!',
                    text: '{{trans('words.user_dlt_success')}}',
                    showConfirmButton: true,
                    confirmButtonColor: '#10c469',
                    background:"#1a2234",
                    color:"#fff"
                  }).then(function() {
                                  window.location = "{{ URL::to('/') }}";
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
                       })
              }
              
            }
        });
    }
 
})

});
 

  </script>
 
@endsection