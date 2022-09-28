<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SmscModel extends Model
{
    

    public function smscS($req){
      
 
       

        if($req->IsMixRouting == ""){
            $IsMixRouting='0';
            $MixRoutes = 0;
        }else{
             $IsMixRouting='1';
               $MixRoutesArray = $req->MixRoutes;
              $MixRoutes =   implode(',', $MixRoutesArray);
                 $myfile = fopen("rabbit/mixroute/".$req->SmscId.".json", "w") or die("Unable to open file!");
             fwrite($myfile, json_encode($MixRoutesArray));
             fclose($myfile);
        }
        $SMSCdata = array( 
            'SmscId'=> $req->SmscId,
            'routeCategory'=> $req->routeCategory,
            'Description'=> $req->Description,
            'IsMixRouting'=> $IsMixRouting,
            'DateTime'=>Date('Y-m-d H:i:s '),
            'LastUpdate'=>Date('Y-m-d H:i:s '),
            'MixRouteIds'=>$MixRoutes,
            'Status'=>$req->Status,
            
        );

        $UserId = DB::table('smsclist')->insert($SMSCdata);
        if($UserId==true){
             
            return  true;

        }else{
            return false;
        }
        

    }


    public function update_smsc($req){
        $smsc = array( 
            'SmscId'=>  $req->SmscId,
            'Description'=>  $req->Description,
            'Status'=>$req->Status,
            'LastUpdate'=> date('Y-m-d H:i:s a')
        );

        $smsc1 = DB::table('smsclist')->where('Id',$req->Id)->update($smsc);

        if($smsc1 == true){
             
            return  true;
    
        }else{
            return false;
        }
    }

    






}
