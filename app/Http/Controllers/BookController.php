<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Auth;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasPermissionTo('view books')){
            $books = Book::with('Category')->get();
            $categories = Category::all();
            return view('books.index',compact('books','categories'));
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create books')){
            if($book = Book::create($request->all())){
                if ($request->hasFile('cover')) {
                    $file = $request->file('cover');
                    $fileName = 'book_cover'.$book->id.'.'.$file->getClientOriginalExtension();
                    $path = $request->file('cover')->storeAs('img/books',$fileName);
                    $book->cover = $fileName;
                    $book->save();
                }
                return  redirect()->back()->with('success', 'Se ha creado el libro');
            }
            return  redirect()->back()->with('error', "No se pudo crear el libro");
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->hasPermissionTo('update books')){
            $book = Book::with('Category')->where('id',$id)->get();
            $loans = Loan::with('books','users')->where('book_id',$id)->get();
            return view('books.info',compact('book','loans'));
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->hasPermissionTo('update books')){
            $book = Book::find($request['id']);
            if($book->Update($request->all())){
                if ($request->hasFile('cover')) {
                    $file = $request->file('cover');
                    $fileName = 'book_cover'.$book->id.'.'.$file->getClientOriginalExtension();
                    $path = $request->file('cover')->storeAs('img/books',$fileName);
                    $book->cover = $fileName;
                    $book->save();
                }
                return  redirect()->back()->with('success', 'Se ha actualizado el libro');
            }
            return redirect()->back()->with('error', 'No se ha actualizado el libro'); 
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if(Auth::user()->hasPermissionTo('delete books')){
            if($book){
                Loan::where('book_id',$book->id)->delete();
                if($book->delete()){
                    return response()->json([
                        'message' => 'Se ha eliminado el libro', 
                        'code' => '200'
                    ]);
                }
                return response()->json([
                        'message' => "No se ha eliminado el libro", 
                        'code' => '400'
                    ]);
            }
        }
        return response()->json([
            'message' => "No tienes permisos", 
            'code' => '403'
        ]);
    }
}
