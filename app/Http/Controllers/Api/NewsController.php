<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\NewsViewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * News Index - List all news with pagination
     */
    public function index(Request $request)
    {
        try {
            $keyword = $request->input('q');
            $perPage = $request->input('perPage', 10);
            $data = News::where('title', 'like', "%$keyword%")->paginate($perPage);
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'News retrieved successfully',
                'meta' => [
                    'query' => $keyword,
                    'path' => $data->path(),
                    'total' => $data->total(),
                    'perPage' => $data->perPage(),
                    'currentPage' => $data->currentPage(),
                    'lastPage' => $data->lastPage(),
                    'from' => $data->firstItem(),
                    'to' => $data->lastItem(),
                    'hasNext' => $data->hasMorePages(),
                    'hasPrevious' => $data->currentPage() > 1,
                ],
                'data' => NewsResource::collection($data)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * News Show - Get news details by slug
     */
    public function show($slug)
    {
        try {
            $currentUserInfo = Location::get(request()->ip());
            $news_viewers = new NewsViewer();
            $news_viewers->news_id = News::where('slug', $slug)->value('id');
            $news_viewers->ip = request()->ip();
            if ($currentUserInfo) {
                $news_viewers->country = $currentUserInfo->countryName;
                $news_viewers->city = $currentUserInfo->cityName;
                $news_viewers->region = $currentUserInfo->regionName;
                $news_viewers->postal_code = $currentUserInfo->postalCode;
                $news_viewers->latitude = $currentUserInfo->latitude;
                $news_viewers->longitude = $currentUserInfo->longitude;
                $news_viewers->timezone = $currentUserInfo->timezone;
            }
            $news_viewers->user_agent = Agent::getUserAgent();
            $news_viewers->platform = Agent::platform();
            $news_viewers->browser = Agent::browser();
            $news_viewers->device = Agent::device();
            $news_viewers->save();

            $news = News::where('slug', $slug)->firstOrFail();
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'News retrieved successfully',
                'data' => new NewsResource($news)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => Response::HTTP_NOT_FOUND,
                'success' => false,
                'message' => 'News not found',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * news Comment - Submit a comment to a news item
     */
    public function comment(Request $request, $slug)
    {
        try {
            $news = News::where('slug', $slug)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'comment' => 'required|string',
                'parent_id' => 'nullable|exists:news_comments,id',
            ]);
            $validation = array_fill_keys(array_keys($request->all()), []);
            if ($validator->fails()) {
                foreach ($validator->errors()->toArray() as $key => $errors) {
                    $validation[$key] = $errors;
                }
                return response()->json([
                    'response' => Response::HTTP_BAD_REQUEST,
                    'success' => false,
                    'message' => 'Validation error occurred',
                    'validation' => $validation,
                    'data' => null
                ], Response::HTTP_BAD_REQUEST);
            }

            $newsComment = $news->comments()->create([
                'comment' => $request->input('comment'),
                'parent_id' => $request->input('parent_id'),
            ]);

            return response()->json([
                'response' => Response::HTTP_CREATED,
                'success' => true,
                'message' => 'Comment submitted successfully',
                'data' => $newsComment,
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
