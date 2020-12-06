<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if(Auth::user()->hasPermissionTo('view loans')){
            if(Auth::user()->role_id == 1)
                $loans = Loan::with('books.Category','users')->get();
            else
                $loans = Loan::with('books.Category','users')->where('user_id',Auth::user()->id)->get();

            return view('loans.index',compact('loans'));
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
        if(Auth::user()->hasPermissionTo('create loans')){
            $book = Book::where('id',$request['book_id']);
            $book->Update(['status' => 1]);
            $loan = new Loan();
            $loan->user_id = Auth::user()->id;
            $loan->book_id = $request['book_id'];
            $loan->state = 1;
            $loan->save();
            return  redirect()->back()->with('success', 'Se ha creado el prestamo');
        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

            $loans = Loan::with('books')->get()->groupBy('book_id');
            return $loans;

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        if(Auth::user()->hasPermissionTo('update loans')){
            $loan = Loan::find($request['id']);
            $book = Book::where('id',$loan->book_id);
            $book->Update(['status'=>0]);
            if($loan->Update($request->all())){
                return  redirect()->back()->with('success', 'Se ha regresado el libro');
            }
            return  redirect()->back()->with('error', 'No se ha regresado el libro');

        }
        return redirect()->back()->with("error","No tienes permisos"); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        if(Auth::user()->hasPermissionTo('delete loans')){
            if($loan){
                $book = Book::find($loan->book_id);
                $book->Update(['status' => 0]);
                if($loan->delete()){
                    return response()->json([
                        'message' => 'Se ha eliminado el prestamo', 
                        'code' => '200'
                    ]);
                }
                return response()->json([
                        'message' => "No se ha eliminado el prestamo", 
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
