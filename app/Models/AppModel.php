<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppModel extends Model
{
    public function scopeSearchFor($query, Request $request, $raw)
    {
        $columnIndexArr = $request->get('order');
        $orderArr = $request->get('order');
        $columnIndex = $columnIndexArr[0]['column']; // Column index
        $columnName = $request->get('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $orderArr[0]['dir']; // asc or desc
        $searchValue = $request->get('search')['value']; // Search value

        // Total records
        if ($searchValue) {
            $query->where(DB::raw($raw), 'like', '%' . $searchValue . '%')
                ->orWhere('id', $searchValue);
        }

        $query->orderBy($columnName, $columnSortOrder)->skip($request->get("start"))->take($request->get("length"));
    }
}
