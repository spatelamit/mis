<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\ReportModel;
use ZipArchive;
class Delivery_export_model extends Model
{
    use HasFactory;

    public function exportDeliveryReport(){

    	$ExportDetails  =$this->getExportDetails();
    	// dd($ExportDetails->Username);
        
        if($ExportDetails){
               
               $csvFiles  =$this->getSelectDeliveryReportData($ExportDetails->Date, $ExportDetails->Sender, $ExportDetails->Username, $ExportDetails->datasize);
// dd( $csvFiles);

              echo $this->saveReportFilePath($csvFiles,  $ExportDetails->Username, $ExportDetails->Id, $ExportDetails->Date);
                
               
        }

    }

    public function getExportDetails(){

    	$reportdata=DB::table('smppreports')
    	->where('Status',0)
    	->orderby("RequestedDate", "ASC")
    	->limit(1)
    	->first();
		    if($reportdata){
		    	return $reportdata;

		    }else{
		    	return false;
		    }

		    	 
		}

	public function getSelectDeliveryReportData($Date, $SenderId, $username, $datasize) {

        $dsql = 'select fn_get_day_of_half_year("'.$Date.'") as DAY';
        $dquery = DB::select($dsql)	;

       echo($dquery[0]->DAY);
        $DAY = $dquery[0]->DAY +1;

        $limit = 400000;

        if($datasize<=$limit){
            $limit = $datasize;
        }
        echo "<br> datasize $datasize; <br>";

         $count = ceil($datasize/$limit);   
         echo "<br>Total $count Files<br>";
    
    for ($i=0; $i < $count; $i++) { 

        $startDate =  strtotime($Date." 12:00:00 AM");
        $endDate = strtotime($Date." 11:59:59 PM");
 		$offset = $limit*$i;

// DB::enableQueryLog();

// and then you can get query log

       
        
         // $reportdata->where('service', $username);
// dd(DB::getQueryLog());
       
        if($SenderId!="ALL"){
        	 $partion_table='select * from smpp_sent_pdus_archive PARTITION(DAY_'.$DAY.') where sender ="'.$SenderId.'" limit '.$limit.' offset '.$offset.'';
       
        }else{
        	 $partion_table='select * from smpp_sent_pdus_archive PARTITION(DAY_'.$DAY.') where service ="'.$username.'" limit '.$limit.' offset '.$offset.'';

        }

      $reportdata=DB::select($partion_table);
       // $reportdata->limit($limit,$offset)->get();

     // dd($reportdata);

       
        // print_r($this->db->last_query($query));
        // echo "<br>";

    
     
         $CsvFile[] = $this->createCSVExportFile($reportdata, $username, $i, $Date);
        sleep(1);
        }
        return $CsvFile;
        //return $data;
}
 
