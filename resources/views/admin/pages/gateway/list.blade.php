@extends("admin.admin_app")

@section("content")

  
<div class="content-page">
  <div class="content">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-12">
		  <div class="card-box table-responsive">
			@if(Session::has('flash_message'))
				<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				  <span aria-hidden="true">&times;</span></button>
					{{ Session::get('flash_message') }}
				</div>
			@endif
			<div class="row">
			  @foreach($list as $i => $data)
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
					<!-- Simple card -->
					<div class="card m-b-20 p-3 payment_block" style="">
						<div class="ads_logo_item" style="background:rgba(255, 255, 255, 0.9)">
						 <img class="card-img-top thumb-lg img-fluid" src="{{URL::to('/admin_assets/images/gateway/'.$data->id.'.png')}}" alt="{{ stripslashes($data->gateway_name) }}">
						</div>
						<div class="card-body p-0">
							<h4 class="card-title mb-3">{{ stripslashes($data->gateway_name) }}</h4>
							<a href="{{ url('admin/payment_gateway/edit/'.$data->id) }}" class="btn waves-effect waves-light btn-success m-r-5" data-toggle="tooltip" title="{{trans('words.edit')}}"> <i class="fa fa-edit"></i> Edit</a>
							<a href="Javascript:void(0);" class="ml-2 fl-right mt-1" data-toggle="tooltip" title="@if($data->status==1){{ trans('words.active')}} @else {{trans('words.inactive')}} @endif"><input type="checkbox" name="ads_on_off" id="ads_on_off" value="1" data-plugin="switchery" data-color="#28a745" data-size="small" class="enable_disable" data-id="{{$data->id}}" @if($data->status==1) {{ 'checked' }} @endif/></a>    
						</div>
					</div>
				</div>
			   @endforeach      
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  @include("admin.copyright") 
</div>

<script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ URL::asset('admin_assets/js/sweetalert2@11.js') }}"></script>


<script type="text/javascript">
 
$(".enable_disable").on("change",function(e){      
       
      var post_id = $(this).data("id");
      
      var status_set = $(this).prop("checked"); 

      var action_name='payment_status';
      //alert($(this).is(":checked"));
      //alert(status_set);

      $.ajax({
        type: 'post',
        url: "{{ URL::to('admin/ajax_status') }}",
        dataType: 'json',
        data: {"_token": "{{ csrf_token() }}",id: post_id, value: status_set, action_for: action_name},
        success: function(res) {

          if(res.status=='1')
          {
            Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{trans('words.status_changed')}}',
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
}); 

</script>    

@endsection