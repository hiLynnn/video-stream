 
<div id="user_device_list" class="modal fade centered-modal in" role="dialog" aria-labelledby="user_device_list" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
       <div class="modal-content" align="center">
        <div class="modal-header">          
          <h4 class="modal-title">Device Limit Reached</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         		
        	<h4 class="modal-title">Where you're logged in</h4>
          <table class="table">
		    <thead>
		     <tr>
		        <th>Device</th>
		        <th>&nbsp;</th>		         
		      </tr>
		    </thead>
		    <tbody>
		     
		     @foreach(\App\UsersDeviceHistory::where('user_id','=',Auth::user()->id)->orderBy('id','DESC')->get() as $sp => $device_list)
		      <tr>
		        <td class="des_user_title">{{ $device_list->user_device_name?$device_list->user_device_name:'unknown' }}</td>
		        <td style="text-align: right;">
		        	@if(Session::getId()==$device_list->user_session_name)
		        		<a href="Javascript:void(0);" class="current_device">Current Device</a>
		        	@else
		        	<a href="{{ URL::to('/logout_user_remotely/'.$device_list->user_session_name) }}" class="devise_logout">Logout</a>
		        	@endif
		        </td>		         
		      </tr>
		      
		      @endforeach
		       
		    </tbody>
	    </table>

         </div>
         
      </div>      
    </div>
  </div>

 