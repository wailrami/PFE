<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Image;
use App\Models\Infrastructure;
use App\Models\Pool;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function Clue\StreamFilter\append;

class InfrastructureController extends Controller
{
    //

    public function index()
    {
        $infrastructures = Infrastructure::all();
        return view('infrastructure.index', compact('infrastructures'));
    }

    public function indexApi()
    {
        //i want to set the url of each main_image without modifying inn the database, just for the api data
        $infrastructures = Infrastructure::all();
        foreach ($infrastructures as $infrastructure) {
            $infrastructure->main_image = url('storage/' . $infrastructure->main_image);
        }
        return response()->json($infrastructures);
    }

    public function create()
    {
        return view('infrastructure.create');
    }

    public function store(Request $request)
    {

        //dd(session('uploadedFiles'));

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

        $uploadedFiles = session()->get('uploadedFiles', []);
        foreach ($uploadedFiles as $file) {
            // Decode the base64 encoded file content
            $decodedContent = base64_decode($file['file']);

            // Create a temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'upload');
            file_put_contents($tempFile, $decodedContent);

            // Create a file object for storage
            $fileObject = new \Illuminate\Http\File($tempFile);

            // Store the file in the desired directory and get the path
            $filePath = Storage::disk('public')->put('images', $fileObject);

            // Remove the temporary file
            unlink($tempFile);

            $image = new Image();
            $image->image = $filePath;
            $image->mime = $file['mime'];
            $image->infrastructure()->associate($infrastructure);
            $image->save();
        }
        $infrastructure->gestionnaire()->associate(auth()->user()->gestionnaire);
        try {
            $infrastructure->save();
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
        }

        session()->forget('uploadedFiles');
        
        return redirect()->route('gestionnaire.infrastructure.index')
            ->with('success', 'The infrastructure ' . $infrastructure->name . ' has been created successfully.');
    }



    public function upload(Request $request)
{
    $data = array();

    $validator = Validator::make($request->all(), [
        'file' => 'mimes:png,jpg,jpeg,pdf,jfif|max:2048'
    ],
    [
        'file.mimes' => 'Invalid file type. Only PNG, JPG, JPEG, PDF, JFIF files are allowed.',
        'file.max' => 'Maximum file size to upload is 2MB.'
    ]);

    if ($validator->fails()) {
        $data['success'] = 0;
        $data['error'] = $validator->errors()->first('images'); // Error response
    } else {
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $uploadedFiles = session()->get('uploadedFiles', []);

            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();

                // Temporarily store the file in the session
                $uploadedFiles[] = [
                    'name' => $filename,
                    'file' => base64_encode(file_get_contents($file->getRealPath())),
                    'mime' => $file->getClientMimeType(),
                ];
            }

            session(['uploadedFiles' => $uploadedFiles]);

            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';
            $data['filenames'] = array_column($uploadedFiles, 'name');
        } else {
            $data['success'] = 0;
            $data['message'] = 'File not uploaded.';
        }
    }

    return response()->json($data);
}

public function clearUploadedFiles()
{
    session()->forget('uploadedFiles');
    return response()->json(['success' => true]);
}


