<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Image;
use App\Models\Infrastructure;
use App\Models\Pool;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfrastructureController extends Controller
{
    //

    public function index()
    {
        $infrastructures = Infrastructure::all();
        return view('infrastructure.index', compact('infrastructures'));
    }

    public function create()
    {
        return view('infrastructure.create');
    }

    public function store(Request $request)
    {

        
        $request->validate([
            'name' => 'required',
            'ville' => 'required',
            'cite' => 'required',
            'infrastructable_type' => 'required',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
        ], [
            'main_image.required' => 'The main image is required',
            'main_image.image' => 'The main image must be an image',
            'main_image.mimes' => 'The main image must be a file of type: jpeg, png, jpg, gif, svg, jfif',
            'main_image.max' => 'The main image may not be greater than 2048 kilobytes',
            'images.array' => 'The images must be an array',
            'images.*.image' => 'The images must be images',
            'images.*.mimes' => 'The images must be files of type: jpeg, png, jpg, gif, svg, jfif',
            'images.*.max' => 'The images may not be greater than 2048 kilobytes',
            'name.required' => 'The name is required',
            'ville.required' => 'The city is required',
            'cite.required' => 'The address is required',
            'infrastructable_type.required' => 'The type is required',
        ]);

        // dd($request->all());

        $infrastructure = new Infrastructure();

        $infrastructure->name = $request->name;
        if(isset($request->description))
            $infrastructure->description = $request->description;
        else
            $infrastructure->description = null;
        $infrastructure->ville = $request->ville;

        $infrastructure->cite = $request->cite;


        if ($request->infrastructable_type == 'pool') {
            $pool = new Pool();
            /* $pool->length = $request->length;
            $pool->width = $request->width;
            $pool->depth = $request->depth; */
            $pool->pool_type = $request->pool_type;
            $pool->save();
            $infrastructure->infrastructable()->associate($pool);
        } else if ($request->infrastructable_type == 'stadium') {
            $stadium = new Stadium();
            $stadium->stadium_type = $request->stadium_type;
            $stadium->save();
            $infrastructure->infrastructable()->associate($stadium);
        } else if ($request->infrastructable_type == 'hall') {
            $hall = new Hall();
            $hall->hall_type = $request->hall_type;
            $hall->save();
            $infrastructure->infrastructable()->associate($hall);
        }

        
        $imageFile = $request->file('main_image');
        $infrastructure->main_image = $imageFile->store('images', 'public');
        $infrastructure->main_image_mime = $imageFile->getMimeType();

        if ($request->hasFile('images')){
            
            foreach ($request->file('images') as $imageFile) {
                $image = new Image();
                $image->image = file_get_contents($imageFile->getRealPath());
                $image->mime = $imageFile->getMimeType();
                $image->infrastructure()->associate($infrastructure);
                $image->save();
            }
        }

        $infrastructure->gestionnaire()->associate(auth()->user()->gestionnaire);
        try {
            $infrastructure->save();
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
        }
        
        return redirect()->route('gestionnaire.infrastructure.index')
            ->with('success', 'Infrastructure created successfully.');
    }



    public function upload(Request $request)
    {
        $data = array();

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:png,jpg,jpeg,pdf,jfif|max:2048'
        ]);

        if ($validator->fails()) {
            
            $data['success'] = 0;
            $data['error'] = $validator->errors()->first('file');// Error response
            
        }else{
            if($request->file('file')) {
                
                $file = $request->file('file');
                $filename = time().'_'.$file->getClientOriginalName();

                // File upload location
                $location = 'files';

                if(is_writable($location))
                {
                    // Upload file
                    $file->move($location,$filename);
                    // Response
                    $data['success'] = 1;
                    $data['message'] = 'Uploaded Successfully!';

                }else{
                    // Response
                    $data['success'] = 0;
                    $data['message'] = 'Destination is not writable.';
                }



            }else{
                    // Response
                    $data['success'] = 0;
                    $data['message'] = 'File not uploaded.'; 
            }
        }

        return response()->json($data);
    }







    public function show(Infrastructure $infrastructure)
    {
        $images = $infrastructure->images;
        return view('infrastructure.show', compact('infrastructure'))->with('images', $images);
    }


    
    public function edit(Infrastructure $infrastructure)
    {
        return view('infrastructure.edit', compact('infrastructure'));
    }

    public function update(Request $request, Infrastructure $infrastructure)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        $infrastructure->update($request->all());

        return redirect()->route('infrastructure.index')
            ->with('success', 'Infrastructure updated successfully');
    }

    public function destroy(Infrastructure $infrastructure)
    {
        $infrastructure->delete();

        return redirect()->route('infrastructure.index')
            ->with('success', 'Infrastructure deleted successfully');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $infarstructures = Infrastructure::where('name', 'like', '%' . $search . '%')->get();
        return view('infrastructure.index', compact('infarstructures'));
    }



    public function filter(Request $request)
    {
        $filter = $request->get('filter');
        $infarstructures = Infrastructure::where('type', 'like', '%' . $filter . '%')->get();
        return view('infrastructure.index', compact('infarstructures'));
    }



    public function sort(Request $request)
    {
        $sort = $request->get('sort');
        $infarstructures = Infrastructure::orderBy('name', $sort)->get();
        return view('infrastructure.index', compact('infarstructures'));
    }



    public function sortDesc(Request $request)
    {
        $sort = $request->get('sort');
        $infarstructures = Infrastructure::orderBy('name', $sort)->get();
        return view('infrastructure.index', compact('infarstructures'));
    }



    public function sortAsc(Request $request)
    {
        $sort = $request->get('sort');
        $infarstructures = Infrastructure::orderBy('name', $sort)->get();
        return view('infrastructure.index', compact('infarstructures'));
    }



    public function filterSort(Request $request)
    {
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $infarstructures = Infrastructure::where('type', 'like', '%' . $filter . '%')->orderBy('name', $sort)->get();
        return view('infrastructure.index', compact('infarstructures'));
    }

    public function gestionnaireIndex()
    {
        $infrastructures = auth()->user()->gestionnaire->infrastructures;
        return view('infrastructure.gestionnaire_index', compact('infrastructures'));
    }




    public function details(Infrastructure $infrastructure)
    {
        $images = $infrastructure->images;
        return view('infrastructure.show', compact('infrastructure'))->with('images', $images);
    }



    
    
}
