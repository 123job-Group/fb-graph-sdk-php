<?php


namespace Nggiahao\Facebook\Models\Caster;


use Illuminate\Support\Collection;
use Nggiahao\Facebook\Models\Attachment;

class AttachmentCaster implements CastsAttributes
{

    public function get($value)
    {
        if (isset($value['data'][0]['subattachments'])) {
            $attachments = $value['data'][0]['subattachments']['data'];
        } elseif (isset($value['data'])) {
            $attachments = $value['data'];
        } elseif ($value) {
            return new Attachment([
                'id' => $value['target']['id'] ?? null,
                'type' => $value['type'] ?? null,
                'url' => $value['target']['url'] ?? null,
                'src' => $value['media']['image']['src'] ?? null
            ]);
        } else {
            return null;
        }

        $attachments = array_map(function ($attachment) {
            return new Attachment([
                'id' => $attachment['target']['id'] ?? null,
                'type' => $attachment['type'] ?? null,
                'url' => $attachment['target']['url'] ?? null,
                'src' => $attachment['media']['image']['src'] ?? null
            ]);
        }, $attachments);
        return new Collection($attachments);
    }

    public function set($value)
    {
        return $value;
    }
}