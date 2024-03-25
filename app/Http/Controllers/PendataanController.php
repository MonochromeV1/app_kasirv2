<?php

namespace App\Http\Controllers;

use App\Models\Pendataan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PendataanController extends Controller
{

    public function index() : View
    {
        //get all products
        $pendataans = Pendataan::latest()->paginate(10);

        //render view with products
        return view('pendataans.index', compact('pendataans'));
    }
     public function create(): View
    {
        return view('pendataans.create');
    }
     public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        Pendataan::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('pendataan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
        public function show(string $id): View
    {
        //get product by ID
        $pendataan = Pendataan::findOrFail($id);

        //render view with product
        return view('pendataans.show', compact('pendataan'));
    }
      public function edit(string $id): View
    {
        //get product by ID
        $pendataan = Pendataan::findOrFail($id);

        //render view with product
        return view('pendataans.edit', compact('pendataan'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //get product by ID
        $pendataan = pendataan::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //delete old image
            Storage::delete('public/products/'.$pendataan->image);

            //update product with new image
            $pendataan->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);

        } else {

            //update product without image
            $pendataan->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        }

        //redirect to index
        return redirect()->route('pendataan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
        public function destroy($id): RedirectResponse
    {
        //get product by ID
        $pendataan = Pendataan::findOrFail($id);

        //delete image
        Storage::delete('public/products/'. $pendataan->image);

        //delete product
        $pendataan->delete();

        //redirect to index
        return redirect()->route('pendataan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
