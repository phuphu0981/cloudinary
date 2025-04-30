<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lover;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class LoverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lovers = Lover::all();
        return view('lovers.index', compact('lovers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pass' => 'required|string|max:255',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture1' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture2' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture3' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture4' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture5' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture6' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture7' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture8' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'picture9' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Check if a lover with id = 1 exists
        $lover = Lover::find(1);

        if (!$lover) {
            $lover = new Lover();
        }

        $lover->name = $request->name;
        $lover->pass = $request->pass; // Save password as plain text
        $lover->profile_text = $request->profile_text;
        $lover->content = $request->content;
        $lover->letter_text = $request->letter_text;

        if ($request->hasFile('avatar')) {
            // Upload avatar to Cloudinary
            $uploadedFile = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'lovers/avatars',
            ]);
            $lover->avatar = $uploadedFile->getSecurePath();
        }

        // Upload pictures 1 to 9
        for ($i = 1; $i <= 9; $i++) {
            $pictureField = 'picture' . $i;
            if ($request->hasFile($pictureField)) {
                $uploadedFile = Cloudinary::upload($request->file($pictureField)->getRealPath(), [
                    'folder' => 'lovers/pictures',
                ]);
                $lover->{$pictureField} = $uploadedFile->getSecurePath();
            }
        }

        $lover->save();

        return redirect()->route('lovers.index')->with('success', 'Lover saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lover = Lover::findOrFail($id);
        return view('lovers.edit', compact('lover'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $lover = Lover::findOrFail($id);
        $field = $request->field;

        if ($request->hasFile('file')) {
            // Delete the old file from Cloudinary if it exists
            if ($lover->{$field}) {
                $publicId = pathinfo($lover->{$field}, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            // Upload the new file to Cloudinary
            $uploadedFile = Cloudinary::upload($request->file('file')->getRealPath(), [
                'folder' => $field === 'avatar' ? 'lovers/avatars' : 'lovers/pictures',
                'public_id' => $field === 'avatar' ? 'lover_' . $id : 'lover_' . $id . '_' . $field,
                'overwrite' => true,
            ]);
            $lover->{$field} = $uploadedFile->getSecurePath();
        } else {
            // Handle text field updates
            $lover->{$field} = $request->value;
        }

        $lover->save();

        return redirect()->route('lovers.index')->with('success', 'Lover updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lover = Lover::findOrFail($id);

        // Delete avatar from Cloudinary if it exists
        if ($lover->avatar) {
            $publicId = pathinfo($lover->avatar, PATHINFO_FILENAME);
            Cloudinary::destroy('lovers/avatars/' . $publicId);
        }

        // Delete pictures 1 to 9 from Cloudinary if they exist
        for ($i = 1; $i <= 9; $i++) {
            $pictureField = 'picture' . $i;
            if ($lover->{$pictureField}) {
                $publicId = pathinfo($lover->{$pictureField}, PATHINFO_FILENAME);
                Cloudinary::destroy('lovers/pictures/' . $publicId);
            }
        }

        $lover->delete();

        return redirect()->route('lovers.index')->with('success', 'Lover deleted successfully!');
    }
}
