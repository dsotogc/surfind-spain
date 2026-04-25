<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beach;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeachController extends Controller
{
    public function index(): View
    {
        return view('admin.beaches.index');
    }

    public function create(): View
    {
        return view('admin.beaches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.beaches.index');
    }

    public function show(Beach $beach): View
    {
        return view('admin.beaches.show', compact('beach'));
    }

    public function edit(Beach $beach): View
    {
        return view('admin.beaches.edit', compact('beach'));
    }

    public function update(Request $request, Beach $beach): RedirectResponse
    {
        return redirect()->route('admin.beaches.show', $beach);
    }

    public function destroy(Beach $beach): RedirectResponse
    {
        return redirect()->route('admin.beaches.index');
    }
}
