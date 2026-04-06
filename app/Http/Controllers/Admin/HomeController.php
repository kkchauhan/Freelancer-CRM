<?php

namespace App\Http\Controllers\Admin;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'clientsCount' => \App\Client::count(),
            'projectsCount' => \App\Project::count(),
            'transactionsCount' => \App\Transaction::count(),
            'documentsCount' => \App\Document::count(),
            'recentProjects' => \App\Project::with(['client', 'status'])->latest()->take(6)->get(),
        ];

        return view('home', compact('data'));
    }
}
