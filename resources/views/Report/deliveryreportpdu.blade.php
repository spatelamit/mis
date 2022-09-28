<style type="text/css">
  	#example{
    	font-size: 15px !important;
  	}
</style>

<div class="col-md-12"> 
	<div class="box box-default color-palette-box">
  		<div class="box-header with-border">
    		<h3 class="box-title">
      			
    		</h3> 
  		</div>
	    <div class="box-body">
	 		<div  class="table-responsive">
	            <div class="box-body table-as">
	              	<table id="example" class="table table-bordered" data-page-length='25'>
	                	<thead>
	                		<tr>
	                  			<th>MsgID</th>
	                  			@if(session()->get('IsAdmin') == 'Y')
	                  			<th> Operator </th>
	                  			@endif
	                  			<th>Mobile</th>
	                  			<th>Sender</th>
	                  			<th>User</th>
	                  			<th>Status</th>
	                  			<th>Date </th>
	                  			<th>Info</th>
	                  			<th>Message</th>
	               			</tr>
	              		</thead>
	              		<tbody>
				            <?php
				              $k =1;
				              if($DeliveryReportPdu!=""){
				              	
				                foreach ($DeliveryReportPdu as $key => $value) {

				                    $DLRStatus ="N/A";
				                    $ErrorCode ="0";
				                    $CheckState =  $value->dlr_mask;

									if ($CheckState==1) {
										$DLRStatus= "Delivered";
										$ErrorCode ="000";
										$Description = "Normal Delivered";
									}elseif ($CheckState==923 || $CheckState==8) {
										$DLRStatus= "Pending";
										$ErrorCode ="008";
										$Description = "Pending ";
									}elseif ($CheckState==16) {
										$DLRStatus= "Rejected";
										$ErrorCode ="016";
										$Description = "REJECTED";
									}elseif ($CheckState==48) {
										$DLRStatus= "Blacklist";
										$ErrorCode ="016";
										$Description = "Black Listed Operator";
									}
									elseif ($CheckState==2 || $CheckState==771) {
										$DLRStatus= "Failed";
										$ErrorCode ="000";
										$Description = "Failed ";
									}else{
				       
										$ErrorCode = explode(' ', hex2bin($value->dlr_receipt)); 
										$ErrorCode = explode(':', $ErrorCode[8]); 
										$ErrorCode = $ErrorCode[1];
										$DLRStatus= "Failed";
										$Description = "Failed";
									}
				 
				            	?>
	                  		<tr>
	                    
			                    <td><small><?php echo $value->dlr_url;?></small></td>

			                    @if(session()->get('IsAdmin') == 'Y')
			                    <td><?php echo $value->smsc_id;?></td>
			                    @endif

			                    <td><?php echo $value->receiver;?></td>
			                    <td><?php echo $value->sender;?></td>
			                    <td><?php echo $value->service;?></td>
			                    <td><?php echo $DLRStatus; ?> </td>
			                    <td> Submit :  <?php echo date('Y-m-d H:i:s', $value->time);?>  </br></br>
				                    <?php 
				                        if($value->dlr_time!=0){
				                            echo "Delivery : ". date('Y-m-d H:i:s', $value->dlr_time);
				                        }else{
											echo "-";
				                        }
				                    ?>
			                    </td>
			                    <td>
			                        Coding : <?php if($value->coding==0){ echo "Text"; }else{ echo "Unicode"; }?><br>
			                        Code : <small><?php echo $ErrorCode;?></small><br>
			                        Length :  <?php  echo strlen(hex2bin($value->msgdata));?>
			                    </td>
			                    <td>
			                    	<?php
				                    	echo str_replace("\n", "<br>", hex2bin($value->msgdata));
				                     	if(session()->get('IsAdmin')=="Y"){
				                      		echo "<br/>PDU: <b><br/>";
				                        	echo hex2bin($value->dlr_receipt);
				                      		echo "<br/>Optional Parameter:<br/>";
				                        	echo $value->udhdata;
				                      		echo '</b>';
				                    	}
			                    	?>
			                    </td>
			                </tr>
			      			<?php
			      				$k++;
			         			} 
			       			}
			      			?>
	                	</tbody>
	               
	              	</table>
	            </div>
	           
	        </div>
	    </div>
 	</div>
</div>