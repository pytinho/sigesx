<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfController extends Controller
{
  public function index(Request $req)
{
    // filtros
    $q   = trim((string) $req->input('q', ''));
    $ano = $req->integer('ano');

    // filtro ordenar
    $sort = $req->get('sort', 'ano');      
    $dir  = $req->get('dir',  'desc');     
    $allowed = ['ano','titulo','size'];
    if (!in_array($sort, $allowed, true))  { $sort = 'ano'; }
    $dir = $dir === 'asc' ? 'asc' : 'desc';

    $pdfs = Pdf::query()
        ->when($ano, fn($qb) => $qb->where('ano', $ano))
        ->when($q !== '', fn($qb) => $qb->where('titulo', 'like', "%{$q}%"))
        ->orderBy($sort, $dir)             
        ->orderBy('id', 'desc')            
        ->paginate(24)
        ->withQueryString();               

    return view('pdfs.index', compact('pdfs'));
}

  public function store(Request $req)
  {
    $data = $req->validate([
      'titulo' => ['required','string','max:255'],
      'ano'    => ['required','integer','min:1990','max:2100'],
      'arquivo'=> ['required','file','mimetypes:application/pdf','max:25600'], 
    ]);

    $file = $data['arquivo'];
    $uuid = (string) Str::uuid();
    $dir  = "pdfs/{$data['ano']}";
    Storage::disk('local')->makeDirectory($dir);
    $path = $file->storeAs($dir, "{$uuid}.pdf", 'local');

    Pdf::create([
      'titulo' => $data['titulo'],
      'ano'    => $data['ano'],
      'disk'   => 'local',
      'path'   => $path,
      'mime'   => $file->getMimeType(),
      'size'   => $file->getSize(),
      'user_id'=> auth()->id(),
    ]);

    return back()->with('success','PDF enviado com sucesso!');
  }

  public function download(Pdf $pdf)
  {
    return Storage::disk($pdf->disk)->download(
      $pdf->path,
      Str::slug($pdf->titulo).'.pdf'
    );
  }

  public function destroy(Pdf $pdf)
  {
    Storage::disk($pdf->disk)->delete($pdf->path);
    $pdf->delete();
    return back()->with('success','PDF removido.');
  }
}

