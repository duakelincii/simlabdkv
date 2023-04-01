<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total = $this->getTotalData();
        $loanOverview = $this->getLoanOverview();
        $topBooks = $this->getTopBooks();

        return view('home', compact('total', 'loanOverview', 'topBooks'));
    }

    public function getTotalData()
    {
        if(Auth::user()->is_admin ==1)
        {
            $total = [
                'book' => Barang::count(),
                'category' => \App\Models\Category::count(),
                'loan' => Loan::count(),
                'activeLoan' => Loan::whereStatus(true)->count()
            ];
        }else{
            $total = [
                'book' => Barang::count(),
                'category' => \App\Models\Category::count(),
                'loan' => Loan::with(['barangs' => function ($barang) {
                            $barang->select('name');
                        }, 'member' => function ($member) {
                            $member->select('id', 'name', 'user_id');
                        }])->whereHas('member', function ($q) {
                            $q->where('id', Auth::user()->member->id);
                        })->count(),
                'activeLoan' => Loan::with(['barangs' => function ($barang) {
                        $barang->select('name');
                    }, 'member' => function ($member) {
                        $member->select('id', 'name', 'user_id');
                    }])->whereHas('member', function ($q) {
                        $q->where('id', Auth::user()->member->id);
                    })->whereStatus(true)->count()
            ];
        }

        return $total;
    }

    public function getLoanOverview()
    {
        $month = collect();
        $total = collect();

        for ($i=6; $i >= 0; $i--) {
            $today = Carbon::today();
            $date = $today->subMonth($i);

            $month->push($date->format('F'));
            $total->push(Loan::whereMonth('created_at', $date->month)->count());
        }

        return compact('month', 'total');
    }

    public function getTopBooks()
    {
        $books = Barang::select('name', 'id')
            ->withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->take(3)
            ->get();

        $name = $books->map(function ($item, $key)
        {
            return $item->name;
        });

        $total = $books->map(function ($item, $key)
        {
            return $item->loans_count;
        });

        return compact('name', 'total');
    }
}
