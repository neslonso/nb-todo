<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_completed = fake()->boolean();
        $completed_at = $is_completed ? now() : null;

        return [
            'user_id' => User::all()->random()->id,
            'title' => fake()->sentence(3),
            // 'description' => fake()->paragraph(13),
            'description' => str_replace(['<html>', '<body>', '</body>', '</html>'], '',
                $this->removeHtmlTagsAndContent(
                    fake()->randomHtml(6, 6),
                    ['head', 'script', 'style', 'form']
                ),
            ),
            'is_completed' => $is_completed,
            'completed_at' => $completed_at,
        ];
    }

    public function removeHtmlTagsAndContent($html, $tags)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);

        foreach ($tags as $tag) {
            while ($node = $xpath->query("//{$tag}")->item(0)) {
                $node->parentNode->removeChild($node);
            }
        }

        return $dom->saveHTML();
    }
}
