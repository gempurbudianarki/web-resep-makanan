<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Stichoza\GoogleTranslate\Exceptions\LargeTextException;
use Stichoza\GoogleTranslate\Exceptions\RateLimitException;
use Stichoza\GoogleTranslate\Exceptions\TranslationRequestException;

class TranslationService
{
    private string $myMemoryUrl = 'https://api.mymemory.translated.net/get';

    public function translateToEnglish(string $text): ?string
    {
        if (empty(trim($text))) {
            return null;
        }

        $result = $this->translateWithGoogle($text);

        if ($result === null) {
            Log::info('Google Translate failed, falling back to MyMemory');
            $result = $this->translateWithMyMemory($text);
        }

        return $result;
    }

    private function translateWithGoogle(string $text): ?string
    {
        try {
            $tr = new GoogleTranslate();
            $tr->setSource('id');
            $tr->setTarget('en');
            $tr->setOptions(['timeout' => 8]);

            $translated = $tr->translate($text);

            if ($translated && strtoupper($translated) !== strtoupper($text)) {
                return $translated;
            }
        } catch (RateLimitException $e) {
            Log::warning('Google Translate rate limited: ' . $e->getMessage());
        } catch (LargeTextException $e) {
            Log::warning('Google Translate text too large: ' . $e->getMessage());
        } catch (TranslationRequestException $e) {
            Log::warning('Google Translate request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::warning('Google Translate error: ' . $e->getMessage());
        }

        return null;
    }

    private function translateWithMyMemory(string $text): ?string
    {
        try {
            $response = Http::timeout(5)
                ->get($this->myMemoryUrl, [
                    'q' => $text,
                    'langpair' => 'id|en',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $translated = $data['responseData']['translatedText'] ?? null;

                if ($translated && strtoupper($translated) !== strtoupper($text)) {
                    return $translated;
                }
            }
        } catch (\Exception $e) {
            Log::warning('MyMemory translation failed: ' . $e->getMessage());
        }

        return null;
    }

    public function translateRecipe(array $data): array
    {
        $titleEn = $this->translateToEnglish($data['title'] ?? '');
        $descEn = $this->translateToEnglish($data['description'] ?? '');

        if ($titleEn) {
            $data['title_en'] = $titleEn;
        }
        if ($descEn) {
            $data['description_en'] = $descEn;
        }

        if (!empty($data['steps'])) {
            $data['steps_en'] = $this->translateSteps($data['steps']);
        }

        return $data;
    }

    public function translateSteps(array $steps): array
    {
        $translated = [];

        foreach ($steps as $step) {
            if (is_string($step) && !empty(trim($step))) {
                $en = $this->translateToEnglish($step);
                $translated[] = $en ?: $step;
            } else {
                $translated[] = $step;
            }
        }

        return $translated;
    }
}
