<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KannelModel extends Model
{
    use HasFactory;

    public function getSmscsTrafficSummeryHistory()
    {
        $startDate = date('Y-m-', strtotime(" -4 month")) . '-01';
        $endDate = date('Y-m', strtotime(" 0 month")) . '-31';
        //   echo $startDate;
        //   echo $endDate;
        DB::enableQueryLog();
        $data = DB::table('smsc_traffic_data')
            ->select('*')
            // ->whereBetween('Date', [$startDate, $endDate])
            ->where('Date', '>=', $startDate)
            ->where('Date', '<=', $endDate)
            ->groupBy('Date', 'SMSC_Name')
            ->orderBy("Date", "DESC")
            ->get();
        // dd(DB::getQueryLog());
        //   dd($data);
        return $data;
    }


    public function getDataSenderWise($req)
    {
        $date = explode(" - ", $req->datetimes);
        $from =  strtotime($date[0]);
        $to = strtotime($date[1]);
        $type = $req->type;
// echo $date[0];
// echo $date[1];
        DB::enableQueryLog();
        $data = DB::table('smpp_sent_pdus')
            ->select($type, 'sender', 'dlr_mask', DB::raw("COUNT(dlr_mask) as count"))
            // ->whereBetween('time', [$from, $to])
            ->where('time', '>=' , $from)
            ->where('time','<=', $to)
            ->groupBy('sender', 'dlr_mask');

        if (isset($type) && $type != '') {
            $data = $data->groupBy($type);
        }
        $data = $data->orderBy("count", "DESC")
            ->limit(200)
            ->get();
        // ->paginate(10);
        // dd(DB::getQueryLog());
        // dd($data);
        return $data;
    }

    public function getAllSmscsTraffic($req)
    {
        $date = explode(" - ", $req->datetimes);
        $startDate =  strtotime($date[0]);
        $endDate = strtotime($date[1]);

        $DOM = date('d', $startDate);
        $DOM = ltrim($DOM, "0");
        $DOM = $DOM;

        $result = DB::select(DB::raw("SELECT dlr_mask, smsc_id, count(dlr_mask) as Count FROM smpp_sent_pdus_dlr PARTITION (DOM_" . $DOM . ") group by smsc_id, dlr_mask"));
        return $result;

        // $this->db->select('dlr_mask, COUNT(dlr_mask) as Count,smsc_id');
        // $this->db->from('smpp_sent_pdus_dlr PARTITION(DOM_'.$DOM.')');

        // $this->db->group_by('smsc_id');
        // $this->db->group_by('dlr_mask');

        // $query = $this->db->get();
    }

    public function fakeSmscsTrafficOnly($req)
    {
        $date = explode(" - ", $req->datetimes);
        $startDate =  strtotime($date[0]);
        $endDate = strtotime($date[1]);

        $DOM = date('d', $startDate);
        $DOM = ltrim($DOM, "0");
        $DOM = $DOM;

        $result = DB::select(DB::raw("SELECT dlr_mask, smsc_id, count(dlr_mask) as Count FROM smpp_sent_pdus PARTITION (DOM_" . $DOM . ") where smsc_id = 'VIDEOCON_PRE' group by dlr_mask"));
        return $result;




        // $this->db->select('smsc_id, dlr_mask, COUNT(dlr_mask) as Count', false);
        // $this->db->where("smsc_id",'VIDEOCON_PRE');
        // $this->db->from('smpp_sent_pdus PARTITION(DOM_'.$DOM.')');
        // $this->db->group_by('dlr_mask');
        // $query = $this->db->get();

    }
}
