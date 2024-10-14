@extends("admin.admin_app")

@section("content")

 
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                 
                  
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">
                    <a href="#" class="btn btn-info btn-md waves-effect waves-light m-b-20 mt-2 pull-right" title="{{trans('words.test_smtp')}}" data-toggle="modal" data-target="#smtp_test_model"><i class="fa fa-send"></i> {{trans('words.test_smtp')}}</a> 
                    </div>

                    <div id="smtp_test_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">{{trans('words.test_smtp')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
 
                                  <div class="form-group row">    
                                    <label class="col-sm-3 col-form-label">{{trans('words.test_email')}}</label>
                                    <div class="col-sm-9">
                                     <input type="email" name="test_email" placeholder="{{trans('words.email')}}" class="form-control" id="test_email" autocomplete="off" required>
                                    </div>
                                  </div>
                                   
                                     
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="test_email_sent_btn" class="btn btn-primary waves-effect waves-light"> {{trans('words.send')}}</button>                                     
                                </div>
                                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                   
                </div>

                 {!! Form::open(array('url' => array('admin/email_settings'),'class'=>'form-horizontal','name'=>'settings_form','id'=>'settings_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($settings->id) ? $settings->id : null }}">
  
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.host')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="smtp_host" value="{{ isset($settings->smtp_host) ? $settings->smtp_host : null }}" class="form-control" placeholder="mail.example.com">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.port')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="smtp_port" value="{{ isset($settings->smtp_port) ? $settings->smtp_port : null }}" class="form-control" placeholder="465">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.email')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="smtp_email" value="{{ isset($settings->smtp_email) ? $settings->smtp_email : null }}" class="form-control" placeholder="info@example.com">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.password')}}*</label>
                    <div class="col-sm-8">
                      <input type="password" name="smtp_password" value="{{ isset($settings->smtp_password) ? $settings->smtp_password : null }}" class="form-control" placeholder="****">
                    </div>
                  </div>   
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{trans('words.encryption')}}</label>
                      <div class="col-sm-8">
                        <select class="form-control" name="smtp_encryption">                                                                
                            <option value="TLS" @if($settings->smtp_encryption=="TLS") selected @endif>TLS</option>
                            <option value="SSL" @if($settings->smtp_encryption=="SSL") selected @endif>SSL</option>                                  
                        </select>
                      </div>
                  </div>                    
                  <div class="form-group">
                    <div class="offset-sm-2 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{trans('words.save_settings')}} </button>                      
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
     jQuery(document).ready(function(){
    $(document).on('click', '#test_email_sent_btn', function() {
        //$('#result').html('');
        var test_email = $("#test_email").val();

         
         if (test_email != '') {
            $.ajax({
                type: 'GET',
                url: "{{ URL::to('admin/test_smtp_settings') }}",
                data: "test_email=" + encodeURIComponent(test_email),
                dataType: 'json',
                beforeSend: function() {
                    $("#test_email_sent_btn").html('sending...');
                },
                success: function(response) {

                  var resp_status     = response.resp_status;
                  var resp_msg     = response.resp_msg;
                    
                  if (resp_status == 'success') {

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
                          title: resp_msg
                        })
 
                       
                        $('#test_email_sent_btn').html('{{trans('words.send')}}');                                      

                    } else {

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
                          title: resp_msg
                        })

                        $('#test_email_sent_btn').html('{{trans('words.send')}}');
                         
                    }
                }
            });
        } 
        else {
            alert('Please enter email');
        }
    });
});
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