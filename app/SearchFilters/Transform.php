<?php

namespace App\SearchFilters;

class Transform
{
    public function handle($value, $field, $searchable)
    {
        $template = $searchable->content_template;

        // TODO: Add support for other templates, for now just handle like text
        if ($template == 'custom') {
            return $this->handleTextTemplate($searchable);
        }

        if ($template == 'text') {
            return $this->handleTextTemplate($searchable);
        }

        $content = $searchable->content ?? $value;

        return $this->prependTitle($searchable, $content);
    }

    private function handleTextTemplate($searchable)
    {
        $fullText = '';
        $pageBuilder = $searchable->sections ?? [];

        foreach ($pageBuilder as $section) {
            if ($section['type'] == 'text_mixed_content') {
                $fullText .= $this->extractTextContent($section);
            }
        }

        return $this->prependTitle($searchable, trim($fullText));
    }

    private function extractTextContent($section)
    {
        $content = '';

        // Extract headline
        if (! empty($section['headline'])) {
            $content .= $section['headline'][0]['text'] ?? '';
        }

        // Extract main content
        if (! empty($section['content'])) {
            $content .= ' '.(new \App\Actions\FlattenBard)($section['content']);
        }

        // Extract side content
        if (! empty($section['side_content'])) {
            foreach ($section['side_content'] as $sideItem) {
                $content .= ' '.($sideItem['title'] ?? '');
                $content .= ' '.($sideItem['text_content'] ?? '');
            }
        }

        return $content;
    }

    private function prependTitle($searchable, $content)
    {
        $title = $searchable->title ?? '';

        return $title ? "$title\n\n$content" : $content;
    }
}
