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
                  <span data-toggle="modal" data-target="#add_model">
                    <a href="#" class="btn btn-success btn-md waves-effect waves-light m-b-20" data-toggle="tooltip" title="{{trans('words.add_language')}}"><i class="fa fa-plus"></i> {{trans('words.add_language')}}</a>
                  </span>

                      <div id="add_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content pt-3 pb-3 pl-0 pr-0">
                                <div class="modal-header pl-3 pr-3">
                                    <h4 class="modal-title mt-0" id="myModalLabel">{{trans('words.add_language')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body pl-3 pr-3 pt-3 pb-0">

                                 {!! Form::open(array('url' => array('admin/language/add_edit_language'),'class'=>'form-horizontal','name'=>'category_form','id'=>'category_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                                    
                                  <div class="form-group row">    
                                    <label class="col-sm-4 col-form-label">{{trans('words.language_name')}}</label>
                                    <div class="col-sm-8">
                                      <input type="text" name="language_name" value="" class="form-control">
                                    </div>
                                  </div>

                                  <div class="form-group row">    
                                    <label class="col-sm-4 col-form-label">{{trans('words.status')}}</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" name="status">                               
                                        <option value="1">{{trans('words.active')}}</option>
                                        <option value="0">{{trans('words.inactive')}}</option>                            
                                     </select>
                                    </div>
                                  </div>                                   
                                     
                                </div>
                                <div class="modal-footer pl-3 pr-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save')}}</button>                                     
                                </div>
                                {!! Form::close() !!}
 
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                 </div>
              </div>
 
              <div class="row">
                  @foreach($languag_list as $i => $languag)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" id="card_box_id_{{$languag->id}}">
                        <!-- Simple card -->
                        <div class="card m-b-20 p-3 lng_item_grid">
                            <div class="card-body p-0">
                                <!--<h4 class="card-title mb-3">{{ stripslashes($languag->language_name) }}</h4>-->
								<div class="item_latter">{{ stripslashes($languag->language_name) }}</div>
                                <span data-toggle="modal" data-target="#edit_model{{$languag->id}}">
                                    <a href="#" class="btn waves-effect waves-light btn-success m-r-5" data-toggle="tooltip" title="{{trans('words.edit')}}"><i class="fa fa-edit"></i></a>
                                </span>
                                <div id="edit_model{{$languag->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content pt-3 pb-3 pl-0 pr-0">
                                          <div class="modal-header pl-3 pr-3">
                                              <h4 class="modal-title mt-0" id="myModalLabel">{{trans('words.edit_language')}}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                          </div>
                                          <div class="modal-body pl-3 pr-3 pt-3 pb-0">

                                          {!! Form::open(array('url' => array('admin/language/add_edit_language'),'class'=>'form-horizontal','name'=>'category_form','id'=>'category_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                                            
                                          <input type="hidden" name="id" value="{{ $languag->id }}">
                                            <div class="form-group row">    
                                              <label class="col-sm-4 col-form-label">{{trans('words.language_name')}}</label>
                                              <div class="col-sm-8">
                                                <input type="text" name="language_name" value="{{stripslashes($languag->language_name)}}" class="form-control">
                                              </div>
                                            </div>

                                            <div class="form-group row">    
                                              <label class="col-sm-4 col-form-label">{{trans('words.status')}}</label>
                                              <div class="col-sm-8">
                                              <select class="form-control" name="status">                               
                                                  <option value="1" @if($languag->status==1) selected @endif>{{trans('words.active')}}</option>
                                                  <option value="0" @if($languag->status==0) selected @endif>{{trans('words.inactive')}}</option>                            
                                              </select>
                                              </div>
                                            </div>                                   
                                          </div>
                                          <div class="modal-footer pl-3 pr-3">
                                              <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save')}}</button>                                     
                                          </div>
                                          {!! Form::close() !!}
                                      </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div>
                                <a href="#" class="btn waves-effect waves-light btn-danger data_remove" data-toggle="tooltip" title="{{trans('words.remove')}}" data-id="{{$languag->id}}"> <i class="fa fa-remove"></i></a>
                                <a href="Javascript:void(0);" class="ml-2 fl-right mt-1" data-toggle="tooltip" title="@if($languag->status==1){{ trans('words.active')}} @else {{trans('words.inactive')}} @endif"><input type="checkbox" name="ads_on_off" id="ads_on_off" value="1" data-plugin="switchery" data-color="#28a745" data-size="small" class="enable_disable"  data-id="{{$languag->id}}" @if($languag->status==1) {{ 'checked' }} @endif/></a>    
                            </div>
                        </div>
                    </div>
                   @endforeach      
                </div>
                 
                <nav class="paging_simple_numbers">
                @include('admin.pagination', ['paginator' => $languag_list]) 
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

<script type="text/javascript">
 
 $(".enable_disable").on("change",function(e){      
        
       var post_id = $(this).data("id");
       
       var status_set = $(this).prop("checked"); 
 
       var action_name='lang_status';
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

<script type="text/javascript">

$(".data_remove").click(function () {  
  
  var post_id = $(this).data("id");
  var action_name='lang_delete';

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