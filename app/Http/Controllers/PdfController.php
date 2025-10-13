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
    $pdfs = Pdf::query()
      ->when($req->filled('ano'), fn($q)=>$q->where('ano', (int)$req->ano))
      ->when($req->filled('q'), function($q) use ($req){
        $t = trim($req->q);
        $q->where('titulo','like',"%{$t}%");
      })
      ->latest()
      ->paginate(24)
      ->withQueryString();

    return view('pdfs.index', compact('pdfs'));
  }

  public function store(Request $req)
  {
    $data = $req->validate([
      'titulo' => ['required','string','max:255'],
      'ano'    => ['required','integer','min:1990','max:2100'],
      'arquivo'=> ['required','file','mimetypes:application/pdf','max:25600'], // até ~25MB
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

