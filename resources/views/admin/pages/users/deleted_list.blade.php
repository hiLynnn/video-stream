@extends("admin.admin_app")

@section("content")

  
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card-box table-responsive">

                <div class="row">
                  <div class="col-sm-3 m-b-20">
                  {!! Form::open(array('url' => 'admin/deleted_users','class'=>'app-search','id'=>'search','role'=>'form','method'=>'get')) !!}   
                      <input type="text" name="s" placeholder="{{trans('words.search_by_name_email')}}" class="form-control">
                      <button type="submit"><i class="fa fa-search"></i></button>
                    {!! Form::close() !!}
                  </div>
                  <div class="col-md-3">
                    
                  </div>             
                <div class="col-md-3">
                   
                </div>
                <div class="col-md-3">
                   
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
                      <th>{{trans('words.name')}}</th>
                      <th>{{trans('words.email')}}</th>
                      <th>{{trans('words.phone')}}</th>
                       <th>{{trans('words.action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($user_list as $i => $user_data)
                    <tr id="card_box_id_{{$user_data->id}}">
                      <td>{{ $user_data->name }}</td>
                      <td>{{ $user_data->email }}</td>
                      <td>{{ $user_data->phone }}</td>
                                     
                      <td>                       
                      <a href="#" class="btn btn-icon waves-effect waves-light btn-success m-b-5 data_restore" data-toggle="tooltip" title="{{trans('words.restore')}}" data-id="{{$user_data->id}}"> <i class="fa fa-mail-reply"></i> </a>
                      &nbsp;
                      <a href="#" class="btn btn-icon waves-effect waves-light btn-primary m-b-5 data_remove" data-toggle="tooltip" title="{{trans('words.remove')}}" data-id="{{$user_data->id}}"> <i class="fa fa-remove"></i> </a>
                      </td>
                    </tr>
                   @endforeach
                     
                     
                     
                  </tbody>
                </table>
              </div>
                <nav class="paging_simple_numbers">
                @include('admin.pagination', ['paginator' => $user_list]) 
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
 
 $(".data_restore").click(function () {  
   
   var post_id = $(this).data("id");
   var action_name='user_restore';
 
   Swal.fire({
     title: '{{trans('words.dlt_warning')}}',
   text: "{{trans('words.restore_warning_text')}}",
   icon: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: '{{trans('words.restored_confirm')}}',
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
                     title: '{{trans('words.restored')}}!',
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


 $(".data_remove").click(function () {  
   
   var post_id = $(this).data("id");
   var action_name='permanent_user_delete';
 
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