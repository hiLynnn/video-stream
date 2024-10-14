@extends("admin.admin_app")

@section("content")

  
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card-box table-responsive">

                <div class="row">
                    <div class="col-md-3">
                      <a href="{{URL::to('admin/coupons/addcoupon')}}" class="btn btn-success btn-md waves-effect waves-light m-b-20" data-toggle="tooltip" title="{{trans('words.add_coupon')}}"><i class="fa fa-plus"></i> {{trans('words.add_coupon')}}</a>
                    </div>
                </div>    
                
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>{{trans('words.coupon_code')}}</th>
                      <th>{{trans('words.coupon_percentage')}}</th>
                      <th>{{trans('words.number_of_users')}}</th>
                      <th>{{trans('words.coupon_used')}}</th>
                      <th>{{trans('words.expiry_date')}}</th>
                      <th>{{trans('words.status')}}</th>                        
                      <th>{{trans('words.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($coupons as $i => $coupon_data)
                    <tr id="card_box_id_{{$coupon_data->id}}">
                      <td>{{ $coupon_data->coupon_code }}</td>
                      <td>{{ $coupon_data->coupon_percentage }}%</td>
                      <td>{{ $coupon_data->coupon_user_limit }}</td>
                      <td>{{ $coupon_data->coupon_used }}</td>
                      <td>{{ date('m/d/Y',$coupon_data->coupon_exp_date) }}</td>
                      <td>@if($coupon_data->status==1)<span class="badge badge-success">{{trans('words.active')}}</span> @else<span class="badge badge-danger">{{trans('words.inactive')}}</span>@endif</td>                       
                      <td>
                      <a href="{{ url('admin/coupons/addcoupon/'.$coupon_data->id) }}" class="btn btn-icon waves-effect waves-light btn-success m-b-5 m-r-5" data-toggle="tooltip" title="{{trans('words.edit')}}"> <i class="fa fa-edit"></i> </a>
                       
                      <a href="#" class="btn btn-icon waves-effect waves-light btn-danger m-b-5 data_remove" data-toggle="tooltip" title="{{trans('words.remove')}}" data-id="{{$coupon_data->id}}"> <i class="fa fa-remove"></i> </a>                            
                      </td>
                    </tr>
                   @endforeach
                     
                     
                     
                  </tbody>
                </table>
              </div>                 
              <nav class="paging_simple_numbers">
                @include('admin.pagination', ['paginator' => $coupons]) 
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include("admin.copyright") 
    </div>

    <script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}"></script>
 
 <script type="text/javascript">
 
 $(".data_remove").click(function () {  
   
   var post_id = $(this).data("id");
   var action_name='coupon_delete';
 
   Swal.fire({
     title: '{{trans('words.dlt_warning')}}',
   text: "{{trans('words.dlt_warning_text')}}",
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
             type: 'post',
             url: "{{ URL::to('admin/ajax_delete') }}",
             dataType: 'json',
             data: {"_token": "{{ csrf_token() }}",id: post_id, action_for: action_name},
             success: function(res) {
 
               if(res.status=='1')
               {  
 
                   var selector = "#card_box_id_"+post_id;
                     $(selector ).fadeOut(1000);
                     setTimeout(function(){
                             $(selector ).remove()
                         }, 1000);
 
                   Swal.fire({
                     position: 'center',
                     icon: 'success',
                     title: '{{trans('words.deleted')}}!',
                     showConfirmButton: true,
                     confirmButtonColor: '#10c469',
                     background:"#1a2234",
                     color:"#fff"
                   })
                 
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