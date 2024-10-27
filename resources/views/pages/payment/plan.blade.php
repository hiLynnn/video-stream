@extends('site_app')

@section('head_title', trans('words.subscription_plan').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')
  
@if(Session::has('order_id'))
<script>
        document.addEventListener('DOMContentLoaded', function() {
          $.ajax({
                url: "{{ route('success-payment') }}",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if(response.error === 0) {
                      console.log("response",response);
                        console.log("Payment Success:", response.data);
                        if(response.data.status === "PAID"){
                          const notification = document.querySelector('.payment-success-container');
                          notification.style.display = 'block';
                          setTimeout(function() {
                              notification.classList.add('fade-out');
                              notification.classList.add('hide'); // Use this class to trigger opacity to 0
                              setTimeout(function() {
                                  notification.style.display = 'none';
                              }, 500);
                          }, 2000);
                        }
                    } else {
                        console.error("Error:", response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                }
            });
        });
</script>
@endif
<!-- Start Breadcrumb -->
<div class="breadcrumb-section bg-xs" style="background-image: url('{{ URL::asset('site_assets/images/breadcrum-bg.jpg') }}')">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12"> 
        <h2>{{trans('words.subscription_plan')}} </h2>      
        <nav id="breadcrumbs">
            <ul>
              <li><a href="{{ URL::to('/') }}" title="{{trans('words.home')}}">{{trans('words.home')}}</a></li>
               <li>{{trans('words.subscription_plan')}}</li>

            </ul>
          </nav>
     </div>
      </div>
    </div>
  </div>
<!-- End Breadcrumb --> 

 <!-- Start Membership Plan Page -->
<div class="vfx-item-ptb vfx-item-info">
  <div class="container-fluid">
     <div class="row">
        
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">             
                {!! $message !!}
            </div>

            <?php Session::forget('success');?>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger">            
                {!! $message !!}
            </div>
            <?php Session::forget('error');?>
            @endif
          </div>
        </div>

        @foreach($plan_list as $plan_data)
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="membership-plan-list">
            <h3>{{$plan_data->plan_name}}</h3>
            <h1>
              @if(Session::get('coupon_percentage'))
              <?php 
                   $discount_price_less =  $plan_data->plan_price * Session::get('coupon_percentage') / 100;

                   $final_plan_price = $plan_data->plan_price - $discount_price_less;

              echo number_format($final_plan_price, 0, ',', '.'); 
              ?>
              @else
                {{ number_format($plan_data->plan_price, 0, ',', '.') }} VND
              @endif
              
            </h1>
            <p></p>
            <h4>{{ App\SubscriptionPlan::getPlanDuration($plan_data->id) }}</h4>
            <h4>{{trans('words.plan_device_limit')}} - {{ $plan_data->plan_device_limit }}</h4>
            <a href="{{ URL::to('payment_method/'.$plan_data->id) }}" class="vfx-item-btn-danger text-uppercase mb-30" title="plan">{{trans('words.select_plan')}}</a>
          </div>
        </div>
        @endforeach  
      
      </div>
    <!-- <div class="row">
      <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <div class="apply-coupon-code">
            <h2>{{trans('words.have_coupon_code')}}</h2>
            {!! Form::open(array('url' => 'apply_coupon_code','class'=>'','id'=>'apply_coupon','role'=>'form')) !!}
 

              <div class="apply-now-item">
                 
                  <input type="text" name="coupon_code" id="enterCode" value="{{Session::get('coupon_code')}}" class="form-control" placeholder="" required="">
                  @if(Session::get('coupon_percentage'))
                  <button class="vfx-item-btn-danger text-uppercase" type="submit">{{trans('words.coupon_applied')}}</button>
                  @else
                  <button class="vfx-item-btn-danger text-uppercase" type="submit">{{trans('words.apply_coupon')}}</button>
                  @endif
                  
                 
              </div>
            {!! Form::close() !!}  
          </div>
        </div>    
     </div>
  </div> -->
</div>
<!-- End Membership Plan Page -->
<style>
    /* Center the container */
    .payment-success-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999; /* Ensure it appears on top */
        display: none;
        width: 100%;
        max-width: 500px;
    }

    /* Add smooth fade-out effect */
    .fade-out {
        opacity: 1;
        transition: opacity 0.5s ease;
    }

    .fade-out.hide {
        opacity: 0;
    }
</style>
<div class="payment-success-container">
    <div class="card shadow p-4">
        <div class="text-center">
            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            <h2 class="mt-3">Thanh toán thành công!!</h2>
            <p class="lead">Cảm ơn bạn đã thanh toán. Tài khoản bạn đã nâng cấp thành công.</p>
            <hr>
            <div class="order-details mt-4">
                <button class="btn btn-primary mt-3" onclick="window.location.href='/your-dashboard'">
                    Về trang chủ
                </button>
            </div>
        </div>
    </div>
</div>

 
@endsection