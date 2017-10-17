<?php

namespace App\Http\Controllers;

use App\Pet;
use App\Tag;
use App\Category;
use App\Http\Requests\CreatePetsRequest;
use Illuminate\Http\Request;

class PetsController extends Controller
{
    public function findByTags(Request $request)
    {
        $tags = explode(",", $request->tags);
        $pet = Pet::with('tags')->whereHas('tags', function($q) use ($tags) {
            $q->whereIn('name', $tags);
        })->get();
        
        return response($pet, 200);
    }
    
    public function findById($petId)
    {
        $pet = Pet::findOrFail($petId);
        return response($pet, 200);
    }
    
    public function updateWithId(Request $request, $petId)
    {
        $pet = Pet::findOrFail($request->petId);
        $pet->update($request->only(['name', 'status']));
        
        return response('Successfully updated a Pet record', 200);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $cat = Category::create($request->category);
        $tags = $request->tags;
        $data = $request->only([
            'name', 'status'
        ]);
        $data['categoryId'] = $cat->id;
        $data['photoUrls'] = $request->photoUrls[0];

        $pet = Pet::create($data);

        foreach ($tags as $tag) {
            if (!$pet->tags->contains($tag['id'])) {
                $tagId = Tag::create($tag);
                $pet->tags()->attach($tagId->id);
            }
        }


        return response('Successfully created a Pet record', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pet = Pet::findOrFail($request->id);
        $tags = $request->tags;
        $data = $request->only([
            'name', 'status'
        ]);
        
        $pet->update($data);

        if (!Category::where('id', $request->category['id'])->exists()) {
            $cat = Category::create($request->category);
            $data['categoryId'] = $cat->id;
            $pet->update($data);
        }

        foreach ($tags as $tag) {
            if (!$pet->tags->contains($tag['id'])) {
                $tagId = Tag::create($tag);
                $pet->tags()->attach($tagId->id);
            }
        }
        return response('Successfully updated a Pet record', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = Pet::findOrfail($id);
        $pet->delete();
        
        return response('Successfully deleted a Pet record', 200);
    }
}
