<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->filled('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }

        if ($request->filled('content')) {
            $query->whereFullText('value', $request->content);
        }

        if ($request->filled('tags')) {
            $query->whereJsonContains('tags', $request->tags);
        }

        return response()->json($query->paginate(50));
    }

    public function store(StoreTranslationRequest $request)
    {
        $translation = Translation::create($request->validated());
        Cache::forget("export_translations_{$translation->locale}");
        return response()->json($translation, 201);
    }

    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        $translation->update($request->validated());
        Cache::forget("export_translations_{$translation->locale}");
        return response()->json($translation);
    }

    public function export($locale)
    {
        $translations = Cache::remember("export_translations_{$locale}", 60, function () use ($locale) {
            return Translation::where('locale', $locale)->pluck('value', 'key');
        });

        return response()->json($translations);
    }
}
