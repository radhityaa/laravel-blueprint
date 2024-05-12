<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): Response
    {
        $stores = Store::all();

        return view('stores.index', compact('stores'));
    }

    public function create(Request $request): Response
    {
        return view('stores.create');
    }

    public function store(StoreStoreRequest $request): Response
    {
        $store = Store::create($request->validated());

        return redirect()->route('stores.index');
    }

    public function show(Request $request, Store $store): Response
    {
        return view('stores.show', compact('stores'));
    }

    public function edit(Request $request, Store $store): Response
    {
        return view('stores.edit', compact('stores'));
    }

    public function update(StoreUpdateRequest $request, Store $store): Response
    {
        $store->update($request->validated());

        return redirect()->route('stores.show', ['store' => $store]);
    }
}
