<?php

// namespace App\Imports;

// use App\Models\user;
// use Maatwebsite\Excel\Concerns\ToModel;

// class usersImport implements ToModel
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         return new user([
//             //
//         ]);
//     }
// }



//--------------------------------------------------
namespace App\Imports;

use App\Http\Controllers\Users;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class usersImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row )
        {
            // dd($row->toArray());
            DB::table('smpp_dlt_templates')->insert($row->toArray());
            
        }
    }
}
