<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        if ($this->validateUserStatus()) {
            $rules = [
                'title' => 'required',
                'description' => 'required',
            ];

            $messages = [
                'title.required' => 'El titulo es requerido',
                'description.required' => 'El contenido es requerido',
            ];

            $this->validate($request, $rules, $messages);

            try {
                DB::beginTransaction();
                $article = Article::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'status' => 1
                ]);
                if ($article) {
                    DB::commit();
                    return response()->json(['success' => 'Articulo creado correctamente', 'article' => $article], 200);
                } else {
                    return response()->json(['error' => 'Error al crear el articulo'], 500);
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('errors', 'Error al crear el articulo, usted no puede crear articulos debe estar activo');
            }
        } else {
            return response()->json(['error' => 'Usuario no autorizado'], 401);
        }
    }


    public function validateUserStatus()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->status == 1) {
            return true;
        }
        return false;
    }

    public function list()
    {
        $articles = Article::where('status', 1)->get();
        return response()->json($articles);
    }

    public function getArticle($id)
    {
        $article = Article::where('id', $id)->first();
        return response()->json($article);
    }

    public function update(Request $request)
    {
        $article = Article::where('id', $request->id)->first();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->status = $request->status;
        $article->save();
        return response()->json(['success' => 'Articulo actualizado correctamente', 'article' => $article], 200);
    }

    public function delete($id)
    {
        $article = Article::where('id', $id)->first()->delete();
        return response()->json(['success' => 'Articulo eliminado correctamente'], 200);
    }
}
