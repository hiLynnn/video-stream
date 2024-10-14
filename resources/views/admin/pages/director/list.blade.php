@extends("admin.admin_app")

@section("content")

  
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card-box table-responsive">
 
              <div class="row">   
                  <div class="wall-filter-block">  
                    <div class="row" style="align-items: center;justify-content: space-between;">            
                     
                      <div class="col-sm-3"> 
                          {!! Form::open(array('url' => 'admin/director','class'=>'app-search','id'=>'search','role'=>'form','method'=>'get')) !!}   
                          <input type="text" name="s" placeholder="{{trans('words.search_by_name')}}" class="form-control">
                          <button type="submit"><i class="fa fa-search"></i></button>
                          {!! Form::close() !!}                    
                      </div>
                      <div class="col-sm-3">
                      &nbsp;              
                      </div>
                       
                      <div class="col-sm-4">
                        <div class="checkbox checkbox-success pull-right">
                            <input id="sellect_all" type="checkbox" name="sellect_all">
                            <label for="sellect_all">{{trans('words.select_all')}}</label>
                            &nbsp;&nbsp;
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">{{trans('words.action')}}<span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <a href="javascript:void(0);" class="dropdown-item" data-action="delete" id="data_remove_selected">{{trans('words.delete')}}</a>                                                                  
                                </div> 

                                
                            </div>&nbsp;&nbsp;&nbsp;

                            <a href="{{URL::to('admin/director/add')}}" class="btn btn-success btn-md waves-effect waves-light pull-right" data-toggle="tooltip" title="{{trans('words.add_director')}}"><i class="fa fa-plus"></i> {{trans('words.add_director')}}</a>
                        </div>

                        
                      </div>
                      
                    </div> 
                  </div>                
                </div>

                <br/>

                 
                <div class="row">
                @foreach($list as $i => $data)
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6" id="card_box_id_{{$data->id}}">

                        <!-- Simple card -->
                        <div class="card m-b-20">
                            <div class="wall-list-item">
                              <div class="checkbox checkbox-success wall_check">
                                <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $data->id; ?>" class="post_ids">
                                <label for="checkbox<?php echo $i; ?>"></label>
                              </div>  
                              <p class="wall_sub_text"> {{ stripslashes($data->ad_name) }}</p>
                               
                              @if(isset($data->ad_image)) <img class="card-img-top thumb-xs img-fluid" src="{{URL::to('/'.$data->ad_image)}}" alt="{{ stripslashes($data->ad_name) }}">
                              @else
                              <img class="card-img-top thumb-xs img-fluid" src="{{URL::to('/admin_assets/images/placeholder.png')}}" alt="{{ stripslashes($data->ad_name) }}">
                              @endif
                            </div>
 
                            <div class="card-body p-3">
                                 
                                <a href="{{ url('admin/actor/edit/'.$data->id) }}" class="btn btn-icon waves-effect waves-light btn-success m-r-5" data-toggle="tooltip" title="{{trans('words.edit')}}"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-icon waves-effect waves-light btn-danger data_remove" data-toggle="tooltip" title="{{trans('words.remove')}}" data-id="{{$data->id}}"><i class="fa fa-remove"></i></a>
                                     
                            </div>
                        </div>

                    </div>
                   @endforeach      

                </div> 
                 
                <nav class="paging_simple_numbers">
                @include('admin.pagination', ['paginator' => $list]) 
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
   var action_name='actors_delete';
 
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
 
//Multiple
$("#data_remove_selected").click(function () {  
  
  var post_ids = $.map($('.post_ids:checked'), function(c) {
      return c.value;
    });
         
  var action_name='actors_delete_selected';

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
 
    if(result.isConfirmed) { 

        $.ajax({
            type: 'post',
            url: "{{ URL::to('admin/ajax_delete') }}",
            dataType: 'json',
            data: {"_token": "{{ csrf_token() }}",id: post_ids, action_for: action_name},
            success: function(res) {

              if(res.status=='1')
              {  
                  $.map($('.post_ids:checked'), function(c) {
                    
                    var post_id= c.value;
                    
                    var selector = "#card_box_id_"+post_id;
                      $(selector ).fadeOut(1000);
                      setTimeout(function(){
                              $(selector ).remove()
                          }, 1000);

                    return c.value;
                  });
 
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
<script type="text/javascript">

  
  var totalItems = 0;
 // $("#sellect_all").on("click", function(e) {
  $(document).on("click", "#sellect_all", function() {
      
    totalItems = 0;

    $("input[name='post_ids[]']").not(this).prop('checked', this.checked);
    $.each($("input[name='post_ids[]']:checked"), function() {
      totalItems = totalItems + 1;       
    });

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

    
    if ($("input[name='post_ids[]']").prop("checked") == true) {
        
      Toast.fire({
      icon: 'success',
      title: totalItems + ' {{trans('words.item_checked')}}'
    })

    } else if ($("input[name='post_ids[]']").prop("checked") == false) {
      totalItems = 0;
      
      Toast.fire({
      icon: 'success',
      title: totalItems + ' {{trans('words.item_checked')}}'
    })
      
    }
 
});

$(document).on("click", ".post_ids", function(e) {
 
if ($(this).prop("checked") == true) {
  totalItems = totalItems + 1;
} else if ($(this).prop("checked") == false) {
  totalItems = totalItems - 1;
}

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

    if (totalItems == 0) {
      Toast.fire({
        icon: 'success',
        title: totalItems + ' {{trans('words.item_checked')}}'
      })

      return true;
    }
 
    Toast.fire({
      icon: 'success',
      title: totalItems + ' {{trans('words.item_checked')}}'
    })

 
});

</script>    
    

@endsection