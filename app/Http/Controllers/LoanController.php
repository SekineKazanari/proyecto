<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

use Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

        $loans = Loan::all();
        $books = Book::all();
        $categories = Category::all();

        return view('loans.index',compact('loans', 'books', 'categories'));
   
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
        if ($loan = Loan::create($request->all())) {
            return redirect()->back()->with('success', 'El registro se creó correctamente');
        }
         return redirect()->back()->with('error', 'No se pudo crear el registro');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $loan = Loan::find($request->id);
        if ($loan->update($request->all())) {
            return redirect()->back()->with('success', 'El registro se modificó correctamente');
        }
        return redirect()->back()->with('error', 'No se pudo modificar el registro');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        if ($loan) {
            if ($loan->delete()) {
               return response()->json([
                    'message' => 'Registro eliminado correctamente',
                    'code' => '200'
                ]);
            }
        }
        return response()->json([
                'message' => 'No se pudo eliminar el registro',
                'code' => '400'
            ]);
    }
}
