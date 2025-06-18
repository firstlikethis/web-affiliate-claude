<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ClickLog;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // จำนวนสินค้าทั้งหมด
        $totalProducts = Product::count();
        
        // จำนวนบทความทั้งหมด
        $totalArticles = Article::count();
        
        // จำนวนคลิกทั้งหมด
        $totalClicks = ClickLog::count();
        
        // สินค้ายอดนิยม 5 อันดับแรก
        $popularProducts = Product::orderBy('click_count', 'desc')
            ->take(5)
            ->get();
        
        // บทความยอดนิยม 5 อันดับแรก
        $popularArticles = Article::orderBy('view_count', 'desc')
            ->take(5)
            ->get();
        
        // สถิติการคลิกในรอบ 7 วันล่าสุด
        $clickStats = ClickLog::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalArticles',
            'totalClicks',
            'popularProducts',
            'popularArticles',
            'clickStats'
        ));
    }
}