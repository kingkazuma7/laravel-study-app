<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request) {
      $query = Person::query();

      if ($request->filled('person_code')) {
        $query->where('person_code', $request->person_code);
      }

      $items = $query->get();
      return view('person.index', ['items' => $items]);
    }
}