	public function createCSVExportFile($ReportData, $Username, $i, $Date) {
		//    $file_name=date('Y-m-d').time().$ReportId;
		// echo $Date;
		    $filename = $Username."-".$Date.'-'.uniqid()."-$i";
		    $file_name  = $filename;

// echo $filename;
		    $report_model=New ReportModel;
		    $errors  = $report_model->get_error_cods();
		    foreach ($errors as $key => $value) {
		        $error[$value->operator_code] = $value->custom_code;

		    }

		    // dd($error);	
		    
		    $csvFile = "./reports/csv/$filename.csv";

		     $file = fopen($csvFile, 'w') or die("can't open file");

		      $headings = "MsgID,Mobile,Sender,Coding,Status,Code,Submit Date,Delivery Date,Message";
		       fputcsv($file, explode(',', $headings));
		        $i = 1;
		        $j=1;
		       
		        if ($ReportData) {
		            
		               foreach ($ReportData as $key => $value) {
		                
		                  $Status = $this->getStatusOfMessage($value->dlr_mask,hex2bin($value->msgdata));
		                    if($value->coding==0)
		                    	{ $Coding="Text"; 
		                	}else{
		                		 $Coding = "Unicode";}

		                        # ERROR CODE 
		                              $eror = str_replace(",", " ",hex2bin($value->dlr_receipt));
		                              $eror = explode(" ", $eror);
		                              $err  = $eror;
		                              // dd($eror);
		                              $eror = explode(":", $eror[8]);
		                              
		                              //$eror = $eror[1];
		                              $eror = ltrim($eror[1],0);
		                              if($eror!=""){

		                              $e_code = $error[$eror];
		                              }
		                              // $error_codes[$eror[1]]=$eror[1].','.$value['receiver'].','.str_replace(",", " ",hex2bin($value['dlr_receipt'])).','.$value['smsc_id'];
		                              if(!isset($e_code)){
		                                $e_code = '34';
		                              }
		                              if($value->dlr_mask==1){
		                                $e_code = '000';
		                              }
		                              if($err[7]=='stat:DNDNumber'){
		                                $e_code = 'DNDNumber';
		                                //print_r($err);
		                              }
		                              # ERROR CODE 


		                             // dd($Status);	
		    					
		                         $line="";
		                        $line .= $value->dlr_url;
		                        $line .= "," . $value->receiver;
		                        $line .= "," . $value->sender;
		                        $line .= "," . $Coding;
		                        $line .= "," . $Status['DLRStatus'];
		                        $line .= "," . $e_code;
		                        $line .= "," .date('Y-m-d H:i:s', $value->time);
		                        $line .= "," .date('Y-m-d H:i:s', $value->dlr_time);
		                        $line .= "," . str_replace(',', ' ', utf8_decode(hex2bin($value->msgdata)));
		           // dd ($line);	
		                        fputcsv($file, explode(',', $line));
		                        $i++;
		                        unset($line);
		           }	
		                fclose($file);
		        // dd($csvFile);
		            return $csvFile;
		        }


		        
		}
		    
		public function getStatusOfMessage($CheckStatus, $dlrPdu) {

		    // $dlrPdu

				if($CheckStatus==1){
					$DLRStatus  = "Delivered";
					$ErrorCode  = "000";

				}elseif($CheckStatus==2){
					$DLRStatus  = "Failed";
					$ErrorCode  = "002";

				}elseif($CheckStatus==16){
					$DLRStatus  = "Rejected";
					$ErrorCode  = "016";

				}elseif($CheckStatus==8 || $CheckStatus==923){
					$DLRStatus  = "Pending";
					$ErrorCode  = "008";
				}
				else{
					$DLRStatus  = "N/A";
					$ErrorCode  = "N/A";
				}

				$Status = array(
				    'DLRStatus'=>$DLRStatus,
				    'ErrorCode'=>$ErrorCode
				);
				return $Status;

		}


		public function saveReportFilePath( $csvFiles, $Username, $ReportId, $Date) {
 

$zip = new ZipArchive;
			$ZipFile=$Username."-".$Date.'-'.uniqid().".zip";


			// $fileName = $zip->archive('./reports/archive/'.$ZipFile); 
	 if ($zip->open('./reports/archive/'.$ZipFile, ZipArchive::CREATE) === TRUE) {    
			for($i=0;$i<count($csvFiles);$i++){
				// dd($csvFiles);//
				// dd($csvFiles[$i]);
				echo $i;
				$csv=explode("/",$csvFiles[$i]);
				// dd($csv);
            $zip->addFile('./reports/csv/',$csv[3]);        
             
        

			     

    			
			  
			    // unlink($csvFiles[$i]);
			}
			
		$zip->close();
}

			$data = array(
			         'ReportStatus' => "Complete",
			         'ReportPath' =>  $ZipFile,
			         'Status' => 1
			    );
			$query=DB::table('smppreports')
			->where('Id',  $ReportId)
			->update($data);
			
			 if($query){
			    // echo $fileName;

			    // print_r($this->db->last_query($query));
			   return true;
			}

			    




		}






 }




?>