public function delete(Request $request)
{
    $data = array();

    $filename = $request->get('filename');
    $uploadedFiles = session()->get('uploadedFiles', []);

    $fileFound = false;
    foreach ($uploadedFiles as $key => $file) {
        if ($file['name'] === $filename) {
            unset($uploadedFiles[$key]);
            session(['uploadedFiles' => array_values($uploadedFiles)]); // Reindex array

            $fileFound = true;
            break;
        }
    }

    if ($fileFound) {
        $data['success'] = 1;
        $data['message'] = 'File deleted successfully!';
    } else {
        $data['success'] = 0;
        $data['message'] = 'File not found!';
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
            'ville' => 'required' , function($attribute, $value, $fail) {
                if (!preg_match("/^[a-zA-Z ]*$/",$value)) {
                    $fail('The '.$attribute.' must contain only letters and spaces');
                }
                if(ucfirst($value) != $value)
                    $fail('The '.$attribute.' must start with a capital letter');
            },
            'cite' => 'required', 'max:255',
            'infrastructable_type' => 'required',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
        ], [
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
            //'infrastructable_type.required' => 'The type is required',
        ]);

        
        $infrastructure->name = $request->name;
        if(isset($request->description))
            $infrastructure->description = $request->description;
        else
            $infrastructure->description = null;
        $infrastructure->ville = $request->ville;
        $infrastructure->cite = $request->cite;

        if ($infrastructure->infrastructable_type == 'pool') {
            $pool = Pool::find($infrastructure->infrastructable->id);
            $pool->pool_type = $request->pool_type;
            $pool->save();
            $infrastructure->infrastructable()->associate($pool);
        } else if ($infrastructure->infrastructable_type == 'stadium') {
            $stadium = Stadium::find($infrastructure->infrastructable->id);
            $stadium->stadium_type = $request->stadium_type;
            $stadium->save();
            $infrastructure->infrastructable()->associate($stadium);
        } else if ($infrastructure->infrastructable_type == 'hall') {
            $hall = Hall::find($infrastructure->infrastructable->id);
            $hall->hall_type = $request->hall_type;
            $hall->save();
            $infrastructure->infrastructable()->associate($hall);
        }

        if ($request->hasFile('main_image')) {
            $imageFile = $request->file('main_image');
            $infrastructure->main_image = $imageFile->store('images', 'public');
            $infrastructure->main_image_mime = $imageFile->getMimeType();
        }

        $uploadedFiles = session()->get('uploadedFiles', []);
        foreach ($uploadedFiles as $file) {
            // Decode the base64 encoded file content
            $decodedContent = base64_decode($file['file']);
            
            // Create a temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'upload');
            file_put_contents($tempFile, $decodedContent);
            
            // Create a file object for storage
            $fileObject = new \Illuminate\Http\File($tempFile);
            
            // Store the file in the desired directory and get the path
            $filePath = Storage::disk('public')->put('images', $fileObject);
            
            // Remove the temporary file
            unlink($tempFile);
            
            $image = new Image();
            $image->image = $filePath;
            $image->mime = $file['mime'];
            $image->infrastructure()->associate($infrastructure);
            $image->save();
        }

        $infrastructure->save();

        //success message specifying infrastructure name
        return redirect()->route('gestionnaire.infrastructure.index')
            ->with('success', 'The infrastructure ' . $infrastructure->name . ' has been updated successfully.');
    }

    public function destroy(Infrastructure $infrastructure)
    {
        if($infrastructure->main_image)
            unlink(storage_path('app/public/' . $infrastructure->main_image));

        foreach ($infrastructure->images as $image) {
            $image->delete();
        }

        //delete the instance of Stadium, Pool or Hall
        $infrastructure->infrastructable->delete();
        $infrastructure->delete();

        return redirect()->route('gestionnaire.infrastructure.index')
            ->with('success', 'Infrastructure deleted successfully');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $infrastructures = Infrastructure::where('name', 'like', '%' . $search . '%')->get();
        if(auth()->check())
        {
            if(auth()->user()->role == 'client')
                return view('infrastructure.index', compact('infrastructures'));
            else if(auth()->user()->role == 'admin')
                return view('admin.infrastructure.index', compact('infrast  ructures'));
        }
        else 
            return view('guest.infrastructure.index', compact('infrastructures'));
    }



    public function filter(Request $request)
    {
        $filter = $request->get('filter');
        $infrastructures = Infrastructure::where('infrastructable_type',$filter)->get();

        if(auth()->check())
        {

            if(auth()->user()->role == 'client')
                return view('infrastructure.index', compact('infrastructures'));
            else if(auth()->user()->role == 'admin')
                return view('admin.infrastructure.index', compact('infrastructures'));
        }
        else
            return view('guest.infrastructure.index', compact('infrastructures'));
    }



    public function sort(Request $request)
    {
        $sort = $request->get('sort');
        $infarstructures = Infrastructure::orderBy('name', $sort)->get();
        return view('infrastructure.index', compact('infarstructures'));
    }


    //search and filter infrastructure functions for gestionnaire
    public function searchGestionnaire(Request $request)
    {
        $search = $request->get('search');
        $infrastructures = Infrastructure::where('name', 'like', '%' . $search . '%')->where('gestionnaire_id',auth()->user()->gestionnaire->id)->get();
        return view('infrastructure.gestionnaire_index', compact('infrastructures'));
    }

    public function filterGestionnaire(Request $request)
    {
        $filter = $request->get('filter');
        $infrastructures = Infrastructure::where('infrastructable_type',$filter)->where('gestionnaire_id',auth()->user()->gestionnaire->id)->get();
        return view('infrastructure.gestionnaire_index', compact('infrastructures'));
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
