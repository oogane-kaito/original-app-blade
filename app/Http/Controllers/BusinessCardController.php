<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BusinessCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $businessCards = BusinessCard::where('user_id', Auth::id())
                                       ->orderBy('created_at', 'desc')
                                       ->get();
            
            return view('business-cards.index', compact('businessCards'));
        } catch (\Exception $e) {
            Log::error('Error fetching business cards: ' . $e->getMessage());
            return redirect()->back()->with('error', '名刺の取得に失敗しました。');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('business-cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // デバッグ用ログ
        Log::info('Store method called', [
            'request_data' => $request->all(),
            'visibility_raw' => $request->input('visibility'),
            'visibility_type' => gettype($request->input('visibility')),
            'user_id' => Auth::id()
        ]);

        try {
            $validated = $this->validateBusinessCard($request);
            $validated['user_id'] = Auth::id();
            
            // visibilityの明示的な変換
            $validated['visibility'] = $this->convertToBoolean($request->input('visibility', false));
            
            // リンクデータの処理
            $validated['links'] = $this->processLinksData($request->input('links', '[]'));

            Log::info('Validation passed', ['validated_data' => $validated]);

            $businessCard = BusinessCard::create($validated);

            Log::info('Business card created successfully', ['card_id' => $businessCard->id]);

            return redirect()->route('editor.index')
                            ->with('success', '名刺が作成されました。');

        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
                'visibility_value' => $request->input('visibility'),
                'visibility_type' => gettype($request->input('visibility'))
            ]);
            
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput()
                            ->with('error', 'バリデーションエラーが発生しました。');

        } catch (\Exception $e) {
            Log::error('Error creating business card: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', '名刺の作成に失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessCard $businessCard)
    {
        try {
            // Check if the card is public or belongs to the authenticated user
            if (!$businessCard->visibility && (!Auth::check() || $businessCard->user_id !== Auth::id())) {
                abort(404);
            }

            return view('business-cards.show', compact('businessCard'));
        } catch (\Exception $e) {
            Log::error('Error showing business card: ' . $e->getMessage());
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessCard $businessCard)
    {
        // Ensure the user can only edit their own cards
        if ($businessCard->user_id !== Auth::id()) {
            abort(403);
        }

        return view('business-cards.edit', compact('businessCard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessCard $businessCard)
    {
        // デバッグ用ログ
        Log::info('Update method called', [
            'request_data' => $request->all(),
            'visibility_raw' => $request->input('visibility'),
            'visibility_type' => gettype($request->input('visibility')),
            'card_id' => $businessCard->id,
            'user_id' => Auth::id()
        ]);

        try {
            // Ensure the user can only update their own cards
            if ($businessCard->user_id !== Auth::id()) {
                abort(403);
            }

            $validated = $this->validateBusinessCard($request);
            
            // visibilityの明示的な変換
            $validated['visibility'] = $this->convertToBoolean($request->input('visibility', false));
            
            // リンクデータの処理
            $validated['links'] = $this->processLinksData($request->input('links', '[]'));

            Log::info('Update validation passed', ['validated_data' => $validated]);

            $businessCard->update($validated);

            Log::info('Business card updated successfully', ['card_id' => $businessCard->id]);

            return redirect()->route('editor.index')
                            ->with('success', '名刺が更新されました。');

        } catch (ValidationException $e) {
            Log::error('Update validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
                'visibility_value' => $request->input('visibility'),
                'visibility_type' => gettype($request->input('visibility'))
            ]);
            
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput()
                            ->with('error', 'バリデーションエラーが発生しました。');

        } catch (\Exception $e) {
            Log::error('Error updating business card: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', '名刺の更新に失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessCard $businessCard)
    {
        try {
            // Ensure the user can only delete their own cards
            if ($businessCard->user_id !== Auth::id()) {
                abort(403);
            }

            $businessCard->delete();

            return redirect()->route('business-cards.index')
                            ->with('success', '名刺が削除されました。');
        } catch (\Exception $e) {
            Log::error('Error deleting business card: ' . $e->getMessage());
            return redirect()->back()->with('error', '名刺の削除に失敗しました。');
        }
    }

    /**
     * Convert value to boolean
     */
    private function convertToBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            return in_array(strtolower($value), ['true', '1', 'on', 'yes']);
        }
        
        if (is_numeric($value)) {
            return (bool) $value;
        }
        
        return false;
    }

    /**
     * Validate business card data
     */
    private function validateBusinessCard(Request $request)
    {
        Log::info('Starting validation', [
            'request_data' => $request->all(),
            'visibility_raw' => $request->input('visibility'),
            'visibility_type' => gettype($request->input('visibility'))
        ]);

        $rules = [
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|string|max:500',
            'theme' => 'nullable|string|in:nature,sunny,warm,fresh,gentle',
            'backgroundColor' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'textColor' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accentColor' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'links' => 'nullable|string',
            // visibilityのバリデーションを緩和
            'visibility' => 'nullable'
        ];

        $messages = [
            'name.required' => 'お名前は必須です。',
            'name.max' => 'お名前は255文字以内で入力してください。',
            'title.max' => '肩書きは255文字以内で入力してください。',
            'bio.max' => '自己紹介は1000文字以内で入力してください。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'phone.max' => '電話番号は20文字以内で入力してください。',
            'backgroundColor.regex' => '背景色は正しい形式で入力してください。',
            'textColor.regex' => 'テキスト色は正しい形式で入力してください。',
            'accentColor.regex' => 'アクセント色は正しい形式で入力してください。',
            'theme.in' => '選択されたテーマが無効です。',
        ];

        try {
            $validated = $request->validate($rules, $messages);
            Log::info('Validation successful', ['validated_data' => $validated]);
            return $validated;
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'rules' => $rules,
                'request_data' => $request->all()
            ]);
            throw $e;
        }
    }

    /**
     * Process links data from JSON string
     */
    private function processLinksData($linksJson)
    {
        Log::info('Processing links data', ['links_json' => $linksJson]);

        try {
            if (empty($linksJson)) {
                return [];
            }

            $links = json_decode($linksJson, true);
            
            if (!is_array($links)) {
                Log::warning('Links data is not an array', ['links_data' => $links]);
                return [];
            }

            // リンクデータのサニタイズと検証
            $processedLinks = [];
            foreach ($links as $index => $link) {
                Log::info("Processing link {$index}", ['link' => $link]);

                if (isset($link['url']) && !empty($link['url'])) {
                    // URLの検証
                    if (filter_var($link['url'], FILTER_VALIDATE_URL)) {
                        $processedLinks[] = [
                            'id' => $link['id'] ?? uniqid(),
                            'title' => strip_tags($link['title'] ?? ''),
                            'url' => filter_var($link['url'], FILTER_SANITIZE_URL),
                            'icon' => in_array($link['icon'] ?? '', ['twitter', 'instagram', 'linkedin', 'github', 'website', 'mail']) 
                                    ? $link['icon'] 
                                    : 'website',
                            'delete' => false
                        ];
                    } else {
                        Log::warning("Invalid URL in link {$index}", ['url' => $link['url']]);
                    }
                }
            }

            Log::info('Links processing completed', ['processed_links' => $processedLinks]);
            return $processedLinks;

        } catch (\Exception $e) {
            Log::error('Error processing links data: ' . $e->getMessage(), [
                'links_json' => $linksJson,
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }
}
