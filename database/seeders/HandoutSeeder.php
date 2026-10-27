<?php

namespace Database\Seeders;

use App\Models\Handout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Starter handouts for the patient corner, on the topics the centre's old site covered
 * (blood pressure, diabetes and carbohydrates, arthritis, osteoporosis, vaccines). The
 * original PDFs it linked to have gone, so these point to current public-health pages
 * (US NIH, MedlinePlus and PAHO), all checked live in October 2026. Runs only on an empty
 * table, so it never overwrites what staff have edited.
 */
class HandoutSeeder extends Seeder
{
    public const array HANDOUTS = [
        ['heart', 'High blood pressure', 'What blood pressure numbers mean, why high blood pressure matters, and how to bring it down.', 'National Heart, Lung, and Blood Institute (NIH)', 'https://www.nhlbi.nih.gov/health/high-blood-pressure'],
        ['heart', 'Heart-healthy living', 'Everyday steps for a healthier heart: food, activity, weight, sleep and not smoking.', 'National Heart, Lung, and Blood Institute (NIH)', 'https://www.nhlbi.nih.gov/health/heart-healthy-living'],
        ['heart', 'Blood pressure: your guide', 'Plain-language information about high blood pressure, with links to tests and treatment.', 'MedlinePlus (US National Library of Medicine)', 'https://medlineplus.gov/highbloodpressure.html'],
        ['diabetes', 'What is diabetes?', 'Type 1, type 2 and gestational diabetes explained, with the symptoms to watch for.', 'National Institute of Diabetes and Digestive and Kidney Diseases (NIH)', 'https://www.niddk.nih.gov/health-information/diabetes/overview/what-is-diabetes'],
        ['diabetes', 'Healthy living with diabetes', 'Eating, physical activity and weight when you have diabetes.', 'National Institute of Diabetes and Digestive and Kidney Diseases (NIH)', 'https://www.niddk.nih.gov/health-information/diabetes/overview/healthy-living-with-diabetes'],
        ['diabetes', 'Carbohydrates', 'Sugars, starches and fibre: which foods carry carbohydrate and how it affects blood sugar.', 'MedlinePlus (US National Library of Medicine)', 'https://medlineplus.gov/carbohydrates.html'],
        ['bones', 'Osteoporosis', 'Who is at risk, how bone density is measured, and how to protect your bones.', 'National Institute of Arthritis and Musculoskeletal and Skin Diseases (NIH)', 'https://www.niams.nih.gov/health-topics/osteoporosis'],
        ['bones', 'Arthritis', 'The common kinds of arthritis, their symptoms, and how they are treated.', 'National Institute of Arthritis and Musculoskeletal and Skin Diseases (NIH)', 'https://www.niams.nih.gov/health-topics/arthritis'],
        ['vaccines', 'Childhood vaccines', 'Why children are vaccinated, which vaccines they need, and what to expect.', 'MedlinePlus (US National Library of Medicine)', 'https://medlineplus.gov/childhoodvaccines.html'],
        ['vaccines', 'Immunization in the Americas', 'How vaccination protects families across the region.', 'Pan American Health Organization', 'https://www.paho.org/en/topics/immunization'],
        ['general', 'Sleep disorders', 'Insomnia, sleep apnoea and other sleep problems, and when a sleep study helps.', 'MedlinePlus (US National Library of Medicine)', 'https://medlineplus.gov/sleepdisorders.html'],
    ];

    public function run(): void
    {
        if (Handout::query()->exists()) {
            return;
        }
        foreach (self::HANDOUTS as $i => [$category, $title, $summary, $publisher, $url]) {
            Handout::create([
                'slug' => Str::slug($title),
                'title' => $title,
                'category' => $category,
                'summary' => $summary,
                'publisher' => $publisher,
                'url' => $url,
                'published' => true,
                'sort' => ($i + 1) * 10,
            ]);
        }
    }
}
