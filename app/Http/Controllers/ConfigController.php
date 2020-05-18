<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        if(! auth()->user()->admin)
            return redirect()->back()->with("error", "no permission");

        $config = Config::all();

        return view("config.index", compact("config"));
    }

    public function create()
    {
        return view("config.create");
    }

    public function store(Request $request)
    {
        try {
            $configItem = new Config($request->all());
            $configItem->save();
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return redirect()->route("settings.index")->with("success", "Created new config Item");
    }

    public function edit($id)
    {
        $item = Config::findOrFail($id);

        return view("config.edit", compact("item"));
    }

    public function update(Request $request, $id)
    {
        $item = Config::findOrFail($id);
        $item->key = $request->get("key");
        $item->value = $request->get("value");
        $item->save();

        return redirect()->route("settings.index")->with("success", "Updated config settings");
    }
}
