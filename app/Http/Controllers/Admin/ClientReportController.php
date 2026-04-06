<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Project;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientReportController extends Controller
{
    public function index(Request $request)
    {
        $q = Transaction::with('project')
            ->with('transaction_type')
            ->with('income_source')
            ->with('currency')
            ->orderBy('transaction_date', 'desc');

        if ($request->has('project')) {
            $q->where('project_id', $request->project);
        }

        $transactions = $q->get();

        $entries = [];

        foreach ($transactions as $row) {
            if ($row->transaction_date != null) {
                $date = Carbon::createFromFormat(config('panel.date_format'), $row->transaction_date)->format("Y-m");

                if (!isset($entries[$date])) {
                    $entries[$date] = [];
                }

                $currency = $row->currency->code;

                if (!isset($entries[$date][$currency])) {
                    $entries[$date][$currency] = [
                        'income'   => 0,
                        'expenses' => 0,
                        'fees'     => 0,
                        'total'    => 0,
                    ];
                }

                $income   = 0;
                $expenses = 0;
                $fees     = 0;

                if ($row->amount > 0) {
                    $income += $row->amount;
                } else {
                    $expenses += $row->amount;
                }

                if (!is_null($row->income_source->fee_percent)) {
                    $fees = $row->amount * ($row->income_source->fee_percent / 100);
                }

                $total = $income + $expenses - $fees;
                $entries[$date][$currency]['income'] += $income;
                $entries[$date][$currency]['expenses'] += $expenses;
                $entries[$date][$currency]['fees'] += $fees;
                $entries[$date][$currency]['total'] += $total;
            }
        }

        // Build chart data: aggregate across all currencies for monthly trend
        $chartLabels = [];
        $chartIncome = [];
        $chartExpenses = [];
        $chartFees = [];
        $chartTotal = [];

        // Overall summary totals
        $summaryIncome = 0;
        $summaryExpenses = 0;
        $summaryFees = 0;
        $summaryTotal = 0;

        // Sort entries by date for chart chronological order
        ksort($entries);

        foreach ($entries as $date => $currencies) {
            $monthIncome = 0;
            $monthExpenses = 0;
            $monthFees = 0;
            $monthTotal = 0;

            foreach ($currencies as $currency => $row) {
                $monthIncome += $row['income'];
                $monthExpenses += abs($row['expenses']);
                $monthFees += $row['fees'];
                $monthTotal += $row['total'];
            }

            $chartLabels[] = $date;
            $chartIncome[] = round($monthIncome, 2);
            $chartExpenses[] = round($monthExpenses, 2);
            $chartFees[] = round($monthFees, 2);
            $chartTotal[] = round($monthTotal, 2);

            $summaryIncome += $monthIncome;
            $summaryExpenses += $monthExpenses;
            $summaryFees += $monthFees;
            $summaryTotal += $monthTotal;
        }

        $projects = Project::pluck('name', 'id')->prepend('--- ' . trans('cruds.clientReport.reports.allProjects') . ' ---', '');

        if ($request->has('project')) {
            $currentProject = $request->get('project');
        } else {
            $currentProject = '';
        }

        return view('admin.clientReports.index', compact(
            'entries',
            'projects',
            'currentProject',
            'chartLabels',
            'chartIncome',
            'chartExpenses',
            'chartFees',
            'chartTotal',
            'summaryIncome',
            'summaryExpenses',
            'summaryFees',
            'summaryTotal'
        ));
    }
}
