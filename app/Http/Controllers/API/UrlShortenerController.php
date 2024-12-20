<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UrlDecodedResource;
use App\Http\Resources\UrlEncodedResource;
use App\Models\Url;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlShortenerController extends Controller
{
    /**
     * encode a url
     *
     * @return UrlEncodedResource|JsonResponse
     */
    public function encodeUrl(Request $request): UrlEncodedResource|JsonResponse
    {  
        // initialise validator instance
        $validator = Validator::make(
            $request->all(),
            [
                'url' => ['required', 'string', 'url:http,https'],
                'domain' => ['required', 'string', 'url:http,https']
            ]
        );

        // perform validation and respond to errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // identify the user
        $user = $request->user();

        // check api token allows encoding of urls
        if ($user->tokenCan('url:encode')) {
            // add url
            $url = $user->urls()->create([
                'code' => self::generateUniqueId(),
                'domain' => $request->post('domain'),
                'url' => $request->post('url')
            ]);

            // return the resource
            return new UrlEncodedResource($url);
        }

        return response()->json([
            'message' => 'you do not have the ability to encode urls'
        ], 422);
    }

    /**
     * decode a url
     * 
     * @param String $code
     * 
     * @return UrlDecodedResource|JsonResponse
     */
    public function decodeUrl(Request $request, String $code): UrlDecodedResource|JsonResponse
    {
        // initialise validator instance
        $validator = Validator::make(
            $request->all(),
            [
                'code' => ['string', 'exists:urls,code']
            ]
        );

        // perform validation and respond to errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // identify the user
        $user = $request->user();

        // check api token allows encoding of urls
        if ($user->tokenCan('url:decode')) {
            // retrieve the url by the shortened code
            $url = Url::byCode($code)->first();

            // not found
            if (!$url) return response()->json(['message' => 'unable to find the url specified'], 404);

            // return
            return new UrlDecodedResource($url);
        }

        return response()->json([
            'message' => 'you do not have the ability to decode urls'
        ], 403);
    }

    /**
     * @return String
     */
    private static function generateUniqueId(): String
    {
        $key = random_int(100000, 999999);
        $key = str_pad($key, 6, 0, STR_PAD_LEFT);
        return $key;
    }
}
