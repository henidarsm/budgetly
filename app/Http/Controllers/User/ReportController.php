<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId    = Auth::id();
        $dateFrom  = $request->date_from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateTo    = $request->date_to   ?? Carbon::now()->format('Y-m-d');
        $categoryId = $request->category_id;

        $query = Expense::with('category')
            ->where('user_id', $userId)
            ->whereBetween('expense_date', [$dateFrom, $dateTo]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $expenses   = $query->orderByDesc('expense_date')->get();
        $totalAmount = $expenses->sum('amount');

        // Category breakdown
        $categoryBreakdown = Expense::where('user_id', $userId)
            ->whereBetween('expense_date', [$dateFrom, $dateTo])
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(function($items) {
                return [
                    'name'    => $items->first()->category->name,
                    'color'   => $items->first()->category->color,
                    'total'   => $items->sum('amount'),
                    'count'   => $items->count(),
                ];
            })
            ->sortByDesc('total')
            ->values();

        // Daily breakdown
        $dailyBreakdown = $expenses->groupBy(fn($e) => $e->expense_date->format('Y-m-d'))
            ->map(fn($items) => $items->sum('amount'))
            ->sortKeys();

        $categories = Category::where(function($q) use ($userId) {
            $q->where('user_id', $userId)->orWhereNull('user_id');
        })->get();

        return view('user.reports.index', compact(
            'expenses', 'totalAmount', 'categoryBreakdown', 'dailyBreakdown',
            'categories', 'dateFrom', 'dateTo', 'categoryId'
        ));
    }

    public function exportPdf(Request $request)
    {
        $userId   = Auth::id();
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateTo   = $request->date_to   ?? Carbon::now()->format('Y-m-d');

        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->whereBetween('expense_date', [$dateFrom, $dateTo])
            ->orderByDesc('expense_date')
            ->get();

        $totalAmount = $expenses->sum('amount');
        $categoryBreakdown = $expenses->groupBy('category_id')->map(function($items) {
            return ['name' => $items->first()->category->name, 'total' => $items->sum('amount')];
        });

        $user = Auth::user();
        $pdf  = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.reports.pdf', compact(
            'expenses', 'totalAmount', 'categoryBreakdown', 'user', 'dateFrom', 'dateTo'
        ));
        return $pdf->download('laporan-pengeluaran-' . $dateFrom . '-sd-' . $dateTo . '.pdf');
    }

    public function exportCsv(Request $request)
    {
        $userId   = Auth::id();
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $dateTo   = $request->date_to   ?? Carbon::now()->format('Y-m-d');

        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->whereBetween('expense_date', [$dateFrom, $dateTo])
            ->orderByDesc('expense_date')
            ->get();

        $filename = 'laporan-pengeluaran-' . $dateFrom . '-sd-' . $dateTo . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($expenses) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            fputcsv($handle, ['No', 'Tanggal', 'Judul', 'Kategori', 'Jumlah (Rp)', 'Deskripsi'], ';');
            foreach ($expenses as $i => $exp) {
                fputcsv($handle, [
                    $i + 1,
                    $exp->expense_date->format('d/m/Y'),
                    $exp->title,
                    $exp->category->name,
                    number_format($exp->amount, 0, ',', '.'),
                    $exp->description ?? '-',
                ], ';');
            }
            $total = $expenses->sum('amount');
            fputcsv($handle, ['', '', '', 'TOTAL', number_format($total, 0, ',', '.'), ''], ';');
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
