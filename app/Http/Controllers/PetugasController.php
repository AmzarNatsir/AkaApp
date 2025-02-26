<?php

namespace App\Http\Controllers;

use App\Models\PetugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Throwable;

class PetugasController extends Controller
{
    public function list()
    {
        return view('petugas.list');
    }
    public function getData(Request $request)
    {
        $columns = ['created_at'];
        $totalData = PetugasModel::where('aktif', 'y')->count();
        $search = $request->input('search.value');
        $query = PetugasModel::where('aktif', 'y')->select('*');
        if(!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->Where('nama_petugas', 'like', "%{$search}%");
            });
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
                      ->limit($request->input('length'))
                        ->orderBy('id', 'asc')
                      ->get();

        $data = array();
        if($query){
            $counter = $request->input('start') + 1;
            foreach($query as $r){
                $no_image = "<a href=".asset('assets/images/avtar/11.jpg')." data-fancybox data-caption='No Image'><img class='img-fluid' src=".asset('assets/images/avtar/11.jpg')." alt='avatar'></a>";
                $yes_image = "<a href=".Storage::url('petugas/'.$r->photo)." data-fancybox data-caption='No Image'><img class='img-fluid' src=".Storage::url('petugas/'.$r->photo)." alt='avatar'></a>";
                $photo = (empty($r->photo)) ? $no_image : $yes_image;
                $petugas = '<div class="product-names">
                                <div class="light-product-box">'.$photo.'</div>
                                <p>'.$r->nama_petugas.'</p>
                              </div>';
                $btn = "<button type='button' class='btn btn-danger btn-sm' id='btn_delete' value='".$r->id."' onclick='konfirmDelete(this)'><i class='icon-trash'></i></button><button type='button' class='btn btn-success btn-sm' id='btn_edit' data-bs-toggle='modal' data-bs-target='#exampleModalgetbootstrap' data-whatever='@getbootstrap' value='".$r->id."'><i class='icon-pencil-alt'></i></button>";
                $Data['act'] = $btn;
                $Data['id'] =  $r->id;
                $Data['nama_petugas'] =  $petugas;
                $Data['ttl'] =  $r->tempat_lahir.", ".$r->tanggal_lahir;
                $Data['jenkel'] =  $r->jenkel;
                $Data['alamat'] =  $r->alamat;
                $Data['no_telepon'] =  $r->no_telpon;
                $Data['photo'] =  $r->photo;
                $Data['no'] = $counter;
                $data[] = $Data;
                $counter++;
            }
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        try {
            $fileImage = NULL;
            $path = NULL;
            if($request->hasFile('inpFile'))
            {
                $path = storage_path("app/public/petugas");
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('petugas');
                }
                $image = $request->file('inpFile');
                $fileImage = time() . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::read($image->getRealPath());
                $image_resize->resize(300, 300, function($construction){
                    $construction->aspectRatio();
                });
                $image_resize->save(storage_path("app/public/petugas/".$fileImage));

            }
                PetugasModel::create([
                    "nama_petugas" => $request->inpNama,
                    "tempat_lahir" => $request->inpTempatLahir,
                    "tanggal_lahir" => $request->inpTanggalLahir,
                    "jenkel" => $request->pilihanJenkel,
                    "alamat" => $request->inpAlamat,
                    "no_telpon" => $request->inpNotel,
                    'photo' => $fileImage,
                    'photo_path' => $path,
                    'aktif' => "y"
                ]);
                $rs = response()->json([
                    'success' => true,
                    'message' => "Data baru berhasil disimpan"
                ]);

        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data baru"
            ]);
        }
        return $rs;

        // return redirect()->route('datamaster.merek')
        //         ->withSuccess('New Merek is added successfully.');
    }
    public function edit($id)
    {
        $data = [
            'res' => PetugasModel::find($id)
        ];
        return view('petugas.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $fileImage = (empty($request->tmpFile)) ? NULL : $request->tmpFile;
            $path = (empty($request->tmpFilePath)) ? NULL : $request->tmpFilePath;
            if($request->hasFile('inpFile'))
            {
                if(!empty($fileImage)) {
                    $this->del_image_folder($id);
                }
                $path = storage_path("app/public/petugas");
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('petugas');
                }
                $image = $request->file('inpFile');
                $fileImage = time() . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::read($image->getRealPath());
                $image_resize->resize(300, 300, function($construction){
                    $construction->aspectRatio();
                });
                $image_resize->save(storage_path("app/public/petugas/".$fileImage));

            }

            $updateExec = PetugasModel::find($id)->update([
                "nama_petugas" => $request->inpNama,
                "tempat_lahir" => $request->inpTempatLahir,
                "tanggal_lahir" => $request->inpTanggalLahir,
                "jenkel" => $request->pilihanJenkel,
                "alamat" => $request->inpAlamat,
                "no_telpon" => $request->inpNotel,
                'photo' => $fileImage,
                'photo_path' => $path,
            ]);
            if($updateExec) {
                $status = true;
                $message = "Data updated successfully.";
            } else {
                $status = false;
                $message = "Data update not successfully.";
            }
            $rs = response()->json([
                'success' => $status,
                'message' => $message
            ]);
        } catch (Throwable $e) {
            $rs = response()->json([
                'success' => false,
                'message' => "Terdapat error pada proses penyimpanan data"
            ]);
        }
        return $rs;
    }

    public function destroy($id)
    {
        $del = PetugasModel::find($id)->update(['aktif' => 't']);
        if($del) {
            $rs = response()->json([
                'success' => true
            ]);
        } else {
            $rs = response()->json([
                'success' => false
            ]);
        }
        return $rs;
    }

    public function del_image_folder($id)
    {
        $resfile = PetugasModel::find($id);
        $filename = $resfile->photo;
        $image_path = storage_path('app/public/petugas/'.$filename);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }
}
