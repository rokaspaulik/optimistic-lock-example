<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\OptimisticLockException;
use App\Models\Content;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __invoke(Request $request)
    {
        $content = Content::first();

        try {
            if ($request->isMethod('post')) {
                $requestVersion = (int) $request->version;
                $modelVersion = (int) $content->version;
    
                if ($requestVersion !== $modelVersion) {
                    throw new OptimisticLockException('Another user edited content.');
                }
    
                $content->update([
                    'content' => $request->content,
                    'version' => $requestVersion + 1,
                ]);
            }
        } catch (OptimisticLockException $e) {
            return view('form', [
                'message' => $e->getMessage(),
                'contentLocked' => $request->content,
                'content' => $content->content ?? '',
                'version' => $content->version,
            ]);
        } catch (\Exception $e) {
            return view('form', [
                'message' => 'Unknown error, please try later.',
                'content' => $content->content ?? '',
                'version' => $content->version,
            ]);
        }

        if (!$content) {
            $content = Content::create();
        }

        return view('form', [
            'content' => $content->content ?? '',
            'version' => $content->version,
        ]);
    }
}
