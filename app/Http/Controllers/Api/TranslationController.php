<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
/**
 * @OA\Info(
 *     title="Translation Management API",
 *     version="1.0.0",
 *     description="API for managing translations",
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="API Server"
 * )
 */
class TranslationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="key", type="string", example="welcome"),
     *             @OA\Property(property="content", type="string", example="Welcome!"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string", example="web"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Translation created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="key", type="string", example="welcome"),
     *             @OA\Property(property="content", type="string", example="Welcome!"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string", example="web"))
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'locale' => 'required|string|max:10',
            'key' => 'required|string|max:255|unique:translations,key',
            'content' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        $translation = Translation::create($validated);

        return response()->json($translation, 201);
    }

    /**
     * @OA\Put(
     *     path="/translations/{id}",
     *     summary="Update an existing translation",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the translation to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="key", type="string", example="greeting"),
     *             @OA\Property(property="content", type="string", example="Hello, world!"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string", example="mobile"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="key", type="string", example="greeting"),
     *             @OA\Property(property="content", type="string", example="Hello, world!"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string", example="mobile"))
     *         )
     *     )
     * )
     */
    public function update(Request $request, Translation $translation): JsonResponse
    {
        $validated = $request->validate([
            'locale' => 'sometimes|required|string|max:10',
            'key' => 'sometimes|required|string|max:255|unique:translations,key,' . $translation->id,
            'content' => 'sometimes|required|string',
            'tags' => 'nullable|array',
        ]);

        $translation->update($validated);

        return response()->json($translation);
    }

    /**
     * @OA\Get(
     *     path="/translations/{id}",
     *     summary="Get a specific translation",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the translation to retrieve",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation details retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="key", type="string", example="greeting"),
     *             @OA\Property(property="content", type="string", example="Hello!"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string", example="web"))
     *         )
     *     )
     * )
     */
    public function show(Translation $translation): JsonResponse
    {
        return response()->json($translation);
    }

    /**
     * @OA\Get(
     *     path="/translations",
     *     summary="List translations with optional filters",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         required=false,
     *         description="Filter by tags",
     *         @OA\Schema(type="string", example="web")
     *     ),
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         required=false,
     *         description="Filter by key",
     *         @OA\Schema(type="string", example="greeting")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of translations retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="locale", type="string", example="en"),
     *                 @OA\Property(property="key", type="string", example="greeting"),
     *                 @OA\Property(property="content", type="string", example="Hello!"),
     *                 @OA\Property(property="tags", type="array", @OA\Items(type="string", example="web"))
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Translation::query();

        if ($request->has('tags')) {
            $query->whereJsonContains('tags', $request->get('tags'));
        }

        if ($request->has('key')) {
            $query->where('key', 'like', '%' . $request->get('key') . '%');
        }

        if ($request->has('content')) {
            $query->where('content', 'like', '%' . $request->get('content') . '%');
        }

        return response()->json($query->paginate(10));
    }

    /**
     * @OA\Get(
     *     path="/export",
     *     summary="Export all translations as JSON",
     *     tags={"Translations"},
     *     @OA\Response(
     *         response=200,
     *         description="Exported translations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="locale", type="string", example="en"),
     *                 @OA\Property(property="key", type="string", example="greeting"),
     *                 @OA\Property(property="content", type="string", example="Hello!"),
     *                 @OA\Property(property="tags", type="array", @OA\Items(type="string", example="web"))
     *             )
     *         )
     *     )
     * )
     */
    public function export(): JsonResponse
    {
        $translations = Translation::all();

        return response()->json($translations);
    }
}
