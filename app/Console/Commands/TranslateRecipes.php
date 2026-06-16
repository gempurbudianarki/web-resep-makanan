<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use App\Services\TranslationService;
use Illuminate\Console\Command;

class TranslateRecipes extends Command
{
    protected $signature = 'recipes:translate {--force : Re-translate all recipes even if already translated}';
    protected $description = 'Auto-translate all recipe titles and descriptions to English using Google Translate (with MyMemory fallback)';

    public function handle(TranslationService $translator): int
    {
        $query = Recipe::query();

        if (!$this->option('force')) {
            $query->whereNull('title_en')->orWhereNull('description_en');
        }

        $recipes = $query->get();

        if ($recipes->isEmpty()) {
            $this->info('✅ All recipes already translated.');
            return 0;
        }

        $this->info("Translating {$recipes->count()} recipes...");
        $bar = $this->output->createProgressBar($recipes->count());
        $bar->start();

        $count = 0;
        $force = $this->option('force');
        foreach ($recipes as $recipe) {
            $update = [];

            if ($force || !$recipe->title_en) {
                $translated = $translator->translateToEnglish($recipe->title);
                if ($translated) {
                    $update['title_en'] = $translated;
                }
            }

            if ($force || !$recipe->description_en) {
                $translated = $translator->translateToEnglish($recipe->description);
                if ($translated) {
                    $update['description_en'] = $translated;
                }
            }

            if ($force || !$recipe->steps_en) {
                $steps = $recipe->steps;
                if (!empty($steps)) {
                    $translated = $translator->translateSteps($steps);
                    if (!empty($translated)) {
                        $update['steps_en'] = $translated;
                    }
                }
            }

            if (!empty($update)) {
                $recipe->update($update);
                $count++;
            }

            $bar->advance();
            usleep(500000);
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Translated {$count} recipes!");

        return 0;
    }
}
